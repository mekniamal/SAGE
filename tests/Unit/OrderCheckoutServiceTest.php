<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderCheckoutService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class OrderCheckoutServiceTest extends TestCase
{
    use RefreshDatabase;

    private OrderCheckoutService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new OrderCheckoutService;
    }

    public function test_place_order_creates_order_and_decrements_stock(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 50,
            'stock' => 5,
            'is_active' => true,
        ]);

        $cart = [
            $product->id => [
                'id' => $product->id,
                'quantity' => 2,
            ],
        ];

        $order = $this->service->placeOrder($user, $cart, [
            'address' => '1 rue Test',
            'phone' => '12345678',
        ]);

        $this->assertEquals(100, (float) $order->total);
        $this->assertEquals('pending', $order->status);
        $this->assertEquals(3, $product->fresh()->stock);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    public function test_empty_cart_throws_validation_exception(): void
    {
        $user = User::factory()->create();

        $this->expectException(ValidationException::class);

        $this->service->placeOrder($user, [], [
            'address' => '1 rue Test',
            'phone' => '12345678',
        ]);
    }

    public function test_insufficient_stock_throws_validation_exception(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'stock' => 1,
            'is_active' => true,
        ]);

        $this->expectException(ValidationException::class);

        $this->service->placeOrder($user, [
            $product->id => ['id' => $product->id, 'quantity' => 5],
        ], [
            'address' => '1 rue Test',
            'phone' => '12345678',
        ]);
    }

    public function test_inactive_product_throws_validation_exception(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'is_active' => false,
            'stock' => 10,
        ]);

        $this->expectException(ValidationException::class);

        $this->service->placeOrder($user, [
            $product->id => ['id' => $product->id, 'quantity' => 1],
        ], [
            'address' => '1 rue Test',
            'phone' => '12345678',
        ]);
    }
}
