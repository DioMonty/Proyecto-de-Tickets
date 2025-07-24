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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Rensar Consuling</a>
                            </li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Gestión de
                                    Usuarios</a></li>
                            <li class="breadcrumb-item active">Cliente</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Cliente</h4>
                    <p class="mt-2 mb-3 text-muted">
                        En esta pantalla se podrá visualizar y gestionar la información de los clientes
                        registrados en el sistema.
                        Permite registrar nuevos clientes, actualizar datos existentes y consultar detalles
                        relevantes para facilitar su identificación y seguimiento dentro de los procesos del
                        sistema.
                    </p>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Botones: Nuevo Acceso a la izquierda, Exportar + Filtros a la derecha -->
        <div class="row mb-4 align-items-center">
            <!-- Botón izquierdo -->
            <div class="col d-flex">
                <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal"
                    data-bs-target="#agregar-modal">
                    <i class="mdi mdi-account-multiple-plus-outline me-1"></i> Agregar Cliente
                </button>
            </div>

            <!-- Botones derechos -->
            <div class="col d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-warning px-4">
                    <i class="mdi mdi-cloud-print me-1"></i> Exportar
                </button>
                <button type="button" class="btn btn-info px-4">
                    <i class="mdi mdi-account-filter me-1"></i> Filtros
                </button>
            </div>
        </div>

        <!-- Tabla de usuarios -->
        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Correo Electronico</th>
                    <th>Sociedades</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->username }}</td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->phone }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>
                        <button href="#" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#asignar-sociedad-modal-{{ $usuario->id }}">
                            Sociedades
                        </button>
                    </td>
                    <td class="table-action">
                        <a href="#" class="action-icon" data-bs-toggle="modal"
                            data-bs-target="#editar-modal-{{ $usuario->id }}">
                            <i class="mdi mdi-pencil"></i>
                        </a>
                        <a href="#" class="action-icon" data-bs-toggle="modal"
                            data-bs-target="#warning-alert-modal-{{ $usuario->id }}">
                            <i class="mdi mdi-delete"></i>
                        </a>
                        <a href="javascript:void(0);" class="action-icon" data-bs-toggle="modal" data-bs-target="#detalle-modal-{{ $usuario->id }}">
                            <i class="mdi mdi-eye"></i>
                        </a>

                    </td>
                </tr>

                <!-- Modal asignar sociedades -->
                <div class="modal fade" id="asignar-sociedad-modal-{{ $usuario->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('admin.cliente.sociedad.update', $usuario->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Asignar Sociedades a {{ $usuario->username }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>

                                <div class="modal-body">
                                    <!-- Selector para agregar -->
                                    <div class="mt-3">
                                        <label class="project-overview">Seleccionar Sociedad:</label>
                                        <div class="col-sm-9 d-flex">
                                            <select class="form-control select2" id="sociedad-select-{{ $usuario->id }}">
                                                <option value="">-- Selecciona --</option>
                                                @foreach ($sociedades as $soc)
                                                <option value="{{ $soc->id }}">{{ $soc->nombre_sociedad }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-primary"
                                                onclick="agregarSociedad({{ $usuario->id }})">Agregar</button>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- JSON oculto -->
                                    <input type="hidden" name="sociedades_json" id="sociedades-json-{{ $usuario->id }}">

                                    <!-- Lista de checkboxes -->
                                    <h6>Sociedades Asignadas:</h6>
                                    <div id="lista-sociedades-{{ $usuario->id }}">
                                        @php
                                        $asignadas = $idclientes
                                        ->where('id_cliente', $usuario->id)
                                        ->pluck('sociedad.nombre_sociedad', 'id_sociedad')
                                        ->toArray();
                                        @endphp

                                        @foreach ($asignadas as $idSociedad => $nombreSociedad)
                                        <div class="form-check">
                                            <input class="form-check-input sociedad-checkbox"
                                                type="checkbox"
                                                value="{{ $idSociedad }}"
                                                id="sociedad-{{ $usuario->id }}-{{ $idSociedad }}"
                                                checked
                                                onchange="actualizarJsonSociedades({{ $usuario->id }})">
                                            <label class="form-check-label"
                                                for="sociedad-{{ $usuario->id }}-{{ $idSociedad }}">
                                                {{ $nombreSociedad }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        actualizarJsonSociedades({
                            {
                                $usuario - > id
                            }
                        });
                    });
                </script>



                <!-- Modal de confirmación eliminar -->
                <div id="warning-alert-modal-{{$usuario->id}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-body p-4">
                                <div class="text-center">
                                    <i class="ri-alert-line h1 text-warning"></i>
                                    <h4 class="mt-2">¿Estás Seguro?</h4>
                                    <p class="mt-3">
                                        Esta acción resultará en la eliminación permanente de la información
                                        seleccionada.
                                        Una vez eliminada, no será posible recuperarla.
                                    </p>
                                    <form method="POST" action="{{ route('admin.user_society.destroy', $usuario->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-warning my-2">Confirmar</button>
                                        <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">Cancelar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal editar usuario -->
                <!-- Modal detalle usuario -->
                <div id="detalle-modal-{{$usuario->id}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title" style="color: black;">Detalle del Usuario</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <div class="ps-3 pe-3">

                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control bg-light border-0" value="{{ $usuario->nombre}}" readonly tabindex="-1">
                                    </div>

                                    <div class="mb-3">
                                        <label for="username" class="form-label">Nombre de Usuario</label>
                                        <input type="text" class="form-control bg-light border-0" value="{{ $usuario->username}}" readonly tabindex="-1">
                                    </div>

                                    <div class="mb-3">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="text" class="form-control bg-light border-0" value="{{ $usuario->phone}}" readonly tabindex="-1">
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Correo Electrónico</label>
                                        <input type="text" class="form-control bg-light border-0" value="{{ $usuario->email}}" readonly tabindex="-1">
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
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
                    <h4 class="modal-title" style="color: black;">Agregar Usuario</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ps-3 pe-3" action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="username-add" class="form-label">Nombre</label>
                            <input class="form-control" type="text" name="name_user" required
                                placeholder="Nombre">
                        </div>
                        <div class="mb-3">
                            <label for="apellido-add" class="form-label">Apellido</label>
                            <input class="form-control" type="text" name="lastname_user" required
                                placeholder="Apellido">
                        </div>
                        <div class="mb-3">
                            <label for="username-add" class="form-label">Nombre de Usuario</label>
                            <input class="form-control" type="text" name="username"
                                placeholder="Ingrese el nombre de usuario">
                        </div>
                        <div class="mb-3">
                            <label for="email-add" class="form-label">Correo Electrónico</label>
                            <input class="form-control" type="email" name="email" required
                                placeholder="john@deo.com">
                        </div>
                        <div class="mb-3">
                            <label for="phone-add" class="form-label">Teléfono</label>
                            <input class="form-control" type="text" name="phone"
                                placeholder="Ingrese el número de teléfono">
                        </div>
                        <div class="mb-3">
                            <label for="password-add" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <input class="form-control" type="password" required id="password-add" name="password"
                                    placeholder="Ingrese la contraseña">
                                <a class="btn btn-outline-secondary" type="button" onclick="document.getElementById('password-add').type = document.getElementById('password-add').type === 'password' ? 'text' : 'password'">
                                    <i class="mdi mdi-eye"></i>
                                </a>
                            </div>
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

