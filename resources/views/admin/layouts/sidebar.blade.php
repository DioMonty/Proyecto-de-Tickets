<!-- Brand Logo Light -->
<a href="{{ route('admin.dashboard') }}" class="logo logo-light">
    <span class="logo-lg">
        <img src="{{asset('backend/assets/images/logo-light.png')}}" alt="logo">
    </span>
    <span class="logo-sm">
        <img src="{{asset('backend/assets/images/logo-sm.png')}}" alt="small logo">
    </span>
</a>
<!-- Brand Logo Dark -->
<a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
    <span class="logo-lg">
        <img src="{{asset('backend/assets/images/logo-dark.png')}}" alt="dark logo">
    </span>
    <span class="logo-sm">
        <img src="{{asset('backend/assets/images/logo-dark-sm.png')}}" alt="small logo">
    </span>
</a>

<!-- Sidebar Hover Menu Toggle Button -->
<div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
    <i class="ri-checkbox-blank-circle-line align-middle"></i>
</div>

<!-- Full Sidebar Menu Close Button -->
<div class="button-close-fullsidebar">
    <i class="ri-close-fill align-middle"></i>
</div>

<!-- Sidebar -left -->
<div class="h-100" id="leftside-menu-container" data-simplebar>
    <!-- Leftbar User -->
    <div class="leftbar-user">
        <a href="pages-profile.html">
            <img src="{{asset(Auth::user()->image)}}" alt="user-image" height="42"
                class="rounded-circle shadow-sm">
            <span class="leftbar-user-name mt-2">{{Auth::user()->name}}</span>
        </a>
    </div>

    <!--- Sidemenu -->
    <ul class="side-nav">

        <li class="side-nav-title">Navegacion</li>

        <li class="side-nav-item">
            <a href="{{ route('admin.dashboard') }}" class="side-nav-link">
                <i class="uil-home-alt"></i>
                <span class="badge bg-success float-end">1</span>
                <span> Dashboards </span>
            </a>
        </li>


        <li class="side-nav-title">Apps</li>
        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarProjects" aria-expanded="false"
                aria-controls="sidebarProjects" class="side-nav-link">
                <i class="uil-briefcase"></i>
                <span> Gestion de Tickets </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarProjects">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="#">Ver Tickets</a>
                    </li>
                    <li>
                        <a href="#">Crear Tickets</a>
                    </li>


                </ul>
            </div>
        </li>

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarCrm" aria-expanded="false" aria-controls="sidebarCrm"
                class="side-nav-link">
                <i class="uil uil-tachometer-fast"></i>
                <span> Gestion de Usuarios </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarCrm">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="pages-usuario.html">Usuarios</a>
                    </li>
                    <li>
                        <a href="page-clientes.html">Clientes</a>
                    </li>
                    <li>
                        <a href="pages-sociedades.html">Sociedades</a>
                    </li>
                    <li>
                        <a href="page-solicitante.html">Solicitante</a>
                    </li>
                    <li>
                        <a href="pages-consultor-sap.html">Consultor</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarTasks" aria-expanded="false"
                aria-controls="sidebarTasks" class="side-nav-link">
                <i class="uil-clipboard-alt"></i>
                <span> Reportes </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarTasks">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="apps-tasks.html">Lista</a>
                    </li>
                    <li>
                        <a href="apps-tasks-details.html">Detalles de Lista</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="side-nav-title">Catalogos</li>
        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarLayouts" aria-expanded="false"
                aria-controls="sidebarLayouts" class="side-nav-link">
                <i class="uil-window"></i>
                <span> Tablas Maestras </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarLayouts">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="pages-asignaciones.html">Asignaciones</a>
                    </li>
                    <li>
                        <a href="pages-modulos-sap.html">Modulos</a>
                    </li>

                </ul>
            </div>
        </li>

    </ul>
    <!--- End Sidemenu -->

    <div class="clearfix"></div>
</div>