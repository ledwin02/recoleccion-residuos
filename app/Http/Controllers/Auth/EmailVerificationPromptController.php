<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Mostrar el aviso de verificación de correo.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        // Si el usuario ya ha verificado su correo, redirige según su rol
        if ($request->user()->hasVerifiedEmail()) {
            // Redirigir según el tipo de usuario (admin, collector, etc.)
            if ($request->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            if ($request->user()->isCollector()) {
                return redirect()->route('collector.dashboard'); // Asegúrate de tener esta ruta definida
            }

            return redirect('/'); // Redirige a la página de inicio para usuarios normales
        }

        // Si el correo no ha sido verificado, muestra la vista de verificación
        return view('auth.verify-email');
    }
}
