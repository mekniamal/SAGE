<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts  = Product::count();
        $totalOrders    = Order::count();
        $totalRevenue   = Order::where('status', '!=', 'cancelled')->sum('total');
        $totalUsers     = User::count();
        $pendingOrders  = Order::where('status', 'pending')->count();
        $lowStockProducts = Product::where('stock', '<=', 5)->where('stock', '>', 0)->get();
        $outOfStock     = Product::where('stock', 0)->count();
        $recentOrders   = Order::with('user')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalProducts', 'totalOrders', 'totalRevenue',
            'totalUsers', 'pendingOrders', 'lowStockProducts',
            'outOfStock', 'recentOrders'
        ));
    }
}