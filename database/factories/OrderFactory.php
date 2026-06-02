<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'total' => fake()->randomFloat(2, 20, 500),
            'status' => 'pending',
            'address' => fake()->streetAddress(),
            'phone' => fake()->phoneNumber(),
            'notes' => null,
        ];
    }
}
