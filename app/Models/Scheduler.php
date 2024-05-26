<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Scheduler extends Model
{
    use HasFactory;

    // Define la propiedad $from como 'fillable'
    protected $from = 'fillable';

    // Define los campos que se pueden asignar masivamente
    protected $fillable = [
        'from',
        'to',
        'status',
        'staff_user_id',
        'client_user_id',
        'service_id',
    ];

    // Especifica los campos que deben ser tratados como instancias de Carbon (fechas)
    protected $dates = [
        'from',
        'to',
    ];

    /**
     * Define la relación con el servicio asociado a esta cita.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        // Una cita pertenece a un servicio
        return $this->belongsTo(Service::class);
    }

    /**
     * Define la relación con el usuario del personal asociado a esta cita.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function staffUser()
    {
        // Una cita pertenece a un usuario del personal (staff)
        return $this->belongsTo(User::class);
    }
}
