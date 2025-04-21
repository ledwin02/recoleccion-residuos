<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostrar la vista de login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Manejar la solicitud de autenticación.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Autenticación del usuario
        $request->authenticate();

        // Regenerar la sesión para proteger contra fijación de sesión
        $request->session()->regenerate(); // ✅ Usando $request->session()

        $user = Auth::user();

        // Verificar si el correo está verificado
        if (!$user->hasVerifiedEmail()) {
            Auth::logout(); // Cierra la sesión si no está verificado

            // ✅ Usamos el helper session() para mostrar un mensaje flash
            session()->flash('error', 'Debes verificar tu correo electrónico antes de continuar.');

            return redirect()->route('verification.notice');
        }

        // Redirigir según el tipo de usuario
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Redirigir al destino previsto o al HOME general
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Cerrar sesión y destruir sesión autenticada.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        // ✅ Estas llamadas están bien hechas
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
