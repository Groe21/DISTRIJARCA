@extends('layouts.admin')

@section('title', 'Editar Producto - DISTRI-JARCA Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Editar Producto</h2>
        <p class="text-muted">Actualiza la información del producto</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-info">
            <i class="bi bi-eye me-2"></i>Ver
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Producto *</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" name="nombre" value="{{ old('nombre', $product->nombre) }}" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                          id="descripcion" name="descripcion" rows="4">{{ old('descripcion', $product->descripcion) }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="caracteristicas" class="form-label">Características</label>
                                <textarea class="form-control @error('caracteristicas') is-invalid @enderror" 
                                          id="caracteristicas" name="caracteristicas" rows="3" 
                                          placeholder="Ej: Origen, Maduración, Ingredientes...">{{ old('caracteristicas', $product->caracteristicas) }}</textarea>
                                @error('caracteristicas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="imagen" class="form-label">Imagen del Producto</label>
                                <input type="file" class="form-control @error('imagen') is-invalid @enderror" 
                                       id="imagen" name="imagen" accept="image/*">
                                @error('imagen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Formatos: JPG, PNG, WEBP (Máx. 2MB)</small>
                            </div>

                            <div id="preview" class="mt-3">
                                @if($product->imagen)
                                    <img id="preview-image" src="{{ $product->imagen_url }}" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                @else
                                    <img id="preview-image" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px; display: none;">
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Categoría *</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" 
                                        id="category_id" name="category_id" required>
                                    <option value="">Seleccionar categoría</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="unidad_medida" class="form-label">Unidad de Medida *</label>
                                <select class="form-select @error('unidad_medida') is-invalid @enderror" 
                                        id="unidad_medida" name="unidad_medida" required>
                                    <option value="kg" {{ old('unidad_medida', $product->unidad_medida) === 'kg' ? 'selected' : '' }}>Kilogramo (kg)</option>
                                    <option value="g" {{ old('unidad_medida', $product->unidad_medida) === 'g' ? 'selected' : '' }}>Gramos (g)</option>
                                    <option value="unidad" {{ old('unidad_medida', $product->unidad_medida) === 'unidad' ? 'selected' : '' }}>Unidad</option>
                                    <option value="paquete" {{ old('unidad_medida', $product->unidad_medida) === 'paquete' ? 'selected' : '' }}>Paquete</option>
                                    <option value="caja" {{ old('unidad_medida', $product->unidad_medida) === 'caja' ? 'selected' : '' }}>Caja</option>
                                </select>
                                @error('unidad_medida')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio *</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control @error('precio') is-invalid @enderror" 
                                           id="precio" name="precio" value="{{ old('precio', $product->precio) }}" 
                                           placeholder="0.00" pattern="[0-9]+([.][0-9]+)?" required>
                                    @error('precio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Usa punto como separador decimal (ej: 8.50)</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock Disponible *</label>
                                <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                       id="stock" name="stock" value="{{ old('stock', $product->stock) }}" 
                                       min="0" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="activo" name="activo" 
                                       {{ old('activo', $product->activo) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">
                                    <strong>Producto Activo</strong><br>
                                    <small class="text-muted">Los productos inactivos no se mostrarán en el catálogo</small>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="destacado" name="destacado" 
                                       {{ old('destacado', $product->destacado) ? 'checked' : '' }}>
                                <label class="form-check-label" for="destacado">
                                    <strong>Producto Destacado</strong><br>
                                    <small class="text-muted">Se mostrará en la página principal</small>
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Actualizar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script>
// Preview de imagen
document.getElementById('imagen').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview-image');
            preview.style.display = 'block';
            preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>
<script src="{{ asset('admin/js/admin-script.js') }}"></script>
@endsection
