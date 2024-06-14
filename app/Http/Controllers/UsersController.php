<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UsersRequest;

class UsersController extends Controller
{
    // Método para mostrar la lista de usuarios
    public function index()
    {
        // Obtiene usuarios con sus servicios y roles, y los pagina
        $users = User::with('service', 'roles')->paginate(10);

        // Retorna la vista 'users.index' con los usuarios obtenidos
        return view('users.index')->with([
            'users' => $users,
        ]);
    }

    // Método para mostrar el formulario de creación de usuarios
    public function create()
    {
        // Obtiene todos los roles disponibles
        $roles = Role::all();

        // Retorna la vista 'users.create' con los roles obtenidos
        return view('users.create')->with([
            'roles' => $roles,
        ]);
    }

    // Método para almacenar un nuevo usuario
    public function store(UsersRequest $request)
    {
        // Crea un nuevo usuario con los datos del formulario
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt(Str::random(20)), // Genera una contraseña aleatoria
        ]);

        // Sincroniza los roles del usuario con los roles seleccionados en el formulario
        $user->roles()->sync($request->input('roles_ids'));

        // Redirige a la lista de usuarios
        return redirect(route('users.index'));
    }

    // Método para mostrar el formulario de edición de un usuario específico
    public function edit(User $user)
    {
        // Carga los roles del usuario
        $user->load('roles');

        // Obtiene todos los roles disponibles
        $roles = Role::get();

        // Retorna la vista 'users.edit' con el usuario y los roles obtenidos
        return view('users.edit')->with([
            'roles' => $roles,
            'user' => $user,
        ]);
    }

    // Método para actualizar un usuario existente
    public function update(UsersRequest $request, User $user)
    {
        // Actualiza el usuario con los datos del formulario
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        // Sincroniza los roles del usuario con los roles seleccionados en el formulario
        $user->roles()->sync($request->input('roles_ids'));

        // Redirige a la lista de usuarios
        return redirect(route('users.index'));
    }
}
