<div class="h-auto w-full">
    <div class="flex items-center justify-center gap-8 overflow-x-auto mb-6">
        @foreach ($brands as $brand)
            <div class="flex items-center cursor-pointer rounded-lg overflow-hidden @if($selectedBrand == $brand->id)border border-2 border-slate-500 @endif" wire:click="filterByBrand({{ $brand->id }})" wire:key="brand-{{ $brand->id }}">
                <img src="{{ asset('/storage/' . $brand->logo) }}" alt="{{ $brand->name }}"
                    class="h-32 w-32">
            </div>
        @endforeach
    </div>
    <div class="flex items-center justify-start gap-8 overflow-x-auto">
        @foreach ($categories as $category)
            <div class="flex items-center cursor-pointer rounded-lg overflow-hidden @if($selectedCategory == $category->id)border border-2 border-slate-500 @endif" wire:click="filterByCategory({{ $category->id }})" wire:key="category-{{ $category->id }}">
                <span class="text-center text-sm font-semibold text-gray-700">{{ $category->name }}</span>
            </div>            
        @endforeach    
    </div>
    {{-- <div class="swiper h-auto w-full"
        data-swiper-options="{
            'autoHeight': true,
            'spaceBetween': 20,
            'grabCursor': true,
            'slidesPerView': 1,
            'pagination': { 'el': '.swiper-pagination' , 'clickable': true },
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
        <div class="swiper-pagination"></div>
    </div> --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($featuredVehicles as $vehicle)
            <div class="flex items-center justify-center" wire:key="vehicle-{{ $vehicle->id }}">
                <x-vehicle-card :vehicle="$vehicle" />
            </div>
        @endforeach
</div>