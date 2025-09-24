@extends('admin.layouts.master')

@section('title', 'Usuarios | Rensar Consulting')

@section('content')
<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="uil-home-alt"></i> Gestion de Usuario</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                        </ol>
                    </nav>
                    </div>
                    <h4 class="page-title">Usuarios</h4>
                    <p class="mt-2 mb-3 text-muted">
                        Permite visualizar y gestionar los diferentes roles del sistema. Desde esta pantalla
                        se puede definir qué permisos y accesos tiene cada tipo de usuario.
                    </p>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Botones: Nuevo Acceso a la izquierda, Exportar + Filtros a la derecha -->
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-stat">
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregar-modal">
                        <i class="mdi mdi-account-multiple-plus-outline me-1"></i> Agregar Usuario
                    </button>
                    <button type="button" class="btn btn-warning">
                        <i class="mdi mdi-cloud-print me-1"></i> Exportar
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabla de usuarios -->
        <div class="mt-4 mb-4">
            <h5 class="m-0 pb-2">
                <a class="text-dark" data-bs-toggle="collapse" href="#adminTaks" role="button"
                    aria-expanded="false" aria-controls="todayTasks">
                    <i class='uil uil-angle-down font-18'></i>Administradores 
                    <span class="text-muted">({{ $administradores->count() }})</span>
                </a>
            </h5>

            <div class="collapse show" id="adminTaks">
                <div class="card mb-0">
                    <div class="card-body">
                        <!-- task -->
                        <table id="basic-datatable-one" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Correo Electrónico</th>
                                    <th>User Name</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                    <th>Activado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($administradores as $user)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td class="table-user">
                                        <img src="{{asset($user->image)}}" alt="table-user"
                                            class="me-2 rounded-circle" />
                                        {{$user->nombre}}
                                    </td>
                                    <td>{{$user->apellido}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->username}}</td>
                                    <td>{{$user->role}}</td>
                                    <td class="table-action">

                                        <a href="#" class="action-icon" data-bs-toggle="modal"
                                            data-bs-target="#editar-modal-{{$user->id}}">
                                            <i class="mdi mdi-pencil" data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Editar"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="action-icon"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detalle-modal-{{ $user->id }}">
                                            <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Detalle"></i>
                                        </a>
                                    </td>
                                    <td class="table-action">
                                        <div class="form-check form-switch d-flex">
                                            <input type="checkbox"
                                                class="form-check-input cambiar-estado"
                                                name="status"
                                                data-id="{{ $user->id }}"
                                                data-url="{{ url('admin/users/status', $user->id) }}"
                                                id="switch03-{{ $user->id }}"
                                                {{ $user->status === 'active' ? 'checked' : '' }}>

                                            <label for="switch03-{{ $user->id }}" class="switch-label mb-0 ms-2">
                                                {{ $user->status === 'active' ? 'Sí' : 'No' }}
                                            </label>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal detalle usuario -->
                                <div id="detalle-modal-{{ $user->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header text-center">
                                                <h4 class="modal-title">Detalle del
                                                    Usuario</h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="ps-3 pe-3">

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Nombre:</label>
                                                        <input type="text"
                                                            class="form-control bg-light border-0"
                                                            value="{{ $user->nombre}}" readonly
                                                            tabindex="-1">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Apellido:</label>
                                                        <input type="text"
                                                            class="form-control bg-light border-0"
                                                            value="{{ $user->apellido}}" readonly
                                                            tabindex="-1">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Nombre de
                                                            Usuario:</label>
                                                        <input type="text"
                                                            class="form-control bg-light border-0"
                                                            value="{{ $user->username}}" readonly
                                                            tabindex="-1">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Correo
                                                            Electrónico:</label>
                                                        <input type="text"
                                                            class="form-control bg-light border-0"
                                                            value="{{ $user->email}}" readonly
                                                            tabindex="-1">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Rol:</label>
                                                        <input type="text"
                                                            class="form-control bg-light border-0"
                                                            value="{{ $user->role}}" readonly tabindex="-1">
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-center">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal editar usuario -->
                                <div id="editar-modal-{{$user->id}}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header text-center">
                                                <h4 class="modal-title">Editar Usuario
                                                </h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="ps-3 pe-3"
                                                    action="{{ route('admin.users.update', $user->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="username-add"
                                                            class="form-label">Nombre</label>
                                                        <input class="form-control" type="text"
                                                            name="name_user" value="{{$user->nombre}}"
                                                            required placeholder="Nombre">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="apellido-add"
                                                            class="form-label">Apellido</label>
                                                        <input class="form-control" type="text"
                                                            name="lastname_user" value="{{$user->apellido}}"
                                                            required placeholder="Apellido">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="username-add" class="form-label">Nombre
                                                            de Usuario</label>
                                                        <input class="form-control" type="text"
                                                            name="username" value="{{$user->username}}"
                                                            placeholder="Ingrese el nombre de usuario">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email-add" class="form-label">Correo
                                                            Electrónico</label>
                                                        <input class="form-control" type="email"
                                                            name="email" required value="{{$user->email}}"
                                                            placeholder="john@deo.com">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="phone-add"
                                                            class="form-label">Teléfono</label>
                                                        <input class="form-control" type="text" name="phone"
                                                            value="{{$user->phone}}"
                                                            placeholder="Ingrese el número de teléfono">
                                                    </div>
                                                    <div class="modal-footer d-flex justify-content-center">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Cerrar</button>
                                                        <button type="submit"
                                                            class="btn btn-success">Actualizar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                @endforelse
                            </tbody>
                        </table>

                        <!-- end task -->
                    </div> <!-- end card-body-->
                </div> <!-- end card -->
            </div> <!-- end .collapse-->
        </div> <!-- end .mt-2-->

        
        <div class="mt-2 mb-4">
            <h5 class="m-0 pb-2">
                <a class="text-dark" data-bs-toggle="collapse" href="#consultorTaks" role="button"
                    aria-expanded="false" aria-controls="todayTasks">
                    <i class='uil uil-angle-down font-18'></i>Consultores 
                    <span class="text-muted">({{ $consultores->count() }})</span>
                </a>
            </h5>

            <div class="collapse show" id="consultorTaks">
                <div class="card mb-0">
                    <div class="card-body">
                        <!-- task -->
                        <table id="basic-datatable-two" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Correo Electrónico</th>
                                    <th>User Name</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                    <th>Activado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($consultores as $user)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td class="table-user">
                                        <img src="{{asset($user->image)}}" alt="table-user"
                                            class="me-2 rounded-circle" />
                                        {{$user->nombre}}
                                    </td>
                                    <td>{{$user->apellido}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->username}}</td>
                                    <td>{{$user->role}}</td>
                                    <td class="table-action">

                                        <a href="#" class="action-icon" data-bs-toggle="modal"
                                            data-bs-target="#editar-modal-{{$user->id}}">
                                            <i class="mdi mdi-pencil" data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Editar"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="action-icon"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detalle-modal-{{ $user->id }}">
                                            <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Detalle"></i>
                                        </a>
                                    </td>
                                    <td class="table-action">
                                        <div class="form-check form-switch d-flex">
                                            <input type="checkbox"
                                                class="form-check-input cambiar-estado"
                                                name="status"
                                                data-id="{{ $user->id }}"
                                                data-url="{{ url('admin/users/status', $user->id) }}"
                                                id="switch03-{{ $user->id }}"
                                                {{ $user->status === 'active' ? 'checked' : '' }}>

                                            <label for="switch03-{{ $user->id }}" class="switch-label mb-0 ms-2">
                                                {{ $user->status === 'active' ? 'Sí' : 'No' }}
                                            </label>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal detalle usuario -->
                                <div id="detalle-modal-{{ $user->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header text-center">
                                                <h4 class="modal-title">Detalle del
                                                    Usuario</h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="ps-3 pe-3">

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Nombre:</label>
                                                        <input type="text"
                                                            class="form-control bg-light border-0"
                                                            value="{{ $user->nombre}}" readonly
                                                            tabindex="-1">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Apellido:</label>
                                                        <input type="text"
                                                            class="form-control bg-light border-0"
                                                            value="{{ $user->apellido}}" readonly
                                                            tabindex="-1">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Nombre de
                                                            Usuario:</label>
                                                        <input type="text"
                                                            class="form-control bg-light border-0"
                                                            value="{{ $user->username}}" readonly
                                                            tabindex="-1">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Correo
                                                            Electrónico:</label>
                                                        <input type="text"
                                                            class="form-control bg-light border-0"
                                                            value="{{ $user->email}}" readonly
                                                            tabindex="-1">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Rol:</label>
                                                        <input type="text"
                                                            class="form-control bg-light border-0"
                                                            value="{{ $user->role}}" readonly tabindex="-1">
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-center">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal editar usuario -->
                                <div id="editar-modal-{{$user->id}}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header text-center">
                                                <h4 class="modal-title">Editar Usuario
                                                </h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="ps-3 pe-3"
                                                    action="{{ route('admin.users.update', $user->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="username-add"
                                                            class="form-label">Nombre</label>
                                                        <input class="form-control" type="text"
                                                            name="name_user" value="{{$user->nombre}}"
                                                            required placeholder="Nombre">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="apellido-add"
                                                            class="form-label">Apellido</label>
                                                        <input class="form-control" type="text"
                                                            name="lastname_user" value="{{$user->apellido}}"
                                                            required placeholder="Apellido">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="username-add" class="form-label">Nombre
                                                            de Usuario</label>
                                                        <input class="form-control" type="text"
                                                            name="username" value="{{$user->username}}"
                                                            placeholder="Ingrese el nombre de usuario">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email-add" class="form-label">Correo
                                                            Electrónico</label>
                                                        <input class="form-control" type="email"
                                                            name="email" required value="{{$user->email}}"
                                                            placeholder="john@deo.com">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="phone-add"
                                                            class="form-label">Teléfono</label>
                                                        <input class="form-control" type="text" name="phone"
                                                            value="{{$user->phone}}"
                                                            placeholder="Ingrese el número de teléfono">
                                                    </div>
                                                    <div class="modal-footer d-flex justify-content-center">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Cerrar</button>
                                                        <button type="submit"
                                                            class="btn btn-success">Actualizar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                @endforelse
                            </tbody>
                        </table>

                        <!-- end task -->
                    </div> <!-- end card-body-->
                </div> <!-- end card -->
            </div> <!-- end .collapse-->
        </div> <!-- end .mt-2-->
        <div class="mt-2 mb-4">
            <h5 class="m-0 pb-2">
                <a class="text-dark" data-bs-toggle="collapse" href="#clienteTaks" role="button"
                    aria-expanded="false" aria-controls="todayTasks">
                    <i class='uil uil-angle-down font-18'></i>Clientes
                        <span class="text-muted">({{ $users->count() }})</span>
                </a>
            </h5>

            <div class="collapse show" id="clienteTaks">
                <div class="card mb-0">
                    <div class="card-body">
                        <!-- task -->
                        <table id="basic-datatable-three" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Correo Electrónico</th>
                                    <th>User Name</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                    <th>Activado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td class="table-user">
                                        <img src="{{asset($user->image)}}" alt="table-user"
                                            class="me-2 rounded-circle" />
                                        {{$user->nombre}}
                                    </td>
                                    <td>{{$user->apellido}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->username}}</td>
                                    <td>{{$user->role}}</td>
                                    <td class="table-action">

                                        <a href="#" class="action-icon" data-bs-toggle="modal"
                                            data-bs-target="#editar-modal-{{$user->id}}">
                                            <i class="mdi mdi-pencil" data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Editar"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="action-icon"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detalle-modal-{{ $user->id }}">
                                            <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Detalle"></i>
                                        </a>
                                    </td>
                                    <td class="table-action">
                                        <div class="form-check form-switch d-flex">
                                            <input type="checkbox"
                                                class="form-check-input cambiar-estado"
                                                name="status"
                                                data-id="{{ $user->id }}"
                                                data-url="{{ url('admin/users/status', $user->id) }}"
                                                id="switch03-{{ $user->id }}"
                                                {{ $user->status === 'active' ? 'checked' : '' }}>

                                            <label for="switch03-{{ $user->id }}" class="switch-label mb-0 ms-2">
                                                {{ $user->status === 'active' ? 'Sí' : 'No' }}
                                            </label>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal detalle usuario -->
                                <div id="detalle-modal-{{ $user->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header text-center">
                                                <h4 class="modal-title" >Detalle del
                                                    Usuario</h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="ps-3 pe-3">

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Nombre:</label>
                                                        <input type="text"
                                                            class="form-control bg-light border-0"
                                                            value="{{ $user->nombre}}" readonly
                                                            tabindex="-1">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Apellido:</label>
                                                        <input type="text"
                                                            class="form-control bg-light border-0"
                                                            value="{{ $user->apellido}}" readonly
                                                            tabindex="-1">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Nombre de
                                                            Usuario:</label>
                                                        <input type="text"
                                                            class="form-control bg-light border-0"
                                                            value="{{ $user->username}}" readonly
                                                            tabindex="-1">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Correo
                                                            Electrónico:</label>
                                                        <input type="text"
                                                            class="form-control bg-light border-0"
                                                            value="{{ $user->email}}" readonly
                                                            tabindex="-1">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Rol:</label>
                                                        <input type="text"
                                                            class="form-control bg-light border-0"
                                                            value="{{ $user->role}}" readonly tabindex="-1">
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-center">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal editar usuario -->
                                <div id="editar-modal-{{$user->id}}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header text-center">
                                                <h4 class="modal-title">Editar Usuario
                                                </h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="ps-3 pe-3"
                                                    action="{{ route('admin.users.update', $user->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="username-add"
                                                            class="form-label">Nombre</label>
                                                        <input class="form-control" type="text"
                                                            name="name_user" value="{{$user->nombre}}"
                                                            required placeholder="Nombre">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="apellido-add"
                                                            class="form-label">Apellido</label>
                                                        <input class="form-control" type="text"
                                                            name="lastname_user" value="{{$user->apellido}}"
                                                            required placeholder="Apellido">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="username-add" class="form-label">Nombre
                                                            de Usuario</label>
                                                        <input class="form-control" type="text"
                                                            name="username" value="{{$user->username}}"
                                                            placeholder="Ingrese el nombre de usuario">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email-add" class="form-label">Correo
                                                            Electrónico</label>
                                                        <input class="form-control" type="email"
                                                            name="email" required value="{{$user->email}}"
                                                            placeholder="john@deo.com">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="phone-add"
                                                            class="form-label">Teléfono</label>
                                                        <input class="form-control" type="text" name="phone"
                                                            value="{{$user->phone}}"
                                                            placeholder="Ingrese el número de teléfono">
                                                    </div>
                                                    <div class="modal-footer d-flex justify-content-center">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Cerrar</button>
                                                        <button type="submit"
                                                            class="btn btn-success">Actualizar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                @endforelse
                            </tbody>
                        </table>

                        <!-- end task -->
                    </div> <!-- end card-body-->
                </div> <!-- end card -->
            </div> <!-- end .collapse-->
        </div> <!-- end .mt-2-->
    </div> <!-- container -->



    <!-- Modal agregar usuario -->
    <div id="agregar-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title">Agregar Usuario</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ps-3 pe-3" action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="username-add" class="form-label">Nombre</label>
                            <input class="form-control" type="text" name="name_user" required
                                placeholder="Nombre">
                        </div>
                        <div class="mb-3">
                            <label for="apellido-add" class="form-label">Apellido</label>
                            <input class="form-control" type="text" name="lastname_user" required
                                placeholder="Apellido">
                        </div>
                        <div class="mb-3">
                            <label for="username-add" class="form-label">Nombre de Usuario</label>
                            <input class="form-control" type="text" name="username"
                                placeholder="Ingrese el nombre de usuario">
                        </div>
                        <div class="mb-3">
                            <label for="email-add" class="form-label">Correo Electrónico</label>
                            <input class="form-control" type="email" name="email" required
                                placeholder="john@deo.com">
                        </div>
                        <div class="mb-3">
                            <label for="phone-add" class="form-label">Teléfono</label>
                            <input class="form-control" type="text" name="phone"
                                placeholder="Ingrese el número de teléfono">
                        </div>
                        <div class="mb-3">
                            <label for="password-add" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <input class="form-control" type="password" required id="password-add" name="password"
                                    placeholder="Ingrese la contraseña">
                                <a class="btn btn-outline-secondary" type="button" onclick="document.getElementById('password-add').type = document.getElementById('password-add').type === 'password' ? 'text' : 'password'">
                                    <i class="mdi mdi-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="rol-add" class="form-label">Rol</label>
                            <select class="form-control" name="rol" required>
                                <option value="" disabled selected>Seleccione un rol</option>
                                <option value="admin">Administrador</option>
                                <option value="user">Cliente</option>
                                <option value="consultor">Consultor</option>
                            </select>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div> 
