<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopFilterRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Page boutique publique
    public function shop(ShopFilterRequest $request)
    {
        $filters = $request->validated();
        $query = Product::with('category')->where('is_active', true);

        if (! empty($filters['category'])) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $filters['category']));
        }

        if (! empty($filters['search'])) {
            $query->where('name', 'like', '%'.$filters['search'].'%');
        }

        $products   = $query->latest()->paginate(12);
        $categories = Category::withCount('products')
            ->with(['products' => fn ($q) => $q->whereNotNull('image')->limit(1)])
            ->get();

        $stats = [
            'products'   => Product::where('is_active', true)->count(),
            'orders'     => Order::where('status', '!=', 'cancelled')->count(),
            'customers'  => User::count(),
            'categories' => $categories->count(),
        ];

        $heroProduct = Product::where('is_active', true)->whereNotNull('image')->latest()->first();

        $isFiltered = ! empty($filters['search']) || ! empty($filters['category']);

        return view('shop.index', compact('products', 'categories', 'stats', 'heroProduct', 'isFiltered'));
    }

    // Détail produit
    public function show(Product $product)
    {
        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)->get();
        return view('shop.show', compact('product', 'related'));
    }

    // Admin - liste
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    // Admin - formulaire création
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // Admin - enregistrer
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'        => $data['name'],
            'slug'        => Str::slug($data['name']),
            'category_id' => $data['category_id'],
            'price'       => $data['price'],
            'stock'       => $data['stock'],
            'description' => $data['description'] ?? null,
            'image'       => $imagePath,
            'is_active'   => $request->has('is_active'),
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit ajouté avec succès !');
    }

    // Admin - formulaire édition
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // Admin - mettre à jour
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $imagePath = $product->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'        => $data['name'],
            'slug'        => Str::slug($data['name']),
            'category_id' => $data['category_id'],
            'price'       => $data['price'],
            'stock'       => $data['stock'],
            'description' => $data['description'] ?? null,
            'image'       => $imagePath,
            'is_active'   => $request->has('is_active'),
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit mis à jour !');
    }

    // Admin - supprimer
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Produit supprimé !');
    }
}