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

    <section id="slider" class="min-h-[85dvh] bg-slate-50">
        <div class="swiper h-[85dvh]"
            data-swiper-options="{
                'loop': true,
                'grabCursor': true,
                'speed': 1000,
                'effect': 'creative',
                'creativeEffect': {
                    'prev': {
                        'shadow': true,
                        'translate': ['20%', 0, -1]
                    },
                    'next': {
                        'translate': ['-100%', 0, 0]
                    }
                },
                'pagination': {
                    'el': '.swiper-pagination',
                    'clickable': true
                }
        }">
            <div class="swiper-wrapper">
                @foreach ($slides as $slide)
                    <div class="swiper-slide">
                        <div
                            class=" relative h-[85dvh] w-full py-12 before:content-[''] before:absolute before:top-0 before:start-0 before:h-full before:w-1/2 rtl:before:bg-gradient-to-l ltr:before:bg-gradient-to-r before:from-black/60 before:to-transparent before:z-10">
                            <div class="w-full h-full absolute top-0 left-0 overflow-hidden">
                                <picture>
                                    <source media="(max-width: 480px)"
                                        srcset="{{ asset('storage/' . $slide['mobile_image']) }}">
                                    <img loading="lazy" class="object-cover object-center w-full h-full"
                                        src="{{ asset('storage/' . $slide['laptop_image']) }}"
                                        alt="{{ $slide['title'] }}">
                                </picture>
                            </div>
                            <div
                                class="wrapper relative z-20 flex flex-col items-center justify-end h-full text-white">
                                <div class="relative max-w-xl flex flex-col gap-4">
                                    <div>
                                        <x-primary-button href="{{ $slide['button_link'] }}">
                                            {{ $slide['button_text'] }}
                                        </x-primary-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
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
            <livewire:vehicle-search queryType="take" />
            <div class="mt-8">
                <x-outline-button href="{{ localizedUrl('/vehicles') }}">
                    {{ __('frontend.homepage.featured_vehicles.button') }}
                </x-outline-button>
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

    @if (\App\Models\Offer::exists())
        <section id="offers" class="py-24">
            <div class="wrapper flex flex-col items-center gap-8">
                <div class="max-w-5xl text-center">
                    <h2 class="mb-8 text-3xl font-semibold text-slate-800">
                        {{ __('frontend.homepage.offers.heading') }}
                    </h2>
                    <p class="text-slate-500">
                        {{ __('frontend.homepage.offers.description') }}
                    </p>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full mt-12">
                    @foreach (\App\Models\Offer::latest()->take(3)->get() as $offer)
                        <x-offer-card :offer="$offer" />
                    @endforeach
                </div>
                <div class="flex items-center">
                    <x-primary-button href="{{ localizedUrl('/offers') }}">
                        {{ __('frontend.homepage.offers.button') }}
                    </x-primary-button>
                </div>
            </div>
        </section>
    @endif

    <section id="contact" class="py-24 bg-slate-50">
        <div class="wrapper">
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 items-center gap-6">
                <a class="group flex gap-y-6 size-full hover:bg-white focus:outline-none focus:bg-slate-100 rounded-lg p-8"
                    href="{{ localizedUrl('/contact') }}">
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
                    href="{{ localizedUrl('/installment-calculator') }}">
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
                    href="{{ localizedUrl('/contact') }}">
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
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full mt-12">
                @foreach (\App\Models\Post::orderBy('is_featured', 'desc')->orderBy('published_at', 'desc')->take(3)->get() as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
            <div class="flex items-center">
                <x-primary-button href="{{ localizedUrl('/posts') }}">
                    {{ __('frontend.homepage.news.button') }}
                </x-primary-button>
            </div>
        </div>
    </section>
</x-app-layout>
