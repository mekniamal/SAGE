<x-guest-layout>
    <h1>Créer un compte</h1>
    <p>Rejoignez notre collection</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="luxury-form-group">
            <label for="name">Nom</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            <x-input-error :messages="$errors->get('name')" class="luxury-error" />
        </div>

        <div class="luxury-form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="luxury-error" />
        </div>

        <div class="luxury-form-group">
            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="luxury-error" />
        </div>

        <div class="luxury-form-group">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="luxury-error" />
        </div>

        <button type="submit" class="luxury-btn luxury-btn--block">S'inscrire</button>

        <div class="luxury-auth-links">
            <a href="{{ route('login') }}">Déjà inscrit ? Se connecter</a>
        </div>
    </form>
</x-guest-layout>
