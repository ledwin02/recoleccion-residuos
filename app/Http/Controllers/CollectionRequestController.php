<?php

namespace App\Http\Controllers;

use App\Models\CollectionRequest;
use App\Models\WasteType;
use App\Models\CollectorCompany;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CollectionRequestController extends Controller
{
    public function __construct()
    {
        // Middleware de autenticación para asegurar que solo los usuarios autenticados accedan
        $this->middleware('auth');
    }

    /**
     * Muestra las solicitudes para el administrador.
     */
    public function adminIndex(): View
    {
        // El administrador puede ver todas las solicitudes
        $requests = CollectionRequest::with(['user', 'wasteType', 'company'])
                                     ->latest()
                                     ->get();

        return view('admin.collection_requests.index', compact('requests'));
    }

    /**
     * Lista las solicitudes del usuario autenticado.
     */
    public function index(): View
    {
        // El usuario puede ver solo sus propias solicitudes
        $userRequests = Auth::user()
            ->collectionRequests()
            ->with(['wasteType', 'company'])
            ->latest()
            ->paginate(10);

        return view('collection_requests.index', compact('userRequests'));
    }

    /**
     * Muestra el formulario para crear una solicitud de recolección.
     */
    public function create(): View
    {
        // Se obtienen los tipos de residuos y las empresas de recolección
        $wasteTypes = WasteType::all();
        $companies = CollectorCompany::all();

        return view('collection_requests.create', compact('wasteTypes', 'companies'));
    }

    /**
     * Almacena una nueva solicitud de recolección en la base de datos.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validación de la solicitud
        $data = $request->validate([
            'waste_type_id'    => 'required|exists:waste_types,id',
            'company_id'       => 'required|exists:collector_companies,id',
            'collection_date'  => 'required|date|after_or_equal:today',
            'collection_time'  => 'nullable|date_format:H:i',
            'frequency'        => 'required|in:weekly,biweekly,monthly,on_demand',
            'is_on_demand'     => 'boolean',  // Si la recolección es bajo demanda
            'notes'            => 'nullable|string|max:500',
            'weight'           => 'nullable|numeric',  // Peso de los residuos
        ]);

        // Se crea la solicitud de recolección asociada al usuario autenticado
        Auth::user()->collectionRequests()->create($data);

        return redirect()
            ->route('collection_requests.index')
            ->with('success', 'Solicitud de recolección creada correctamente.');
    }

    /**
     * Permite al administrador actualizar el estado de una solicitud.
     */
    public function updateStatus(Request $request, CollectionRequest $collectionRequest): RedirectResponse
    {
        // Validación para asegurarse de que el estado es válido
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,canceled',
        ]);

        // Actualizar el estado de la solicitud
        $collectionRequest->update(['status' => $request->status]);

        return redirect()
            ->route('collection_requests.index')
            ->with('success', 'Estado de la solicitud actualizado correctamente.');
    }
}
