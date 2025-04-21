@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registrar Solicitud de Recolección</h2>

    <form action="{{ route('collection_requests.store') }}" method="POST">
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
            <label for="company_id" class="form-label">Empresa Recolectora</label>
            <select name="company_id" id="company_id" class="form-control" required>
                <option value="">Seleccione...</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="collection_date" class="form-label">Fecha de Recolección</label>
            <input type="date" name="collection_date" id="collection_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="collection_time" class="form-label">Hora de Recolección (opcional)</label>
            <input type="time" name="collection_time" id="collection_time" class="form-control">
        </div>

        <div class="mb-3">
            <label for="frequency" class="form-label">Frecuencia</label>
            <select name="frequency" id="frequency" class="form-control" required>
                <option value="">Seleccione...</option>
                <option value="weekly">Semanal</option>
                <option value="biweekly">Quincenal</option>
                <option value="monthly">Mensual</option>
                <option value="on_demand">Por demanda</option>
            </select>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_on_demand" id="is_on_demand" class="form-check-input">
            <label for="is_on_demand" class="form-check-label">¿Es por Demanda?</label>
        </div>

        <div class="mb-3">
            <label for="weight" class="form-label">Peso (solo para reciclables)</label>
            <input type="number" name="weight" id="weight" class="form-control" min="0" step="any">
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Notas Adicionales</label>
            <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Solicitud</button>
    </form>
</div>
@endsection
