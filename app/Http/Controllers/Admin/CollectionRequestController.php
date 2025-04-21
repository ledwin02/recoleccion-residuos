<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CollectionRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CollectionRequestController extends Controller
{
    /**
     * Muestra todas las solicitudes de recolección.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(): View|RedirectResponse
    {
        // Verificación de permisos: si el usuario no está autenticado, redirige al login.
        $user = auth()->user();

        if (!$user) {
            // Si no está autenticado, redirige al login.
            return redirect()->route('login')->with('error', 'Debes estar autenticado para acceder.');
        }

        // Si el usuario no es admin, redirige a la página principal del admin.
        if (!$user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        // Obtener todas las solicitudes de recolección con sus relaciones.
        try {
            $requests = CollectionRequest::with(['user', 'wasteType', 'company'])->get();
        } catch (\Exception $e) {
            // En caso de error al cargar las solicitudes.
            return redirect()->route('admin.dashboard')->with('error', 'Error al cargar las solicitudes de recolección.');
        }

        // Retorna la vista con las solicitudes de recolección.
        return view('admin.collection_requests.index', compact('requests'));
    }
}
