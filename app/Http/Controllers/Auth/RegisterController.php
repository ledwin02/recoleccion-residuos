<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Location;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Muestra el formulario de registro.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        // Obtener todas las ubicaciones disponibles para mostrar en el formulario
        $locations = Location::all();
        return view('auth.register', compact('locations'));
    }

    /**
     * Maneja una solicitud de registro entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(Request $request)
    {
        // Validar los datos del formulario
        $this->validator($request->all())->validate();

        // Crear el nuevo usuario
        event(new Registered($user = $this->create($request->all())));

        // Iniciar sesión del usuario inmediatamente después de la creación
        Auth::login($user);

        // Verificar el rol del usuario para redirigirlo a la página correspondiente
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isCollector()) {
            return redirect()->route('collector.dashboard');
        }

        // Redirigir a la página principal para usuarios regulares
        return redirect()->route('home');
    }

    /**
     * Obtiene un validador para una solicitud de registro.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:15'],
            'location_id' => ['required', 'exists:locations,id'], // Asegurarse de que la ubicación existe
            'role' => ['required', 'in:admin,collector,user'], // Validar que el rol sea uno de los tres disponibles
            'password' => ['required', 'string', 'min:8', 'confirmed'], // Validar la contraseña con mínimo de 8 caracteres y confirmación
        ]);
    }

    /**
     * Crea una nueva instancia de usuario después de la validación.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Crear el nuevo usuario con los datos validados
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'location_id' => $data['location_id'], // Asociar la ubicación
            'role' => $data['role'], // Establecer el rol del usuario
            'password' => Hash::make($data['password']), // Encriptar la contraseña
        ]);
    }
}
