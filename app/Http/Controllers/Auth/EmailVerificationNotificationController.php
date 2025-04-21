<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Enviar una nueva notificación de verificación de correo.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar.');
        }

        // Si ya está verificado, redirige según su rol
        if ($user->hasVerifiedEmail()) {
            if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            if (method_exists($user, 'isCollector') && $user->isCollector()) {
                return redirect()->route('collector.dashboard'); // Asegúrate de tener esta ruta
            }

            return redirect('/'); // Usuario normal
        }

        // Enviar nueva notificación de verificación
        $user->sendEmailVerificationNotification();

        return back()->with('status', 'Se ha enviado un nuevo enlace de verificación a tu correo electrónico.');
    }
}
