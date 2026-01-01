<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DISTRI-JARCA - Distribución de quesos y embutidos de calidad premium">
    <meta name="keywords" content="quesos, embutidos, distribución, alimentos, jamones">
    <meta name="author" content="DISTRI-JARCA">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DISTRI-JARCA | Distribución de Quesos y Embutidos')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}">
    
    @yield('extra-css')
</head>
<body>

    <!-- ========== NAVBAR ========== -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('assets/logo-distrijarca.png') }}" alt="Logo DISTRI-JARCA" class="logo-navbar">
                <span class="brand-text ms-2">DISTRI-<span class="brand-jarca">JARCA</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/#inicio') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#nosotros') }}">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#productos') }}">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#calidad') }}">Calidad</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#contacto') }}">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-admin ms-3" href="{{ route('login') }}">
                            <i class="bi bi-gear-fill me-2"></i>Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ========== CONTENIDO PRINCIPAL ========== -->
    @yield('content')

    <!-- ========== FOOTER ========== -->
    <footer class="footer">
        <div class="footer-main">
            <div class="container">
                <div class="row g-4">
                    <!-- Columna 1: Logo y Descripción -->
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-brand mb-4">
                            <img src="{{ asset('assets/logo-distrijarca.png') }}" alt="Logo DISTRI-JARCA" class="footer-logo mb-3">
                            <h3 class="footer-brand-text">
                                DISTRI-<span class="text-highlight">JARCA</span>
                            </h3>
                        </div>
                        <p class="footer-description">
                            Distribuidores especializados en quesos y embutidos premium. 
                            Llevamos calidad y frescura a tu negocio desde 2009.
                        </p>
                        <div class="social-links mt-4">
                            <a href="#" class="social-link" aria-label="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="WhatsApp">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Columna 2: Enlaces Rápidos -->
                    <div class="col-lg-2 col-md-6">
                        <h4 class="footer-title">Enlaces Rápidos</h4>
                        <ul class="footer-links">
                            <li><a href="{{ url('/#inicio') }}">Inicio</a></li>
                            <li><a href="{{ url('/#nosotros') }}">Nosotros</a></li>
                            <li><a href="{{ url('/#productos') }}">Productos</a></li>
                            <li><a href="{{ url('/#calidad') }}">Calidad</a></li>
                            <li><a href="{{ url('/#contacto') }}">Contacto</a></li>
                        </ul>
                    </div>

                    <!-- Columna 3: Productos -->
                    <div class="col-lg-3 col-md-6">
                        <h4 class="footer-title">Nuestros Productos</h4>
                        <ul class="footer-links">
                            <li><a href="{{ url('/#productos') }}">Quesos Artesanales</a></li>
                            <li><a href="{{ url('/#productos') }}">Embutidos Selectos</a></li>
                            <li><a href="{{ url('/#productos') }}">Jamones Premium</a></li>
                            <li><a href="{{ url('/#productos') }}">Productos Especiales</a></li>
                            <li><a href="{{ url('/#productos') }}">Catálogo Completo</a></li>
                        </ul>
                    </div>

                    <!-- Columna 4: Newsletter -->
                    <div class="col-lg-3 col-md-6">
                        <h4 class="footer-title">Newsletter</h4>
                        <p class="footer-newsletter-text">
                            Suscríbete para recibir ofertas exclusivas y novedades
                        </p>
                        <form class="newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="email" name="email" class="form-control" placeholder="Tu email" required>
                                <button class="btn btn-newsletter" type="submit">
                                    <i class="bi bi-arrow-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                        <p class="mb-0">
                            &copy; {{ date('Y') }} DISTRI-JARCA. Todos los derechos reservados.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <a href="#" class="footer-bottom-link">Política de Privacidad</a>
                        <span class="mx-2">|</span>
                        <a href="#" class="footer-bottom-link">Términos y Condiciones</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Botón Scroll to Top -->
    <button id="scrollToTop" class="scroll-to-top" aria-label="Volver arriba">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- JavaScript Personalizado -->
    <script src="{{ asset('js/frontend.js') }}"></script>
    
    @yield('extra-js')

</body>
</html>
