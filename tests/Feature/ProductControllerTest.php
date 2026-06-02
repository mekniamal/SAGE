<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        $this->admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        $this->category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category'
        ]);
    }

    public function test_admin_can_view_products_list()
    {
        $response = $this->actingAs($this->admin)->get('/admin/products');
        $response->assertStatus(200);
        $response->assertViewIs('products.index');
    }

    public function test_admin_can_create_product_form()
    {
        $response = $this->actingAs($this->admin)->get('/admin/products/create');
        $response->assertStatus(200);
        $response->assertViewIs('products.create');
    }

    public function test_admin_can_store_product()
    {
        $data = [
            'name' => 'Test Product',
            'category_id' => $this->category->id,
            'price' => 99.99,
            'stock' => 10,
            'description' => 'Test Description',
            'is_active' => true
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/products', $data);

        $response->assertRedirect('/admin/products');
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 99.99
        ]);
    }

    public function test_admin_can_edit_product()
    {
        $product = Product::create([
            'name' => 'Original',
            'slug' => 'original',
            'category_id' => $this->category->id,
            'price' => 50,
            'stock' => 5,
            'is_active' => true
        ]);

        $response = $this->actingAs($this->admin)
            ->get('/admin/products/' . $product->id . '/edit');

        $response->assertStatus(200);
        $response->assertViewIs('products.edit');
    }

    public function test_admin_can_update_product()
    {
        $product = Product::create([
            'name' => 'Original',
            'slug' => 'original',
            'category_id' => $this->category->id,
            'price' => 50,
            'stock' => 5,
            'is_active' => true
        ]);

        $data = [
            'name' => 'Updated',
            'category_id' => $this->category->id,
            'price' => 75,
            'stock' => 8,
            'is_active' => true
        ];

        $response = $this->actingAs($this->admin)
            ->put('/admin/products/' . $product->id, $data);

        $response->assertRedirect('/admin/products');
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated',
            'price' => 75
        ]);
    }

    public function test_admin_can_delete_product()
    {
        $product = Product::create([
            'name' => 'To Delete',
            'slug' => 'to-delete',
            'category_id' => $this->category->id,
            'price' => 50,
            'stock' => 5
        ]);

        $response = $this->actingAs($this->admin)
            ->delete('/admin/products/' . $product->id);

        $response->assertRedirect('/admin/products');
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_non_admin_cannot_access_product_management()
    {
        $user = User::create([
            'name' => 'User',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);

        $response = $this->actingAs($user)->get('/admin/products');
        $response->assertRedirect(route('shop'));
    }

    public function test_product_validation_required_fields()
    {
        $response = $this->actingAs($this->admin)
            ->post('/admin/products', [
                'name' => '',
                'price' => ''
            ]);

        $response->assertSessionHasErrors(['name', 'price']);
    }
}
