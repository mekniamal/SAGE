@extends('layouts.luxury-app')

@section('title', 'Gestion des commandes')
@section('footer-label', 'Administration')

@section('content')
<div class="luxury-page-header">
    <div>
        <h1 class="luxury-page-title">Commandes</h1>
        <p class="luxury-page-subtitle" style="margin-bottom:0">Gestion des commandes clients</p>
    </div>
</div>

<div class="luxury-card">
    @if($orders->isEmpty())
        <p style="text-align:center;color:var(--luxury-gray);padding:3rem 0">Aucune commande.</p>
    @else
    <table class="luxury-table">
        <thead>
            <tr>
                <th>Commande</th>
                <th>Client</th>
                <th>Date</th>
                <th>Total</th>
                <th>Articles</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td><strong>#{{ $order->id }}</strong></td>
                <td>{{ $order->user->name }}</td>
                <td style="color:var(--luxury-gray)">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td style="color:var(--luxury-accent)">{{ number_format($order->total, 2) }} TND</td>
                <td><span class="luxury-badge">{{ $order->items->count() }} article(s)</span></td>
                <td>
                    <span class="luxury-badge luxury-badge--{{ $order->status }}">
                        {{ strtoupper($order->status) }}
                    </span>
                </td>
                <td style="white-space:nowrap">
                    <a href="{{ route('admin.orders.show', $order) }}" class="luxury-btn luxury-btn--outline luxury-btn--sm">Voir</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($orders->hasPages())
        <div class="luxury-pagination">{{ $orders->links() }}</div>
    @endif
    @endif
</div>
@endsection
