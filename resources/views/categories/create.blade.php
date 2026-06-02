@extends('layouts.luxury-app')

@section('title', 'Nouvelle catégorie')

@section('content')
<h1 class="luxury-page-title">Nouvelle catégorie</h1>
<p class="luxury-page-subtitle">Ajouter une catégorie au catalogue</p>

<div class="luxury-card" style="max-width:600px">
    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        <div class="luxury-form-group">
            <label>Nom *</label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="ex: Mobilier, Décoration…">
            @error('name') <p class="luxury-error">{{ $message }}</p> @enderror
        </div>
        <div class="luxury-form-group">
            <label>Description</label>
            <textarea name="description" rows="3" placeholder="Description optionnelle…">{{ old('description') }}</textarea>
        </div>
        <div style="display:flex;gap:0.75rem">
            <button type="submit" class="luxury-btn">Créer</button>
            <a href="{{ route('admin.categories.index') }}" class="luxury-btn luxury-btn--outline">Annuler</a>
        </div>
    </form>
</div>
@endsection
