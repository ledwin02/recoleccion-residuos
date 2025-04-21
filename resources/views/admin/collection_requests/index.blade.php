@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-4 px-4">
    <h2 class="text-2xl font-semibold mb-4">Solicitudes de Recolección</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($requests->isEmpty())
        <div class="bg-blue-100 text-blue-800 p-4 rounded">
            No hay solicitudes de recolección en este momento.
        </div>
    @else
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">Usuario</th>
                    <th class="px-4 py-2 border">Tipo de Residuo</th>
                    <th class="px-4 py-2 border">Fecha de Recolección</th>
                    <th class="px-4 py-2 border">Hora</th>
                    <th class="px-4 py-2 border">Estado</th>
                    <th class="px-4 py-2 border">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $request)
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $request->user->name }}</td>
                        <td class="px-4 py-2 border">{{ optional($request->wasteType)->name ?? 'Desconocido' }}</td>
                        <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($request->collection_date)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2 border">{{ $request->collection_time ?? 'No especificada' }}</td>
                        <td class="px-4 py-2 border">
                            <span class="inline-block px-3 py-1 text-white rounded-full
                                @if($request->status == 'pending')
                                    bg-yellow-500
                                @elseif($request->status == 'in_progress')
                                    bg-blue-500
                                @elseif($request->status == 'completed')
                                    bg-green-500
                                @elseif($request->status == 'canceled')
                                    bg-red-500
                                @else
                                    bg-gray-500
                                @endif
                            ">
                                {{ match($request->status) {
                                    'pending' => 'Pendiente',
                                    'in_progress' => 'En Proceso',
                                    'completed' => 'Completada',
                                    'canceled' => 'Cancelada',
                                    default => ucfirst($request->status),
                                } }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border">
                            <form action="{{ route('collection_requests.update_status', $request) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <select name="status" class="form-control" onchange="this.form.submit()">
                                    <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="in_progress" {{ $request->status == 'in_progress' ? 'selected' : '' }}>En Proceso</option>
                                    <option value="completed" {{ $request->status == 'completed' ? 'selected' : '' }}>Completada</option>
                                    <option value="canceled" {{ $request->status == 'canceled' ? 'selected' : '' }}>Cancelada</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $requests->links() }}
        </div>
    @endif
</div>
@endsection
