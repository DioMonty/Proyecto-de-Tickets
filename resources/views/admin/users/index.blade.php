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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Rensar Consuling</a>
                            </li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Gestión de
                                    Usuarios</a></li>
                            <li class="breadcrumb-item active">Usuarios</li>
                        </ol>
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
        <div class="row mb-3 align-items-center">
            <!-- Botón izquierdo -->
            <div class="col d-flex">
                <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal"
                    data-bs-target="#agregar-modal">
                    <i class="mdi mdi-account-multiple-plus-outline me-1"></i> Agregar Usuario
                </button>
            </div>

            <!-- Botones derechos -->
            <div class="col d-flex justify-content-end gap-2 ">
                <button type="button" class="btn btn-warning px-3"> Imprimir
                    <i class="mdi mdi-cloud-print me-1"></i> 
                </button>
                <button type="button" class="btn btn-info px-3"> Filtrar
                    <i class="mdi mdi-account-filter me-1"></i> 
                </button>

            </div>
        </div>

        <!-- Tabla de usuarios -->
        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Correo Electrónico</th>
                    <th>User Name</th>
                    <th>Rol</th>
                    <th>Detalle</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="table-user">
                        <img src="{{asset($user->image)}}" alt="table-user"
                            class="me-2 rounded-circle" />
                        {{$user->nombre}}
                    </td>
                    <td>{{$user->apellido}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->role}}</td>
                    <td>
                        <button type="button" class="btn btn-success">Ver Detalle</button>
                    </td>
                    <td class="table-action">
                        <a href="#" class="action-icon" data-bs-toggle="modal"
                            data-bs-target="#editar-modal-{{$user->id}}">
                            <i class="mdi mdi-pencil"></i>
                        </a>
                        <a href="javascript: void(0);" class="action-icon" data-bs-toggle="modal"
                            data-bs-target="#warning-alert-modal-{{$user->id}}">
                            <i class="mdi mdi-delete"></i>
                        </a>
                    </td>
                </tr>

                <!-- Modal de confirmación eliminar -->
                <div id="warning-alert-modal-{{$user->id}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-body p-4">
                                <div class="text-center">
                                    <i class="ri-alert-line h1 text-warning"></i>
                                    <h4 class="mt-2">¿Estás Seguro?</h4>
                                    <p class="mt-3">
                                        Esta acción resultará en la eliminación permanente de la información
                                        seleccionada.
                                        Una vez eliminada, no será posible recuperarla.
                                    </p>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-warning my-2">Confirmar</button>
                                        <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">Cancelar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal editar usuario -->
                <div id="editar-modal-{{$user->id}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title" style="color: black;">Editar Usuario</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="ps-3 pe-3" action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="username-add" class="form-label">Nombre</label>
                                        <input class="form-control" type="text" name="name_user" value="{{$user->nombre}}" required
                                            placeholder="Nombre">
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellido-add" class="form-label">Apellido</label>
                                        <input class="form-control" type="text" name="lastname_user" value="{{$user->apellido}}" required
                                            placeholder="Apellido">
                                    </div>
                                    <div class="mb-3">
                                        <label for="username-add" class="form-label">Nombre de Usuario</label>
                                        <input class="form-control" type="text" name="username" value ="{{$user->username}}"
                                            placeholder="Ingrese el nombre de usuario">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email-add" class="form-label">Correo Electrónico</label>
                                        <input class="form-control" type="email" name="email" required value="{{$user->email}}"
                                            placeholder="john@deo.com">
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone-add" class="form-label">Teléfono</label>
                                        <input class="form-control" type="text" name="phone" value="{{$user->phone}}"
                                            placeholder="Ingrese el número de teléfono">
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-success">Actualizar</button>
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
    </div> <!-- container -->

    

    <!-- Modal agregar usuario -->
    <div id="agregar-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title" style="color: black;">Agregar Usuario</h4>
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

</div> <!-- content -->
@endsection
