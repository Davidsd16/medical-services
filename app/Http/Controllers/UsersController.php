<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    // Método para mostrar la lista de usuarios con el rol de 'staff'
    public function index()
    {
        // Obtiene todos los usuarios con el rol de 'staff', incluyendo la relación 'service'
        $users = User::with('service')
            ->role('staff')
            ->get();
        
        // Retorna la vista 'users.index' con los usuarios obtenidos
        return view('users.index')->with([
            'users' => $users,
        ]);
    }
}
