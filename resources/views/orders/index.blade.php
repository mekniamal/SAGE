@extends('layouts.luxury-app')

@section('title', 'Mes commandes')

@section('content')
<h1 class="luxury-page-title">Mes commandes</h1>
<p class="luxury-page-subtitle">Historique de vos achats</p>

@if($orders->isEmpty())
    <div class="luxury-card" style="text-align:center;padding:4rem 2rem">
        <p style="font-family:'Cormorant Garamond',serif;font-size:1.5rem;color:var(--luxury-gray);margin-bottom:1.5rem">Aucune commande pour le moment.</p>
        <a href="{{ route('shop') }}" class="luxury-btn">Découvrir la collection</a>
    </div>
@else
    <div class="luxury-card">
        <table class="luxury-table">
            <thead>
                <tr>
                    <th>Commande</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td style="color:var(--luxury-gray)">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ number_format($order->total, 2) }} TND</td>
                    <td><span class="luxury-badge luxury-badge--{{ $order->status }}">{{ strtoupper($order->status) }}</span></td>
                    <td><a href="{{ route('orders.show', $order) }}" class="luxury-btn luxury-btn--outline luxury-btn--sm">Détails</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($orders->hasPages())
            <div class="luxury-pagination">{{ $orders->links() }}</div>
        @endif
    </div>
@endif
@endsection
