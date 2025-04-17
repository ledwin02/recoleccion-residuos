@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Registro de Notificaciones</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Historial</h6>
            <div class="btn-group">
                <a href="?failed=1" class="btn btn-sm btn-danger">Solo fallidas</a>
                <a href="?" class="btn btn-sm btn-secondary">Limpiar filtros</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Fecha</th>
                            <th>Canal</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr class="{{ $log->success ? '' : 'table-danger' }}">
                            <td>{{ $log->id }}</td>
                            <td>{{ $log->user->name ?? 'N/A' }}</td>
                            <td>{{ $log->created_at }}</td>
                            <td>{{ ucfirst($log->channel) }}</td>
                            <td>
                                @if($log->success)
                                    <span class="badge badge-success">Éxito</span>
                                @else
                                    <span class="badge badge-danger">Fallido</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.notifications.show', $log) }}"
                                   class="btn btn-sm btn-info">
                                    Detalles
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
