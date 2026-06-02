<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin — Sage</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Jost', sans-serif;
            background: #f9f7f4;
            color: #2c2c2c;
        }
        .admin-header {
            background: #4a5d4a;
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .admin-header__left {
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        .admin-header__logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            font-style: italic;
        }
        .admin-header__nav {
            display: flex;
            gap: 1rem;
        }
        .admin-header__link {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-size: 0.9rem;
            transition: background 0.3s;
        }
        .admin-header__link:hover {
            background: rgba(255,255,255,0.1);
        }
        .admin-header__user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .admin-header__logout {
            background: #3d4d3d;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            font-family: 'Jost', sans-serif;
        }
        .admin-header__logout:hover {
            background: #2a3a2a;
        }
        .admin-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: calc(100vh - 70px);
        }
        .admin-sidebar {
            background: #f0ede8;
            border-right: 1px solid #ddd;
            padding: 2rem 0;
        }
        .admin-sidebar__title {
            padding: 1rem 1.5rem;
            font-size: 0.75rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #999;
            margin-bottom: 0.5rem;
        }
        .admin-sidebar__link {
            display: block;
            padding: 0.75rem 1.5rem;
            color: #666;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }
        .admin-sidebar__link:hover,
        .admin-sidebar__link.active {
            background: #e8e4de;
            color: #4a5d4a;
            border-left-color: #4a5d4a;
        }
        .admin-main {
            padding: 2rem;
        }
        .admin-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        .admin-subtitle {
            color: #999;
            margin-bottom: 2rem;
        }
        .admin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        .admin-card {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .admin-card__value {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.5rem;
            color: #4a5d4a;
            margin-bottom: 0.5rem;
        }
        .admin-card__label {
            font-size: 0.9rem;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .admin-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .admin-btn {
            background: #4a5d4a;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-family: 'Jost', sans-serif;
            font-size: 0.9rem;
            transition: background 0.3s;
            display: inline-block;
        }
        .admin-btn:hover {
            background: #3d4d3d;
        }
        .admin-btn--outline {
            background: transparent;
            border: 1px solid #4a5d4a;
            color: #4a5d4a;
        }
        .admin-btn--outline:hover {
            background: #4a5d4a;
            color: white;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="admin-header__left">
            <div class="admin-header__logo">Sage Admin</div>
            <nav class="admin-header__nav">
                <a href="{{ route('admin.dashboard') }}" class="admin-header__link">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="admin-header__link">Produits</a>
                <a href="{{ route('admin.categories.index') }}" class="admin-header__link">Catégories</a>
                <a href="{{ route('admin.orders.index') }}" class="admin-header__link">Commandes</a>
            </nav>
        </div>
        <div class="admin-header__user">
            <span>{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('admin.logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="admin-header__logout">Déconnexion</button>
            </form>
        </div>
    </header>

    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="admin-sidebar__title">Navigation</div>
            <a href="{{ route('admin.dashboard') }}" class="admin-sidebar__link active">Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="admin-sidebar__link">Produits</a>
            <a href="{{ route('admin.categories.index') }}" class="admin-sidebar__link">Catégories</a>
            <a href="{{ route('admin.orders.index') }}" class="admin-sidebar__link">Commandes</a>
            <div class="admin-sidebar__title" style="margin-top: 2rem;">Autres</div>
            <a href="{{ route('shop') }}" class="admin-sidebar__link">Voir la boutique</a>
        </aside>

        <main class="admin-main">
            <h1 class="admin-title">Dashboard</h1>
            <p class="admin-subtitle">Bienvenue, {{ auth()->user()->name }} ! Voici un aperçu de votre boutique.</p>

            <div class="admin-grid">
                <div class="admin-card">
                    <div class="admin-card__value">{{ $stats['products'] }}</div>
                    <div class="admin-card__label">Produits</div>
                </div>
                <div class="admin-card">
                    <div class="admin-card__value">{{ $stats['categories'] }}</div>
                    <div class="admin-card__label">Catégories</div>
                </div>
                <div class="admin-card">
                    <div class="admin-card__value">{{ $stats['orders'] }}</div>
                    <div class="admin-card__label">Commandes</div>
                </div>
                <div class="admin-card">
                    <div class="admin-card__value">{{ $stats['users'] }}</div>
                    <div class="admin-card__label">Clients</div>
                </div>
            </div>

            <h2 style="font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; margin: 2rem 0 1rem;">Gestion rapide</h2>
            <div class="admin-actions">
                <a href="{{ route('admin.products.create') }}" class="admin-btn">+ Ajouter un produit</a>
                <a href="{{ route('admin.products.index') }}" class="admin-btn admin-btn--outline">Voir tous les produits</a>
                <a href="{{ route('admin.categories.index') }}" class="admin-btn admin-btn--outline">Gérer les catégories</a>
                <a href="{{ route('admin.orders.index') }}" class="admin-btn admin-btn--outline">Voir les commandes</a>
            </div>
        </main>
    </div>
</body>
</html>
