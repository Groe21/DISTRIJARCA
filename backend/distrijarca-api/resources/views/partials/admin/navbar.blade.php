<nav class="top-navbar">
    <div class="d-flex align-items-center">
        <button class="btn btn-link text-dark p-0" id="sidebarToggle">
            <i class="bi bi-list fs-3"></i>
        </button>
        
        {{-- Breadcrumb opcional --}}
        @if(isset($breadcrumbs))
        <nav aria-label="breadcrumb" class="ms-3 d-none d-md-block">
            <ol class="breadcrumb mb-0">
                @foreach($breadcrumbs as $breadcrumb)
                    @if($loop->last)
                        <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['title'] }}</li>
                    @else
                        <li class="breadcrumb-item">
                            <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>
        @endif
    </div>
    
    <div class="ms-auto d-flex align-items-center gap-3">
        {{-- Notificaciones (opcional para futuro) --}}
        {{--
        <div class="dropdown">
            <button class="btn btn-link text-dark position-relative p-0" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-bell fs-5"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    3
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><h6 class="dropdown-header">Notificaciones</h6></li>
                <li><a class="dropdown-item" href="#">Nueva actualización</a></li>
            </ul>
        </div>
        --}}
        
        {{-- Usuario --}}
        <div class="dropdown">
            <button class="btn btn-link text-dark d-flex align-items-center gap-2 text-decoration-none p-0" 
                    type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                <div class="user-avatar">
                    <i class="bi bi-person-circle fs-3"></i>
                </div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><h6 class="dropdown-header">{{ Auth::user()->email }}</h6></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.users.show', Auth::user()) }}">
                        <i class="bi bi-person me-2"></i>Mi Perfil
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
