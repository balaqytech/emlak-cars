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
            <div>
                <span
                    class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-primary text-white">
                    <x-icons.tag class="size-4" />
                    {{ $post->category->name }}
                </span>
            </div>
            <h1 class="text-5xl font-bold text-slate-800">{{ $post->title }}</h1>
            <div class="text-sm mt-2">
                <p>{{ __('frontend.posts.published_at') }} <time
                        datetime="{{ $post->published_at }}">{{ $post->published_at->format('d/m/Y') }}</time></p>
            </div>
        </header>

        <section class="prose max-w-none">
            {!! $post->content !!}
        </section>

        @if ($post->video)
            <section class="mt-12">
                <div class="wrapper">
                    <div class="h-[60vh]">
                        <iframe src="{{ str_replace('watch?v=', 'embed/', $post->video) }}" frameborder="0" allowfullscreen
                            class="w-full h-full"></iframe>
                    </div>
                </div>
            </section>
        @endif
    </article>

</x-app-layout>
