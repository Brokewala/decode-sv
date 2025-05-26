<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller

{
    /**
     * Display a listing of the documents.
     */
    public function index(Request $request)
    {
        $query = Document::where('is_verified', true);

        // Filtrer par recherche
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtrer par pays
        if ($request->filled('country')) {
            $query->where('country', $request->input('country'));
        }

        // Filtrer par format
        if ($request->filled('format')) {
            $format = $request->input('format');
            if ($format === 'pdf') {
                $query->where('format', 'pdf');
            } elseif ($format === 'doc') {
                $query->whereIn('format', ['doc', 'docx']);
            } elseif ($format === 'xls') {
                $query->whereIn('format', ['xls', 'xlsx']);
            }
        }

        // Tri
        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'rating':
                $query->withCount(['ratings as average_rating' => function($query) {
                    $query->select(\DB::raw('coalesce(avg(rating), 0)'));
                }])->orderBy('average_rating', 'desc');
                break;
            case 'downloads':
                $query->orderBy('downloads', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
        }

        $documents = $query->paginate(12);

        return view('documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new document.
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'country' => 'required|string|max:100',
                'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240', // 10MB max
                'description' => 'nullable|string|max:1000',
                'terms' => 'required|accepted',
            ]);

            // Vérifier la taille du fichier (sécurité supplémentaire)
            if ($request->file('file')->getSize() > 10485760) { // 10MB en bytes
                return back()->withErrors(['file' => 'Le fichier ne peut pas dépasser 10MB.'])->withInput();
            }

            // Déterminer le format et le prix
            $format = strtolower($request->file('file')->getClientOriginalExtension());
            $price = in_array($format, ['doc', 'docx', 'xls', 'xlsx']) ? 2 : 1;

            // Utiliser une transaction pour assurer la cohérence
            DB::beginTransaction();

            try {
                // Sauvegarder le fichier avec un nom sécurisé
                $fileName = uniqid() . '_' . time() . '.' . $format;
                $filePath = $request->file('file')->storeAs('documents/original', $fileName, 'private');

                // Créer une prévisualisation
                $previewPath = $this->createPreview($request->file('file'), $format);

                // Créer le document
                $document = Document::create([
                    'user_id' => Auth::id(),
                    'title' => $request->input('title'),
                    'country' => $request->input('country'),
                    'format' => $format,
                    'description' => $request->input('description'),
                    'price' => $price,
                    'file_path' => $filePath,
                    'preview_path' => $previewPath,
                    'is_verified' => false, // À valider par un modérateur
                    'downloads' => 0,
                ]);

                DB::commit();

                return redirect()->route('documents.my')->with('success', 'Votre document a été soumis avec succès et est en attente de validation.');

            } catch (\Exception $e) {
                DB::rollback();

                // Supprimer le fichier si il a été uploadé
                if (isset($filePath) && Storage::disk('private')->exists($filePath)) {
                    Storage::disk('private')->delete($filePath);
                }

                throw $e;
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'upload du document: ' . $e->getMessage());
            return back()->withErrors(['file' => 'Une erreur est survenue lors de l\'upload. Veuillez réessayer.'])->withInput();
        }
    }

    /**
     * Display the specified document.
     */
    public function show(Document $document)
    {
        // Vérifier si le document est validé ou si l'utilisateur est le propriétaire
        if (!$document->is_verified && (!Auth::check() || Auth::id() !== $document->user_id)) {
            abort(404);
        }

        // Récupérer les avis
        $ratings = $document->ratings()->with('user')->latest()->limit(5)->get();
        $averageRating = $document->getAverageRatingAttribute();

        return view('documents.show', compact('document', 'ratings', 'averageRating'));
    }

    /**
     * Show the user's documents.
     */
    public function userDocuments()
    {
        $uploadedDocuments = Auth::user()->uploadedDocuments()->latest()->get();
        $downloadedDocuments = Auth::user()->downloadedDocuments()->latest()->get();

        return view('documents.my', compact('uploadedDocuments', 'downloadedDocuments'));
    }

    /**
     * Download a document.
     */
    public function download(Document $document)
    {
        // Vérifier si le document est validé
        if (!$document->is_verified) {
            return back()->with('error', 'Ce document n\'est pas disponible au téléchargement.');
        }

        $user = Auth::user();

        // Vérifier si l'utilisateur a déjà téléchargé ce document
        if ($user->downloadedDocuments()->where('document_id', $document->id)->exists()) {
            return Storage::disk('private')->download($document->file_path, $document->title . '.' . $document->format);
        }

        // Vérifier si l'utilisateur a assez de points
        if ($user->points < $document->price) {
            return back()->with('error', 'Vous n\'avez pas assez de points pour télécharger ce document.');
        }

        // Déduire les points
        $user->points -= $document->price;
        $user->save();

        // Enregistrer le téléchargement
        $user->downloadedDocuments()->attach($document->id, ['downloaded_at' => now()]);

        // Incrémenter le compteur de téléchargements
        $document->increment('downloads');

        // Télécharger le fichier
        return Storage::disk('private')->download($document->file_path, $document->title . '.' . $document->format);
    }

    /**
     * Rate a document.
     */
    public function rate(Request $request, Document $document)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Vérifier si l'utilisateur a téléchargé le document
        if (!Auth::user()->downloadedDocuments()->where('document_id', $document->id)->exists()) {
            return back()->with('error', 'Vous devez télécharger le document avant de pouvoir le noter.');
        }

        // Vérifier si l'utilisateur a déjà noté ce document
        $existingRating = Rating::where('user_id', Auth::id())
                              ->where('document_id', $document->id)
                              ->first();

        if ($existingRating) {
            $existingRating->rating = $request->input('rating');
            $existingRating->comment = $request->input('comment');
            $existingRating->save();
            $message = 'Votre évaluation a été mise à jour avec succès.';
        } else {
            Rating::create([
                'user_id' => Auth::id(),
                'document_id' => $document->id,
                'rating' => $request->input('rating'),
                'comment' => $request->input('comment'),
            ]);
            $message = 'Merci pour votre évaluation !';
        }

        return back()->with('success', $message);
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(Document $document)
    {
        // Vérifier si l'utilisateur est le propriétaire
        if (Auth::id() !== $document->user_id) {
            abort(403);
        }

        // Supprimer les fichiers
        if (Storage::disk('private')->exists($document->file_path)) {
            Storage::disk('private')->delete($document->file_path);
        }

        if ($document->preview_path && Storage::disk('public')->exists($document->preview_path)) {
            Storage::disk('public')->delete($document->preview_path);
        }

        $document->delete();

        return redirect()->route('documents.my')->with('success', 'Document supprimé avec succès.');
    }

    /**
     * Create a preview image for the document.
     */
    private function createPreview($file, $format)
    {
        $previewPath = null;

        try {
            // Pour les PDF, essayer de créer une image de prévisualisation
            if (strtolower($format) === 'pdf') {
                // Vérifier si Imagick est disponible pour les PDF
                if (extension_loaded('imagick')) {
                    try {
                        $imagick = new \Imagick();
                        $imagick->readImage($file->path() . '[0]'); // Première page
                        $imagick->setImageFormat('jpeg');
                        $imagick->setImageCompressionQuality(80);
                        $imagick->resizeImage(800, 0, \Imagick::FILTER_LANCZOS, 1);

                        $previewPath = 'documents/previews/' . uniqid() . '.jpg';
                        Storage::disk('public')->put($previewPath, $imagick->getImageBlob());
                        $imagick->clear();
                        $imagick->destroy();
                    } catch (\Exception $e) {
                        \Log::warning('Erreur Imagick pour PDF: ' . $e->getMessage());
                        $previewPath = $this->getGenericPreview($format);
                    }
                } else {
                    // Imagick non disponible, utiliser une image générique
                    $previewPath = $this->getGenericPreview($format);
                }
            }
            // Pour les autres formats, utiliser une image générique
            else {
                $previewPath = $this->getGenericPreview($format);
            }
        } catch (\Exception $e) {
            // En cas d'erreur, utiliser une image générique
            \Log::error('Erreur lors de la création de la prévisualisation: ' . $e->getMessage());
            $previewPath = $this->getGenericPreview($format);
        }

        return $previewPath;
    }

    /**
     * Get generic preview image for a file format.
     */
    private function getGenericPreview($format)
    {
        // Créer le répertoire de previews s'il n'existe pas
        if (!Storage::disk('public')->exists('documents/previews')) {
            Storage::disk('public')->makeDirectory('documents/previews');
        }

        // Vérifier si l'image générique spécifique existe
        $genericPath = 'documents/previews/generic-' . strtolower($format) . '.jpg';
        if (Storage::disk('public')->exists($genericPath)) {
            return $genericPath;
        }

        // Créer une image générique simple si elle n'existe pas
        $defaultPath = 'documents/previews/generic-' . strtolower($format) . '.jpg';
        $this->createGenericImage($format, $defaultPath);

        return $defaultPath;
    }

    /**
     * Create a simple generic preview image.
     */
    private function createGenericImage($format, $path)
    {
        try {
            // Créer une image simple avec GD
            $width = 400;
            $height = 300;
            $image = imagecreate($width, $height);

            // Couleurs
            $backgroundColor = imagecolorallocate($image, 240, 240, 240);
            $textColor = imagecolorallocate($image, 100, 100, 100);
            $borderColor = imagecolorallocate($image, 200, 200, 200);

            // Fond
            imagefill($image, 0, 0, $backgroundColor);

            // Bordure
            imagerectangle($image, 0, 0, $width-1, $height-1, $borderColor);

            // Texte
            $text = strtoupper($format);
            $fontSize = 5;
            $textWidth = imagefontwidth($fontSize) * strlen($text);
            $textHeight = imagefontheight($fontSize);
            $x = ($width - $textWidth) / 2;
            $y = ($height - $textHeight) / 2;

            imagestring($image, $fontSize, $x, $y, $text, $textColor);

            // Sauvegarder
            ob_start();
            imagejpeg($image, null, 80);
            $imageData = ob_get_contents();
            ob_end_clean();

            Storage::disk('public')->put($path, $imageData);

            imagedestroy($image);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création de l\'image générique: ' . $e->getMessage());
        }
    }
}
