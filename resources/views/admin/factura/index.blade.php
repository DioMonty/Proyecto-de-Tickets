@extends('admin.layouts.master')

@section('title', 'Tickets por Facturar | Rensar Consulting')

@section('content')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-xxl-12">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#"><i class="uil-home-alt"></i> Reporte </a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Tickets Por Facturar</li>
                                    </ol>
                                </nav>
                            </div>
                            <h4 class="page-title">Tickets por Facturar
                                <button id="btn-facturar" type="button" class="btn btn-success btn-sm ms-3" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#facturar-modal"
                                    disabled>
                                    <i class="mdi mdi-alarm-panel me-1"></i> Facturar
                                </button>
                                <button id="exportBtn"type="button" class="btn btn-warning btn-sm ms-1" >
                                    <i class="mdi mdi-cloud-print me-1"></i> Exportar
                                </button>
                            </h4>

                            <p class="text-muted" style="margin-top: 5px;">
                                Generar una factura para los tickets seleccionados permite formalizar la
                                transacción realizada.
                            </p>
                        </div>
                        <!-- PANEL Y FILTROS -->
                    <div class="card p-3 shadow-sm rounded">
                        <form method="GET" action="{{ route('admin.factura.ticket') }}">
                            <div class="mb-3">
                                <h5 class="mb-3 text-dark">Filtros de Búsqueda</h5>
                                <div class="row gy-2 gx-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Cliente <span class="text-danger">*</span></label>
                                        <select id="filtro-cliente" name="cliente" class="form-select form-select-sm" required>
                                            <option value="">Seleccione...</option>
                                            <option value="all" {{ request('cliente') == 'all' ? 'selected' : '' }}>Todo</option>
                                            @foreach($clientes as $cliente)
                                                <option value="{{ $cliente->id }}" {{ request('cliente') == $cliente->id ? 'selected' : '' }}>
                                                    {{ $cliente->descripcion }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Código</label>
                                        <input type="text" id="filtro-codigo" name="codigo" value="{{ request('codigo') }}"
                                            class="form-control form-control-sm" placeholder="Ej: RSR-2025-0020" />
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary btn-sm w-100">
                                            <i class="mdi mdi-filter"></i> Filtrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
                <!-- end page title -->
                <!-- Orden de Compra -->
                <div class="mt-4">
                    <h5 class="m-0 pb-2">
                        <a class="text-dark" data-bs-toggle="collapse" href="#OCTasks" role="button"
                            aria-expanded="false" aria-controls="OCTasks">
                            <i class='uil uil-angle-down font-18'></i>Orden de Compra <span
                                class="text-muted">({{ $ordenCompra->count() }})</span>
                        </a>
                    </h5>

                    <div class="collapse show" id="OCTasks">
                        <div class="card mb-0">
                            <div class="card-body">
                                <!-- task -->
                                <table id="basic-datatable-one" class="table dt-responsive nowrap w-100"
                                    style=" font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>#<div class="resizer"></div>
                                            </th>
                                            <th>Check<div class="resizer"></div>
                                            </th>
                                            <th>C.Requerimiento <div class="resizer"></div>
                                            </th>
                                            <th>Título <div class="resizer"></div>
                                            </th>
                                            <th>N° OC<div class="resizer"></div>
                                            </th>
                                            <th>Sociedad <div class="resizer"></div>
                                            </th>
                                            <th>Fecha PRD <div class="resizer"></div>
                                            </th>
                                            <th>Fecha Terminado <div class="resizer"></div>
                                            </th>
                                            <th>Costo Total <div class="resizer"></div>
                                            </th>
                                            <th>Acción <div class="resizer"></div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($ordenCompra as $a)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" data-id="{{ $a->id }}"
                                                        data-ocbolsa="{{ $a->tipo_ticket === 'OC' || $a->tipo_ticket === 'Bolsa' ? 'true' : 'false' }}">
                                                </div>
                                            </td>
                                            <td>{{ $a->cod_ticket }}</td>
                                            <td>{{ $a->nombre_ticket}}</td>
                                            <td>{{ $a->oc_bolsa ?? null}}</td>
                                            <td>{{ $a->sociedad->nombre_sociedad}}</td>
                                            <td>{{ $a->fecha_prd ?? null }}</td>
                                            <td>{{ $a->fecha_resolucion ?? null}}</td>
                                            <td>{{ $a->costo_total ?? null }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('admin.ticket.show', Crypt::encrypt($a->id)) }}" class="action-icon" target="_blank" rel="noopener">
                                                    <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                                                        title="Detalle"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="action-icon"
                                                    data-bs-toggle="modal" data-bs-target="#hes-modal-{{ $a->id }}">
                                                    <i class="mdi mdi-pencil" data-bs-toggle="tooltip" data-bs-placement="left" title="Hes"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Modal HES-->
                                        <div id="hes-modal-{{ $a->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header text-center">
                                                        <h4 class="modal-title" style="color: black;">Hoja de Entrada de Servicios</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="ps-3 pe-3" action="{{ route('admin.num_hes.ticket.update', $a->id) }}" method="POST" >
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="username" class="form-label">N° Hes</label>
                                                                <input class="form-control" type="text" id="num_hes" name="num_hes" value="{{ $a->num_hes}}" required
                                                                    placeholder="N° Hes">
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
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>

                                <!-- end task -->
                            </div> <!-- end card-body-->
                        </div> <!-- end card -->
                    </div> <!-- end .collapse-->
                </div> <!-- end .mt-2-->
                <!-- Bolsa -->
                <div class="mt-4">
                    <h5 class="m-0 pb-2">
                        <a class="text-dark" data-bs-toggle="collapse" href="#bolsaTasks" role="button"
                            aria-expanded="false" aria-controls="bolsaTasks">
                            <i class='uil uil-angle-down font-18'></i>Bolsa <span
                                class="text-muted">({{ $bolsa->count() }})</span>
                        </a>
                    </h5>

                    <div class="collapse show" id="bolsaTasks">
                        <div class="card mb-0">
                            <div class="card-body">
                                <!-- task -->
                                <table id="basic-datatable-two" class="table dt-responsive nowrap w-100"
                                    style=" font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>#<div class="resizer"></div>
                                            </th>
                                            <th>Check<div class="resizer"></div>
                                            </th>
                                            <th>C.Requerimiento <div class="resizer"></div>
                                            </th>
                                            <th>Título <div class="resizer"></div>
                                            </th>
                                            <th>N° OC<div class="resizer"></div>
                                            </th>
                                            <th>Sociedad <div class="resizer"></div>
                                            </th>
                                            <th>Fecha PRD <div class="resizer"></div>
                                            </th>
                                            <th>Fecha Terminado <div class="resizer"></div>
                                            </th>
                                            <th>Costo Total <div class="resizer"></div>
                                            </th>
                                            <th>Acción <div class="resizer"></div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($bolsa as $b)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" data-id="{{ $b->id }}"
                                                        data-ocbolsa="{{ $b->tipo_ticket === 'OC' || $b->tipo_ticket === 'Bolsa' ? 'true' : 'false' }}">
                                                </div>
                                            </td>
                                            <td>{{ $b->cod_ticket }}</td>
                                            <td>{{ $b->nombre_ticket}}</td>
                                            <td>{{ $b->oc_bolsa ?? null}}</td>
                                            <td>{{ $b->sociedad->nombre_sociedad}}</td>
                                            <td>{{ $b->fecha_prd ?? null }}</td>
                                            <td>{{ $b->fecha_resolucion ?? null}}</td>
                                            <td>{{ $b->costo_total ?? null }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('admin.ticket.show', Crypt::encrypt($b->id)) }}" class="action-icon" target="_blank" rel="noopener">
                                                    <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                                                        title="Detalle"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="action-icon"
                                                    data-bs-toggle="modal" data-bs-target="#hes-modal-{{ $b->id }}">
                                                    <i class="mdi mdi-pencil" data-bs-toggle="tooltip" data-bs-placement="left" title="Hes"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Modal HES-->
                                        <div id="hes-modal-{{ $b->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header text-center">
                                                        <h4 class="modal-title" style="color: black;">Hoja de Entrada de Servicios</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="ps-3 pe-3" action="{{ route('admin.num_hes.ticket.update', $b->id) }}" method="POST" >
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="username" class="form-label">N° Hes</label>
                                                                <input class="form-control" type="text" id="num_hes" name="num_hes" value="{{ $b->num_hes}}" required
                                                                    placeholder="N° Hes">
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
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>

                                <!-- end task -->
                            </div> <!-- end card-body-->
                        </div> <!-- end card -->
                    </div> <!-- end .collapse-->
                </div> <!-- end .mt-2-->

                <!-- Sin OC -->
                <div class="mt-4">
                    <div class="mt-4 d-flex align-items-center mb-2">
                        <h5 class="m-0 pb-2 me-3">
                            <a class="text-dark" data-bs-toggle="collapse" href="#sinOCTasks" role="button"
                                aria-expanded="false" aria-controls="sinOCTasks">
                                <i class='uil uil-angle-down font-18'></i>Sin OC 
                                <span class="text-muted">({{ $sinOC->count() }})</span>
                            </a>
                        </h5>

                        <!-- Botón para abrir modal -->
                        <button id="btn-asignar-ocbolsa" class="btn btn-primary btn-sm" 
                                data-bs-toggle="modal" data-bs-target="#asignarOCBolsaModal" disabled>
                            Asignar OCBolsa
                        </button>
                    </div>

                    <div class="collapse show" id="sinOCTasks">
                        <div class="card mb-0">
                            <div class="card-body">
                                <!-- task -->
                                <table id="basic-datatable-three" class="table dt-responsive nowrap w-100"
                                    style=" font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>#<div class="resizer"></div>
                                            </th>
                                            <th>Check<div class="resizer"></div>
                                            </th>
                                            <th>C.Requerimiento <div class="resizer"></div>
                                            </th>
                                            <th>Título <div class="resizer"></div>
                                            </th>
                                            <th>N° OC<div class="resizer"></div>
                                            </th>
                                            <th>Sociedad <div class="resizer"></div>
                                            </th>
                                            <th>Fecha PRD <div class="resizer"></div>
                                            </th>
                                            <th>Fecha Terminado <div class="resizer"></div>
                                            </th>
                                            <th>Costo Total <div class="resizer"></div>
                                            </th>
                                            <th>Acción <div class="resizer"></div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($sinOC as $c)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" data-id="{{ $c->id }}"
                                                        data-ocbolsa="{{ $c->tipo_ticket === 'OC' || $c->tipo_ticket === 'Bolsa' ? 'true' : 'false' }}">
                                                </div>
                                            </td>
                                            <td>{{ $c->cod_ticket }}</td>
                                            <td>{{ $c->nombre_ticket}}</td>
                                            <td>{{ $c->oc_bolsa ?? null}}</td>
                                            <td>{{ $c->sociedad->nombre_sociedad}}</td>
                                            <td>{{ $c->fecha_prd ?? null }}</td>
                                            <td>{{ $c->fecha_resolucion ?? null}}</td>
                                            <td>{{ $c->costo_total ?? null }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('admin.ticket.show', Crypt::encrypt($c->id)) }}" class="action-icon" target="_blank" rel="noopener">
                                                    <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                                                        title="Detalle"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="action-icon"
                                                    data-bs-toggle="modal" data-bs-target="#hes-modal-{{ $c->id }}">
                                                    <i class="mdi mdi-pencil" data-bs-toggle="tooltip" data-bs-placement="left" title="Hes"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Modal HES-->
                                        <div id="hes-modal-{{ $c->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header text-center">
                                                        <h4 class="modal-title" style="color: black;">Hoja de Entrada de Servicios</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="ps-3 pe-3" action="{{ route('admin.num_hes.ticket.update', $c->id) }}" method="POST" >
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="username" class="form-label">N° Hes</label>
                                                                <input class="form-control" type="text" id="num_hes" name="num_hes" value="{{ $c->num_hes}}" required
                                                                    placeholder="N° Hes">
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
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>

                                <!-- end task -->
                            </div> <!-- end card-body-->
                        </div> <!-- end card -->
                    </div> <!-- end .collapse-->
                </div> <!-- end .mt-2-->

            </div> <!-- end col -->
        </div>
        <!-- end row-->

    </div> <!-- container -->
    <!-- Modal editar usuario -->
    <div id="facturar-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title" style="color: black;">Facturar</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ps-3 pe-3" action="{{ route('admin.facturar.ticket.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="ids_tickets" id="idTicketsSelec">
                        <div class="mb-3">
                            <label for="username" class="form-label">Factura Referencia</label>
                            <input class="form-control" type="text" id="num_factura" name='num_factura' required
                                placeholder="Factura Referencia">
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Fecha de Facturación </label>
                            <input class="form-control" type="date" id="date_factura" name="date_factura" required
                                placeholder="Usuario">
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-warning">Facturar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Asignar OC/Bolsa -->
    <div class="modal fade" id="asignarOCBolsaModal" tabindex="-1" aria-labelledby="asignarOCBolsaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="asignarOCBolsaModalLabel">Asignar OC/Bolsa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <form class="ps-3 pe-3" action="{{ route('admin.oc_bolsa.asing.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="tickets_ids" id="ticketsSeleccionados">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tipoAsignacion" class="form-label">Seleccione tipo:</label>
                            <select id="tipoAsignacion" name="tipo" class="form-select" required>
                                <option value="">-- Seleccionar --</option>
                                <option value="OC">OC</option>
                                <option value="Bolsa">Bolsa</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="num_ocbolsa" class="form-label">Número de OC Bolsa</label>
                            <input class="form-control" type="text" required id="num_ocbolsa" name="num_oc_bolsa_cam"
                                placeholder="N° 123456789" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div> <!-- content -->

{{-- <script>
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
</script> --}}
<script>
    $(document).ready(function () {
        "use strict";

        // Tabla 1
        $("#basic-datatable-one").DataTable({
            keys: !0,
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>",
                },
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        });

        // Tabla 2
        $("#basic-datatable-two").DataTable({
            keys: !0,
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>",
                },
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        });

        // Tabla 3 (Sin OC)
        $("#basic-datatable-three").DataTable({
            keys: !0,
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>",
                },
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        });

        // Tabla con botones
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
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        });

        // Tabla con selección múltiple
        $("#selection-datatable").DataTable({
            select: { style: "multi" },
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>",
                },
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        });

        a.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");

        // Varias configuraciones de tablas
        $("#alternative-page-datatable").DataTable({
            pagingType: "full_numbers",
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        });

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
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        });

        $("#scroll-horizontal-datatable").DataTable({
            scrollX: !0,
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>",
                },
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        });

        $("#complex-header-datatable").DataTable({
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>",
                },
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
            columnDefs: [{ visible: !1, targets: -1 }],
        });

        $("#row-callback-datatable").DataTable({
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>",
                },
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
            createdRow: function (a, e, t) {
                15e4 < +e[5].replace(/[\$,]/g, "") && $("td", a).eq(5).addClass("text-danger");
            },
        });

        $("#state-saving-datatable").DataTable({
            stateSave: !0,
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>",
                },
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        });

        $("#fixed-columns-datatable").DataTable({
            scrollY: 300,
            scrollX: !0,
            scrollCollapse: !0,
            paging: !1,
            fixedColumns: !0,
        });

        $(".dataTables_length select").addClass("form-select form-select-sm");
        $(".dataTables_length label").addClass("form-label");
    });

    // Fixed Header
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
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
        });
        new $.fn.dataTable.FixedHeader(a);
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('#basic-datatable-three tbody .form-check-input');
        const btnAsignar = document.getElementById('btn-asignar-ocbolsa');
        const inputHidden = document.getElementById('ticketsSeleccionados');

        function actualizarBoton() {
            const seleccionados = Array.from(checkboxes)
                .filter(chk => chk.checked)
                .map(chk => chk.getAttribute('data-id'));

            btnAsignar.disabled = seleccionados.length === 0;

            // Guardar IDs seleccionados en el input hidden
            inputHidden.value = seleccionados.join(',');
        }

        checkboxes.forEach(chk => {
            chk.addEventListener('change', actualizarBoton);
        });

        // Cuando se envía el formulario del modal, aseguramos que los IDs estén actualizados
        document.querySelector('#asignarOCBolsaModal form').addEventListener('submit', function () {
            actualizarBoton();
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnFacturar = document.getElementById('btn-facturar');
        const inputHidden = document.getElementById('idTicketsSelec');

        // Selecciona todos los checkboxes de ambas tablas
        const checkboxes = document.querySelectorAll(
            '#basic-datatable-one tbody .form-check-input, #basic-datatable-two tbody .form-check-input'
        );

        function actualizarBoton() {
            const seleccionados = Array.from(checkboxes)
                .filter(chk => chk.checked)
                .map(chk => chk.getAttribute('data-id'));

            btnFacturar.disabled = seleccionados.length === 0;
            inputHidden.value = seleccionados.join(',');
        }

        checkboxes.forEach(chk => {
            chk.addEventListener('change', actualizarBoton);
        });

        // Por seguridad, antes de enviar formulario actualizamos el hidden
        document.querySelector('#facturar-modal form').addEventListener('submit', actualizarBoton);
    });
