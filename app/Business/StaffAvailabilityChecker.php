<?php

namespace App\Business;

use App\Models\User;
use Carbon\Carbon;
use App\Models\Scheduler;

class StaffAvailabilityChecker
{
    protected $staffUser; // Usuario del personal cuyo horario se está verificando
    protected $from; // Fecha y hora de inicio del rango de tiempo a verificar
    protected $to; // Fecha y hora de fin del rango de tiempo a verificar
    protected $ignoreScheduler = false; // Bandera para indicar si se debe ignorar una cita específica
    protected $scheduler = null; // Cita que se debe ignorar si la bandera está activada

    /**
     * Constructor para inicializar las propiedades del verificador de disponibilidad del personal.
     *
     * @param User $staffUser El usuario del personal
     * @param Carbon $from La fecha y hora de inicio de la cita
     * @param Carbon $to La fecha y hora de fin de la cita
     * @param Scheduler|null $scheduler (Opcional) La cita a ignorar
     */
    public function __construct(User $staffUser, Carbon $from, Carbon $to, Scheduler $scheduler = null)
    {
        $this->staffUser = $staffUser; // Asigna el usuario del personal
        $this->from = $from; // Asigna la fecha y hora de inicio
        $this->to = $to; // Asigna la fecha y hora de fin
        $this->scheduler = $scheduler; // Asigna la cita a ignorar (opcional)
    }

    /**
     * Ignora una cita específica al verificar la disponibilidad.
     *
     * @param Scheduler $scheduler La cita a ignorar
     * @return $this Retorna la instancia actual para permitir encadenamiento
     */
    public function ignore(Scheduler $scheduler)
    {
        $this->ignoreScheduler = true; // Activa la bandera para ignorar la cita
        $this->scheduler = $scheduler; // Asigna la cita que se debe ignorar
        return $this; // Retorna la instancia actual para permitir encadenamiento
    }

    /**
     * Verifica la disponibilidad del personal para la cita especificada.
     *
     * @return bool True si el personal está disponible, False si no lo está
     */
    public function check()
    {
        // Verifica si existen registros en la tabla Scheduler que se solapen con el rango de tiempo especificado para el usuario del personal
        return !Scheduler::where('staff_user_id', $this->staffUser->id) // Filtra por el ID del usuario del personal
            ->when($this->ignoreScheduler, function($query) {
                // Si la bandera ignoreScheduler está activada, excluye la cita especificada de la verificación
                $query->where('id', '<>', $this->scheduler->id);
            })
            ->where('from', '<', $this->to) // Verifica que el tiempo de inicio de la reserva sea antes del tiempo de fin del rango
            ->where('to', '>', $this->from) // Verifica que el tiempo de fin de la reserva sea después del tiempo de inicio del rango
            ->exists(); // Verifica si existe algún registro que cumpla con las condiciones anteriores
    }
}
