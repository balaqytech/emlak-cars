@php
    use function Laravel\Folio\name;

    name('posts.show');
@endphp

<x-app-layout>
    <x-slot name="title">
        {{ $post->title }}
    </x-slot>

    <div class="w-full h-[80dvh] overflow-hidden bg-center bg-cover">
        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
            class="w-full h-full object-cover object-center">
    </div>

    <article class="max-w-4xl mx-auto p-6">
        <header
            class="flex flex-col items-center justify-center gap-4 mb-24 -mt-36 relative bg-white p-20 text-center shadow-3xl rounded-lg">
            <x-breadcrumb :items="[['label' => __('frontend.navigation.posts'), 'url' => localizedUrl('/posts')],['label' => $post->title]]" color="slate-400" />
            <h1 class="text-3xl font-bold text-slate-800 mt-4">{{ $post->title }}</h1>
            <div class=" flex flex-col md:flex-row items-center gap-2 text-sm mt-2">
                <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3">
                    <x-icons.calendar class="size-4 text-primary" />{{ __('frontend.posts.published_at') }} <time
                        datetime="{{ $post->published_at }}">{{ $post->published_at->format('d/m/Y') }}</time>
                </span>
                <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3">
                    <x-icons.tag class="size-4 text-primary" />{{ $post->category->name }}
                </span>
            </div>
        </header>

        <section class="prose max-w-none">
            {!! $post->content !!}
        </section>

        @if ($post->video)
            <section class="mt-12">
                <div class="wrapper">
                    <div class="h-[60vh]">
                        <iframe src="{{ str_replace('watch?v=', 'embed/', $post->video) }}" frameborder="0"
                            allowfullscreen class="w-full h-full"></iframe>
                    </div>
                </div>
            </section>
        @endif
    </article>

</x-app-layout>
