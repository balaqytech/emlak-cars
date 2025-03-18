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
    public $queryType = 'paginate'; // Default query type

    public function mount($queryType = 'paginate')
    {
        $this->queryType = $queryType;
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
    }

    public function render()
    {
        $vehicles = Vehicle::when($this->selectedCategory, function ($query) {
            $query->where('vehicle_category_id', $this->selectedCategory);
        })
            ->orderBy('published_at', 'desc');

        if ($this->queryType === 'paginate') {
            $vehicles = $vehicles->paginate(12);
        } else {
            $vehicles = $vehicles->take(3)->get();
        }

        return view('livewire.vehicle-search', [
            'vehicles' => $vehicles,
            'categories' => VehicleCategory::all(),
        ]);
    }
}
