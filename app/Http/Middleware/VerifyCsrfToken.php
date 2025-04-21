<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Las URIs que deben excluirse de la verificación CSRF.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*',          // Excluir todas las rutas de la API
        'webhook/*',      // Excluir rutas de webhook externas
        // Añade más rutas si es necesario
    ];

    /**
     * Determina si la solicitud debe pasar por la verificación CSRF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function shouldPassThrough($request): bool
    {
        // Verificar si el URI coincide con las rutas excluidas
        foreach ($this->except as $pattern) {
            if ($request->is($pattern)) {
                return true; // Excluir de la verificación CSRF
            }
        }

        return parent::shouldPassThrough($request); // Aplicar CSRF para las demás rutas
    }
}