</script>

@endsection

<!-- Pasar datos desde Laravel a JS -->
<script>
    const ticketsOC = @json($ordenCompra ?? []);
    console.log("Tickets OC cargados:", ticketsOC.length);
    if (ticketsOC.length > 0) {
        console.log("Primer ticket completo:", ticketsOC[0]);
        console.log("cliente:", ticketsOC[0]?.cliente);
        console.log("sociedad:", ticketsOC[0]?.sociedad);
        console.log("modulo:", ticketsOC[0]?.modulo);
    }
</script>

<!-- Pasar los tickets pendientes a JS -->
<script>
    const ticketsPendientes = @json($baseTicket);
    console.log('Tickets pendientes cargados:', ticketsPendientes);
</script>

<!-- Librerías necesarias -->
<script src="https://cdn.jsdelivr.net/npm/exceljs/dist/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const exportBtn = document.getElementById('exportBtn');
    exportBtn.addEventListener('click', async () => {
        if(!ticketsPendientes || ticketsPendientes.length === 0){
            alert('No hay tickets pendientes para exportar.');
            return;
        }

        const ticketsArray = Object.values(ticketsPendientes);

        const workbook = new ExcelJS.Workbook();
        const sheet = workbook.addWorksheet('Tickets Pendientes');

        let currentRow = 1;

        // ===== Título =====
        sheet.mergeCells(`A${currentRow}:U${currentRow}`);
        const titleCell = sheet.getCell(`A${currentRow}`);
        titleCell.value = 'Tickets Terminados';
        titleCell.font = { size: 18, bold: true };
        titleCell.alignment = { horizontal: 'center', vertical: 'middle' };
        currentRow++;

        // ===== Fecha =====
        sheet.mergeCells(`A${currentRow}:U${currentRow}`);
        const dateCell = sheet.getCell(`A${currentRow}`);
        const now = new Date();
        dateCell.value = `Generado el: ${now.toLocaleDateString()} ${now.toLocaleTimeString()}`;
        dateCell.font = { italic: true };
        dateCell.alignment = { horizontal: 'center', vertical: 'middle' };
        currentRow++;


        // ===== Cabecera de la tabla =====
        const headers = [
            'Tipo Ticket','Cliente','Sociedad','Ticket','Descripción','Modulo','ABAP','Funcional','Fecha Inicio',
            'Pase a PRD','OC Bolsa','HES','Solicitante',
            'Horas ABAP','Costo ABAP','Cost. Total Abap', // nueva columna aquí
            'Horas Fun.','Costo Fun.','Cost. Tota. Fun',  // nueva columna aquí
            'Total Horas','Total Costo','Factura Referencia','Fecha de Facturaciones'
        ];
        const headerRow = sheet.addRow(headers);
        headerRow.eachCell(cell => {
            cell.font = { bold: true, color: { argb: 'FFFFFFFF' } };
            cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF000000' } };
            cell.alignment = { horizontal: 'center', vertical: 'middle', wrapText: true };
            cell.border = {
                top: { style: 'thin' },
                left: { style: 'thin' },
                bottom: { style: 'thin' },
                right: { style: 'thin' }
            };
        });

        // ===== Agregar datos =====
        ticketsArray.forEach(ticket => {
            const horasAbap = Number(ticket.hora_abap) || 0;
            const costoAbap = Number(ticket.costo_abap) || 0;
            const horasFun = Number(ticket.hora_funcional) || 0;
            const costoFun = Number(ticket.costo_funcional) || 0;
        
            const costoTotalAbap = horasAbap * costoAbap;
            const costoTotalFun = horasFun * costoFun;
        
            const row = sheet.addRow([
                ticket.tipo_ticket ?? '',        // Tipo de Ticket
                ticket.cliente?.razon_social ?? '',        // Cliente
                ticket.sociedad?.nombre_sociedad ?? '',    // Sociedad
                ticket.cod_ticket ?? '',                   // Ticket
                ticket.nombre_ticket ?? '',                // Descripción
                ticket.modulo?.abre_modulo ?? '',          // Módulo
                ticket.abap?.usuario?.name ?? '',          // ABAP
                ticket.funcional?.usuario?.name ?? '',     // Funcional
                ticket.fecha_inicio ?? '',                 // Fecha Inicio
                ticket.fecha_prd ?? '',                    // Pase a PRD
                ticket.oc_bolsa ?? '',                     // OC Bolsa
                ticket.num_hes ?? '',                      // HES
                ticket.solicitante ?? '',                  // Solicitante
                parseFloat(ticket.hora_abap) || 0,          // fuerza a número
                costoAbap,                                 // Costo ABAP
                costoTotalAbap,                            // Cost. Total Abap (nuevo)
                parseFloat(ticket.hora_funcional) || 0,     // fuerza a número
                costoFun,                                  // Costo Fun.
                costoTotalFun,                             // Cost. Tota. Fun (nuevo)
                parseFloat(ticket.total_horas) || 0,        // fuerza a número
                parseFloat(ticket.costo_total) || 0,        // Total Costo
                ticket.factura_id ?? '',                   // Factura Referencia
                ticket.factura?.fecha ?? ''                // Fecha de Facturación
            ]);

            // Bordes, alineación y formato personalizado
            // Estilo por fila (aplicar después de cargar todos los datos)
            sheet.eachRow((row, rowNumber) => {
              if (rowNumber === 1) return; // saltar cabecera
            
              row.eachCell((cell, colNumber) => {
            
                //  Alinear columnas 13 a 20 a la derecha
                if (colNumber >= 14 && colNumber <= 21) {
                  cell.alignment = { horizontal: "right" };
                }
            
                //  Formato de horas (columnas 14, 17, 20)
                if ([14, 17, 20].includes(colNumber)) {
                  cell.numFmt = '#,##0.00" hs";[Red]-#,##0.00" hs"';
                }
            
                // Formato de soles (costos)
                // Suponiendo que tus columnas de costos son: 
                if ([15, 16, 18, 19, 21].includes(colNumber)) {
                  cell.numFmt = '"S/." #,##0.00;[Red]"S/." -#,##0.00';
                }
            
              });
            });
        });

        // ===== Ancho de columnas automático =====
        sheet.columns.forEach(column => {
            let maxLength = 10;
            column.eachCell({ includeEmpty: true }, cell => {
                const value = cell.value ? cell.value.toString() : '';
                maxLength = Math.max(maxLength, value.length);
            });
            column.width = Math.min(maxLength + 2, 30);
        });

        // ===== Descargar archivo =====
        const buffer = await workbook.xlsx.writeBuffer();
        const blob = new Blob([buffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
        saveAs(blob, "Tickets terminados .xlsx");

        console.log('Archivo generado correctamente');
    });
});
</script>
