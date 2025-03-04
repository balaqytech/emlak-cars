<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('storage/' . general_settings('site_favicon')) }}" type="image/x-icon">

    <title>{{ $title ?? config('app.name', 'Laravel') }} - {{ general_settings('site_name') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    @vite(['resources/css/app.css'])
</head>

<body class="font-sans antialiased min-h-screen text-slate-600">
    @include('partials.header')
    
    <main>
        {{ $slot }}
    </main>
    
    @include('partials.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @vite('resources/js/app.js')
    {{ $scripts ?? '' }}
</body>

</html>
