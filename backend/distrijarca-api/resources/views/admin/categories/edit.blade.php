@extends('layouts.admin')

@section('title', 'Editar Categoría - DISTRI-JARCA Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Editar Categoría</h2>
        <p class="text-muted">{{ $category->nombre }}</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Volver
    </a>
</div>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la Categoría *</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                               id="nombre" name="nombre" value="{{ old('nombre', $category->nombre) }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Slug actual: <strong>{{ $category->slug }}</strong></small>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion" name="descripcion" rows="4">{{ old('descripcion', $category->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="orden" class="form-label">Orden de visualización</label>
                        <input type="number" class="form-control @error('orden') is-invalid @enderror" 
                               id="orden" name="orden" value="{{ old('orden', $category->orden) }}" min="0">
                        @error('orden')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Número menor aparece primero</small>
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" id="activo" name="activo" 
                               {{ old('activo', $category->activo) ? 'checked' : '' }}>
                        <label class="form-check-label" for="activo">
                            <strong>Categoría Activa</strong><br>
                            <small class="text-muted">Las categorías inactivas no se mostrarán en el catálogo</small>
                        </label>
                    </div>

                    @if($category->products()->count() > 0)
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Esta categoría tiene <strong>{{ $category->products()->count() }}</strong> producto(s) asociado(s)
                        </div>
                    @endif

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Actualizar Categoría
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script src="{{ asset('admin/js/admin-script.js') }}"></script>
@endsection
