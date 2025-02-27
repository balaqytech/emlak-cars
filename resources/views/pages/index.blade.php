@php
    use Panakour\FilamentFlatPage\Facades\FilamentFlatPage;
    $settings = FilamentFlatPage::all('homepage.json');
    $slides = $settings['slider'][app()->getLocale()];
    $banner_image = asset('storage/' . $settings['banner']);
    $banner_title = $settings['banner_title'][app()->getLocale()];
    $banner_subtitle = $settings['banner_subtitle'][app()->getLocale()];
@endphp

<x-app-layout>
    <x-slot name="title">
        {{ __('frontend.homepage.page_title') }}
    </x-slot>

    <section id="slider" class="min-h-screen bg-slate-50">
        <div data-hs-carousel='{
            "loadingClasses": "opacity-0",
            "dotsItemClasses": "hs-carousel-active:bg-primary hs-carousel-active:border-primary size-3 border border-gray-400 rounded-full cursor-pointer dark:border-neutral-600 dark:hs-carousel-active:bg-primary dark:hs-carousel-active:border-primary",
            "isAutoPlay": true,
            "isRTL": true
          }'
            class="relative">
            <div class="hs-carousel relative overflow-hidden w-full min-h-screen">
                <div
                    class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700 opacity-0">
                    @foreach ($slides as $slide)
                        <div
                            class="hs-carousel-slide relative h-screen w-full before:content-[''] before:absolute before:top-0 before:start-0 before:h-full before:w-1/2 rtl:before:bg-gradient-to-l ltr:before:bg-gradient-to-r before:from-black/60 before:to-transparent before:z-10">
                            <div class="w-full h-full absolute top-0 left-0 overflow-hidden">
                                <img class="object-cover object-center w-full h-full"
                                    src="{{ asset('storage/' . $slide['laptop_image']) }}" alt="{{ $slide['title'] }}">
                            </div>
                            <div
                                class="wrapper relative z-20 flex flex-col items-start justify-center h-full text-white">
                                <div class="relative max-w-xl flex flex-col gap-4">
                                    <span class="font-bold text-lg text-white">{{ $slide['subtitle'] }}</span>
                                    <h2 class="inline-block rounded-lg font-bold text-4xl text-white">
                                        {{ $slide['title'] }}</h2>
                                    <div>
                                        <x-primary-button href="{{ $slide['button_link'] }}">
                                            {{ $slide['button_text'] }}
                                        </x-primary-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="hs-carousel-pagination flex justify-center absolute bottom-3 start-0 end-0 gap-2"></div>
        </div>
    </section>

    <section id="featured-cars" class="py-24">
        <div class="wrapper flex flex-col items-center gap-8">
            <div class="max-w-5xl text-center">
                <h2 class="mb-8 text-3xl font-semibold text-slate-800">
                    {{ __('frontend.homepage.featured_vehicles.heading') }}
                </h2>
                <p class="text-slate-500">
                    {{ __('frontend.homepage.featured_vehicles.description') }}
                </p>
            </div>
            <div class="w-full bg-white rounded-lg shadow-md">
                <div data-hs-carousel='{
                    "isAutoHeight": true,
                    "loadingClasses": "opacity-0",
                    "dotsItemClasses": "hs-carousel-active:bg-primary hs-carousel-active:border-primary size-3 border border-gray-400 rounded-full cursor-pointer dark:border-neutral-600 dark:hs-carousel-active:bg-primary dark:hs-carousel-active:border-primary",
                    "isAutoPlay": true,
                    "isRTL": true
                  }'
                    class="relative">
                    <div class="hs-carousel min-h-96 relative overflow-hidden w-full bg-white rounded-lg">
                        <div
                            class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700 opacity-0">
                            @foreach (\App\Models\Vehicle::latest()->take(3)->get() as $vehicle)
                                <x-featured-vehicle-card :vehicle="$vehicle" class="hs-carousel-slide h-auto" />
                            @endforeach
                        </div>
                    </div>

                    <button type="button"
                        class="hs-carousel-prev hs-carousel-disabled:opacity-50 disabled:pointer-events-none absolute inset-y-0 start-0 inline-flex justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10 rounded-s-lg">
                        <span class="text-2xl" aria-hidden="true">
                            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="m15 18-6-6 6-6"></path>
                            </svg>
                        </span>
                        <span class="sr-only">Previous</span>
                    </button>
                    <button type="button"
                        class="hs-carousel-next hs-carousel-disabled:opacity-50 disabled:pointer-events-none absolute inset-y-0 end-0 inline-flex justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10 rounded-e-lg">
                        <span class="sr-only">Next</span>
                        <span class="text-2xl" aria-hidden="true">
                            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6"></path>
                            </svg>
                        </span>
                    </button>

                    <div class="hs-carousel-pagination flex justify-center absolute bottom-3 start-0 end-0 gap-2">
                    </div>
                </div>
            </div>
            <div>
                <x-primary-button href="/vehicles">
                    {{ __('frontend.homepage.featured_vehicles.button') }}
                </x-primary-button>
            </div>
        </div>
    </section>

    <section id="banner"
        class="h-screen relative flex items-end bg-slate-50 bg-cover bg-center bg-fixed py-24 before:content[''] before:absolute before:top-0 before:left-0 before:right-0 before:h-1/2 before:bg-gradient-to-b before:from-white before:to-transparent"
        style="background-image: url('{{ $banner_image }}');">
        <div class="wrapper relative">
            <div class="max-w-xl flex flex-col items-start gap-1">
                <h2 class="bg-black/20 p-4 inline-block rounded-lg backdrop-blur-sm font-bold text-4xl text-white">
                    {{ $banner_title }}</h2>
                <p class="bg-black/20 p-2 inline-block rounded-lg backdrop-blur-sm text-slate-100">
                    {{ $banner_subtitle }}</p>
            </div>
        </div>
    </section>

    <section id="contact" class="py-24 bg-slate-50">
        <div class="wrapper">
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 items-center gap-6">
                <a class="group flex gap-y-6 size-full hover:bg-white focus:outline-none focus:bg-slate-100 rounded-lg p-8"
                    href="/branches">
                    <x-icons.locations class="shrink-0 size-8 text-slate-800 mt-0.5 me-6 group-hover:text-primary" />

                    <div>
                        <div>
                            <h3 class="block font-bold text-slate-800">
                                {{ __('frontend.homepage.contact.branches.heading') }}</h3>
                            <p class="text-slate-600">{{ __('frontend.homepage.contact.branches.description') }}</p>
                        </div>

                        <p
                            class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold text-slate-800 hover:underline hover:text-primary">
                            {{ __('frontend.homepage.contact.branches.button') }}
                            <x-icons.arrow-left
                                class="shrink-0 size-4 transition ease-in-out ltr:group-hover:translate-x-1 ltr:group-focus:translate-x-1 rtl:group-hover:-translate-x-1 rtl:rotate-180" />
                        </p>
                    </div>
                </a>

                <a class="group flex gap-y-6 size-full hover:bg-white focus:outline-none focus:bg-slate-100 rounded-lg p-8"
                    href="/installment-calculator">
                    <x-icons.calculator class="shrink-0 size-8 text-slate-800 mt-0.5 me-6 group-hover:text-primary" />

                    <div>
                        <div>
                            <h3 class="block font-bold text-slate-800">
                                {{ __('frontend.homepage.contact.calculator.heading') }}</h3>
                            <p class="text-slate-600">{{ __('frontend.homepage.contact.calculator.description') }}</p>
                        </div>

                        <p
                            class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold text-slate-800 hover:underline hover:text-primary">
                            {{ __('frontend.homepage.contact.calculator.button') }}
                            <x-icons.arrow-left
                                class="shrink-0 size-4 transition ease-in-out ltr:group-hover:translate-x-1 ltr:group-focus:translate-x-1 rtl:group-hover:-translate-x-1 rtl:rotate-180" />
                        </p>
                    </div>
                </a>
                <a class="group flex gap-y-6 size-full hover:bg-white focus:outline-none focus:bg-slate-100 rounded-lg p-8"
                    href="/contact">
                    <x-icons.phone class="shrink-0 size-8 text-slate-800 mt-0.5 me-6 group-hover:text-primary" />

                    <div>
                        <div>
                            <h3 class="block font-bold text-slate-800">
                                {{ __('frontend.homepage.contact.contact.heading') }}</h3>
                            <p class="text-slate-600">{{ __('frontend.homepage.contact.contact.description') }}</p>
                        </div>

                        <p
                            class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold text-slate-800 hover:underline hover:text-primary">
                            {{ __('frontend.homepage.contact.contact.button') }}
                            <x-icons.arrow-left
                                class="shrink-0 size-4 transition ease-in-out ltr:group-hover:translate-x-1 ltr:group-focus:translate-x-1 rtl:group-hover:-translate-x-1 rtl:rotate-180" />
                        </p>
                    </div>
                </a>
            </div>
            <!-- End Icon Blocks -->
        </div>
    </section>

    <section id="news" class="py-24">
        <div class="wrapper flex flex-col items-center gap-8">
            <div class="max-w-5xl text-center">
                <h2 class="mb-8 text-3xl font-semibold text-slate-800">
                    {{ __('frontend.homepage.news.heading') }}
                </h2>
                <p class="text-slate-500">
                    {{ __('frontend.homepage.news.description') }}
                </p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-12">
                @foreach (\App\Models\Post::latest()->take(3)->get() as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
            <div>
                <x-primary-button href="/posts">
                    {{ __('frontend.homepage.news.button') }}
                </x-primary-button>
            </div>
        </div>
    </section>
</x-app-layout>
