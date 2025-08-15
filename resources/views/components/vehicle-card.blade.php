<div
    {{ $attributes->merge(['class' => 'flex flex-col border border-slate-100 rounded-lg overflow-hidden bg-white shadow-3xl h-full shrink-0']) }}>
    <a href="{{ localizedUrl('/vehicles/' . $vehicle->slug) }}" class="relative h-80 min-h-64 rounded-lg overflow-hidden">
        <img loading="lazy" class="object-cover w-full h-full hover:scale-110 hover:rotate-2 transition-all duration-500"
            src="{{ Storage::url($vehicle->image) }}" alt="{{ $vehicle->name }}">
        <div
            class="absolute top-4 start-4 inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-primary text-white">
            {{ $vehicle->category->name }}</div>
    </a>
    <div class="py-8 px-8 flex flex-col gap-4 grow">
        <h2 class="flex items-center gap-2 font-bold text-2xl text-slate-800 hover:text-primary hover:underline">
            <a href="{{ localizedUrl('/vehicles/' . $vehicle->slug) }}">{{ $vehicle->name }}</a>
            {{-- <sub class="text-slate-500 text-xs font-normal">({{ $vehicle->year }})</sub> --}}
        </h2>
        <p class="text-slate-600 text-sm grow">{{ $vehicle->excerpt }}</p>
        <hr>
        <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mt-auto">
            <p class="flex gap-2 text-sm">
                @if ($vehicle->show_least_price)
                    {{ __('frontend.price_start') }}:
                    <span class="font-bold text-primary">{{ number_format($vehicle->least_price) ?? 'NON' }}</span>
                    <x-icons.sar class="size-4 shrink-0" />
                @endif
            </p>
            <x-primary-button href="{{ localizedUrl('/vehicles/' . $vehicle->slug) }}"
                class="text-xs font-bold text-primary hover:underline mt-2">{{ __('frontend.vehicles.view_details') }}</x-primary-button>
        </div>
    </div>
</div>
