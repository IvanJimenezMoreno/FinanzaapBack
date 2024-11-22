<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PagoRecordatorio extends Notification
{
    use Queueable;

    protected $pago;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($pago)
    {
        $this->pago = $pago;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Recordatorio de Pago')
                    ->line('Este es un recordatorio de que tienes un pago pendiente.')
                    ->line('Nombre del Pago: ' . $this->pago->nombre_pago)
                    ->line('Fecha de Pago: ' . $this->pago->fecha_pago->format('d-m-Y'))
                    ->line('Monto del Pago: ' . $this->pago->monto_pago)
                    ->line('Descripción: ' . $this->pago->descripcion)
                    ->line('Por favor, asegúrate de realizar el pago a tiempo.')
                    ->action('Ver Pago', url('/pagos/' . $this->pago->id_pago))
                    ->line('Gracias por usar nuestra aplicación!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
