<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class OpeningHour extends Model
{
    use HasFactory;

    // Array para traducir los días de la semana a nombres en español
    protected $dayNames = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        7 => 'Domingo',
    ];

    // Atributo para formatear la hora de apertura
    protected function open(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return date('H:i', strtotime($value)); // Devuelve la hora en formato H:i
            }
        );
    }

    // Atributo para formatear la hora de cierre
    protected function close(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return date('H:i', strtotime($value)); // Devuelve la hora en formato H:i
            }
        );
    }

    // Atributo para obtener el nombre del día en español
    protected function dayName(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                return $this->dayNames[$attributes['day']]; // Devuelve el nombre del día según el valor de 'day'
            }
        );
    }
}
