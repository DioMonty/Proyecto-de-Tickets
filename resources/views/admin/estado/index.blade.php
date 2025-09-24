@extends('admin.layouts.master')

@section('title', 'Estados | Rensar Consulting')

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
                                <li class="breadcrumb-item"><a href="#"><i class="uil-home-alt"></i> Catalogos</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Estados</li>
                            </ol>
                        </nav>
                    </div>
                    <h4 class="page-title">Estados</h4>
                    <p class="mt-2 mb-3 text-muted">
                        Permite visualizar y gestionar los diferentes Estados existentes en SAP.
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
                        <i class="mdi mdi-account-multiple-plus-outline me-1"></i> Crear Estado
                    </button>
                    <button type="button" class="btn btn-warning" id="export-excel"> 
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
                    <th>Nombre Estado</th>
                    <th>Descripcion</th>
                    <th></th>
                    <th>Activado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($estados as $estado)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $estado->abre_estado }}</td>
                    <td>{{ $estado->desc_estado }}</td>
                    <td class="table-action">
                        <a href="#" class="action-icon" data-bs-toggle="modal" data-bs-target="#editar-modal-{{ $estado->id }}">
                            <i class="mdi mdi-pencil" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Editar"></i>
                        </a>
                        <a href="javascript: void(0);" class="action-icon" data-bs-toggle="modal" data-bs-target="#detalle-estado-modal-{{ $estado->id }}">
                            <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Detalle"></i>
                        </a>
                    </td>
                    <td class="table-action">
                        <div class="form-check form-switch d-flex ">
                            <input type="checkbox"
                                class="form-check-input cambiar-estado"
                                data-id="{{ $estado->id }}"
                                id="switch03-{{ $estado->id }}"
                                {{ $estado->estado ? 'checked' : '' }}>
                            <label for="switch03-{{ $estado->id }}" class="switch-label mb-0 ms-2">
                                {{ $estado->estado ? 'Sí' : 'No' }}
                            </label>

                        </div>

                    </td>
                </tr>

                <!-- Modal detalle estado -->
                <div id="detalle-estado-modal-{{ $estado->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title">Detalle de Estado</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <div class="ps-3 pe-3">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nombre de Estado:</label>
                                        <div class="border rounded px-3 py-2 bg-light">{{ $estado->abre_estado }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Descripción:</label>
                                        <div class="border rounded px-3 py-2 bg-light">{{ $estado->desc_estado }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal editar usuario -->
                <div id="editar-modal-{{ $estado->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title">Editar Estado</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="ps-3 pe-3" action="{{ route('admin.estado.update', $estado->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="apellido" class="form-label">Nombre de Estado</label>
                                        <input class="form-control" type="text" name="abre_estado" required value="{{ $estado->abre_estado }}" placeholder="Nombre de Estado">
                                    </div>
                                    <div class="mb-3">
                                        <label for="emailaddress" class="form-label">Descripcion</label>
                                        <input class="form-control" type="text" name="desc_estado" required value="{{ $estado->desc_estado }}" placeholder="Descripcion">
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-success">Actualizar</button>
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

    

    <!-- Modal agregar usuario -->
    <div id="agregar-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title">Crear Estado</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ps-3 pe-3" action="{{ route('admin.estado.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Nombre de Estado</label>
                            <input class="form-control" type="text" name="abre_estado" required placeholder="Nombre de Estado">
                        </div>
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Descripcion</label>
                            <input class="form-control" type="text" name="desc_estado" required placeholder="Descripcion">
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger">Guardar</button>
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
                url: '{{ url("admin/estado/estado") }}/' + id,
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

<!-- SheetJS para Excel -->
<script src="https://cdn.jsdelivr.net/npm/exceljs/dist/exceljs.min.js"></script>

<!-- jsPDF + autotable para PDF -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        async function exportTableToExcel() {
            const estados = @json($estados);
            const workbook = new ExcelJS.Workbook();
            const sheet = workbook.addWorksheet("Estados");

            // --- Crear título y fecha ---
            const ahora = new Date();
            const fechaTexto =
                ahora.getFullYear() + "-" +
                String(ahora.getMonth() + 1).padStart(2, '0') + "-" +
                String(ahora.getDate()).padStart(2, '0') + " " +
                String(ahora.getHours()).padStart(2, '0') + ":" +
                String(ahora.getMinutes()).padStart(2, '0');

            // Fila 1: Título
            sheet.addRow(["Listado de Estados"]);
            sheet.mergeCells("A1:B1");
            sheet.getCell("A1").font = {
                bold: true,
                size: 14
            };
            sheet.getCell("A1").alignment = {
                horizontal: "center"
            };

            // Fila 2: Fecha
            sheet.addRow(["Generado el: " + fechaTexto]);
            sheet.mergeCells("A2:B2");
            sheet.getCell("A2").font = {
                italic: true,
                size: 10
            };
            sheet.getCell("A2").alignment = {
                horizontal: "center"
            };

            sheet.addRow([]); // Fila vacía

            // --- Encabezados ---
            const headerRow = sheet.addRow(["Abreviatura", "Descripción"]);
            headerRow.eachCell(cell => {
                cell.font = {
                    bold: true,
                    color: {
                        argb: "FFFFFFFF"
                    }
                };
                cell.fill = {
                    type: "pattern",
                    pattern: "solid",
                    fgColor: {
                        argb: "000000"
                    }
                };
                cell.alignment = {
                    horizontal: "center",
                    vertical: "middle"
                };
                cell.border = {
                    top: {
                        style: "thin"
                    },
                    bottom: {
                        style: "thin"
                    },
                    left: {
                        style: "thin"
                    },
                    right: {
                        style: "thin"
                    }
                };
            });

            // --- Filas de datos ---
            estados.forEach(m => {
                const row = sheet.addRow([m.abre_estado, m.desc_estado]);
                row.eachCell(cell => {
                    cell.border = {
                        top: {
                            style: "thin"
                        },
                        bottom: {
                            style: "thin"
                        },
                        left: {
                            style: "thin"
                        },
                        right: {
                            style: "thin"
                        }
                    };
                });
            });

            // --- Ajustar ancho de columnas ---
            sheet.columns.forEach(column => {
                let maxLength = 10;
                column.eachCell({
                    includeEmpty: true
                }, cell => {
                    const value = cell.value ? cell.value.toString() : "";
                    if (value.length > maxLength) maxLength = value.length;
                });
                column.width = maxLength + 2;
            });

            // --- Generar archivo ---
            const fechaStr =
                ahora.getFullYear().toString() +
                String(ahora.getMonth() + 1).padStart(2, '0') +
                String(ahora.getDate()).padStart(2, '0') +
                String(ahora.getHours()).padStart(2, '0') +
                String(ahora.getMinutes()).padStart(2, '0');

            const buffer = await workbook.xlsx.writeBuffer();
            const blob = new Blob([buffer], {
                type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            });
            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = `${fechaStr}Estados.xlsx`;
            link.click();
        }

        document.getElementById("export-excel").addEventListener("click", function(e) {
            e.preventDefault();
            exportTableToExcel();
        });
    });
</script>


@endsection
