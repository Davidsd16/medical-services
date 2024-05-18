<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Crear roles en la base de datos
        Role::create(['name' => 'admin']); // Crear un rol de administrador
        Role::create(['name' => 'staff']); // Crear un rol de personal
        Role::create(['name' => 'client']); // Crear un rol de cliente

        // Crear usuarios con roles asignados
        $users = \App\Models\User::factory(10)->create(); // Crear 10 usuarios ficticios

        // Asignar el rol 'client' a los usuarios creados
        foreach ($users as $user) {
            $user->assignRole('client');
        }

        // Crear usuarios específicos y asignarles roles

        // Crear usuario 'David' y asignarle el rol de administrador
        $userAdmin = \App\Models\User::factory()->create([
            'name' => 'David',
            'email' => 'david@gmail.com'
        ]);

        $userAdmin->assignRole('admin'); // Asignar el rol de administrador al usuario 'David'

        // Crear usuario 'Judy' y asignarle el rol de personal
        $staff = \App\Models\User::factory()->create([
            'name' => 'Judy',
            'email' => 'judy@gmail.com'
        ]);

        $staff->assignRole('staff'); // Asignar el rol de personal al usuario 'Judy'

        $this->call(OpeningHoursSeeder::class); // Llamar al seeder de horarios de apertura
        
        $this->call(ServicesSeeder::class); // Llamar al seeder de servicios 
    }
}
