# Estructura de Partials - Panel Admin DISTRI-JARCA

## Descripción

Este proyecto utiliza una arquitectura modular de vistas, similar a Django Templates, donde los componentes reutilizables están separados en archivos parciales (`partials`).

## Estructura de Archivos

```
resources/views/
├── partials/
│   └── admin/
│       ├── sidebar.blade.php          # Menú lateral del admin
│       ├── navbar.blade.php           # Barra superior de navegación
│       ├── footer.blade.php           # Footer del panel admin
│       ├── head-styles.blade.php      # Enlaces CSS (Bootstrap, Bootstrap Icons, Admin CSS)
│       └── footer-scripts.blade.php   # Scripts JS (Bootstrap, Admin JS)
├── layouts/
│   └── app.blade.php                  # Layout base de la aplicación
└── admin/
    ├── dashboard.blade.php
    └── users/
        ├── index.blade.php            # Lista de usuarios
        ├── show.blade.php             # Detalle de usuario
        ├── create.blade.php           # Crear usuario
        ├── edit.blade.php             # Editar usuario
        └── activity-logs.blade.php    # Logs de actividad
```

## Uso de Partials

### 1. Sidebar

El sidebar es el menú lateral que aparece en todas las páginas del admin.

**Ubicación:** `resources/views/partials/admin/sidebar.blade.php`

**Uso:**
```blade
@include('partials.admin.sidebar')
```

**Características:**
- Menú lateral con íconos y etiquetas
- Indicador de elemento activo dinámico basado en la ruta
- Detecta automáticamente la página actual usando `request()->routeIs()`
- Responsive: se colapsa en dispositivos móviles
- Botón para ver el sitio web
- Botón para cerrar sesión

**Agregar nuevos elementos al menú:**
```blade
<a href="{{ route('admin.productos.index') }}" 
   class="menu-item {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}" 
   data-tooltip="Productos">
    <i class="bi bi-box-seam"></i>
    <span>Productos</span>
</a>
```

### 2. Navbar

La barra superior de navegación que muestra información del usuario.

**Ubicación:** `resources/views/partials/admin/navbar.blade.php`

**Uso:**
```blade
@include('partials.admin.navbar')
```

**Características:**
- Botón de toggle para colapsar/expandir sidebar
- Breadcrumbs opcionales (si se pasa la variable `$breadcrumbs`)
- Avatar y nombre del usuario autenticado
- Dropdown con opciones:
  - Ver perfil
  - Cerrar sesión
- Notificaciones (comentado, para implementación futura)

**Pasar breadcrumbs desde el controlador:**
```php
return view('admin.users.edit', [
    'user' => $user,
    'breadcrumbs' => [
        ['title' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['title' => 'Usuarios', 'url' => route('admin.users.index')],
        ['title' => 'Editar Usuario', 'url' => '']
    ]
]);
```

### 3. Head Styles

Enlaces a los archivos CSS necesarios para el panel admin.

**Ubicación:** `resources/views/partials/admin/head-styles.blade.php`

**Uso:**
```blade
@include('partials.admin.head-styles')
```

**Incluye:**
- Bootstrap 5 CSS
- Bootstrap Icons
- Admin Styles personalizados

### 4. Footer Scripts

Scripts JavaScript necesarios para el panel admin.

**Ubicación:** `resources/views/partials/admin/footer-scripts.blade.php`

**Uso:**
```blade
@include('partials.admin.footer-scripts')
```

**Incluye:**
- Bootstrap Bundle JS (con Popper)
- Admin Scripts personalizados

### 5. Footer Admin

Footer del panel administrativo con enlaces rápidos y redes sociales.

**Ubicación:** `resources/views/partials/admin/footer.blade.php`

**Uso:**
```blade
@include('partials.admin.footer')
```

**Características:**
- Enlaces rápidos del admin
- Información de productos
- Newsletter y redes sociales
- Copyright dinámico
- Responsive

## Ejemplo de Estructura de Vista Completa

```blade
@extends('layouts.app')

@section('title', 'Mi Página - DISTRI-JARCA Admin')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('admin/css/admin-styles.css') }}">
<style>
    /* Estilos específicos de esta página */
    .mi-clase { color: red; }
</style>
@endsection

@section('content')
@include('partials.admin.sidebar')

<div class="main-content">
    @include('partials.admin.navbar')

    <div class="dashboard-content">
        <h1>Contenido de mi página</h1>
        
        <!-- Tu contenido aquí -->
        
    </div>
</div>

@include('partials.admin.footer')

<script src="{{ asset('admin/js/admin-script.js') }}"></script>
@endsection
```

## Ventajas de Esta Arquitectura

1. **DRY (Don't Repeat Yourself):** El código del sidebar, navbar, etc. se escribe una sola vez
2. **Mantenibilidad:** Cambios en el menú se reflejan automáticamente en todas las páginas
3. **Escalabilidad:** Fácil agregar nuevos componentes reutilizables
4. **Consistencia:** Todas las páginas tienen el mismo look & feel
5. **Claridad:** Código más limpio y fácil de leer

## CSS Responsive

El sistema está optimizado para diferentes tamaños de pantalla:

- **Desktop (> 768px):** Sidebar completo visible
- **Tablet/Mobile (≤ 768px):** Sidebar colapsado por defecto
- **Navbar:** Se adapta automáticamente con Bootstrap

## Próximas Mejoras

- [ ] Componente de alerts/notificaciones reutilizable
- [ ] Partial para footer del admin
- [ ] Componente de tablas con paginación
- [ ] Modal reutilizable
- [ ] Breadcrumbs automáticos
