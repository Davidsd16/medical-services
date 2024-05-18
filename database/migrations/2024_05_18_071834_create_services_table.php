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
        // Crea la tabla 'services' en la base de datos
        Schema::create('services', function (Blueprint $table) {
            $table->id(); // Columna 'id' (clave primaria) de tipo increment (unsignedBigInteger)
            $table->string('name'); // Columna 'name' de tipo string (varchar)
            $table->integer('duration'); // Columna 'duration' de tipo integer
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
        // Elimina la tabla 'services' si existe
        Schema::dropIfExists('services');
    }
};
