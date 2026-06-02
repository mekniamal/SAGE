<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutOrderRequest;
use App\Models\Order;
use App\Notifications\OrderConfirmed;
use App\Services\OrderCheckoutService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private readonly OrderCheckoutService $checkoutService
    ) {}

    public function adminList()
    {
        $this->authorize('viewAny', Order::class);

        $orders = Order::with('user', 'items.product')
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Votre panier est vide !');
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('orders.checkout', compact('cart', 'total'));
    }

    public function store(CheckoutOrderRequest $request)
    {
        $cart = session()->get('cart', []);

        $order = $this->checkoutService->placeOrder(
            auth()->user(),
            $cart,
            $request->validated()
        );

        session()->forget('cart');

        try {
            auth()->user()->notify(new OrderConfirmed($order));
        } catch (\Exception $e) {
            report($e);
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Commande passée avec succès !');
    }

    public function adminShow(Order $order)
    {
        $this->authorize('view', $order);

        $order->load('items.product', 'user');

        return view('admin.orders.show', compact('order'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }
}
