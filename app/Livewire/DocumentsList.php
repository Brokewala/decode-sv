<?php

namespace App\Livewire;

use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DocumentsList extends Component
{
    use WithPagination;
    
    public $search = '';
    public $country = '';
    public $format = '';
    public $sort = 'newest';
    public $viewMode = 'grid';
    
    protected $queryString = [
        'search' => ['except' => ''],
        'country' => ['except' => ''],
        'format' => ['except' => ''],
        'sort' => ['except' => 'newest'],
        'page' => ['except' => 1],
    ];
    
    public function mount()
    {
        // Charger la préférence d'affichage depuis localStorage via Alpine
        // Ceci sera géré côté frontend
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingCountry()
    {
        $this->resetPage();
    }
    
    public function updatingFormat()
    {
        $this->resetPage();
    }
    
    public function updatingSort()
    {
        $this->resetPage();
    }
    
    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }
    
    public function resetFilters()
    {
        $this->search = '';
        $this->country = '';
        $this->format = '';
        $this->sort = 'newest';
        $this->resetPage();
    }
    
    public function render()
    {
        $query = Document::where('is_verified', true);

        // Filtrer par recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('country', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%");
            });
        }

        // Filtrer par pays
        if ($this->country) {
            $query->where('country', $this->country);
        }

        // Filtrer par format
        if ($this->format) {
            if ($this->format === 'pdf') {
                $query->where('format', 'pdf');
            } elseif ($this->format === 'doc') {
                $query->whereIn('format', ['doc', 'docx']);
            } elseif ($this->format === 'xls') {
                $query->whereIn('format', ['xls', 'xlsx']);
            }
        }

        // Tri
        switch ($this->sort) {
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
        
        return view('livewire.documents-list', [
            'documents' => $documents,
            'userPoints' => Auth::check() ? Auth::user()->points : 0
        ]);
    }
}