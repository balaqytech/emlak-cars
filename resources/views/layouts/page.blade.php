<x-app-layout>
    <x-slot name="title">
        {!! $title ?? null !!}
    </x-slot>

    <section
        class="relative min-h-[60vh] flex items-center justify-center bg-primary text-white bg-cover bg-center after:content-[''] after:absolute after:inset-0 after:bg-gradient-to-r after:from-slate-950 after:to-transparent after:opacity-55 before:content-[''] before:absolute before:inset-0 before:bg-cover before:bg-center  before:bg-[url('{{ env('APP_URL') }}/images/page-title-pattern.svg')] before:opacity-15"
        style="background-image: url({{ asset('storage/' . general_settings('site_banner')) }});">

        <div class="wrapper relative z-10 flex flex-col gap-4 justify-center items-center">
            <x-breadcrumb :items="[['label' => $title]]" color="white" />
            <h1 class="text-5xl font-bold text-center">{{ $title }}</h1>
            <p class="text-center mt-4">{{ $excerpt ?? '' }}</p>
        </div>
    </section>

    {{ $slot }}
</x-app-layout>
