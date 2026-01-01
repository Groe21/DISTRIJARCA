<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('assets/logo-distrijarca.png') }}" alt="Logo" class="sidebar-logo">
        <h4>DISTRI-<span class="text-danger">JARCA</span></h4>
        <p class="text-muted small mb-0">Panel Administrativo</p>
    </div>

    <div class="sidebar-menu">
        <div class="menu-section">
            <h6 class="menu-title">PRINCIPAL</h6>
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-tooltip="Dashboard">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </div>

        <div class="menu-section">
            <h6 class="menu-title">GESTIÓN</h6>
            <a href="{{ route('admin.products.index') }}" class="menu-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" data-tooltip="Productos">
                <i class="bi bi-box-seam"></i>
                <span>Productos</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" data-tooltip="Categorías">
                <i class="bi bi-tags"></i>
                <span>Categorías</span>
            </a>
            <a href="#" class="menu-item" data-tooltip="Mensajes">
                <i class="bi bi-envelope"></i>
                <span>Mensajes</span>
            </a>
            <a href="#" class="menu-item" data-tooltip="Newsletter">
                <i class="bi bi-mailbox"></i>
                <span>Newsletter</span>
            </a>
        </div>

        <div class="menu-section">
            <h6 class="menu-title">SISTEMA</h6>
            <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') && !request()->routeIs('admin.users.activity-logs') ? 'active' : '' }}" data-tooltip="Usuarios">
                <i class="bi bi-people"></i>
                <span>Usuarios</span>
            </a>
            <a href="{{ route('admin.users.activity-logs') }}" class="menu-item {{ request()->routeIs('admin.users.activity-logs') ? 'active' : '' }}" data-tooltip="Logs">
                <i class="bi bi-clock-history"></i>
                <span>Logs de Actividad</span>
            </a>
        </div>
    </div>

    <div class="sidebar-footer">
        <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm w-100 mb-2" target="_blank">
            <i class="bi bi-globe me-2"></i>Ver Sitio Web
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
            </button>
        </form>
    </div>
</div>
