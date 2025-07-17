<?php

namespace App\Livewire;

use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleCategory;
use Livewire\Component;
use Livewire\WithPagination;

class VehicleSearch extends Component
{
    use WithPagination;

    public $vehicle_search = '';
    public $selectedCategory = null;
    public $selectedBrand = null;
    public $categories = [];
    public $brands = [];

    public function search()
    {
        // Reset pagination when searching
        $this->resetPage();
    }

    public function mount()
    {
        $this->categories = VehicleCategory::all();
        $this->brands = VehicleBrand::all();
    }

    public function updatedSelectedBrand($value)
    {
        $this->updateCategories($value);
    }

    public function render()
    {
        $query = Vehicle::query();
        $query->orderBy('order', 'asc');

        if (!empty($this->vehicle_search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->vehicle_search . '%');
            });
        }

        if (!empty($this->selectedBrand)) {
            $query->where('vehicle_brand_id', $this->selectedBrand);
        }

        if (!empty($this->selectedCategory)) {
            $query->where('vehicle_category_id', $this->selectedCategory);
        }

        return view('livewire.vehicle-search', [
            'vehicles' => $query->paginate(12),
        ]);
    }

    public function updateCategories($brandId)
    {
        $this->categories = VehicleCategory::whereHas('vehicles', function ($query) use ($brandId) {
            $query->where('vehicle_brand_id', $brandId);
        })->get();
        $this->selectedCategory = null;
    }
}
