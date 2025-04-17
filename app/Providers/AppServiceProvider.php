<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\NotificationService; // Importa tu servicio

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registrar NotificationService como singleton
        $this->app->singleton(NotificationService::class, function ($app) {
            return new NotificationService(); // Asegúrate de que NotificationService no requiera parámetros adicionales
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Aquí puedes agregar lógica si necesitas algo en el inicio
    }
}
