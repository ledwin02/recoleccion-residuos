<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;  // Asegúrate de importar Request
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Marcar el correo electrónico del usuario autenticado como verificado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        // Verificar si el usuario está autenticado
        if (!$request->user()) {
            return redirect()->route('login');  // Redirigir al login si no está autenticado
        }

        /** @var User $user */
        $user = $request->user();  // Obtenemos al usuario autenticado

        // Si el correo ya está verificado, redirigir al usuario
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
        }

        // Marcar el correo como verificado
        $user->markEmailAsVerified();

        // Redirigir a la página de recolección o alguna ruta relacionada
        return redirect()->route('collections.index'); // Ajusta esta ruta según tu flujo
    }
}