</div> <!-- content -->
@endsection
<script>
    function agregarSociedad(userId) {
        const select = document.getElementById(`sociedad-select-${userId}`);
        const selectedValue = select.value;
        const selectedText = select.options[select.selectedIndex].text;

        if (!selectedValue) return;

        // Evitar duplicados
        if (document.getElementById(`sociedad-${userId}-${selectedValue}`)) {
            alert("Esta sociedad ya ha sido agregada.");
            return;
        }

        const listaDiv = document.getElementById(`lista-sociedades-${userId}`);

        // Crear checkbox dinámico
        const container = document.createElement('div');
        container.classList.add('form-check');

        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.className = 'form-check-input sociedad-checkbox';
        checkbox.value = selectedValue;
        checkbox.id = `sociedad-${userId}-${selectedValue}`;
        checkbox.checked = true;
        checkbox.setAttribute('onchange', `actualizarJsonSociedades(${userId})`);

        const label = document.createElement('label');
        label.className = 'form-check-label';
        label.htmlFor = checkbox.id;
        label.textContent = selectedText;

        container.appendChild(checkbox);
        container.appendChild(label);
        listaDiv.appendChild(container);

        actualizarJsonSociedades(userId);
    }

    function actualizarJsonSociedades(userId) {
        const checkboxes = document.querySelectorAll(`#lista-sociedades-${userId} .sociedad-checkbox`);
        const inputHidden = document.getElementById(`sociedades-json-${userId}`);

        const seleccionadas = [];
        checkboxes.forEach(cb => {
            if (cb.checked) {
                seleccionadas.push(cb.value);
            }
        });

        inputHidden.value = JSON.stringify(seleccionadas);
    }
</script>