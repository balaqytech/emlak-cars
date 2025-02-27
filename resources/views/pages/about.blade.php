@php
    $settings = FilamentFlatPage::all('about.json');
    $locale = app()->getLocale();
@endphp

<x-page-layout>
    <x-slot name="title">
        {{ __('frontend.about.page_title') }}
    </x-slot>

    {{-- hero section --}}
    <section>
        <div class="wrapper py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-14">
                <div class="h-96 rounded-lg overflow-hidden">
                    <img class="h-full w-full object-cover object-center"
                        src="{{ asset('storage/' . $settings['about_image']) }}" alt="">
                </div>
                <div class="flex flex-col gap-2">
                    <span class="font-bold text-primary">{{ $settings['about_subheading'][$locale] }}</span>
                    <h2 class="font-bold text-slate-800 text-3xl mb-4">{{ $settings['about_heading'][$locale] }}</h2>
                    <div class="prose max-w-none">
                        {!! $settings['about_description'][$locale] !!}
                    </div>
                </div>
            </div>
            <div class="grid gird-cols-1 lg:grid-cols-2 mt-16 gap-8 items-center">
                <div class="grid grid-cols-2 lg:grid-cols-3 items-center text-center gap-4">
                    <span
                        class="font-bold text-8xl text-slate-800">{{ $settings['facts'][$locale][0]['number'] }}</span>
                    <span
                        class="font-bold text-4xl text-slate-800 text-start">{{ $settings['facts'][$locale][0]['title'] }}</span>
                    <span class="hidden lg:block text-7xl text-primary">|</span>
                </div>
                <div class="grid grid-cols-2 items-center gap-4">
                    <div class="flex flex-col justify-center gap-4 text-center">
                        <span
                            class="font-bold text-5xl text-slate-800">{{ $settings['facts'][$locale][1]['number'] }}</span>
                        <span
                            class="font-bold text-xl text-slate-800">{{ $settings['facts'][$locale][1]['title'] }}</span>
                    </div>
                    <div class="flex flex-col justify-center gap-4 text-center">
                        <span
                            class="font-bold text-5xl text-slate-800">{{ $settings['facts'][$locale][2]['number'] }}</span>
                        <span
                            class="font-bold text-xl text-slate-800">{{ $settings['facts'][$locale][2]['title'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- end hero section --}}

    {{-- vision and mission section --}}
    <section id="vision-section" class="bg-slate-50 my-4">
        <div class="wrapper py-20 ">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="flex flex-col gap-4">
                    <div class="w-full">
                        <div data-hs-carousel='{
                            "loadingClasses": "opacity-0",
                            "isRTL": true
                          }'
                            class="relative">
                            <div class="hs-carousel relative overflow-hidden w-full min-h-64 px-24">
                                <div
                                    class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700 opacity-0">
                                    <div class="hs-carousel-slide">
                                        <div class="flex flex-col px-6 py-4 gap-4">
                                            <h2 class="font-bold text-primary">{{ __('frontend.about.vision') }}</h2>
                                            <p class="font-bold text-slate-800 text-3xl">
                                                {{ $settings['vision_title'][$locale] }}</p>
                                            <p>
                                                {!! str($settings['vision_description'][$locale])->sanitizeHtml() !!}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="hs-carousel-slide">
                                        <div class="flex flex-col px-6 py-4 gap-4">
                                            <h2 class="font-bold text-primary">{{ __('frontend.about.mission') }}</h2>
                                            <p class="font-bold text-slate-800 text-3xl">
                                                {{ $settings['mission_title'][$locale] }}</p>
                                            <p>{!! str($settings['mission_description'][$locale])->sanitizeHtml() !!}</p>
                                        </div>
                                    </div>
                                    <div class="hs-carousel-slide">
                                        <div class="flex flex-col px-6 py-4 gap-4">
                                            <h2 class="font-bold text-primary">{{ __('frontend.about.values') }}</h2>
                                            <p class="font-bold text-slate-800 text-3xl">
                                                {{ $settings['values_title'][$locale] }}</p>
                                            <p>{!! str($settings['values_description'][$locale])->sanitizeHtml() !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button"
                                class="hs-carousel-prev hs-carousel-disabled:opacity-50 disabled:pointer-events-none h-10 w-10 rounded-full inline-flex justify-center items-center text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10 ">
                                <span class="text-2xl" aria-hidden="true">
                                    <svg class="shrink-0 size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="m15 18-6-6 6-6"></path>
                                    </svg>
                                </span>
                                <span class="sr-only">Previous</span>
                            </button>
                            <button type="button"
                                class="hs-carousel-next hs-carousel-disabled:opacity-50 disabled:pointer-events-none h-10 w-10 rounded-full inline-flex justify-center items-center text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10">
                                <span class="sr-only">Next</span>
                                <span class="text-2xl" aria-hidden="true">
                                    <svg class="shrink-0 size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="m9 18 6-6-6-6"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div>
                    <img src="{{ asset('storage/' . $settings['about_image']) }}" alt="">
                </div>
            </div>
        </div>
    </section>
    {{-- end vision and mission section --}}

    {{-- partners section --}}
    <section id="partners-section" class="py-24">
        <div class="wrapper">
            <div class="w-2/3 sm:w-1/2 lg:w-1/3 mx-auto text-center mb-6">
                <h2 class="font-bold text-slate-800 text-3xl">{{ __('frontend.about.partners_heading') }}</h2>
            </div>

            <div class="flex flex-wrap justify-center gap-6 sm:gap-12 lg:gap-18 mt-12">
                @foreach ($settings['partners'] as $partner)
                    <div class="h-12 sm:h-16 lg:h-48 border border-gray-300 rounded-lg overflow-hidden border-dashed">
                        <img class="h-full w-full object-contain object-center"
                            src="{{ asset('storage/' . $partner) }}" alt="">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- end partners section --}}

    {{-- timeline section --}}
    <section id="timeline-section" class="bg-slate-50 py-24">
        <div class="wrapper flex flex-col gap-12">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-8">
                <h2 class="font-bold text-slate-800 text-2xl">{{ $settings['history_heading'][$locale] }}</h2>
                <div class="prose max-w-none">
                    {!! str($settings['history_description'][$locale])->sanitizeHtml() !!}
                </div>
            </div>
            <div data-hs-carousel='{
                "isRTL": true,
                "loadingClasses": "opacity-0",
                "dotsItemClasses": "hs-carousel-active:bg-primary hs-carousel-active:border-blue-700 size-3 border border-gray-400 rounded-full cursor-pointer dark:border-neutral-600 dark:hs-carousel-active:bg-primary dark:hs-carousel-active:border-primary",
                "slidesQty": {
                  "xs": 1,
                  "lg": 3
                }
              }'
                class="relative">
                <div class="hs-carousel w-full overflow-hidden">
                    <div class="relative min-h-96 -mx-1">
                        <!-- transition-transform duration-700 -->
                        <div
                            class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap opacity-0 transition-transform duration-700">

                            @foreach ($settings['timeline'][$locale] as $history)
                                <div class="hs-carousel-slide px-1">
                                    <x-timeline-item :year="$history['year']" :title="$history['title']">
                                        {!! $history['description'] !!}
                                    </x-timeline-item>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- end timeline section --}}

    {{-- video section --}}
    <section id="video-section">
        <div class="wrapper py-24">
            <div class="relative h-96 rounded-xl overflow-hidden">
                <img class="h-full w-full object-cover object-center" src="{{ Storage::url($settings['image']) }}"
                    alt="">

                <div class="absolute inset-0 size-full">
                    <div class="flex flex-col justify-center items-center size-full">
                        <a class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                            href="{{ $settings['video'] }}" target="_blank">
                            <x-icons.play class="shrink-0 size-4" />
                            {{ __('frontend.about.watch_video') }}
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>
    {{-- end video section --}}
</x-page-layout>
