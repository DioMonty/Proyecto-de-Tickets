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
                            <li class="breadcrumb-item active">Sociedades</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Sociedades</h4>
                    <p class="mt-2 mb-3 text-muted">
                        Permite visualizar y gestionar las diferentes sociedades asociadas a un cliente.
                        Desde esta pantalla
                        se puede definir la información, los permisos y accesos específicos para cada
                        sociedad.
                    </p>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Botones: Nuevo Acceso a la izquierda, Exportar + Filtros a la derecha -->
        <div class="row mb-4 align-items-center">
            <!-- Botón izquierdo -->
            <div class="col d-flex">
                <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal"
                    data-bs-target="#agregar-modal">
                    <i class="mdi mdi-account-multiple-plus-outline me-1"></i> Agregar Sociedad
                </button>
            </div>

            <!-- Botones derechos -->
            <div class="col d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-warning px-4">
                    <i class="mdi mdi-cloud-print me-1"></i> Exportar
                </button>
                <button type="button" class="btn btn-info px-4">
                    <i class="mdi mdi-account-filter me-1"></i> Filtros
                </button>
            </div>
        </div>

        <!-- Tabla de usuarios -->
        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
            <thead>
                <tr>
                    <th>Sociedad</th>
                    <th>Cliente</th>
                    <th>Razon Social</th>
                    <th>RUC</th>
                    <th>Direccion</th>
                    <th>Detalle</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($sociedades as $sociedad)
                <tr>
                    <td>{{ $sociedad->nombre_sociedad }}</td>
                    <td>Prolan</td>
                    <td>{{ $sociedad->razon_social }}</td>
                    <td>{{ $sociedad->ruc }}</td>
                    <td>{{ $sociedad->direccion }}</td>
                    <td>
                        <button type="button" class="btn btn-success">Ver Detalle</button>
                    </td>
                    <td class="table-action">
                        <a type="button" class="action-icon" data-bs-toggle="modal"
                            data-bs-target="#editar-modal-{{ $sociedad->id }}">
                            <i class="mdi mdi-pencil"></i>
                        </a>
                        <a href="javascript: void(0);" class="action-icon" data-bs-toggle="modal"
                            data-bs-target="#warning-alert-modal-{{ $sociedad->id }}">
                            <i class="mdi mdi-delete"></i>
                        </a>
                    </td>
                </tr>

                <!-- Modal de confirmación eliminar -->
                <div id="warning-alert-modal-{{ $sociedad->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                                    <form method="POST" action="{{ route('admin.society.destroy', $sociedad->id) }}">
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
                <div id="editar-modal-{{ $sociedad->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title" style="color: black;">Editar Sociedad</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="ps-3 pe-3" action="{{ route('admin.society.update', $sociedad->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Sociedad</label>
                                        <input class="form-control" type="text" name="nombre_sociedad" value="{{ $sociedad->nombre_sociedad }}" required
                                            placeholder="Sociedad">
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellido" class="form-label">Cliente</label>
                                        <input class="form-control" type="text" name="id_client" value="Prolan" required
                                            placeholder="Cliente">
                                    </div>
                                    <div class="mb-3">
                                        <label for="emailaddress" class="form-label">Razon Social</label>
                                        <input class="form-control" type="text" name="razon_social" value="{{ $sociedad->razon_social }}" required
                                            placeholder="Ingrese su razon Social">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">RUC</label>
                                        <input class="form-control" type="number" required name="ruc" value="{{ $sociedad->ruc }}"
                                            placeholder="Ingrese el RUC">
                                    </div>
                                    <div class="mb-3">
                                        <label for="rol" class="form-label">Direccion</label>
                                        <input class="form-control" type="text" required name="direccion" value="{{ $sociedad->direccion }}"
                                            placeholder="Ingrese la direccion">
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
                    <h4 class="modal-title" style="color: black;">Agregar Sociedad</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ps-3 pe-3" action="{{ route('admin.society.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Sociedad</label>
                            <input class="form-control" type="text" name="nombre_sociedad" required
                                placeholder="Sociedad">
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Cliente</label>
                            <input class="form-control" type="text" name="id_client" required
                                placeholder="Cliente">
                        </div>
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Razon Social</label>
                            <input class="form-control" type="text" name="razon_social" required
                                placeholder="Ingrese su razon Social">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">RUC</label>
                            <input class="form-control" type="number" name="ruc" required
                                placeholder="Ingrese el RUC">
                        </div>
                        <div class="mb-3">
                            <label for="rol" class="form-label">Direccion</label>
                            <input class="form-control" type="text" name="direccion" required
                                placeholder="Ingrese la direccion">
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div> <!-- content -->
@endsection
