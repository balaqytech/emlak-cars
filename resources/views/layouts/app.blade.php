<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('storage/' . general_settings('site_favicon')) }}" type="image/x-icon">

    <title>{{ $title ?? config('app.name', 'Laravel') }} - {{ general_settings('site_name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased min-h-screen text-slate-600">
    @include('partials.header')

    <main>
        {{ $slot }}
    </main>

    {{ $scripts ?? '' }}
</body>

</html>
