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
        $this->refreshFeaturedVehiclesList();
        $this->refreshCategories();
    }

    public function filterByBrand($brandId)
    {
        $this->selectedBrand = $brandId;
        $this->selectedCategory = null; // Reset category filter when brand changes
        $this->refreshFeaturedVehiclesList();
        $this->refreshCategories();
        $this->dispatch('swiperReinit');
    }

    public function filterByCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->refreshFeaturedVehiclesList();
        $this->dispatch('swiperReinit');
    }
    /**
     * Refresh the featured vehicles list based on selected brand and category.
     */
    private function refreshFeaturedVehiclesList()
    {
        $this->featuredVehicles = \App\Models\Vehicle::featured()
            ->when($this->selectedBrand, function ($query) {
                $query->where('vehicle_brand_id', $this->selectedBrand);
            })
            ->when($this->selectedCategory, function ($query) {
                $query->where('vehicle_category_id', $this->selectedCategory);
            })
            ->orderBy('order', 'asc')
            ->get();
    }

    /**
     * Refresh the categories list based on selected brand.
     */
    private function refreshCategories()
    {
        $this->categories = VehicleCategory::whereHas('vehicles', function ($query) {
            $query->featured();
            if ($this->selectedBrand) {
                $query->where('vehicle_brand_id', $this->selectedBrand);
            }
        })->get();
    }

    public function render()
    {
        return view('livewire.featured-vehicles', [
            'featuredVehicles' => $this->featuredVehicles,
            'brands' => VehicleBrand::all(),
        ]);
    }
}
