<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Livewire\Component;
use App\Models\VehicleBrand;
use Livewire\WithPagination;
use App\Models\VehicleCategory;
use Illuminate\Support\Collection;

class VehicleSearch extends Component
{
    use WithPagination;

    public string $vehicle_search = '';
    public ?int $selectedCategory = null;
    public ?int $selectedBrand = null;
    public Collection $categories;
    public Collection $brands;

    /**
     * Keep selected filters in the query string so links are sharable.
     */
    protected $queryString = [
        'vehicle_search' => ['except' => ''],
        'selectedBrand' => ['except' => null],
        'selectedCategory' => ['except' => null],
    ];

    public function search()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->categories = VehicleCategory::all();
        $this->brands = VehicleBrand::all();

        // If a brand is pre-selected from the query string, make sure
        // categories are filtered accordingly on initial load.
        if (! empty($this->selectedBrand)) {
            $this->updateCategories($this->selectedBrand);
        }
    }

    /**
     * Reset pagination when the search term changes.
     */
    public function updatingVehicleSearch(): void
    {
        $this->resetPage();
    }

    /**
     * When brand changes, update available categories based on the new brand
     * value and reset pagination.
     */
    public function updatingSelectedBrand($value): void
    {
        $this->resetPage();
        $this->updateCategories($value);
    }

    public function render()
    {
        $vehicles = Vehicle::query()
            ->orderBy('order', 'asc')
            ->when($this->vehicle_search, function ($q) {
                $q->where('name', 'like', '%' . $this->vehicle_search . '%');
            })
            ->when($this->selectedBrand, function ($q) {
                $q->where('vehicle_brand_id', $this->selectedBrand);
            })
            ->when($this->selectedCategory, function ($q) {
                $q->where('vehicle_category_id', $this->selectedCategory);
            });

        return view('livewire.vehicle-search', [
            'vehicles' => $vehicles->paginate(12),
        ]);
    }

    public function updateCategories($brandId)
    {
        if (empty($brandId)) {
            $this->categories = VehicleCategory::all();
            $this->selectedCategory = null;
            return;
        }

        $this->categories = VehicleCategory::whereHas('vehicles', function ($query) use ($brandId) {
            $query->where('vehicle_brand_id', $brandId);
        })->get();

        $this->selectedCategory = null;
    }
}
