<?php

namespace App\Business;

use App\Models\OpeningHour;
use Carbon\Carbon;

class OpeningHourChecker
{
    // Propiedades protegidas para almacenar los tiempos de inicio y fin
    protected $from;
    protected $to;

    // Constructor que inicializa las propiedades con instancias de Carbon
    public function __construct(Carbon $from, Carbon $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    // Método para verificar si el rango de tiempo está dentro del horario de apertura
    public function check()
    {
        // Consulta en el modelo OpeningHour para verificar si existe un horario que cumpla con las condiciones
        return OpeningHour::where('day', $this->from->dayOfWeek) // Verifica si el día de la semana coincide
            ->where('open', '<=', $this->from->format('H:i')) // Verifica si la hora de apertura es anterior o igual a 'from'
            ->where('close', '>=', $this->to->format('H:i')) // Verifica si la hora de cierre es posterior o igual a 'to'
            ->exists(); // Devuelve true si existe un registro que cumpla con todas las condiciones, false en caso contrario
    }
}
