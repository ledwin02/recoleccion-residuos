@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Panel de Administración</h1>

    {{-- Resumen de estadísticas --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Usuarios</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $userCount }}</h5>
                    <p class="card-text">Registrados</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Solicitudes</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $requestCount }}</h5>
                    <p class="card-text">Totales</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Pendientes</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $pendingCount }}</h5>
                    <p class="card-text">Por atender</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Recolectores</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $collectorCount }}</h5>
                    <p class="card-text">Empresas activas</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Últimas solicitudes --}}
    <div class="card mb-4">
        <div class="card-header">Últimas solicitudes de recolección</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Tipo de residuo</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestRequests as $request)
                    <tr>
                        <td>{{ $request->user->name }}</td>
                        <td>{{ $request->wasteType->name }}</td>
                        <td>{{ ucfirst($request->status) }}</td>
                        <td>{{ $request->scheduled_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Accesos rápidos --}}
    <div class="mb-4">
        <a href="{{ route('collection_requests.admin_index') }}" class="btn btn-outline-primary">Ver solicitudes</a>
        <a href="{{ route('collections.index') }}" class="btn btn-outline-success">Ver colecciones</a>
        <a href="#" class="btn btn-outline-warning">Agregar recolector</a>
        <a href="#" class="btn btn-outline-info">Ver usuarios</a>
    </div>
</div>
@endsection
