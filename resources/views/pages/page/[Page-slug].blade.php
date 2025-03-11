<x-app-layout>
    <x-slot name="title">
        {{ $page->title }}
    </x-slot>

    <div class="w-full h-[40dvh] lg:h-[80dvh] overflow-hidden bg-center bg-cover">
        <img loading="lazy" src="{{ asset('storage/' . $page->image) }}" alt="{{ $page->title }}"
            class="w-full h-full object-cover object-center">
    </div>
    
    <article class="max-w-4xl mx-auto p-6">
        <header
            class="flex flex-col items-center justify-center gap-4 mb-24 -mt-8 lg:-mt-36 relative bg-white p-4 lg:p-20 text-center shadow-3xl rounded-lg">
            <x-breadcrumb :items="[['label' => $page->title]]" color="slate-500" />
            <h1 class="text-3xl font-bold text-slate-800">{{ $page->title }}</h1>
        </header>

        <section class="prose max-w-none">
            {!! $page->content !!}
        </section>
    </article>

</x-app-layout>