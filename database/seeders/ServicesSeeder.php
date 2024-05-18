<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServicesSeeder extends Seeder // Corregir el nombre de la clase aquí
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear servicios médicos en la base de datos
        Service::create([
            'name' => 'Consulta médica general',
            'duration' => 30
        ]);
        Service::create([
            'name' => 'Examen físico',
            'duration' => 45
        ]);
        Service::create([
            'name' => 'Extracción de sangre',
            'duration' => 15
        ]);
        Service::create([
            'name' => 'Electrocardiograma',
            'duration' => 20
        ]);
        Service::create([
            'name' => 'Radiografía de tórax',
            'duration' => 15
        ]);
        Service::create([
            'name' => 'Ecografía abdominal ',
            'duration' => 30
        ]);
        Service::create([
            'name' => 'Resonancia magnética',
            'duration' => 60
        ]);
        Service::create([
            'name' => 'Psicoterapia individual',
            'duration' => 50
        ]);
        Service::create([
            'name' => 'Consulta con especialista',
            'duration' => 45
        ]);
        Service::create([
            'name' => 'Sesión de rehabilitación cardíaca',
            'duration' => 60
        ]);
        
    }
}
