@extends('admin.layouts.master')

@section('title', 'Back Log | Rensar Consulting')

@section('content')

@php
use Carbon\Carbon;
@endphp
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
                                <li class="breadcrumb-item"><a href="#"><i class="uil-home-alt"></i> Back
                                        Log </a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tickets Cancelados
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <h4 class="page-title">Back Log</h4>
                    <p class="mt-2 mb-3 text-muted">
                        Una bandeja de tickets cancelados es el espacio donde se muestran los tickets
                        anulados, los cuales no continúan en el flujo de atención ni generan comprobante de
                        pago.

                    </p>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="card p-3 shadow-sm rounded">
            <form method="GET" action="{{ route('admin.ticket.cancelado') }}">
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
                            <button type="button" class="btn btn-warning btn-sm w-100 ms-1" id="exportBtn">
                                <i class="mdi mdi-cloud-print me-1"></i> Exportar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Tabla de usuarios -->
        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
            <thead>
                <tr>
                    <th>#<div class="resizer"></div></th>
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
                @forelse($cancelados as $cancelado)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $cancelado->cod_ticket }}</td>
                    <td>{{ $cancelado->nombre_ticket }}</td>
                    <td>{{ $cancelado->sociedad->nombre_sociedad }}</td>
                    <td>{{ $cancelado->abap?->usuario?->name ?? 'No Asignado' }}</td>
                    <td>{{ $cancelado->funcional?->usuario?->name ?? 'No Asignado' }}</td>
                    <td>{{ $cancelado->created_at->format('d-m-Y') }}</td>
                    <td class="table-action">
                        <a href="{{ route('admin.ticket.cancelado.show', Crypt::encrypt($cancelado->id)) }}" class="action-icon" target="_blank" rel="noopener">
                            <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                                title="Detalle"></i>
                        </a>
                        <a href="javascript: void(0);" class="action-icon" data-bs-toggle="modal"
                            data-bs-target="#warning-alert-modal-{{ $cancelado->id }}">
                            <i class="mdi mdi-backup-restore"></i>
                        </a>
                    </td>
                </tr>

                <!-- Modal de confirmación eliminar -->
                <div id="warning-alert-modal-{{ $cancelado->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-body p-4">
                                <form class="ps-3 pe-3" action="{{ route('admin.restaurar.ticket', $cancelado->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="text-center">
                                        <i class="ri-alert-line h1 text-warning"></i>
                                        <h4 class="mt-2">Restaurar Ticket Cancelado</h4>
                                        <p class="mt-3">
                                            ¿Deseas restaurar este ticket cancelado para que vuelva al flujo de gestión?
                                        </p>
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-warning my-2"
                                            data-bs-dismiss="modal">Continuar</button>
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
    </div> <!-- container -->

</div> <!-- content -->

<!-- Pasar los tickets pendientes a JS -->
<script>
    const ticketsPendientes = {!! $cancelados->toJson() !!};
    console.log('Tickets pendientes cargados:', ticketsPendientes);
</script>

<!-- Librerías necesarias -->
<script src="https://cdn.jsdelivr.net/npm/exceljs/dist/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script>
    document.getElementById('exportBtn').addEventListener('click', async () => {
        if(!ticketsPendientes || Object.keys(ticketsPendientes).length === 0){
            alert('No hay tickets cancelados para exportar.');
            return;
        }

        const ticketsArray = Object.values(ticketsPendientes);

        const workbook = new ExcelJS.Workbook();
        const sheet = workbook.addWorksheet('Tickets Pendientes');

        let currentRow = 1;

        // ===== Título =====
        sheet.mergeCells(`A${currentRow}:U${currentRow}`);
        const titleCell = sheet.getCell(`A${currentRow}`);
        titleCell.value = 'Total Tickets Cancelados';
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
        saveAs(blob, "Tickets Cancelados.xlsx");

        console.log('Archivo generado correctamente');
    });
</script>

@endsection

