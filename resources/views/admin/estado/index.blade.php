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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Rensar Consuling</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Gestión de Usuarios</a></li>
                            <li class="breadcrumb-item active">Estados</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Estados</h4>
                    <p class="mt-2 mb-3 text-muted">
                        Permite visualizar y gestionar los diferentes Estados existentes en SAP.
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
                        <i class="mdi mdi-account-multiple-plus-outline me-1"></i> Crear Estado
                    </button>
                    <button type="button" class="btn btn-warning">
                        <i class="mdi mdi-cloud-print me-1"></i> Exportar
                    </button>
                </div>
            </div>
        </div>





        <!-- Tabla de usuarios -->
        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
            <thead>
                <tr>
                    <th>Nombre Estado</th>
                    <th>Descripcion</th>
                    <th>Detalle</th>
                    <th>Acciones</th>
                    <th>Activado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($estados as $estado)
                <tr>
                    <td>{{ $estado->abre_estado }}</td>
                    <td>{{ $estado->desc_estado }}</td>
                    <td>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detalle-estado-modal-{{ $estado->id }}">
                            <i class="mdi mdi-eye"></i> Ver Detalle
                        </button>
                    </td>
                    <td class="table-action">
                        <a href="#" class="action-icon" data-bs-toggle="modal" data-bs-target="#editar-modal-{{ $estado->id }}">
                            <i class="mdi mdi-pencil"></i>
                        </a>
                        <a href="javascript: void(0);" class="action-icon" data-bs-toggle="modal" data-bs-target="#warning-alert-modal-{{ $estado->id }}">
                            <i class="mdi mdi-delete"></i>
                        </a>
                    </td>
                    <td class="table-action">
                        <div>
                            <input type="checkbox" id="switch03" data-switch="success" />
                            <label for="switch03" data-on-label="Si" data-off-label="No" class="mb-0 d-block"></label>
                        </div>
                    </td>
                </tr>
                <!-- Modal de confirmación eliminar -->
                <div id="warning-alert-modal-{{ $estado->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-body p-4">
                                <div class="text-center">
                                    <i class="ri-alert-line h1 text-danger"></i>
                                    <h4 class="mt-2">¿Estás Seguro?</h4>
                                    <p class="mt-3">
                                        Esta acción resultará en la eliminación permanente de la información seleccionada.
                                        Una vez eliminada, no será posible recuperarla.
                                    </p>
                                    <form method="POST" action="{{ route('admin.estado.destroy', $estado->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger my-2">Confirmar</button>
                                        <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">Cancelar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal editar usuario -->
                <div id="editar-modal-{{ $estado->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title" style="color: black;">Editar Estado</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="ps-3 pe-3" action="{{ route('admin.estado.update', $estado->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="apellido" class="form-label">Nombre de Estado</label>
                                        <input class="form-control" type="text" name="abre_estado" required value="{{ $estado->abre_estado }}" placeholder="Nombre de Estado">
                                    </div>
                                    <div class="mb-3">
                                        <label for="emailaddress" class="form-label">Descripcion</label>
                                        <input class="form-control" type="text" name="desc_estado" required value="{{ $estado->desc_estado }}" placeholder="Descripcion">
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
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


    <!-- Modal detalle estado -->
    <div id="detalle-estado-modal-{{ $estado->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title" style="color: black;">Detalle de Estado</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="ps-3 pe-3">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre de Estado:</label>
                            <div class="border rounded px-3 py-2 bg-light">{{ $estado->abre_estado }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Descripción:</label>
                            <div class="border rounded px-3 py-2 bg-light">{{ $estado->desc_estado }}</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal agregar usuario -->
    <div id="agregar-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title" style="color: black;">Crear Estado</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ps-3 pe-3" action="{{ route('admin.estado.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Nombre de Estado</label>
                            <input class="form-control" type="text" name="abre_estado" required placeholder="Nombre de Estado">
                        </div>
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Descripcion</label>
                            <input class="form-control" type="text" name="desc_estado" required placeholder="Descripcion">
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div> <!-- content -->
@endsection