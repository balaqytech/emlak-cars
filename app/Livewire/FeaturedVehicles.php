<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\VehicleBrand;
use App\Models\VehicleCategory;

class FeaturedVehicles extends Component
{
    public $categories;
    public $featuredVehicles;
    public $selectedBrand;
    public $selectedCategory;

    protected $listeners = [
        'refreshFeaturedVehicles' => '$refresh',
    ];

    public function mount()
    {
        $this->selectedBrand = VehicleBrand::first()?->id ?? null;
        $this->selectedCategory = null;

        // Fetch initial featured vehicles
        $this->featuredVehicles = \App\Models\Vehicle::featured()
            ->when($this->selectedBrand, function ($query) {
                $query->where('vehicle_brand_id', $this->selectedBrand);
            })
            ->get();

        // Fetch all brands and categories
        $this->categories = VehicleCategory::all();
    }

    public function filterByBrand($brandId)
    {
        $this->selectedBrand = $brandId;
        $this->selectedCategory = null; // Reset category filter when brand changes
        // refresh the featured vehicles list
        $this->featuredVehicles = \App\Models\Vehicle::featured()
            ->when($this->selectedBrand, function ($query) {
                $query->where('vehicle_brand_id', $this->selectedBrand);
            })
            ->when($this->selectedCategory, function ($query) {
                $query->where('vehicle_category_id', $this->selectedCategory);
            })
            ->get();
        // Update categories to only non-empty ones for the selected brand
        $this->categories = \App\Models\VehicleCategory::whereHas('vehicles', function ($query) {
            $query->featured();
            if ($this->selectedBrand) {
                $query->where('vehicle_brand_id', $this->selectedBrand);
            }
        })->get();

        $this->dispatch('swiperReinit');
    }

    public function filterByCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        // refresh the featured vehicles list
        $this->featuredVehicles = \App\Models\Vehicle::featured()
            ->when($this->selectedBrand, function ($query) {
                $query->where('vehicle_brand_id', $this->selectedBrand);
            })
            ->when($this->selectedCategory, function ($query) {
                $query->where('vehicle_category_id', $this->selectedCategory);
            })
            ->get();

        $this->dispatch('swiperReinit');
    }

    public function render()
    {
        return view('livewire.featured-vehicles', [
            'featuredVehicles' => $this->featuredVehicles,
            'brands' => VehicleBrand::all(),
        ]);
    }
}
