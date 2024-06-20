<?php

namespace App\Http\Requests;

use App\Business\StaffServiceChecker;
use App\Business\StaffAvailabilityChecker;
use App\Business\ClientAvailabilityChecker;
use App\Business\OpeningHourChecker;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Scheduler;

class MyScheduleRequest extends FormRequest
{

    use ManagesReservationRules;

        /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     *
     * @return bool
     */
    public function authorize()
    {
        // Permite la autorización para todos los usuarios.
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
            // El campo 'from.date' es requerido, debe tener el formato 'Y-m-d' y ser una fecha igual o posterior a hoy.
            'from.date' => 'required|date_format:Y-m-d|after_or_equal:today',

            // El campo 'from.time' es requerido y debe tener el formato 'H:i'.
            'from.time' => 'required|date_format:H:i',
            
            // El campo 'service_id' es requerido y debe existir en la tabla 'services' con el 'id' especificado.
            'service_id' => 'required|exists:services,id',
            
            // El campo 'staff_user_id' es requerido y debe existir en la tabla 'users' con el 'id' especificado.
            'staff_user_id' => 'required|exists:users,id',
        ];
    }


}
