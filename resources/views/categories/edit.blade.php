@extends('layouts.luxury-app')

@section('title', 'Modifier catégorie')

@section('content')
<h1 class="luxury-page-title">Modifier</h1>
<p class="luxury-page-subtitle">{{ $category->name }}</p>

<div class="luxury-card" style="max-width:600px">
    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
        @csrf @method('PUT')
        <div class="luxury-form-group">
            <label>Nom *</label>
            <input type="text" name="name" value="{{ $category->name }}" required>
        </div>
        <div class="luxury-form-group">
            <label>Description</label>
            <textarea name="description" rows="3">{{ $category->description }}</textarea>
        </div>
        <div style="display:flex;gap:0.75rem">
            <button type="submit" class="luxury-btn">Mettre à jour</button>
            <a href="{{ route('admin.categories.index') }}" class="luxury-btn luxury-btn--outline">Annuler</a>
        </div>
    </form>
</div>
@endsection
