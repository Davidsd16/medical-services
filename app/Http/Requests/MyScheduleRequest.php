<?php

namespace App\Http\Requests;

use App\Business\StaffServiceChecker;
use App\Business\StaffAvailabilityChecker;
use App\Business\ClientAvailabilityChecker;
use Illuminate\Foundation\Http\FormRequest;

class MyScheduleRequest extends FormRequest
{
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

    public function checkReservationRules($staffUser, $clientUser, $from, $to, $service)
    {
        // Verifica la disponibilidad del personal en el horario especificado
        if (!(new StaffAvailabilityChecker($staffUser, $from, $to))->check()) {
            // Si el horario no está disponible, redirige de vuelta con un mensaje de error y los datos del formulario
            return back()->withErrors('Este horario no está disponible')->withInput();
        }
    
        // Verifica la disponibilidad del cliente en el horario especificado
        if (!(new ClientAvailabilityChecker($clientUser, $from, $to))->check()) {
            // Si el cliente ya tiene una reserva confirmada en este horario, redirige de vuelta con un mensaje de error y los datos del formulario
            return back()->withErrors('Ya tienes una reserva confirmada en este horario')->withInput();
        }
    
        // Verifica si el personal presta el servicio especificado
        if (!(new StaffServiceChecker($staffUser, $service))->check()) {
            // Si el personal no presta el servicio, redirige de vuelta con un mensaje de error y los datos del formulario
            return back()->withErrors("{$staffUser->name} no presta el servicio de {$service->name}.")->withInput();
        }
    }
    
}
