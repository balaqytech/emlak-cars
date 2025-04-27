<div class="h-auto w-full">
    <div class="flex items-center justify-center gap-8 overflow-x-auto mb-6">
        @foreach ($brands as $brand)
            <div class="flex items-center shrink-0 h-32 w-32 p-1 cursor-pointer rounded-lg shadow-lg border-2 @if($selectedBrand == $brand->id) border-primary @else border-slate-500 @endif" wire:click="filterByBrand({{ $brand->id }})" wire:key="brand-{{ $brand->id }}">
                <img src="{{ asset('/storage/' . $brand->logo) }}" alt="{{ $brand->name }}"
                    class="w-full h-full object-cover object-center rounded-lg">
            </div>
        @endforeach
    </div>
    <div class="flex flex-nowrap items-center justify-start gap-8 overflow-x-auto mb-6">
        <div class="cursor-pointer shrink-0 @if($selectedCategory == null) border-b-2 border-slate-500 @endif" wire:click="filterByCategory('')">
            {{ __('frontend.all') }}
        </div>            
        @foreach ($categories as $category)
            <div class="cursor-pointer shrink-0 @if($selectedCategory == $category->id)border-b-2 border-slate-500 @endif" wire:click="filterByCategory({{ $category->id }})" wire:key="category-{{ $category->id }}">
                {{ $category->name }}
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
        @forelse ($featuredVehicles as $vehicle)
            <div wire:key="vehicle-{{ $vehicle->id }}">
                <x-vehicle-card :vehicle="$vehicle" />
            </div>
        @empty
        <div class="mt-8 col-span-3">
            <x-icons.question class="block mx-auto size-24 text-primary" />
            <p class="text-center">{{ __('frontend.vehicles.no_vehicles') }}</p>
        </div>
        @endforelse
    </div>
</div>