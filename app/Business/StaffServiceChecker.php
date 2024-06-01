<?php

namespace App\Business;

use App\Models\User;
use App\Models\Service;
use App\Models\Scheduler;

class StaffServiceChecker
{
    // Variables protegidas para almacenar el usuario del personal y el servicio
    protected $staffUser;
    protected $service;
    protected $ignoreScheduler = false;
    protected $scheduler = null;

    // Constructor para inicializar las variables con los valores pasados como parámetros
    public function __construct(User $staffUser, Service $service)
    {
        $this->staffUser = $staffUser; // Usuario del personal
        $this->service = $service; // Servicio
    }

    public function ignore(Scheduler $scheduler)
    {
        $this->ignoreScheduler = true;

        $this->scheduler = $scheduler;
        
        return $this;
    }


    // Método para verificar si el usuario del personal está asociado con el servicio específico
    public function check()
    {
        // Verifica si existe una relación entre el usuario del personal y el servicio específico
        return $this->staffUser
                ->service() // Asumiendo que hay una relación definida entre User y Service en el modelo User
                ->where('id', $this->service->id) // Filtra por el ID del servicio
                ->exists(); // Verifica si la relación existe
    }
}
