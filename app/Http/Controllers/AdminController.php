<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Page d'accueil admin login
    public function loginForm()
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    // Traiter la connexion admin
    public function login(AdminLoginRequest $request)
    {
        $email = $request->validated('email');

        if (Auth::attempt(
            ['email' => $email, 'password' => $request->validated('password')],
            $request->boolean('remember')
        )) {
            $user = auth()->user();
            
            if ($user->role !== 'admin') {
                Auth::logout();

                return redirect()->route('admin.login.form')
                    ->with('error', 'Accès admin refusé.');
            }

            return redirect()->route('admin.dashboard')->with('success', 'Bienvenue, administrateur !');
        }

        $hint = \App\Models\User::where('email', $email)->exists()
            ? 'Mot de passe incorrect.'
            : 'Aucun compte avec cet e-mail. Vérifiez l\'adresse (ex. mekniamal385@gmail.com).';

        return back()
            ->withInput($request->only('email'))
            ->with('error', $hint);
    }

    // Dashboard admin
    public function dashboard()
    {
        $stats = [
            'products' => \App\Models\Product::count(),
            'orders' => \App\Models\Order::count(),
            'categories' => \App\Models\Category::count(),
            'users' => \App\Models\User::where('role', 'user')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('shop')->with('success', 'Déconnexion réussie.');
    }
}
