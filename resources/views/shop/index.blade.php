@extends('layouts.luxury')

@section('title', 'Accueil')

@section('content')

@if(!$isFiltered)
{{-- Hero minimaliste deux colonnes --}}
<section class="pb-hero">
    <div class="pb-hero__inner">
        <div class="pb-hero__content">
            <h1 class="pb-hero__title">L'art du naturel au quotidien</h1>
            <p class="pb-hero__text">
                Des produits sélectionnés avec soin, alliant qualité, style et prix accessibles.
                Découvrez notre collection de bien-être et de beauté minimaliste.
            </p>
            <div class="pb-hero__actions">
                <a href="#produits" class="pb-btn pb-btn--primary">Découvrir la collection</a>
                <a href="#apropos" class="pb-btn pb-btn--link">En savoir plus →</a>
            </div>
            <ul class="pb-hero__features">
                <li><span class="pb-hero__feat-icon">✓</span> Sélection qualité</li>
                <li><span class="pb-hero__feat-icon">✓</span> Ingrédients éprouvés</li>
                <li><span class="pb-hero__feat-icon">✓</span> Service fiable</li>
                <li><span class="pb-hero__feat-icon">✓</span> Emballage durable</li>
            </ul>
        </div>
        <div class="pb-hero__visual">
            <img src="{{ asset('images/arriere-plan-accueil.png') }}" alt="Collection bien-être et beauté">
        </div>
    </div>
</section>

@include('layouts.partials.trust-marquee')

{{-- Statistiques --}}
<section class="pb-stats" id="statistiques">
    <div class="pb-stats__inner">
        <div class="pb-stats__intro">
            <h2 class="pb-section-title">Nos chiffres</h2>
            <p class="pb-section-lead">La confiance de nos clients en quelques indicateurs clés.</p>
        </div>
        <div class="pb-stats__grid">
            <div class="pb-stats__card">
                <p class="pb-stats__number">{{ $stats['products'] }}+</p>
                <p class="pb-stats__label">Produits actifs</p>
            </div>
            <div class="pb-stats__card">
                <p class="pb-stats__number">{{ $stats['orders'] }}+</p>
                <p class="pb-stats__label">Commandes livrées</p>
            </div>
            <div class="pb-stats__card">
                <p class="pb-stats__number">{{ $stats['customers'] }}+</p>
                <p class="pb-stats__label">Clients inscrits</p>
            </div>
            <div class="pb-stats__card">
                <p class="pb-stats__number">{{ $stats['categories'] }}</p>
                <p class="pb-stats__label">Catégories</p>
            </div>
        </div>
    </div>
</section>

{{-- Catégories --}}
@if($categories->isNotEmpty())
<section class="pb-categories">
    <div class="pb-categories__inner">
        <div class="pb-section-head">
            <div>
                <h2 class="pb-section-title">Acheter par catégorie</h2>
                <p class="pb-section-lead">Parcourez notre catalogue par univers.</p>
            </div>
            <a href="#produits" class="pb-btn pb-btn--link">Voir tout →</a>
        </div>
        <div class="pb-categories__grid">
            @foreach($categories->take(4) as $cat)
            <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="pb-category-card">
                <div class="pb-category-card__img">
                    @if($cat->products->first()?->image)
                        <img src="{{ asset('storage/' . $cat->products->first()->image) }}" alt="{{ $cat->name }}">
                    @else
                        <span>{{ mb_substr($cat->name, 0, 1) }}</span>
                    @endif
                </div>
                <span class="pb-category-card__name">{{ $cat->name }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- À propos --}}
<section class="pb-about" id="apropos">
    <div class="pb-about__inner">
        <div class="pb-about__content">
            <h2 class="pb-section-title">À propos de {{ config('app.name') }}</h2>
            <p>
                Nous sommes une boutique en ligne dédiée à vous offrir des produits de qualité,
                sélectionnés avec soin pour répondre à vos besoins du quotidien.
            </p>
            <p>
                Notre mission : rendre le shopping simple, agréable et accessible — avec un service
                client attentif et une expérience fluide de la découverte à la livraison.
            </p>
            <ul class="pb-about__list">
                <li>Catalogue mis à jour régulièrement</li>
                <li>Commandes suivies en temps réel</li>
                <li>Équipe à votre écoute</li>
            </ul>
            @guest
                <a href="{{ route('register') }}" class="pb-btn pb-btn--primary" style="margin-top:1.5rem">Créer un compte</a>
            @endguest
        </div>
        <div class="pb-about__visual">
            <div class="pb-about__image">
                <img src="{{ asset('images/about-beach.png') }}" alt="Reflets dorés sur l'eau — bien-être et nature">
            </div>
        </div>
    </div>
</section>
@endif

{{-- Produits --}}
<section class="pb-products" id="produits">
    <div class="pb-products__inner">
        <div class="pb-section-head" style="margin-bottom: 1.5rem;">
            <div>
                <h2 class="pb-section-title" style="margin-bottom: 0.25rem;">{{ $isFiltered ? 'Résultats' : 'Catalogue' }}</h2>
                <p class="pb-section-lead">{{ $products->total() }} produit{{ $products->total() > 1 ? 's' : '' }} disponible{{ $products->total() > 1 ? 's' : '' }}</p>
            </div>
        </div>

        <form method="GET" action="{{ route('shop') }}" class="pb-filters">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher…">
            <select name="category">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="pb-btn pb-btn--primary">Filtrer</button>
            @if($isFiltered)
                <a href="{{ route('shop') }}" class="pb-btn pb-btn--link">Réinitialiser</a>
            @endif
        </form>

        @if($products->isEmpty())
            <p class="pb-empty">Aucun produit trouvé.</p>
        @else
            <div class="pb-product-grid">
                @foreach($products as $product)
                <article class="pb-product-card">
                    <a href="{{ route('product.show', $product) }}" class="pb-product-card__img">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <span class="pb-product-card__placeholder">{{ mb_substr($product->name, 0, 1) }}</span>
                        @endif
                    </a>
                    <div class="pb-product-card__body">
                        <span class="pb-product-card__cat">{{ $product->category->name }}</span>
                        <h3 class="pb-product-card__name"><a href="{{ route('product.show', $product) }}" style="color:inherit;text-decoration:none">{{ $product->name }}</a></h3>
                        <p class="pb-product-card__price">{{ number_format($product->price, 2) }} TND</p>
                        @auth
                            @if($product->stock > 0)
                                <form method="POST" action="{{ route('cart.add', $product) }}" style="margin-top: 1rem;">
                                    @csrf
                                    <button type="submit" class="pb-btn pb-btn--primary pb-btn--sm pb-btn--block">Ajouter au panier</button>
                                </form>
                            @else
                                <span class="pb-product-card__out" style="margin-top: 1rem;">Rupture de stock</span>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="pb-btn pb-btn--outline pb-btn--sm pb-btn--block" style="margin-top: 1rem;">Se connecter</a>
                        @endauth
                    </div>
                </article>
                @endforeach
            </div>
            @if($products->hasPages())
                <div class="pb-pagination">{{ $products->links() }}</div>
            @endif
        @endif
    </div>
</section>

@include('layouts.partials.purelis-footer')

@endsection
