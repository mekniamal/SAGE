<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        $this->user = User::create([
            'name' => 'Regular User',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);
    }

    public function test_login_form_accessible_without_auth()
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
        $response->assertViewIs('admin.login');
    }

    public function test_login_form_redirects_authenticated_admin()
    {
        $response = $this->actingAs($this->admin)->get('/admin/login');
        $response->assertRedirect('/admin/dashboard');
    }

    public function test_admin_can_login()
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password'
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();
    }

    public function test_non_admin_cannot_login_via_admin_panel()
    {
        $response = $this->post('/admin/login', [
            'email' => 'user@test.com',
            'password' => 'password'
        ]);

        $response->assertRedirect(route('admin.login.form'));
        $response->assertSessionHas('error');
    }

    public function test_dashboard_shows_stats()
    {
        // Create test data
        $category = Category::create(['name' => 'Test Cat', 'slug' => 'test-cat']);
        Product::create([
            'name' => 'Test',
            'slug' => 'test',
            'category_id' => $category->id,
            'price' => 100,
            'stock' => 5,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
        $response->assertViewHas('stats');
    }

    public function test_non_admin_cannot_access_dashboard()
    {
        $response = $this->actingAs($this->user)->get('/admin/dashboard');
        $response->assertRedirect(route('shop'));
    }

    public function test_unauthenticated_cannot_access_dashboard()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect(route('admin.login.form'));
    }

    public function test_admin_can_logout()
    {
        $response = $this->actingAs($this->admin)
            ->post('/admin/logout');

        $response->assertRedirect('/shop');
        $this->assertGuest();
    }

    public function test_admin_login_rejects_wrong_password(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertGuest();
    }

    public function test_admin_login_normalizes_email(): void
    {
        $this->admin->update(['email' => 'admin@test.com']);

        $response = $this->post('/admin/login', [
            'email' => '  ADMIN@TEST.COM  ',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');
    }
}
