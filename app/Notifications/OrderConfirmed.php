<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderConfirmed extends Notification
{
    use Queueable;

    public function __construct(public Order $order) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('✅ Commande #' . $this->order->id . ' confirmée !')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Votre commande a été passée avec succès.')
            ->line('**Numéro de commande :** #' . $this->order->id)
            ->line('**Total :** ' . number_format($this->order->total, 2) . ' TND')
            ->line('**Adresse de livraison :** ' . $this->order->address)
            ->action('Voir ma commande', url('/orders/' . $this->order->id))
            ->line('Merci pour votre achat !');
    }

    public function toArray($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'total'    => $this->order->total,
            'status'   => $this->order->status,
            'message'  => 'Votre commande #' . $this->order->id . ' a été confirmée !',
        ];
    }
}