<x-guest-layout>
    <h1>Connexion</h1>
    <p>Accédez à votre espace</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="luxury-form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="luxury-error" />
        </div>

        <div class="luxury-form-group">
            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="luxury-error" />
        </div>

        <div class="luxury-form-group">
            <label style="display:flex;align-items:center;gap:0.5rem;text-transform:none;letter-spacing:0;font-size:0.85rem;color:var(--luxury-gray)">
                <input id="remember_me" type="checkbox" name="remember" style="width:auto">
                Se souvenir de moi
            </label>
        </div>

        <button type="submit" class="luxury-btn luxury-btn--block">Se connecter</button>

        <div class="luxury-auth-links">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
            @endif
            @if (Route::has('register'))
                <br><a href="{{ route('register') }}">Créer un compte</a>
            @endif
        </div>
    </form>
</x-guest-layout>
