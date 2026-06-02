<?php

namespace App\Http\Controllers;

use App\Services\ChatService;
use Illuminate\Http\Request;

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

    public function send(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        $user = auth()->user();

        $this->chatService->saveUserMessage($user, $request->message);

        $context = $this->chatService->buildBusinessContext($user);
        $apiMessages = $this->chatService->buildApiMessages($user, $context);
        $reply = $this->chatService->ask($apiMessages);

        $this->chatService->saveAssistantMessage($user, $reply);

        return response()->json(['reply' => $reply]);
    }
}
