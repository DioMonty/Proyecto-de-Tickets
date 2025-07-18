@extends('admin.layouts.master')

@section('content')
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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tickets</li>
                    </ol>
                </div>
                <h4 class="page-title">Tickets</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card rounded-0 shadow-none m-0">
                                <div class="card-body text-center">
                                    <i class="ri-briefcase-line text-muted font-24"></i>
                                    <h3><span>29</span></h3>
                                    <p class="text-muted font-15 mb-0">Total Tickets</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="card rounded-0 shadow-none m-0 border-start border-light">
                                <div class="card-body text-center">
                                    <i class="ri-list-check-2 text-muted font-24"></i>
                                    <h3><span>715</span></h3>
                                    <p class="text-muted font-15 mb-0">Total Clientes</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="card rounded-0 shadow-none m-0 border-start border-light">
                                <div class="card-body text-center">
                                    <i class="ri-group-line text-muted font-24"></i>
                                    <h3><span>31</span></h3>
                                    <p class="text-muted font-15 mb-0">Miembros</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card rounded-0 shadow-none m-0 border-start border-light">
                                <div class="card-body text-center">
                                    <i class="ri-line-chart-line text-muted font-24"></i>
                                    <h3><span>5</span> <i class="mdi mdi-arrow-up text-success"></i>
                                    </h3>
                                    <p class="text-muted font-15 mb-0">Facturados</p>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end row -->
                </div>
            </div> <!-- end card-box-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Tasks</h4>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle arrow-none card-drop"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Weekly Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Monthly Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                        </div>
                    </div>
                </div>
                <div
                    class="card-header bg-light-lighten border-top border-bottom border-light py-1 text-center">
                    <p class="m-0"><b>107</b> Tasks completed out of 195</p>
                </div>
                <div class="card-body pt-2">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <tbody>
                                <tr>
                                    <td>
                                        <h5 class="font-14 my-1"><a href="javascript:void(0);"
                                                class="text-body">Coffee detail page - Main Page</a>
                                        </h5>
                                        <span class="text-muted font-13">Due in 3 days</span>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Status</span> <br />
                                        <span class="badge badge-warning-lighten">In-progress</span>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Assigned to</span>
                                        <h5 class="font-14 mt-1 fw-normal">Logan R. Cohn</h5>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Total time spend</span>
                                        <h5 class="font-14 mt-1 fw-normal">3h 20min</h5>
                                    </td>
                                    <td class="table-action" style="width: 90px;">
                                        <a href="javascript: void(0);" class="action-icon"> <i
                                                class="mdi mdi-pencil"></i></a>
                                        <a href="javascript: void(0);" class="action-icon"> <i
                                                class="mdi mdi-delete"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 class="font-14 my-1"><a href="javascript:void(0);"
                                                class="text-body">Drinking bottle graphics</a></h5>
                                        <span class="text-muted font-13">Due in 27 days</span>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Status</span> <br />
                                        <span class="badge badge-danger-lighten">Outdated</span>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Assigned to</span>
                                        <h5 class="font-14 mt-1 fw-normal">Jerry F. Powell</h5>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Total time spend</span>
                                        <h5 class="font-14 mt-1 fw-normal">12h 21min</h5>
                                    </td>
                                    <td class="table-action" style="width: 90px;">
                                        <a href="javascript: void(0);" class="action-icon"> <i
                                                class="mdi mdi-pencil"></i></a>
                                        <a href="javascript: void(0);" class="action-icon"> <i
                                                class="mdi mdi-delete"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 class="font-14 my-1"><a href="javascript:void(0);"
                                                class="text-body">App design and development</a></h5>
                                        <span class="text-muted font-13">Due in 7 days</span>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Status</span> <br />
                                        <span class="badge badge-success-lighten">Completed</span>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Assigned to</span>
                                        <h5 class="font-14 mt-1 fw-normal">Scot M. Smith</h5>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Total time spend</span>
                                        <h5 class="font-14 mt-1 fw-normal">78h 05min</h5>
                                    </td>
                                    <td class="table-action" style="width: 90px;">
                                        <a href="javascript: void(0);" class="action-icon"> <i
                                                class="mdi mdi-pencil"></i></a>
                                        <a href="javascript: void(0);" class="action-icon"> <i
                                                class="mdi mdi-delete"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 class="font-14 my-1"><a href="javascript:void(0);"
                                                class="text-body">Poster illustation design</a></h5>
                                        <span class="text-muted font-13">Due in 5 days</span>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Status</span> <br />
                                        <span class="badge badge-warning-lighten">In-progress</span>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Assigned to</span>
                                        <h5 class="font-14 mt-1 fw-normal">John P. Ritter</h5>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Total time spend</span>
                                        <h5 class="font-14 mt-1 fw-normal">26h 58min</h5>
                                    </td>
                                    <td class="table-action" style="width: 90px;">
                                        <a href="javascript: void(0);" class="action-icon"> <i
                                                class="mdi mdi-pencil"></i></a>
                                        <a href="javascript: void(0);" class="action-icon"> <i
                                                class="mdi mdi-delete"></i></a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div> <!-- end table-responsive-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Actividades Recientes</h4>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle arrow-none card-drop"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Weekly Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Monthly Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-start">
                                            <img class="me-2 rounded-circle"
                                                src="{{asset('backend/assets/images/users/avatar-2.jpg')}}" width="40"
                                                alt="Generic placeholder image">
                                            <div>
                                                <h5 class="mt-0 mb-1">Soren Drouin<small
                                                        class="fw-normal ms-3">18 Jan 2019 11:28
                                                        pm</small></h5>
                                                <span class="font-13">Completed "Design new
                                                    idea"...</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Project</span> <br />
                                        <p class="mb-0">Hyper Mockup</p>
                                    </td>
                                    <td class="table-action" style="width: 50px;">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-horizontal"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <!-- item-->
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item">Settings</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item">Action</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="d-flex align-items-start">
                                            <img class="me-2 rounded-circle"
                                                src="{{asset('backend/assets/images/users/avatar-6.jpg')}}" width="40"
                                                alt="Generic placeholder image">
                                            <div>
                                                <h5 class="mt-0 mb-1">Anne Simard<small
                                                        class="fw-normal ms-3">18 Jan 2019 11:09
                                                        pm</small></h5>
                                                <span class="font-13">Assigned task "Poster illustation
                                                    design"...</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Project</span> <br />
                                        <p class="mb-0">Hyper Mockup</p>
                                    </td>
                                    <td class="table-action" style="width: 50px;">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-horizontal"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <!-- item-->
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item">Settings</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item">Action</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="d-flex align-items-start">
                                            <img class="me-2 rounded-circle"
                                                src="{{asset('backend/assets/images/users/avatar-3.jpg')}}" width="40"
                                                alt="Generic placeholder image">
                                            <div>
                                                <h5 class="mt-0 mb-1">Nicolas Chartier<small
                                                        class="fw-normal ms-3">15 Jan 2019 09:29
                                                        pm</small></h5>
                                                <span class="font-13">Completed "Drinking bottle
                                                    graphics"...</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Project</span> <br />
                                        <p class="mb-0">Web UI Design</p>
                                    </td>
                                    <td class="table-action" style="width: 50px;">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-horizontal"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <!-- item-->
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item">Settings</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item">Action</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="d-flex align-items-start">
                                            <img class="me-2 rounded-circle"
                                                src="{{asset('backend/assets/images/users/avatar-4.jpg')}}" width="40"
                                                alt="Generic placeholder image">
                                            <div>
                                                <h5 class="mt-0 mb-1">Gano Cloutier<small
                                                        class="fw-normal ms-3">10 Jan 2019 08:36
                                                        pm</small></h5>
                                                <span class="font-13">Completed "Design new
                                                    idea"...</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Project</span> <br />
                                        <p class="mb-0">UBold Admin</p>
                                    </td>
                                    <td class="table-action" style="width: 50px;">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-horizontal"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <!-- item-->
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item">Settings</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item">Action</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="d-flex align-items-start">
                                            <img class="me-2 rounded-circle"
                                                src="{{asset('backend/assets/images/users/avatar-5.jpg')}}" width="40"
                                                alt="Generic placeholder image">
                                            <div>
                                                <h5 class="mt-0 mb-1">Francis Achin<small
                                                        class="fw-normal ms-3">08 Jan 2019 12:28
                                                        pm</small></h5>
                                                <span class="font-13">Assigned task "Hyper app
                                                    design"...</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Project</span> <br />
                                        <p class="mb-0">Website Mockup</p>
                                    </td>
                                    <td class="table-action" style="width: 50px;">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-horizontal"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <!-- item-->
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item">Settings</a>
                                                <!-- item-->
                                                <a href="javascript:void(0);"
                                                    class="dropdown-item">Action</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div> <!-- end table-responsive-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->


</div> <!-- container -->
@endsection