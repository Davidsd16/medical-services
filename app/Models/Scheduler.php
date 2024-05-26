<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Scheduler extends Model
{
    use HasFactory;

    protected $from = 'fillable';

    protected $fillable = [
        'from',
        'to',
        'status',
        'staff_user_id',
        'client_user_id',
        'service_id',
    ];


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
        return $this->belongsTo(Service::class);
    }

    /**
     * Define la relación con el usuario del personal asociado a esta cita.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function staffUser()
    {
        return $this->belongsTo(User::class);
    }
}