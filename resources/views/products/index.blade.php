@extends('layouts.luxury-app')

@section('title', 'Produits')
@section('footer-label', 'Administration')

@section('content')
<div class="luxury-page-header">
    <div>
        <h1 class="luxury-page-title">Produits</h1>
        <p class="luxury-page-subtitle" style="margin-bottom:0">Gestion du catalogue</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="luxury-btn">Nouveau produit</a>
</div>

<div class="luxury-card">
    @if($products->isEmpty())
        <p style="text-align:center;color:var(--luxury-gray);padding:3rem 0">Aucun produit.</p>
    @else
    <table class="luxury-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="luxury-thumb" alt="">
                    @else
                        <div class="luxury-thumb"></div>
                    @endif
                </td>
                <td><strong>{{ $product->name }}</strong></td>
                <td style="color:var(--luxury-gray)">{{ $product->category->name }}</td>
                <td style="color:var(--luxury-accent)">{{ number_format($product->price, 2) }} TND</td>
                <td>
                    @if($product->stock == 0)
                        <span class="luxury-stock-list__warn">Rupture</span>
                    @elseif($product->stock <= 5)
                        <span style="color:#9a6b3a">{{ $product->stock }}</span>
                    @else
                        {{ $product->stock }}
                    @endif
                </td>
                <td>{{ $product->is_active ? 'Actif' : 'Inactif' }}</td>
                <td style="white-space:nowrap">
                    <a href="{{ route('admin.products.edit', $product) }}" class="luxury-btn luxury-btn--outline luxury-btn--sm">Modifier</a>
                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="luxury-btn luxury-btn--danger luxury-btn--sm" onclick="return confirm('Supprimer ?')">Suppr.</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($products->hasPages())
        <div class="luxury-pagination">{{ $products->links() }}</div>
    @endif
    @endif
</div>
@endsection
