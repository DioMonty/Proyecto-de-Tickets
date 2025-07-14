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
                            <li class="breadcrumb-item active">Consultor</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Consultor</h4>
                    <p class="mt-2 mb-3 text-muted">
                        Permite visualizar y gestionar los diferentesconsultores ABAP y Funcionales
                    </p>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Botones: Nuevo Acceso a la izquierda, Exportar + Filtros a la derecha -->
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-stat">
                <div class="d-flex flex-wrap gap-2">
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
                    <th>Nombre Consultor</th>
                    <th>Celular</th>
                    <th>RUC</th>
                    <th>Banco</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($consultores as $consultor)
                <tr>
                    <td>{{ $consultor->usuario->name }}</td>
                    <td>{{ $consultor->telefono }}</td>
                    <td>{{ $consultor->ruc }}</td>
                    <td>{{ $consultor->banco }}</td>
                    <td>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tipo-consultor-modal-{{ $consultor->id }}">Tipo de Consultor</button>
                    </td>
                    <td>
                        @if($consultor->roles->contains('detalle', 'funcional'))
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modulo-modal-{{ $consultor->id }}">
                            Asignar Módulo
                        </button>
                        @else
                        <button type="button" class="btn btn-success" disabled>
                            Asignar Módulo
                        </button>
                        @endif
                    </td>

                    <td class="table-action">
                        <a href="#" class="action-icon" data-bs-toggle="modal"
                            data-bs-target="#editar-modal-{{ $consultor->id }}">
                            <i class="mdi mdi-pencil"></i>
                        </a>
                        <a href="javascript: void(0);" class="action-icon" data-bs-toggle="modal"
                            data-bs-target="#warning-alert-modal-{{ $consultor->id }}">
                            <i class="mdi mdi-delete"></i>
                        </a>
                        <a href="javascript: void(0);" class="action-icon" data-bs-toggle="modal"
                            data-bs-target="#detalle-modal-{{ $consultor->id }}">
                            <i class="mdi mdi-eye"></i>
                        </a>
                    </td>
                </tr>
                @stack('scripts')
                <div id="modulo-modal-{{ $consultor->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.consultor.modulo.store', $consultor->id) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Seleccionar Tipo de Consultor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row fw-bold mb-2">
                                        <div class="col-4">Módulo</div>
                                        <div class="col-4">Costo Funcional</div>
                                        <div class="col-4">Costo Cliente</div>
                                    </div>

                                    @foreach($modulos as $modulo)
                                    @php
                                    $moduloSeleccionado = $consultor->modulos->firstWhere('id_modulo', $modulo->id);
                                    $checked = $moduloSeleccionado && $moduloSeleccionado->estado;
                                    $disabledCheckbox = $moduloSeleccionado && !$moduloSeleccionado->estado;
                                    $mostrarValor = $moduloSeleccionado != null;
                                    @endphp

                                    <div class="row align-items-center mb-2">
                                        {{-- Checkbox + label --}}
                                        <div class="col-4">
                                            <div class="form-check">
                                                <input class="form-check-input modulo-checkbox"
                                                    type="checkbox"
                                                    name="modulos[]"
                                                    id="modulo_{{ $consultor->id }}_{{ $modulo->id }}"
                                                    value="{{ $modulo->id }}"
                                                    {{ $checked ? 'checked' : '' }}>

                                                <label class="form-check-label" for="modulo_{{ $consultor->id }}_{{ $modulo->id }}">
                                                    {{ $modulo->abre_modulo }} - {{ $modulo->desc_modulo }}
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Costo funcional --}}
                                        <div class="col-4">
                                            <input type="number"
                                                class="form-control form-control-sm costo-funcional"
                                                name="costo_funcional[{{ $modulo->id }}]"
                                                placeholder="0.00"
                                                step="0.01"
                                                style="width: 100%;"
                                                value="{{ $mostrarValor ? $moduloSeleccionado->costo_funcional : '' }}"
                                                {{ $checked ? '' : 'disabled' }}>
                                        </div>

                                        {{-- Costo cliente --}}
                                        <div class="col-4">
                                            <input type="number"
                                                class="form-control form-control-sm costo-cliente"
                                                name="costo_cliente[{{ $modulo->id }}]"
                                                placeholder="0.00"
                                                step="0.01"
                                                style="width: 100%;"
                                                value="{{ $mostrarValor ? $moduloSeleccionado->costo_cliente : '' }}"
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

                @push('scripts')
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const checkboxes = document.querySelectorAll('.modulo-checkbox');

                        checkboxes.forEach(function(checkbox) {
                            checkbox.addEventListener('change', function() {
                                const row = checkbox.closest('.row');
                                const costoFuncional = row.querySelector('.costo-funcional');
                                const costoCliente = row.querySelector('.costo-cliente');

                                if (checkbox.checked) {
                                    costoFuncional.removeAttribute('disabled');
                                    costoCliente.removeAttribute('disabled');
                                } else {
                                    costoFuncional.setAttribute('disabled', true);
                                    costoCliente.setAttribute('disabled', true);
                                }
                            });
                        });
                    });
                </script>
                @endpush


                <!-- Modal de confirmación eliminar -->
                <div id="warning-alert-modal-{{ $consultor->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                                    <form method="POST" action="{{ route('admin.consultor.destroy', $consultor->id) }}">
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
                <div id="editar-modal-{{ $consultor->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg"> <!-- Hacemos el modal más ancho -->
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title" style="color: black;">Editar Consultor</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="ps-3 pe-3" action="{{ route('admin.consultor.update', $consultor->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label for="id_asignacion" class="form-label">Consultor</label>
                                            <input class="form-control" type="text" name="id_usuario" value="{{ $consultor->usuario->name }}" readonly
                                                placeholder="Id Consultor">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="celular" class="form-label">Celular</label>
                                            <input class="form-control" type="text" name="telefono" value="{{ $consultor->telefono }}"
                                                placeholder="Celular">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="ruc" class="form-label">RUC</label>
                                            <input class="form-control" type="text" name="ruc" value="{{ $consultor->ruc }}"
                                                placeholder="RUC">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="banco" class="form-label">Banco</label>
                                            <input class="form-control" type="text" name="banco" value="{{ $consultor->banco }}"
                                                placeholder="Banco">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="cta_banco" class="form-label">Cta Banco</label>
                                            <input class="form-control" type="text" name="cta_banco" value="{{ $consultor->cta_banco }}"
                                                placeholder="Cta Banco">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="cta_cci" class="form-label">Cta. Banco CCI</label>
                                            <input class="form-control" type="text" name="cta_cci" value="{{ $consultor->cta_cci }}"
                                                placeholder="Cta. Banco CCI">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="cta_detracciones" class="form-label">Cta. Detracciones</label>
                                            <input class="form-control" type="text" name="cta_detraccion" value="{{ $consultor->cta_detraccion }}"
                                                placeholder="Cta. Detracciones">
                                        </div>
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

                <div id="detalle-modal-{{ $consultor->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title" style="color: black;">Detalle del Consultor</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row ps-3 pe-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Consultor</label>
                                        <div class="border rounded px-3 py-2 bg-light">{{ $consultor->usuario->name }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Celular</label>
                                        <div class="border rounded px-3 py-2 bg-light">{{ $consultor->telefono }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">RUC</label>
                                        <div class="border rounded px-3 py-2 bg-light">{{ $consultor->ruc }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Banco</label>
                                        <div class="border rounded px-3 py-2 bg-light">{{ $consultor->banco }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Cta Banco</label>
                                        <div class="border rounded px-3 py-2 bg-light">{{ $consultor->cta_banco }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Cta. Banco CCI</label>
                                        <div class="border rounded px-3 py-2 bg-light">{{ $consultor->cta_cci }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Cta. Detracciones</label>
                                        <div class="border rounded px-3 py-2 bg-light">{{ $consultor->cta_detraccion }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Tipo de Consultor -->
                <div id="tipo-consultor-modal-{{ $consultor->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.consultor.rol.store', $consultor->id) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Seleccionar Tipo de Consultor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="tipo_abap" id="tipo_abap_{{ $consultor->id }}" value="1"
                                            {{ $consultor->roles->contains('detalle', 'abap') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="tipo_abap_{{ $consultor->id }}">
                                            ABAP
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="tipo_funcional" id="tipo_funcional_{{ $consultor->id }}" value="1"
                                            {{ $consultor->roles->contains('detalle', 'funcional') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="tipo_funcional_{{ $consultor->id }}">
                                            Funcional
                                        </label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    document.querySelectorAll('button.btn-success:contains("Tipo de Consultor")').forEach(function(btn, idx) {
                        btn.addEventListener('click', function() {
                            var id = btn.closest('tr').querySelector('a[data-bs-target^="#editar-modal-"]').getAttribute('data-bs-target').replace('#editar-modal-', '');
                            var modal = document.getElementById('tipo-consultor-modal-' + id);
                            var bsModal = new bootstrap.Modal(modal);
                            bsModal.show();
                        });
                    });
                </script>

                @empty
                @endforelse
            </tbody>
        </table>
    </div> <!-- container -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const consultSelect = document.getElementById('id_consultor');
            const telefonoInput = document.getElementById('telefono');

            consultSelect.addEventListener('change', function() {
                const selectedOption = consultSelect.options[consultSelect.selectedIndex];
                const phone = selectedOption.getAttribute('data-phone');
                telefonoInput.value = phone || '';
            });
        });
    </script>
    @endsection