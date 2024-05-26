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
        // Crea la tabla 'scheduler' en la base de datos
        Schema::create('schedulers', function (Blueprint $table) {
            $table->id(); // Columna 'id' (clave primaria) de tipo increment (unsignedBigInteger)
            $table->dateTime('from'); // Columna 'from' de tipo dateTime
            $table->dateTime('to'); // Columna 'to' de tipo dateTime
            $table->string('status'); // Columna 'status' de tipo string (varchar)
            $table->unsignedBigInteger('staff_user_id'); // Columna 'staff_user_id' de tipo unsignedBigInteger
            $table->unsignedBigInteger('client_user_id'); // Columna 'client_user_id' de tipo unsignedBigInteger
            $table->unsignedBigInteger('service_id'); // Columna 'service_id' de tipo unsignedBigInteger
            $table->timestamps(); // Columnas 'created_at' y 'updated_at' de tipo timestamp

            // Define una clave foránea en la columna 'service_id' que referencia la columna 'id' en la tabla 'services'
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onUpdate('cascade') // Actualiza la clave foránea en cascada
                ->onDelete('cascade'); // Elimina los registros relacionados en cascada

            // Define una clave foránea en la columna 'client_user_id' que referencia la columna 'id' en la tabla 'users'
            $table->foreign('client_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade') // Actualiza la clave foránea en cascada
                ->onDelete('cascade'); // Elimina los registros relacionados en cascada

            // Define una clave foránea en la columna 'staff_user_id' que referencia la columna 'id' en la tabla 'users'
            $table->foreign('staff_user_id')
                ->references('id')
                ->on('users')
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
        // Elimina la tabla 'scheduler' si existe
        Schema::dropIfExists('scheduler');
    }
};
