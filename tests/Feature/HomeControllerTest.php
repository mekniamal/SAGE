<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('home');
    }

    public function test_home_page_shows_stats()
    {
        $category = Category::create(['name' => 'Test', 'slug' => 'test']);
        Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'category_id' => $category->id,
            'price' => 100,
            'stock' => 10,
            'is_active' => true,
        ]);

        $response = $this->get('/');
        $response->assertViewHas('stats');
        $this->assertArrayHasKey('products', $response['stats']);
        $this->assertArrayHasKey('categories', $response['stats']);
        $this->assertArrayHasKey('clients', $response['stats']);
    }

    public function test_shop_page_loads()
    {
        $response = $this->get('/shop');
        $response->assertStatus(200);
    }
}
