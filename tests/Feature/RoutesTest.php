<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_route_exists()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_shop_route_exists()
    {
        $response = $this->get('/shop');
        $response->assertStatus(200);
    }

    public function test_product_show_route()
    {
        $category = Category::create(['name' => 'Test', 'slug' => 'test']);
        $product = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'category_id' => $category->id,
            'price' => 100,
            'stock' => 10
        ]);

        $response = $this->get('/product/test-product');
        $response->assertStatus(200);
    }

    public function test_admin_login_route_accessible()
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

    public function test_admin_dashboard_requires_auth()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/admin/login');
    }

    public function test_admin_dashboard_requires_admin_role()
    {
        $user = User::create([
            'name' => 'User',
            'email' => 'user@test.com',
            'password' => 'password',
            'role' => 'user'
        ]);

        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertRedirect('/shop');
    }

    public function test_admin_can_access_dashboard()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => 'password',
            'role' => 'admin'
        ]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_access_cart()
    {
        $user = User::create([
            'name' => 'User',
            'email' => 'user@test.com',
            'password' => 'password',
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/cart');
        $response->assertStatus(200);
    }

    public function test_unauthenticated_cannot_access_cart()
    {
        $response = $this->get('/cart');
        $response->assertRedirect('/login');
    }
}
