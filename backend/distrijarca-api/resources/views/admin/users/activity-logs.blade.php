@extends('layouts.admin')

@section('title', 'Logs de Actividad - DISTRI-JARCA Admin')

@section('extra-css')
<style>
.log-table { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.log-table th { background: #102542; color: white; padding: 15px; font-weight: 600; font-size: 13px; }
.log-table td { padding: 12px 15px; border-bottom: 1px solid #dee2e6; font-size: 14px; }
.log-action { padding: 4px 10px; border-radius: 15px; font-size: 11px; font-weight: 600; display: inline-block; }
.log-login { background: #d4edda; color: #155724; }
.log-logout { background: #f8d7da; color: #721c24; }
.log-create { background: #d1ecf1; color: #0c5460; }
.log-update { background: #fff3cd; color: #856404; }
.log-delete { background: #f5c6cb; color: #721c24; }
.log-default { background: #e2e3e5; color: #383d41; }
</style>
@endsection

@section('content')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>Logs de Actividad</h2>
                <p class="text-muted">Registro de todas las acciones realizadas en el sistema</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Volver
            </a>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table log-table mb-0">
                        <thead>
                            <tr>
                                <th style="width: 80px;">ID</th>
                                <th style="width: 150px;">Usuario</th>
                                <th style="width: 140px;">Acción</th>
                                <th>Descripción</th>
                                <th style="width: 130px;">IP</th>
                                <th style="width: 180px;">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                            <tr>
                                <td><small class="text-muted">#{{ $log->id }}</small></td>
                                <td>
                                    @if($log->user)
                                    <strong>{{ $log->user->name }}</strong>
                                    <br><small class="text-muted">{{ $log->user->email }}</small>
                                    @else
                                    <span class="text-muted">Sistema</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="log-action log-{{ 
                                        Str::contains($log->action, 'login') ? 'login' : 
                                        (Str::contains($log->action, 'logout') ? 'logout' : 
                                        (Str::contains($log->action, 'create') ? 'create' : 
                                        (Str::contains($log->action, 'update') ? 'update' : 
                                        (Str::contains($log->action, 'delete') ? 'delete' : 'default'))))
                                    }}">
                                        {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                    </span>
                                </td>
                                <td>{{ $log->description }}</td>
                                <td><small class="font-monospace">{{ $log->ip_address ?? 'N/A' }}</small></td>
                                <td>
                                    <small>{{ $log->created_at->format('d/m/Y H:i:s') }}</small>
                                    <br><small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-clock-history text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-2">No hay registros de actividad</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Información</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Tipos de Acciones:</h6>
                        <ul class="list-unstyled">
                            <li><span class="log-action log-login">Login</span> - Inicio de sesión</li>
                            <li><span class="log-action log-logout">Logout</span> - Cierre de sesión</li>
                            <li><span class="log-action log-create">Create</span> - Creación de registros</li>
                            <li><span class="log-action log-update">Update</span> - Actualización de registros</li>
                            <li><span class="log-action log-delete">Delete</span> - Eliminación de registros</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Estadísticas:</h6>
                        <ul class="list-unstyled">
                            <li><strong>Total de registros:</strong> {{ $logs->total() }}</li>
                            <li><strong>Página actual:</strong> {{ $logs->currentPage() }} de {{ $logs->lastPage() }}</li>
                            <li><strong>Mostrando:</strong> {{ $logs->count() }} registros</li>
                        </ul>
                    </div>
                </div>
            </div>
    </div>
@endsection

@section('extra-js')
<script src="{{ asset('admin/js/admin-script.js') }}"></script>
@endsection
