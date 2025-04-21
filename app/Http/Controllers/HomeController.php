<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Muestra la página principal tras el login.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Verificar si el usuario tiene el correo verificado
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice'); // Redirige a la página de verificación
        }

        // Aquí puedes incluir cualquier otro dato relevante para la vista de inicio
        // Por ejemplo, estadísticas de la cuenta del usuario o sus solicitudes pendientes

        $pendingRequests = $user->collectionRequests()->where('status', 'pendiente')->count();

        // Retornar la vista de la página principal (home) con los datos del usuario
        return view('home', compact('user', 'pendingRequests'));
    }
}
