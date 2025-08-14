@php
    use RalphJSmit\Laravel\SEO\Support\SEOData;
    use RalphJSmit\Laravel\SEO\SchemaCollection;
    use RalphJSmit\Laravel\SEO\Support\AlternateTag;
    use App\Models\Page;
    use App\Models\Post;
    use App\Models\Offer;
    use App\Models\Vehicle;

    $search = request('s', '');

    $postResults = Post::where('title', 'like', '%' . $search . '%')
        ->orWhere('content', 'like', '%' . $search . '%')
        ->orWhere('excerpt', 'like', '%' . $search . '%')
        ->orderBy('created_at', 'desc')
        ->get()
        ->each(function ($post) {
            $post->slug = 'posts/' . $post->slug;
        });

    $pageResults = Page::where('title', 'like', '%' . $search . '%')
        ->orWhere('content', 'like', '%' . $search . '%')
        ->orderBy('created_at', 'desc')
        ->get()
        ->each(function ($page) {
            $page->slug = 'page/' . $page->slug;
        });

    $offerResults = Offer::where('title', 'like', '%' . $search . '%')
        ->orWhere('content', 'like', '%' . $search . '%')
        ->orWhere('excerpt', 'like', '%' . $search . '%')
        ->orderBy('created_at', 'desc')
        ->get()
        ->each(function ($offer) {
            $offer->slug = 'offers/' . $offer->slug;
        });

    $vehicleResults = Vehicle::where('name', 'like', '%' . $search . '%')
        ->orWhere('overview', 'like', '%' . $search . '%')
        ->orWhere('features', 'like', '%' . $search . '%')
        ->orderBy('created_at', 'desc')
        ->get()
        ->each(function ($vehicle) {
            $vehicle->title = $vehicle->name;
            $vehicle->slug = 'vehicles/' . $vehicle->slug;
        });

    $results = $postResults->merge($pageResults)->merge($offerResults)->merge($vehicleResults);

    $SEO = new SEOData(
        title: __('frontend.search_result_for', ['s' => $search]),
        description: __('frontend.search_result_description', ['s' => $search]),
        image: asset('storage/' . general_settings('site_banner')),
        url: localizedUrl('/search'),
        robots: 'index, follow',
        alternates: collect(config('app.locales'))
            ->map(function ($locale) {
                return new AlternateTag($locale, localizedUrl('/search'));
            })
            ->all(),
        schema: SchemaCollection::make()->add(
            fn() => [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => __('frontend.search_result_for', ['s' => $search]),
                'description' => __('frontend.search_result_description', ['s' => $search]),
                'image' => asset('storage/' . general_settings('site_banner')),
                'url' => localizedUrl('search'),
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
        {{ __('frontend.search_result_for', ['s' => $search]) }}
    </x-slot>

    <section>
        <div class="wrapper">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 py-12">
                @forelse ($results as $result)
                    <x-search-card :post="$result" />
                @empty
                    <div class="mt-8 col-span-3">
                        <x-icons.question class="block mx-auto size-24 text-primary" />
                        <p class="text-center">{{ __('frontend.search_no_results') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

</x-page-layout>
