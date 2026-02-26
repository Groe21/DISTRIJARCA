@extends('layouts.admin')

@section('title', 'Mensajes')

@section('content')
<div class="container-fluid">
    <!-- Título y filtros -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-envelope me-2"></i>Bandeja de Mensajes</h2>
            <p class="text-muted">Administra los mensajes de contacto recibidos</p>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Estadísticas rápidas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total de Mensajes</p>
                            <h4 class="mb-0">{{ \App\Models\Mensaje::count() }}</h4>
                        </div>
                        <i class="bi bi-envelope text-primary" style="font-size: 2rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">No leídos</p>
                            <h4 class="mb-0 text-danger">{{ $noLeidos }}</h4>
                        </div>
                        <i class="bi bi-envelope-open text-danger" style="font-size: 2rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Pendientes de Respuesta</p>
                            <h4 class="mb-0 text-warning">{{ $pendientes }}</h4>
                        </div>
                        <i class="bi bi-reply text-warning" style="font-size: 2rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Respondidos</p>
                            <h4 class="mb-0 text-success">{{ \App\Models\Mensaje::where('respondido', true)->count() }}</h4>
                        </div>
                        <i class="bi bi-check2-circle text-success" style="font-size: 2rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de mensajes -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Mensajes Recibidos</h5>
        </div>
        <div class="card-body">
            @if($mensajes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="mensajesTable">
                        <thead class="table-light">
                            <tr>
                                <th width="50"></th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Asunto</th>
                                <th width="80" class="text-center">Estado</th>
                                <th width="80" class="text-center">Respuesta</th>
                                <th width="100" class="text-center">Fecha</th>
                                <th width="120" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mensajes as $mensaje)
                                <tr class="{{ !$mensaje->leido ? 'table-active fw-bold' : '' }}">
                                    <td class="text-center">
                                        @if(!$mensaje->leido)
                                            <span class="badge bg-danger rounded-circle" style="height: 12px; width: 12px;"></span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $mensaje->nombre }}
                                        @if($mensaje->empresa)
                                            <br><small class="text-muted">{{ $mensaje->empresa }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $mensaje->email }}" class="text-decoration-none">
                                            {{ $mensaje->email }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="tel:{{ $mensaje->telefono }}" class="text-decoration-none">
                                            {{ $mensaje->telefono }}
                                        </a>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $mensaje->asunto }}</small>
                                    </td>
                                    <td class="text-center">
                                        @if($mensaje->leido)
                                            <span class="badge bg-success">Leído</span>
                                        @else
                                            <span class="badge bg-secondary">Nuevo</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($mensaje->respondido)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check2"></i>
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-hourglass-split"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center text-muted small">
                                        {{ $mensaje->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.mensajes.show', $mensaje) }}" 
                                               class="btn btn-primary" title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.mensajes.destroy', $mensaje) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('¿Estás seguro de eliminar este mensaje?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <nav class="mt-4">
                    {{ $mensajes->links() }}
                </nav>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <h4 class="mt-3 text-muted">No hay mensajes</h4>
                    <p class="text-muted">Cuando recibas mensajes de contacto, aparecerán aquí</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Función para marcar como leído sin recargar
    document.querySelectorAll('[data-marcar-leido]').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.dataset.marcarLeido;
            fetch(`/admin/mensajes/${id}/marcar-leido`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            }).then(r => r.json()).then(data => {
                if(data.success) location.reload();
            });
        });
    });
</script>

@endsection
