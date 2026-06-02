<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderCheckoutService
{
    /**
     * @param  array<int, array{id: int, quantity: int}>  $cart
     */
    public function placeOrder(User $user, array $cart, array $shipping): Order
    {
        if (empty($cart)) {
            throw ValidationException::withMessages([
                'cart' => 'Votre panier est vide.',
            ]);
        }

        return DB::transaction(function () use ($user, $cart, $shipping) {
            $total = 0;
            $lines = [];

            foreach ($cart as $item) {
                $product = Product::lockForUpdate()->find($item['id']);

                if (! $product || ! $product->is_active) {
                    throw ValidationException::withMessages([
                        'cart' => 'Un produit du panier n\'est plus disponible.',
                    ]);
                }

                $quantity = (int) $item['quantity'];

                if ($quantity < 1 || $product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'cart' => "Stock insuffisant pour « {$product->name} ».",
                    ]);
                }

                $lineTotal = $product->price * $quantity;
                $total += $lineTotal;

                $lines[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ];
            }

            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
                'status' => 'pending',
                'address' => $shipping['address'],
                'phone' => $shipping['phone'],
                'notes' => $shipping['notes'] ?? null,
            ]);

            foreach ($lines as $line) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $line['product']->id,
                    'quantity' => $line['quantity'],
                    'price' => $line['price'],
                ]);

                $line['product']->decrement('stock', $line['quantity']);
            }

            return $order->load('items.product');
        });
    }
}
