@extends('admin.layouts.master')

@section('title', 'Bandeja de Estados | Rensar Consulting')

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
                    <!-- PANEL Y FILTROS -->
                    <div class="card p-3 shadow-sm rounded">
                        <form method="GET" action="{{ route('admin.ticket') }}">
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
                                        <!-- <button type="button" class="btn btn-warning btn-sm w-100 ms-1" id="exportBtn" disabled>-->
                                            <!--<i class="mdi mdi-cloud-print me-1"></i> Exportar-->
                                        <!--</button>-->
                                    </div>
                                </div>
                            </div>
                        </form>
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
                                            <th>Sociedad <div class="resizer"></div></th>
                                            <th>Abap <div class="resizer"></div></th>
                                            <th>Funcional <div class="resizer"></div></th>
                                            <th>Fecha Registro <div class="resizer"></div></th>
                                            <th>Acción <div class="resizer"></div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pendientes as $pendiente)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pendiente->cod_ticket }}</td>
                                            <td>{{ $pendiente->nombre_ticket }}</td>
                                            <td>{{ $pendiente->sociedad->nombre_sociedad }}</td>
                                            <td>{{ $pendiente->abap?->usuario?->name ?? null }}</td>
                                            <td>{{ $pendiente->funcional?->usuario?->name ?? null }}</td>
                                            <td>{{ $pendiente->created_at->format('Y-m-d') }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('admin.ticket.show', Crypt::encrypt($pendiente->id)) }}" class="action-icon" target="_blank" rel="noopener">
                                                    <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                                                        title="Detalle"></i>
                                                </a>
                                                <a href="javascript: void(0);" class="action-icon" data-bs-toggle="modal"
                                                    data-bs-target="#delete-modal-costo-{{ $pendiente->id }}">
                                                    <i class="mdi mdi-delete" data-bs-toggle="tooltip" data-bs-placement="left"
                                                    title="Eliminar"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Modal de confirmación eliminar ticket-->
                                        <div id="delete-modal-costo-{{ $pendiente->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-body p-4">
                                                        <form class="ps-3 pe-3" action="{{ route('admin.ticket.delete', $pendiente->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="text-center">
                                                                <i class="ri-alert-line h1 text-danger"></i>
                                                                <h4 class="mt-2">¿Estás Seguro?</h4>
                                                                <p class="mt-3">
                                                                    Esta acción resultará en la eliminación permanente del ticket seleccionado.
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
                                            <th>Sociedad <div class="resizer"></div></th>
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
                                            <td>{{ $estimado->sociedad->nombre_sociedad }}</td>
                                            <td>{{ $estimado->abap?->usuario?->name ?? null}}</td>
                                            <td>{{ $estimado->funcional?->usuario?->name ?? null }}</td>
                                            <td>{{ $estimado->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $estimado->total_horas }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('admin.ticket.show', Crypt::encrypt($estimado->id)) }}" class="action-icon" target="_blank" rel="noopener">
                                                    <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                                                        title="Detalle"></i>
                                                </a>
                                                <a href="javascript: void(0);" class="action-icon" data-bs-toggle="modal"
                                                    data-bs-target="#delete-modal-costo-{{ $estimado->id }}">
                                                    <i class="mdi mdi-delete" data-bs-toggle="tooltip" data-bs-placement="left"
                                                    title="Eliminar"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Modal de confirmación eliminar ticket-->
                                        <div id="delete-modal-costo-{{ $estimado->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-body p-4">
                                                        <form class="ps-3 pe-3" action="{{ route('admin.ticket.delete', $estimado->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="text-center">
                                                                <i class="ri-alert-line h1 text-danger"></i>
                                                                <h4 class="mt-2">¿Estás Seguro?</h4>
                                                                <p class="mt-3">
                                                                    Esta acción resultará en la eliminación permanente del ticket seleccionado.
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
                                            <th>Sociedad <div class="resizer"></div></th>
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
                                            <td>{{ $aprobado->sociedad->nombre_sociedad }}</td>
                                            <td>{{ $aprobado->abap?->usuario?->name ?? null }}</td>
                                            <td>{{ $aprobado->funcional?->usuario?->name ?? null }}</td>
                                            <td>{{ $fechaInicio }}</td>
                                            <td>{{ $fechaFinal }}</td>
                                            <td>{{ $aprobado->total_horas }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('admin.ticket.show', Crypt::encrypt($aprobado->id)) }}" class="action-icon" target="_blank" rel="noopener">
                                                    <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                                                        title="Detalle"></i>
                                                </a>
                                                <a href="javascript: void(0);" class="action-icon" data-bs-toggle="modal"
                                                    data-bs-target="#delete-modal-costo-{{ $aprobado->id }}">
                                                    <i class="mdi mdi-delete" data-bs-toggle="tooltip" data-bs-placement="left"
                                                    title="Eliminar"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Modal de confirmación eliminar ticket-->
                                        <div id="delete-modal-costo-{{ $aprobado->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-body p-4">
                                                        <form class="ps-3 pe-3" action="{{ route('admin.ticket.delete', $aprobado->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="text-center">
                                                                <i class="ri-alert-line h1 text-danger"></i>
                                                                <h4 class="mt-2">¿Estás Seguro?</h4>
                                                                <p class="mt-3">
                                                                    Esta acción resultará en la eliminación permanente del ticket seleccionado.
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
                                            <th>Abap <div class="resizer"></div></th>
                                            <th>Funcional <div class="resizer"></div></th>
                                            <th>Fecha Inicio <div class="resizer"></div></th>
                                            <th>Fecha Finalizar <div class="resizer"></div></th>
                                            <th>Fecha Registro <div class="resizer"></div></th>
                                            <th>Horas estimadas <div class="resizer"></div></th>
                                            <th>Acción <div class="resizer"></div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($planificados as $planificado)
                                        @php
                                            $fechaInicio = $planificado->fecha_inicio ? Carbon::parse($planificado->fecha_inicio)->format('Y-m-d') : '';
                                            $fechaFinal = $planificado->fecha_resolucion ? Carbon::parse($planificado->fecha_resolucion)->format('Y-m-d') : '';
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $planificado->cod_ticket }}</td>
                                            <td>{{ $planificado->nombre_ticket }}</td>
                                            <td>{{ $planificado->abap?->usuario?->name ?? null }}</td>
                                            <td>{{ $planificado->funcional?->usuario?->name ?? null }}</td>
                                            <td>{{ $fechaInicio }}</td>
                                            <td>{{ $fechaFinal }}</td>
                                            <td>{{ $planificado->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $planificado->total_horas }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('admin.ticket.show', Crypt::encrypt($planificado->id)) }}" class="action-icon" target="_blank" rel="noopener">
                                                    <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                                                        title="Detalle"></i>
                                                </a>
                                                <a href="javascript: void(0);" class="action-icon" data-bs-toggle="modal"
                                                    data-bs-target="#delete-modal-costo-{{ $planificado->id }}">
                                                    <i class="mdi mdi-delete" data-bs-toggle="tooltip" data-bs-placement="left"
                                                    title="Eliminar"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Modal de confirmación eliminar ticket-->
                                        <div id="delete-modal-costo-{{ $planificado->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-body p-4">
                                                        <form class="ps-3 pe-3" action="{{ route('admin.ticket.delete', $planificado->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="text-center">
                                                                <i class="ri-alert-line h1 text-danger"></i>
                                                                <h4 class="mt-2">¿Estás Seguro?</h4>
                                                                <p class="mt-3">
                                                                    Esta acción resultará en la eliminación permanente del ticket seleccionado.
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
                                            <th>Sociedad <div class="resizer"></div></th>
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
                                            <td>{{ $observado->sociedad->nombre_sociedad }}</td>
                                            <td>{{ $observado->abap?->usuario?->name ?? null }}</td>
                                            <td>{{ $observado->funcional?->usuario?->name ?? null }}</td>
                                            <td>{{ $observado->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $observado->total_horas }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('admin.ticket.show', Crypt::encrypt($observado->id)) }}" class="action-icon" target="_blank" rel="noopener">
                                                    <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                                                        title="Detalle"></i>
                                                </a>
                                                <a href="javascript: void(0);" class="action-icon" data-bs-toggle="modal"
                                                    data-bs-target="#delete-modal-costo-{{ $observado->id }}">
                                                    <i class="mdi mdi-delete" data-bs-toggle="tooltip" data-bs-placement="left"
                                                    title="Eliminar"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Modal de confirmación eliminar ticket-->
                                        <div id="delete-modal-costo-{{ $observado->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-body p-4">
                                                        <form class="ps-3 pe-3" action="{{ route('admin.ticket.delete', $observado->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="text-center">
                                                                <i class="ri-alert-line h1 text-danger"></i>
                                                                <h4 class="mt-2">¿Estás Seguro?</h4>
                                                                <p class="mt-3">
                                                                    Esta acción resultará en la eliminación permanente del ticket seleccionado.
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
                                            <th>Sociedad <div class="resizer"></div></th>
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
                                            <td>{{ $prueba_cliente->sociedad->nombre_sociedad }}</td>
                                            <td>{{ $prueba_cliente->abap?->usuario?->name ?? null }}</td>
                                            <td>{{ $prueba_cliente->funcional?->usuario?->name ?? null }}</td>
                                            <td>{{ $prueba_cliente->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $prueba_cliente->total_horas }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('admin.ticket.show', Crypt::encrypt($prueba_cliente->id)) }}" class="action-icon" target="_blank" rel="noopener">
                                                    <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                                                        title="Detalle"></i>
                                                </a>
                                                <a href="javascript: void(0);" class="action-icon" data-bs-toggle="modal"
                                                    data-bs-target="#delete-modal-costo-{{ $prueba_cliente->id }}">
                                                    <i class="mdi mdi-delete" data-bs-toggle="tooltip" data-bs-placement="left"
                                                    title="Eliminar"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Modal de confirmación eliminar ticket-->
                                        <div id="delete-modal-costo-{{ $prueba_cliente->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-body p-4">
                                                        <form class="ps-3 pe-3" action="{{ route('admin.ticket.delete', $prueba_cliente->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="text-center">
                                                                <i class="ri-alert-line h1 text-danger"></i>
                                                                <h4 class="mt-2">¿Estás Seguro?</h4>
                                                                <p class="mt-3">
                                                                    Esta acción resultará en la eliminación permanente del ticket seleccionado.
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
                                            <th>Sociedad <div class="resizer"></div></th>
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
                                            <td>{{ $cerrado->sociedad->nombre_sociedad }}</td>
                                            <td>{{ $cerrado->abap?->usuario?->name ?? null }}</td>
                                            <td>{{ $cerrado->funcional?->usuario?->name ?? null }}</td>
                                            <td>{{ $cerrado->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $cerrado->total_horas }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('admin.ticket.show', Crypt::encrypt($cerrado->id)) }}" class="action-icon" target="_blank" rel="noopener">
                                                    <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                                                        title="Detalle"></i>
                                                </a>
                                                <a href="javascript: void(0);" class="action-icon" data-bs-toggle="modal"
                                                    data-bs-target="#delete-modal-costo-{{ $cerrado->id }}">
                                                    <i class="mdi mdi-delete" data-bs-toggle="tooltip" data-bs-placement="left"
                                                    title="Eliminar"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Modal de confirmación eliminar ticket-->
                                        <div id="delete-modal-costo-{{ $cerrado->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-body p-4">
                                                        <form class="ps-3 pe-3" action="{{ route('admin.ticket.delete', $cerrado->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="text-center">
                                                                <i class="ri-alert-line h1 text-danger"></i>
                                                                <h4 class="mt-2">¿Estás Seguro?</h4>
                                                                <p class="mt-3">
                                                                    Esta acción resultará en la eliminación permanente del ticket seleccionado.
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

