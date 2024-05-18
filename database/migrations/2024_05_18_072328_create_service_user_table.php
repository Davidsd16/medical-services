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
        // Crea la tabla pivot 'service_user' en la base de datos
        Schema::create('service_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id'); // Columna 'user_id' de tipo unsignedBigInteger
            $table->unsignedBigInteger('service_id'); // Columna 'service_id' de tipo unsignedBigInteger
            $table->timestamps(); // Columnas 'created_at' y 'updated_at' de tipo timestamp

            // Define una clave foránea en la columna 'user_id' que referencia la columna 'id' en la tabla 'users'
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade') // Actualiza la clave foránea en cascada
                ->onDelete('cascade'); // Elimina los registros relacionados en cascada

            // Define una clave foránea en la columna 'service_id' que referencia la columna 'id' en la tabla 'services'
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onUpdate('cascade') // Actualiza la clave foránea en cascada
                ->onDelete('cascade'); // Elimina los registros relacionados en cascada
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        // Elimina la tabla 'service_user' si existe
        Schema::dropIfExists('service_user');
    }
};
