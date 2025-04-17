@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-4 px-4">
    <h2 class="text-2xl font-semibold mb-4">Mis Solicitudes de Recolección</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($userRequests->isEmpty())
        <div class="bg-blue-100 text-blue-800 p-4 rounded">
            No tienes solicitudes todavía.
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($userRequests as $request)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="bg-blue-600 text-white p-4">
                        <h3 class="font-semibold">{{ $request->wasteType->name }}</h3>
                    </div>
                    <div class="p-4">
                        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($request->collection_date)->format('d/m/Y') }}</p>
                        <p><strong>Hora:</strong> {{ $request->collection_time ?? 'No especificada' }}</p>
                        <p><strong>Empresa:</strong> {{ $request->company->name }}</p>
                        <p><strong>Frecuencia:</strong> {{ ucfirst(str_replace('_', ' ', $request->frequency)) }}</p>
                        @if($request->weight)
                            <p><strong>Peso:</strong> {{ $request->weight }} kg</p>
                        @endif
                        <p>
                            <strong>Estado:</strong>
                            <span class="inline-block px-3 py-1 text-white rounded-full
                                @if($request->status == 'pending')
                                    bg-yellow-400
                                @elseif($request->status == 'in_progress')
                                    bg-blue-400
                                @elseif($request->status == 'completed')
                                    bg-green-400
                                @elseif($request->status == 'canceled')
                                    bg-red-400
                                @else
                                    bg-gray-400
                                @endif
                            ">
                                {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                            </span>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $userRequests->links() }}
        </div>
    @endif
</div>
@endsection
