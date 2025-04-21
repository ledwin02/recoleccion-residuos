<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\CollectionRequest;
use App\Models\CollectorCompany;

class AdminDashboardController extends Controller
{
    /**
     * Muestra el panel de administración.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();

        // Asegurar que el usuario está autenticado y es administrador
        if (!$user || !$user->isAdmin()) {
            return redirect()->route('home')->with('error', 'No tienes permiso para acceder al panel de administración.');
        }

        // Recolección de datos para estadísticas del dashboard
        $userCount       = User::count(); // Total de usuarios
        $requestCount    = CollectionRequest::count(); // Total de solicitudes de recolección
        $pendingCount    = CollectionRequest::where('status', 'pendiente')->count(); // Solicitudes pendientes
        $collectorCount  = CollectorCompany::count(); // Total de empresas de recolección
        $latestRequests  = CollectionRequest::with(['user', 'wasteType'])
                                ->latest()
                                ->take(5) // Últimas 5 solicitudes
                                ->get();

        // Retornar la vista del panel de administración con los datos
        return view('admin.dashboard', compact(
            'userCount',
            'requestCount',
            'pendingCount',
            'collectorCount',
            'latestRequests'
        ));
    }
}
