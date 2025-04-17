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
    /**
     * Middleware de autenticación y autorización.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Listado de solicitudes para admin.
     */
    public function adminIndex(): View
    {
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
        $userRequests = auth()->user()
                            ->collectionRequests()
                            ->with(['wasteType', 'company'])
                            ->latest()
                            ->paginate(10);

        return view('collection_requests.index', compact('userRequests'));
    }

    /**
     * Formulario de creación de solicitud (usuario).
     */
    public function create(): View
    {
        return view('collection_requests.create', [
            'wasteTypes' => WasteType::all(),
            'companies' => CollecterCompany::all(),
        ]);
    }

    /**
     * Guarda una nueva solicitud en la base de datos.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'waste_type_id' => 'required|exists:waste_types,id',
            'company_id' => 'required|exists:collector_companies,id',
            'collection_date' => 'required|date|after_or_equal:today',
            'collection_time' => 'nullable|date_format:H:i',
            'frequency' => 'required|in:weekly,biweekly,monthly,on_demand',
            'is_on_demand' => 'boolean',
            'notes' => 'nullable|string|max:500',
            'weight' => 'nullable|numeric',
        ]);

        auth()->user()
            ->collectionRequests()
            ->create($data);

        return redirect()
            ->route('collection_requests.index')
            ->with('success', 'Solicitud creada correctamente.');
    }

    /**
     * Actualiza el estado de la solicitud (solo admin).
     */
    public function updateStatus(Request $request, CollectionRequest $collectionRequest): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,canceled',
        ]);

        $collectionRequest->update(['status' => $request->status]);

        return redirect()
            ->route('collection_requests.index')
            ->with('success', 'Estado actualizado correctamente.');
    }
}
