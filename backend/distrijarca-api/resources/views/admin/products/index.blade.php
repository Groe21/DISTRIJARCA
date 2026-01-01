@extends('layouts.admin')

@section('title', 'Gestión de Productos - DISTRI-JARCA Admin')

@section('extra-css')
<style>
.product-table-wrapper { 
    background: white; 
    border-radius: 10px; 
    overflow: hidden; 
    box-shadow: 0 2px 8px rgba(0,0,0,0.1); 
    padding: 20px;
}
.product-table th { 
    background: #102542 !important; 
    color: white !important; 
    padding: 15px !important; 
    font-weight: 600; 
    font-size: 13px; 
    border: none !important;
}
.product-table td { 
    padding: 12px 15px !important; 
    vertical-align: middle !important; 
    border-bottom: 1px solid #dee2e6 !important;
}
.product-img { 
    width: 60px; 
    height: 60px; 
    object-fit: cover; 
    border-radius: 8px; 
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.badge-category { 
    padding: 6px 12px; 
    border-radius: 20px; 
    font-size: 11px; 
    font-weight: 600;
    background: #F9B233; 
    color: #102542; 
}
.btn-action { 
    padding: 6px 10px; 
    font-size: 12px; 
    margin: 0 2px; 
    border-radius: 6px;
    transition: all 0.3s ease;
}
.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
.product-name {
    font-weight: 600;
    color: #102542;
    margin-bottom: 4px;
}
.product-desc {
    font-size: 12px;
    color: #6c757d;
}
.stock-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
}
.price-display {
    font-size: 16px;
    font-weight: 700;
    color: #28a745;
}
.price-unit {
    font-size: 11px;
    color: #6c757d;
    display: block;
}
/* DataTables customization */
.dataTables_wrapper .dataTables_filter input {
    border: 2px solid #102542;
    border-radius: 8px;
    padding: 6px 12px;
    margin-left: 8px;
}
.dataTables_wrapper .dataTables_length select {
    border: 2px solid #102542;
    border-radius: 8px;
    padding: 4px 8px;
}
.dataTables_wrapper .dataTables_info {
    color: #102542;
    font-weight: 500;
}
.page-link {
    color: #102542;
}
.page-item.active .page-link {
    background-color: #102542;
    border-color: #102542;
}
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Gestión de Productos</h2>
        <p class="text-muted">Administra el catálogo de productos</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Nuevo Producto
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="product-table-wrapper">
    <table class="table table-hover product-table" id="productsTable">
        <thead>
            <tr>
                <th width="80">Imagen</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th width="100">Estado</th>
                <th width="100">Destacado</th>
                <th width="180" class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>
                    @if($product->imagen)
                        <img src="{{ asset('storage/' . $product->imagen) }}" alt="{{ $product->nombre }}" class="product-img">
                    @else
                        <div class="product-img bg-light d-flex align-items-center justify-content-center">
                            <i class="bi bi-image text-muted fs-4"></i>
                        </div>
                    @endif
                </td>
                <td>
                    <div class="product-name">{{ $product->nombre }}</div>
                    <small class="product-desc">{{ Str::limit($product->descripcion, 60) }}</small>
                </td>
                <td>
                    <span class="badge-category">{{ $product->category->nombre }}</span>
                </td>
                <td>
                    <div class="price-display">${{ number_format($product->precio, 2) }}</div>
                    <span class="price-unit">por {{ $product->unidad_medida }}</span>
                </td>
                <td>
                    @if($product->stock > 10)
                        <span class="badge bg-success stock-badge">{{ $product->stock }}</span>
                    @elseif($product->stock > 0)
                        <span class="badge bg-warning stock-badge">{{ $product->stock }}</span>
                    @else
                        <span class="badge bg-danger stock-badge">Sin stock</span>
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        @if($product->activo)
                            <button type="submit" class="badge bg-success border-0" style="cursor: pointer;" title="Desactivar">
                                <i class="bi bi-check-circle"></i> Activo
                            </button>
                        @else
                            <button type="submit" class="badge bg-secondary border-0" style="cursor: pointer;" title="Activar">
                                <i class="bi bi-x-circle"></i> Inactivo
                            </button>
                        @endif
                    </form>
                </td>
                <td class="text-center">
                    <form action="{{ route('admin.products.toggle-featured', $product) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        @if($product->destacado)
                            <button type="submit" class="btn btn-sm btn-warning" style="cursor: pointer;" title="Desmarcar">
                                <i class="bi bi-star-fill"></i>
                            </button>
                        @else
                            <button type="submit" class="btn btn-sm btn-outline-warning" style="cursor: pointer;" title="Destacar">
                                <i class="bi bi-star"></i>
                            </button>
                        @endif
                    </form>
                </td>
                <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('admin.products.show', $product) }}" 
                           class="btn btn-info btn-action" 
                           title="Ver">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.products.edit', $product) }}" 
                           class="btn btn-warning btn-action" 
                           title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button type="button"
                                class="btn btn-danger btn-action delete-product"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->nombre }}"
                                data-url="{{ route('admin.products.destroy', $product) }}"
                                title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('extra-js')
<script>
$(document).ready(function() {
    // Inicializar DataTables
    const table = $('#productsTable').DataTable({
        language: {
            "decimal": "",
            "emptyTable": "No hay productos registrados",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ productos",
            "infoEmpty": "Mostrando 0 a 0 de 0 productos",
            "infoFiltered": "(filtrado de _MAX_ productos totales)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ productos",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "No se encontraron productos",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": activar para ordenar la columna de manera ascendente",
                "sortDescending": ": activar para ordenar la columna de manera descendente"
            }
        },
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
        order: [[1, 'asc']], // Ordenar por nombre de producto
        columnDefs: [
            { orderable: false, targets: [0, 5, 6, 7] }, // Deshabilitar orden en imagen, estado, destacado y acciones
            { searchable: false, targets: [0, 5, 6, 7] }
        ],
        responsive: true,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
    });

    // Eliminar producto
    $(document).on('click', '.delete-product', function(e) {
        e.preventDefault();
        const name = $(this).data('name');
        const url = $(this).data('url');
        
        if (confirm(`¿Estás seguro de eliminar el producto "${name}"?`)) {
            const form = $('<form>', {
                method: 'POST',
                action: url
            });
            
            form.append($('<input>', {
                type: 'hidden',
                name: '_token',
                value: '{{ csrf_token() }}'
            }));
            
            form.append($('<input>', {
                type: 'hidden',
                name: '_method',
                value: 'DELETE'
            }));
            
            $('body').append(form);
            form.submit();
        }
    });
});
</script>
<script src="{{ asset('admin/js/admin-script.js') }}"></script>
@endsection
