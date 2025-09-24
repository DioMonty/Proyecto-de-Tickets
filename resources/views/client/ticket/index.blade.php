@extends('client.layouts.master')

@section('title', 'Bandeja de estados | Rensar Consulting')

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
                                        <li class="breadcrumb-item active" aria-current="page">Bandeja de Estados</li>
                                    </ol>
                                </nav>
                                </div>
                                <h4 class="page-title">Bandeja de Estados</h4>
                                <p class="mt-2 mb-3 text-muted">
                                    Una bandeja de estados es el espacio donde se visualizan los tickets organizados según su estado de atención.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- end page title -->

                <!-- Pendientes -->
                <div class="mt-4">
                    <h5 class="m-0 pb-2">
                        <a class="text-dark" data-bs-toggle="collapse" href="#pendienteTasks" role="button"
                            aria-expanded="false" aria-controls="todayTasks">
                            <i class='uil uil-angle-down font-18'></i>Pendiente <span
                                class="text-muted">({{ $pendientes->count() }})</span>
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
                                            <th>Cliente <div class="resizer"></div></th>
                                            <th>Abap <div class="resizer"></div></th>
                                            <th>Funcional <div class="resizer"></div></th>
                                            <th>Fecha Registro <div class="resizer"></div></th>
                                            <th>Horas estimadas <div class="resizer"></div></th>
                                            <th>Acción <div class="resizer"></div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pendientes as $pendiente)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pendiente->cod_ticket }}</td>
                                            <td>{{ $pendiente->nombre_ticket }}</td>
                                            <td>{{ $pendiente->cliente->descripcion }}</td>
                                            <td>{{ $pendiente->abap?->usuario?->name ?? null }}</td>
                                            <td>{{ $pendiente->funcional?->usuario?->name ?? null }}</td>
                                            <td>{{ $pendiente->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $pendiente->total_horas }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('client.ticket.show', Crypt::encrypt($pendiente->id)) }}" class="action-icon" target="_blank" rel="noopener">
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

                <!-- Estimado -->
                <div class="mt-4">
                    <h5 class="m-0 pb-2">
                        <a class="text-dark" data-bs-toggle="collapse" href="#estimadoTasks" role="button"
                            aria-expanded="false" aria-controls="todayTasks">
                            <i class='uil uil-angle-down font-18'></i>Estimado <span
                                class="text-muted">({{ $estimados->count() }})</span>
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
                                            <th>C.Requerimiento <div class="resizer"></div> </th>
                                            <th>Título <div class="resizer"></div></th>
                                            <th>Cliente <div class="resizer"></div></th>
                                            <th>Abap <div class="resizer"></div></th>
                                            <th>Funcional <div class="resizer"></div></th>
                                            <th>Fecha Registro <div class="resizer"></div></th>
                                            <th>Horas estimadas <div class="resizer"></div></th>
                                            <th>Acción <div class="resizer"></div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($estimados as $estimado)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $estimado->cod_ticket }}</td>
                                            <td>{{ $estimado->nombre_ticket }}</td>
                                            <td>{{ $estimado->cliente->descripcion }}</td>
                                            <td>{{ $estimado->abap?->usuario?->name ?? null }}</td>
                                            <td>{{ $estimado->funcional?->usuario?->name ?? null }}</td>
                                            <td>{{ $estimado->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $estimado->total_horas }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('client.ticket.show', Crypt::encrypt($estimado->id)) }}" class="action-icon" target="_blank" rel="noopener">
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

                <!-- Aprobado -->
                <div class="mt-4">
                    <h5 class="m-0 pb-2">
                        <a class="text-dark" data-bs-toggle="collapse" href="#aprobadosTasks" role="button"
                            aria-expanded="false" aria-controls="todayTasks">
                            <i class='uil uil-angle-down font-18'></i>Aprobado <span
                                class="text-muted">({{ $aprobados->count() }})</span>
                        </a>
                    </h5>

                    <div class="collapse show" id="aprobadosTasks">
                        <div class="card mb-0">
                            <div class="card-body">
                                <!-- task -->
                                <table id="basic-datatable-three" class="table dt-responsive nowrap w-100"
                                    style=" font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th># <div class="resizer"></div></th>
                                            <th>C.Requerimiento <div class="resizer"></div></th>
                                            <th>Título <div class="resizer"></div></th>
                                            <th>Cliente <div class="resizer"></div></th>
                                            <th>Abap <div class="resizer"></div></th>
                                            <th>Funcional <div class="resizer"></div></th>
                                            <th>Fecha Inicio <div class="resizer"></div></th>
                                            <th>Fecha Finalizar <div class="resizer"></div></th>
                                            <th>Horas estimadas <div class="resizer"></div></th>
                                            <th>Acción <div class="resizer"></div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($aprobados as $aprobado)
                                        @php
                                            $fechaInicio = $aprobado->fecha_inicio ? Carbon::parse($aprobado->fecha_inicio)->format('Y-m-d') : '';
                                            $fechaFinal = $aprobado->fecha_resolucion ? Carbon::parse($aprobado->fecha_resolucion)->format('Y-m-d') : '';
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $aprobado->cod_ticket }}</td>
                                            <td>{{ $aprobado->nombre_ticket }}</td>
                                            <td>{{ $aprobado->cliente->descripcion }}</td>
                                            <td>{{ $aprobado->abap?->usuario?->name ?? null }}</td>
                                            <td>{{ $aprobado->funcional?->usuario?->name ?? null }}</td>
                                            <td>{{ $fechaInicio }}</td>
                                            <td>{{ $fechaFinal }}</td>
                                            <td>{{ $aprobado->total_horas }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('client.ticket.show', Crypt::encrypt($aprobado->id)) }}" class="action-icon" target="_blank" rel="noopener">
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
                
                <!-- Planificado -->
                <div class="mt-4">
                    <h5 class="m-0 pb-2">
                        <a class="text-dark" data-bs-toggle="collapse" href="#planificadoTasks" role="button"
                            aria-expanded="false" aria-controls="todayTasks">
                            <i class='uil uil-angle-down font-18'></i>Planificado <span
                                class="text-muted">({{ $planificados->count() }})</span>
                        </a>
                    </h5>

                    <div class="collapse show" id="planificadoTasks">
                        <div class="card mb-0">
                            <div class="card-body">
                                <!-- task -->
                                <table id="basic-datatable-four" class="table dt-responsive nowrap w-100"
                                    style=" font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th># <div class="resizer"></div></th>
                                            <th>C.Requerimiento <div class="resizer"></div></th>
                                            <th>Título <div class="resizer"></div></th>
                                            <th>Cliente <div class="resizer"></div></th>
                                            <th>Abap <div class="resizer"></div></th>
                                            <th>Funcional <div class="resizer"></div></th>
                                            <th>Fecha Registro <div class="resizer"></div></th>
                                            <th>Horas estimadas <div class="resizer"></div></th>
                                            <th>Acción <div class="resizer"></div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($planificados as $planificado)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $planificado->cod_ticket }}</td>
                                            <td>{{ $planificado->nombre_ticket }}</td>
                                            <td>{{ $planificado->cliente->descripcion }}</td>
                                            <td>{{ $planificado->abap?->usuario?->name ?? null }}</td>
                                            <td>{{ $planificado->funcional?->usuario?->name ?? null }}</td>
                                            <td>{{ $planificado->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $planificado->total_horas }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('client.ticket.show', Crypt::encrypt($planificado->id)) }}" class="action-icon" target="_blank" rel="noopener">
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

                <!-- Observados -->
                <div class="mt-4">
                    <h5 class="m-0 pb-2">
                        <a class="text-dark" data-bs-toggle="collapse" href="#observadoTasks" role="button"
                            aria-expanded="false" aria-controls="todayTasks">
                            <i class='uil uil-angle-down font-18'></i>Observados <span
                                class="text-muted">({{ $observados->count() }})</span>
                        </a>
                    </h5>

                    <div class="collapse show" id="observadoTasks">
                        <div class="card mb-0">
                            <div class="card-body">
                                <!-- task -->
                                <table id="basic-datatable-five" class="table dt-responsive nowrap w-100"
                                    style=" font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th># <div class="resizer"></div></th>
                                            <th>C.Requerimiento <div class="resizer"></div></th>
                                            <th>Título <div class="resizer"></div></th>
                                            <th>Cliente <div class="resizer"></div></th>
                                            <th>Abap <div class="resizer"></div></th>
                                            <th>Funcional <div class="resizer"></div></th>
                                            <th>Fecha Registro <div class="resizer"></div></th>
                                            <th>Horas estimadas <div class="resizer"></div></th>
                                            <th>Acción <div class="resizer"></div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($observados as $observado)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $observado->cod_ticket }}</td>
                                            <td>{{ $observado->nombre_ticket }}</td>
                                            <td>{{ $observado->cliente->descripcion }}</td>
                                            <td>{{ $observado->abap?->usuario?->name ?? null }}</td>
                                            <td>{{ $observado->funcional?->usuario?->name ?? null }}</td>
                                            <td>{{ $observado->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $observado->total_horas }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('client.ticket.show', Crypt::encrypt($observado->id)) }}" class="action-icon" target="_blank" rel="noopener">
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

                <!-- Prueba Cliente -->
                <div class="mt-4">
                    <h5 class="m-0 pb-2">
                        <a class="text-dark" data-bs-toggle="collapse" href="#pruebaClienteTasks" role="button"
                            aria-expanded="false" aria-controls="todayTasks">
                            <i class='uil uil-angle-down font-18'></i>Prueba Cliente <span
                                class="text-muted">({{ $prueba_clientes->count() }})</span>
                        </a>
                    </h5>

                    <div class="collapse show" id="pruebaClienteTasks">
                        <div class="card mb-0">
                            <div class="card-body">
                                <!-- task -->
                                <table id="basic-datatable-six" class="table dt-responsive nowrap w-100"
                                    style=" font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th># <div class="resizer"></div></th>
                                            <th>C.Requerimiento <div class="resizer"></div></th>
                                            <th>Título <div class="resizer"></div></th>
                                            <th>Cliente <div class="resizer"></div></th>
                                            <th>Abap <div class="resizer"></div></th>
                                            <th>Funcional <div class="resizer"></div></th>
                                            <th>Fecha Registro <div class="resizer"></div></th>
                                            <th>Horas estimadas <div class="resizer"></div></th>
                                            <th>Acción <div class="resizer"></div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($prueba_clientes as $prueba_cliente)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $prueba_cliente->cod_ticket }}</td>
                                            <td>{{ $prueba_cliente->nombre_ticket }}</td>
                                            <td>{{ $prueba_cliente->cliente->descripcion }}</td>
                                            <td>{{ $prueba_cliente->abap?->usuario?->name ?? null }}</td>
                                            <td>{{ $prueba_cliente->funcional?->usuario?->name ?? null }}</td>
                                            <td>{{ $prueba_cliente->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $prueba_cliente->total_horas }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('client.ticket.show', Crypt::encrypt($prueba_cliente->id)) }}" class="action-icon" target="_blank" rel="noopener">
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

                <!-- Cerrado -->
                <div class="mt-4">
                    <h5 class="m-0 pb-2">
                        <a class="text-dark" data-bs-toggle="collapse" href="#cerradoTasks" role="button"
                            aria-expanded="false" aria-controls="todayTasks">
                            <i class='uil uil-angle-down font-18'></i>Cerrado <span
                                class="text-muted">({{ $cerrados->count() }})</span>
                        </a>
                    </h5>

                    <div class="collapse show" id="cerradoTasks">
                        <div class="card mb-0">
                            <div class="card-body">
                                <!-- task -->
                                <table id="basic-datatable-seven" class="table dt-responsive nowrap w-100"
                                    style=" font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th># <div class="resizer"></div></th>
                                            <th>C.Requerimiento <div class="resizer"></div></th>
                                            <th>Título <div class="resizer"></div></th>
                                            <th>Cliente <div class="resizer"></div></th>
                                            <th>Abap <div class="resizer"></div></th>
                                            <th>Funcional <div class="resizer"></div></th>
                                            <th>Fecha Registro <div class="resizer"></div></th>
                                            <th>Horas estimadas <div class="resizer"></div></th>
                                            <th>Acción <div class="resizer"></div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($cerrados as $cerrado)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $cerrado->cod_ticket }}</td>
                                            <td>{{ $cerrado->nombre_ticket }}</td>
                                            <td>{{ $cerrado->cliente->descripcion }}</td>
                                            <td>{{ $cerrado->abap?->usuario?->name ?? null }}</td>
                                            <td>{{ $cerrado->funcional?->usuario?->name ?? null }}</td>
                                            <td>{{ $cerrado->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $cerrado->total_horas }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('client.ticket.show', Crypt::encrypt($cerrado->id)) }}" class="action-icon" target="_blank" rel="noopener">
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