<?php

namespace App\Business;

use App\Models\User;
use Carbon\Carbon;
use App\Models\Scheduler;

class ClientAvailabilityChecker
{
    // Variables protegidas para almacenar el usuario cliente y los rangos de tiempo
    protected $clientUser;
    protected $from;
    protected $to;
    protected $ignoreScheduler = false;
    protected $scheduler = null;

    // Constructor para inicializar las variables con los valores pasados como parámetros
    public function __construct(User $clientUser, Carbon $from, Carbon $to)
    {
        $this->clientUser = $clientUser; // Usuario cliente
        $this->from = $from; // Tiempo de inicio
        $this->to = $to; // Tiempo de fin
    }

    public function ignore($cheduler)
    {
        $this->ignoreScheduler = true;

        $this->scheduler = $cheduler;

        return $this;
    }

    // Método para verificar la disponibilidad del cliente en un rango de tiempo
    public function check()
    {
        // Verifica si existen registros en la tabla Scheduler que se solapen con el rango de tiempo especificado para el usuario cliente
        return !Scheduler::where('client_user_id', $this->clientUser->id)
            ->when($this->ignoreScheduler, function($query){
                $query->where('id', '<>', $this->scheduler->id);
            })
            ->where('from', '<', $this->to)
            ->where('to', '>', $this->from)
            ->exists(); 
    }

}
