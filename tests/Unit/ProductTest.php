<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_be_created()
    {
        $category = Category::create([
            'name' => 'Test',
            'slug' => 'test'
        ]);

        $product = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'category_id' => $category->id,
            'price' => 99.99,
            'stock' => 10,
            'description' => 'Test',
            'is_active' => true
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 99.99
        ]);
    }

    public function test_product_has_category()
    {
        $category = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics'
        ]);

        $product = Product::create([
            'name' => 'Laptop',
            'slug' => 'laptop',
            'category_id' => $category->id,
            'price' => 1000,
            'stock' => 5
        ]);

        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertEquals('Electronics', $product->category->name);
    }

    public function test_product_can_be_deactivated()
    {
        $category = Category::create(['name' => 'Test', 'slug' => 'test']);

        $product = Product::create([
            'name' => 'Test',
            'slug' => 'test',
            'category_id' => $category->id,
            'price' => 50,
            'stock' => 5,
            'is_active' => true,
        ]);

        $product->update(['is_active' => false]);

        $this->assertFalse($product->refresh()->is_active);
    }

    public function test_product_stock_can_be_decremented()
    {
        $category = Category::create(['name' => 'Test', 'slug' => 'test-2']);

        $product = Product::create([
            'name' => 'Test',
            'slug' => 'test-2',
            'category_id' => $category->id,
            'price' => 50,
            'stock' => 10,
        ]);

        $product->decrement('stock', 3);

        $this->assertEquals(7, $product->refresh()->stock);
    }
}
