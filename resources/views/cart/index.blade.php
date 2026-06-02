@extends('layouts.luxury-app')

@section('title', 'Mon Panier')

@section('content')
<h1 class="luxury-page-title">Mon Panier</h1>
<p class="luxury-page-subtitle">Vos pièces sélectionnées</p>

@if(empty($cart))
    <div class="luxury-card" style="text-align:center;padding:4rem 2rem">
        <p style="font-family:'Cormorant Garamond',serif;font-size:1.5rem;color:var(--luxury-gray);margin-bottom:1.5rem">Votre panier est vide.</p>
        <a href="{{ route('shop') }}" class="luxury-btn">Continuer mes achats</a>
    </div>
@else
<div class="luxury-layout-2">
    <div class="luxury-card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
            <h2 class="luxury-card__title" style="margin:0">Articles ({{ count($cart) }})</h2>
            <form method="POST" action="{{ route('cart.clear') }}">
                @csrf @method('DELETE')
                <button type="submit" class="luxury-btn luxury-btn--danger luxury-btn--sm">Vider le panier</button>
            </form>
        </div>

        @foreach($cart as $id => $item)
        <div class="luxury-cart-item">
            <div class="luxury-cart-item__img">
                @if($item['image'])
                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                @endif
            </div>
            <div class="luxury-cart-item__info">
                <p class="luxury-cart-item__name">{{ $item['name'] }}</p>
                <p class="luxury-cart-item__price">{{ number_format($item['price'], 2) }} TND</p>
            </div>
            <form method="POST" action="{{ route('cart.update', $id) }}">
                @csrf @method('PATCH')
                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="99"
                       style="width:56px;text-align:center;padding:0.4rem;border:1px solid var(--luxury-border)"
                       onchange="this.form.submit()">
            </form>
            <form method="POST" action="{{ route('cart.remove', $id) }}">
                @csrf @method('DELETE')
                <button type="submit" class="luxury-btn luxury-btn--outline luxury-btn--sm">Retirer</button>
            </form>
            <p style="min-width:80px;text-align:right;font-weight:500">{{ number_format($item['price'] * $item['quantity'], 2) }} TND</p>
        </div>
        @endforeach
    </div>

    <div class="luxury-card">
        <h2 class="luxury-card__title">Résumé</h2>
        @foreach($cart as $item)
        <div class="luxury-summary-row">
            <span>{{ $item['name'] }} ×{{ $item['quantity'] }}</span>
            <span>{{ number_format($item['price'] * $item['quantity'], 2) }} TND</span>
        </div>
        @endforeach
        <div class="luxury-summary-total">
            <span>Total</span>
            <span style="color:var(--luxury-accent)">{{ number_format($total, 2) }} TND</span>
        </div>
        <a href="{{ route('orders.checkout') }}" class="luxury-btn luxury-btn--block" style="margin-top:1.5rem">Passer la commande</a>
        <a href="{{ route('shop') }}" class="luxury-btn luxury-btn--outline luxury-btn--block" style="margin-top:0.75rem">Continuer mes achats</a>
    </div>
</div>
@endif
@endsection
