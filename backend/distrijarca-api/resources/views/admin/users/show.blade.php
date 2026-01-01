@extends('layouts.admin')

@section('title', 'Ver Usuario - DISTRI-JARCA Admin')

@section('extra-css')
<style>
.user-detail { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.info-label { font-weight: 600; color: #102542; margin-bottom: 5px; }
.info-value { color: #666; margin-bottom: 20px; }
.activity-item { border-left: 3px solid #102542; padding: 15px; margin-bottom: 15px; background: #f8f9fa; border-radius: 5px; }
.activity-item .time { color: #999; font-size: 12px; }
</style>
@endsection

@section('content')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>Detalles del Usuario</h2>
                <p class="text-muted">Información completa y actividad reciente</p>
            </div>
            <div>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning me-2">
                    <i class="bi bi-pencil me-2"></i>Editar
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Volver
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row">
            <div class="col-lg-4">
                <div class="user-detail mb-4">
                    <div class="text-center mb-4">
                        <div class="user-avatar-large mb-3" style="font-size: 80px; color: #102542;">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h3>{{ $user->name }}</h3>
                        <p class="text-muted">{{ $user->email }}</p>
                        @if($user->activo)
                        <span class="badge bg-success">Activo</span>
                        @else
                        <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </div>

                    <hr>

                    <div class="info-label">Rol</div>
                    <div class="info-value">
                        <span class="badge {{ $user->role === 'super_admin' ? 'bg-danger' : 'bg-primary' }}">
                            {{ $user->role === 'super_admin' ? 'Super Administrador' : 'Administrador' }}
                        </span>
                    </div>

                    <div class="info-label">Último Login</div>
                    <div class="info-value">
                        @if($user->last_login)
                        {{ $user->last_login->format('d/m/Y H:i:s') }}
                        <br><small class="text-muted">{{ $user->last_login->diffForHumans() }}</small>
                        @else
                        <span class="text-muted">Nunca</span>
                        @endif
                    </div>

                    <div class="info-label">Fecha de Registro</div>
                    <div class="info-value">
                        {{ $user->created_at->format('d/m/Y H:i:s') }}
                    </div>

                    <div class="info-label">Última Actualización</div>
                    <div class="info-value">
                        {{ $user->updated_at->format('d/m/Y H:i:s') }}
                    </div>

                    <hr>

                    <button type="button" class="btn btn-sm btn-warning w-100 mb-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="bi bi-key me-2"></i>Cambiar Contraseña
                    </button>

                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-secondary w-100">
                            <i class="bi bi-{{ $user->activo ? 'pause' : 'play' }}-circle me-2"></i>
                            {{ $user->activo ? 'Desactivar' : 'Activar' }} Usuario
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Actividad Reciente</h5>
                    </div>
                    <div class="card-body">
                        @forelse($activities as $activity)
                        <div class="activity-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>{{ ucfirst(str_replace('_', ' ', $activity->action)) }}</strong>
                                    <p class="mb-1">{{ $activity->description }}</p>
                                    <small class="time">
                                        <i class="bi bi-clock me-1"></i>{{ $activity->created_at->format('d/m/Y H:i:s') }}
                                        ({{ $activity->created_at->diffForHumans() }})
                                    </small>
                                </div>
                                @if($activity->ip_address)
                                <small class="text-muted">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $activity->ip_address }}
                                </small>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">No hay actividad reciente</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cambiar Contraseña -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.users.change-password', $user) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="password" class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required minlength="6">
                        <small class="text-muted">Mínimo 6 caracteres</small>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                </div>
            </form>
    </div>
@endsection

@section('extra-js')
<script src="{{ asset('admin/js/admin-script.js') }}"></script>
@endsection
