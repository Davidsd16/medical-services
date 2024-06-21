<?php

namespace App\Models;


use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // Utiliza varios traits para proporcionar funcionalidad adicional al modelo User
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    // Define los atributos que se pueden asignar en masa
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Los atributos que deben estar ocultos para la serialización.
     *
     * @var array<int, string>
     */
    // Define los atributos que deben estar ocultos cuando el modelo se serializa
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    // Define los atributos que deben ser convertidos a tipos nativos
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Define la relación de muchos a muchos con el modelo Service
    public function service()
    {
        return $this->belongsToMany(Service::class);
    }
}
