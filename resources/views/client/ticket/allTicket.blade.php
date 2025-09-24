@extends('client.layouts.master')

@section('title', 'Tickets Terminados | Rensar Consulting')

@section('content')

@php
use Carbon\Carbon;
@endphp
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
                                        <li class="breadcrumb-item active" aria-current="page">Tickets Terminado</li>
                                    </ol>
                                </nav>
                                </div>
                                <h4 class="page-title">Tickets Terminado</h4>
                                <p class="mt-2 mb-3 text-muted">
                                    Una bandeja de estados es el espacio donde se visualizan los tickets organizados según su estado de atención.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- end page title -->

                <!-- ORDEN DE COMPRA -->
                <div class="mt-4">
                    <h5 class="m-0 pb-2">
                        <a class="text-dark" data-bs-toggle="collapse" href="#pendienteTasks" role="button"
                            aria-expanded="false" aria-controls="todayTasks">
                            <i class='uil uil-angle-down font-18'></i>Orden de Compra <span
                                class="text-muted">({{ $ordenCompra->count() }})</span>
                        </a>
                    </h5>

                    <div class="collapse show" id="pendienteTasks">
                        <div class="card mb-0">
                            <div class="card-body">
                                <!-- task -->
                                <table id="basic-datatable-one" class="table dt-responsive nowrap w-100"
                                    style=" font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th># <div class="resizer"></div></th>
                                            <th>C.Requerimiento <div class="resizer"></div></th>
                                            <th>Título <div class="resizer"></div></th>
                                            <th>N° OC<div class="resizer"></div></th>
                                            <th>Sociedad <div class="resizer"></div></th>
                                            <th>Fecha PRD <div class="resizer"></div></th>
                                            <th>Fecha Terminado <div class="resizer"></div></th>
                                            <th>Costo Total <div class="resizer"></div></th>
                                            <th>Acción <div class="resizer"></div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($ordenCompra as $a)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $a->cod_ticket }}</td>
                                            <td>{{ $a->nombre_ticket}}</td>
                                            <td>{{ $a->oc_bolsa ?? null}}</td>
                                            <td>{{ $a->sociedad->nombre_sociedad}}</td>
                                            <td>{{ $a->fecha_prd ?? null }}</td>
                                            <td>{{ $a->fecha_resolucion ?? null}}</td>
                                            <td>{{ $a->costo_total ?? null }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('client.ticket.all.show', Crypt::encrypt($a->id)) }}" class="action-icon" target="_blank" rel="noopener">
                                                    <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                                                        title="Detalle"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>

                                <!-- end task -->
                            </div> <!-- end card-body-->
                        </div> <!-- end card -->
                    </div> <!-- end .collapse-->
                </div> <!-- end .mt-2-->

                <!-- BOLSA -->
                <div class="mt-4">
                    <h5 class="m-0 pb-2">
                        <a class="text-dark" data-bs-toggle="collapse" href="#estimadoTasks" role="button"
                            aria-expanded="false" aria-controls="todayTasks">
                            <i class='uil uil-angle-down font-18'></i>Bolsa <span
                                class="text-muted">({{ $bolsa->count() }})</span>
                        </a>
                    </h5>

                    <div class="collapse show" id="estimadoTasks">
                        <div class="card mb-0">
                            <div class="card-body">
                                <!-- task -->
                                <table id="basic-datatable-two" class="table dt-responsive nowrap w-100"
                                    style=" font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th># <div class="resizer"></div>
                                            </th>
                                            <th>C.Requerimiento <div class="resizer"></div></th>
                                            <th>Título <div class="resizer"></div></th>
                                            <th>N° OC<div class="resizer"></div></th>
                                            <th>Sociedad <div class="resizer"></div></th>
                                            <th>Fecha PRD <div class="resizer"></div></th>
                                            <th>Fecha Terminado <div class="resizer"></div></th>
                                            <th>Costo Total <div class="resizer"></div></th>
                                            <th>Acción <div class="resizer"></div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($bolsa as $b)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $b->cod_ticket }}</td>
                                            <td>{{ $b->nombre_ticket}}</td>
                                            <td>{{ $b->oc_bolsa ?? null}}</td>
                                            <td>{{ $b->sociedad->nombre_sociedad}}</td>
                                            <td>{{ $b->fecha_prd ?? null }}</td>
                                            <td>{{ $b->fecha_resolucion ?? null}}</td>
                                            <td>{{ $b->costo_total ?? null }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('client.ticket.all.show', Crypt::encrypt($b->id)) }}" class="action-icon" target="_blank" rel="noopener">
                                                    <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                                                        title="Detalle"></i>
                                                </a>
                                            </td>
                                        </tr>
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
        $("#basic-datatable-four").DataTable({
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
        $("#basic-datatable-five").DataTable({
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
        $("#basic-datatable-six").DataTable({
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
        $("#basic-datatable-seven").DataTable({
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
        $("#basic-datatable-eight").DataTable({
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