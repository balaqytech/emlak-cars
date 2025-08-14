@php
    use App\Models\Branch;
    use RalphJSmit\Laravel\SEO\SchemaCollection;
    use RalphJSmit\Laravel\SEO\Support\SEOData;

    $branches = Branch::all();

    $SEO = new SEOData(
        title: __('frontend.branches.page_title'),
        description: __('frontend.branches.subheading'),
        image: asset('storage/' . general_settings('site_banner')),
        url: localizedUrl('/branches'),
        schema: SchemaCollection::make()
            ->add(
                fn() => [
                    '@context' => 'https://schema.org',
                    '@type' => 'WebPage',
                    'name' => __('frontend.branches.page_title'),
                    'description' => __('frontend.branches.subheading'),
                    'url' => localizedUrl('/branches'),
                    'inLanguage' => app()->getLocale(),
                    'isPartOf' => [
                        '@type' => 'WebSite',
                        'name' => general_settings('site_name'),
                        'url' => localizedUrl('/'),
                    ],
                ],
            )
            ->add(function () use ($branches) {
                return [
                    '@context' => 'https://schema.org',
                    '@type' => 'ItemList',
                    'name' => __('frontend.branches.page_title'),
                    'itemListElement' => $branches
                        ->values()
                        ->map(
                            fn($branch, $index) => [
                                '@type' => 'ListItem',
                                'position' => $index + 1,
                                'name' => $branch->name,
                            ],
                        )
                        ->all(),
                ];
            })

            ->add(function () use ($branches) {
                return $branches
                    ->map(
                        fn($branch) => [
                            '@type' => 'https://schema.org/AutoDealer',
                            'name' => $branch->name,
                            'telephone' => $branch->telephone,
                            'address' => [
                                '@type' => 'PostalAddress',
                                'streetAddress' => $branch->address,
                                'addressLocality' => $branch->address,
                            ],
                            'openingHoursSpecification' => str($branch->working_hours)->stripTags()->toString(),
                            'sameAs' => $branch->contact_whatsapp ? ['https://wa.me/' . $branch->contact_whatsapp] : [],
                            'parentOrganization' => [
                                '@type' => 'Organization',
                                'name' => general_settings('site_name'),
                                'url' => localizedUrl('/'),
                            ],
                            'contactPoint' => [
                                '@type' => 'ContactPoint',
                                'telephone' => $branch->telephone,
                                'contactType' => 'Customer Service',
                                'url' => 'https://wa.me/' . $branch->contact_whatsapp,
                            ],
                        ],
                    )
                    ->all();
            }),
    );
@endphp

<x-page-layout>
    <x-slot name="title">
        {!! seo($SEO) !!}
    </x-slot>

    <x-slot name="pageTitle">
        {{ __('frontend.branches.page_title') }}
    </x-slot>

    <section x-data="{ mapEmbed: '{{ $branches->first()->map_embed }}' }">
        <div class="wrapper py-24">
            <h2 class="text-3xl font-bold text-center text-slate-800">{{ __('frontend.branches.heading') }}</h2>
            <p class="text-center mt-4 text-slate-600">{{ __('frontend.branches.subheading') }}</p>

            @if ($branches->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-8">
                    <div class="h-[70vh] overflow-y-scroll mt-8 p-4 space-y-8">
                        @foreach ($branches as $branch)
                            <div id="branch-details" class="bg-white shadow-lg rounded-lg p-8 cursor-pointer"
                                @click="mapEmbed = '{{ $branch->map_embed }}'">
                                <h3 class="text-xl font-bold text-slate-800">{{ $branch->name }}</h3>
                                <ul class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 text-sm text-slate-600">
                                    <li class="flex gap-x-3">
                                        <span
                                            class="size-8 flex justify-center items-center rounded-full bg-slate-50 text-primary border border-slate-200 dark:bg-blue-800/30 dark:text-blue-500">
                                            <x-icons.map-pin class="size-4" />
                                        </span>
                                        <span class="text-slate-800 dark:text-neutral-400">
                                            <b class="mb-1 block">{{ __('frontend.branches.address') }}:</b>
                                            {{ $branch->address }}
                                        </span>
                                    </li>
                                    <li class="flex gap-x-3">
                                        <span
                                            class="size-8 flex justify-center items-center rounded-full bg-slate-50 text-primary border border-slate-200 dark:bg-blue-800/30 dark:text-blue-500">
                                            <x-icons.phone class="size-4" />
                                        </span>
                                        <a href="tel:{{ $branch->contact_mobile }}"
                                            class="text-slate-800 hover:underline">
                                            <b class="mb-1 block">{{ __('frontend.branches.contact_mobile') }}:</b>
                                            <span dir="ltr">{{ $branch->contact_mobile }}</span>
                                        </a>
                                    </li>
                                    <li class="flex gap-x-3">
                                        <span
                                            class="size-8 flex justify-center items-center rounded-full bg-slate-50 text-primary border border-slate-200 dark:bg-blue-800/30 dark:text-blue-500">
                                            <x-icons.whatsapp class="size-4" />
                                        </span>
                                        <a href="https://wa.me/{{ $branch->contact_whatsapp }}" target="_blank"
                                            class="text-slate-800 hover:underline">
                                            <b class="mb-1 block">{{ __('frontend.branches.contact_whatsapp') }}:</b>
                                            {{ $branch->contact_whatsapp }}
                                        </a>
                                    </li>
                                    <li class="flex gap-x-3">
                                        <span
                                            class="size-8 shrink-0 inline-flex justify-center items-center rounded-full bg-slate-50 text-primary border border-slate-200 dark:bg-blue-800/30 dark:text-blue-500">
                                            <x-icons.clock class="size-4" />
                                        </span>
                                        <span class="text-slate-800 dark:text-neutral-400">
                                            <b class="mb-1 block">{{ __('frontend.branches.working_hours') }}:</b>
                                            <span>{{ $branch->working_hours }}</span>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                    <div class="w-full">
                        <div id="map-embed" x-html="mapEmbed"
                            class="overflow-x-auto h-full w-full object-contain object-center"></div>
                    </div>
                </div>
            @else
                <div class="mt-8">
                    <x-icons.question class="block mx-auto size-24 text-primary" />
                    <p class="text-center">{{ __('frontend.branches.no_branches') }}</p>
                </div>
            @endif
        </div>
    </section>

</x-page-layout>
