<div class="wrapper" x-data="{ selectedCategory: @entangle('selectedCategory'), active: null }">
    <nav class="-mb-0.5 flex justify-start gap-x-6 overflow-x-auto">
        <a class="py-4 px-1 inline-flex items-center gap-2 border-b-2 text-sm whitespace-nowrap hover:text-primary focus:outline-hidden focus:text-primary"
            href="#" wire:click.prevent="selectCategory(null); active = null" x-on:click="selectedCategory = null"
            :class="active === null ? 'text-primary border-primary' : 'text-slate-500 border-transparent'">
            <span>{{ __('frontend.all') }}</span>
        </a>
        @foreach ($categories as $category)
            <a class="py-4 px-1 inline-flex items-center gap-2 border-b-2 text-sm whitespace-nowrap hover:text-primary focus:outline-hidden focus:text-primary"
                href="#" wire:click.prevent="selectCategory({{ $category->id }}); active = {{ $category->id }}" x-on:click="selectedCategory = {{ $category->id }}"
                :class="active === {{ $category->id }} ? 'text-primary border-primary' : 'text-slate-500 border-transparent'">
                <span>{{ $category->name }}</span>
            </a>
        @endforeach
    </nav>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8" x-show="true" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90">
        @forelse ($vehicles as $vehicle)
            <x-vehicle-card :vehicle="$vehicle" />
        @empty
            <div class="mt-8 col-span-3">
                <x-icons.question class="block mx-auto size-24 text-primary" />
                <p class="text-center">{{ __('frontend.vehicles.no_vehicles') }}</p>
            </div>
        @endforelse
    </div>
    @if ($queryType === 'paginate')
    <div class="mt-10">
        {{ $vehicles->links() }}
    </div>
    @endif
</div>
