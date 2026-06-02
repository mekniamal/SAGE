@extends('layouts.luxury-app')

@section('title', 'Commande #' . $order->id)

@section('content')
<div class="luxury-page-header">
    <div>
        <h1 class="luxury-page-title">Commande #{{ $order->id }}</h1>
        <p class="luxury-page-subtitle" style="margin-bottom:0">{{ $order->created_at->format('d/m/Y à H:i') }}</p>
    </div>
    <span class="luxury-badge luxury-badge--{{ $order->status }}">{{ strtoupper($order->status) }}</span>
</div>

<div class="luxury-layout-2">
    <div class="luxury-card">
        <h2 class="luxury-card__title">Articles commandés</h2>
        @foreach($order->items as $item)
        <div class="luxury-cart-item">
            <div class="luxury-cart-item__img">
                @if($item->product && $item->product->image)
                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="">
                @endif
            </div>
            <div class="luxury-cart-item__info">
                <p class="luxury-cart-item__name">{{ $item->product->name ?? 'Produit supprimé' }}</p>
                <p style="color:var(--luxury-gray);font-size:0.85rem">{{ $item->quantity }} × {{ number_format($item->price, 2) }} TND</p>
            </div>
            <p style="font-weight:500">{{ number_format($item->price * $item->quantity, 2) }} TND</p>
        </div>
        @endforeach
        <div class="luxury-summary-total">
            <span>Total</span>
            <span style="color:var(--luxury-accent)">{{ number_format($order->total, 2) }} TND</span>
        </div>
    </div>

    <div>
        <div class="luxury-card">
            <h2 class="luxury-card__title">Livraison</h2>
            <p style="font-size:0.9rem;color:var(--luxury-gray);margin-bottom:0.5rem"><strong style="color:var(--luxury-black)">Adresse</strong><br>{{ $order->address }}</p>
            <p style="font-size:0.9rem;color:var(--luxury-gray);margin-bottom:0.5rem"><strong style="color:var(--luxury-black)">Téléphone</strong><br>{{ $order->phone }}</p>
            @if($order->notes)
                <p style="font-size:0.9rem;color:var(--luxury-gray)"><strong style="color:var(--luxury-black)">Notes</strong><br>{{ $order->notes }}</p>
            @endif
        </div>
    </div>
</div>

<div style="margin-top:2rem;display:flex;gap:0.75rem;flex-wrap:wrap">
    <a href="{{ route('user.orders.index') }}" class="luxury-btn luxury-btn--outline">Mes commandes</a>
    <a href="{{ route('shop') }}" class="luxury-btn">Continuer mes achats</a>
</div>
@endsection
