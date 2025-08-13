@php
    use RalphJSmit\Laravel\SEO\Support\SEOData;
    use RalphJSmit\Laravel\SEO\SchemaCollection;
    use Panakour\FilamentFlatPage\Facades\FilamentFlatPage;

    $faqs = collect(FilamentFlatPage::get('faqs.json', 'faqs'));
    $grouped_faqs = $faqs->groupBy('group')->toArray();

    $description = str(FilamentFlatPage::get('about.json', 'about_description'))->stripTags()->limit(155)->toString();
    $SEO = new SEOData(
        title: __('frontend.faqs.page_title'),
        description: $description,
        url: localizedUrl('/'),
        image: asset('storage/' . general_settings('site_banner')),
        robots: 'index,follow',
        locale: app()->getLocale(),
        schema: SchemaCollection::make()
            ->add(
                fn() => [
                    '@context' => 'https://schema.org',
                    '@type' => 'WebPage',
                    'name' => __('frontend.faqs.page_title'),
                    'description' => $description,
                    'url' => localizedUrl('/'),
                    'image' => asset('storage/' . general_settings('site_banner')),
                    'robots' => 'index,follow',
                    'locale' => app()->getLocale(),
                    'isPartOf' => [
                        '@type' => 'WebSite',
                        'name' => general_settings('site_name'),
                        'url' => localizedUrl('/'),
                    ],
                ],
            )
            ->add(function () use ($faqs) {
                return [
                    '@context' => 'https://schema.org',
                    '@type' => 'FAQPage',
                    'mainEntity' => $faqs
                        ->values()
                        ->map(function ($faq) {
                            return [
                                '@type' => 'Question',
                                'name' => $faq['question'],
                                'url' => localizedUrl('/faqs') . '#' . str($faq['question'])->slug(),
                                'acceptedAnswer' => [
                                    '@type' => 'Answer',
                                    'text' => $faq['answer'],
                                ],
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
        {{ __('frontend.faqs.page_title') }}
    </x-slot>

    <section>
        <div class="wrapper py-24">
            @foreach ($grouped_faqs as $name => $group)
                <div class="grid md:grid-cols-5 gap-10 py-12">
                    <div class="md:col-span-2">
                        <div class="max-w-xs">
                            <h2 class="text-2xl font-bold md:text-4xl md:leading-tight text-slate-800">
                                {{ $name }}</h2>
                        </div>
                    </div>
                    <div class="md:col-span-3">
                        <div class="mt-4 hs-accordion-group">
                            @foreach ($group as $faq)
                                <x-accordion :title="$faq['question']">
                                    <p>{!! str($faq['answer'])->sanitizeHtml() !!}</p>
                                </x-accordion>
                            @endforeach
                        </div>
                    </div>
                </div>
                <hr class="mt-10 border-t border-gray-200">
            @endforeach
        </div>
    </section>
</x-page-layout>
