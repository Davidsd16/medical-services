<?php

namespace App\Business;

use App\Models\User;
use Carbon\Carbon;
use App\Models\Scheduler;

class StaffAvailabilityChecker
{
    // Propiedades protegidas para el usuario del personal y los tiempos de inicio y fin de la cita
    protected $staffUser;
    protected $from;
    protected $to;

    /**
     * Constructor para inicializar las propiedades del verificador de disponibilidad del personal.
     *
     * @param User $staffUser El usuario del personal
     * @param Carbon $from La fecha y hora de inicio de la cita
     * @param Carbon $to La fecha y hora de fin de la cita
     */
    public function __construct(User $staffUser, Carbon $from, Carbon $to)
    {
        $this->staffUser = $staffUser;
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * Verifica la disponibilidad del personal para la cita especificada.
     *
     * @return bool True si el personal está disponible, False si no lo está
     */
    public function check()
    {
        // Busca en la tabla 'scheduler' si hay algún conflicto de horario para el personal
        return !Scheduler::where('staff_user_id', $this->staffUser->id)
            ->where('from', '<', $this->to) // La cita comienza antes de que termine la nueva cita
            ->where('to', '>', $this->from) // La cita termina después de que comience la nueva cita
            ->exists(); // Verifica si existe algún registro que coincida con los criterios anteriores
    }
}