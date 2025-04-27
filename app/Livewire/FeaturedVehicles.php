<?php

namespace App\Livewire;

use Livewire\Component;

class FeaturedVehicles extends Component
{
    public $featuredVehicles;
    public $selectedBrand;
    public $selectedCategory;

    protected $listeners = [
        'refreshFeaturedVehicles' => '$refresh',
    ];

    public function filterByBrand($brandId)
    {
        $this->selectedBrand = $brandId;
        // refresh the featured vehicles list
        $this->featuredVehicles = \App\Models\Vehicle::featured()
            ->when($this->selectedBrand, function ($query) {
                $query->where('vehicle_brand_id', $this->selectedBrand);
            })
            ->when($this->selectedCategory, function ($query) {
                $query->where('vehicle_category_id', $this->selectedCategory);
            })
            ->get();
            $this->dispatch('refreshFeaturedVehicles');
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
    }

    public function render()
    {
        // Fetch featured vehicles from the database
        $this->featuredVehicles = \App\Models\Vehicle::featured()
            ->when($this->selectedBrand, function ($query) {
                $query->where('vehicle_brand_id', $this->selectedBrand);
            })
            ->when($this->selectedCategory, function ($query) {
                $query->where('vehicle_category_id', $this->selectedCategory);
            })
            ->get();
        $brands = \App\Models\VehicleBrand::all();
        $categories = \App\Models\VehicleCategory::all();
        return view('livewire.featured-vehicles', [
            'featuredVehicles' => $this->featuredVehicles,
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }
}
