@php
    use RalphJSmit\Laravel\SEO\Support\SEOData;
    use RalphJSmit\Laravel\SEO\SchemaCollection;
    use RalphJSmit\Laravel\SEO\Support\AlternateTag;
    use Panakour\FilamentFlatPage\Facades\FilamentFlatPage;

    $calculator = FilamentFlatPage::get('calculator.json', 'activate');

    $SEO = new SEOData(
        title: __('frontend.calculator.page_title'),
        description: __('frontend.calculator.page_description'),
        image: asset('storage/' . general_settings('site_banner')),
        url: localizedUrl('calculator'),
        robots: 'index, follow',
        alternates: collect(config('app.locales'))
            ->map(function ($locale) {
                return new AlternateTag($locale, localizedUrl('calculator', $locale));
            })
            ->all(),
        schema: SchemaCollection::make()->add(
            fn() => [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => __('frontend.calculator.page_title'),
                'description' => __('frontend.calculator.page_description'),
                'image' => asset('storage/' . general_settings('site_banner')),
                'url' => localizedUrl('calculator'),
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
        {{ __('frontend.calculator.page_title') }}
    </x-slot>

    @if ($calculator)
        <livewire:installment-calculator />
    @else
        <section>
            <div class="wrapper py-24">
                <div class="lg:col-span-2">
                    <livewire:cash-purchase-application-form method="installment" />
                </div>
            </div>
        </section>
    @endif

</x-page-layout>
