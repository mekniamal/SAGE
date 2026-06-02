<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
    }

    public function test_admin_can_view_categories_list()
    {
        $response = $this->actingAs($this->admin)->get('/admin/categories');
        $response->assertStatus(200);
        $response->assertViewIs('categories.index');
    }

    public function test_admin_can_create_category_form()
    {
        $response = $this->actingAs($this->admin)->get('/admin/categories/create');
        $response->assertStatus(200);
        $response->assertViewIs('categories.create');
    }

    public function test_admin_can_store_category()
    {
        $data = [
            'name' => 'New Category',
            'description' => 'Category Description'
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/categories', $data);

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', [
            'name' => 'New Category'
        ]);
    }

    public function test_category_name_must_be_unique()
    {
        Category::create([
            'name' => 'Existing',
            'slug' => 'existing'
        ]);

        $response = $this->actingAs($this->admin)
            ->post('/admin/categories', [
                'name' => 'Existing',
                'description' => 'Test'
            ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_admin_can_edit_category()
    {
        $category = Category::create([
            'name' => 'Original',
            'slug' => 'original'
        ]);

        $response = $this->actingAs($this->admin)
            ->get('/admin/categories/' . $category->id . '/edit');

        $response->assertStatus(200);
        $response->assertViewIs('categories.edit');
    }

    public function test_admin_can_update_category()
    {
        $category = Category::create([
            'name' => 'Original',
            'slug' => 'original'
        ]);

        $response = $this->actingAs($this->admin)
            ->put('/admin/categories/' . $category->id, [
                'name' => 'Updated',
                'description' => 'New Description'
            ]);

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated'
        ]);
    }

    public function test_admin_can_delete_category()
    {
        $category = Category::create([
            'name' => 'To Delete',
            'slug' => 'to-delete'
        ]);

        $response = $this->actingAs($this->admin)
            ->delete('/admin/categories/' . $category->id);

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_non_admin_cannot_manage_categories()
    {
        $user = User::create([
            'name' => 'User',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);

        $response = $this->actingAs($user)->get('/admin/categories');
        $response->assertRedirect(route('shop'));
    }
}
