@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Solicitudes de Recolección</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Tipo de Residuo</th>
                <th>Fecha</th>
                <th>Frecuencia</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($requests as $request)
                <tr>
                    <td>{{ $request->user->name }}</td>
                    <td>{{ $request->wasteType->name }}</td>
                    <td>{{ $request->collection_date->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($request->frequency) }}</td>
                    <td>
                        <span class="badge bg-{{ $request->status_color }}">
                            {{ ucfirst($request->status) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.collection_requests.update', $request->id) }}" method="POST" class="d-flex">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-select me-2">
                                <option value="pendiente" {{ $request->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="recolectado" {{ $request->status == 'recolectado' ? 'selected' : '' }}>Recolectado</option>
                                <option value="cancelado" {{ $request->status == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay solicitudes registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
