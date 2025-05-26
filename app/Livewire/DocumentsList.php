<?php

namespace App\Livewire;

use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public $priceMin = '';
    public $priceMax = '';
    public $dateFrom = '';
    public $dateTo = '';

    // Propriétés pour les statistiques
    public $totalDocuments = 0;
    public $availableCountries = [];
    public $availableFormats = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'country' => ['except' => ''],
        'format' => ['except' => ''],
        'sort' => ['except' => 'newest'],
        'priceMin' => ['except' => ''],
        'priceMax' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        // Charger les données pour les filtres
        $this->loadFilterData();
    }

    /**
     * Charger les données pour les filtres (pays et formats disponibles)
     */
    private function loadFilterData()
    {
        // Récupérer les pays disponibles
        $this->availableCountries = Document::where('is_verified', true)
            ->select('country')
            ->distinct()
            ->orderBy('country')
            ->pluck('country')
            ->toArray();

        // Récupérer les formats disponibles
        $this->availableFormats = Document::where('is_verified', true)
            ->select('format')
            ->distinct()
            ->orderBy('format')
            ->pluck('format')
            ->toArray();

        // Compter le total des documents
        $this->totalDocuments = Document::where('is_verified', true)->count();
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

    public function updatingPriceMin()
    {
        $this->resetPage();
    }

    public function updatingPriceMax()
    {
        $this->resetPage();
    }

    public function updatingDateFrom()
    {
        $this->resetPage();
    }

    public function updatingDateTo()
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
        $this->priceMin = '';
        $this->priceMax = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    /**
     * Obtenir le nombre de documents correspondant aux filtres actuels
     */
    public function getFilteredCount()
    {
        return $this->buildQuery()->count();
    }

    /**
     * Construire la requête avec tous les filtres
     */
    private function buildQuery()
    {
        $query = Document::where('is_verified', true);

        // Filtrer par recherche
        if ($this->search) {
            $searchTerm = trim($this->search);
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('country', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
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

        // Filtrer par prix
        if ($this->priceMin !== '' && is_numeric($this->priceMin)) {
            $query->where('price', '>=', (float) $this->priceMin);
        }

        if ($this->priceMax !== '' && is_numeric($this->priceMax)) {
            $query->where('price', '<=', (float) $this->priceMax);
        }

        // Filtrer par date
        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        return $query;
    }

    public function render()
    {
        $query = $this->buildQuery();

        // Tri
        switch ($this->sort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'rating':
                // Utiliser une sous-requête pour calculer la moyenne des notes
                $query->leftJoin('ratings', 'documents.id', '=', 'ratings.document_id')
                      ->select('documents.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'))
                      ->groupBy('documents.id')
                      ->orderBy('average_rating', 'desc');
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
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
        }

        $documents = $query->paginate(12);

        // Calculer les statistiques pour l'affichage
        $filteredCount = $this->getFilteredCount();

        return view('livewire.documents-list', [
            'documents' => $documents,
            'userPoints' => Auth::check() ? Auth::user()->points : 0,
            'filteredCount' => $filteredCount,
            'availableCountries' => $this->availableCountries,
            'availableFormats' => $this->availableFormats,
            'totalDocuments' => $this->totalDocuments,
        ]);
    }
}