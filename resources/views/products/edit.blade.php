@extends('layouts.luxury-app')

@section('title', 'Modifier produit')

@section('content')
<h1 class="luxury-page-title">Modifier</h1>
<p class="luxury-page-subtitle">{{ $product->name }}</p>

<div class="luxury-card" style="max-width:700px">
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="luxury-form-group">
            <label>Nom du produit *</label>
            <input type="text" name="name" value="{{ $product->name }}" required>
        </div>
        <div class="luxury-form-row">
            <div class="luxury-form-group">
                <label>Catégorie *</label>
                <select name="category_id" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="luxury-form-group">
                <label>Prix (TND) *</label>
                <input type="number" name="price" value="{{ $product->price }}" step="0.01" min="0" required>
            </div>
        </div>
        <div class="luxury-form-group">
            <label>Description</label>
            <textarea name="description" rows="3">{{ $product->description }}</textarea>
        </div>
        <div class="luxury-form-row">
            <div class="luxury-form-group">
                <label>Stock *</label>
                <input type="number" name="stock" value="{{ $product->stock }}" min="0" required>
            </div>
            <div class="luxury-form-group">
                <label>Nouvelle image</label>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="luxury-thumb" style="width:60px;height:60px;margin-bottom:0.5rem;display:block" alt="">
                @endif
                <input type="file" name="image" accept="image/*">
            </div>
        </div>
        <div class="luxury-form-group">
            <label style="display:flex;align-items:center;gap:0.5rem;text-transform:none;letter-spacing:0">
                <input type="checkbox" name="is_active" {{ $product->is_active ? 'checked' : '' }} style="width:auto"> Produit actif
            </label>
        </div>
        <div style="display:flex;gap:0.75rem">
            <button type="submit" class="luxury-btn">Mettre à jour</button>
            <a href="{{ route('admin.products.index') }}" class="luxury-btn luxury-btn--outline">Annuler</a>
        </div>
    </form>
</div>
@endsection
