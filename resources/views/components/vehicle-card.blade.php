<div class="flex flex-col gap-4 p-4 bg-white shadow-3xl rounded-2xl">
    <a href="/vehicles/{{ $vehicle->slug }}" class="relative w-full h-56 bg-cover bg-center bg-no-repeat rounded-xl overflow-hidden"
        style="background-image: url('{{ Storage::url($vehicle->image) }}')">
        <img src="{{ Storage::url($vehicle->image) }}" alt="{{ $vehicle->name }}"
            class="w-full h-full object-cover object-center hover:scale-110 hover:rotate-2 transition-all duration-500">
        <div
            class="absolute z-10 top-4 start-4 inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-primary text-white">
            {{ $vehicle->category->name }}</div>
    </a>
    <div class="flex flex-col justify-between grow gap-4 p-4">
        <div>
            <h2 class="text-xl font-semibold text-primary">
                <a href="/vehicles/{{ $vehicle->slug }}" class="hover:underline">{{ $vehicle->name }}</a>
            </h2>
            <p class="text-sm text-slate-600">{{ $vehicle->excerpt }}</p>
        </div>
        <div class="flex justify-between items-center">
            {{-- <span class="text-lg font-semibold text-primary">{{ $vehicle->price }}</span> --}}
            <x-primary-button href="/vehicles/{{ $vehicle->slug }}"
                class="text-sm text-primary hover:underline">{{ __('frontend.vehicles.view_details') }}</x-primary-button>
        </div>
    </div>
</div>
