<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Registra cualquier servicio de aplicación.
     *
     * @return void
     */
    public function register()
    {
        // Puedes registrar cualquier servicio de aplicación aquí si es necesario.
    }

    /**
     * Inicializa cualquier servicio de aplicación.
     *
     * @return void
     */
    public function boot()
    {
        // Establece el idioma para Carbon a español
        Carbon::setLocale('es');
    }
}
