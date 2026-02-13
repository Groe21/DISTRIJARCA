@extends('layouts.admin')

@section('title', 'Editar Sección Home')

@section('content')
<div class="container-fluid">
    <!-- Título -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-pencil me-2"></i>Editar Sección: {{ $homeSection->titulo }}</h2>
            <p class="text-muted">Modifica los datos de la sección</p>
        </div>
        <a href="{{ route('admin.home-sections.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Volver
        </a>
    </div>

    <!-- Formulario -->
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.home-sections.update', $homeSection) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Fila 1: Categoría y Orden -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label">Categoría <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Seleccione una categoría...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ old('category_id', $homeSection->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Se mostrarán los productos destacados de esta categoría</small>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Orden <span class="text-danger">*</span></label>
                        <input type="number" name="orden" class="form-control @error('orden') is-invalid @enderror" 
                               min="0" value="{{ old('orden', $homeSection->orden) }}" required>
                        @error('orden')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Título -->
                <div class="mb-3">
                    <label class="form-label">Título de la Sección <span class="text-danger">*</span></label>
                    <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror" 
                           value="{{ old('titulo', $homeSection->titulo) }}" required>
                    @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Subtítulo -->
                <div class="mb-3">
                    <label class="form-label">Subtítulo (opcional)</label>
                    <input type="text" name="subtitulo" class="form-control @error('subtitulo') is-invalid @enderror" 
                           value="{{ old('subtitulo', $homeSection->subtitulo) }}">
                    @error('subtitulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="mb-3">
                    <label class="form-label">Descripción <span class="text-danger">*</span></label>
                    <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" 
                              rows="3" maxlength="500" required>{{ old('descripcion', $homeSection->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Fila 2: Badge -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Texto del Badge (opcional)</label>
                        <input type="text" name="badge_texto" class="form-control @error('badge_texto') is-invalid @enderror" 
                               value="{{ old('badge_texto', $homeSection->badge_texto) }}">
                        @error('badge_texto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Color del Badge <span class="text-danger">*</span></label>
                        <select name="badge_color" class="form-select @error('badge_color') is-invalid @enderror" required>
                            @foreach($colores as $key => $label)
                                <option value="{{ $key }}" 
                                    {{ old('badge_color', $homeSection->badge_color) == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('badge_color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Fila 3: Ícono y Max Productos -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label">Ícono <span class="text-danger">*</span></label>
                        <select name="icono" class="form-select @error('icono') is-invalid @enderror" required>
                            @foreach($iconos as $key => $label)
                                <option value="{{ $key }}" 
                                    {{ old('icono', $homeSection->icono) == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('icono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Máx Productos <span class="text-danger">*</span></label>
                        <input type="number" name="max_productos" class="form-control @error('max_productos') is-invalid @enderror" 
                               min="1" max="10" value="{{ old('max_productos', $homeSection->max_productos) }}" required>
                        @error('max_productos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Imagen Actual -->
                <div class="mb-3">
                    <label class="form-label">Imagen Actual</label>
                    <div class="mb-2">
                        <img src="{{ $homeSection->imagen_url }}" class="img-thumbnail" style="max-height: 200px">
                    </div>
                </div>

                <!-- Nueva Imagen -->
                <div class="mb-3">
                    <label class="form-label">Cambiar Imagen (opcional)</label>
                    <input type="file" name="imagen" class="form-control @error('imagen') is-invalid @enderror" 
                           accept="image/jpeg,image/png,image/jpg,image/webp">
                    <small class="text-muted">Deja vacío para mantener la imagen actual</small>
                    @error('imagen')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Estado Activo -->
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="activo" id="activo" 
                           {{ old('activo', $homeSection->activo) ? 'checked' : '' }}>
                    <label class="form-check-label" for="activo">
                        Sección activa (visible en la página principal)
                    </label>
                </div>

                <!-- Botones -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Actualizar Sección
                    </button>
                    <a href="{{ route('admin.home-sections.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-lg me-2"></i>Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
