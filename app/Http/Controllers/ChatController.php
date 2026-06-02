<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatMessageRequest;
use App\Services\ChatService;

class ChatController extends Controller
{
    public function __construct(
        private readonly ChatService $chatService
    ) {}

    public function index()
    {
        $messages = auth()->user()->chatMessages()
            ->latest()
            ->take(20)
            ->get()
            ->reverse();

        return view('chat.index', compact('messages'));
    }

    public function send(ChatMessageRequest $request)
    {
        $user = auth()->user();
        $message = $request->validated('message');

        $this->chatService->saveUserMessage($user, $message);

        $context = $this->chatService->buildBusinessContext($user);
        $apiMessages = $this->chatService->buildApiMessages($user, $context);
        $reply = $this->chatService->ask($apiMessages);

        $this->chatService->saveAssistantMessage($user, $reply);

        return response()->json(['reply' => $reply]);
    }
}
