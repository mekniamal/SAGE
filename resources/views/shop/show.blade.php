@extends('layouts.luxury')

@section('title', $product->name)

@section('content')
<div class="luxury-page-header">
    <div>
        <p style="color:var(--luxury-gray);font-size:0.85rem;margin-bottom:0.5rem">
            <a href="{{ route('shop') }}" style="color:inherit">Boutique</a>
            / {{ $product->category->name ?? '' }}
        </p>
        <h1 class="luxury-page-title">{{ $product->name }}</h1>
        <p class="luxury-page-subtitle" style="margin-bottom:0">{{ number_format($product->price, 2) }} TND</p>
    </div>
</div>

<div class="luxury-layout-2">
    <div class="luxury-card" style="padding:0;overflow:hidden">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width:100%;display:block;object-fit:cover;max-height:480px">
        @else
            <div style="padding:4rem;text-align:center;color:var(--luxury-gray)">Aucune image</div>
        @endif
    </div>

    <div class="luxury-card">
        <h2 class="luxury-card__title">Description</h2>
        <p style="line-height:1.7;color:var(--luxury-gray)">{{ $product->description ?? 'Aucune description.' }}</p>
        <p style="margin-top:1.5rem">
            <strong>Stock :</strong>
            @if($product->stock > 0)
                {{ $product->stock }} disponible(s)
            @else
                <span style="color:#b91c1c">Rupture de stock</span>
            @endif
        </p>

        @auth
            @if($product->stock > 0)
                <form method="POST" action="{{ route('cart.add', $product) }}" style="margin-top:1.5rem">
                    @csrf
                    <button type="submit" class="luxury-btn luxury-btn--block">Ajouter au panier</button>
                </form>
            @endif
        @else
            <a href="{{ route('login') }}" class="luxury-btn luxury-btn--block" style="margin-top:1.5rem">Se connecter pour acheter</a>
        @endauth

        <a href="{{ route('shop') }}" class="luxury-btn luxury-btn--outline luxury-btn--block" style="margin-top:0.75rem">Retour à la boutique</a>
    </div>
</div>

@if($related->isNotEmpty())
<section style="margin-top:3rem">
    <h2 class="luxury-card__title" style="margin-bottom:1rem">Produits similaires</h2>
    <div class="pb-product-grid">
        @foreach($related as $item)
        <article class="pb-product-card">
            <a href="{{ route('product.show', $item) }}" class="pb-product-card__img">
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                @endif
            </a>
            <div class="pb-product-card__body">
                <h3 class="pb-product-card__name">{{ $item->name }}</h3>
                <p class="pb-product-card__price">{{ number_format($item->price, 2) }} TND</p>
            </div>
        </article>
        @endforeach
    </div>
</section>
@endif

@include('layouts.partials.purelis-footer')
@endsection
