<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    public function test_shop_filters_by_category_slug(): void
    {
        $catA = Category::factory()->create(['name' => 'A', 'slug' => 'cat-a']);
        $catB = Category::factory()->create(['name' => 'B', 'slug' => 'cat-b']);

        Product::factory()->create([
            'name' => 'Produit A',
            'slug' => 'produit-a',
            'category_id' => $catA->id,
            'is_active' => true,
        ]);
        Product::factory()->create([
            'name' => 'Produit B',
            'slug' => 'produit-b',
            'category_id' => $catB->id,
            'is_active' => true,
        ]);

        $response = $this->get('/shop?category=cat-a');

        $response->assertStatus(200);
        $response->assertSee('Produit A');
        $response->assertDontSee('Produit B');
    }

    public function test_shop_search_filters_by_name(): void
    {
        $category = Category::factory()->create();
        Product::factory()->create([
            'name' => 'Crème solaire',
            'slug' => 'creme-solaire',
            'category_id' => $category->id,
            'is_active' => true,
        ]);
        Product::factory()->create([
            'name' => 'Huile corps',
            'slug' => 'huile-corps',
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $response = $this->get('/shop?search=Crème');

        $response->assertStatus(200);
        $response->assertSee('Crème solaire');
        $response->assertDontSee('Huile corps');
    }

    public function test_product_detail_page(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'slug' => 'mon-produit',
            'is_active' => true,
        ]);

        $this->get(route('product.show', $product))
            ->assertStatus(200)
            ->assertSee($product->name);
    }
}
