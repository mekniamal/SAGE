
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
<body class="luxury-site" x-data="{ menuOpen: false, portfolioOpen: true, adminOpen: false }" x-cloak data-auth="{{ auth()->check() ? 'true' : 'false' }}">

    @include('layouts.partials.luxury-drawer')

    @include('layouts.partials.purelis-header')

    @if(session('success'))
        <div class="luxury-flash luxury-flash--success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="luxury-flash luxury-flash--error">{{ session('error') }}</div>
    @endif

    @yield('content')

    {{-- Floating Chat Button --}}
    <button class="pb-chat-button" id="chatButton" aria-label="Ouvrir le chat" type="button">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            <circle cx="9" cy="10" r="1"></circle>
            <circle cx="12" cy="10" r="1"></circle>
            <circle cx="15" cy="10" r="1"></circle>
        </svg>
    </button>

    @stack('scripts')
</body>
</html>
