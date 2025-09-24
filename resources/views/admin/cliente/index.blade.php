@extends('admin.layouts.master')

@section('title', 'Cliente | Rensar Consulting')

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
                            <li class="breadcrumb-item active" aria-current="page">Cliente</li>
                        </ol>
                    </nav>
                    </div>
                    <h4 class="page-title">Cliente</h4>
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregar-modal">
                        <i class="mdi mdi-account-multiple-plus-outline me-1"></i> Agregar Cliente
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
                    <th>Nombre</th>
                    <th>Razon Social</th>
                    <th>RUC</th>
                    <th>Correo</th>
                    <th></th>
                    <th></th>
                    <th>Activo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clientes as $cliente)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $cliente->descripcion }}</td>
                    <td>{{ $cliente->razon_social }}</td>
                    <td>{{ $cliente->ruc }}</td>
                    <td>{{ $cliente->email }}</td>
                    <td>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modulo-modal-{{ $cliente->id }}">
                            Asignar Módulo
                        </button>
                    </td>
                    <td class="table-action">
                        <a type="button" class="action-icon" data-bs-toggle="modal"
                            data-bs-target="#editar-modal-{{ $cliente->id }}">
                            <i class="mdi mdi-pencil" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Editar"></i>
                        </a>
                        <a href="javascript: void(0);" class="action-icon" data-bs-toggle="modal"
                            data-bs-target="#detalle-modal-{{ $cliente->id }}">
                            <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Detalle"></i>
                        </a>
                    </td>
                    <td class="table-action">
                        <div class="form-check form-switch d-flex ">
                            <input type="checkbox"
                                class="form-check-input cambiar-estado"
                                data-id="{{ $cliente->id }}"
                                id="switch03-{{ $cliente->id }}"
                                {{ $cliente->estado ? 'checked' : '' }}>
                            <label for="switch03-{{ $cliente->id }}" class="switch-label mb-0 ms-2">
                                {{ $cliente->estado ? 'Sí' : 'No' }}
                            </label>
                        </div>
                    </td>
                </tr>
                {{-- @stack('scripts') --}}
                <div id="modulo-modal-{{ $cliente->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <form action="{{ route('admin.cliente.modulo.store', $cliente->id) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Asignar Costo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row fw-bold mb-2">
                                        <div class="col-3">Módulo</div>
                                        <div class="col-3">Soporte</div>
                                        <div class="col-3">Proyecto</div>
                                        <div class="col-3">Bolsa de Hora</div>
                                    </div>

                                    @foreach($modulos as $modulo)
                                    @php
                                    $moduloSeleccionado = $cliente->modulos->firstWhere('id_modulo', $modulo->id);
                                    $checked = $moduloSeleccionado && $moduloSeleccionado->estado;
                                    $disabledCheckbox = $moduloSeleccionado && !$moduloSeleccionado->estado;
                                    $mostrarValor = $moduloSeleccionado != null;
                                    @endphp

                                    <div class="row align-items-center mb-2">
                                        {{-- Checkbox + label --}}
                                        <div class="col-3">
                                            <div class="form-check">
                                                <input class="form-check-input modulo-checkbox"
                                                    type="checkbox"
                                                    name="modulos[]"
                                                    id="modulo_{{ $cliente->id }}_{{ $modulo->id }}"
                                                    value="{{ $modulo->id }}"
                                                    {{ $checked ? 'checked' : '' }}>

                                                <label class="form-check-label" for="modulo_{{ $cliente->id }}_{{ $modulo->id }}">
                                                    {{ $modulo->abre_modulo }} - {{ $modulo->desc_modulo }}
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Costo funcional --}}
                                        <div class="col-3">
                                            <input type="number"
                                                class="form-control form-control-sm costo-soporte"
                                                name="costo_soporte[{{ $modulo->id }}]"
                                                placeholder="0.00"
                                                step="0.01"
                                                style="width: 100%;"
                                                value="{{ $mostrarValor ? $moduloSeleccionado->costo_soporte : '' }}"
                                                {{ $checked ? '' : 'disabled' }}>
                                        </div>

                                        {{-- Costo cliente --}}
                                        <div class="col-3">
                                            <input type="number"
                                                class="form-control form-control-sm costo-proyecto"
                                                name="costo_proyecto[{{ $modulo->id }}]"
                                                placeholder="0.00"
                                                step="0.01"
                                                style="width: 100%;"
                                                value="{{ $mostrarValor ? $moduloSeleccionado->costo_proyecto : '' }}"
                                                {{ $checked ? '' : 'disabled' }}>
                                        </div>

                                        {{-- Costo cliente --}}
                                        <div class="col-3">
                                            <input type="number"
                                                class="form-control form-control-sm costo-bolsa-hora"
                                                name="costo_bolsa_hora[{{ $modulo->id }}]"
                                                placeholder="0.00"
                                                step="0.01"
                                                style="width: 100%;"
                                                value="{{ $mostrarValor ? $moduloSeleccionado->costo_bolsa_hora : '' }}"
                                                {{ $checked ? '' : 'disabled' }}>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- @push('scripts') --}}
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const checkboxes = document.querySelectorAll('.modulo-checkbox');

                        checkboxes.forEach(function(checkbox) {
                            checkbox.addEventListener('change', function() {
                                const row = checkbox.closest('.row');
                                const costoSoporte = row.querySelector('.costo-soporte');
                                const costoProyecto = row.querySelector('.costo-proyecto');
                                const costoBolsaHora = row.querySelector('.costo-bolsa-hora');

                                if (checkbox.checked) {
                                    costoSoporte.removeAttribute('disabled');
                                    costoProyecto.removeAttribute('disabled');
                                    costoBolsaHora.removeAttribute('disabled');
                                } else {
                                    costoSoporte.setAttribute('disabled', true);
                                    costoProyecto.setAttribute('disabled', true);
                                    costoBolsaHora.setAttribute('disabled', true);
                                }
                            });
                        });
                    });
                </script>
                {{-- @endpush --}}

                <!-- Modal editar usuario -->
                <div id="editar-modal-{{ $cliente->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title">Editar Sociedad</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="ps-3 pe-3" action="{{ route('admin.cliente.update', $cliente->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Cliente</label>
                                        <input class="form-control" type="text" name="descripcion" value="{{ $cliente->descripcion }}" required
                                            placeholder="Sociedad">
                                    </div>
                                    <div class="mb-3">
                                        <label for="emailaddress" class="form-label">Razon Social</label>
                                        <input class="form-control" type="text" name="razon_social" value="{{ $cliente->razon_social }}" 
                                            placeholder="Ingrese su razon Social">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">RUC</label>
                                        <input class="form-control" type="number" name="ruc" value="{{ $cliente->ruc }}"
                                            placeholder="Ingrese el RUC">
                                    </div>
                                    <div class="mb-3">
                                        <label for="rol" class="form-label">Direccion</label>
                                        <input class="form-control" type="text" name="direccion" value="{{ $cliente->direccion }}"
                                            placeholder="Ingrese la direccion">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email-add" class="form-label">Correo Electrónico</label>
                                        <input class="form-control" type="email" name="email" value="{{ $cliente->email }}"
                                            placeholder="john@deo.com">
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
                <!-- Modal detalle cliente -->
