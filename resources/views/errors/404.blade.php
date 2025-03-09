<x-app-layout>
    <section class="w-full h-[80vh] flex items-center justify-center py-24">
        <div class="wrapper flex flex-col items-center gap-4 justify-center">
            <h1 class="text-9xl font-bold text-primary">404</h1>
            <h2 class="text-4xl font-bold text-slate-800">{{ __('frontend.errors.404.title') }}</h2>
            <p class="text-slate-600">{{ __('frontend.errors.404.message') }}</p>.
            <x-primary-button href="{{ localizedUrl('/') }}">{{ __('frontend.errors.back_to_home') }}</x-primary-button>
        </div>
    </section>
</x-app-layout>