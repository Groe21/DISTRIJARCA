<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - DISTRI-JARCA Admin</title>
    
    @include('partials.admin.head-styles')
</head>
<body>

    @include('partials.admin.sidebar')

    <div class="main-content">
        @include('partials.admin.navbar')

        <div class="dashboard-content">
            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-icon bg-primary">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $stats['total_productos'] }}</h3>
                            <p>Productos Activos</p>
                            <span class="stat-trend text-success">
                                <i class="bi bi-arrow-up"></i> Disponibles
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-icon bg-success">
                            <i class="bi bi-tags"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $stats['total_categorias'] }}</h3>
                            <p>Categorías</p>
                            <span class="stat-trend text-success">
                                <i class="bi bi-folder"></i> Organizadas
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-icon bg-warning">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $stats['mensajes_pendientes'] }}</h3>
                            <p>Mensajes Nuevos</p>
                            <span class="stat-trend text-warning">
                                <i class="bi bi-clock"></i> Pendientes
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-icon bg-danger">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $stats['suscriptores'] }}</h3>
                            <p>Suscriptores</p>
                            <span class="stat-trend text-muted">
                                <i class="bi bi-envelope-check"></i> Newsletter
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row g-4 mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Acciones Rápidas</h5>
                        </div>
                        <div class="card-body">
                            <div class="quick-actions">
                                <a href="{{ route('admin.products.create') }}" class="quick-action-btn">
                                    <i class="bi bi-plus-circle"></i>
                                    <span>Nuevo Producto</span>
                                </a>
                                <a href="{{ route('admin.categories.create') }}" class="quick-action-btn">
                                    <i class="bi bi-tag"></i>
                                    <span>Nueva Categoría</span>
                                </a>
                                <a href="#" class="quick-action-btn">
                                    <i class="bi bi-file-pdf"></i>
                                    <span>Generar Reporte</span>
                                </a>
                                <a href="#" class="quick-action-btn">
                                    <i class="bi bi-send"></i>
                                    <span>Enviar Newsletter</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Messages and Products -->
            <div class="row g-4">
                <!-- Recent Messages -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Mensajes Recientes</h5>
                            <a href="#" class="text-primary small">Ver todos</a>
                        </div>
                        <div class="card-body p-0">
                            @forelse($mensajes_recientes as $mensaje)
                            <div class="message-item {{ $mensaje->leido ? '' : 'unread' }}">
                                <div class="message-avatar">
                                    <i class="bi bi-person-circle"></i>
                                </div>
                                <div class="message-content">
                                    <h6>{{ $mensaje->nombre }}</h6>
                                    <p>{{ Str::limit($mensaje->mensaje, 60) }}</p>
                                    <span class="text-muted small">{{ $mensaje->created_at->diffForHumans() }}</span>
                                </div>
                                @if(!$mensaje->leido)
                                <span class="badge bg-danger">Nuevo</span>
                                @endif
                            </div>
                            @empty
                            <div class="text-center py-5">
                                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-2">No hay mensajes recientes</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Products -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Productos Recientes</h5>
                            <a href="{{ route('admin.products.index') }}" class="text-primary small">Ver todos</a>
                        </div>
                        <div class="card-body p-0">
                            @forelse($productos_recientes as $producto)
                            <div class="product-item">
                                <div class="product-image-small">
                                    @if($producto->imagen)
                                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                    @else
                                        <i class="bi bi-box-seam"></i>
                                    @endif
                                </div>
                                <div class="product-details">
                                    <h6>{{ $producto->nombre }}</h6>
                                    <p class="text-muted small mb-0">{{ $producto->category->nombre ?? 'Sin categoría' }}</p>
                                    <span class="text-muted small">{{ $producto->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="product-meta">
                                    <div class="product-price">${{ number_format($producto->precio, 2) }}</div>
                                    @if($producto->activo)
                                    <span class="badge bg-success">Activo</span>
                                    @else
                                    <span class="badge bg-secondary">Inactivo</span>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-5">
                                <i class="bi bi-box text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-2">No hay productos registrados</p>
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm mt-2">
                                    <i class="bi bi-plus-circle me-2"></i>Crear producto
                                </a>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.admin.footer')

    @include('partials.admin.footer-scripts')

</body>
</html>
