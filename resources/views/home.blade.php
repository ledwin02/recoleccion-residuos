@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Bienvenido, {{ $user->name }} al panel principal</h1>

        @if($user->hasVerifiedEmail())
            <p>¡Has iniciado sesión exitosamente y tu correo está verificado!</p>
        @else
            <p>Tu correo electrónico aún no está verificado. Por favor, verifica tu correo para acceder a todas las funciones.</p>
        @endif

        @if($pendingRequests > 0)
            <div class="alert alert-warning mt-3">
                <strong>¡Atención!</strong> Tienes {{ $pendingRequests }} solicitud(es) de recolección pendiente(s).
            </div>
        @else
            <p class="mt-3">No tienes solicitudes pendientes de recolección.</p>
        @endif

        <!-- Agregar más contenido o estadísticas según se requiera -->
    </div>
@endsection
