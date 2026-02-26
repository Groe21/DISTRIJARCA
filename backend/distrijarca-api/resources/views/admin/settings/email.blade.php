@extends('layouts.admin')

@section('title', 'Configuración de Email')

@section('content')
<div class="container-fluid">
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-google me-2"></i>Configuración de Google Mail</h2>
            <p class="text-muted">Configura tu cuenta de Gmail para enviar emails desde DISTRI-JARCA</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Volver
        </a>
    </div>

    <!-- Alertas -->
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

    <div class="row">
        <!-- Formulario de configuración -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-envelope me-2"></i>Datos de tu cuenta Google</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="MAIL_MAILER" class="form-label">Mailer</label>
                            <input type="text" name="MAIL_MAILER" id="MAIL_MAILER" class="form-control" 
                                   value="smtp" readonly>
                            <small class="text-muted">Configurado para usar SMTP</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="MAIL_HOST" class="form-label">Host SMTP *</label>
                                <input type="text" name="MAIL_HOST" id="MAIL_HOST" class="form-control @error('MAIL_HOST') is-invalid @enderror" 
                                       value="{{ old('MAIL_HOST', $emailSettings->firstWhere('key', 'MAIL_HOST')?->value) }}" readonly>
                                @error('MAIL_HOST')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">smtp.gmail.com (fijo)</small>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="MAIL_PORT" class="form-label">Puerto SMTP *</label>
                                <input type="number" name="MAIL_PORT" id="MAIL_PORT" class="form-control @error('MAIL_PORT') is-invalid @enderror" 
                                       value="{{ old('MAIL_PORT', $emailSettings->firstWhere('key', 'MAIL_PORT')?->value) }}" readonly>
                                @error('MAIL_PORT')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">587 (fijo)</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="MAIL_USERNAME" class="form-label">Usuario/Email SMTP *</label>
                                <input type="text" name="MAIL_USERNAME" id="MAIL_USERNAME" class="form-control @error('MAIL_USERNAME') is-invalid @enderror" 
                                       value="{{ old('MAIL_USERNAME', $emailSettings->firstWhere('key', 'MAIL_USERNAME')?->value) }}" required>
                                @error('MAIL_USERNAME')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="MAIL_PASSWORD" class="form-label">Contraseña SMTP *</label>
                                <input type="password" name="MAIL_PASSWORD" id="MAIL_PASSWORD" class="form-control @error('MAIL_PASSWORD') is-invalid @enderror" 
                                       value="{{ old('MAIL_PASSWORD', $emailSettings->firstWhere('key', 'MAIL_PASSWORD')?->value) }}" required>
                                @error('MAIL_PASSWORD')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Token o contraseña de acceso</small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="MAIL_ENCRYPTION" class="form-label">Encriptación</label>
                            <input type="text" name="MAIL_ENCRYPTION" id="MAIL_ENCRYPTION" class="form-control" 
                                   value="tls" readonly>
                            <small class="text-muted">TLS (fijo para Google)</small>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="MAIL_FROM_ADDRESS" class="form-label">Email Remitente *</label>
                                <input type="email" name="MAIL_FROM_ADDRESS" id="MAIL_FROM_ADDRESS" class="form-control @error('MAIL_FROM_ADDRESS') is-invalid @enderror" 
                                       value="{{ old('MAIL_FROM_ADDRESS', $emailSettings->firstWhere('key', 'MAIL_FROM_ADDRESS')?->value) }}" required>
                                @error('MAIL_FROM_ADDRESS')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Email que aparecerá como remitente</small>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="MAIL_FROM_NAME" class="form-label">Nombre Remitente *</label>
                                <input type="text" name="MAIL_FROM_NAME" id="MAIL_FROM_NAME" class="form-control @error('MAIL_FROM_NAME') is-invalid @enderror" 
                                       value="{{ old('MAIL_FROM_NAME', $emailSettings->firstWhere('key', 'MAIL_FROM_NAME')?->value) }}" required>
                                @error('MAIL_FROM_NAME')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Nombre que aparecerá en los emails</small>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-save me-2"></i>Guardar Configuración
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Panel de ayuda -->
        <div class="col-lg-4">
            <!-- Guía rápida Gmail -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-google me-2"></i>Configurar Gmail</h5>
                </div>
                <div class="card-body small">
                    <p class="mb-3"><strong>Pasos para obtener tu contraseña de aplicación:</strong></p>
                    <ol class="ps-3 mb-3">
                        <li>Ve a <a href="https://myaccount.google.com/security" target="_blank" class="text-primary">myaccount.google.com/security</a></li>
                        <li>Habilita "Verificación en 2 pasos" (si no lo has hecho)</li>
                        <li>Busca "Contraseñas de aplicaciones" (abajo de la página)</li>
                        <li>Selecciona:
                            <ul>
                                <li><strong>App:</strong> Mail</li>
                                <li><strong>Device:</strong> Windows Computer (o tu dispositivo)</li>
                            </ul>
                        </li>
                        <li>Google te generará una contraseña de <strong>16 caracteres</strong></li>
                        <li>Copia esa contraseña y pégala aquí abajo</li>
                    </ol>
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Nota:</strong> Debes tener 2FA activado en tu Google para generar contraseñas de app.
                    </div>
                </div>
            </div>

            <!-- Datos para llenar -->
            <div class="card shadow-sm mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Lo que debes cambiar</h5>
                </div>
                <div class="card-body small">
                    <div class="mb-3 p-2 bg-light rounded">
                        <strong>Tu email de Google:</strong>
                        <br><code>tu_email@gmail.com</code>
                    </div>
                    <div class="p-2 bg-light rounded">
                        <strong>Contraseña de app (16 caracteres):</strong>
                        <br><code>xxxx xxxx xxxx xxxx</code>
                    </div>
                </div>
            </div>

            <!-- Prueba de conexión -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-envelope-at me-2"></i>Prueba de Conexión</h5>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">Envía un email de prueba para verificar que todo está configurado correctamente</p>
                    <form action="{{ route('admin.settings.test-email') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="test_email" class="form-label small">Email de prueba</label>
                            <input type="email" name="test_email" id="test_email" class="form-control form-control-sm" 
                                   value="{{ auth()->user()->email }}" placeholder="tu@email.com">
                        </div>
                        <button type="submit" class="btn btn-success btn-sm w-100">
                            <i class="bi bi-send me-2"></i>Enviar email de prueba
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
