<x-app-layout>
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <section class="relative min-h-[60vh] flex items-center justify-center bg-primary text-white bg-cover bg-center after:content-[''] after:absolute after:inset-0 after:bg-slate-950 after:opacity-15" style="background-image: url({{ asset('storage/' . general_settings('site_banner')) }});">
        <div class="wrapper relative z-10">
            <h1 class="text-5xl font-bold text-center">{{ $title }}</h1>
            <p class="text-center mt-4">{{ $excerpt ?? '' }}</p>
        </div>
    </section>

    {{ $slot }}
</x-app-layout>