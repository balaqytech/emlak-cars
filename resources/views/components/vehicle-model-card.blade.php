<div class="flex flex-col gap-4 p-4 bg-white shadow-3xl rounded-2xl">
    <a href="{{ localizedUrl('/vehicles/' . $model->vehicle->slug. '/' . $model->slug) }}"
        class="relative w-full h-64 bg-contain bg-center bg-no-repeat rounded-xl overflow-hidden"
        style="background-image: url('{{ Storage::url($model->image) }}')">
        <img loading="lazy" src="{{ Storage::url($model->image) }}" alt="{{ $model->name }}"
            class="w-full h-full object-contain object-center hover:scale-110 hover:rotate-2 transition-all duration-500">
        <div class="absolute start-2 bottom-2 flex justify-start gap-2">
            @foreach ($model->colors as $color)
                <div class="w-4 h-4 rounded-full border border-slate-300" style="background-color: {{ $color['hex'] }}"></div>
            @endforeach
        </div>
    </a>
    <div class="flex flex-col gap-4 p-4">
        <h3 class="text-xl font-semibold text-primary font-arial">
            <a href="{{ localizedUrl('/vehicles/' . $model->vehicle->slug. '/' . $model->slug) }}"
                class="hover:underline">{{ $model->name }}</a>
        </h3>
        <p class="text-sm text-slate-600">{{ $model->excerpt }}</p>
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <x-primary-button href="{{ localizedUrl('/vehicles/' . $model->vehicle->slug. '/' . $model->slug) }}"
                class="w-full text-sm text-primary hover:underline">{{ __('frontend.vehicles.view_details') }}</x-primary-button>
            <x-purchase-application-modal :model="$model->id">{{ __('frontend.vehicles.purchase') }}</x-purchase-application-modal>
        </div>
    </div>
</div>
