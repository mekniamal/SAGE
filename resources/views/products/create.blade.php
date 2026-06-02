@extends('layouts.luxury-app')

@section('title', 'Nouveau produit')

@section('content')
<h1 class="luxury-page-title">Nouveau produit</h1>
<p class="luxury-page-subtitle">Ajouter une pièce à la collection</p>

<div class="luxury-card" style="max-width:700px">
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="luxury-form-group">
            <label>Nom du produit *</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
            @error('name') <p class="luxury-error">{{ $message }}</p> @enderror
        </div>
        <div class="luxury-form-row">
            <div class="luxury-form-group">
                <label>Catégorie *</label>
                <select name="category_id" required>
                    <option value="">Choisir</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="luxury-error">{{ $message }}</p> @enderror
            </div>
            <div class="luxury-form-group">
                <label>Prix (TND) *</label>
                <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" required>
                @error('price') <p class="luxury-error">{{ $message }}</p> @enderror
            </div>
        </div>
        <div class="luxury-form-group">
            <label>Description</label>
            <textarea name="description" rows="3">{{ old('description') }}</textarea>
        </div>
        <div class="luxury-form-row">
            <div class="luxury-form-group">
                <label>Stock *</label>
                <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required>
            </div>
            <div class="luxury-form-group">
                <label>Image</label>
                <input type="file" name="image" accept="image/*">
                @error('image') <p class="luxury-error">{{ $message }}</p> @enderror
            </div>
        </div>
        <div class="luxury-form-group">
            <label style="display:flex;align-items:center;gap:0.5rem;text-transform:none;letter-spacing:0">
                <input type="checkbox" name="is_active" checked style="width:auto"> Produit actif
            </label>
        </div>
        <div style="display:flex;gap:0.75rem">
            <button type="submit" class="luxury-btn">Créer le produit</button>
            <a href="{{ route('admin.products.index') }}" class="luxury-btn luxury-btn--outline">Annuler</a>
        </div>
    </form>
</div>
@endsection
