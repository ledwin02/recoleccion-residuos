<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Actualiza la contraseña del usuario.
     */
    public function update(Request $request): RedirectResponse
    {
        // Validación de la solicitud para cambiar la contraseña
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'], // Asegura que la contraseña actual es válida
            'password' => ['required', Password::defaults(), 'confirmed'], // Asegura que la nueva contraseña es válida y confirmada
        ]);

        // Actualizar la contraseña en el modelo de usuario
        $request->user()->update([
            'password' => Hash::make($validated['password']), // Usamos Hash::make para asegurar la contraseña
        ]);

        // Redirigir de vuelta con un mensaje de éxito
        return back()->with('status', 'password-updated');
    }
}
