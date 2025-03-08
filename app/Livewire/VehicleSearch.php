<?php

namespace App\Livewire;

use App\Models\Vehicle;
use App\Models\VehicleCategory;
use Livewire\Component;
use Livewire\WithPagination;

class VehicleSearch extends Component
{
    use WithPagination;

    public $selectedCategory = null;

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
    }

    public function render()
    {
        $vehicles = Vehicle::when($this->selectedCategory, function ($query) {
            $query->where('vehicle_category_id', $this->selectedCategory);
        })->latest()->paginate(12);

        return view('livewire.vehicle-search', [
            'vehicles' => $vehicles,
            'categories' => VehicleCategory::all(),
        ]);
    }
}
