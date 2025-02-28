@php
    use function Laravel\Folio\name;

    name('vehicles.show');
@endphp

<x-app-layout>
    <x-slot name="title">
        {{ $vehicle->name }}
    </x-slot>

    <section class="">
        <div class="max-h-[80dvh] overflow-hidden">
            <img src="{{ asset('storage/' . $vehicle->banner) }}" alt="{{ $vehicle->name }}"
                class="h-full w-full object-cover object-center">
        </div>
    </section>

    <section>
        <div class="wrapper grid grid-cols-1 lg:grid-cols-2 gap-4 my-24">
            <div class="flex flex-col gap-4">
                <p><a href="#"
                        class="bg-primary inline-block hover:bg-slate-700 text-white rounded px-5 py-2 transition-all duration-500">{{ $vehicle->category->name }}</a>
                </p>
                <h1 class="text-4xl font-bold text-slate-800">
                    {{ $vehicle->name }}
                </h1>
                <p class="text-slate-600 max-w-lg">
                    {{ $vehicle->excerpt }}
                </p>
            </div>
            <div class="h-48 w-full">
                <img class="w-full h-full object-contain object-center" src="{{ asset('storage/' . $vehicle->brand->logo) }}" alt="{{ $vehicle->brand->name }}">
            </div>

        </div>
    </section>

    <section>
        <div class="wrapper">
            <nav class="relative z-0 flex flex-col md:flex-row border rounded-xl overflow-hidden" aria-label="Tabs" role="tablist"
                aria-orientation="horizontal">
                <button type="button"
                    class="hs-tab-active:border-b-primary hs-tab-active:text-gray-900 relative min-w-0 flex-1 bg-white first:border-s-0 border-s border-b-2 py-4 px-4 text-gray-500 hover:text-gray-700 text-sm font-medium text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-none focus:text-primary disabled:opacity-50 disabled:pointer-events-none active"
                    id="models-item" aria-selected="true" data-hs-tab="#models"
                    aria-controls="models" role="tab">
                    {{ __('frontend.vehicles.models') }}
                </button>
                <button type="button"
                    class="hs-tab-active:border-b-primary hs-tab-active:text-gray-900 relative min-w-0 flex-1 bg-white first:border-s-0 border-s border-b-2 py-4 px-4 text-gray-500 hover:text-gray-700 text-sm font-medium text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-none focus:text-primary disabled:opacity-50 disabled:pointer-events-none"
                    id="overview-item" aria-selected="false" data-hs-tab="#overview"
                    aria-controls="overview" role="tab">
                    {{ __('frontend.vehicles.overview') }}
                </button>
                <button type="button"
                    class="hs-tab-active:border-b-primary hs-tab-active:text-gray-900 relative min-w-0 flex-1 bg-white first:border-s-0 border-s border-b-2 py-4 px-4 text-gray-500 hover:text-gray-700 text-sm font-medium text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-none focus:text-primary disabled:opacity-50 disabled:pointer-events-none"
                    id="features-item" aria-selected="false" data-hs-tab="#features"
                    aria-controls="features" role="tab">
                    {{ __('frontend.vehicles.features') }}
                </button>
            </nav>

            <div class="mt-3">
                <div id="models" class="py-8" role="tabpanel" aria-labelledby="models-item">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($vehicle->models as $model)
                            <x-vehicle-model-card :model="$model" />
                        @endforeach
                    </div>
                </div>
                <div id="overview" class="hidden" role="tabpanel" aria-labelledby="overview-item">
                    <div class="prose max-w-3xl py-12 mx-auto">
                        {!! str($vehicle->overview)->sanitizeHtml() !!}
                    </div>
                </div>
                <div id="features" class="hidden" role="tabpanel"
                    aria-labelledby="features-item">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($vehicle->features as $feature)
                            <x-vehicle-feature-card :image="$feature['image']" :title="$feature['title']" :description="$feature['description']" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
