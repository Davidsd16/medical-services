<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // Definición de las reglas de validación para el formulario de usuarios
        $rules = [
            'name' => 'required|string', // El nombre es requerido y debe ser una cadena
            'email' => 'required|email|unique:users,email', // El correo electrónico es requerido, debe ser válido y único en la tabla 'users'
            'roles_ids' => 'required|array', // Los roles_ids deben ser un array
            'roles_ids.*' => [ // Cada elemento de roles_ids debe cumplir con estas reglas
                'required', // Es requerido
                'exists:roles,id', // Debe existir en la tabla 'roles'
                function ($attribute, $value, $fail) { // Función anónima para validación personalizada
                    if (
                        $value == 3 && (in_array(1, request('roles_ids')) ||
                            in_array(2, request('roles_ids')))
                    ) {
                        $fail('El usuario de tipo cliente no puede tener roles adicionales.'); // Mensaje de error personalizado si el usuario de tipo cliente tiene roles adicionales
                    }
                }
            ],
        ];

        // Si el método HTTP es PUT, se agregan reglas adicionales para la actualización del usuario
        if ($this->method() == 'PUT') {
            $rules = array_merge($rules, [
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($this->user), // El correo electrónico debe ser único, ignorando el usuario actual
                ],
            ]);
        }

        return $rules; // Retorna las reglas de validación
    }
}
