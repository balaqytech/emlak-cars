<div {{ $attributes->merge(['class' => 'grid grid-cols-1 md:grid-cols-2 items-center border border-slate-100 rounded-lg overflow-hidden bg-white shadow-3xl']) }}>
    <div class="py-8 px-8 h-full flex flex-col gap-4">
        <h2 class="font-bold text-2xl text-slate-800 hover:text-primary hover:underline">
            <a href="/vehicles/{{ $vehicle->slug }}">{{ $vehicle->name }}</a>
        </h2>
        <p class="text-slate-600 text-sm grow">{{ $vehicle->excerpt }}</p>
        <x-outline-button href="/vehicles/{{ $vehicle->slug }}"
            class="w-full inline-block self-start font-bold text-primary hover:underline mt-2">{{ __('frontend.vehicles.view_details') }}</x-outline-button>
    </div>
    <a href="/vehicles/{{ $vehicle->slug }}" class="relative h-full min-h-64 rounded-lg overflow-hidden">
        <img class="object-cover w-full h-full hover:scale-110 hover:rotate-2 transition-all duration-500"
            src="{{ Storage::url($vehicle->image) }}" alt="{{ $vehicle->name }}">
        <div
            class="absolute top-4 start-4 inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-primary text-white">
            {{ $vehicle->category->name }}</div>
    </a>
</div>
