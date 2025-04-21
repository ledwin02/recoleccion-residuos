<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard del usuario.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = Auth::user();

        // Verificar si el usuario está autenticado
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder al dashboard.');
        }

        // Aquí puedes pasar datos relevantes al dashboard, como estadísticas o el estado del usuario
        // Por ejemplo, el número de solicitudes de recolección pendientes
        $pendingRequests = $user->collectionRequests()->where('status', 'pendiente')->count();

        return view('dashboard', compact('pendingRequests'));
    }
}
