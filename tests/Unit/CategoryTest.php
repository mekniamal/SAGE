<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_can_be_created()
    {
        $category = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronic items'
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Electronics'
        ]);
    }

    public function test_category_has_many_products()
    {
        $category = Category::create([
            'name' => 'Books',
            'slug' => 'books'
        ]);

        Product::create([
            'name' => 'Book 1',
            'slug' => 'book-1',
            'category_id' => $category->id,
            'price' => 20,
            'stock' => 5
        ]);

        Product::create([
            'name' => 'Book 2',
            'slug' => 'book-2',
            'category_id' => $category->id,
            'price' => 25,
            'stock' => 3
        ]);

        $this->assertEquals(2, $category->products()->count());
    }

    public function test_category_can_be_updated()
    {
        $category = Category::create([
            'name' => 'Old Name',
            'slug' => 'old-name'
        ]);

        $category->update(['name' => 'New Name']);

        $this->assertEquals('New Name', $category->refresh()->name);
    }

    public function test_category_can_be_deleted()
    {
        $category = Category::create([
            'name' => 'To Delete',
            'slug' => 'to-delete'
        ]);

        $id = $category->id;
        $category->delete();

        $this->assertNull(Category::find($id));
    }
}
