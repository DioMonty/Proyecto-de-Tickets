@extends('admin.layouts.master')

@section('title', $ticket->nombre_ticket . ' | Rensar Consulting')

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
                            <h3 class="">{{ $ticket->nombre_ticket }} 
                                <a type="button" class="action-icon" data-bs-toggle="modal"
                                    data-bs-target="#edit-descrip">
                                    <i class="mdi mdi-pencil" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Editar descripción"></i>
                                </a> 
                            </h3>
                            
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
                                    @if($ticket->solicitante)
                                        <p>{{ $ticket->solicitante }}
                                            <a type="button" class="action-icon" data-bs-toggle="modal"
                                        data-bs-target="#agregar-solicitante">
                                        <i class="mdi mdi-pencil" data-bs-toggle="tooltip" data-bs-placement="left"
                                            title="Editar Solicitante"></i>
                                        </a> 
                                        </p>
                                    @else
                                    <button type="button" class="btn btn-light w-100" data-bs-toggle="modal"
                                            data-bs-target="#agregar-solicitante">
                                            Añadir solicitante</button>
                                    @endif
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
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <h5>Tipo de Costo</h5>
                                    <p>
                                        @switch($ticket->tipo_costo)
                                            @case('soporte') SOPORTE @break
                                            @case('proyecto') PROYECTO @break
                                            @case('bolsa_hora') BOLSA DE HORAS @break
                                            @default {{ $ticket->tipo_costo }}
                                        @endswitch
                                    </p>

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
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <div class="mt-0">
                                        <h5>Cambiar Abap</h5>
                                    </div>
                                    <button type="button" class="btn btn-light w-100" data-bs-toggle="modal"
                                        data-bs-target="#cambiar-abap">
                                        Cambiar de Abap</button>
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
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <div class="mt-0">
                                        <h5>Cambiar Funcional</h5>
                                    </div>
                                    <button type="button" class="btn btn-light w-100" data-bs-toggle="modal"
                                        data-bs-target="#cambiar-funcional">
                                        Cambiar de Funcional</button>
                                </div>
                            </div>
                        </div>
                        <h4>Detalles de OC - Bolsa</h4>
                        {{-- OC BOLSA --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <div class="mt-0">
                                        <h5>N°</h5>
                                        <p>{{ $ticket->oc_bolsa ?? 'No Asignado' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <div class="mt-0">
                                        <h5>Descripcion OC Bolsa</h5>
                                    </div>
                                    <button type="button" class="btn btn-light w-100" data-bs-toggle="modal"
                                        data-bs-target="#cambiar-descripcion">
                                        Descripción </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <div class="mt-0">
                                        <h5>N° HES</h5>
                                        <p>{{ $ticket->num_hes ?? 'No Asignado' }} 
                                            <a type="button" class="action-icon" data-bs-toggle="modal"
                                                data-bs-target="#edit-hes">
                                                <i class="mdi mdi-pencil" data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Editar HES"></i>
                                            </a> 
                                        </p>
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
                                        <h5>Estado de Proyecto: {{ $ticket->estado->desc_estado }}</h5>
                                    </div>
                                    @if( $ticket->id_estado === 8)
                                        <label for="project-status" class="form-label">Ticket Cerrado</label>
                                    @else
                                        <button type="button" class="btn btn-light w-100" data-bs-toggle="modal"
                                            data-bs-target="#cambiar-status">
                                            Cambiar de Estado</button>
                                    @endif
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
                            @if($ticket->id_estado >= 3)
                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <div class="mt-0">
                                            <label for="project-status" class="form-label">Asignacion de fechas:</label>
                                        </div>
                                        <button type="button" class="btn btn-light w-100" data-bs-toggle="modal"
                                            data-bs-target="#cambiar-fecha-ini-fin">
                                            Asignar fechas</button>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <h5>Fecha Pase a PRD</h5>
                                    @php
                                    $fecha_prd = null;
                                    if (!empty($ticket_prd->fecha_prd)) {
                                        $fecha_prd = Carbon::parse($ticket->fecha_inicio);
                                        $dia_prd = $fecha_prd->day;
                                        $mes_prd = $fecha_prd->locale('es')->isoFormat('MMMM');
                                        $anio_prd = $fecha_prd->year;
                                        $hora_prd = $fecha_prd->format('g:i');
                                        $ampm_prd = $fecha_prd->format('A') == 'AM' ? 'a. m.' : 'p. m.';
                                        }
                                        
                                    @endphp
                                    @if($fecha_prd)
                                        <p>{{ $dia_prd }} {{ ucfirst($mes_prd) }} {{ $anio_prd }} <small class="text-muted">{{ $hora_prd }} {{ $ampm_prd }}</small></p>
                                    @else
                                        <p class="text-muted">No asignada</p>
                                    @endif
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
                                                        $deleteBtnId = 'btnEliminar_' . $documento->id;
                                                        $modalId = 'confirmDeleteModal_' . $documento->id;
                                                        $cancelBtnId = 'cancelarEliminar_' . $documento->id;
                                                        $confirmBtnId = 'confirmarEliminar_' . $documento->id;
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
                                                                    <!-- Botón que abre modal de confirmación -->
                                                                    <button type="button" class="btn btn-link btn-lg text-muted" id="{{ $deleteBtnId }}">
                                                                        <i class="mdi mdi-delete" data-bs-toggle="tooltip" data-bs-placement="left" title="Eliminar"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal Interno de Confirmación -->
                                                    <div class="inner-modal-backdrop" id="{{ $modalId }}" style="display:none;">
                                                        <div class="inner-modal text-center">
                                                            <form class="ps-3 pe-3" action="{{ route('admin.documento.delete', $documento->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                <div class="modal-content">
                                                                    <div class="modal-body p-4">
                                                                        <i class="ri-alert-line h1 text-danger"></i>
                                                                        <h4 class="mt-2">¿Estás Seguro?</h4>
                                                                        <p class="mt-3">
                                                                            Esta acción resultará en la eliminación permanente del documento seleccionado {{ $documento->id }}.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-around mt-3">
                                                                    <button type="button" class="btn btn-secondary" id="{{ $cancelBtnId }}">Cancelar</button>
                                                                    <button type="submit" class="btn btn-danger" id="{{ $confirmBtnId }}">Continuar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <script>
                                                        document.getElementById('{{ $deleteBtnId }}').addEventListener('click', () => {
                                                            document.getElementById('{{ $modalId }}').style.display = 'flex';
                                                        });

                                                        document.getElementById('{{ $cancelBtnId }}').addEventListener('click', () => {
                                                            document.getElementById('{{ $modalId }}').style.display = 'none';
                                                        });

                                                    </script>
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
                            @if( $ticket->id_estado === 8)
                            @else
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#nuevo-costo">
                                    Asignar Horas
                                </button>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-centered mb-0">
                                <thead>
                                    <tr>
                                        <th>Detalle</th>
                                        <th>Costo Unitario</th>
                                        <th>Horas</th>
                                        <th>Costo Total</th>
                                        <th>Acciones</th>
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
                                        <td>
                                            <a type="button" class="action-icon" data-bs-toggle="modal"
                                                data-bs-target="#editar-modal-{{ $history_costo->id }}">
                                                <i class="mdi mdi-pencil" data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Editar"></i>
                                            </a>
                                            <a href="javascript: void(0);" class="action-icon" data-bs-toggle="modal"
                                                data-bs-target="#delete-modal-costo-{{ $history_costo->id }}">
                                                <i class="mdi mdi-delete" data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Eliminar"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Modal editar costo -->
                                    <div id="editar-modal-{{ $history_costo->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header text-center">
                                                    <h4 class="modal-title" style="color: black;"> Editar las horas</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="ps-3 pe-3" action="{{ route('admin.costo_ticket.edit', $history_costo->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="desc_status" class="form-label">Horas</label>
                                                            <input class="form-control" type="number" name="horas_edit_costo" value="{{ $history_costo->horas }}" placeholder="0.00" min="0" step="0.01" required>
                                                        </div>
                                                        <div class="modal-footer d-flex justify-content-center">
                                                            <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">Cerrar</button>
                                                            <button type="submit" class="btn btn-primary">Editar Horas</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal de confirmación eliminar Costo-->
                                    <div id="delete-modal-costo-{{ $history_costo->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-body p-4">
                                                    <form class="ps-3 pe-3" action="{{ route('admin.costo_ticket.delete', $history_costo->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="text-center">
                                                            <i class="ri-alert-line h1 text-danger"></i>
                                                            <h4 class="mt-2">¿Estás Seguro?</h4>
                                                            <p class="mt-3">
                                                                Esta acción resultará en la eliminación permanente del costo seleccionado.
                                                            </p>
                                                            <button type="submit" class="btn btn-danger my-2" data-bs-dismiss="modal">Continuar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    @endforelse
                                    <tr>
                                        <td colspan="2"><strong>Total Ticket</strong></td>
                                        <td><strong>{{ $ticket->total_horas }}</strong></td>
                                        <td><strong>{{ $ticket->costo_total }}</strong></td>
                                        <td></td>
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
                {{-- crear nuevo documento  --}}
                <form action="{{ route('admin.documento_ticket.create', $ticket->id) }}" method="POST" enctype="multipart/form-data" id="form-documentos">
                @csrf
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Subir Documentos</h5>
                            <p class="text-muted font-14">Tamaño máximo recomendado: 10MB. Archivos permitidos: PDF, Word, Excel.</p>

                            <div class="mb-3">
                                <label for="desc_status" class="form-label">Comentario</label>
                                <input class="form-control" type="text" id="comentario_data" name="comentario_data">
                            </div>

                            <div class="mb-3">
                                <label for="documentos" class="form-label">Cargar Archivos</label><br>
                                <input type="file" name="documentos[]" id="documentos" class="form-control" multiple>
                                <div id="preview-container-doc" class="mt-3 d-flex flex-wrap gap-2"></div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-danger d-flex align-items-center justify-content-center w-100">
                                        <i class="mdi mdi-cloud me-1"></i> <span>Guardar</span>
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" id="btn-cancelar-doc" class="btn btn-secondary d-flex align-items-center justify-content-center w-100">
                                        <span>Cancelar</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

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
                                            <a href="javascript: void(0);" class="btn btn-link btn-lg text-muted" data-bs-toggle="modal"
                                                data-bs-target="#delete-document-{{ $documentos_listado->id }}">
                                                <i class="mdi mdi-delete" data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="Eliminar"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal de confirmación eliminar Documento-->
                            <div id="delete-document-{{ $documentos_listado->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body p-4">
                                            <form class="ps-3 pe-3" action="{{ route('admin.documento.delete', $documentos_listado->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="text-center">
                                                    <i class="ri-alert-line h1 text-danger"></i>
                                                    <h4 class="mt-2">¿Estás Seguro?</h4>
                                                    <p class="mt-3">
                                                        Esta acción resultará en la eliminación permanente del documento seleccionado.
                                                    </p>
                                                    <button type="submit" class="btn btn-danger my-2" data-bs-dismiss="modal">Continuar</button>
                                                </div>
                                            </form>
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

    <!-- Modal cambiar descripcion ticket -->
    <div id="edit-descrip" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title" style="color: black;">Cambiar Estatus</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ps-3 pe-3" action="{{ route('admin.descrip_ticket.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="desc_status" class="form-label">Descripcion</label>
                            <input class="form-control" type="text" id="descrip_tick" name="descrip_tick" value="{{ $ticket->nombre_ticket }}">
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cambiar hes ticket -->
    <div id="edit-hes" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title" style="color: black;">Cambiar Estatus</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ps-3 pe-3" action="{{ route('admin.num_hes.ticket.update', $ticket->id) }}" method="POST" >
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="desc_status" class="form-label">Número Hes</label>
                            <input class="form-control" type="text" id="num_hes" name="num_hes" value="{{ $ticket->num_hes ?? null }}">
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

       <!-- Modal cambiar solicitante ticket -->
    <div id="agregar-solicitante" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title" style="color: black;">Cambiar Estatus</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ps-3 pe-3" action="{{ route('admin.solicitante.ticket.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="desc_status" class="form-label">Solicitante</label>
                            <input class="form-control" type="text" id="solicitante_tick" name="solicitante_tick" placeholder="Añadir solicitante" value="{{ $ticket->solicitante }}">
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cambiar estado de ticket -->
    <div id="cambiar-status" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title" style="color: black;">Cambiar Estatus</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ps-3 pe-3" action="{{ route('admin.cam_estado.create', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="rol-add" class="form-label">Fecha</label>
                            <input class="form-control" type="datetime-local" required id="fecha_est" name="fecha_est"
                                    placeholder="Fecha y hora" value="{{ Carbon::now()->format('Y-m-d\TH:i') }}">

                        </div>
                        <div class="mb-3">
                            <label for="rol-add" class="form-label">Cambiar de Estado</label>
                            <select class="form-control" required id="estado_cam" name="estado_cam">
                                <option value="">Seleccionar</option>
                                @foreach ($estados as $estado)
                                    {{-- Mostrar Cancelar (id = 9) solo si ticket->id_estado es 1 o 2 --}}
                                    @if ($estado->id == 9)
                                        @if (in_array($ticket->id_estado, [1, 2]))
                                            <option value="{{ $estado->id }}" 
                                                @if($ticket->id_estado == $estado->id) selected @endif>
                                                {{ $estado->desc_estado }}
                                            </option>
                                        @endif
                                    @else
                                        {{-- Los demás estados siempre se muestran --}}
                                        <option value="{{ $estado->id }}" 
                                            @if($ticket->id_estado == $estado->id) selected @endif>
                                            {{ $estado->desc_estado }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>

                        </div>
                        <!-- Campo dinámico que aparece solo si estado_cam == 8 -->
                        <div class="mb-3 d-none" id="factura-field">
                            <label for="num_factura" class="form-label">Número de Factura</label>
                            <input class="form-control" type="text" id="num_factura" name="num_factura" placeholder="Ingrese número de factura">
                        </div>
                        <div class="mb-3">
                            <label for="desc_status" class="form-label">Comentario</label>
                            <input class="form-control" type="text" id="desc_status" name="desc_status">
                        </div>
                        <div class="mb-3">
                            <label for="archivos" class="form-label">Cargar Archivos</label><br>
                            <small class="text-muted">Tamaño máximo por archivo: 10MB. Archivos permitidos: PDF, Word, Excel, CSV.</small>
                            <input type="file" name="archivos[]" id="archivos" class="form-control" multiple>
                            <div id="preview-container" class="mt-3 d-flex flex-wrap gap-2"></div>
                        </div>

                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cambiar abap -->
    <div id="cambiar-abap" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title" style="color: black;">Cambiar Abap</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ps-3 pe-3" action="{{ route('admin.abap_cambio.edit', $ticket->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="rol-add" class="form-label">Cambiar de Abap</label>
                            <select class="form-control"  id="abap_cam" name="abap_cam">
                                <option value="">Seleccionar</option>
                                @foreach ($abaps as $abap)
                                    <option value="{{ $abap->id }}" @if($ticket->id_abap == $abap->id) selected @endif>{{ $abap->usuario->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cambiar funcional -->
    <div id="cambiar-funcional" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title" style="color: black;">Cambiar Funcional</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ps-3 pe-3" action="{{ route('admin.funcional_cambio.edit', $ticket->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="rol-add" class="form-label">Cambiar de Funcional</label>
                            <select class="form-control"  id="funcional_cam" name="funcional_cam">
                                <option value="">Seleccionar</option>
                                @foreach ($funcionales as $funcional)
                                    <option value="{{ $funcional->consultor->id }}" 
                                        @if($ticket->id_funcional == $funcional->consultor->id) selected @endif>
                                        {{ $funcional->consultor->usuario->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cambiar numero oc o compra -->
    <div id="cambiar-descripcion" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title" style="color: black;">Cambiar descripción</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ps-3 pe-3" action="{{ route('admin.descrip_oc_bolsa.edit', $ticket->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="project-overview" class="form-label">Seleccione modo de OC Bolsa</label>
                            <select id="tipo_ticket" class="form-control" name="tipo_ticket" required>
                                <option value="">Seleccionar</option>
                                <option value="Bolsa" @if($ticket->tipo_ticket == 'Bolsa') selected @endif >Bolsa</option>
                                <option value="OC" @if($ticket->tipo_ticket == 'OC') selected @endif >Orden de Compra</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="rol-add" class="form-label">Número de OC Bolsa</label>
                            <input class="form-control" type="text" id="num_oc_bolsa_cam" name="num_oc_bolsa_cam"
                                placeholder="N° de {{ $oc_bolsa }}" value="{{ $ticket->oc_bolsa }}">
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal nuevo costo -->
    <div id="nuevo-costo" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title" style="color: black;"> Agregar nuevo costo</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ps-3 pe-3" action="{{ route('admin.costo_ticket.store', $ticket->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="rol-add" class="form-label">Consultor</label>
                            <select class="form-control"  id="consultor_costo" name="consultor_costo" required>
                                <option value="">--- Seleccione ---</option>
                                @if($ticket->id_funcional)
                                <option value="funcional">Funcional</option>
                                @endif
                                @if($ticket->id_abap)
                                <option value="abap">Abap</option>
                                @endif
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="desc_status" class="form-label">Horas</label>
                            <input class="form-control" type="number" name="horas_costo" placeholder="0.00" min="0" step="0.01" required>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Asignar horas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal cambiar fecha inicio fin --}}
    <div id="cambiar-fecha-ini-fin" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title" style="color: black;">Cambiar Estatus</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ps-3 pe-3" action="{{ route('admin.fecha_ini_fin.create', $ticket->id) }}" method="POST" >
                        @csrf
                        @php
                            $fechaInicio = $ticket->fecha_inicio ? Carbon::parse($ticket->fecha_inicio)->format('Y-m-d\TH:i') : '';
                            $fechaFinal = $ticket->fecha_resolucion ? Carbon::parse($ticket->fecha_resolucion)->format('Y-m-d\TH:i') : '';
                        @endphp

                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                            <input class="form-control" type="datetime-local" id="fecha_inicio" 
                                name="fecha_inicio" value="{{ $fechaInicio }}"
                                placeholder="Fecha y hora de inicio">
                        </div>

                        <div class="mb-3">
                            <label for="fecha_final" class="form-label">Fecha Finalizar</label>
                            <input class="form-control" type="datetime-local" id="fecha_final" 
                                name="fecha_final" value="{{ $fechaFinal }}" placeholder="Fecha y hora de finalización (opcional)">
                        </div>

                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div> <!-- content -->

<script>
    const inputArchivos = document.getElementById('archivos');
    const container = document.getElementById('preview-container');
    let fileList = [];

    inputArchivos.addEventListener('change', function (e) {
        const newFiles = Array.from(e.target.files);

        // Evita duplicados basados en nombre y tamaño
        newFiles.forEach(file => {
            const exists = fileList.some(f => f.name === file.name && f.size === file.size);
            if (!exists) {
                fileList.push(file);
            }
        });

        updatePreview();
        updateFileInput();
    });

    function updatePreview() {
        container.innerHTML = '';
        fileList.forEach((file, index) => {
            const filePreview = document.createElement('div');
            filePreview.className = 'file-preview border rounded p-2 d-flex align-items-center justify-content-between w-100';
            filePreview.style.gap = '10px';

            const fileName = document.createElement('span');
            fileName.textContent = file.name;

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn btn-sm btn-danger';
            removeBtn.innerHTML = '<i class="mdi mdi-close"></i>';
            removeBtn.onclick = function () {
                fileList.splice(index, 1);
                updatePreview();
                updateFileInput();
            };

            filePreview.appendChild(fileName);
            filePreview.appendChild(removeBtn);
            container.appendChild(filePreview);
        });
    }

    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        fileList.forEach(file => dataTransfer.items.add(file));
        inputArchivos.files = dataTransfer.files;
    }
</script>

<script>
    const inputArchivosDoc = document.getElementById('documentos');
    const containerDoc = document.getElementById('preview-container-doc');
    let fileListDoc = [];

    inputArchivosDoc.addEventListener('change', function (e) {
        const newFilesDoc = Array.from(e.target.files);

        // Evita duplicados por nombre y tamaño
        newFilesDoc.forEach(file => {
            const exists = fileListDoc.some(f => f.name === file.name && f.size === file.size);
            if (!exists) {
                fileListDoc.push(file);
            }
        });

        updatePreviewDoc();
        updateFileInputDoc();
    });

    function updatePreviewDoc() {
        containerDoc.innerHTML = '';

        fileListDoc.forEach((file, index) => {
            const filePreviewDoc = document.createElement('div');
            filePreviewDoc.className = 'file-preview border rounded p-2 d-flex align-items-center justify-content-between w-100';
            filePreviewDoc.style.gap = '10px';

            const fileNameDoc = document.createElement('span');
            fileNameDoc.textContent = file.name;

            const removeBtnDoc = document.createElement('button');
            removeBtnDoc.type = 'button';
            removeBtnDoc.className = 'btn btn-sm btn-danger';
            removeBtnDoc.innerHTML = '<i class="mdi mdi-close"></i>';
            removeBtnDoc.onclick = function () {
                fileListDoc.splice(index, 1);
                updatePreviewDoc();
                updateFileInputDoc();
            };

            filePreviewDoc.appendChild(fileNameDoc);
            filePreviewDoc.appendChild(removeBtnDoc);
            containerDoc.appendChild(filePreviewDoc);
        });
    }

    function updateFileInputDoc() {
        const dataTransfer = new DataTransfer();
        fileListDoc.forEach(file => dataTransfer.items.add(file));
        inputArchivosDoc.files = dataTransfer.files;
    }
</script>

<script>
    document.getElementById('btn-cancelar-doc').addEventListener('click', function () {
        const form = document.getElementById('form-documentos');
        form.reset(); // limpia campos de texto y archivos

        // Limpiar vista previa si tienes miniaturas
        const previewContainer = document.getElementById('preview-container-doc');
        previewContainer.innerHTML = '';
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const estadoSelect = document.getElementById('estado_cam');
        const facturaField = document.getElementById('factura-field');

        function toggleFacturaField() {
            if (estadoSelect.value === '8') {
                facturaField.classList.remove('d-none');
            } else {
                facturaField.classList.add('d-none');
                document.getElementById('num_factura').value = ''; // limpia si se oculta
            }
        }

        // Ejecutar al cargar por si ya está seleccionado
        toggleFacturaField();

        // Escuchar cambios
        estadoSelect.addEventListener('change', toggleFacturaField);
    });
</script>
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