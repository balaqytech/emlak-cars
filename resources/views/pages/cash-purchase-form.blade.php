@php
    use RalphJSmit\Laravel\SEO\Support\SEOData;
    use RalphJSmit\Laravel\SEO\SchemaCollection;
    use RalphJSmit\Laravel\SEO\Support\AlternateTag;

    $SEO = new SEOData(
        title: __('frontend.cash_purchase_form.page_title'),
        description: __('frontend.cash_purchase_form.page_description'),
        image: asset('storage/' . general_settings('site_banner')),
        url: localizedUrl('cash-purchase'),
        robots: 'index, follow',
        alternates: collect(config('app.locales'))
            ->map(function ($locale) {
                return new AlternateTag($locale, localizedUrl('cash-purchase', $locale));
            })
            ->all(),
        schema: SchemaCollection::make()->add(
            fn() => [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => __('frontend.cash_purchase_form.page_title'),
                'description' => __('frontend.cash_purchase_form.page_description'),
                'image' => asset('storage/' . general_settings('site_banner')),
                'url' => localizedUrl('cash-purchase'),
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
        {{ __('frontend.cash_purchase_form.page_title') }}
    </x-slot>

    <section>
        <div class="wrapper py-24">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <livewire:cash-purchase-application-form method="cash" />
                </div>
            </div>
        </div>
    </section>
</x-page-layout>
