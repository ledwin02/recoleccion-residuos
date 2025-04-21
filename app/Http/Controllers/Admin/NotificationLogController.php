<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class NotificationLogController extends Controller
{
    /**
     * Muestra todos los registros de notificación con filtros opcionales.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        // Verificación de permisos: asegurarse de que el usuario es administrador
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            // Retorna un RedirectResponse si el usuario no es admin
            return redirect()->route('admin.dashboard')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        // Construcción de la consulta para obtener los registros de notificación con filtros
        $logs = NotificationLog::with(['user', 'collectionRequest'])
            ->when($request->has('failed'), function ($query) {
                return $query->where('success', false);
            })
            ->when($request->has('channel'), function ($query) use ($request) {
                return $query->where('channel', $request->channel);
            })
            ->latest()
            ->paginate(25);

        // Retorna la vista con los logs
        return view('admin.notifications.index', compact('logs'));
    }

    /**
     * Muestra un registro de notificación específico.
     *
     * @param  \App\Models\NotificationLog  $notificationLog
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(NotificationLog $notificationLog): View|RedirectResponse
    {
        // Verificación de permisos: asegurarse de que el usuario es administrador
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            // Retorna un RedirectResponse si el usuario no es admin
            return redirect()->route('admin.dashboard')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        // Retorno de la vista con el detalle del log
        return view('admin.notifications.show', compact('notificationLog'));
    }
}
