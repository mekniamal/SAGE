<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Boutique') }} - @yield('title', 'Accueil')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f8fafc; color: #1e293b; }
        .navbar { background: #1e293b; padding: 0 30px; display: flex; align-items: center; justify-content: space-between; height: 64px; position: sticky; top: 0; z-index: 100; }
        .navbar-brand { color: #f97316; font-size: 24px; font-weight: bold; text-decoration: none; }
        .navbar-menu { display: flex; align-items: center; gap: 20px; }
        .nav-link { color: #94a3b8; text-decoration: none; padding: 8px 12px; border-radius: 6px; transition: all 0.2s; }
        .nav-link:hover { color: white; background: #334155; }
        .nav-link.active { color: white; background:#f97316; }
        .btn { padding: 8px 18px; border-radius: 8px; border: none; cursor: pointer; font-size: 14px; text-decoration: none; display: inline-block; transition: all 0.2s; }
        .btn-primary { background: #f97316; color: white; }
        .btn-primary:hover { background: #ea580c; }
        .btn-secondary { background: #334155; color: white; }
        .btn-secondary:hover { background: #475569; }
        .btn-danger { background: #dc2626; color: white; }
        .btn-danger:hover { background: #b91c1c; }
        .btn-success { background: #16a34a; color: white; }
        .btn-sm { padding: 5px 12px; font-size: 12px; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .card { background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 24px; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .badge { padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-confirmed { background: #dbeafe; color: #1e40af; }
        .badge-shipped { background: #ede9fe; color: #5b21b6; }
        .badge-delivered { background: #dcfce7; color: #166534; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 6px; font-weight: 500; color: #374151; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; background: white; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,0.1); }
        .error-text { color: #dc2626; font-size: 12px; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8fafc; padding: 12px 16px; text-align: left; font-weight: 600; color: #374151; border-bottom: 2px solid #e2e8f0; }
        td { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; }
        tr:hover td { background: #f8fafc; }
        .cart-count { background: #f97316; color: white; border-radius: 50%; width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; margin-left: 4px; }
        .sidebar { background: #1e293b; min-height: 100vh; width: 240px; position: fixed; top: 0; left: 0; padding: 20px 0; }
        .sidebar-brand { color: #f97316; font-size: 20px; font-weight: bold; padding: 0 20px 20px; border-bottom: 1px solid #334155; }
        .sidebar-link { color: #94a3b8; text-decoration: none; padding: 10px 20px; display: block; transition: all 0.2s; }
        .sidebar-link:hover, .sidebar-link.active { background: #334155; color: white; }
        .admin-content { margin-left: 240px; padding: 30px; }
    </style>
</head>
<body>
    @if(!request()->routeIs('dashboard') && !request()->routeIs('products.*') && !request()->routeIs('categories.*'))
    <!-- Navbar boutique -->
    <nav class="navbar">
        <a href="{{ route('shop') }}" class="navbar-brand">🛍️ Ma Boutique</a>
        <div class="navbar-menu">
            <a href="{{ route('shop') }}" class="nav-link {{ request()->routeIs('shop') ? 'active' : '' }}">Accueil</a>
            @auth
                <a href="{{ route('user.orders.index') }}" class="nav-link {{ request()->routeIs('user.orders.*', 'orders.*') ? 'active' : '' }}">Mes Commandes</a>
                <a href="{{ route('chat.index') }}" class="nav-link {{ request()->routeIs('chat.*') ? 'active' : '' }}">🤖 Assistant</a>
                <a href="{{ route('cart.index') }}" class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                    🛒 Panier
                    @if(session('cart'))
                        <span class="cart-count">{{ array_sum(array_column(session('cart'), 'quantity')) }}</span>
                    @endif
                </a>
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">⚙️ Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">Connexion</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">S'inscrire</a>
            @endauth
        </div>
    </nav>
    @endif

    @if(session('success'))
        <div class="container" style="margin-top: 16px;">
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="container" style="margin-top: 16px;">
            <div class="alert alert-error">❌ {{ session('error') }}</div>
        </div>
    @endif

    @yield('content')

</body>
</html>