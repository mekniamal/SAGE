@extends('layouts.luxury-app')

@section('title', 'Finaliser la commande')

@section('content')
<h1 class="luxury-page-title">Finaliser la commande</h1>
<p class="luxury-page-subtitle">Informations de livraison</p>

<div class="luxury-layout-3-2">
    <div class="luxury-card">
        <h2 class="luxury-card__title">Adresse de livraison</h2>
        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            <div class="luxury-form-group">
                <label>Adresse *</label>
                <textarea name="address" rows="3" required placeholder="Rue, ville, code postal…">{{ old('address') }}</textarea>
                @error('address') <p class="luxury-error">{{ $message }}</p> @enderror
            </div>
            <div class="luxury-form-group">
                <label>Téléphone *</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="+216 XX XXX XXX">
                @error('phone') <p class="luxury-error">{{ $message }}</p> @enderror
            </div>
            <div class="luxury-form-group">
                <label>Notes (optionnel)</label>
                <textarea name="notes" rows="2" placeholder="Instructions spéciales…">{{ old('notes') }}</textarea>
            </div>
            <button type="submit" class="luxury-btn luxury-btn--block">Confirmer la commande</button>
        </form>
    </div>

    <div class="luxury-card">
        <h2 class="luxury-card__title">Récapitulatif</h2>
        @foreach($cart as $item)
        <div class="luxury-summary-row">
            <span>{{ $item['name'] }} <span style="opacity:0.6">×{{ $item['quantity'] }}</span></span>
            <span>{{ number_format($item['price'] * $item['quantity'], 2) }} TND</span>
        </div>
        @endforeach
        <div class="luxury-summary-total">
            <span>Total</span>
            <span style="color:var(--luxury-accent)">{{ number_format($total, 2) }} TND</span>
        </div>
    </div>
</div>
@endsection
