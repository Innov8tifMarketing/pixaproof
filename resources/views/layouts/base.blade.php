<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('partials.google-tag-manager-head')
    @include('partials.google-analytics')

    @hasSection('title')
        <title>@yield('title') - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    {{-- Meta Description --}}
    @hasSection('description')
        <meta name="description" content="@yield('description')">
    @else
        <meta name="description"
            content="PixaProof verifies image authenticity at the point of capture — stopping fraudulent photos, AI-generated documents, and tampered evidence before they enter your workflow.">
    @endif

    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    @hasSection('title')
        <meta property="og:title" content="@yield('title') - {{ config('app.name') }}">
    @else
        <meta property="og:title" content="{{ config('app.name') }}">
    @endif
    @hasSection('description')
        <meta property="og:description" content="@yield('description')">
    @else
        <meta property="og:description"
            content="PixaProof verifies image authenticity at the point of capture — stopping fraudulent photos, AI-generated documents, and tampered evidence before they enter your workflow.">
    @endif
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/og-image.webp') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    @hasSection('title')
        <meta name="twitter:title" content="@yield('title') - {{ config('app.name') }}">
    @else
        <meta name="twitter:title" content="{{ config('app.name') }}">
    @endif
    @hasSection('description')
        <meta name="twitter:description" content="@yield('description')">
    @else
        <meta name="twitter:description"
            content="PixaProof verifies image authenticity at the point of capture — stopping fraudulent photos, AI-generated documents, and tampered evidence before they enter your workflow.">
    @endif
    <meta name="twitter:image" content="{{ asset('images/og-image.webp') }}">

    {{-- Favicons --}}

    <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="Pixaproof" />
    <link rel="manifest" href="{{ asset('site.webmanifest') }}" />

    <!-- Fonts: Inter (via @fontsource) -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @livewireScripts

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @include('partials.google-tag-manager-body')

    @yield('body')
</body>

</html>
