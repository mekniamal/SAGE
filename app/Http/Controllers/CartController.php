<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCartRequest;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart     = session()->get('cart', []);
        $total    = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Product $product)
    {
        if ($product->stock <= 0) {
            return back()->with('error', 'Ce produit est en rupture de stock !');
        }

        $cart = session()->get('cart', []);
        $id   = $product->id;

        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] >= $product->stock) {
                return back()->with('error', 'Stock insuffisant !');
            }
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'image'    => $product->image,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Produit ajouté au panier !');
    }

    public function update(UpdateCartRequest $request, Product $product)
    {
        $quantity = (int) $request->validated('quantity');
        $cart = session()->get('cart', []);
        $id   = $product->id;

        if (isset($cart[$id])) {
            if ($quantity <= 0) {
                unset($cart[$id]);
            } else {
                $cart[$id]['quantity'] = min($quantity, $product->stock);
            }
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Panier mis à jour !');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        unset($cart[$product->id]);
        session()->put('cart', $cart);
        return back()->with('success', 'Produit retiré du panier !');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Panier vidé !');
    }
}