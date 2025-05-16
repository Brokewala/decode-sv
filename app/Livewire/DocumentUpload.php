<?php

namespace App\Livewire;

use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager;

class DocumentUpload extends Component
{
    use WithFileUploads;
    
    public $title;
    public $country;
    public $description;
    public $file;
    public $terms = false;
    
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
    
    public function upload()
    {
        $this->validate();
        
        // Déterminer le format et le prix
        $format = $this->file->getClientOriginalExtension();
        $price = in_array(strtolower($format), ['doc', 'docx', 'xls', 'xlsx']) ? 2 : 1;
        
        // Sauvegarder le fichier
        $filePath = $this->file->store('documents/original', 'private');
        
        // Créer une prévisualisation
        $previewPath = $this->createPreview($this->file, $format);
        
        // Créer le document
        $document = new Document([
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
        
        $document->save();
        
        session()->flash('success', 'Votre document a été soumis avec succès et est en attente de validation.');
        
        return redirect()->route('documents.my');
    }
    
    private function createPreview($file, $format)
    {
        $previewPath = null;
        
        try {
            // Pour les PDF, créer une image de prévisualisation de la première page
            if (strtolower($format) === 'pdf') {
                // Utiliser Intervention\Image v3
                $manager = new \Intervention\Image\ImageManager(
                    new \Intervention\Image\Drivers\Gd\Driver()
                );
                $image = $manager->read($file->path());
                $image = $image->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                
                $previewPath = 'documents/previews/' . uniqid() . '.jpg';
                Storage::disk('public')->put($previewPath, (string) $image->encodeByExtension('jpg'));
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
    
    public function render()
    {
        return view('livewire.document-upload');
    }
}