@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mis Solicitudes de Recolección</h1>
    <table class="table">
        <thead>
            <tr>
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
                    <td>{{ $request->wasteType->name }}</td>
                    <td>{{ $request->collection_date }}</td>
                    <td>{{ $request->weight ? $request->weight . ' Kg' : 'N/A' }}</td>
                    <td>
                        <span class="badge bg-{{ $request->statusColor }}">{{ $request->status }}</span>
                    </td>
                    <td>
                        @if($request->status == 'pending')
                            <a href="#" class="btn btn-danger" onclick="if(confirm('¿Estás seguro de cancelar esta solicitud?')) { document.getElementById('cancel-form-{{ $request->id }}').submit(); }">Cancelar</a>
                            <form id="cancel-form-{{ $request->id }}" action="{{ route('collection_requests.update_status', $request->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
