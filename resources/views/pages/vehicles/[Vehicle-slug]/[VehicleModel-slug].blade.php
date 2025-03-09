<x-app-layout>
    <x-slot name="title">
        {{ $vehicleModel->vehicle->name }} - {{ $vehicleModel->name }}
    </x-slot>

    <section class="py-24 bg-white">
        <div class="wrapper">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-4">
                <div class="order-2 md:order-1 flex flex-col gap-4">
                    <x-breadcrumb :items="[
                        ['label' => __('frontend.navigation.vehicles'), 'url' => localizedUrl('/vehicles/')],
                        ['label' => $vehicleModel->vehicle->name, 'url' => localizedUrl('/vehicles/' . $vehicleModel->vehicle->slug)],
                        ['label' => $vehicleModel->name],
                    ]" color="slate-400" />
                    <h1 class="text-3xl font-bold text-slate-900">{{ $vehicleModel->name }}</h1>
                    <p class="mt-2 text-slate-500">{{ $vehicleModel->excerpt }}</p>
                    <div class="flex flex-col md:flex-row gap-4 items-center">
                        <div x-data="{ modalIsOpen: false }">
                            <x-primary-button x-on:click="modalIsOpen = true"
                                class="cursor-pointer">{{ __('frontend.vehicles.cash_purchase_apply') }}</x-primary-button>
                            <livewire:cash-purchase-application-form :model="$vehicleModel->id" paymentMethod="cash" />

                        </div>
                        <x-outline-button
                            href="{{ localizedUrl('/installment-calculator?model=' .$vehicleModel->id) }}">{{ __('frontend.vehicles.installment_apply') }}</x-outline-button>
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
                    id="overview-item" aria-selected="true" data-hs-tab="#overview" aria-controls="overview"
                    role="tab">
                    {{ __('frontend.vehicles.model_overview') }}
                </button>
                <button type="button" x-on:click="selectedTab = 'specifications'"
                    x-bind:aria-selected="selectedTab === 'specifications'"
                    x-bind:tabindex="selectedTab === 'specifications' ? '0' : '-1'"
                    x-bind:class="selectedTab === 'specifications' ? 'border-b-primary text-gray-900' : 'text-gray-500'"
                    class="relative min-w-0 flex-1 bg-white first:border-s-0 border-s border-b-2 py-4 px-4 hover:text-gray-700 text-sm font-medium text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-none focus:text-primary disabled:opacity-50 disabled:pointer-events-none active"
                    id="specifications-item" aria-selected="true" data-hs-tab="#specifications"
                    aria-controls="specifications" role="tab">
                    {{ __('frontend.vehicles.model_specifications') }}
                </button>
            </nav>

            <div class="mt-3">
                <div x-cloak x-show="selectedTab === 'colors'" id="tabpanelColors" role="tabpanel" aria-label="colors"
                    class="py-8" role="tabpanel" aria-labelledby="colors-item">
                    <div x-data="{
                        slides: {{ $vehicleModel->colors->toJson() }},
                        currentSlideIndex: 1,
                    }" class="relative w-full">

                        <!-- slides -->
                        <!-- Change min-h-[50svh] to your preferred height size -->
                        <div class="relative min-h-[80dvh] md:min-h-[50svh] h-auto w-full">
                            <template x-for="(slide, index) in slides">
                                <div x-cloak x-show="currentSlideIndex == index + 1" class="absolute inset-0"
                                    x-transition.opacity.duration.1000ms>
                                    <div
                                        class="absolute w-full h-full inset-0 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                        <div class="bg-white border border-gray-200 rounded-xl shadow-lg" role="alert"
                                            tabindex="-1">
                                            <div class="flex p-8">
                                                <div class="shrink-0">
                                                    <x-icons.pallete
                                                        class="w-6 h-6 text-slate-700 dark:text-slate-300" />
                                                </div>
                                                <div class="flex flex-col ms-3 gap-2">
                                                    <h3 class="text-slate-800 font-semibold dark:text-white">
                                                        {{ __('frontend.vehicles.model_color') }}
                                                    </h3>
                                                    <p x-text="slide.name"
                                                        class="text-sm text-slate-700 dark:text-neutral-400"></p>
                                                </div>
                                            </div>
                                            <div class="flex p-8">
                                                <div class="shrink-0">
                                                    <x-icons.sar class="w-6 h-6 text-slate-700 dark:text-slate-300" />
                                                </div>
                                                <div class="flex flex-col ms-3 gap-2">
                                                    <h3 class="text-slate-800 font-semibold dark:text-white">
                                                        {{ __('frontend.vehicles.model_cash_price') }}
                                                    </h3>
                                                    <p class="text-sm text-slate-700 dark:text-neutral-400">
                                                        <span
                                                            x-text="new Intl.NumberFormat().format(slide.cash_price)"></span>
                                                        {{ __('frontend.sar') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex p-8">
                                                <div class="shrink-0">
                                                    <x-icons.sar class="w-6 h-6 text-slate-700 dark:text-slate-300" />
                                                </div>
                                                <div class="flex flex-col ms-3 gap-2">
                                                    <h3 class="text-slate-800 font-semibold dark:text-white">
                                                        {{ __('frontend.vehicles.model_installment_price') }}
                                                    </h3>
                                                    <p class="text-sm text-slate-700 dark:text-neutral-400">
                                                        <span
                                                            x-text="new Intl.NumberFormat().format(slide.installment_price)"></span>
                                                        {{ __('frontend.sar') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <img class="md:col-span-2 lg:col-span-3 object-contain text-slate-700 dark:text-slate-300"
                                            x-bind:src="'/storage/' + slide.image" x-bind:alt="slide.name" />
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- indicators -->
                        <div class="rounded-xl flex mt-4 justify-center gap-4 md:gap-3 px-1.5 py-1 md:px-2"
                            role="group" aria-label="slides">
                            <template x-for="(slide, index) in slides">
                                <button class="size-6 rounded-full transition"
                                    x-on:click="currentSlideIndex = index + 1"
                                    x-bind:style="'background-color: ' + slide.hex"
                                    x-bind:aria-label="'slide ' + (index + 1)"
                                    x-bind:class="currentSlideIndex === index + 1 ? 'border-2 border-slate-900' : ''"></button>
                            </template>
                        </div>
                    </div>
                </div>
                <div x-cloak x-show="selectedTab === 'overview'" id="tabpanelOverview" role="tabpanel"
                    aria-label="overview" class="py-8" role="tabpanel" aria-labelledby="overview-item">
                    <div class="prose max-w-3xl py-12 mx-auto">
                        {!! str($vehicleModel->overview)->sanitizeHtml() !!}
                    </div>
                </div>
                <div x-cloak x-show="selectedTab === 'specifications'" id="tabpanelSpecifications" role="tabpanel"
                    aria-label="specifications" class="py-8" role="tabpanel"
                    aria-labelledby="specifications-item">
                    <div class="prose max-w-3xl py-12 mx-auto">
                        {!! str($vehicleModel->specifications)->sanitizeHtml() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
