<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Definición de una nueva migración utilizando una clase anónima
return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        // Crea la tabla 'opening_hours' en la base de datos
        Schema::create('opening_hours', function (Blueprint $table) {
            $table->id(); // Columna 'id' (clave primaria) de tipo increment (unsignedBigInteger)
            $table->integer('day'); // Columna 'day' de tipo integer para almacenar el día de la semana (0 para domingo, 1 para lunes, etc.)
            $table->time('open'); // Columna 'open' de tipo time para almacenar la hora de apertura
            $table->time('close'); // Columna 'close' de tipo time para almacenar la hora de cierre
            $table->timestamps(); // Columnas 'created_at' y 'updated_at' de tipo timestamp
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        // Elimina la tabla 'opening_hours' si existe
        Schema::dropIfExists('opening_hours');
    }
};
