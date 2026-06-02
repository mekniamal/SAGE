<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'user@test.com',
            'password' => bcrypt('password')
        ]);

        $category = Category::create(['name' => 'Test', 'slug' => 'test']);
        $this->product = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'category_id' => $category->id,
            'price' => 100,
            'stock' => 10,
            'is_active' => true
        ]);
    }

    public function test_authenticated_user_can_view_cart()
    {
        $response = $this->actingAs($this->user)->get('/cart');
        $response->assertStatus(200);
    }

    public function test_user_can_add_product_to_cart()
    {
        $response = $this->actingAs($this->user)
            ->post('/cart/add/' . $this->product->id);

        $response->assertStatus(302);
        $this->assertNotEmpty(session('cart'));
    }

    public function test_user_can_remove_product_from_cart()
    {
        // First add to cart
        $this->actingAs($this->user)
            ->post('/cart/add/' . $this->product->id);

        // Then remove
        $response = $this->actingAs($this->user)
            ->delete('/cart/remove/' . $this->product->id);

        $response->assertStatus(302);
    }

    public function test_user_can_clear_cart()
    {
        $this->actingAs($this->user)->post('/cart/add/' . $this->product->id);

        $response = $this->actingAs($this->user)->delete('/cart/clear');

        $response->assertStatus(302);
        $this->assertEmpty(session('cart', []));
    }

    public function test_unauthenticated_cannot_access_cart()
    {
        $response = $this->get('/cart');
        $response->assertRedirect('/login');
    }
}
