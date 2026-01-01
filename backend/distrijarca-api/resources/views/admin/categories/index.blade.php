@extends('layouts.admin')

@section('title', 'Categorías - DISTRI-JARCA Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Gestión de Categorías</h2>
        <p class="text-muted">Organiza tus productos por categorías</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Nueva Categoría
    </a>
</div>

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

<div class="card">
    <div class="card-body">
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width: 50px;">Orden</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th style="width: 100px;">Productos</th>
                            <th style="width: 100px;">Estado</th>
                            <th style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td class="text-center">
                                <span class="badge bg-secondary">{{ $category->orden ?? '-' }}</span>
                            </td>
                            <td>
                                <strong>{{ $category->nombre }}</strong><br>
                                <small class="text-muted">{{ $category->slug }}</small>
                            </td>
                            <td>
                                <small>{{ Str::limit($category->descripcion, 80) }}</small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info">{{ $category->products_count }}</span>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input status-toggle" 
                                           type="checkbox" 
                                           data-id="{{ $category->id }}"
                                           data-url="{{ route('admin.categories.toggle-status', $category) }}"
                                           {{ $category->activo ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.categories.edit', $category) }}" 
                                       class="btn btn-outline-primary" 
                                       title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-outline-danger delete-btn" 
                                            data-id="{{ $category->id }}"
                                            data-name="{{ $category->nombre }}"
                                            data-url="{{ route('admin.categories.destroy', $category) }}"
                                            title="Eliminar"
                                            {{ $category->products_count > 0 ? 'disabled' : '' }}>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $categories->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-folder-x" style="font-size: 4rem; color: #ccc;"></i>
                <h4 class="mt-3">No hay categorías registradas</h4>
                <p class="text-muted">Comienza creando tu primera categoría</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-plus-circle me-2"></i>Crear Primera Categoría
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('extra-js')
<script>
// Toggle de estado
document.querySelectorAll('.status-toggle').forEach(toggle => {
    toggle.addEventListener('change', function() {
        const url = this.dataset.url;
        const checkbox = this;

        fetch(url, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('success', data.message);
            }
        })
        .catch(error => {
            checkbox.checked = !checkbox.checked;
            showToast('error', 'Error al cambiar el estado');
        });
    });
});

// Eliminar categoría
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const name = this.dataset.name;
        const url = this.dataset.url;

        if (confirm(`¿Estás seguro de eliminar la categoría "${name}"?`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
});

function showToast(type, message) {
    // Simple toast notification
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const icon = type === 'success' ? 'check-circle' : 'exclamation-triangle';
    
    const toast = document.createElement('div');
    toast.className = `alert ${alertClass} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
    toast.style.zIndex = '9999';
    toast.innerHTML = `
        <i class="bi bi-${icon} me-2"></i>${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>
<script src="{{ asset('admin/js/admin-script.js') }}"></script>
@endsection