<!-- Pasar los tickets pendientes a JS -->
<script>
    const ticketsPendientes = {!! $tickets->toJson() !!};
    console.log('Tickets pendientes cargados:', ticketsPendientes);
</script>

<!-- Librerías necesarias -->
<script src="https://cdn.jsdelivr.net/npm/exceljs/dist/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script>
    document.getElementById('exportBtn').addEventListener('click', async () => {
        if(!ticketsPendientes || Object.keys(ticketsPendientes).length === 0){
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
        titleCell.value = 'Total Tickets';
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
            'Cliente','Sociedad','Ticket','Descripción','Modulo','ABAP','Funcional','Fecha Inicio',
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
                ticket.cliente?.razon_social ?? '',        // Cliente
                ticket.sociedad?.nombre_sociedad ?? '',    // Sociedad
                ticket.cod_ticket ?? '',                   // Ticket
                ticket.nombre_ticket ?? '',                // Descripción
                ticket.modulo?.desc_modulo ?? '',          // Módulo
                ticket.abap?.usuario?.name ?? '',          // ABAP
                ticket.funcional?.usuario?.name ?? '',     // Funcional
                ticket.fecha_inicio ?? '',                 // Fecha Inicio
                ticket.fecha_prd ?? '',                    // Pase a PRD
                ticket.oc_bolsa ?? '',                     // OC Bolsa
                ticket.num_hes ?? '',                      // HES
                ticket.solicitante ?? '',                  // Solicitante
                horasAbap,                                 // Horas ABAP
                costoAbap,                                 // Costo ABAP
                costoTotalAbap,                            // Cost. Total Abap (nuevo)
                horasFun,                                  // Horas Fun.
                costoFun,                                  // Costo Fun.
                costoTotalFun,                             // Cost. Tota. Fun (nuevo)
                ticket.total_horas ?? '',                  // Total Horas
                ticket.costo_total ?? '',                  // Total Costo
                ticket.factura_id ?? '',                   // Factura Referencia
                ticket.factura?.fecha ?? ''                // Fecha de Facturación
            ]);

            // Bordes y alineación
            row.eachCell(cell => {
                cell.alignment = { vertical: 'middle', horizontal: 'left' };
                cell.border = {
                    top: { style: 'thin' },
                    left: { style: 'thin' },
                    bottom: { style: 'thin' },
                    right: { style: 'thin' }
                };
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
        saveAs(blob, "total_tickets.xlsx");

        console.log('Archivo generado correctamente');
    });
</script>




@endsection

