<?php

namespace App\Business;

use App\Models\User;
use App\Models\Scheduler;
use Carbon\Carbon;

class DeletePermissionChecker
{
    protected $scheduler;
    protected $user;

    // Constructor para inicializar las variables con los valores pasados como parámetros
    public function __construct(Scheduler $scheduler, User $user)
    {
        $this->scheduler = $scheduler; // La cita que se quiere eliminar
        $this->user = $user; // El usuario que intenta eliminar la cita
    }

    // Método para verificar si el usuario tiene permiso para eliminar la cita
    public function check()
    {
        // Verifica si el usuario es el dueño de la cita
        $isOwner = $this->scheduler->client_user_id == $this->user->id;

        // Verifica si la cita es para una fecha futura
        $isFuture = Carbon::parse($this->scheduler->from)->isFuture();

        // Devuelve verdadero si el usuario es el dueño de la cita y la cita es para una fecha futura
        return $isOwner && $isFuture;
    }
}
