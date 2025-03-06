<x-app-layout>
    <x-slot name="title">
        {{ $vehicleModel->vehicle->name }} - {{ $vehicleModel->name }}
    </x-slot>

    <section class="py-24 bg-white">
        <div class="wrapper">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-4">
                <div class="order-2 md:order-1 flex flex-col gap-4">
                    <x-breadcrumb :items="[
                        ['label' => __('frontend.navigation.vehicles'), 'url' => '/vehicles'],
                        ['label' => $vehicleModel->vehicle->name, 'url' => '/vehicle/' . $vehicleModel->vehicle->slug],
                        ['label' => $vehicleModel->name]
                    ]" color="slate-400" />
                    <h1 class="text-3xl font-bold text-slate-900">{{ $vehicleModel->name }}</h1>
                    <p class="mt-2 text-slate-500">{{ $vehicleModel->excerpt }}</p>
                    <div class="flex flex-col md:flex-row gap-4 items-center">
                        <livewire:cash-purchase-application-form :model="$vehicleModel->id" paymentMethod="cash" />
                        <x-outline-button
                            href="/installment-calculator">{{ __('frontend.vehicles.installment_apply') }}</x-outline-button>
                    </div>
                </div>
                <div class="order-1 md:order-2">
                    <img class="w-full h-full object-contain object-center"
                        src="{{ asset('storage/' . $vehicleModel->image) }}" alt="{{ $vehicleModel->name }}">
                </div>
            </div>
        </div>
    </section>

    <section>
        <div x-data="{ selectedTab: 'colors' }" class="wrapper">
            <nav x-on:keydown.right.prevent="$focus.wrap().next()" x-on:keydown.left.prevent="$focus.wrap().previous()"
                class="relative z-0 flex flex-col md:flex-row border rounded-xl overflow-hidden"
                aria-label="tab options">
                <button type="button" x-on:click="selectedTab = 'colors'"
                    x-bind:aria-selected="selectedTab === 'colors'"
                    x-bind:tabindex="selectedTab === 'colors' ? '0' : '-1'"
                    x-bind:class="selectedTab === 'colors' ? 'border-b-primary text-gray-900' : 'text-gray-500'"
                    class="relative min-w-0 flex-1 bg-white first:border-s-0 border-s border-b-2 py-4 px-4 hover:text-gray-700 text-sm font-medium text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-none focus:text-primary disabled:opacity-50 disabled:pointer-events-none active"
                    id="colors-item" aria-selected="true" data-hs-tab="#colors" aria-controls="colors" role="tab">
                    {{ __('frontend.vehicles.model_colors') }}
                </button>
                <button type="button" x-on:click="selectedTab = 'overview'"
                    x-bind:aria-selected="selectedTab === 'overview'"
                    x-bind:tabindex="selectedTab === 'overview' ? '0' : '-1'"
                    x-bind:class="selectedTab === 'overview' ? 'border-b-primary text-gray-900' : 'text-gray-500'"
                    class="relative min-w-0 flex-1 bg-white first:border-s-0 border-s border-b-2 py-4 px-4 hover:text-gray-700 text-sm font-medium text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-none focus:text-primary disabled:opacity-50 disabled:pointer-events-none active"
                    id="overview-item" aria-selected="true" data-hs-tab="#overview" aria-controls="overview" role="tab">
                    {{ __('frontend.vehicles.model_overview') }}
                </button>
                <button type="button" x-on:click="selectedTab = 'specifications'"
                    x-bind:aria-selected="selectedTab === 'specifications'"
                    x-bind:tabindex="selectedTab === 'specifications' ? '0' : '-1'"
                    x-bind:class="selectedTab === 'specifications' ? 'border-b-primary text-gray-900' : 'text-gray-500'"
                    class="relative min-w-0 flex-1 bg-white first:border-s-0 border-s border-b-2 py-4 px-4 hover:text-gray-700 text-sm font-medium text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-none focus:text-primary disabled:opacity-50 disabled:pointer-events-none active"
                    id="specifications-item" aria-selected="true" data-hs-tab="#specifications" aria-controls="specifications" role="tab">
                    {{ __('frontend.vehicles.model_specifications') }}
                </button>
            </nav>

            <div class="mt-3">
                <div  x-cloak x-show="selectedTab === 'colors'" id="tabpanelColors" role="tabpanel" aria-label="colors" class="py-8" role="tabpanel" aria-labelledby="colors-item">
                    <!-- Slider -->
                    <div data-hs-carousel='{
                                                "loadingClasses": "opacity-0",
                                                "isRTL": true
                                            }'
                        class="relative">
                        <div class="hs-carousel flex gap-2">
                            <div class="flex-none">
                                <div class="hs-carousel-pagination max-h-96 flex flex-col gap-y-2 overflow-y-auto">
                                    @foreach ($vehicleModel->colors as $color)
                                        <div
                                            class="hs-carousel-pagination-item shrink-0 border rounded-md overflow-hidden cursor-pointer w-[150px] h-[150px] hs-carousel-active:border-primary">
                                            <div class="flex justify-center h-full p-2"
                                                style="background-color: {{ $color->hex }};">
                                                <span class="self-center transition duration-700"
                                                    style="color: {{ $color->hex }}; filter: grayscale(100%) invert(1);">{{ $color->name }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="relative grow overflow-hidden min-h-96 bg-white rounded-lg">
                                <div
                                    class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700 opacity-0">
                                    @foreach ($vehicleModel->colors as $color)
                                        <div class="hs-carousel-slide flex-none w-full h-full relative">
                                            <img class="w-full h-full object-contain object-center"
                                                src="{{ asset('storage/' . $color->image) }}"
                                                alt="{{ $color->name }}">
                                            <div class="absolute start-2 top-2 flex justify-start gap-2">
                                                <span
                                                    class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded bg-primary text-white">{{ __('frontend.vehicles.cash_price') }}
                                                    {{ $color->cash_price }}</span>
                                                <span
                                                    class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded bg-slate-800 text-white">{{ __('frontend.vehicles.installment_price') }}
                                                    {{ $color->installment_price }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="button"
                                    class="hs-carousel-prev hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 start-0 inline-flex justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10 rounded-s-lg">
                                    <span class="text-2xl" aria-hidden="true">
                                        <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m15 18-6-6 6-6"></path>
                                        </svg>
                                    </span>
                                    <span class="sr-only">Previous</span>
                                </button>
                                <button type="button"
                                    class="hs-carousel-next hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 end-0 inline-flex justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10 rounded-e-lg">
                                    <span class="sr-only">Next</span>
                                    <span class="text-2xl" aria-hidden="true">
                                        <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m9 18 6-6-6-6"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- End Slider -->
                </div>
                <div  x-cloak x-show="selectedTab === 'overview'" id="tabpanelOverview" role="tabpanel" aria-label="overview" class="py-8" role="tabpanel" aria-labelledby="overview-item">
                    <div class="prose max-w-3xl py-12 mx-auto">
                        {!! str($vehicleModel->overview)->sanitizeHtml() !!}
                    </div>
                </div>
                <div  x-cloak x-show="selectedTab === 'specifications'" id="tabpanelSpecifications" role="tabpanel" aria-label="specifications" class="py-8" role="tabpanel" aria-labelledby="specifications-item">
                    <div class="prose max-w-3xl py-12 mx-auto">
                        {!! str($vehicleModel->specifications)->sanitizeHtml() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
