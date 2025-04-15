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

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $vehicles = Vehicle::query()
            ->when($this->vehicle_search, function ($query) {
                $query->where('name', 'like', '%' . $this->vehicle_search . '%');
            })
            ->when($this->selectedCategory, function ($query) {
                $query->where('vehicle_category_id', $this->selectedCategory);
            })
            ->when($this->selectedBrand, function ($query) {
                $query->where('vehicle_brand_id', $this->selectedBrand);
            })
            ->orderBy('order', 'asc')
            ->paginate(12);

        return view('livewire.vehicle-search', [
            'vehicles' => $vehicles,
            'categories' => VehicleCategory::all(),
            'brands' => VehicleBrand::all(),
        ]);
    }
}
