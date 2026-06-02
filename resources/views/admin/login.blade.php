<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin — Sage</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Jost', sans-serif;
            background: linear-gradient(135deg, #4a5d4a 0%, #3d4d3d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .admin-login-container {
            width: 100%;
            max-width: 420px;
            padding: 2rem;
        }
        .admin-login-card {
            background: white;
            border-radius: 8px;
            padding: 3rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
        }
        .admin-login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .admin-login-logo h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.5rem;
            font-style: italic;
            color: #4a5d4a;
            margin-bottom: 0.5rem;
        }
        .admin-login-logo p {
            font-size: 0.85rem;
            color: #999;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }
        .admin-login-form {
            margin-top: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .form-group input {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            font-family: 'Jost', sans-serif;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #4a5d4a;
            box-shadow: 0 0 0 3px rgba(74, 93, 74, 0.1);
        }
        .form-group input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            min-width: 1rem;
            padding: 0;
            margin: 0;
            flex-shrink: 0;
            accent-color: #4a5d4a;
        }
        .form-group--remember {
            margin-bottom: 1.25rem;
        }
        .form-group--remember label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 400;
            cursor: pointer;
            font-size: 0.9rem;
            color: #555;
            line-height: 1.4;
        }
        .admin-login-form .admin-login-btn {
            margin-top: 0.25rem;
        }
        .admin-login-btn {
            width: 100%;
            padding: 1rem;
            background: #4a5d4a;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            font-family: 'Jost', sans-serif;
            transition: background 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        .admin-login-btn:hover {
            background: #3d4d3d;
        }
        .admin-login-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #eee;
        }
        .admin-login-footer p {
            font-size: 0.9rem;
            color: #666;
        }
        .admin-login-footer a {
            color: #4a5d4a;
            text-decoration: none;
            font-weight: 500;
        }
        .admin-login-footer a:hover {
            text-decoration: underline;
        }
        .admin-error {
            background: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        .admin-success {
            background: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="admin-login-container">
        <div class="admin-login-card">
            <div class="admin-login-logo">
                <h1>Sage</h1>
                <p>Administration</p>
            </div>

            @if($errors->any())
                <div class="admin-error">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if(session('error'))
                <div class="admin-error">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="admin-success">{{ session('success') }}</div>
            @endif

            <form class="admin-login-form" method="POST" action="{{ route('admin.login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" inputmode="email" spellcheck="false">
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password">
                </div>

                <div class="form-group form-group--remember">
                    <label for="remember">
                        <input type="checkbox" id="remember" name="remember" value="1">
                        <span>Se souvenir de moi</span>
                    </label>
                </div>

                <button type="submit" class="admin-login-btn">Se connecter</button>
            </form>

            <div class="admin-login-footer">
                <p>Retour à la <a href="{{ route('shop') }}">boutique</a></p>
            </div>
        </div>
    </div>
</body>
</html>
