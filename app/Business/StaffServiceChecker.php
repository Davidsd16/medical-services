<?php

namespace App\Business;

use App\Models\User;
use App\Models\Service;
use App\Models\Scheduler;

class StaffServiceChecker
{
    // Variables protegidas para almacenar el usuario del personal y el servicio
    protected $staffUser; // Usuario del personal
    protected $service; // Servicio
    protected $ignoreScheduler = false; // Bandera para indicar si se debe ignorar un scheduler específico
    protected $scheduler = null; // Scheduler que se debe ignorar si la bandera está activada

    /**
     * Constructor para inicializar las variables con los valores pasados como parámetros.
     *
     * @param User $staffUser El usuario del personal
     * @param Service $service El servicio específico
     */
    public function __construct(User $staffUser, Service $service)
    {
        $this->staffUser = $staffUser; // Asigna el usuario del personal
        $this->service = $service; // Asigna el servicio
    }

    /**
     * Ignora un scheduler específico al verificar la asociación del servicio.
     *
     * @param Scheduler $scheduler La cita a ignorar
     * @return $this Retorna la instancia actual para permitir encadenamiento
     */
    public function ignore(Scheduler $scheduler)
    {
        $this->ignoreScheduler = true; // Activa la bandera para ignorar el scheduler
        $this->scheduler = $scheduler; // Asigna el scheduler que se debe ignorar
        return $this; // Retorna la instancia actual para permitir encadenamiento
    }

    /**
     * Verifica si el usuario del personal está asociado con el servicio específico.
     *
     * @return bool True si el personal está asociado con el servicio, False si no lo está
     */
    public function check()
    {
        // Verifica si existe una relación entre el usuario del personal y el servicio específico
        return $this->staffUser
                ->service() // Asumiendo que hay una relación definida entre User y Service en el modelo User
                ->where('id', $this->service->id) // Filtra por el ID del servicio
                ->exists(); // Verifica si la relación existe
    }
}
