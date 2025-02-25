@php
    $posts = \App\Models\Post::latest()->paginate(9);
@endphp

<x-page-layout>
    <x-slot name="title">
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
                {{ $posts->links() }}
            </div>
        </div>
    </section>
</x-page-layout>
