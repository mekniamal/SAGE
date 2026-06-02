<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Erreur' }} — {{ config('app.name', 'Boutique') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=Jost:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        .error-page { min-height: 70vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 2rem; }
        .error-page__code { font-family: 'Cormorant Garamond', serif; font-size: 5rem; margin: 0; line-height: 1; color: var(--luxury-accent, #c9a962); }
        .error-page__title { font-family: 'Cormorant Garamond', serif; font-size: 1.75rem; margin: 0.5rem 0 1rem; }
        .error-page__text { color: var(--luxury-gray, #666); max-width: 28rem; margin: 0 auto 1.5rem; font-size: 0.95rem; }
    </style>
</head>
<body class="luxury-site">
    <main class="error-page">
        <div>
            <p class="error-page__code">@yield('code')</p>
            <h1 class="error-page__title">@yield('message')</h1>
            <p class="error-page__text">@yield('description')</p>
            <a href="{{ route('home') }}" class="luxury-btn luxury-btn--outline">Retour à l'accueil</a>
        </div>
    </main>
</body>
</html>
