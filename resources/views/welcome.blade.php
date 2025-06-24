<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Bienvenida | Rensar Consulting</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('backend/assets/images/logo-dark-sm.png')}}">

    <!-- Theme Config Js -->
    <script src="{{asset('backend/assets/js/hyper-config.js')}}"></script>

    <!-- App css -->
    <link href="{{asset('backend/assets/css/app-saas.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- NAVBAR START -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="https://www.rensar.biz/wp/" target="_blank" rel="noopener noreferrer">
                <img src="{{asset('backend/assets/images/logo-dark.png')}}" alt="Logo" height="50">
            </a>

            <!-- Botón hamburguesa -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Contenido del navbar -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto align-items-center gap-2 mt-3 mt-lg-0">
                    @if (Route::has('login'))
                    @auth
                    <li class="nav-item">
                        <a href="{{ url('/dashboard') }}" class="btn btn-sm btn-success rounded-pill d-flex align-items-center">
                            <i class="mdi mdi-view-dashboard me-2"></i> Dashboard
                        </a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-sm btn-primary rounded-pill d-flex align-items-center">
                            <i class="mdi mdi-account me-2"></i> Iniciar Sesión
                        </a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-sm btn-outline-primary rounded-pill d-flex align-items-center">
                            <i class="mdi mdi-account-cog me-2"></i> Registrarse
                        </a>
                    </li>
                    @endif
                    @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <!-- NAVBAR END -->

    <!-- START HERO -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="mt-md-4">
                        <div>
                            <span class="badge bg-danger rounded-pill">Nuevo</span>
                            <span class="text-white-50 ms-1">Bienvenido a la pagina principal de Rensar
                                Consulting</span>
                        </div>
                        <h2 class="text-white fw-normal mb-4 mt-3 hero-title">
                            Lidera la transformación digital con SAP
                        </h2>

                        <p class="mb-4 font-16 text-white-50">Especialistas en consultoría SAP que potencian la
                            eficiencia y el crecimiento de tu negocio.</p>

                    </div>
                </div>
                <div class="col-md-5 offset-md-2">
                    <div class="text-md-end mt-3 mt-md-0">
                        <img src="{{asset('backend/assets/images/svg/startup.svg')}}" alt="" class="img-fluid" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END HERO -->

    <!-- START SERVICES -->
    <section class="py-5">
        <div class="container">
            <div class="row py-4">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h1 class="mt-0"><i class="mdi mdi-infinity"></i></h1>
                        <h3>Soluciones integrales de consultoría y <span class="text-primary">soporte SAP</span></h3>
                        <p class="text-muted mt-2">Nuestros Servicios</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="text-center p-2 p-sm-3">
                        <div class="avatar-sm m-auto">
                            <span class="avatar-title bg-primary-lighten rounded-circle">
                                <i class="uil uil-apps text-primary font-24"></i>
                            </span>
                        </div>
                        <h4 class="mt-3">Consultoría SAP Estratégica</h4>
                        <p class="text-muted mt-2 mb-0">Convierte tu visión en soluciones SAP efectivas y reales.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="text-center p-2 p-sm-3">
                        <div class="avatar-sm m-auto">
                            <span class="avatar-title bg-primary-lighten rounded-circle">
                                <i class="uil uil-shopping-cart-alt text-primary font-24"></i>
                            </span>
                        </div>
                        <h4 class="mt-3">Soporte Técnico Especializado</h4>
                        <p class="text-muted mt-2 mb-0">Atención rápida para mantener SAP funcionando al 100%.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="text-center p-2 p-sm-3">
                        <div class="avatar-sm m-auto">
                            <span class="avatar-title bg-primary-lighten rounded-circle">
                                <i class="uil uil-grids text-primary font-24"></i>
                            </span>
                        </div>
                        <h4 class="mt-3">Optimización de Procesos SAP</h4>
                        <p class="text-muted mt-2 mb-0">Optimización eficiente de procesos clave en SAP empresarial.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END SERVICES -->

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>

</html>