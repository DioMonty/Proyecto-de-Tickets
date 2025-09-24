@extends('admin.layouts.master')

@section('title', 'Sociedades | Rensar Consulting')

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
                                <li class="breadcrumb-item active" aria-current="page">Sociedades</li>
                            </ol>
                        </nav>
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

        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-stat">
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal"
                    data-bs-target="#agregar-modal">
                    <i class="mdi mdi-account-multiple-plus-outline me-1"></i> Agregar Sociedad
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
                    <th class="all">#</th>
                    <th>Cliente</th>
                    <th>Sociedad</th>
                    <th>Razon Social</th>
                    <th>RUC</th>
                    <th>Direccion</th>
                    <th></th>
                    <th>Activo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sociedades as $sociedad)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $sociedad->cliente->descripcion}}</td>
                    <td>{{ $sociedad->nombre_sociedad }}</td>
                    <td>{{ $sociedad->razon_social }}</td>
                    <td>{{ $sociedad->ruc }}</td>
                    <td>{{ $sociedad->direccion }}</td>
                    <td class="table-action">
                        <a type="button" class="action-icon" data-bs-toggle="modal"
                            data-bs-target="#editar-modal-{{ $sociedad->id }}">
                            <i class="mdi mdi-pencil" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Editar"></i>
                        </a>
                        <a href="javascript: void(0);" class="action-icon" data-bs-toggle="modal"
                            data-bs-target="#detalle-modal-{{ $sociedad->id }}">
                            <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Detalle"></i>
                        </a>
                    </td>
                    <td class="table-action">
                        <div class="form-check form-switch d-flex ">
                            <input type="checkbox"
                                class="form-check-input cambiar-estado"
                                data-id="{{ $sociedad->id }}"
                                id="switch03-{{ $sociedad->id }}"
                                {{ $sociedad->estado ? 'checked' : '' }}>
                            <label for="switch03-{{ $sociedad->id }}" class="switch-label mb-0 ms-2">
                                {{ $sociedad->estado ? 'Sí' : 'No' }}
                            </label>
                        </div>
                    </td>
                </tr>
                <!-- Modal editar usuario -->
                <div id="editar-modal-{{ $sociedad->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title">Editar Sociedad</h4>
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
                                        <label for="project-overview" class="form-label">Cliente</label>

                                        <select class="form-control" id="cliente" name="id_cliente">
                                            <option value="">Seleccionar</option>
                                            @foreach ($clientes as $cliente)
                                                <option value="{{ $cliente->id }}" {{ $cliente->id == $sociedad->id_cliente ? 'selected' : '' }}>
                                                    {{ $cliente->descripcion }}
                                                </option>
                                            @endforeach
                                        </select>

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
                <div id="detalle-modal-{{ $sociedad->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title">Detalle Sociedad</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body ps-3 pe-3">
                                <div class="mb-3">
                                    <label class="form-label">Sociedad</label>
                                    <input class="form-control" type="text" value="{{ $sociedad->nombre_sociedad }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Cliente</label>
                                    <input class="form-control" type="text" 
                                           value="{{ $sociedad->cliente->descripcion ?? 'N/A' }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Razón Social</label>
                                    <input class="form-control" type="text" value="{{ $sociedad->razon_social }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">RUC</label>
                                    <input class="form-control" type="text" value="{{ $sociedad->ruc }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Dirección</label>
                                    <input class="form-control" type="text" value="{{ $sociedad->direccion }}" readonly>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
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
                    <h4 class="modal-title">Agregar Sociedad</h4>
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
                            <label for="project-overview" class="form-label">Cliente</label>

                            <select class="form-control" name="id_cliente" id="cliente">
                                <option>Seleccionar</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->descripcion }}</option>
                                @endforeach
                            </select>
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
<script>
    $(document).ready(function () {
        $('.cambiar-estado').change(function () {
            var checkbox = $(this);
            var id = checkbox.data('id');
            var estado = checkbox.is(':checked');
            var label = checkbox.next('.switch-label');

            label.text(estado ? 'Sí' : 'No');

            $.ajax({
                url: '{{ url("admin/society/estado") }}/' + id,
                method: 'POST',
                data: {
                    estado: estado,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                error: function (xhr) {
                    alert('Error al actualizar el estado');
                    checkbox.prop('checked', !estado); // revertir
                    label.text(!estado ? 'Sí' : 'No');
                }
            });
        });
    });
</script>
@endsection
