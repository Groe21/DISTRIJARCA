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

    <!-- Hero Principal (arriba de secciones) -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1"><i class="bi bi-image me-2"></i>Hero Principal</h5>
                <small class="text-muted">Configura la imagen principal, la imagen de fondo y el texto</small>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.home-hero.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label">Texto del Hero</label>
                    <textarea name="texto" class="form-control" rows="4" required>{{ old('texto', $hero->texto ?? 'Más de 15 años distribuyendo productos premium con garantía de frescura.\nSomos tu socio confiable en quesos y embutidos de calidad.') }}</textarea>
                    <small class="text-muted">Usa salto de línea para separar frases.</small>
                </div>

                <div class="mb-4">
                    <label class="form-label">Imagen de Fondo</label>
                    <input type="file" name="imagen_fondo" class="form-control" accept="image/*">
                    <small class="text-muted">Recomendado: 1920x1080px</small>
                    @if($hero && $hero->imagen_fondo)
                        <div class="mt-3">
                            <img src="{{ $hero->imagen_fondo_url }}" alt="Imagen de fondo" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    @endif
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Guardar Hero
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sección Nosotros (arriba de secciones) -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1"><i class="bi bi-info-circle me-2"></i>Sección Nosotros</h5>
                <small class="text-muted">Configura el contenido que aparece en la sección intermedia</small>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.home-about.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Etiqueta</label>
                        <input type="text" name="label" class="form-control" required
                               value="{{ old('label', $about->label ?? 'Nuestra Historia') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Título (parte 1)</label>
                        <input type="text" name="title_before" class="form-control" required
                               value="{{ old('title_before', $about->title_before ?? 'Más de') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Título (destacado)</label>
                        <input type="text" name="title_highlight" class="form-control" required
                               value="{{ old('title_highlight', $about->title_highlight ?? '15 años') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Título (parte 2)</label>
                    <input type="text" name="title_after" class="form-control" required
                           value="{{ old('title_after', $about->title_after ?? 'llevando sabor a tu mesa') }}">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Párrafo 1</label>
                        <textarea name="paragraph_1" class="form-control" rows="4" required>{{ old('paragraph_1', $about->paragraph_1 ?? 'En DISTRI-JARCA, comenzamos como un pequeño negocio familiar con una pasión por los productos lácteos y cárnicos de calidad. Hoy somos reconocidos como uno de los principales distribuidores de quesos y embutidos en la región.') }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Párrafo 2</label>
                        <textarea name="paragraph_2" class="form-control" rows="4">{{ old('paragraph_2', $about->paragraph_2 ?? 'Trabajamos directamente con productores seleccionados, garantizando la trazabilidad y frescura de cada producto. Nuestra red de distribución cubre toda la región, asegurando entregas puntuales y en condiciones óptimas.') }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Estadística 1</label>
                        <input type="text" name="stat_1_value" class="form-control" required
                               value="{{ old('stat_1_value', $about->stat_1_value ?? '15+') }}">
                        <input type="text" name="stat_1_label" class="form-control mt-2" required
                               value="{{ old('stat_1_label', $about->stat_1_label ?? 'Años de experiencia') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Estadística 2</label>
                        <input type="text" name="stat_2_value" class="form-control" required
                               value="{{ old('stat_2_value', $about->stat_2_value ?? '500+') }}">
                        <input type="text" name="stat_2_label" class="form-control mt-2" required
                               value="{{ old('stat_2_label', $about->stat_2_label ?? 'Clientes satisfechos') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Estadística 3</label>
                        <input type="text" name="stat_3_value" class="form-control" required
                               value="{{ old('stat_3_value', $about->stat_3_value ?? '200+') }}">
                        <input type="text" name="stat_3_label" class="form-control mt-2" required
                               value="{{ old('stat_3_label', $about->stat_3_label ?? 'Productos en catálogo') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Imagen</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Recomendado: 800x600px</small>
                        @if($about && $about->image)
                            <div class="mt-3">
                                <img src="{{ $about->image_url }}" alt="Imagen nosotros" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Alt de imagen</label>
                        <input type="text" name="image_alt" class="form-control" required
                               value="{{ old('image_alt', $about->image_alt ?? 'Productos DISTRI-JARCA') }}">

                        <label class="form-label mt-3">Texto del badge</label>
                        <input type="text" name="badge_text" class="form-control" required
                               value="{{ old('badge_text', $about->badge_text ?? 'Calidad Certificada') }}">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Guardar Sección Nosotros
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de Secciones -->
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Secciones</h5>
            </div>
            <a href="{{ route('admin.home-sections.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-2"></i>Nueva Sección
            </a>
        </div>
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

    {{-- Sección Contacto (DESHABILITADA)
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1"><i class="bi bi-telephone me-2"></i>Sección Contacto</h5>
                <small class="text-muted">Sección deshabilitada por solicitud del cliente</small>
            </div>
        </div>
    </div>
    --}}
</div>
@endsection
