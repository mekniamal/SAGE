@extends('layouts.luxury-app')

@section('title', 'Dashboard')

@section('content')
<div class="luxury-page-header">
    <div>
        <h1 class="luxury-page-title">Dashboard</h1>
        <p class="luxury-page-subtitle" style="margin-bottom:0">Vue d'ensemble de votre boutique</p>
    </div>
</div>

<div class="luxury-stat-grid">
    <div class="luxury-stat luxury-stat--accent">
        <p class="luxury-stat__label">Total produits</p>
        <p class="luxury-stat__value">{{ $totalProducts }}</p>
    </div>
    <div class="luxury-stat">
        <p class="luxury-stat__label">Total commandes</p>
        <p class="luxury-stat__value">{{ $totalOrders }}</p>
    </div>
    <div class="luxury-stat">
        <p class="luxury-stat__label">Revenus total</p>
        <p class="luxury-stat__value">{{ number_format($totalRevenue, 2) }} <small style="font-size:1rem">TND</small></p>
    </div>
    <div class="luxury-stat">
        <p class="luxury-stat__label">Utilisateurs</p>
        <p class="luxury-stat__value">{{ $totalUsers }}</p>
    </div>
</div>

<div class="luxury-layout-2">
    <div class="luxury-card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem">
            <h2 class="luxury-card__title" style="margin:0">Dernières commandes</h2>
            <span class="luxury-badge luxury-badge--pending">{{ $pendingOrders }} en attente</span>
        </div>
        @if($recentOrders->isEmpty())
            <p style="color:var(--luxury-gray);text-align:center;padding:2rem 0">Aucune commande.</p>
        @else
        <table class="luxury-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ number_format($order->total, 2) }} TND</td>
                    <td><span class="luxury-badge luxury-badge--{{ $order->status }}">{{ strtoupper($order->status) }}</span></td>
                    <td style="color:var(--luxury-gray);font-size:0.85rem">{{ $order->created_at->diffForHumans() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <div class="luxury-card">
        <h2 class="luxury-card__title">Stock faible</h2>
        @if($lowStockProducts->isEmpty())
            <p class="luxury-alert luxury-alert--ok">Tous les produits ont un stock suffisant.</p>
        @else
            @foreach($lowStockProducts as $product)
            <div class="luxury-stock-list__item">
                <span>{{ $product->name }}</span>
                <span class="luxury-stock-list__warn">{{ $product->stock }} restants</span>
            </div>
            @endforeach
        @endif
        @if($outOfStock > 0)
            <p style="margin-top:1rem;color:var(--luxury-accent);font-size:0.85rem">{{ $outOfStock }} produit(s) en rupture de stock.</p>
        @endif
    </div>
</div>
@endsection
