<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ErrorPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_404_page_is_rendered_for_unknown_route(): void
    {
        $response = $this->get('/route-inexistante-cdc-test');

        $response->assertStatus(404);
        $response->assertSee('404', false);
        $response->assertSee('Page introuvable', false);
    }

    public function test_403_page_when_user_views_foreign_order(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($intruder)->get(route('orders.show', $order));

        $response->assertStatus(403);
        $response->assertSee('403', false);
        $response->assertSee('Accès refusé', false);
    }
}
