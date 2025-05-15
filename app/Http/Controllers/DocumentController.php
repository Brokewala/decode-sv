<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

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
        $request->validate([
            'title' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240', // 10MB max
            'description' => 'nullable|string',
            'terms' => 'required|accepted',
        ]);

        // Déterminer le format et le prix
        $format = $request->file('file')->getClientOriginalExtension();
        $price = in_array(strtolower($format), ['doc', 'docx', 'xls', 'xlsx']) ? 2 : 1;

        // Sauvegarder le fichier
        $filePath = $request->file('file')->store('documents/original', 'private');

        // Créer une prévisualisation
        $previewPath = $this->createPreview($request->file('file'), $format);

        // Créer le document
        $document = new Document([
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

        $document->save();

        return redirect()->route('documents.my')->with('success', 'Votre document a été soumis avec succès et est en attente de validation.');
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
            // Pour les PDF, créer une image de prévisualisation de la première page
            if (strtolower($format) === 'pdf') {
                // Utiliser \Intervention\Image\ImageManager qui est l'API 2.x
                $manager = new \Intervention\Image\ImageManager(['driver' => 'gd']);
                $image = $manager->make($file->path());
                $image->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                
                $previewPath = 'documents/previews/' . uniqid() . '.jpg';
                Storage::disk('public')->put($previewPath, (string) $image->encode('jpg'));
            }
            // Pour les autres formats, utiliser une image générique
            else {
                // Vérifier si l'image générique existe
                $genericPath = 'documents/previews/generic-' . strtolower($format) . '.jpg';
                if (Storage::disk('public')->exists($genericPath)) {
                    $previewPath = $genericPath;
                } else {
                    // Utiliser une image générique par défaut
                    $previewPath = 'documents/previews/generic.jpg';
                }
            }
        } catch (\Exception $e) {
            // En cas d'erreur, utiliser une image générique
            \Log::error('Erreur lors de la création de la prévisualisation: ' . $e->getMessage());
            $previewPath = 'documents/previews/generic.jpg';
        }
        
        return $previewPath;
    }
}
