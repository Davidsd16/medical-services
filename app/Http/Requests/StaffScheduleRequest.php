<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffScheduleRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     *
     * @return bool
     */
    public function authorize()
    {
        // Permitir siempre la autorización para esta solicitud
        return true;
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            // Regla de validación para la fecha de inicio de la cita
            // La fecha es requerida, debe tener el formato 'Y-m-d' y debe ser hoy o una fecha futura
            'from.date' => 'required|date_format:Y-m-d|after_or_equal:today',
            
            // Regla de validación para la hora de inicio de la cita
            // La hora es requerida y debe tener el formato 'H:i'
            'from.time' => 'required|date_format:H:i',
        ];
    }
}