<script>
    $(document).ready(function () {
        $('.cambiar-estado').change(function () {
            var checkbox = $(this);
            var url = checkbox.data('url');
            var estado = checkbox.is(':checked');
            var label = checkbox.next('.switch-label');

            // Actualizar label antes de enviar
            label.text(estado ? 'Sí' : 'No');

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    estado: estado,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log("Estado actualizado", response);
                },
                error: function (xhr) {
                    alert('Error al actualizar el estado');
                    // revertir si falla
                    checkbox.prop('checked', !estado);
                    label.text(!estado ? 'Sí' : 'No');
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
    "use strict";
    $("#basic-datatable-one").DataTable({
        keys: !0,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>",
            },
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
        },
    });
    $("#basic-datatable-two").DataTable({
        keys: !0,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>",
            },
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
        },
        
    });
    $("#basic-datatable-three").DataTable({
        keys: !0,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>",
            },
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
        },
    });
    var a = $("#datatable-buttons").DataTable({
        lengthChange: !1,
        buttons: ["copy", "print"],
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>",
            },
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
        },
    });
    $("#selection-datatable").DataTable({
        select: { style: "multi" },
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>",
            },
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
        },
    }),
        a
            .buttons()
            .container()
            .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"),
        $("#alternative-page-datatable").DataTable({
            pagingType: "full_numbers",
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass(
                    "pagination-rounded"
                );
            },
        }),
        $("#scroll-vertical-datatable").DataTable({
            scrollY: "350px",
            scrollCollapse: !0,
            paging: !1,
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>",
                },
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass(
                    "pagination-rounded"
                );
            },
        }),
        $("#scroll-horizontal-datatable").DataTable({
            scrollX: !0,
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>",
                },
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass(
                    "pagination-rounded"
                );
            },
        }),
        $("#complex-header-datatable").DataTable({
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>",
                },
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass(
                    "pagination-rounded"
                );
            },
            columnDefs: [{ visible: !1, targets: -1 }],
        }),
        $("#row-callback-datatable").DataTable({
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>",
                },
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass(
                    "pagination-rounded"
                );
            },
            createdRow: function (a, e, t) {
                15e4 < +e[5].replace(/[\$,]/g, "") &&
                    $("td", a).eq(5).addClass("text-danger");
            },
        }),
        $("#state-saving-datatable").DataTable({
            stateSave: !0,
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>",
                },
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass(
                    "pagination-rounded"
                );
            },
        }),
        $("#fixed-columns-datatable").DataTable({
            scrollY: 300,
            scrollX: !0,
            scrollCollapse: !0,
            paging: !1,
            fixedColumns: !0,
        }),
        $(".dataTables_length select").addClass("form-select form-select-sm"),
        $(".dataTables_length label").addClass("form-label");
}),
    $(document).ready(function () {
        var a = $("#fixed-header-datatable").DataTable({
            responsive: !0,
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>",
                },
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass(
                    "pagination-rounded"
                );
            },
        });
        new $.fn.dataTable.FixedHeader(a);
    });
</script>
@endsection