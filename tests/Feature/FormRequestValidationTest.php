<?php

namespace Tests\Feature;

use App\Http\Requests\ChatMessageRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class FormRequestValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_requires_address_and_phone(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/orders', [])
            ->assertSessionHasErrors(['address', 'phone']);
    }

    public function test_chat_message_is_required(): void
    {
        $validator = Validator::make([], (new ChatMessageRequest)->rules());

        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('message'));
    }

    public function test_admin_login_validates_email(): void
    {
        $this->post('/admin/login', [
            'email' => 'invalid',
            'password' => 'secret',
        ])->assertSessionHasErrors(['email']);
    }

    public function test_category_store_requires_unique_name(): void
    {
        $admin = User::factory()->admin()->create();
        Category::factory()->create(['name' => 'Soins', 'slug' => 'soins']);

        $this->actingAs($admin)
            ->post(route('admin.categories.store'), [
                'name' => 'Soins',
            ])
            ->assertSessionHasErrors(['name']);
    }

    public function test_cart_update_requires_quantity(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $product = \App\Models\Product::factory()->create(['category_id' => $category->id]);

        $this->actingAs($user)
            ->patch(route('cart.update', $product), [])
            ->assertSessionHasErrors(['quantity']);
    }
}
