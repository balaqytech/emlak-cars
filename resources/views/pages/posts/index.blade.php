@php
    $posts = \App\Models\Post::latest()->paginate(9);
@endphp

<x-page-layout>
    <x-slot name="title">
        {{ __('frontend.posts') }}
    </x-slot>

    <section class="py-20">
        <div class="wrapper">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($posts as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        </div>
    </section>
</x-page-layout>
