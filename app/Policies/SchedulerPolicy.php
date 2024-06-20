<?php

namespace App\Policies;

use App\Models\Scheduler;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchedulerPolicy
{
    use HandlesAuthorization;

    /**
     * Determina si el usuario puede ver cualquier modelo de Scheduler.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // Lógica para determinar si el usuario puede ver cualquier Scheduler
    }

    /**
     * Determina si el usuario puede ver un modelo específico de Scheduler.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Scheduler  $scheduler
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Scheduler $scheduler)
    {
        // Lógica para determinar si el usuario puede ver un Scheduler específico
    }

    /**
     * Determina si el usuario puede crear modelos de Scheduler.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // Lógica para determinar si el usuario puede crear un Scheduler
    }

    /**
     * Determina si el usuario puede actualizar un modelo específico de Scheduler.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Scheduler  $scheduler
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Scheduler $scheduler)
    {
        // Impide la actualización si falta menos de 24 horas para la cita
        if ($scheduler->from->diffInHours() < 24) {
            return false;
        }

        // Permite la actualización si el usuario es el cliente o el personal asociado a la cita
        if (($scheduler->client_user_id == $user->id) OR ($scheduler->staff_user_id == $user->id)) {
            return true;
        }

        // Retorna null si no se cumple ninguna de las condiciones anteriores
        return null;
    }

    /**
     * Determina si el usuario puede eliminar un modelo específico de Scheduler.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Scheduler  $scheduler
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Scheduler $scheduler)
    {
        // Verifica si los atributos 'to' y 'from' son null
        if ($scheduler->to === null || $scheduler->from === null) {
            return false;
        }

        // Impide la eliminación si la cita ya ha pasado
        if ($scheduler->to->isPast()) {
            return false;
        }

        // Impide la eliminación si falta menos de 24 horas para la cita
        if ($scheduler->from->diffInHours() < 24) {
            return false;
        }

        // Permite la eliminación si el usuario es el cliente o el personal asociado a la cita
        if ($scheduler->client_user_id == $user->id || $scheduler->staff_user_id == $user->id) {
            return true;
        }

        // Retorna false por defecto si ninguna condición se cumple
        return false;
    }


    /**
     * Determina si el usuario puede restaurar un modelo específico de Scheduler.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Scheduler  $scheduler
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Scheduler $scheduler)
    {
        // Lógica para determinar si el usuario puede restaurar un Scheduler
    }

    /**
     * Determina si el usuario puede eliminar permanentemente un modelo específico de Scheduler.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Scheduler  $scheduler
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Scheduler $scheduler)
    {
        // Lógica para determinar si el usuario puede eliminar permanentemente un Scheduler
    }
}
