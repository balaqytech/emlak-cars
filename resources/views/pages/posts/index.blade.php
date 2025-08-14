@php
    use RalphJSmit\Laravel\SEO\Support\SEOData;
    use RalphJSmit\Laravel\SEO\SchemaCollection;
    use RalphJSmit\Laravel\SEO\Support\AlternateTag;

    $posts = \App\Models\Post::orderBy('is_featured', 'desc')->orderBy('published_at', 'desc')->paginate(9);

    $SEO = new SEOData(
        title: __('frontend.posts.page_title'),
        description: __('frontend.posts.subheading'),
        image: asset('storage/' . general_settings('site_banner')),
        url: localizedUrl('posts'),
        robots: 'index, follow',
        alternates: collect(config('app.locales'))
            ->map(function ($locale) {
                return new AlternateTag($locale, localizedUrl('posts', $locale));
            })
            ->all(),
        schema: SchemaCollection::make()
            ->add(
                fn() => [
                    '@context' => 'https://schema.org',
                    '@type' => 'WebPage',
                    'name' => __('frontend.posts.page_title'),
                    'description' => __('frontend.posts.subheading'),
                    'image' => asset('storage/' . general_settings('site_banner')),
                    'url' => localizedUrl('posts'),
                    'isPartOf' => [
                        '@type' => 'WebSite',
                        'name' => general_settings('site_name'),
                        'url' => localizedUrl('/'),
                    ],
                ],
            )
            ->add(function () use ($posts) {
                if ($posts->isEmpty()) {
                    return null;
                }

                return [
                    '@context' => 'https://schema.org',
                    '@type' => 'ItemList',
                    'name' => __('frontend.posts.page_title'),
                    'itemListOrder' => 'https://schema.org/ItemListOrderAscending',
                    'numberOfItems' => $posts->count(),
                    'itemListElement' => $posts
                        ->map(function ($post, $index) {
                            return [
                                '@type' => 'ListItem',
                                'position' => $index + 1,
                                'name' => $post->title,
                                'url' => localizedUrl('posts/' . $post->slug),
                                'image' => asset('storage/' . $post->image),
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
        {{ __('frontend.posts.page_title') }}
    </x-slot>

    <section class="py-20">
        <div class="wrapper">
            @if ($posts->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>
            @else
                <div class="mt-8">
                    <x-icons.question class="block mx-auto size-24 text-primary" />
                    <p class="text-center text-slate-600">{{ __('frontend.posts.no_posts') }}</p>
                </div>
            @endif
            <div class="mt-10">
                {{ $posts->links('components.pagination') }}
            </div>
        </div>
    </section>
</x-page-layout>
