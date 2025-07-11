<div class="h-auto w-full">
    <div class="flex justify-center gap-4 overflow-x-auto mb-6 py-2">
        <div class="flex items-center cursor-pointer px-2 shrink-0 h-auto rounded-lg shadow border-2 @if ($selectedBrand == null) border-primary @else border-slate-500 @endif hover:-translate-y-1 transition-all duration-300 ease-in-out"
            wire:click="filterByBrand('')">
            {{ __('frontend.all') }}
        </div>
        @foreach ($brands as $brand)
            <div class="flex items-center gap-2 shrink-0 p-1 cursor-pointer rounded-lg shadow border-2 @if ($selectedBrand == $brand->id) border-primary @else border-slate-500 @endif hover:-translate-y-1 transition-all duration-300 ease-in-out"
                wire:click="filterByBrand({{ $brand->id }})" wire:key="brand-{{ $brand->id }}">
                <div class="h-12 w-12">
                    <img src="{{ asset('/storage/' . $brand->logo) }}" alt="{{ $brand->name }}"
                        class="w-full h-full object-cover object-center rounded-lg">
                </div>
                <span class="pe-2">{{ $brand->name }}</span>
            </div>
        @endforeach
    </div>
    <div class="flex flex-nowrap items-center justify-start gap-8 overflow-x-auto mb-6 py-1">
        <div class="cursor-pointer shrink-0 @if ($selectedCategory == null) border-b-2 border-slate-500 @endif"
            wire:click="filterByCategory('')">
            {{ __('frontend.all') }}
        </div>
        @foreach ($categories as $category)
            <div class="cursor-pointer shrink-0 @if ($selectedCategory == $category->id) border-b-2 border-slate-500 @endif"
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
