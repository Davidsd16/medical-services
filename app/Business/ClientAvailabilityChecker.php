<?php

namespace App\Business;

use App\Models\User;
use Carbon\Carbon;
use App\Models\Scheduler;

class ClientAvailabilityChecker
{
    // Variables protegidas para almacenar el usuario cliente y los rangos de tiempo
    protected $clientUser;
    protected $from; // Fecha y hora de inicio del rango de tiempo a verificar
    protected $to; // Fecha y hora de fin del rango de tiempo a verificar
    protected $ignoreScheduler = false; // Bandera para indicar si se debe ignorar un scheduler específico
    protected $scheduler = null; // Variable para almacenar el scheduler que se debe ignorar

        /**
     * Constructor para inicializar las propiedades del verificador de disponibilidad del personal.
     *
     * @param User $staffUser El usuario del personal
     * @param Carbon $from La fecha y hora de inicio de la cita
     * @param Carbon $to La fecha y hora de fin de la cita
     * @param Scheduler|null $scheduler (Opcional) La cita a ignorar
     */
    
    // Constructor para inicializar las variables con los valores pasados como parámetros
    public function __construct(User $clientUser, Carbon $from, Carbon $to)
    {
        $this->clientUser = $clientUser; // Usuario cliente
        $this->from = $from; // Tiempo de inicio
        $this->to = $to; // Tiempo de fin
    }

    // Método para ignorar un scheduler específico en las verificaciones de disponibilidad
    public function ignore($scheduler)
    {
        $this->ignoreScheduler = true; // Activa la bandera para ignorar el scheduler
        $this->scheduler = $scheduler; // Asigna el scheduler que se debe ignorar
        return $this; // Devuelve la instancia actual para permitir encadenamiento
    }

    // Método para verificar la disponibilidad del cliente en un rango de tiempo
    public function check()
    {
        // Verifica si existen registros en la tabla Scheduler que se solapen con el rango de tiempo especificado para el usuario cliente
        return !Scheduler::where('client_user_id', $this->clientUser->id) // Filtra por el ID del usuario cliente
            ->when($this->ignoreScheduler, function($query) {
                // Si la bandera ignoreScheduler está activa, excluye el scheduler especificado de la verificación
                $query->where('id', '<>', $this->scheduler->id);
            })
            ->where('from', '<', $this->to) // Verifica que el tiempo de inicio de la reserva sea antes del tiempo de fin del rango
            ->where('to', '>', $this->from) // Verifica que el tiempo de fin de la reserva sea después del tiempo de inicio del rango
            ->exists(); // Verifica si existe algún registro que cumpla con las condiciones anteriores
    }
}
