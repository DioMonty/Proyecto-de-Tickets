@extends('admin.layouts.master')

@section('title', 'Modulos | Rensar Consulting')

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
                                <li class="breadcrumb-item active" aria-current="page">Modulos</li>
                            </ol>
                        </nav>
                    </div>
                    <h4 class="page-title">Modulos</h4>
                    <p class="mt-2 mb-3 text-muted">
                        Permite visualizar y gestionar los diferentes modulos existentes en SAP.
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
                        <i class="mdi mdi-account-multiple-plus-outline me-1"></i> Crear Modulo
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
                    <th>Nombre Modulo</th>
                    <th>Descripcion</th>
                    <th>Acciones</th>
                    <th>Activado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($modulos as $modulo)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $modulo->abre_modulo }}</td>
                    <td>{{ $modulo->desc_modulo }}</td>
                    <td class="table-action">
                        <a href="#" class="action-icon" data-bs-toggle="modal" data-bs-target="#editar-modal-{{ $modulo->id }}">
                            <i class="mdi mdi-pencil" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Editar"></i>
                        </a>
                        <a href="javascript: void(0);" class="action-icon" data-bs-toggle="modal" data-bs-target="#detalle-modal-{{ $modulo->id }}">
                            <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Detalle"></i>
                        </a>
                    </td>
                    <td class="table-action">
                        <div class="form-check form-switch d-flex ">
                            <input type="checkbox"
                                class="form-check-input cambiar-estado"
                                data-id="{{ $modulo->id }}"
                                id="switch03-{{ $modulo->id }}"
                                {{ $modulo->estado ? 'checked' : '' }}>
                            <label for="switch03-{{ $modulo->id }}" class="switch-label mb-0 ms-2">
                                {{ $modulo->estado ? 'Sí' : 'No' }}
                            </label>

                        </div>

                    </td>
                </tr>
                <!-- Modal detalle modulo -->
                <div id="detalle-modal-{{ $modulo->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title">Detalle del Módulo</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <div class="ps-3 pe-3">

                                    <div class="mb-3">
                                        <label class="form-label">Nombre de Módulo</label>
                                        <input type="text" class="form-control bg-light border-0" value="{{ $modulo->abre_modulo }}" readonly tabindex="-1">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Descripción</label>
                                        <input type="text" class="form-control bg-light border-0" value="{{ $modulo->desc_modulo }}" readonly tabindex="-1">
                                    </div>

                                    <!-- Si el módulo tiene más campos, los puedes agregar aquí con el mismo estilo -->

                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal editar usuario -->
                <div id="editar-modal-{{ $modulo->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title">Editar Modulo</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="ps-3 pe-3" action="{{ route('admin.modulo.update', $modulo->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="apellido" class="form-label">Nombre de Modulo</label>
                                        <input class="form-control" type="text" name="abre_modulo" required value="{{ $modulo->abre_modulo }}" placeholder="Nombre de Modulo">
                                    </div>
                                    <div class="mb-3">
                                        <label for="emailaddress" class="form-label">Descripcion</label>
                                        <input class="form-control" type="text" name="desc_modulo" required value="{{ $modulo->desc_modulo }}" placeholder="Descripcion">
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
                    <h4 class="modal-title">Crear Modulo</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ps-3 pe-3" action="{{ route('admin.modulo.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Nombre de Modulo</label>
                            <input class="form-control" type="text" name="abre_modulo" required placeholder="Nombre de Modulo">
                        </div>
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Descripcion</label>
                            <input class="form-control" type="text" name="desc_modulo" required placeholder="Descripcion">
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
                url: '{{ url("admin/modulo/estado") }}/' + id,
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
            const modulos = @json($modulos);
            const workbook = new ExcelJS.Workbook();
            const sheet = workbook.addWorksheet("Modulos");

            // --- Crear título y fecha ---
            const ahora = new Date();
            const fechaTexto =
                ahora.getFullYear() + "-" +
                String(ahora.getMonth() + 1).padStart(2, '0') + "-" +
                String(ahora.getDate()).padStart(2, '0') + " " +
                String(ahora.getHours()).padStart(2, '0') + ":" +
                String(ahora.getMinutes()).padStart(2, '0');

            // Fila 1: Título
            sheet.addRow(["Listado de Módulos"]);
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
            modulos.forEach(m => {
                const row = sheet.addRow([m.abre_modulo, m.desc_modulo]);
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
            link.download = `${fechaStr}Modulos.xlsx`;
            link.click();
        }

        document.getElementById("export-excel").addEventListener("click", function(e) {
            e.preventDefault();
            exportTableToExcel();
        });
    });
</script>

<script>
    function toggleLabel(checkbox) {
        const label = checkbox.nextElementSibling;
        label.textContent = checkbox.checked ? 'Sí' : 'No';
    }
</script>


@endsection