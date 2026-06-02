<footer class="pb-footer">
    <div class="pb-footer__inner">
        <div>
            <p class="pb-footer__brand">{{ config('app.name') }}</p>
            <p class="pb-footer__text">Boutique en ligne — qualité et service.</p>
        </div>
        <div class="pb-footer__links">
            <a href="{{ route('shop') }}">Accueil</a>
            <a href="{{ route('shop') }}#apropos">À propos</a>
            <a href="{{ route('shop') }}#produits">Produits</a>
            @auth
                <a href="{{ route('user.orders.index') }}">Commandes</a>
            @else
                <a href="{{ route('login') }}">Connexion</a>
            @endauth
        </div>
        <p class="pb-footer__copy">&copy; {{ date('Y') }} {{ config('app.name') }}</p>
    </div>
</footer>
