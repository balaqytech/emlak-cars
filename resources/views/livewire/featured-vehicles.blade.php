<div class="h-auto w-full">
    <div class="flex justify-center gap-4 overflow-x-auto mb-6 py-2">
        @foreach ($brands as $brand)
            <div class="py-4 px-6 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border-2 border-primary disabled:opacity-50 disabled:pointer-events-none cursor-pointer @if ($selectedBrand == $brand->id) bg-primary text-white @else bg-white text-primary @endif hover:-translate-y-1 transition-all duration-300 ease-in-out"
                wire:click="filterByBrand({{ $brand->id }})" wire:key="brand-{{ $brand->id }}">
                <span class="text-lg">{{ $brand->name }}</span>
            </div>
        @endforeach
    </div>
    <div class="flex flex-nowrap items-center justify-center gap-4 overflow-x-auto mb-6 py-1">
        <div class="py-1 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-primary disabled:opacity-50 disabled:pointer-events-none cursor-pointer @if ($selectedCategory == null) bg-primary text-white @else bg-white text-primary @endif hover:-translate-y-1 transition-all duration-300 ease-in-out"
            wire:click="filterByCategory('')">
            {{ __('frontend.all') }}
        </div>
        @foreach ($categories as $category)
            <div class="py-1 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-primary disabled:opacity-50 disabled:pointer-events-none cursor-pointer @if ($selectedCategory == $category->id) bg-primary text-white @else bg-white text-primary @endif hover:-translate-y-1 transition-all duration-300 ease-in-out"
                wire:click="filterByCategory({{ $category->id }})" wire:key="category-{{ $category->id }}">
                {{ $category->name }}
            </div>
        @endforeach
    </div>
    <div class="swiper h-auto w-full"
        data-swiper-options="{
            'autoHeight': true,
            'spaceBetween': 20,
            'grabCursor': true,
            'slidesPerView': 1,
            'pagination': { 'el': '.featured-pagination' , 'clickable': true },
            'breakpoints': {
                '640': {
                    'slidesPerView': 2,
                    'spaceBetween': 20
                },
                '768': {
                    'slidesPerView': 3,
                    'spaceBetween': 30
                }
            }
    }">
        <div class="swiper-wrapper py-12">
            @foreach ($featuredVehicles as $vehicle)
                <div class="swiper-slide" wire:key="vehicle-{{ $vehicle->id }}">
                    <x-vehicle-card :vehicle="$vehicle" />
                </div>
            @endforeach
        </div>
        <div class="featured-pagination flex items-center justify-center"></div>
    </div>
</div>
