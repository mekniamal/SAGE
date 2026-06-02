<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Test',
            'email' => 'test@test.com',
            'password' => bcrypt('pass')
        ]);

        $category = Category::create(['name' => 'Test', 'slug' => 'test']);
        $this->product = Product::create([
            'name' => 'Product',
            'slug' => 'product',
            'category_id' => $category->id,
            'price' => 100,
            'stock' => 10
        ]);
    }

    public function test_order_can_be_created()
    {
        $order = Order::create([
            'user_id' => $this->user->id,
            'total' => 100,
            'status' => 'pending',
            'address' => '123 St',
            'phone' => '555-1234'
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'pending'
        ]);
    }

    public function test_order_has_user()
    {
        $order = Order::create([
            'user_id' => $this->user->id,
            'total' => 100,
            'status' => 'pending',
            'address' => '123 St',
            'phone' => '555-1234'
        ]);

        $this->assertInstanceOf(User::class, $order->user);
        $this->assertEquals($this->user->id, $order->user->id);
    }

    public function test_order_has_items()
    {
        $order = Order::create([
            'user_id' => $this->user->id,
            'total' => 100,
            'status' => 'pending',
            'address' => '123 St',
            'phone' => '555-1234'
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
            'price' => 50
        ]);

        $this->assertEquals(1, $order->items()->count());
    }

    public function test_order_status_can_be_changed()
    {
        $order = Order::create([
            'user_id' => $this->user->id,
            'total' => 100,
            'status' => 'pending',
            'address' => '123 St',
            'phone' => '555-1234'
        ]);

        $order->update(['status' => 'delivered']);

        $this->assertEquals('delivered', $order->refresh()->status);
    }
}
