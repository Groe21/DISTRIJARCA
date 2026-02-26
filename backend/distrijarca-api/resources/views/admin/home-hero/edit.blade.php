@extends('layouts.admin')

@section('title', 'Hero Principal - DISTRI-JARCA Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Hero Principal</h2>
        <p class="text-muted">Configura la imagen principal, la imagen de fondo y el texto del hero</p>
    </div>
    <a href="{{ route('admin.home-sections.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Volver a Secciones
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.home-hero.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="form-label">Texto del Hero</label>
                <textarea name="texto" class="form-control" rows="4" required>{{ old('texto', $hero->texto ?? 'Más de 15 años distribuyendo productos premium con garantía de frescura.\nSomos tu socio confiable en quesos y embutidos de calidad.') }}</textarea>
                <small class="text-muted">Usa salto de línea para separar frases.</small>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label">Imagen Principal</label>
                    <input type="file" name="imagen_principal" class="form-control" accept="image/*">
                    <small class="text-muted">Recomendado: 600x400px</small>
                    @if($hero && $hero->imagen_principal)
                        <div class="mt-3">
                            <img src="{{ $hero->imagen_principal_url }}" alt="Imagen principal" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    @endif
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label">Imagen de Fondo</label>
                    <input type="file" name="imagen_fondo" class="form-control" accept="image/*">
                    <small class="text-muted">Recomendado: 1920x1080px</small>
                    @if($hero && $hero->imagen_fondo)
                        <div class="mt-3">
                            <img src="{{ $hero->imagen_fondo_url }}" alt="Imagen de fondo" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    @endif
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('extra-js')
<script src="{{ asset('admin/js/admin-script.js') }}"></script>
@endsection
