<div class="topbar container-fluid">
    <div class="d-flex align-items-center gap-lg-2 gap-1">

        <!-- Topbar Brand Logo -->
        <div class="logo-topbar">
            <!-- Logo light -->
            <a href="{{ route('consultor.dashboard') }}" class="logo-light">
                <span class="logo-lg">
                    <img src="{{asset('backend/assets/images/logo.png')}}" alt="logo">
                </span>
                <span class="logo-sm">
                    <img src="{{asset('backend/assets/images/logo-sm.png')}}" alt="small logo">
                </span>
            </a>

            <!-- Logo Dark -->
            <a href="{{ route('consultor.dashboard') }}" class="logo-dark">
                <span class="logo-lg">
                    <img src="{{asset('backend/assets/images/logo-dark.png')}}" alt="dark logo">
                </span>
                <span class="logo-sm">
                    <img src="{{asset('backend/assets/images/logo-dark-sm.png')}}" alt="small logo">
                </span>
            </a>
        </div>

        <!-- Sidebar Menu Toggle Button -->
        <button class="button-toggle-menu">
            <i class="mdi mdi-menu"></i>
        </button>

        <!-- Horizontal Menu Toggle Button -->
        <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
            <div class="lines">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
    </div>

    <ul class="topbar-menu d-flex align-items-center gap-3">
        <li class="d-none d-sm-inline-block">
            <a class="nav-link" data-bs-toggle="offcanvas" href="#theme-settings-offcanvas">
                <i class="ri-settings-3-line font-22"></i>
            </a>
        </li>

        <li class="d-none d-sm-inline-block">
            <div class="nav-link" id="light-dark-mode" data-bs-toggle="tooltip" data-bs-placement="left"
                title="Theme Mode">
                <i class="ri-moon-line font-22"></i>
            </div>
        </li>


        <li class="d-none d-md-inline-block">
            <a class="nav-link" href="" data-toggle="fullscreen">
                <i class="ri-fullscreen-line font-22"></i>
            </a>
        </li>

        <li class="dropdown">
            <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown"
                role="button" aria-haspopup="false" aria-expanded="false">
                <span class="account-user-avatar">
                    <img src="{{asset(Auth::user()->image)}}" alt="user-image" width="32"
                        class="rounded-circle">
                </span>
                <span class="d-lg-flex flex-column gap-1 d-none">
                    <h5 class="my-0">{{Auth::user()->name}}</h5>
                    <h6 class="my-0 fw-normal">{{Auth::user()->role}}</h6>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                <!-- item-->
                <div class=" dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Bienvenido !</h6>
                </div>

                <!-- item-->
                <a href="{{route('consultor.profile')}}" class="dropdown-item">
                    <i class="mdi mdi-account-circle me-1"></i>
                    <span>Mi Cuenta</span>
                </a>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item">
                    <i class="mdi mdi-account-edit me-1"></i>
                    <span>Configuraciones</span>
                </a>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item">
                    <i class="mdi mdi-lifebuoy me-1"></i>
                    <span>Soporte</span>
                </a>


                <!-- item-->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();"
                        class="dropdown-item">
                        <i class="mdi mdi-logout me-1"></i>
                        <span>Cerrar Sesion</span>
                    </a>

                </form>



            </div>
        </li>
    </ul>
</div>