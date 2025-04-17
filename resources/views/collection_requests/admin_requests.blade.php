@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Solicitudes de Recolección (Administrador)</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Tipo de Residuo</th>
                    <th>Fecha de Recolección</th>
                    <th>Peso</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($collectionRequests as $request)
                    <tr>
                        <td>{{ $request->user->name }}</td>
                        <td>{{ $request->wasteType->name }}</td>
                        <td>{{ $request->collection_date }}</td>
                        <td>{{ $request->weight ? $request->weight . ' Kg' : 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $request->statusColor }}">{{ $request->status }}</span>
                        </td>
                        <td>
                            @if($request->status == 'pending')
                                <a href="{{ route('collection_requests.update_status', ['id' => $request->id, 'status' => 'scheduled']) }}"
                                    class="btn btn-info">Programar</a>
                            @elseif($request->status == 'scheduled')
                                <a href="{{ route('collection_requests.update_status', ['id' => $request->id, 'status' => 'completed']) }}"
                                    class="btn btn-success">Marcar como Completado</a>
                            @elseif($request->status == 'completed')
                                <a href="{{ route('collection_requests.update_status', ['id' => $request->id, 'status' => 'cancelled']) }}"
                                    class="btn btn-danger">Cancelar</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
