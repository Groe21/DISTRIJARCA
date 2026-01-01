@extends('layouts.admin')

@section('title', 'Ver Producto - DISTRI-JARCA Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Detalle del Producto</h2>
        <p class="text-muted">Información completa</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>Editar
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-10 mx-auto">
        <!-- Imagen y datos principales -->
        <div class="card mb-4">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-4 text-center">
                        @if($product->imagen)
                            <img src="{{ $product->imagen_url }}" alt="{{ $product->nombre }}" 
                                 class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                 style="height: 300px;">
                                <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h3 class="mb-3">{{ $product->nombre }}</h3>
                        
                        <div class="mb-3">
                            <span class="badge bg-primary">{{ $product->category->nombre }}</span>
                            @if($product->activo)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Inactivo</span>
                            @endif
                            @if($product->destacado)
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-star-fill"></i> Destacado
                                </span>
                            @endif
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="border rounded p-3">
                                    <small class="text-muted d-block">Precio</small>
                                    <h4 class="mb-0 text-success">${{ number_format($product->precio, 2) }}</h4>
                                    <small class="text-muted">por {{ $product->unidad_medida }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3">
                                    <small class="text-muted d-block">Stock Disponible</small>
                                    <h4 class="mb-0">{{ $product->stock }}</h4>
                                    <small class="text-muted">{{ $product->unidad_medida }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-2">Slug (URL)</small>
                            <code>{{ $product->slug }}</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Descripción y características -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Descripción</h5>
            </div>
            <div class="card-body">
                @if($product->descripcion)
                    <p class="mb-0">{{ $product->descripcion }}</p>
                @else
                    <p class="text-muted mb-0">Sin descripción</p>
                @endif
            </div>
        </div>

        @if($product->caracteristicas)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Características</h5>
            </div>
            <div class="card-body">
                <p class="mb-0" style="white-space: pre-line;">{{ $product->caracteristicas }}</p>
            </div>
        </div>
        @endif

        <!-- Información adicional -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Información Adicional</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Creado:</strong> 
                            {{ $product->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Última actualización:</strong> 
                            {{ $product->updated_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script src="{{ asset('admin/js/admin-script.js') }}"></script>
@endsection
