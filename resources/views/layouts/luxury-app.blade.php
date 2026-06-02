<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Boutique') }} — @yield('title', 'Accueil')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="luxury-site" x-data="{ menuOpen: false, portfolioOpen: false, adminOpen: {{ request()->routeIs('dashboard', 'products.*', 'categories.*', 'chat.*') ? 'true' : 'false' }} }" x-cloak>

    @include('layouts.partials.luxury-drawer')

    @include('layouts.partials.purelis-header')

    @if(session('success'))
        <div class="luxury-flash luxury-flash--success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="luxury-flash luxury-flash--error">{{ session('error') }}</div>
    @endif

    <main class="luxury-page luxury-page--app">
        <div class="luxury-page__inner">
            @yield('content')
        </div>
    </main>

    @include('layouts.partials.purelis-footer')

    @stack('scripts')
</body>
</html>
