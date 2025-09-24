@extends('admin.layouts.master')

@section('title', 'Tickets Facturados | Rensar Consulting')

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
                                    <li class="breadcrumb-item"><a href="#"><i class="uil-home-alt"></i> Reporte</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Tickets Facturados</li>
                                </ol>
                            </nav>
                            </div>
                            <h4 class="page-title">Tickets Facturados</h4>
                            <p class="mt-2 mb-3 text-muted">
                                Una bandeja de tickets facturados es el espacio donde se visualizan los tickets que ya han sido procesados y cuentan con su comprobante de pago emitido.
                            </p>
                        </div>
                    </div>
                </div>
                        <!-- PANEL Y FILTROS -->
                        <div class="card p-3 shadow-sm rounded">
    <form method="GET" action="{{ route('admin.ticket.facturado') }}">
        <div class="mb-3">
            <h5 class="mb-3 text-dark">Filtros de Búsqueda</h5>
            <div class="row gy-2 gx-3 align-items-end">
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

                <div class="col-md-2">
                    <label class="form-label">Código</label>
                    <input type="text" id="filtro-codigo" name="codigo" value="{{ request('codigo') }}"
                        class="form-control form-control-sm" placeholder="Ej: RSR-2025-0020" />
                </div>

                <div class="col-md-2">
                    <label class="form-label">Desde</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio"
                        value="{{ request('fecha_inicio') }}"
                        class="form-control form-control-sm" />
                </div>

                <div class="col-md-2">
                    <label class="form-label">Hasta</label>
                    <input type="date" id="fecha_fin" name="fecha_fin"
                        value="{{ request('fecha_fin') }}"
                        class="form-control form-control-sm" />
                </div>

                <div class="col-md-3 d-flex">
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
                                            <th>C.Requerimiento <div class="resizer"></div>
                                            </th>
                                            <th>Título <div class="resizer"></div>
                                            </th>
                                            <th>N° Factura <div class="resizer"></div>
                                            </th>
                                            <th>Abap <div class="resizer"></div>
                                            </th>
                                            <th>Funcional <div class="resizer"></div>
                                            </th>
                                            <th>Fecha Factura <div class="resizer"></div>
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
                                            <td>{{ $a->cod_ticket }}</td>
                                            <td>{{ $a->nombre_ticket }}</td>
                                            <td>{{ $a->factura?->numero_factura ?? null }}</td>
                                            <td>{{ $a->abap?->usuario?->name ?? null }}</td>
                                            <td>{{ $a->funcional?->usuario?->name ?? null }}</td>
                                            <td>{{ $a->factura->fecha_factura }}</td>
                                            <td>{{ $a->costo_total ?? null }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('admin.ticket.facturado.show', Crypt::encrypt($a->id)) }}" class="action-icon" target="_blank" rel="noopener">
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
                                            <th>C.Requerimiento <div class="resizer"></div>
                                            </th>
                                            <th>Título <div class="resizer"></div>
                                            </th>
                                            <th>N° Factura <div class="resizer"></div>
                                            </th>
                                            <th>Abap <div class="resizer"></div>
                                            </th>
                                            <th>Funcional <div class="resizer"></div>
                                            </th>
                                            <th>Fecha Factura <div class="resizer"></div>
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
                                            <td>{{ $b->cod_ticket }}</td>
                                            <td>{{ $b->nombre_ticket}}</td>
                                            <td>{{ $b->factura?->numero_factura ?? null}}</td>
                                            <td>{{ $b->abap?->usuario?->name ?? null }}</td>
                                            <td>{{ $b->funcional?->usuario?->name ?? null }}</td>
                                            <td>{{ $b->factura->fecha_factura }}</td>
                                            <td>{{ $b->costo_total ?? null }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('admin.ticket.facturado.show', Crypt::encrypt($b->id)) }}" class="action-icon" target="_blank" rel="noopener">
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
            </div> <!-- end col -->
        </div>
        <!-- end row-->
    </div> <!-- container -->
</div> <!-- content -->

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