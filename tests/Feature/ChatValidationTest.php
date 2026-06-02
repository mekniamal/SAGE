<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChatValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_chat_endpoint_rejects_empty_message_via_json(): void
    {
        config(['services.groq.key' => 'test-key']);
        Http::fake();

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withHeaders(['Accept' => 'application/json'])
            ->post('/chat', []);

        $response->assertUnprocessable();
        $response->assertJsonStructure(['message', 'errors' => ['message']]);
    }
}
