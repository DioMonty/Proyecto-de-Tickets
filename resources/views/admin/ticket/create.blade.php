@extends('admin.layouts.master')

@section('content')
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
                            <li class="breadcrumb-item active">Crear Tickets</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Crear Tickets</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="ticketname" class="form-label">Nombre</label>
                                    <input type="text" id="ticketname" class="form-control"
                                        placeholder="Ingresar el Nombre del Ticket">
                                </div>
                                <div class="mt-3">
                                    <label for="project-overview" class="form-label">Modulo</label>

                                    <select class="form-control select2" data-toggle="select2" name="id_modulo">
                                        <option>Seleccionar</option>
                                        @foreach ($modulos as $modulo)
                                            <option value="{{ $modulo->id }}">{{ $modulo->desc_modulo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 mt-3">
                                        <label for="project-overview" class="form-label">Asignar a:
                                            (Abap)</label>
                                        <select class="form-control select2" data-toggle="select2">
                                            <option>Seleccionar</option>
                                            @foreach ($abaps as $abap)
                                                <option value="{{ $abap->id }}">{{ $abap->usuario->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-6 mt-3">
                                        <label for="project-budget" class="form-label">Horas del
                                            Consultor</label>
                                        <input type="text" id="project-budget" class="form-control"
                                            placeholder="Horas del Consultor">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 mt-3">
                                        <label for="project-overview" class="form-label">Asignar a:
                                            (Funcional)</label>
                                        <select class="form-control select2" data-toggle="select2">
                                            <option>Seleccionar</option>
                                            @foreach ($funcionales as $funcional)
                                                <option value="{{ $funcional->id }}">{{ $funcional->usuario->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-6 mt-3">
                                        <label for="project-budget" class="form-label">Horas del
                                            Consultor</label>
                                        <input type="text" id="project-budget" class="form-control"
                                            placeholder="Horas del Consultor">
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="project-status" class="form-label">Estado del
                                        Proyecto:</label>
                                    <select class="form-control select2" data-toggle="select2"
                                        id="project-status">
                                        <option value="">Seleccionar</option>
                                        @foreach ($estados as $estado)
                                            <option value="{{ $estado->id }}">{{ $estado->desc_estado }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-3">
                                    <label for="project-overview" class="form-label">Descripcion</label>
                                    <textarea class="form-control" id="project-overview" rows="5"
                                        placeholder="Ingresa la descripcion.."></textarea>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-xl-6">

                                <div class="mt-0">
                                    <label for="project-overview" class="form-label">Cliente</label>

                                    <select class="form-control select2" data-toggle="select2" id="cliente">
                                        <option>Seleccionar</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-3">
                                    <label for="project-overview" class="form-label">Sociedad</label>

                                    <select class="form-control select2" data-toggle="select2" id="sociedad">
                                        <option>Seleccionar</option>
                                    </select>
                                </div>
                                <div class="mt-3">
                                    <label for="project-overview" class="form-label">Solicitante</label>

                                    <input type="text" id="project-overview" class="form-control"
                                        placeholder="Ingresar el nombre del solicitante">
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6 mt-3">
                                        <label for="project-overview" class="form-label">Seleccione modo de
                                            OC</label>
                                        <select class="form-control select2" data-toggle="select2">
                                            <option>Seleccionar</option>
                                            <option value="BL">Bolsa</option>
                                            <option value="CP">Orden de Compra</option>
                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-6 mt-3">
                                        <label for="project-budget" class="form-label">OC Bolsa</label>
                                        <input type="text" id="project-budget" class="form-control"
                                            placeholder="Digite">
                                    </div>
                                </div>

                                <div class="mb-3 mt-3 mt-xl-0">
                                    <label for="projectname" class="mb-0 mt-3">Documentos</label>
                                    <p class="text-muted font-14">Tamaño máximo recomendado: 10MB. Archivos
                                        permitidos: PDF, Word, Excel.</p>

                                    <form action="/" method="post" class="dropzone" id="myAwesomeDropzone"
                                        data-plugin="dropzone"
                                        data-accepted-files=".pdf,.doc,.docx,.xls,.xlsx,.csv"
                                        data-previews-container="#file-previews"
                                        data-upload-preview-template="#uploadPreviewTemplate">
                                        <div class="fallback">
                                            <input name="file" type="file"
                                                accept=".pdf,.doc,.docx,.xls,.xlsx,.csv" />
                                        </div>

                                        <div class="dz-message needsclick">
                                            <i class="h3 text-muted ri-upload-cloud-2-line"></i>
                                            <h4>Arrastra los documentos aquí o haz clic para subir.</h4>
                                        </div>
                                    </form>

                                    <!-- Vista previa -->
                                    <div class="dropzone-previews mt-3" id="file-previews"></div>

                                    <!-- Plantilla para vista previa -->
                                    <div class="d-none" id="uploadPreviewTemplate">
                                        <div class="card mt-1 mb-0 shadow-none border">
                                            <div class="p-2">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <i class="ri-file-text-line h4 text-primary"></i>
                                                    </div>
                                                    <div class="col ps-0">
                                                        <a href="javascript:void(0);"
                                                            class="text-muted fw-bold" data-dz-name></a>
                                                        <p class="mb-0" data-dz-size></p>
                                                    </div>
                                                    <div class="col-auto">
                                                        <!-- Botón de eliminar -->
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-link btn-lg text-muted"
                                                            data-dz-remove>
                                                            <i class="ri-close-line"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fin de plantilla -->
                                </div> 
                                <div class="row">
                                    <!-- Date View -->
                                    <div class="col-12 col-lg-6 mt-3">
                                        <label class="form-label">Fecha de Inicio</label>
                                        <input type="date" class="form-control">
                                    </div>
                                    <!-- Date View -->
                                    <div class="col-12 col-lg-6 mt-3">
                                        <label class="form-label">Fecha de Resolucion</label>
                                    <input type="date" class="form-control">
                                    </div>
                                </div>

                                <div class="container mt-3">
                                    <div class="row justify-content-center">
                                        <div class="col-12 col-md-6">
                                            <div class="mx-auto">
                                                <button type="button"
                                                    class="btn btn-danger mt-3 d-flex align-items-center justify-content-center w-100">
                                                    <i class="mdi mdi-cloud me-1"></i> <span>Guardar</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div>
                        <!-- end row -->

                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->

    </div> <!-- container -->

</div> <!-- content -->

@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Asegura jQuery -->
<script>
    $(document).ready(function() {
        $('#cliente').on('change', function() {
            const clienteId = $(this).val();

            $('#sociedad').empty().append('<option value="">Seleccionar</option>');

            if (clienteId) {
                $.ajax({
                    url: `/cliente/${clienteId}/sociedades`,
                    method: 'GET',
                    dataType: 'json',
                    success: function(sociedades) {
                        console.log("Sociedades recibidas:", sociedades); // 👈 Revisa en consola

                        if (Array.isArray(sociedades) && sociedades.length > 0) {
                            sociedades.forEach(function(sociedad) {
                                $('#sociedad').append(
                                    `<option value="${sociedad.id}">${sociedad.nombre_sociedad}</option>`
                                );
                            });

                            // Seleccionar automáticamente si solo hay una
                            if (sociedades.length === 1) {
                                $('#sociedad').val(sociedades[0].id).trigger('change');
                            }
                        } else {
                            $('#sociedad').append('<option value="">No hay sociedades disponibles</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error en AJAX:", xhr.responseText, error);
                        alert('Ocurrió un error al cargar las sociedades.');
                    }
                });
            }
        });
    });
</script>
