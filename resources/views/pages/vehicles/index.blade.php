@php
    use RalphJSmit\Laravel\SEO\Support\SEOData;
    use RalphJSmit\Laravel\SEO\SchemaCollection;
    use RalphJSmit\Laravel\SEO\Support\AlternateTag;

    $vehicles = \App\Models\Vehicle::latest()->paginate(9);

    $SEO = new SEOData(
        title: __('frontend.vehicles.page_title'),
        description: __('frontend.vehicles.excerpt'),
        image: asset('storage/' . general_settings('site_banner')),
        url: localizedUrl('vehicles'),
        robots: 'index, follow',
        alternates: collect(config('app.locales'))
            ->map(function ($locale) {
                return new AlternateTag($locale, localizedUrl('vehicles', $locale));
            })
            ->all(),
        schema: SchemaCollection::make()
            ->add(
                fn() => [
                    '@context' => 'https://schema.org',
                    '@type' => 'WebPage',
                    'name' => __('frontend.vehicles.page_title'),
                    'description' => __('frontend.vehicles.excerpt'),
                    'image' => asset('storage/' . general_settings('site_banner')),
                    'url' => localizedUrl('vehicles'),
                    'isPartOf' => [
                        '@type' => 'WebSite',
                        'name' => general_settings('site_name'),
                        'url' => localizedUrl('/'),
                    ],
                ],
            )
            ->add(function () use ($vehicles) {
                if ($vehicles->isEmpty()) {
                    return null;
                }

                return [
                    '@context' => 'https://schema.org',
                    '@type' => 'ItemList',
                    'name' => __('frontend.vehicles.page_title'),
                    'itemListOrder' => 'https://schema.org/ItemListOrderAscending',
                    'numberOfItems' => $vehicles->count(),
                    'itemListElement' => $vehicles
                        ->map(function ($vehicle, $index) {
                            return [
                                '@type' => 'ListItem',
                                'position' => $index + 1,
                                'name' => $vehicle->title,
                                'url' => localizedUrl('vehicles/' . $vehicle->slug),
                                'image' => asset('storage/' . $vehicle->image),
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
        {{ __('frontend.vehicles.page_title') }}
    </x-slot>

    <x-slot name="excerpt">
        {{ __('frontend.vehicles.excerpt') }}
    </x-slot>

    <section class="py-24">
        <livewire:vehicle-search />
    </section>

</x-page-layout>
