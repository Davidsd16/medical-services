<?php

namespace App\Business;

use App\Models\User;
use Carbon\Carbon;
use App\Models\Scheduler;

class StaffAvailabilityChecker
{
    protected $staffUser;
    protected $from;
    protected $to;
    protected $ignoreScheduler = false;
    protected $scheduler = null;

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
        $this->staffUser = $staffUser;
        $this->from = $from;
        $this->to = $to;
        $this->scheduler = $scheduler;
    }

    /**
     * Ignora una cita específica al verificar la disponibilidad.
     *
     * @param Scheduler $scheduler La cita a ignorar
     * @return $this
     */
    public function ignore(Scheduler $scheduler)
    {
        $this->ignoreScheduler = true;

        $this->scheduler = $scheduler;
        
        return $this;
    }

    /**
     * Verifica la disponibilidad del personal para la cita especificada.
     *
     * @return bool True si el personal está disponible, False si no lo está
     */
    public function check()
    {
        return !Scheduler::where('staff_user_id', $this->staffUser->id)
            ->when($this->ignoreScheduler, function($query) {
                $query->where('id', '<>', $this->scheduler->id);
            })
            ->where('from', '<', $this->to)
            ->where('to', '>', $this->from)
            ->exists();
    }
}
