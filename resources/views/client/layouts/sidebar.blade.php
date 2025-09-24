<!-- Brand Logo Light -->
            <a href="{{ route('client.dashboard') }}" class="logo logo-light">
                <span class="logo-lg">
                    <img src="{{asset('backend/assets/images/logo-light.png')}}" alt="logo">
                </span>
                <span class="logo-sm">
                    <img src="{{asset('backend/assets/images/logo-sm.png')}}" alt="small logo">
                </span>
            </a>
            <!-- Brand Logo Dark -->
            <a href="{{ route('client.dashboard') }}" class="logo logo-dark">
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

                    <li class="side-nav-title">Navegacion Principal</li>

                    <li class="side-nav-item">
                        <a href="{{ route('client.dashboard') }}" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <span class="badge bg-danger float-end">1</span>
                            <span> Dashboards </span>
                        </a>
                    </li>

                    <li class="side-nav-title">Resultados y Analisis</li>
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarProjects" aria-expanded="false"
                            aria-controls="sidebarProjects" class="side-nav-link">
                            <i class="uil-clipboard-alt"></i>
                            <span> Reportes </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarProjects">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{route('client.ticket.index')}}">Bandeja de Estados</a>
                                </li>
                                <li>
                                    <a href="{{route('client.ticket.all.index')}}">Tickets Terminados</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Help Box -->
                    <div class="help-box text-white text-center">
                        <img src="{{asset('backend/assets/images/svg/features-2.svg')}}" height="90" alt="Helper Icon Image" />
                        <h5 class="mt-3">Conoce más de Rensar Consulting</h5>
                        <p class="mb-3">Consulta información oficial y recursos en línea de manera rápida y segura.</p>
                        <a href="https://www.rensar.biz/wp/" target="_blank" class="btn btn-success btn-sm">Ir al sitio web</a>
                    </div>
                    <!-- end Help Box -->
                    
                </ul>
                <!--- End Sidemenu -->

                <div class="clearfix"></div>
            </div>