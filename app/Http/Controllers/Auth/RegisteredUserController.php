<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Mostrar el formulario de registro.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('auth.register');  // Asegúrate de que la vista auth.register exista y esté configurada correctamente
    }

    /**
     * Manejar una solicitud de registro entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validación de los datos del formulario
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class, 'lowercase'],  // Validación de email en minúsculas
            'password' => ['required', 'confirmed', Rules\Password::defaults()],  // Confirmación de la contraseña
        ]);

        // Crear un nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),  // Asegura que el email esté en minúsculas
            'password' => Hash::make($request->password),
        ]);

        // Disparar el evento Registered
        event(new Registered($user));

        // Iniciar sesión del usuario inmediatamente después del registro
        Auth::login($user);

        // Redirigir al usuario a su dashboard
        return redirect(route('dashboard', absolute: false));  // Asegúrate de que 'dashboard' sea una ruta válida en tu aplicación
    }
}
