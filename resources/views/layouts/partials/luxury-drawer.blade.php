<div class="luxury-drawer" :class="{ 'is-open': menuOpen }" @keydown.escape.window="menuOpen = false">
    <div class="luxury-drawer__backdrop" @click="menuOpen = false"></div>
    <aside class="luxury-drawer__panel">
        <div class="luxury-drawer__top">
            <div class="luxury-drawer__contact">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                <span>Nouveautés</span>
                <strong>+216 00 000 000</strong>
            </div>
            <button type="button" class="luxury-drawer__close" @click="menuOpen = false" aria-label="Fermer">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
        </div>

        <nav class="luxury-drawer__nav">
            <a href="{{ route('shop') }}" class="luxury-drawer__link {{ request()->routeIs('shop') && !request('category') ? 'is-active' : '' }}" @click="menuOpen = false">Accueil</a>
            <a href="{{ route('shop') }}#apropos" class="luxury-drawer__link" @click="menuOpen = false">À propos</a>

            <div class="luxury-drawer__group">
                <button type="button" class="luxury-drawer__link luxury-drawer__link--toggle" :class="{ 'is-active': portfolioOpen }" @click="portfolioOpen = !portfolioOpen">
                    <span>Collections</span>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" :style="portfolioOpen ? 'transform: rotate(180deg)' : ''"><path d="M6 9l6 6 6-6"/></svg>
                </button>
                <div class="luxury-drawer__sub" x-show="portfolioOpen" x-transition>
                    <a href="{{ route('shop') }}" class="luxury-drawer__sublink {{ !request('category') && request()->routeIs('shop') ? 'is-accent' : '' }}" @click="menuOpen = false">Tout voir</a>
                    @foreach($categories ?? [] as $cat)
                        <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="luxury-drawer__sublink {{ request('category') === $cat->slug ? 'is-accent' : '' }}" @click="menuOpen = false">{{ $cat->name }}</a>
                    @endforeach
                </div>
            </div>

            @auth
                <a href="{{ route('cart.index') }}" class="luxury-drawer__link {{ request()->routeIs('cart.*') ? 'is-active' : '' }}" @click="menuOpen = false">
                    Panier
                    @if(session('cart'))
                        ({{ array_sum(array_column(session('cart'), 'quantity')) }})
                    @endif
                </a>
                <a href="{{ route('user.orders.index') }}" class="luxury-drawer__link {{ request()->routeIs('user.orders.*', 'orders.*') ? 'is-active' : '' }}" @click="menuOpen = false">Mes commandes</a>
                <a href="{{ route('chat.index') }}" class="luxury-drawer__link {{ request()->routeIs('chat.*') ? 'is-active' : '' }}" @click="menuOpen = false">Assistant IA</a>

                @if(auth()->user()->role === 'admin')
                    <div class="luxury-drawer__group">
                        <button type="button" class="luxury-drawer__link luxury-drawer__link--toggle" :class="{ 'is-active': adminOpen }" @click="adminOpen = !adminOpen">
                            <span>Administration</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" :style="adminOpen ? 'transform: rotate(180deg)' : ''"><path d="M6 9l6 6 6-6"/></svg>
                        </button>
                        <div class="luxury-drawer__sub" x-show="adminOpen" x-transition>
                            <a href="{{ route('admin.dashboard') }}" class="luxury-drawer__sublink {{ request()->routeIs('admin.dashboard') ? 'is-accent' : '' }}" @click="menuOpen = false">Dashboard</a>
                            <a href="{{ route('admin.products.index') }}" class="luxury-drawer__sublink {{ request()->routeIs('admin.products.*') ? 'is-accent' : '' }}" @click="menuOpen = false">Produits</a>
                            <a href="{{ route('admin.categories.index') }}" class="luxury-drawer__sublink {{ request()->routeIs('admin.categories.*') ? 'is-accent' : '' }}" @click="menuOpen = false">Catégories</a>
                            <a href="{{ route('admin.orders.index') }}" class="luxury-drawer__sublink {{ request()->routeIs('admin.orders.*') ? 'is-accent' : '' }}" @click="menuOpen = false">Commandes</a>
                        </div>
                    </div>
                @else
                    <a href="{{ route('admin.login.form') }}" class="luxury-drawer__link" style="color: #9a8877;" @click="menuOpen = false">Espace admin</a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="luxury-drawer__link luxury-drawer__link--button luxury-drawer__link--logout">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="luxury-drawer__link luxury-drawer__link--highlight" @click="menuOpen = false">Connexion</a>
                <a href="{{ route('register') }}" class="luxury-drawer__link" @click="menuOpen = false">Créer un compte</a>
                <div style="border-top: 1px solid rgba(255,255,255,0.1); margin-top: 1rem; padding-top: 1rem;">
                    <a href="{{ route('admin.login.form') }}" class="luxury-drawer__link" style="color: #9a8877; font-size: 0.8rem;" @click="menuOpen = false">Administration</a>
                </div>
            @endauth
        </nav>
    </aside>
</div>
