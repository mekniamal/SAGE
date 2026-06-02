<?php

namespace Tests\Feature;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChatControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        config(['services.groq.key' => 'test-key']);

        Http::fake([
            'api.groq.com/*' => Http::response([
                'choices' => [
                    ['message' => ['content' => 'Voici les produits disponibles.']],
                ],
            ], 200),
        ]);

        $this->user = User::factory()->create();
    }

    public function test_authenticated_user_can_view_chat(): void
    {
        $response = $this->actingAs($this->user)->get('/chat');

        $response->assertStatus(200);
    }

    public function test_unauthenticated_cannot_access_chat(): void
    {
        $response = $this->get('/chat');

        $response->assertRedirect(route('login'));
    }

    public function test_chatbot_returns_valid_json_response(): void
    {
        $response = $this->actingAs($this->user)->postJson('/chat', [
            'message' => 'Quels produits sont disponibles ?',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['reply']);

        $this->assertDatabaseHas('chat_messages', [
            'user_id' => $this->user->id,
            'role' => 'user',
            'message' => 'Quels produits sont disponibles ?',
        ]);

        $this->assertDatabaseHas('chat_messages', [
            'user_id' => $this->user->id,
            'role' => 'assistant',
        ]);
    }
}
