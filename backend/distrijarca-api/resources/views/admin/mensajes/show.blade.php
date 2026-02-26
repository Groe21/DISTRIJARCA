@extends('layouts.admin')

@section('title', 'Mensaje - ' . $mensaje->nombre)

@section('content')
<div class="container-fluid">
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.mensajes.index') }}" class="btn btn-outline-secondary btn-sm me-2">
                <i class="bi bi-arrow-left me-2"></i>Volver
            </a>
            <h2 class="d-inline-block"><i class="bi bi-envelope-open me-2"></i>{{ $mensaje->nombre }}</h2>
        </div>
        <div>
            <form action="{{ route('admin.mensajes.destroy', $mensaje) }}" 
                  method="POST" class="d-inline"
                  onsubmit="return confirm('¿Estás seguro de eliminar este mensaje?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="bi bi-trash me-2"></i>Eliminar
                </button>
            </form>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Contenido del mensaje (izquierda) -->
        <div class="col-lg-8">
            <!-- Información del remitente -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Información del Contacto</h5>
                        </div>
                        <div class="col-auto">
                            @if(!$mensaje->leido)
                                <span class="badge bg-danger">Nuevo</span>
                            @endif
                            @if($mensaje->respondido)
                                <span class="badge bg-success">Respondido</span>
                            @else
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted small mb-1">Nombre</p>
                            <h6 class="mb-0">{{ $mensaje->nombre }}</h6>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted small mb-1">Empresa</p>
                            <h6 class="mb-0">{{ $mensaje->empresa ?? '—' }}</h6>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted small mb-1">Email</p>
                            <a href="mailto:{{ $mensaje->email }}" class="text-decoration-none">
                                {{ $mensaje->email }}
                            </a>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted small mb-1">Teléfono</p>
                            <a href="tel:{{ $mensaje->telefono }}" class="text-decoration-none">
                                {{ $mensaje->telefono }}
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted small mb-1">Asunto</p>
                            <h6 class="mb-0">{{ $mensaje->asunto }}</h6>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted small mb-1">Fecha de recepción</p>
                            <h6 class="mb-0">{{ $mensaje->created_at->format('d/m/Y H:i') }}</h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mensaje -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Mensaje</h5>
                </div>
                <div class="card-body">
                    <p class="text-dark" style="white-space: pre-wrap; line-height: 1.6;">
                        {{ $mensaje->mensaje }}
                    </p>
                </div>
            </div>

            <!-- Respuesta (si existe) -->
            @if($mensaje->respondido && $mensaje->respuesta)
                <div class="card shadow-sm mb-4 border-success">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Respuesta Enviada</h5>
                            <small class="text-muted">{{ $mensaje->fecha_respuesta->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                    <div class="card-body bg-light">
                        <p class="text-dark" style="white-space: pre-wrap; line-height: 1.6;">
                            {{ $mensaje->respuesta }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Formulario de respuesta -->
            @if(!$mensaje->respondido)
                <div class="card shadow-sm border-primary">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-reply me-2"></i>Enviar Respuesta</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.mensajes.update', $mensaje) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="respuesta" class="form-label">Tu respuesta *</label>
                                <textarea name="respuesta" id="respuesta" class="form-control @error('respuesta') is-invalid @enderror" 
                                          rows="5" placeholder="Escribe tu respuesta aquí..." required>{{ old('respuesta') }}</textarea>
                                @error('respuesta')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block mt-2">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Será enviada al email del remitente automáticamente.
                                </small>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-send me-2"></i>Enviar Respuesta
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <!-- Panel lateral (derecha) -->
        <div class="col-lg-4">
            <!-- Estado y acciones -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Acciones</h5>
                </div>
                <div class="card-body">
                    @if(!$mensaje->leido)
                        <form action="{{ route('admin.mensajes.marcar-leido', $mensaje) }}" method="POST" class="mb-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-circle me-2"></i>Marcar como leído
                            </button>
                        </form>
                    @else
                        <p class="text-muted text-center mb-0">
                            <i class="bi bi-check-circle me-1"></i>Marcado como leído
                        </p>
                    @endif
                </div>
            </div>

            <!-- Información adicional -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Detalles del Mensaje</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="text-muted small mb-1">Estado de lectura</p>
                        <p class="mb-0">
                            @if($mensaje->leido)
                                <span class="badge bg-success">Leído el {{ $mensaje->updated_at->format('d/m/Y H:i') }}</span>
                            @else
                                <span class="badge bg-secondary">No leído</span>
                            @endif
                        </p>
                    </div>

                    <div class="mb-3">
                        <p class="text-muted small mb-1">Estado de respuesta</p>
                        <p class="mb-0">
                            @if($mensaje->respondido)
                                <span class="badge bg-success">Respondido el {{ $mensaje->fecha_respuesta->format('d/m/Y H:i') }}</span>
                            @else
                                <span class="badge bg-warning text-dark">Pendiente de respuesta</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <p class="text-muted small mb-1">Fecha de recepción</p>
                        <p class="mb-0 small">
                            {{ $mensaje->created_at->format('d/m/Y \\a \\l\\a\\s H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Acciones rápidas -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Contacto Rápido</h5>
                </div>
                <div class="card-body">
                    <a href="mailto:{{ $mensaje->email }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="bi bi-envelope me-2"></i>Enviar Email
                    </a>
                    <a href="tel:{{ $mensaje->telefono }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-telephone me-2"></i>Llamar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
