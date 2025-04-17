@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Nueva solicitud de recolección</h2>

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups!</strong> Corrige los errores abajo.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario de solicitud --}}
    <form method="POST" action="{{ route('collections.store') }}">
        @csrf

        {{-- Tipo de residuo --}}
        <div class="mb-3">
            <label for="waste_type_id" class="form-label">Tipo de Residuo</label>
            <select name="waste_type_id" id="waste_type_id" class="form-select" required>
                <option value="">Selecciona uno</option>
                @foreach($wasteTypes as $wasteType)
                    <option value="{{ $wasteType->id }}" {{ old('waste_type_id') == $wasteType->id ? 'selected' : '' }}>
                        {{ $wasteType->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Empresa recolectora --}}
        <div class="mb-3">
            <label for="company_id" class="form-label">Empresa Recolectora</label>
            <select name="company_id" id="company_id" class="form-select" required>
                <option value="">Selecciona una</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Fecha de recolección --}}
        <div class="mb-3">
            <label for="collection_date" class="form-label">Fecha de Recolección</label>
            <input type="date" name="collection_date" id="collection_date" class="form-control" value="{{ old('collection_date') }}" required>
        </div>

        {{-- Hora de recolección --}}
        <div class="mb-3">
            <label for="collection_time" class="form-label">Hora de Recolección (opcional)</label>
            <input type="time" name="collection_time" id="collection_time" class="form-control" value="{{ old('collection_time') }}">
        </div>

        {{-- Frecuencia --}}
        <div class="mb-3">
            <label for="frequency" class="form-label">Frecuencia</label>
            <select name="frequency" id="frequency" class="form-select" required>
                <option value="">Selecciona una</option>
                <option value="weekly" {{ old('frequency') == 'weekly' ? 'selected' : '' }}>Semanal</option>
                <option value="biweekly" {{ old('frequency') == 'biweekly' ? 'selected' : '' }}>Quincenal</option>
                <option value="monthly" {{ old('frequency') == 'monthly' ? 'selected' : '' }}>Mensual</option>
                <option value="on_demand" {{ old('frequency') == 'on_demand' ? 'selected' : '' }}>Por demanda</option>
            </select>
        </div>

        {{-- Notas opcionales --}}
        <div class="mb-3">
            <label for="notes" class="form-label">Notas (opcional)</label>
            <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
        </div>

        {{-- Botón para enviar el formulario --}}
        <button type="submit" class="btn btn-primary">Solicitar recolección</button>
    </form>
</div>
@endsection
