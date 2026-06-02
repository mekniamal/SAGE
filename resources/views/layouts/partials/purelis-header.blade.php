{{-- Barre d'annonce premium --}}
<div class="pb-topbar">
    <div class="pb-topbar__inner">
        <div class="pb-topbar__item">
            <span class="pb-topbar__icon">🎁</span>
            <span>Livraison gratuite sur les commandes éligibles</span>
        </div>
        <div class="pb-topbar__item">
            <span class="pb-topbar__icon">✓</span>
            <span>Qualité garantie • Service fiable</span>
        </div>
        <div class="pb-topbar__item">
            <span class="pb-topbar__icon">📦</span>
            <span>Retours faciles sous 30 jours</span>
        </div>
    </div>
</div>

<header class="pb-header">
    <div class="pb-header__left">
        <button type="button" class="pb-header__menu" @click="menuOpen = true" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
        <nav class="pb-header__nav pb-header__nav--desktop">
            <a href="{{ route('shop') }}" class="pb-header__link {{ request()->routeIs('shop') && !request('category') && !request('search') ? 'is-active' : '' }}">Boutique</a>
            <a href="{{ route('shop') }}#produits" class="pb-header__link">Collections</a>
            @foreach(($categories ?? collect())->take(2) as $cat)
                <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="pb-header__link {{ request('category') === $cat->slug ? 'is-active' : '' }}">{{ $cat->name }}</a>
            @endforeach
            <a href="{{ route('shop') }}#apropos" class="pb-header__link">À propos</a>
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="pb-header__link {{ request()->routeIs('admin.*') ? 'is-active' : '' }}">Dashboard</a>
                @endif
            @endauth
        </nav>
    </div>

    <a href="{{ route('shop') }}" class="pb-header__brand">{{ strtoupper(config('app.name', 'Ma Boutique')) }}</a>

    <div class="pb-header__right">
        @auth
            <a href="{{ route('cart.index') }}" class="pb-header__icon" aria-label="Panier" style="background: #2c2c2c; color: white; padding: 0.5rem 0.75rem; border-radius: 4px; display: flex; align-items: center; gap: 0.5rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                @if(session('cart'))
                    <span class="pb-header__badge">{{ array_sum(array_column(session('cart'), 'quantity')) }}</span>
                @endif
            </a>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="pb-header__icon" aria-label="Administration">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </a>
            @else
                <a href="{{ route('user.orders.index') }}" class="pb-header__icon" aria-label="Mon compte">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </a>
                <a href="{{ route('admin.login.form') }}" class="pb-header__auth pb-header__auth--admin">Espace admin</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="pb-header__logout-form">
                @csrf
                <button type="submit" class="pb-header__auth pb-header__auth--logout">Déconnexion</button>
            </form>
        @else
            <a href="{{ route('admin.login.form') }}" class="pb-header__auth pb-header__auth--admin">Espace admin</a>
            <a href="{{ route('login') }}" class="pb-header__icon" aria-label="Connexion">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </a>
            <a href="{{ route('login') }}" class="pb-header__auth">Connexion</a>
        @endauth
    </div>
</header>
