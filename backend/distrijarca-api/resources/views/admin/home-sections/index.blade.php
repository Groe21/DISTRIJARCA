@extends('layouts.admin')

@section('title', 'Secciones de la Página Principal')

@section('content')
<div class="container-fluid">
    <!-- Título y Botón -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-grid-3x3 me-2"></i>Secciones de la Página Principal</h2>
            <p class="text-muted">Administra las secciones de productos destacados que aparecen en la home</p>
        </div>
        <a href="{{ route('admin.home-sections.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Nueva Sección
        </a>
    </div>

    <!-- Mensajes de éxito/error -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tabla de Secciones -->
    <div class="card shadow-sm">
        <div class="card-body">
            @if($sections->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="60">Orden</th>
                                <th width="100">Imagen</th>
                                <th>Título</th>
                                <th>Categoría</th>
                                <th>Badge</th>
                                <th width="100" class="text-center">Max Prods.</th>
                                <th width="80" class="text-center">Estado</th>
                                <th width="200" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sections as $section)
                                <tr>
                                    <td class="text-center fw-bold">{{ $section->orden }}</td>
                                    <td>
                                        <img src="{{ $section->imagen_url }}" class="img-thumbnail" 
                                             style="height: 50px; width: 70px; object-fit: cover;"
                                             onerror="this.onerror=null; this.src='https://via.placeholder.com/70x50?text=Sin+Imagen';">
                                    </td>
                                    <td>
                                        <strong>{{ $section->titulo }}</strong>
                                        @if($section->subtitulo)
                                            <br><small class="text-muted">{{ $section->subtitulo }}</small>
                                        @endif
                                        <br><small class="text-muted">{{ Str::limit($section->descripcion, 60) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $section->category->nombre }}</span>
                                    </td>
                                    <td>
                                        @if($section->badge_texto)
                                            <span class="badge bg-{{ $section->badge_color }}">{{ $section->badge_texto }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ $section->max_productos }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($section->activo)
                                            <span class="badge bg-success">Activa</span>
                                        @else
                                            <span class="badge bg-secondary">Inactiva</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.home-sections.edit', $section) }}" 
                                               class="btn btn-sm btn-primary" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.home-sections.toggle-status', $section) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-{{ $section->activo ? 'warning' : 'success' }}" 
                                                        title="{{ $section->activo ? 'Desactivar' : 'Activar' }}">
                                                    <i class="bi bi-{{ $section->activo ? 'eye-slash' : 'eye' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.home-sections.destroy', $section) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('¿Estás seguro de eliminar esta sección?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
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
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <h4 class="mt-3 text-muted">No hay secciones creadas</h4>
                    <p class="text-muted">Crea tu primera sección para la página principal</p>
                    <a href="{{ route('admin.home-sections.create') }}" class="btn btn-primary mt-3">
                        <i class="bi bi-plus-lg me-2"></i>Crear Primera Sección
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
