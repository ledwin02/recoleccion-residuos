<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncryptCookies;
use Illuminate\Http\Request;
use Closure;

class EncryptCookies extends BaseEncryptCookies
{
    /**
     * Los nombres de las cookies que no deberían ser encriptadas.
     *
     * @var array
     */
    protected $except = [
        // Ejemplo: 'cookie_no_encriptada',
        // Aquí puedes añadir las cookies que no deseas encriptar.
    ];

    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Llamamos al método de la clase base
        return parent::handle($request, $next);
    }
}
