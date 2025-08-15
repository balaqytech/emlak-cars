<div class="h-auto w-full relative">
    <!-- Loading Spinner -->
    <div class="absolute inset-0 flex items-center justify-center bg-white/70 z-20" wire:loading.flex
        wire:target="filterByBrand,filterByCategory">
        <svg class="animate-spin h-10 w-10 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
            </circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
    </div>
    <div class="flex justify-center gap-4 overflow-x-auto mb-6 py-2 font-bold">
        @foreach ($brands as $brand)
            <div class="py-4 px-6 inline-flex items-center gap-x-2 text-sm rounded-lg border-2 border-primary disabled:opacity-50 disabled:pointer-events-none cursor-pointer @if ($selectedBrand == $brand->id) bg-primary text-white @else bg-white text-primary @endif hover:-translate-y-1 transition-all duration-300 ease-in-out"
                wire:click="filterByBrand({{ $brand->id }})" wire:key="brand-{{ $brand->id }}"
                wire:loading.attr="disabled">
                <span class="text-lg">{{ $brand->name }}</span>
            </div>
        @endforeach
    </div>
    <div class="flex items-center justify-start lg:justify-center gap-4 overflow-x-auto mb-6 py-1 font-bold">
        <div class="py-1 px-2 inline-flex items-center gap-x-2 shrink-0 text-sm rounded-lg border border-primary disabled:opacity-50 disabled:pointer-events-none cursor-pointer @if ($selectedCategory == null) bg-primary text-white @else bg-white text-primary @endif hover:-translate-y-1 transition-all duration-300 ease-in-out"
            wire:click="filterByCategory('')">
            {{ __('frontend.all') }}
        </div>
        @foreach ($categories as $category)
            <div class="py-1 px-2 inline-flex items-center gap-x-2 shrink-0 text-sm rounded-lg border border-primary disabled:opacity-50 disabled:pointer-events-none cursor-pointer @if ($selectedCategory == $category->id) bg-primary text-white @else bg-white text-primary @endif hover:-translate-y-1 transition-all duration-300 ease-in-out"
                wire:click="filterByCategory({{ $category->id }})" wire:key="category-{{ $category->id }}"
                wire:loading.attr="disabled">
                {{ $category->name }}
            </div>
        @endforeach
    </div>
    <div class="swiper h-auto w-full"
        data-swiper-options="{
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
                <div class="swiper-slide h-auto" wire:key="vehicle-{{ $vehicle->id }}">
                    <x-vehicle-card :vehicle="$vehicle" />
                </div>
            @endforeach
        </div>
        <div class="featured-pagination flex items-center justify-center"></div>
    </div>
</div>
