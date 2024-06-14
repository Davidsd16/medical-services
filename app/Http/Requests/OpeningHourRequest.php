<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OpeningHourRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     *
     * @return bool
     */
    public function authorize()
    {
        // Permitir que todos los usuarios realicen esta solicitud.
        return true;
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // Reglas de validación para los horarios de apertura y cierre.
        return [
            'open' => 'required|array', // 'open' debe ser un array y es requerido.
            'open.1' => 'required|before:close.1', // 'open.1' es requerido y debe ser antes de 'close.1'.
            'open.2' => 'required|before:close.2', // 'open.2' es requerido y debe ser antes de 'close.2'.
            'open.3' => 'required|before:close.3', // 'open.3' es requerido y debe ser antes de 'close.3'.
            'open.4' => 'required|before:close.4', // 'open.4' es requerido y debe ser antes de 'close.4'.
            'open.5' => 'required|before:close.5', // 'open.5' es requerido y debe ser antes de 'close.5'.
            'open.6' => 'required|before:close.6', // 'open.6' es requerido y debe ser antes de 'close.6'.
            'close.1' => 'required', // 'close.1' es requerido.
            'close.2' => 'required', // 'close.2' es requerido.
            'close.3' => 'required', // 'close.3' es requerido.
            'close.4' => 'required', // 'close.4' es requerido.
            'close.5' => 'required', // 'close.5' es requerido.
            'close.6' => 'required', // 'close.6' es requerido.
        ];
    }
}
