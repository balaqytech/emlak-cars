<div class="flex flex-col gap-4 p-4 bg-white shadow-3xl rounded-2xl">
    <a href="{{ localizedUrl('/vehicles/' . $model->vehicle->slug. '/' . $model->slug) }}"
        class="relative w-full h-64 bg-cover bg-center bg-no-repeat rounded-xl overflow-hidden"
        style="background-image: url('{{ Storage::url($model->image) }}')">
        <img src="{{ Storage::url($model->image) }}" alt="{{ $model->name }}"
            class="w-full h-full object-cover object-center hover:scale-110 hover:rotate-2 transition-all duration-500">
        <div class="absolute start-2 bottom-2 flex justify-start gap-2">
            @foreach ($model->colors as $color)
                <div class="w-4 h-4 rounded-full" style="background-color: {{ $color['hex'] }}"></div>
            @endforeach
        </div>
    </a>
    <div class="flex flex-col gap-4 p-4">
        <h3 class="text-xl font-semibold text-primary">
            <a href="{{ localizedUrl('/vehicles/' . $model->vehicle->slug. '/' . $model->slug) }}"
                class="hover:underline">{{ $model->name }}</a>
        </h3>
        <p class="text-sm text-slate-600">{{ $model->excerpt }}</p>
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            {{-- <span class="text-lg font-semibold text-primary">{{ $model->price }}</span> --}}
            <x-primary-button href="{{ localizedUrl('/vehicles/' . $model->vehicle->slug. '/' . $model->slug) }}"
                class="w-full text-sm text-primary hover:underline">{{ __('frontend.vehicles.view_details') }}</x-primary-button>
            <x-outline-button href="{{ localizedUrl('/vehicles/' . $model->vehicle->slug. '/' . $model->slug) }}#contact"
                class="w-full text-sm text-primary hover:underline">{{ __('frontend.vehicles.purchase') }}</x-outline-button>
        </div>
    </div>
</div>
