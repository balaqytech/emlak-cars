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
                <x-breadcrumb :items="[
                    ['label' => __('frontend.navigation.vehicles'), 'url' => localizedUrl('/vehicles/')],
                    ['label' => $vehicle->name],
                ]" color="slate-400" />
                <h1 class="text-4xl font-bold text-slate-800">
                    {{ $vehicle->name }}
                </h1>
                <p class="text-slate-600 max-w-lg">
                    {{ $vehicle->excerpt }}
                </p>
            </div>
            <div class="h-48 w-full">
                <img class="w-full h-full object-contain object-center"
                    src="{{ asset('storage/' . $vehicle->brand->logo) }}" alt="{{ $vehicle->brand->name }}">
            </div>

        </div>
    </section>

    <section>
        <div x-data="{ selectedTab: 'models' }" class="wrapper">
            <nav x-on:keydown.right.prevent="$focus.wrap().next()" x-on:keydown.left.prevent="$focus.wrap().previous()"
                class="relative z-0 flex flex-col md:flex-row border rounded-xl overflow-hidden" role="tablist"
                aria-label="tab options">
                <button type="button" x-on:click="selectedTab = 'models'"
                    x-bind:aria-selected="selectedTab === 'models'"
                    x-bind:tabindex="selectedTab === 'models' ? '0' : '-1'"
                    x-bind:class="selectedTab === 'models' ? 'border-b-primary text-gray-900' : 'text-gray-500'"
                    class="relative min-w-0 flex-1 bg-white first:border-s-0 border-s border-b-2 py-4 px-4 hover:text-gray-700 text-sm font-medium text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-none focus:text-primary disabled:opacity-50 disabled:pointer-events-none active"
                    id="models-item" aria-selected="true" data-hs-tab="#models" aria-controls="models" role="tab">
                    {{ __('frontend.vehicles.models') }}
                </button>
                <button type="button" x-on:click="selectedTab = 'overview'"
                    x-bind:aria-selected="selectedTab === 'overview'"
                    x-bind:tabindex="selectedTab === 'overview' ? '0' : '-1'"
                    x-bind:class="selectedTab === 'overview' ? 'border-b-primary text-gray-900' : 'text-gray-500'"
                    class="relative min-w-0 flex-1 bg-white first:border-s-0 border-s border-b-2 py-4 px-4 hover:text-gray-700 text-sm font-medium text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-none focus:text-primary disabled:opacity-50 disabled:pointer-events-none active"
                    id="overview-item" aria-selected="true" data-hs-tab="#overview" aria-controls="overview"
                    role="tab">
                    {{ __('frontend.vehicles.overview') }}
                </button>
                <button type="button" x-on:click="selectedTab = 'features'"
                    x-bind:aria-selected="selectedTab === 'features'"
                    x-bind:tabindex="selectedTab === 'features' ? '0' : '-1'"
                    x-bind:class="selectedTab === 'features' ? 'border-b-primary text-gray-900' : 'text-gray-500'"
                    class="relative min-w-0 flex-1 bg-white first:border-s-0 border-s border-b-2 py-4 px-4 hover:text-gray-700 text-sm font-medium text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-none focus:text-primary disabled:opacity-50 disabled:pointer-events-none active"
                    id="features-item" aria-selected="true" data-hs-tab="#features" aria-controls="features"
                    role="tab">
                    {{ __('frontend.vehicles.features') }}
                </button>
            </nav>

            <div class="mt-3">
                <div x-cloak x-show="selectedTab === 'models'" id="tabpanelModels" role="tabpanel" aria-label="models"
                    class="py-8" role="tabpanel" aria-labelledby="models-item">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($vehicle->vehicleModels as $model)
                            <x-vehicle-model-card :model="$model" />
                        @endforeach
                    </div>
                </div>
                <div x-cloak x-show="selectedTab === 'overview'" id="tabpanelOverview" role="tabpanel"
                    aria-label="overview">
                    <div class="prose max-w-3xl py-12 mx-auto">
                        {!! str($vehicle->overview)->sanitizeHtml() !!}
                    </div>
                </div>
                <div x-cloak x-show="selectedTab === 'features'" id="tabpanelFeatures" role="tabpanel"
                    aria-label="features">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @if ($vehicle->features)

                            @foreach ($vehicle->features as $feature)
                                <x-vehicle-feature-card :image="$feature['image']" :title="$feature['title']" :description="$feature['description']" />
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
