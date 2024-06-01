<?php

namespace App\Notifications;

use App\Models\Scheduler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SchedulerCreated extends Notification
{
    use Queueable;

    protected $scheduler; // Almacena la instancia de Scheduler asociada con la notificación

    /**
     * Crea una nueva instancia de notificación.
     *
     * @param Scheduler $scheduler La instancia de Scheduler asociada
     * @return void
     */
    public function __construct(Scheduler $scheduler)
    {
        $this->scheduler = $scheduler; // Asigna la instancia de Scheduler a la propiedad protegida
    }

    /**
     * Obtiene los canales de entrega de la notificación.
     *
     * @param  mixed  $notifiable El destinatario de la notificación
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail']; // Define que la notificación se enviará por correo electrónico
    }

    /**
     * Obtiene la representación de correo de la notificación.
     *
     * @param  mixed  $notifiable El destinatario de la notificación
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Construye el mensaje de correo electrónico
        return (new MailMessage)
                    ->greeting("Hola {$this->scheduler->staffUser->name}") // Saludo personalizado
                    ->line("Hay una nueva cita que debes atender el día {$this->scheduler->from->isoFormat('dddd Do MMMM YYYY')} a las {$this->scheduler->from->format('H:i')}") // Detalles de la cita
                    ->action('Revisar Agenda', url('/dashboard')) // Enlace para revisar la agenda
                    ->line('¡No olvides revisar regularmente tu agenda!'); // Línea adicional de información
    }

    /**
     * Obtiene la representación en array de la notificación.
     *
     * @param  mixed  $notifiable El destinatario de la notificación
     * @return array
     */
    public function toArray($notifiable)
    {
        // Aquí se puede definir la representación en array de la notificación si es necesario
        return [
            // Ejemplo de datos adicionales para la notificación
        ];
    }
}
