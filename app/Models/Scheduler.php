<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Scheduler extends Model
{
    use HasFactory;

    // Define los campos que se pueden asignar masivamente
    protected $fillable = [
        'from',           // Fecha y hora de inicio de la cita
        'to',             // Fecha y hora de fin de la cita
        'status',         // Estado de la cita
        'staff_user_id',  // ID del usuario del personal asociado a la cita
        'client_user_id', // ID del usuario cliente asociado a la cita
        'service_id',     // ID del servicio asociado a la cita
    ];

    // Especifica los campos que deben ser tratados como instancias de Carbon (fechas)
    protected $dates = [
        'from', // Fecha y hora de inicio de la cita
        'to',   // Fecha y hora de fin de la cita
    ];

    /**
     * Define la relación con el servicio asociado a esta cita.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service(): BelongsTo
    {
        // Una cita pertenece a un servicio
        return $this->belongsTo(Service::class);
    }

    /**
     * Define la relación con el usuario del personal asociado a esta cita.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function staffUser(): BelongsTo
    {
        // Una cita pertenece a un usuario del personal (staff)
        return $this->belongsTo(User::class, 'staff_user_id');
    }

    /**
     * Define la relación con el usuario cliente asociado a esta cita.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clientUser(): BelongsTo
    {
        // Una cita pertenece a un usuario cliente
        return $this->belongsTo(User::class, 'client_user_id');
    }
}
