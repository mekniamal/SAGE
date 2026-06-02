<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected User $admin;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);

        $this->admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        $category = Category::create(['name' => 'Test', 'slug' => 'test']);
        $this->product = Product::create([
            'name' => 'Test',
            'slug' => 'test',
            'category_id' => $category->id,
            'price' => 100,
            'stock' => 10
        ]);
    }

    public function test_user_can_view_own_orders()
    {
        $response = $this->actingAs($this->user)->get('/my-orders');
        $response->assertStatus(200);
    }

    public function test_user_can_access_checkout()
    {
        $this->actingAs($this->user)
            ->post('/cart/add/' . $this->product->id);

        $response = $this->actingAs($this->user)->get('/orders/checkout');
        $response->assertStatus(200);
    }

    public function test_user_cannot_checkout_empty_cart()
    {
        $response = $this->actingAs($this->user)->get('/orders/checkout');
        $response->assertRedirect('/cart');
    }

    public function test_user_can_place_order()
    {
        // Add to cart
        $this->actingAs($this->user)
            ->post('/cart/add/' . $this->product->id);

        // Place order
        $response = $this->actingAs($this->user)
            ->post('/orders', [
                'address' => '123 Main St',
                'phone' => '555-1234'
            ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id
        ]);
    }

    public function test_admin_can_view_all_orders()
    {
        Order::create([
            'user_id' => $this->user->id,
            'total' => 100,
            'status' => 'pending',
            'address' => '123 St',
            'phone' => '555-1234'
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/orders');
        $response->assertStatus(200);
        $response->assertViewIs('admin.orders.index');
    }

    public function test_user_cannot_access_admin_orders_list()
    {
        $response = $this->actingAs($this->user)->get('/admin/orders');
        $response->assertRedirect(route('shop'));
    }

    public function test_user_can_view_order_details()
    {
        $order = Order::create([
            'user_id' => $this->user->id,
            'total' => 100,
            'status' => 'pending',
            'address' => '123 St',
            'phone' => '555-1234'
        ]);

        $response = $this->actingAs($this->user)->get('/orders/' . $order->id);
        $response->assertStatus(200);
    }

    public function test_user_cannot_view_other_user_order()
    {
        $other_user = User::create([
            'name' => 'Other',
            'email' => 'other@test.com',
            'password' => bcrypt('password')
        ]);

        $order = Order::create([
            'user_id' => $other_user->id,
            'total' => 100,
            'status' => 'pending',
            'address' => '123 St',
            'phone' => '555-1234'
        ]);

        $response = $this->actingAs($this->user)->get('/orders/' . $order->id);
        $response->assertStatus(403);
    }
}
