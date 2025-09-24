@extends('admin.layouts.master')

@section('content')
@php
use Carbon\Carbon;
$oc_bolsa = null;
$cambio = null;
if ($ticket->tipo_ticket == 'OC') {
    $oc_bolsa = 'Orden de Compra';
    $cambio = 'Bolsa';
} else if ($ticket->tipo_ticket == 'Bolsa'){
    $oc_bolsa = 'Bolsa';
    $cambio = 'Orden de Compra';
} else{
    $oc_bolsa = 'No definido';
    $cambio = 'No definido';
}
@endphp
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Rensar Consulting</a>
                            </li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Gestion de
                                    Tickets</a></li>
                            <li class="breadcrumb-item active">Detalle de Tickets</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Detalle de Ticket: {{ $ticket->cod_ticket }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xxl-8 col-lg-6">
                <!-- project card -->
                <div class="card d-block">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h3 class="">{{ $ticket->nombre_ticket }} </h3>
                            
                            <!-- project title-->
                        </div>
                        @if($ticket->tipo_ticket == 'OC')
                            <div class="badge bg-primary text-light mb-3">Orden de Compra</div>
                        @else 
                            @if($ticket->tipo_ticket == 'Bolsa')
                                <div class="badge bg-info text-light mb-3">Bolsa</div>
                            @else
                                <div class="badge bg-dark text-light mb-3">No definido</div>
                            @endif
                        @endif

                        <h4>Descripción general del Ticket:</h4>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <h5>Cliente</h5>
                                    <p>{{ $ticket->cliente->descripcion }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <h5>Sociedad</h5>
                                    <p>{{ $ticket->sociedad->nombre_sociedad }}</small></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <h5>Solicitante</h5>
                                    <p>{{ $ticket->solicitante ?? 'Sin solicitante'}} </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <h5>Modulo</h5>
                                    <p>{{ $ticket->modulo->abre_modulo }} - {{ $ticket->modulo->desc_modulo }}</p>
                                </div>
                            </div>
                        </div>
                        <h4>Descripción de consultores:</h4>
                        {{-- ABAP --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <div class="mt-0">
                                        <h5>Abap</h5>
                                        <p>{{ $ticket->abap?->usuario?->name ?? 'Sin Abap' }}</small></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <div class="mt-0">
                                        <h5>Horas Abap</h5>
                                        <p>{{ $ticket->hora_abap ?? 'No cuenta con hora' }}</small></p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        {{-- FUNCIONAL --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <div class="mt-0">
                                        <h5>Funcional</h5>
                                        <p>{{ $ticket->funcional?->usuario?->name ?? 'Sin Funcional' }}</small></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <div class="mt-0">
                                        <h5>Horas Funcional</h5>
                                        <p>{{ $ticket->hora_funcional ?? 'No cuenta con hora'}}</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <h4>Detalles de OC - Bolsa</h4>
                        {{-- OC BOLSA --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <div class="mt-0">
                                        <h5>N° OC Bolsa</h5>
                                        <p>{{ $ticket->oc_bolsa ?? 'No Asignado' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <div class="mt-0">
                                        <h5>N° HES</h5>
                                        <p>{{ $ticket->num_hes ?? 'No Asignado' }} </p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        {{-- ESTADO --}}
                        <h4>Estados y fechas</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <div class="mt-0">
                                        <h5>Estado de Proyecto: </h5>
                                        <p>{{ $ticket->estado->desc_estado }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <h5>Fecha Registro</h5>
                                    @php
                                        $fecha_reg = Carbon::parse($ticket->created_at);
                                        $dia_reg = $fecha_reg->day;
                                        $mes_reg = $fecha_reg->locale('es')->isoFormat('MMMM');
                                        $anio_reg = $fecha_reg->year;
                                        $hora_reg = $fecha_reg->format('g:i');
                                        $ampm_reg = $fecha_reg->format('A') == 'AM' ? 'a. m.' : 'p. m.';
                                    @endphp
                                    <p>{{ $dia_reg }} {{ ucfirst($mes_reg) }} {{ $anio_reg }} <small class="text-muted">{{ $hora_reg }} {{ $ampm_reg }}</small></p>
                                </div>
                            </div>
                        </div>
                        {{-- FECHAS --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <h5>Fecha Inicio</h5>
                                            @php
                                            $fecha_ini = null;
                                            if (!empty($ticket->fecha_inicio)) {
                                                $fecha_ini = Carbon::parse($ticket->fecha_inicio);
                                                $dia_ini = $fecha_ini->day;
                                                $mes_ini = $fecha_ini->locale('es')->isoFormat('MMMM');
                                                $anio_ini = $fecha_ini->year;
                                                $hora_ini = $fecha_ini->format('g:i');
                                                $ampm_ini = $fecha_ini->format('A') == 'AM' ? 'a. m.' : 'p. m.';
                                                }
                                                
                                            @endphp
                                            @if($fecha_ini)
                                                <p>{{ $dia_ini }} {{ ucfirst($mes_ini) }} {{ $anio_ini }} <small class="text-muted">{{ $hora_ini }} {{ $ampm_ini }}</small></p>
                                            @else
                                                <p class="text-muted">No asignada</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <h5>Fecha Final</h5>
                                            @php
                                            $fecha_fin = null;
                                            if (!empty($ticket->fecha_resolucion)) {
                                                $fecha_fin = Carbon::parse($ticket->fecha_resolucion);
                                                $dia_fin = $fecha_fin->day;
                                                $mes_fin = $fecha_fin->locale('es')->isoFormat('MMMM');
                                                $anio_fin = $fecha_fin->year;
                                                $hora_fin = $fecha_fin->format('g:i');
                                                $ampm_fin = $fecha_fin->format('A') == 'AM' ? 'a. m.' : 'p. m.';
                                                }
                                                
                                            @endphp
                                            @if($fecha_fin)
                                                <p>{{ $dia_fin }} {{ ucfirst($mes_fin) }} {{ $anio_fin }} <small class="text-muted">{{ $hora_fin }} {{ $ampm_fin }}</small></p>
                                            @else
                                                <p class="text-muted">No asignada</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> <!-- end card-body-->

                </div> <!-- end card-->

                {{-- HISTORIAL DE ESTADOS --}}
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 mb-3">Historial de Fechas</h4>
                        <div class="table-responsive">
                            <table id="basic-datatable-one" class="table table-striped table-centered mb-0">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Comentario</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($estado_fechas_tickets as $estado_fecha)
                                    @php
                                    $fechaListEstado = null;
                                    if (!empty($estado_fecha->fecha_estado)) {
                                                $fechaListEstado = Carbon::parse($estado_fecha->fecha_estado);
                                                $dia_est = $fechaListEstado->day;
                                                $mes_est = $fechaListEstado->locale('es')->isoFormat('MMMM');
                                                $anio_est = $fechaListEstado->year;
                                                $hora_est = $fechaListEstado->format('g:i');
                                                $ampm_est = $fechaListEstado->format('A') == 'AM' ? 'a. m.' : 'p. m.';
                                                }
                                                
                                    @endphp
                                    <tr>
                                        <td data-order="{{ $estado_fecha->fecha_estado }}">
                                            {{ $dia_est }} {{ ucfirst($mes_est) }} {{ $anio_est }}
                                            <small class="text-muted">{{ $hora_est }} {{ $ampm_est }}</small>
                                        </td>
                                        <td>{{ $estado_fecha->estado->desc_estado}}</td>
                                        <td>{{ $estado_fecha->descripcion }}</td>
                                        <td class="table-action">
                                            @if($estado_fecha->documentos && $estado_fecha->documentos->count() > 0)
                                                <a href="javascript:void(0);" class="action-icon"
                                                    data-bs-toggle="modal" data-bs-target="#documentosModal{{$estado_fecha->id}}">
                                                    <i class="mdi mdi-file-document-multiple"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="documentosModal{{$estado_fecha->id}}" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="documentosModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="documentosModalLabel">Documentos Relacionados
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Cerrar"></button>
                                                </div>

                                                <div class="modal-body">
                                                    @foreach($estado_fecha->documentos as $documento)
                                                    @php
                                                        $modalId = 'confirmDeleteModal_' . $documento->id;
                                                    @endphp

                                                    <div class="card mb-2 shadow-none border">
                                                        <div class="p-2">
                                                            <div class="row align-items-center">
                                                                <div class="col-auto">
                                                                    <div class="avatar-sm">
                                                                        <span class="avatar-title rounded bg-light text-dark text-uppercase">
                                                                            .{{ $documento->extension }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col ps-0">
                                                                    <a href="{{ asset($documento->ruta_documento) }}" class="text-muted fw-bold" download="{{ $documento->nombre_original }}">
                                                                        {{ $documento->nombre_original }}
                                                                    </a>
                                                                    <p class="mb-0">{{ number_format($documento->tamano_bytes / 1048576, 2) }} MB</p>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <a href="{{ asset($documento->ruta_documento) }}" class="btn btn-link btn-lg text-muted" download="{{ $documento->nombre_original }}">
                                                                        <i class="ri-download-2-line"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                                        Cerrar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end card-body-->
                </div>
                {{-- HISTORIAL DE COSTOS --}}
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mt-0 mb-0">Costos</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-centered mb-0">
                                <thead>
                                    <tr>
                                        <th>Detalle</th>
                                        <th>Costo Unitario</th>
                                        <th>Horas</th>
                                        <th>Costo Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $costo_total = 0; @endphp
                                    @forelse($history_ticket_costos as $history_costo)
                                    @php $costo = 0; @endphp
                                    <tr>
                                        <td>Horas {{ $history_costo->rol }}</td>
                                        @if($history_costo->rol == 'abap')
                                        <td>{{ $costo = $ticket->costo_abap }}</td>
                                        @elseif($history_costo->rol == 'funcional')
                                        <td>{{ $costo = $ticket->costo_funcional }}</td>
                                        @endif
                                        <td>{{ $history_costo->horas }}</td>
                                        @php
                                        $costo = $costo * $history_costo->horas;
                                        $costo = number_format($costo, 2, '.', '');
                                        @endphp

                                        <td>{{ $costo }}</td>
                                    </tr>
                                    @empty
                                    @endforelse
                                    <tr>
                                        <td colspan="2"><strong>Total Ticket</strong></td>
                                        <td><strong>{{ $ticket->total_horas }}</strong></td>
                                        <td><strong>{{ $ticket->costo_total }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end card-body-->
                </div>
                <!-- end card-->
            </div> <!-- end col -->

            {{-- Menu lateral de documentos --}}
            <div class="col-lg-6 col-xxl-4">
                
                {{-- documentos existentes --}}
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Documentos Relacionados</h5>
                        @foreach($estado_fechas_tickets as $documentos_totales)
                        @foreach($documentos_totales->documentos as $documentos_listado)
                            <div class="card mb-2 shadow-none border">
                                <div class="p-2">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar-sm">
                                                <span class="avatar-title rounded bg-light text-dark text-uppercase">
                                                    .{{ $documentos_listado->extension }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col ps-0">
                                            <a href="{{ asset($documentos_listado->ruta_documento) }}" class="text-muted fw-bold" download="{{ $documentos_listado->nombre_original }}">
                                                {{ $documentos_listado->nombre_original }}
                                            </a>
                                            <p class="mb-0">{{ number_format($documentos_listado->tamano_bytes / 1048576, 2) }} MB</p>
                                        </div>
                                        <div class="col-auto">
                                            <a href="{{ asset($documentos_listado->ruta_documento) }}" class="btn btn-link btn-lg text-muted" download="{{ $documentos_listado->nombre_original }}">
                                                <i class="ri-download-2-line" data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Descargar"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @endforeach
                    </div>
                </div>
                <!-- end card-->
            </div>
        </div>
        <!-- end row -->
    </div> <!-- container -->

</div> <!-- content -->

<script>
    $(document).ready(function () {
        "use strict";
        $("#basic-datatable-one").DataTable({
            "order": [[0, "desc"]],
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