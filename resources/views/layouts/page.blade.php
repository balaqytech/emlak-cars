<x-app-layout>
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <section class="min-h-[60vh] flex items-center justify-center bg-primary text-white" style="background-image: url('https://placehold.co/1920x600/af1f23/ff575c'); background-size: cover; background-position: center;">
        <div class="wrapper">
            <h1 class="text-3xl font-bold text-center">{{ $title }}</h1>
        </div>
    </section>

    {{ $slot }}
</x-app-layout>