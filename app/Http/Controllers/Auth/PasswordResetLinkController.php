<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Muestra la vista para solicitar el enlace de restablecimiento de contraseña.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Maneja la solicitud de restablecimiento de contraseña.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validación del correo electrónico proporcionado
        $request->validate([
            'email' => ['required', 'email'], // Asegura que el correo tenga el formato correcto
        ]);

        // Intentamos enviar el enlace de restablecimiento de contraseña
        $status = Password::sendResetLink(
            $request->only('email') // Solo el correo electrónico
        );

        // Redirigir de vuelta con el estado del envío del enlace
        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status)) // Éxito: El enlace ha sido enviado
                    : back()->withInput($request->only('email')) // Error: Mostrar errores si no fue posible
                        ->withErrors(['email' => __($status)]);
    }
}
