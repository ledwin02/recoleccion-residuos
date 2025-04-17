@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Detalle de Notificación #{{ $notificationLog->id }}</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Información Básica</h6>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Usuario:</dt>
                        <dd class="col-sm-8">{{ $notificationLog->user->name ?? 'N/A' }}</dd>

                        <dt class="col-sm-4">Recolección:</dt>
                        <dd class="col-sm-8">
                            @if($notificationLog->collectionRequest)
                                <a href="{{ route('collections.show', $notificationLog->collectionRequest) }}">
                                    #{{ $notificationLog->collectionRequest->id }}
                                </a>
                            @else
                                N/A
                            @endif
                        </dd>

                        <dt class="col-sm-4">Fecha:</dt>
                        <dd class="col-sm-8">{{ $notificationLog->created_at }}</dd>

                        <dt class="col-sm-4">Canal:</dt>
                        <dd class="col-sm-8">{{ ucfirst($notificationLog->channel) }}</dd>

                        <dt class="col-sm-4">Estado:</dt>
                        <dd class="col-sm-8">
                            @if($notificationLog->success)
                                <span class="badge badge-success">Éxito</span>
                            @else
                                <span class="badge badge-danger">Fallido</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Contenido</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Mensaje:</h5>
                        <pre class="bg-light p-3">{{ $notificationLog->message }}</pre>
                    </div>

                    @if(!$notificationLog->success)
                    <div>
                        <h5>Error:</h5>
                        <pre class="bg-light p-3 text-danger">{{ $notificationLog->error }}</pre>

                        @if($notificationLog->metadata)
                        <h5 class="mt-3">Metadata:</h5>
                        <pre class="bg-light p-3">{{ json_encode($notificationLog->metadata, JSON_PRETTY_PRINT) }}</pre>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
        Volver al listado
    </a>
</div>
@endsection
