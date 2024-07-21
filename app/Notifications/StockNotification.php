<?php

namespace App\Notifications;

use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StockNotification extends Notification
{
    use Queueable;
    public $producto;
    /**
     * Create a new notification instance.
     */
    public function __construct(Producto $producto)
    {
        $this->producto= $producto;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Stock Bajo: ' . $this->producto->nombre)
                    ->line('El stock del producto ' . $this->producto->nombre . ' está por acabarse.')
                    ->line('Código del producto: ' . $this->producto->codigo)
                    ->line('Por favor, reponga el stock lo antes posible.')
                    ->line('Gracias por usar nuestra aplicación!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Pocos productos de ' . $this->producto->nombre . '.',
            'Codigo del producto' => $this->producto->codigo,
            'time' => Carbon::now()->diffForHumans(),
        ];
    }
}
