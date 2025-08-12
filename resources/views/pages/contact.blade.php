@php
    use Panakour\FilamentFlatPage\Facades\FilamentFlatPage;
    use RalphJSmit\Laravel\SEO\Support\SEOData;
    use RalphJSmit\Laravel\SEO\SchemaCollection;

    $settings = FilamentFlatPage::all('contact.json');

    $SEO = new SEOData(
        title: __('frontend.contact.page_title'),
        description: str(__('frontend.contact.subheading'))->stripTags()->limit(155)->toString(),
        url: localizedUrl('/'),
        image: asset('storage/' . $settings['image']),
        schema: SchemaCollection::make()->add(
            fn() => [
                '@context' => 'https://schema.org',
                '@type' => 'ContactPage',
                'name' => __('frontend.contact.page_title'),
                'url' => localizedUrl('/'),
                'inLanguage' => app()->getLocale(),
                'description' => str(__('frontend.contact.subheading'))->stripTags()->limit(155)->toString(),
                'image' => asset('storage/' . $settings['image']),
                'isPartOf' => [
                    '@type' => 'WebSite',
                    'name' => general_settings('site_name'),
                    'url' => localizedUrl('/'),
                ],
            ],
        ),
    );
@endphp

<x-page-layout>
    <x-slot name="title">
        {!! seo($SEO) !!}
    </x-slot>

    <x-slot name="pageTitle">
        {{ __('frontend.contact.page_title') }}
    </x-slot>

    <section class="max-w-7xl px-4 sm:px-6 lg:px-8 py-12 lg:py-24 mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 lg:items-center gap-6 md:gap-8 lg:gap-12">
            <div class="aspect-w-16 aspect-h-6 lg:aspect-h-14 overflow-hidden bg-slate-100 rounded-2xl">
                <img loading="lazy"
                    class="group-hover:scale-105 group-focus:scale-105 transition-transform duration-500 ease-in-out object-cover rounded-2xl"
                    src="{{ asset('storage/' . $settings['image']) }}" alt="Contacts Image">
            </div>
            <!-- End Col -->

            <div class="space-y-8 lg:space-y-16">
                <div>
                    <div class="flex flex-col gap-4 mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 sm:text-4xl dark:text-white">
                            {{ __('frontend.contact.heading') }}
                        </h2>
                        <p class="mt-1 text-gray-600 dark:text-neutral-400">
                            {{ __('frontend.contact.subheading') }}
                        </p>
                    </div>
                    <!-- Grid -->
                    <div class="grid gap-4 sm:gap-6 md:gap-8 lg:gap-12">
                        <div class="flex gap-4">
                            <x-icons.clock class="shrink-0 size-6" />

                            <div class="grow">
                                <h2 class="mb-5 font-semibold text-black">
                                    {{ __('frontend.contact.opening_hours') }}
                                </h2>
                                <div class="mt-1 prose max-w-none">
                                    {!! $settings['opening_hours'][app()->getLocale()] !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Grid -->
                </div>

                <div>
                    <!-- Grid -->
                    <div class="grid sm:grid-cols-2 gap-4 sm:gap-6 md:gap-8 lg:gap-12">
                        <div class="flex gap-4">
                            <x-icons.envlope class="shrink-0 size-5" />

                            <div class="grow">
                                <p class="text-sm">
                                    {{ __('frontend.contact.email_us') }}
                                </p>
                                <p>
                                    <a class="relative inline-block font-medium text-black before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-primary hover:before:bg-black focus:outline-none focus:before:bg-black"
                                        href="mailto:{{ $settings['contact_email'] }}">
                                        {{ $settings['contact_email'] }}
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <x-icons.phone class="shrink-0 size-5" />

                            <div class="grow">
                                <p class="text-sm ">
                                    {{ __('frontend.contact.call_us') }}
                                </p>
                                <p>
                                    <a class="relative inline-block font-medium text-black before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-primary hover:before:bg-black focus:outline-none focus:before:bg-black"
                                        href="tel:{{ $settings['contact_phone'] }}">
                                        <span dir="ltr">{{ $settings['contact_phone'] }}</span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- End Grid -->
                </div>
            </div>
            <!-- End Col -->
        </div>
    </section>

    <section class="max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="max-w-7xl lg:max-w-7xl mx-auto">
            <div class="mt-12 grid items-center lg:grid-cols-2 gap-6 lg:gap-16">
                <div class="flex flex-col border rounded-xl p-4 sm:p-6 lg:p-8">
                    <h2 class="mb-8 text-xl font-semibold text-slate-800">
                        {{ __('frontend.contact.form_heading') }}
                    </h2>

                    @livewire('contact-form')
                </div>

                <div class="divide-y divide-slate-200">
                    <!-- Icon Block -->
                    <div class="flex gap-x-7 py-6">
                        <x-icons.question class="shrink-0 size-6 mt-1.5 text-slate-800" />
                        <div class="grow">
                            <h3 class="font-semibold text-slate-800">
                                {{ __('frontend.contact.more_info.about.heading') }}</h3>
                            <p class="mt-1 text-sm text-slate-500">
                                {{ __('frontend.contact.more_info.about.description') }}</p>
                            <a class="mt-2 inline-flex items-center gap-x-2 text-sm font-medium  hover:text-slate-800 focus:outline-none focus:text-slate-800"
                                href="{{ localizedUrl('/about') }}">
                                {{ __('frontend.contact.more_info.about.button') }}
                                <x-icons.arrow-left
                                    class="shrink-0 size-2.5 transition ease-in-out group-hover:translate-x-1 group-focus:translate-x-1 rtl:rotate-180" />
                            </a>
                        </div>
                    </div>
                    <!-- End Icon Block -->

                    <!-- Icon Block -->
                    <div class="flex gap-x-7 py-6">
                        <x-icons.feedback class="shrink-0 size-6 mt-1.5 text-slate-800" />
                        <div class="grow">
                            <h3 class="font-semibold text-slate-800">
                                {{ __('frontend.contact.more_info.faqs.heading') }}</h3>
                            <p class="mt-1 text-sm text-slate-500">
                                {{ __('frontend.contact.more_info.faqs.description') }}</p>
                            <a class="mt-2 inline-flex items-center gap-x-2 text-sm font-medium  hover:text-slate-800 focus:outline-none focus:text-slate-800"
                                href="{{ localizedUrl('/faqs') }}">
                                {{ __('frontend.contact.more_info.faqs.button') }}
                                <x-icons.arrow-left
                                    class="shrink-0 size-2.5 transition ease-in-out group-hover:translate-x-1 group-focus:translate-x-1 rtl:rotate-180" />
                            </a>
                        </div>
                    </div>
                    <!-- End Icon Block -->

                    <!-- Icon Block -->
                    <div class=" flex gap-x-7 py-6">
                        <x-icons.locations class="shrink-0 size-6 mt-1.5 text-slate-800" />
                        <div class="grow">
                            <h3 class="font-semibold text-slate-800">
                                {{ __('frontend.contact.more_info.branches.heading') }}</h3>
                            <p class="mt-1 text-sm text-slate-500">
                                {{ __('frontend.contact.more_info.branches.description') }}</p>
                            <a class="mt-2 inline-flex items-center gap-x-2 text-sm font-medium  hover:text-slate-800 focus:outline-none focus:text-slate-800"
                                href="{{ localizedUrl('/branches') }}">
                                {{ __('frontend.contact.more_info.branches.button') }}
                                <x-icons.arrow-left
                                    class="shrink-0 size-2.5 transition ease-in-out group-hover:translate-x-1 group-focus:translate-x-1 rtl:rotate-180" />
                            </a>
                        </div>
                    </div>
                    <!-- End Icon Block -->

                    <!-- Icon Block -->
                    <div class=" flex gap-x-7 py-6">
                        <x-icons.envlope class="shrink-0 size-6 mt-1.5 text-slate-800" />
                        <div class="grow">
                            <h3 class="font-semibold text-slate-800">
                                {{ __('frontend.contact.more_info.email.heading') }}</h3>
                            <p class="mt-1 text-sm text-slate-500">
                                {{ __('frontend.contact.more_info.email.description') }}</p>
                            <a class="mt-2 inline-flex items-center gap-x-2 text-sm font-medium  hover:text-slate-800 focus:outline-none focus:text-slate-800"
                                href="mailto:{{ $settings['contact_email'] }}">
                                {{ $settings['contact_email'] }}
                            </a>
                        </div>
                    </div>
                    <!-- End Icon Block -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Us -->
</x-page-layout>
