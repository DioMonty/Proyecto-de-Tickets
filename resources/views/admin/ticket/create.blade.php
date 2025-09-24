@extends('admin.layouts.master')

@section('title', 'Crear Tickets | Rensar Consulting')

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
                            <li class="breadcrumb-item"><a href="#"><i class="uil-home-alt"></i> Gestion de Tickets</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Crear Tickets</li>
                        </ol>
                    </nav>
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
                        {{-- action="{{ route('documento.subir') }}" --}}
                        <form class="form-group" method="POST" action="{{ route('admin.ticket.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="ticketname" class="form-label">Nombre</label>
                                        <input type="text" name="nombre_ticket" id="ticketname" class="form-control" required
                                            placeholder="Ingresar el Nombre del Ticket">
                                    </div>
                                    <div class="mt-3">
                                        <label for="project-overview" class="form-label">Modulo</label>

                                        <select class="form-control select2" data-toggle="select2" id="id_modulo" name="id_modulo" required>
                                            <option value="">-- Seleccionar un modulo --</option>
                                            @foreach ($modulos as $modulo)
                                                <option value="{{ $modulo->id }}">{{ $modulo->abre_modulo }} - {{ $modulo->desc_modulo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 mt-3">
                                            <label for="project-overview" class="form-label">Asignar Tipo de Costo:</label>
                                            <select class="form-control select2" data-toggle="select2" id="tipoCosto" name="tipoCosto" required disabled>
                                                <option value="">-- Selecciona un tipo de costo --</option>
                                                <option value="soporte">SOPORTE</option>
                                                <option value="proyecto">PROYECTO</option>
                                                <option value="bolsa_hora">BOLSA DE HORAS</option>
                                            </select>
                                        </div>

                                        <div class="col-12 col-lg-6 mt-3">
                                            <label for="project-status" class="form-label">Estado del
                                            Proyecto:</label>
                                            <input type="text" value="Pendiente" class="form-control"
                                                id="project-status" placeholder="Pendiente" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 mt-3">
                                            <label for="project-overview" class="form-label">Asignar a:
                                                (Abap)</label>
                                            <select class="form-control select2" id="abap"  data-toggle="select2" name="abap" disabled>
                                                <option value="">-- Seleccionar un Abap --</option>
                                                
                                            </select>
                                        </div>

                                        <div class="col-12 col-lg-6 mt-3">
                                            <label for="project-budget" class="form-label">Horas Abap</label>
                                            <input type="text" id="hora_abap" name="hora_abap" class="form-control"
                                                placeholder="Horas Abap" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 mt-3">
                                            <label for="project-overview" class="form-label">Asignar a:
                                                (Funcional)</label>
                                            <select class="form-control select2" data-toggle="select2" id="funcional" name="funcional" disabled>
                                                <option value="">-- Selecciona un funcional --</option>
                                            </select>
                                        </div>

                                        <div class="col-12 col-lg-6 mt-3">
                                            <label for="project-budget" class="form-label">Horas Funcional</label>
                                            <input type="text" id="hora_funcional" name="hora_funcional" class="form-control"
                                                placeholder="Horas Funcional" disabled>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label for="project-overview" class="form-label">Descripcion</label>
                                        <textarea class="form-control" id="project-overview" name="descripcion" rows="5"
                                            placeholder="Ingresa la descripcion.."></textarea>
                                    </div>
                                </div> <!-- end col-->
                                <div class="col-xl-6">

                                    <div class="mt-0">
                                        <label class="form-label">Cliente</label>
                                            <select class="form-control select2" data-toggle="select2" id="cliente" name="cliente" required disabled>
                                                <option value="">-- Selecciona un cliente --</option>
                                                @foreach ($clientes as $cliente)
                                                    <option value="{{ $cliente->id }}">{{ $cliente->descripcion }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">Sociedad</label>
                                            <select class="form-control select2" data-toggle="select2" id="sociedad" name="sociedad" required disabled>
                                                <option value="">-- Selecciona una sociedad --</option>
                                            </select>
                                    </div>
                                    <div class="mt-3">
                                        <label for="project-overview" class="form-label">Solicitante</label>

                                        <input type="text" id="project-overview" class="form-control" name="solicitante"
                                            placeholder="Ingresar el nombre del solicitante">
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6 mt-3">
                                            <label for="project-overview" class="form-label">Seleccione modo de OC</label>
                                            <select id="tipo_ticket" class="form-control select2" data-toggle="select2" name="tipo_ticket">
                                                <option value="">Seleccionar</option>
                                                <option value="Bolsa">Bolsa</option>
                                                <option value="OC">Orden de Compra</option>
                                            </select>
                                        </div>

                                        <div class="col-12 col-lg-6 mt-3">
                                            <label for="project-budget" class="form-label">OC Bolsa</label>
                                            <input type="text" id="oc_bolsa" name="oc_bolsa" class="form-control" placeholder="Digite" disabled>
                                        </div>
                                    </div>
                                    {{-- <div class="mt-3">
                                        <label for="archivos" class="form-label">Cargar Archivos</label>
                                        <input type="file" name="archivos[]" id="archivos" class="form-control" multiple>
                                        <small class="text-muted">Tamaño máximo por archivo: 10MB. Archivos permitidos: PDF, Word, Excel, CSV.</small>
                                    </div> --}}
                                    <div class="mt-3">
                                        <label for="archivos" class="form-label">Cargar Archivos</label>
                                        <input type="file" name="archivos[]" id="archivos" class="form-control" multiple>
                                        <div id="preview-container" class="mt-3 d-flex flex-wrap gap-2"></div>
                                        <small class="text-muted">Limite por archivo: 10MB. Archivos permitidos: PDF, Word, Excel, CSV.</small>
                                    </div>

                                    <div class="container mt-3">
                                        <div class="row justify-content-center">
                                            <div class="col-12 col-md-6">
                                                <div class="mx-auto">
                                                    <button type="submit"
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
                        </form>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->

    </div> <!-- container -->

</div> <!-- content -->

<script>
    $(document).ready(function () {
        // Inicializar select2
        $('#id_modulo, #tipoCosto, #abap, #funcional, #cliente, #sociedad, #tipo_ticket').select2();

        // 1. Selección de módulo → habilita tipo de costo
        $('#id_modulo').on('change', function () {
            const val = $(this).val();
            $('#tipoCosto').prop('disabled', val === '');
            if (val === '') {
                $('#tipoCosto').val('').trigger('change');
            }
        });

        // 2. Selección de tipo de costo → habilita abap y cliente
        $('#tipoCosto').on('change', function () {
            const val = $(this).val();
            const habilitado = val !== '';

            // Cliente + Sociedad
            $('#cliente').prop('disabled', !habilitado);
            $('#sociedad').prop('disabled', !habilitado);

            
        });
        // 4. Selección de cliente → habilita sociedad y funcional
        $('#cliente').on('change', function () {
            const val = $(this).val();
            const habilitado = val !== '';

            $('#sociedad').prop('disabled', !habilitado);
            $('#funcional').prop('disabled', !habilitado);
            
            // Abap
            $('#abap').prop('disabled', !habilitado).val('').trigger('change');
            $('#hora_abap').prop('disabled', true).val('');

            if (!habilitado) {
                $('#funcional').val('').trigger('change');
                $('#abap').val('').trigger('change');
            }
        });

        // 5. Selección de funcional → habilita horas funcional
        $('#funcional').on('change', function () {
            const val = $(this).val();
            $('#hora_funcional').prop('disabled', val === '');
            if (val === '') {
                $('#hora_funcional').val('');
            }
        });

        // 3. Selección de abap → habilita horas abap
        $('#abap').on('change', function () {
            const val = $(this).val();
            $('#hora_abap').prop('disabled', val === '');
            if (val === '') {
                $('#hora_abap').val('');
            }
        });

        // 6. Tipo ticket → habilita campo oc_bolsa
        $('#tipo_ticket').on('change', function () {
            const val = $(this).val();
            const habilitado = (val === 'Bolsa' || val === 'OC');
            $('#oc_bolsa').prop('disabled', !habilitado);
            if (!habilitado) {
                $('#oc_bolsa').val('');
            }
        });

        // 7. Validación al enviar
        $('form').on('submit', function (e) {
            const abap = $('#abap').val();
            const funcional = $('#funcional').val();

            if (!abap && !funcional) {
                e.preventDefault();
                alert('Debe seleccionar al menos un consultor: ABAP o Funcional.');
                return false;
            }
        });
    });

</script>
<script>
    $(document).ready(function () {
        $('#cliente').select2();
        $('#sociedad').select2();

        $('#cliente').on('change', function () {
            let clienteId = $(this).val();
            let sociedadSelect = $('#sociedad');

            sociedadSelect.empty().append('<option value="">Cargando sociedades...</option>');

            if (clienteId) {
                $.ajax({
                    url: "{{ url('/cliente/sociedades') }}/" + clienteId,
                    type: 'GET',
                    success: function (data) {
                        sociedadSelect.empty().append('<option value="">-- Selecciona una sociedad --</option>');
                        data.forEach(function (soc) {
                            sociedadSelect.append(
                                $('<option>', {
                                    value: soc.id,
                                    text: soc.nombre_sociedad
                                })
                            );
                        });
                        sociedadSelect.trigger('change.select2');
                    },
                    error: function () {
                        sociedadSelect.empty().append('<option value="">Error al cargar</option>');
                    }
                });
            } else {
                sociedadSelect.empty().append('<option value="">-- Selecciona una sociedad --</option>');
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#id_modulo, #funcional, #tipoCosto, #cliente').select2();

        function cargarFuncionales() {
            let clienteId = $('#cliente').val();
            let moduloId = $('#id_modulo').val();
            let tipoCosto = $('#tipoCosto').val();
            let funcionalSelect = $('#funcional');

            funcionalSelect.empty().append('<option value="">Cargando funcionales...</option>');

            if (clienteId && moduloId && tipoCosto) {
                $.ajax({
                    url: "{{ url('/modulo/funcional') }}/" + clienteId + "/" + moduloId + "/" + tipoCosto,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        console.log("Funcionales recibidos:", data); // 👀 debug

                        funcionalSelect.empty().append('<option value="">-- Selecciona un funcional --</option>');
                        if (Array.isArray(data) && data.length > 0) {
                            data.forEach(function (fun) {
                                if (fun.consultor && fun.consultor.usuario) {
                                    funcionalSelect.append(
                                        $('<option>', {
                                            value: fun.consultor.id,
                                            text: fun.consultor.usuario.name
                                        })
                                    );
                                }
                            });
                        } else {
                            funcionalSelect.append('<option value="">No hay funcionales disponibles</option>');
                        }
                        funcionalSelect.trigger('change.select2');
                    },
                    error: function (xhr) {
                        console.error("Error AJAX:", xhr.responseText);
                        funcionalSelect.empty().append('<option value="">Error al cargar</option>');
                    }
                });
            } else {
                funcionalSelect.empty().append('<option value="">-- Selecciona un funcional --</option>');
            }
        }

        // ✅ Ejecutar la función en los tres selects
        $('#cliente').on('change', cargarFuncionales);
        $('#id_modulo').on('change', cargarFuncionales);
        $('#tipoCosto').on('change', cargarFuncionales);
    });
</script>

<script>
    $(document).ready(function () {
        $('#id_modulo, #tipoCosto, #cliente, #abap').select2();

        function cargarAbaps() {
            let clienteId = $('#cliente').val();
            let tipoCosto = $('#tipoCosto').val();
            let abapSelect = $('#abap');

            abapSelect.empty().append('<option value="">Cargando abaps...</option>');

            if (clienteId && tipoCosto) {
                $.ajax({
                    url: "{{ url('/modulo/abap') }}/" + clienteId + "/" + tipoCosto,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        console.log("ABAP recibidos:", data); // 👀 debug

                        abapSelect.empty().append('<option value="">-- Selecciona un Abap --</option>');
                        if (Array.isArray(data.abaps) && data.abaps.length > 0) {
                            data.abaps.forEach(function (abap) {
                                abapSelect.append(
                                    $('<option>', {
                                        value: abap.id,
                                        text: abap.name
                                    })
                                );
                            });
                        } else {
                            abapSelect.append('<option value="">No hay ABAP disponibles</option>');
                        }
                        abapSelect.trigger('change.select2');
                    },
                    error: function (xhr) {
                        console.error("Error AJAX:", xhr.responseText);
                        abapSelect.empty().append('<option value="">Error al cargar</option>');
                    }
                });
            } else {
                abapSelect.empty().append('<option value="">-- Selecciona un Abap --</option>');
            }
        }

        // ✅ Ejecutar la función cuando cambie cliente o tipo de costo
        $('#cliente').on('change', cargarAbaps);
        $('#tipoCosto').on('change', cargarAbaps);
    });
</script>


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

@endsection