<div id="detalle-modal-{{ $cliente->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title">Detalle del Cliente</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="ps-3 pe-3">

                    <div class="mb-3">
                        <label class="form-label">Cliente</label>
                        <input type="text" class="form-control bg-light border-0" value="{{ $cliente->descripcion }}" readonly tabindex="-1">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Razón Social</label>
                        <input type="text" class="form-control bg-light border-0" value="{{ $cliente->razon_social }}" readonly tabindex="-1">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">RUC</label>
                        <input type="text" class="form-control bg-light border-0" value="{{ $cliente->ruc }}" readonly tabindex="-1">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dirección</label>
                        <input type="text" class="form-control bg-light border-0" value="{{ $cliente->direccion }}" readonly tabindex="-1">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="text" class="form-control bg-light border-0" value="{{ $cliente->email }}" readonly tabindex="-1">
                    </div>

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
                    <h4 class="modal-title">Agregar Cliente</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ps-3 pe-3" action="{{ route('admin.cliente.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Cliente</label>
                            <input class="form-control" type="text" name="descripcion" required
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
                        <div class="mb-3">
                            <label for="email-add" class="form-label">Correo Electrónico</label>
                            <input class="form-control" type="email" name="email" required
                                placeholder="john@deo.com">
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
                url: '{{ url("admin/cliente/estado") }}/' + id,
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
