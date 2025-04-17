@extends('layouts.app') {{-- Usa tu layout principal --}}

@section('content')
<div class="container">
    <h2>Registrar Solicitud de Recolección</h2>

    <form action="{{ route('collections.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="waste_type_id" class="form-label">Tipo de Residuo</label>
            <select name="waste_type_id" id="waste_type_id" class="form-control" required>
                <option value="">Seleccione...</option>
                @foreach ($wasteTypes as $wasteType)
                    <option value="{{ $wasteType->id }}">{{ $wasteType->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="collection_date" class="form-label">Fecha de Recolección</label>
            <input type="date" name="collection_date" id="collection_date" class="form-control" required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_on_demand" id="is_on_demand" class="form-check-input">
            <label for="is_on_demand" class="form-check-label">¿Es por Demanda?</label>
        </div>

        <div class="mb-3">
            <label for="weight" class="form-label">Peso (solo para reciclables)</label>
            <input type="number" name="weight" id="weight" class="form-control" min="0" step="any">
        </div>

        <button type="submit" class="btn btn-primary">Registrar Solicitud</button>
    </form>
</div>
@endsection
