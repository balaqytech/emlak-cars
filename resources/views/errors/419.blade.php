<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('storage/' . general_settings('site_favicon')) }}" type="image/x-icon">

    <title>{{ $title ?? config('app.name', 'Laravel') }} - {{ general_settings('site_name') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    @livewireStyles
    @vite(['resources/css/app.css'])
</head>

<body class="font-sans antialiased min-h-screen text-slate-600">
    <section
        class="bg-white rounded-xl shadow-lg p-10 w-full text-center min-h-screen text-slate-600 flex flex-col items-center justify-center">
        <div class="mb-6">
            <svg class="mx-auto h-20 w-20 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 48 48">
                <circle cx="24" cy="24" r="22" stroke="currentColor" stroke-width="3" fill="#af1f23" />
                <path d="M24 16v8m0 8h.01" stroke="#fff" stroke-width="3" stroke-linecap="round" />
            </svg>
        </div>
        <h1 class="text-5xl font-extrabold text-primary mb-4">419</h1>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ __('frontend.errors.419.title') }}</h2>
        <p class="text-gray-600 mb-6">{{ __('frontend.errors.419.message') }}</p>
        <a href="{{ localizedUrl('/') }}"
            class="inline-block px-6 py-2 bg-primary text-white rounded-lg shadow hover:bg-primary transition">{{ __('frontend.errors.419.back_to_home') }}</a>
    </section>
</body>

</html>
