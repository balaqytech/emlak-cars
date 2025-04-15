<div class="wrapper relative">
    <form wire:submit.prevent="search" class="w-full  p-8 -mt-36 bg-white rounded-lg shadow-3xl shadow-slate-300 border border-slate-200">
        <div
            class="sm:flex sm:space-x-3 p-3 rounded-lg border border-slate-200">
            <div class="w-full pb-2 sm:pb-0">
                <label for="vehicle_search" class="block text-sm font-medium"><span class="sr-only">{{ __('frontend.vehicles.vehicle_search') }}</span></label>
                <input type="text" id="vehicle_search" wire:model="vehicle_search"
                    class="py-2.5 sm:py-3 px-4 block w-full border-transparent rounded-lg sm:text-sm focus:border-primary focus:ring-primary"
                    placeholder="{{ __('frontend.vehicles.vehicle_search') }}">
            </div>
            <div
                class="pt-2 sm:pt-0 sm:ps-3 border-t border-gray-200 sm:border-t-0 sm:border-s w-full">
                <select wire:model="selectedCategory"
                    class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none">
                    <option selected="" value="">{{ __('frontend.vehicles.select_category') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div
                class="pt-2 sm:pt-0 sm:ps-3 border-t border-gray-200 sm:border-t-0 sm:border-s w-full">
                <select wire:model="selectedBrand"
                    class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none">
                    <option selected="" value="">{{ __('frontend.vehicles.select_brand') }}</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="whitespace-nowrap pt-2 sm:pt-0 grid sm:block">
                <x-submit-button>
                    {{ __('frontend.vehicles.search') }}
                </x-submit-button>
            </div>
        </div>
    </form>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8" >
        @forelse ($vehicles as $vehicle)
            <x-vehicle-card :vehicle="$vehicle" />
        @empty
            <div class="mt-8 col-span-3">
                <x-icons.question class="block mx-auto size-24 text-primary" />
                <p class="text-center">{{ __('frontend.vehicles.no_vehicles') }}</p>
            </div>
        @endforelse
    </div>
    <div class="mt-10">
        {{ $vehicles->links() }}
    </div>
</div>
