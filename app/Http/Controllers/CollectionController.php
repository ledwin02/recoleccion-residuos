<?php

namespace App\Http\Controllers;

use App\Models\CollectionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;
use App\Models\WasteType;
use App\Models\CollectorCompany;

class CollectionController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        // Eliminamos el middleware aquí ya que lo manejamos en las rutas
        $this->notificationService = $notificationService;
    }

    /**
     * Muestra el listado paginado de solicitudes de recolección del usuario autenticado.
     */
    public function index(bool $onlyMine = false): View
    {
        $query = CollectionRequest::with(['wasteType', 'company']);

        if ($onlyMine) {
            $query->where('user_id', Auth::id());
        }

        $collections = $query->latest()->paginate(10);

        return view('collections.index', compact('collections'));
    }

    /**
     * Almacena una nueva solicitud de recolección.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateRequest($request);

        try {
            $collectionRequest = Auth::user()->collectionRequests()->create($validated);
            $this->sendNotification($collectionRequest);

            return redirect()
                ->route('collections.index')
                ->with('success', 'Recolección programada correctamente');
        } catch (\Exception $e) {
            $this->logError($e, $request);
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al programar la recolección. Por favor intente nuevamente.');
        }
    }

    /**
     * Valida los datos de la solicitud.
     */
    protected function validateRequest(Request $request): array
    {
        return $request->validate([
            'waste_type_id'   => 'required|exists:waste_types,id',
            'company_id'      => 'required|exists:collector_companies,id',
            'collection_date' => 'required|date|after:today',
            'collection_time' => 'nullable|date_format:H:i',
            'frequency'       => 'required|in:weekly,biweekly,monthly,on_demand',
            'notes'           => 'nullable|string|max:500',
        ]);
    }

    /**
     * Envía notificación al usuario.
     */
    public function create()
{
    $wasteTypes = WasteType::all();
    $companies = CollectorCompany::all();

    return view('collections.create', compact('wasteTypes', 'companies'));
}
    protected function sendNotification(CollectionRequest $collectionRequest): void
    {
        try {
            $this->notificationService->sendTemplateNotification(
                'collection-scheduled',
                Auth::user(),
                [
                    'name'       => Auth::user()->name,
                    'waste_type' => $collectionRequest->wasteType->name,
                    'date'       => $collectionRequest->collection_date->format('d/m/Y H:i'),
                ]
            );
        } catch (\Exception $e) {
            Log::error('Error enviando notificación', [
                'error'   => $e->getMessage(),
                'user_id' => Auth::id(),
                'request' => $collectionRequest->id,
            ]);
        }
    }

    /**
     * Registra errores en el log.
     */
    protected function logError(\Exception $e, Request $request): void
    {
        Log::error('Error al programar recolección', [
            'error'        => $e->getMessage(),
            'user_id'      => Auth::id(),
            'request_data' => $request->except(['_token', 'password']), // Excluye datos sensibles
        ]);
    }
}
