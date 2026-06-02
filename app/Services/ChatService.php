<?php

namespace App\Services;

use App\Models\ChatMessage;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ChatService
{
    public function saveUserMessage(User $user, string $message): ChatMessage
    {
        return ChatMessage::create([
            'user_id' => $user->id,
            'role' => 'user',
            'message' => $message,
        ]);
    }

    public function saveAssistantMessage(User $user, string $message): ChatMessage
    {
        return ChatMessage::create([
            'user_id' => $user->id,
            'role' => 'assistant',
            'message' => $message,
        ]);
    }

    public function buildBusinessContext(User $user): string
    {
        $totalProducts = Product::where('is_active', true)->count();
        $outOfStock = Product::where('stock', 0)->count();
        $myOrders = Order::where('user_id', $user->id)->count();

        $recentProducts = Product::where('is_active', true)->latest()->take(5)->get();
        $myRecentOrders = Order::where('user_id', $user->id)
            ->with('items.product')
            ->latest()
            ->take(3)
            ->get();

        $context = "Tu es un assistant de boutique e-commerce. Réponds en français, de façon claire et utile.\n";
        $context .= "Données actuelles :\n";
        $context .= "- Produits actifs en catalogue : {$totalProducts}\n";
        $context .= "- Produits en rupture de stock : {$outOfStock}\n";
        $context .= "- Nombre de commandes de cet utilisateur : {$myOrders}\n\n";
        $context .= "Derniers produits disponibles :\n";

        foreach ($recentProducts as $product) {
            $context .= "- {$product->name} : {$product->price} TND, stock {$product->stock}\n";
        }

        $context .= "\nDernières commandes de l'utilisateur :\n";

        foreach ($myRecentOrders as $order) {
            $context .= "- Commande #{$order->id} : {$order->total} TND, statut {$order->status}\n";
        }

        return $context;
    }

    public function buildApiMessages(User $user, string $businessContext): array
    {
        $messages = [
            ['role' => 'system', 'content' => $businessContext],
        ];

        $history = ChatMessage::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get()
            ->reverse();

        foreach ($history as $msg) {
            $messages[] = [
                'role' => $msg->role === 'assistant' ? 'assistant' : 'user',
                'content' => $msg->message,
            ];
        }

        return $messages;
    }

    public function ask(Collection|array $messages): string
    {
        $apiKey = config('services.groq.key');

        if (empty($apiKey)) {
            return 'Le service IA n\'est pas configuré. Ajoutez GROQ_API_KEY dans le fichier .env.';
        }

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer '.$apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => config('services.groq.model', 'llama-3.1-8b-instant'),
                    'messages' => is_array($messages) ? $messages : $messages->all(),
                    'max_tokens' => 1024,
                ]);

            if (! $response->successful()) {
                return 'Le service IA est temporairement indisponible. Réessayez plus tard.';
            }

            return $response->json('choices.0.message.content')
                ?? 'Désolé, je n\'ai pas pu générer une réponse.';
        } catch (\Throwable) {
            return 'Le service IA est temporairement indisponible. Réessayez plus tard.';
        }
    }
}
