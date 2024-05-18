<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OpeningHour; 

class OpeningHoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear registros de horas de apertura en la base de datos
        OpeningHour::create([
            'day' => 1, // Lunes
            'open' => '08:00',
            'close' => '17:00'
        ]);
        OpeningHour::create([
            'day' => 2, // Martes
            'open' => '08:00',
            'close' => '17:00'
        ]);
        OpeningHour::create([
            'day' => 3, // Miércoles
            'open' => '08:00',
            'close' => '17:00'
        ]);
        OpeningHour::create([
            'day' => 4, // Jueves
            'open' => '08:00',
            'close' => '17:00'
        ]);
        OpeningHour::create([
            'day' => 5, // Viernes
            'open' => '08:00',
            'close' => '17:00'
        ]);
        OpeningHour::create([
            'day' => 6, // Sábado
            'open' => '08:00',
            'close' => '13:00'
        ]);
    }
}
