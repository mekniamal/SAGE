@extends('layouts.luxury-app')

@section('title', 'Commande #' . $order->id)
@section('footer-label', 'Administration')

@section('content')
<div class="luxury-page-header">
    <div>
        <h1 class="luxury-page-title">Commande #{{ $order->id }}</h1>
        <p class="luxury-page-subtitle" style="margin-bottom:0">
            Client : {{ $order->user->name }} ({{ $order->user->email }}) — {{ $order->created_at->format('d/m/Y à H:i') }}
        </p>
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
        <p style="text-align:right;font-size:1.25rem;font-weight:600;margin-top:1.5rem;color:var(--luxury-accent)">
            Total : {{ number_format($order->total, 2) }} TND
        </p>
    </div>

    <div class="luxury-card">
        <h2 class="luxury-card__title">Livraison</h2>
        <p><strong>Adresse :</strong> {{ $order->address }}</p>
        <p><strong>Téléphone :</strong> {{ $order->phone }}</p>
        @if($order->notes)
            <p><strong>Notes :</strong> {{ $order->notes }}</p>
        @endif
    </div>
</div>

<div style="margin-top:1.5rem;display:flex;gap:1rem;flex-wrap:wrap">
    <a href="{{ route('admin.orders.index') }}" class="luxury-btn luxury-btn--outline">← Retour aux commandes</a>
    <a href="{{ route('admin.dashboard') }}" class="luxury-btn luxury-btn--outline">Dashboard</a>
</div>
@endsection
