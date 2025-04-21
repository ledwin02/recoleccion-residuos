<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    /**
     * Mostrar la vista para confirmar la contraseña.
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirmar la contraseña del usuario actual.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Verifica que las credenciales sean válidas
        if (! $user || ! Auth::guard('web')->validate([
            'email' => $user->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        // Marca la contraseña como confirmada recientemente
        $request->session()->put('auth.password_confirmed_at', time());

        // Redirección basada en rol
        if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return redirect()->route('admin.dashboard'); // Asegúrate de tener esta ruta
        }

        if (method_exists($user, 'isCollector') && $user->isCollector()) {
            return redirect()->route('collector.dashboard'); // Si tienes recolectores
        }

        // Redirección para usuarios normales
        return redirect()->route('home'); // Esta ruta debería existir
    }
}
