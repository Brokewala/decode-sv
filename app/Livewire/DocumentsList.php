<?php

namespace App\Livewire;

use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        try {
            // Utiliser le cache pour éviter les requêtes répétées
            $cacheKey = 'documents_filter_data';
            $cacheTime = 300; // 5 minutes

            $filterData = cache()->remember($cacheKey, $cacheTime, function () {
                // Optimiser avec une seule requête
                $documents = Document::where('is_verified', true)
                    ->select('country', 'format')
                    ->get();

                return [
                    'countries' => $documents->pluck('country')->unique()->sort()->values()->toArray(),
                    'formats' => $documents->pluck('format')->unique()->sort()->values()->toArray(),
                    'total' => $documents->count()
                ];
            });

            $this->availableCountries = $filterData['countries'];
            $this->availableFormats = $filterData['formats'];
            $this->totalDocuments = $filterData['total'];

        } catch (\Exception $e) {
            Log::error('Erreur lors du chargement des données de filtre: ' . $e->getMessage());

            // Valeurs par défaut en cas d'erreur
            $this->availableCountries = ['France', 'International'];
            $this->availableFormats = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
            $this->totalDocuments = 0;
        }
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
     * Version optimisée du comptage avec cache
     */
    public function getFilteredCountOptimized()
    {
        try {
            // Créer une clé de cache basée sur les filtres actuels
            $cacheKey = 'filtered_count_' . md5(serialize([
                'search' => $this->search,
                'country' => $this->country,
                'format' => $this->format,
                'priceMin' => $this->priceMin,
                'priceMax' => $this->priceMax,
                'dateFrom' => $this->dateFrom,
                'dateTo' => $this->dateTo,
            ]));

            // Cache pour 60 secondes seulement
            return cache()->remember($cacheKey, 60, function () {
                return $this->buildQuery()->count();
            });

        } catch (\Exception $e) {
            Log::warning('Erreur lors du comptage optimisé: ' . $e->getMessage());
            return 0;
        }
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
        try {
            // Augmenter temporairement la limite de temps pour les requêtes complexes
            $originalTimeLimit = ini_get('max_execution_time');
            set_time_limit(config('timeout.livewire_operation', 60));

            $query = $this->buildQuery();

            // Tri optimisé
            switch ($this->sort) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'rating':
                    // Optimiser la requête de rating pour éviter les timeouts
                    if (DB::getDriverName() === 'sqlite') {
                        // Pour SQLite, utiliser une approche plus simple
                        $query->orderBy('downloads', 'desc'); // Fallback sur downloads
                    } else {
                        $query->leftJoin('ratings', 'documents.id', '=', 'ratings.document_id')
                              ->select('documents.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as average_rating'))
                              ->groupBy('documents.id')
                              ->orderBy('average_rating', 'desc');
                    }
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

            // Limiter le nombre d'éléments par page pour éviter les timeouts
            $perPage = min(12, request()->get('per_page', 12));
            $documents = $query->paginate($perPage);

            // Calculer les statistiques de manière optimisée
            $filteredCount = $this->getFilteredCountOptimized();

            // Restaurer la limite de temps
            set_time_limit($originalTimeLimit);

            return view('livewire.documents-list', [
                'documents' => $documents,
                'userPoints' => Auth::check() ? Auth::user()->points : 0,
                'filteredCount' => $filteredCount,
                'availableCountries' => $this->availableCountries,
                'availableFormats' => $this->availableFormats,
                'totalDocuments' => $this->totalDocuments,
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur dans DocumentsList render: ' . $e->getMessage());

            // En cas d'erreur, retourner une vue avec des données minimales
            return view('livewire.documents-list', [
                'documents' => collect()->paginate(12),
                'userPoints' => 0,
                'filteredCount' => 0,
                'availableCountries' => $this->availableCountries,
                'availableFormats' => $this->availableFormats,
                'totalDocuments' => $this->totalDocuments,
            ]);
        }
    }
}