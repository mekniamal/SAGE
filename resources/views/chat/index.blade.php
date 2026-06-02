@extends('layouts.luxury-app')

@section('title', 'Assistant')

@section('content')
<h1 class="luxury-page-title">Assistant</h1>
<p class="luxury-page-subtitle">Posez vos questions sur les produits et commandes</p>

<div class="luxury-chat">
    <div id="chat-messages" class="luxury-chat__messages">
        @forelse($messages as $msg)
            <div class="luxury-chat__bubble luxury-chat__bubble--{{ $msg->role === 'user' ? 'user' : 'bot' }}">
                @if($msg->role === 'assistant')
                    <p style="margin:0 0 0.35rem;font-size:0.65rem;letter-spacing:0.1em;text-transform:uppercase;opacity:0.6">Assistant</p>
                @endif
                <p style="margin:0;white-space:pre-wrap">{{ $msg->message }}</p>
                <p style="margin:0.35rem 0 0;font-size:0.65rem;opacity:0.5;text-align:right">{{ $msg->created_at->format('H:i') }}</p>
            </div>
        @empty
            <div style="text-align:center;color:var(--luxury-gray);margin:auto;padding:2rem">
                <p style="font-family:'Cormorant Garamond',serif;font-size:1.5rem;margin-bottom:0.5rem">Bonjour</p>
                <p style="font-size:0.9rem;margin-bottom:1.5rem">Je suis votre assistant boutique.</p>
                <div style="display:flex;flex-wrap:wrap;gap:0.5rem;justify-content:center">
                    <button type="button" onclick="sendSuggestion('Quels produits sont disponibles ?')" class="luxury-btn luxury-btn--outline luxury-btn--sm">Produits disponibles ?</button>
                    <button type="button" onclick="sendSuggestion('Où en est ma dernière commande ?')" class="luxury-btn luxury-btn--outline luxury-btn--sm">Ma dernière commande ?</button>
                </div>
            </div>
        @endforelse
    </div>
    <div class="luxury-chat__input">
        <input type="text" id="message-input" placeholder="Votre message…" onkeypress="if(event.key==='Enter') sendMessage()">
        <button type="button" onclick="sendMessage()" id="send-btn">Envoyer</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
function sendSuggestion(text) {
    document.getElementById('message-input').value = text;
    sendMessage();
}

function sendMessage() {
    const input = document.getElementById('message-input');
    const message = input.value.trim();
    if (!message) return;

    const chatMessages = document.getElementById('chat-messages');
    const sendBtn = document.getElementById('send-btn');

    chatMessages.innerHTML += `<div class="luxury-chat__bubble luxury-chat__bubble--user"><p style="margin:0">${message.replace(/</g,'&lt;')}</p></div>`;
    chatMessages.innerHTML += `<div id="typing" class="luxury-chat__bubble luxury-chat__bubble--bot"><p style="margin:0;opacity:0.6">Réflexion en cours…</p></div>`;
    chatMessages.scrollTop = chatMessages.scrollHeight;
    input.value = '';
    sendBtn.disabled = true;

    fetch('{{ route("chat.send") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ message: message })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('typing')?.remove();
        chatMessages.innerHTML += `<div class="luxury-chat__bubble luxury-chat__bubble--bot"><p style="margin:0 0 0.35rem;font-size:0.65rem;letter-spacing:0.1em;text-transform:uppercase;opacity:0.6">Assistant</p><p style="margin:0;white-space:pre-wrap">${data.reply.replace(/</g,'&lt;')}</p></div>`;
        chatMessages.scrollTop = chatMessages.scrollHeight;
        sendBtn.disabled = false;
    })
    .catch(() => {
        document.getElementById('typing')?.remove();
        chatMessages.innerHTML += `<div class="luxury-chat__bubble luxury-chat__bubble--bot"><p style="margin:0;color:var(--luxury-accent)">Erreur de connexion. Réessayez.</p></div>`;
        sendBtn.disabled = false;
    });
}

document.getElementById('chat-messages').scrollTop = document.getElementById('chat-messages').scrollHeight;
</script>
@endpush
