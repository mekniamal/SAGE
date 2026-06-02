@extends('layouts.luxury-app')

@section('title', 'Catégories')
@section('footer-label', 'Administration')

@section('content')
<div class="luxury-page-header">
    <div>
        <h1 class="luxury-page-title">Catégories</h1>
        <p class="luxury-page-subtitle" style="margin-bottom:0">Organisation du catalogue</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="luxury-btn">Nouvelle catégorie</a>
</div>

<div class="luxury-card">
    @if($categories->isEmpty())
        <p style="text-align:center;color:var(--luxury-gray);padding:3rem 0">Aucune catégorie.</p>
    @else
    <table class="luxury-table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Produits</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td><strong>{{ $category->name }}</strong></td>
                <td style="color:var(--luxury-gray)">{{ $category->description ?? '—' }}</td>
                <td><span class="luxury-badge">{{ $category->products_count }} produits</span></td>
                <td style="white-space:nowrap">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="luxury-btn luxury-btn--outline luxury-btn--sm">Modifier</a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="luxury-btn luxury-btn--danger luxury-btn--sm" onclick="return confirm('Supprimer ?')">Suppr.</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($categories->hasPages())
        <div class="luxury-pagination">{{ $categories->links() }}</div>
    @endif
    @endif
</div>
@endsection
