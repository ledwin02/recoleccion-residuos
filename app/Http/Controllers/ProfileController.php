<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Muestra el formulario de perfil del usuario.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request): View
    {
        // Usar Auth::user() en lugar de $request->user()
        return view('profile.edit', [
            'user' => Auth::user(),  // Aquí se obtiene el usuario autenticado
        ]);
    }

    /**
     * Actualiza la información del perfil del usuario.
     *
     * @param \App\Http\Requests\ProfileUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Usar Auth::user() en lugar de $request->user()
        $user = Auth::user();  // Aquí se obtiene el usuario autenticado

        // Actualiza los campos validados
        $user->fill($request->validated());

        // Si el email fue modificado, se invalida la verificación
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Elimina la cuenta del usuario.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Usar Auth::user() en lugar de $request->user()
        $user = Auth::user();  // Aquí se obtiene el usuario autenticado

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
