<?php

namespace Tests\Unit;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatMessageTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_chat_message_can_be_created(): void
    {
        ChatMessage::create([
            'user_id' => $this->user->id,
            'role' => 'user',
            'message' => 'Hello AI',
        ]);

        $this->assertDatabaseHas('chat_messages', [
            'message' => 'Hello AI',
            'role' => 'user',
        ]);
    }

    public function test_chat_message_has_user(): void
    {
        $message = ChatMessage::create([
            'user_id' => $this->user->id,
            'role' => 'user',
            'message' => 'Test',
        ]);

        $this->assertInstanceOf(User::class, $message->user);
        $this->assertEquals($this->user->id, $message->user->id);
    }

    public function test_chat_message_stores_assistant_role(): void
    {
        $message = ChatMessage::create([
            'user_id' => $this->user->id,
            'role' => 'assistant',
            'message' => 'I am an AI assistant',
        ]);

        $this->assertEquals('assistant', $message->role);
        $this->assertEquals('I am an AI assistant', $message->message);
    }
}
