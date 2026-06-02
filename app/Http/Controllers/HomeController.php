<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Afficher la page d'accueil publique
     */
    public function index()
    {
        $stats = [
            'products'   => Product::where('is_active', true)->count(),
            'categories' => Category::count(),
            'clients'    => User::where('role', 'user')->count(),
        ];

        return view('home', compact('stats'));
    }
}
