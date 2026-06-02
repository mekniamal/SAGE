<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} — Connexion</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="luxury-site" x-data="{ menuOpen: false, portfolioOpen: false, adminOpen: false }">

    <div class="pb-topbar">
        <div class="pb-topbar__inner">
            <span>Produits sélectionnés</span>
            <span>Qualité garantie</span>
            <span>Livraison soignée</span>
        </div>
    </div>
    <header class="pb-header">
        <a href="{{ route('shop') }}" class="pb-header__brand" style="grid-column:1/-1;justify-self:center">{{ strtoupper(config('app.name', 'Ma Boutique')) }}</a>
    </header>

    <div class="luxury-auth-wrap">
        <div class="luxury-auth-box">
            {{ $slot }}
        </div>
    </div>

</body>
</html>
