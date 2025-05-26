<?php

namespace App\Livewire;

use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class DocumentUpload extends Component
{
    use WithFileUploads;

    public $title;
    public $country;
    public $description;
    public $file;
    public $terms = false;
    public $uploadInProgress = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'country' => 'required|string|max:100',
        'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240', // 10MB max
        'description' => 'nullable|string',
        'terms' => 'required|accepted',
    ];

    protected $messages = [
        'title.required' => 'Le titre est requis',
        'country.required' => 'Le pays est requis',
        'file.required' => 'Le fichier est requis',
        'file.mimes' => 'Le fichier doit être au format PDF, DOC, DOCX, XLS ou XLSX',
        'file.max' => 'Le fichier ne doit pas dépasser 10 Mo',
        'terms.required' => 'Vous devez accepter les conditions d\'utilisation',
        'terms.accepted' => 'Vous devez accepter les conditions d\'utilisation',
    ];


    public function submit()
    {
        try {
            $this->validate();
            $this->uploadInProgress = true;

            // Vérifications de sécurité supplémentaires
            if (!$this->file) {
                throw new \Exception('Aucun fichier sélectionné.');
            }

            if ($this->file->getSize() > 10485760) { // 10MB
                throw new \Exception('Le fichier ne peut pas dépasser 10MB.');
            }

            // Vérifier le type MIME réel du fichier
            $allowedMimes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ];

            if (!in_array($this->file->getMimeType(), $allowedMimes)) {
                throw new \Exception('Type de fichier non autorisé.');
            }

            // Déterminer le format et le prix
            $format = strtolower($this->file->getClientOriginalExtension());
            $price = in_array($format, ['doc', 'docx', 'xls', 'xlsx']) ? 2 : 1;

            // Utiliser une transaction pour assurer la cohérence
            DB::beginTransaction();

            try {
                // Sauvegarder le fichier avec un nom sécurisé
                $fileName = uniqid() . '_' . time() . '.' . $format;
                $filePath = $this->file->storeAs('documents/original', $fileName, 'private');

                // Créer une prévisualisation
                $previewPath = $this->createPreview($this->file, $format);

                // Créer le document
                $document = Document::create([
                    'user_id' => Auth::id(),
                    'title' => $this->title,
                    'country' => $this->country,
                    'format' => $format,
                    'description' => $this->description,
                    'price' => $price,
                    'file_path' => $filePath,
                    'preview_path' => $previewPath,
                    'is_verified' => false, // À valider par un modérateur
                    'downloads' => 0,
                ]);

                DB::commit();

                // Réinitialiser le formulaire
                $this->reset(['title', 'country', 'description', 'file', 'terms']);

                session()->flash('success', 'Votre document a été soumis avec succès et est en attente de validation.');

                return redirect()->route('documents.my');

            } catch (\Exception $e) {
                DB::rollback();

                // Supprimer le fichier si il a été uploadé
                if (isset($filePath) && Storage::disk('private')->exists($filePath)) {
                    Storage::disk('private')->delete($filePath);
                }

                throw $e;
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Les erreurs de validation sont automatiquement gérées par Livewire
            throw $e;
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'upload du document: ' . $e->getMessage());
            $this->addError('file', $e->getMessage());
        } finally {
            $this->uploadInProgress = false;
        }
    }

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
                        Log::warning('Erreur Imagick pour PDF: ' . $e->getMessage());
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
            Log::error('Erreur lors de la création de la prévisualisation: ' . $e->getMessage());
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
            Log::error('Erreur lors de la création de l\'image générique: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.document-upload');
    }
}
