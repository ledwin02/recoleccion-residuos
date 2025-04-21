<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * La ruta de inicio tras el login o registro.
     */
    public const HOME = '/home'; // Ruta post-login básica
    public const VERIFIED_HOME = '/collections'; // Ruta para verificados

    /**
     * Define las rutas de la aplicación.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // Rutas web (sesiones, CSRF, cookies)
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // Rutas API (sin estado, throttle)
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));
        });
    }

    /**
     * Configura limitación de peticiones para API.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        // Aquí puedes definir limitaciones por IP, usuario, etc.
        // Ejemplo:
        // RateLimiter::for('api', function (Request $request) {
        //     return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        // });
    }
}
