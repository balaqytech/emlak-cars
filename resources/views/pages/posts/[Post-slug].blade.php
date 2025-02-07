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
                <a href="#" class="bg-primary hover:bg-slate-700 text-white rounded px-5 py-2 transition-all duration-500">{{ $post->category->name }}</a>
            </div>
            <h1 class="text-5xl font-bold text-slate-800">{{ $post->title }}</h1>
            <div class="text-sm mt-2">
                <p>{{ __('frontend.published_at') }} <time
                        datetime="{{ $post->published_at }}">{{ $post->published_at->format('d/m/Y') }}</time></p>
            </div>
        </header>

        <section class="prose max-w-none">
            {!! $post->content !!}
        </section>
    </article>

</x-app-layout>
