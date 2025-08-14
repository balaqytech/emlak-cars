@php
    use RalphJSmit\Laravel\SEO\Support\SEOData;
    use RalphJSmit\Laravel\SEO\SchemaCollection;
    use RalphJSmit\Laravel\SEO\Support\AlternateTag;
    use function Laravel\Folio\name;

    name('offers.index');

    $offers = \App\Models\Offer::latest()->paginate(9);

    $SEO = new SEOData(
        title: __('frontend.offers.page_title'),
        description: __('frontend.offers.subheading'),
        image: asset('storage/' . general_settings('site_banner')),
        url: localizedUrl('offers'),
        robots: 'index, follow',
        alternates: collect(config('app.locales'))
            ->map(function ($locale) {
                return new AlternateTag($locale, localizedUrl('offers', $locale));
            })
            ->all(),
        schema: SchemaCollection::make()
            ->add(
                fn() => [
                    '@context' => 'https://schema.org',
                    '@type' => 'WebPage',
                    'name' => __('frontend.offers.page_title'),
                    'description' => __('frontend.offers.subheading'),
                    'image' => asset('storage/' . general_settings('site_banner')),
                    'url' => localizedUrl('offers'),
                    'isPartOf' => [
                        '@type' => 'WebSite',
                        'name' => general_settings('site_name'),
                        'url' => localizedUrl('/'),
                    ],
                ],
            )
            ->add(function () use ($offers) {
                if ($offers->isEmpty()) {
                    return null;
                }

                return [
                    '@context' => 'https://schema.org',
                    '@type' => 'ItemList',
                    'name' => __('frontend.offers.page_title'),
                    'itemListOrder' => 'https://schema.org/ItemListOrderAscending',
                    'numberOfItems' => $offers->count(),
                    'itemListElement' => $offers
                        ->map(function ($offer, $index) {
                            return [
                                '@type' => 'ListItem',
                                'position' => $index + 1,
                                'name' => $offer->title,
                                'url' => localizedUrl('offers/' . $offer->slug),
                                'image' => asset('storage/' . $offer->image),
                            ];
                        })
                        ->all(),
                ];
            }),
    );
@endphp

<x-page-layout>
    <x-slot name="title">
        {!! seo($SEO) !!}
    </x-slot>

    <x-slot name="pageTitle">
        {{ __('frontend.offers.page_title') }}
    </x-slot>

    <x-slot name="excerpt">
        {{ __('frontend.offers.subheading') }}
    </x-slot>

    <section class="py-20">
        <div class="wrapper">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($offers as $offer)
                    <x-offer-card :offer="$offer" />
                @empty
                    <div class="mt-8 col-span-3">
                        <x-icons.question class="block mx-auto size-24 text-primary" />
                        <p class="text-center">{{ __('frontend.offers.no_offers') }}</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-10">
                {{ $offers->links('components.pagination') }}
            </div>
        </div>
    </section>
</x-page-layout>
