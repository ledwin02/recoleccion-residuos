@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Mis solicitudes de recolección</h2>
        <a href="{{ route('collections.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Nueva solicitud
        </a>
    </div>

    <!-- Mensajes de estado -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Contenido principal -->
    @if ($collections->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <h5 class="card-title">No tienes solicitudes registradas</h5>
                <p class="card-text">Comienza creando tu primera solicitud de recolección</p>
                <a href="{{ route('collections.create') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-plus me-1"></i> Crear solicitud
                </a>
            </div>
        </div>
    @else
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tipo de residuo</th>
                            <th>Empresa recolectora</th>
                            <th>Fecha programada</th>
                            <th>Estado</th>
                            <th>Notas</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collections as $request)
                            <tr>
                                <td>{{ $request->wasteType->name ?? 'No especificado' }}</td>
                                <td>{{ $request->company->name ?? 'No asignada' }}</td>
                                <td>
                                    {{ $request->collection_date->format('d/m/Y') }}
                                    @if($request->collection_time)
                                        <small class="text-muted d-block">{{ $request->collection_time->format('H:i') }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-{{ $request->status_color }}">
                                        {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                    </span>
                                </td>
                                <td>
                                    @if($request->notes)
                                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip"
                                                title="{{ $request->notes }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('collections.show', $request->id) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($request->status === 'pending')
                                        <a href="{{ route('collections.edit', $request->id) }}"
                                           class="btn btn-sm btn-outline-warning ms-1"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($collections->hasPages())
                <div class="card-footer d-flex justify-content-center">
                    {{ $collections->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Activar tooltips de Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
