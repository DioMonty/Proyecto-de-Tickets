@extends('admin.layouts.master')

@section('content')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Rensar Consulting</a>
                            </li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Gestion de
                                    Tickets</a></li>
                            <li class="breadcrumb-item active">Tickets</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Lista de Tickets</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row mb-2">
            <div class="col-sm-4">
                <a href="{{route('admin.ticket.create')}}" class="btn btn-danger rounded-pill mb-3"><i
                        class="mdi mdi-plus"></i> Crear Tickets</a>
            </div>
            <div class="col-sm-8">
                <div class="text-sm-end">
                    <div class="btn-group mb-3">
                        <button type="button" class="btn btn-primary">Todo</button>
                    </div>
                    <div class="btn-group mb-3 ms-1">
                        <button type="button" class="btn btn-light">Bolsa</button>
                        <button type="button" class="btn btn-light">Orden de Compra</button>
                    </div>
                    <div class="btn-group mb-3 ms-2 d-none d-sm-inline-block">
                        <button type="button" class="btn btn-secondary"><i
                                class="ri-function-line"></i></button>
                    </div>
                    <div class="btn-group mb-3 d-none d-sm-inline-block">
                        <button type="button" class="btn btn-link text-muted"><i
                                class="ri-list-check-2"></i></button>
                    </div>
                </div>
            </div><!-- end col-->
        </div>
        <!-- end row-->

        <div class="row">
            <div class="col-md-6 col-xxl-3">
                <!-- project card -->
                <div class="card d-block">
                    <div class="card-body">
                        <div class="dropdown card-widgets">
                            <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ri-more-fill"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item"><i
                                        class="mdi mdi-pencil me-1"></i>Editar</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item"><i
                                        class="mdi mdi-delete me-1"></i>Eliminar</a>

                            </div>
                        </div>
                        <!-- project title-->
                        <h4 class="mt-0">
                            <a href="apps-projects-details.html" class="text-title">RE000145 - Creación de
                                lista de Matetiales</a>
                        </h4>
                        <div class="badge bg-secondary">Orden de Compra</div>

                        <p class="text-muted font-13 my-3">Con texto de apoyo a continuación como
                            introducción natural a contenido adicional antes de...<a
                                href="apps-projects-details.html" class="fw-bold text-muted">view more</a>
                        </p>

                        <!-- project detail-->
                        <p class="mb-1">
                            <span class="pe-2 text-nowrap mb-2 d-inline-block">
                                <i class="mdi mdi-format-list-bulleted-type text-muted"></i>
                                <b>Abap:</b> Diego Legua
                            </span>
                            <span class="text-nowrap mb-2 d-inline-block">
                                <i class="mdi mdi-comment-multiple-outline text-muted"></i>
                                <b>Funcional:</b> Adolfo
                            </span>
                        </p>
                    </div> <!-- end card-body-->
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-3">
                            <!-- project progress-->
                            <p class="mb-2 fw-bold">Progress <span class="float-end">100%</span></p>
                            <div class="progress progress-sm">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                </div><!-- /.progress-bar -->
                            </div><!-- /.progress -->
                        </li>
                    </ul>
                </div> <!-- end card-->
            </div> <!-- end col -->
            <div class="col-md-6 col-xxl-3">
                <!-- project card -->
                <div class="card d-block">
                    <div class="card-body">
                        <div class="dropdown card-widgets">
                            <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ri-more-fill"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item"><i
                                        class="mdi mdi-pencil me-1"></i>Editar</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item"><i
                                        class="mdi mdi-delete me-1"></i>Eliminar</a>

                            </div>
                        </div>
                        <!-- project title-->
                        <h4 class="mt-0">
                            <a href="apps-projects-details.html" class="text-title">RE000146 - Creación de
                                lista de Matetiales</a>
                        </h4>
                        <div class="badge bg-success">Bolsa</div>

                        <p class="text-muted font-13 my-3">Con texto de apoyo a continuación como
                            introducción natural a contenido adicional antes de...<a
                                href="apps-projects-details.html" class="fw-bold text-muted">view more</a>
                        </p>

                        <!-- project detail-->
                        <p class="mb-1">
                            <span class="pe-2 text-nowrap mb-2 d-inline-block">
                                <i class="mdi mdi-format-list-bulleted-type text-muted"></i>
                                <b>Abap:</b> Diego Legua
                            </span>
                            <span class="text-nowrap mb-2 d-inline-block">
                                <i class="mdi mdi-comment-multiple-outline text-muted"></i>
                                <b>Funcional:</b> Adolfo
                            </span>
                        </p>
                    </div> <!-- end card-body-->
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-3">
                            <!-- project progress-->
                            <p class="mb-2 fw-bold">Progress <span class="float-end">100%</span></p>
                            <div class="progress progress-sm">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                </div><!-- /.progress-bar -->
                            </div><!-- /.progress -->
                        </li>
                    </ul>
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row-->

        <div class="row">

            <div class="col-md-6 col-xxl-3">
                <!-- project card -->
                <div class="card d-block">
                    <!-- project-thumbnail -->
                    <img class="card-img-top" src="assets/images/projects/project-3.jpg"
                        alt="project image cap">
                    <div class="card-img-overlay">
                        <div class="badge bg-secondary text-light p-1">Ongoing</div>
                    </div>

                    <div class="card-body position-relative">
                        <!-- project title-->
                        <h4 class="mt-0">
                            <a href="apps-projects-details.html" class="text-title">Product page
                                redesign</a>
                        </h4>

                        <!-- project detail-->
                        <p class="mb-3">
                            <span class="pe-2 text-nowrap">
                                <i class="mdi mdi-format-list-bulleted-type"></i>
                                <b>21</b> Tasks
                            </span>
                            <span class="text-nowrap">
                                <i class="mdi mdi-comment-multiple-outline"></i>
                                <b>668</b> Comments
                            </span>
                        </p>
                        <div class="mb-3" id="tooltip-container6">
                            <a href="javascript:void(0);" data-bs-container="#tooltip-container6"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Mat Helme"
                                class="d-inline-block">
                                <img src="assets/images/users/avatar-6.jpg" class="rounded-circle avatar-xs"
                                    alt="friend">
                            </a>

                            <a href="javascript:void(0);" data-bs-container="#tooltip-container6"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Michael Zenaty"
                                class="d-inline-block">
                                <img src="assets/images/users/avatar-7.jpg" class="rounded-circle avatar-xs"
                                    alt="friend">
                            </a>

                            <a href="javascript:void(0);" data-bs-container="#tooltip-container6"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="James Anderson"
                                class="d-inline-block">
                                <img src="assets/images/users/avatar-8.jpg" class="rounded-circle avatar-xs"
                                    alt="friend">
                            </a>
                            <a href="javascript:void(0);" class="d-inline-block text-muted fw-bold ms-2">
                                +5 more
                            </a>
                        </div>

                        <!-- project progress-->
                        <p class="mb-2 fw-bold">Progress <span class="float-end">71%</span></p>
                        <div class="progress progress-sm">
                            <div class="progress-bar" role="progressbar" aria-valuenow="71"
                                aria-valuemin="0" aria-valuemax="100" style="width: 71%;">
                            </div><!-- /.progress-bar -->
                        </div><!-- /.progress -->
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->

            <div class="col-md-6 col-xxl-3">
                <!-- project card -->
                <div class="card d-block">
                    <!-- project-thumbnail -->
                    <img class="card-img-top" src="assets/images/projects/project-4.jpg"
                        alt="project image cap">
                    <div class="card-img-overlay">
                        <div class="badge bg-secondary text-light p-1">Ongoing</div>
                    </div>

                    <div class="card-body position-relative">
                        <!-- project title-->
                        <h4 class="mt-0">
                            <a href="apps-projects-details.html" class="text-title">Coffee detail page -
                                Main Page</a>
                        </h4>

                        <!-- project detail-->
                        <p class="mb-3">
                            <span class="pe-2 text-nowrap">
                                <i class="mdi mdi-format-list-bulleted-type"></i>
                                <b>18</b> Tasks
                            </span>
                            <span class="text-nowrap">
                                <i class="mdi mdi-comment-multiple-outline"></i>
                                <b>259</b> Comments
                            </span>
                        </p>
                        <div class="mb-3" id="tooltip-container7">
                            <a href="javascript:void(0);" data-bs-container="#tooltip-container7"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Mat Helme"
                                class="d-inline-block">
                                <img src="assets/images/users/avatar-2.jpg" class="rounded-circle avatar-xs"
                                    alt="friend">
                            </a>

                            <a href="javascript:void(0);" data-bs-container="#tooltip-container7"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Michael Zenaty"
                                class="d-inline-block">
                                <img src="assets/images/users/avatar-3.jpg" class="rounded-circle avatar-xs"
                                    alt="friend">
                            </a>
                        </div>

                        <!-- project progress-->
                        <p class="mb-2 fw-bold">Progress <span class="float-end">52%</span></p>
                        <div class="progress progress-sm">
                            <div class="progress-bar" role="progressbar" aria-valuenow="52"
                                aria-valuemin="0" aria-valuemax="100" style="width: 52%;">
                            </div><!-- /.progress-bar -->
                        </div><!-- /.progress -->
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row-->

    </div> <!-- container -->

</div> <!-- content -->
@endsection