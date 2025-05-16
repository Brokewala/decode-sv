<?php

namespace App\Livewire;

use App\Models\Document;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class DocumentShow extends Component
{
    public $document;
    public $ratings;
    public $averageRating;
    public $userRating = 5;
    public $userComment = '';
    
    public function mount(Document $document)
    {
        // Vérifier si le document est validé ou si l'utilisateur est le propriétaire
        if (!$document->is_verified && (!Auth::check() || Auth::id() !== $document->user_id)) {
            abort(404);
        }
        
        $this->document = $document;
        $this->loadRatings();
    }
    
    private function loadRatings()
    {
        $this->ratings = $this->document->ratings()->with('user')->latest()->limit(5)->get();
        $this->averageRating = $this->document->getAverageRatingAttribute();
        
        // Si l'utilisateur connecté a déjà noté ce document, charger sa notation
        if (Auth::check()) {
            $userRating = Rating::where('user_id', Auth::id())
                             ->where('document_id', $this->document->id)
                             ->first();
                             
            if ($userRating) {
                $this->userRating = $userRating->rating;
                $this->userComment = $userRating->comment;
            }
        }
    }
    
    public function download()
    {
        // Vérifier si le document est validé
        if (!$this->document->is_verified) {
            session()->flash('error', 'Ce document n\'est pas disponible au téléchargement.');
            return;
        }
        
        $user = Auth::user();
        
        // Vérifier si l'utilisateur est connecté
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Vérifier si l'utilisateur a déjà téléchargé ce document
        if ($user->downloadedDocuments()->where('document_id', $this->document->id)->exists()) {
            return redirect()->to(Storage::disk('private')->url($this->document->file_path));
        }
        
        // Vérifier si l'utilisateur a assez de points
        if ($user->points < $this->document->price) {
            session()->flash('error', 'Vous n\'avez pas assez de points pour télécharger ce document.');
            return;
        }
        
        // Déduire les points
        $user->points -= $this->document->price;
        $user->save();
        
        // Enregistrer le téléchargement
        $user->downloadedDocuments()->attach($this->document->id, ['downloaded_at' => now()]);
        
        // Incrémenter le compteur de téléchargements
        $this->document->increment('downloads');
        
        // Recharger le document pour mettre à jour les statistiques
        $this->document = Document::find($this->document->id);
        
        // Télécharger le fichier
        session()->flash('success', 'Document téléchargé avec succès ! ' . $this->document->price . ' points ont été déduits de votre compte.');
        return redirect()->to(Storage::disk('private')->url($this->document->file_path));
    }
    
    public function rateDocument()
    {
        $this->validate([
            'userRating' => 'required|integer|between:1,5',
            'userComment' => 'nullable|string|max:500',
        ]);
        
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Vérifier si l'utilisateur a téléchargé le document
        if (!Auth::user()->downloadedDocuments()->where('document_id', $this->document->id)->exists()) {
            session()->flash('error', 'Vous devez télécharger le document avant de pouvoir le noter.');
            return;
        }
        
        // Vérifier si l'utilisateur a déjà noté ce document
        $existingRating = Rating::where('user_id', Auth::id())
                              ->where('document_id', $this->document->id)
                              ->first();
                              
        if ($existingRating) {
            $existingRating->rating = $this->userRating;
            $existingRating->comment = $this->userComment;
            $existingRating->save();
            $message = 'Votre évaluation a été mise à jour avec succès.';
        } else {
            Rating::create([
                'user_id' => Auth::id(),
                'document_id' => $this->document->id,
                'rating' => $this->userRating,
                'comment' => $this->userComment,
            ]);
            $message = 'Merci pour votre évaluation !';
        }
        
        session()->flash('success', $message);
        
        // Recharger les notations
        $this->loadRatings();
    }
    
    public function render()
    {
        return view('livewire.document-show');
    }
}