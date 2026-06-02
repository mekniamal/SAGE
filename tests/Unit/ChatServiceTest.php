<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Services\ChatService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChatServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_build_business_context_contains_catalog_data(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Soins', 'slug' => 'soins']);

        Product::create([
            'name' => 'Crème hydratante',
            'slug' => 'creme-hydratante',
            'category_id' => $category->id,
            'price' => 49.99,
            'stock' => 12,
            'is_active' => true,
        ]);

        $service = new ChatService;
        $context = $service->buildBusinessContext($user);

        $this->assertStringContainsString('Crème hydratante', $context);
        $this->assertStringContainsString('Produits actifs', $context);
    }

    public function test_ask_returns_message_when_api_succeeds(): void
    {
        config(['services.groq.key' => 'test-key']);

        Http::fake([
            'api.groq.com/*' => Http::response([
                'choices' => [
                    ['message' => ['content' => 'Réponse de test']],
                ],
            ], 200),
        ]);

        $service = new ChatService;
        $reply = $service->ask([
            ['role' => 'system', 'content' => 'Contexte test'],
            ['role' => 'user', 'content' => 'Bonjour'],
        ]);

        $this->assertEquals('Réponse de test', $reply);
    }

    public function test_ask_returns_friendly_message_when_api_fails(): void
    {
        config(['services.groq.key' => 'test-key']);

        Http::fake([
            'api.groq.com/*' => Http::response([], 500),
        ]);

        $service = new ChatService;
        $reply = $service->ask([
            ['role' => 'user', 'content' => 'Bonjour'],
        ]);

        $this->assertStringContainsString('indisponible', $reply);
    }
}
