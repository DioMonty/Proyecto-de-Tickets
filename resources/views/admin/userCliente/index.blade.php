@extends('admin.layouts.master')

@section('title', 'Usuario Cliente | Rensar Consulting')

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
                            <li class="breadcrumb-item"><a href="#"><i class="uil-home-alt"></i> Gestion de Usuario</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Usuario Cliente</li>
                        </ol>
                    </nav>
                    </div>
                    <h4 class="page-title">Usuario Cliente</h4>
                    <p class="mt-2 mb-3 text-muted">
                        En esta pantalla se podrá visualizar y gestionar la información de los clientes
                        registrados en el sistema.
                    </p>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-stat">
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregar-modal">
                        <i class="mdi mdi-account-multiple-plus-outline me-1"></i> Agregar Usuario Cliente
                    </button>
                    <button type="button" class="btn btn-warning">
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
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Correo Electronico</th>
                    <th>Cliente</th>
                    <th>Sociedades</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @forelse($usuarios as $usuario)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $usuario->username }}</td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->phone }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>
                        @if($usuario->cliente_asignado)
                            {{ $usuario->cliente_asignado->descripcion }}
                        @else
                            <span class="text-muted">No asignado</span>
                        @endif
                    </td>
                    <td>
                        <button href="#" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#asignar-sociedad-modal-{{ $usuario->id }}">
                            Sociedades
                        </button>
                    </td>
                    <td class="table-action">
                        <a href="#" class="action-icon" data-bs-toggle="modal"
                            data-bs-target="#editar-modal-{{ $usuario->id }}">
                            <i class="mdi mdi-pencil" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Editar"></i>
                        </a>
                        <a href="javascript:void(0);" class="action-icon" data-bs-toggle="modal" data-bs-target="#detalle-modal-{{ $usuario->id }}">
                            <i class="mdi mdi-eye" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Detalle"></i>
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
                                    <!-- Selector de Cliente -->
                                    <div class="mt-3">
                                        <label class="project-overview">Seleccionar Cliente:</label>
                                        <select class="form-control"
                                            id="cliente-select-{{ $usuario->id }}"
                                            @if($usuario->cliente_asignado) disabled @endif>
                                            <option value="">-- Selecciona un cliente --</option>
                                            @foreach ($clientes as $cliente)
                                                <option value="{{ $cliente->id }}"
                                                    @if($usuario->cliente_asignado && $usuario->cliente_asignado->id == $cliente->id) selected @endif>
                                                    {{ $cliente->descripcion }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>

                                    <!-- Selector de Sociedad -->
                                    <div class="mt-3">
                                        <label class="project-overview">Seleccionar Sociedad:</label>
                                        <div class="col-sm-9 d-flex">
                                            <select class="form-control select2" id="sociedad-select-{{ $usuario->id }}">
                                                <option value="">-- Selecciona una sociedad --</option>
                                                {{-- Opciones serán cargadas dinámicamente --}}
                                            </select>
                                            <button type="button" class="btn btn-primary ms-2" onclick="agregarSociedad({{ $usuario->id }})">Agregar</button>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- JSON oculto -->
                                    <input type="hidden" name="id_cliente" id="input-cliente-id-{{ $usuario->id }}">
                                    <input type="hidden" name="sociedades_json" id="sociedades-json-{{ $usuario->id }}">

                                    <!-- Lista de sociedades asignadas -->
                                    <h6>Sociedades Asignadas:</h6>
                                    <div id="lista-sociedades-{{ $usuario->id }}">
                                        @php
                                            $asignadas = $idclientes
                                                ->where('id_usuario', $usuario->id)
                                                ->pluck('sociedad.nombre_sociedad', 'id_sociedad')
                                                ->toArray();
                                        @endphp

                                        @foreach ($asignadas as $idSociedad => $nombreSociedad)
                                            <div class="form-check">
                                                <input class="form-check-input sociedad-checkbox"
                                                    type="checkbox"
                                                    value="{{ $idSociedad }}"
                                                    data-cliente="{{ $usuario->id_cliente }}"
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
                document.addEventListener("DOMContentLoaded", function () {
                    const userId = {{ $usuario->id }};
                    const selectCliente = document.getElementById(`cliente-select-${userId}`);
                    const inputHiddenCliente = document.getElementById(`input-cliente-id-${userId}`);

                    // Actualizar input oculto si hay cliente preseleccionado
                    const clienteId = selectCliente.value;
                    if (clienteId) {
                        inputHiddenCliente.value = clienteId;
                        cargarSociedades(userId, clienteId);  // 👈 fuerza carga al inicio si ya está seleccionado
                    }

                    // Cargar al cambiar si el select está habilitado
                    if (!selectCliente.disabled) {
                        selectCliente.addEventListener('change', function () {
                            const newClienteId = this.value;
                            inputHiddenCliente.value = newClienteId;
                            cargarSociedades(userId, newClienteId);
                        });
                    }

                    // Inicializa JSON al cargar
                    actualizarJsonSociedades(userId);
                });
                </script>

                
                                <!-- Modal detalle usuario -->
                <div id="detalle-modal-{{$usuario->id}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title">Detalle del Usuario</h4>
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
                <!-- Modal editar usuario -->
                <div id="editar-modal-{{$usuario->id}}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title">Editar Usuario</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="ps-3 pe-3" action="{{ route('admin.user_society.update', $usuario->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Nombre</label>
                                        <input class="form-control" type="text" name="nombre" value="{{$usuario->nombre}}" required
                                            placeholder="Nombre del cliente">
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellido" class="form-label">Apellido</label>
                                        <input class="form-control" type="text" name="apellido" value="{{$usuario->apellido}}"
                                            placeholder="Apellido del cliente">
                                    </div>
                                    <div class="mb-3">
                                        <label for="username-add" class="form-label">Nombre de Usuario</label>
                                        <input class="form-control" type="text" name="username" value="{{$usuario->username}}" required
                                            placeholder="Ingrese el nombre de usuario">
                                    </div>
                                    <div class="mb-3">
                                        <label for="rol" class="form-label">Telefono</label>
                                        <input class="form-control" type="text" name="phone" value="{{$usuario->phone}}"
                                            placeholder="Ingrese el telefono">
                                    </div>
                                    <div class="mb-3">
                                        <label for="emailaddress" class="form-label">Correo Electrónico</label>
                                        <input class="form-control" type="email" name="email" value="{{$usuario->email}}" required
                                            placeholder="john@deo.com">
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Cerrar</button>
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
                    <h4 class="modal-title">Agregar Usuario Cliente</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ps-3 pe-3" action="{{ route('admin.user_society.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="username-add" class="form-label">Nombre</label>
                            <input class="form-control" type="text" name="name_user" required
                                placeholder="Nombre">
                        </div>
                        <div class="mb-3">
                            <label for="apellido-add" class="form-label">Apellido</label>
                            <input class="form-control" type="text" name="lastname_user"
                                placeholder="Apellido">
                        </div>
                        <div class="mb-3">
                            <label for="username-add" class="form-label">Nombre de Usuario</label>
                            <input class="form-control" type="text" name="username"required
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


<script>

function cargarSociedades(userId, clienteId) {
    const sociedadSelect = document.getElementById(`sociedad-select-${userId}`);
    sociedadSelect.innerHTML = '<option value="">-- Selecciona una sociedad --</option>';

    if (!clienteId) return;

    fetch(`{{ url('api/sociedades_por_cliente') }}/${clienteId}`)
        .then(response => response.json())
        .then(data => {
            data.forEach(soc => {
                const option = document.createElement('option');
                option.value = soc.id;
                option.textContent = soc.nombre_sociedad;
                sociedadSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error("Error al cargar sociedades:", error);
            alert("Hubo un problema al cargar las sociedades.");
        });
}

function agregarSociedad(userId) {
    const select = document.getElementById(`sociedad-select-${userId}`);
    const selectedValue = select.value;
    const selectedText = select.options[select.selectedIndex]?.text;
    const clienteSelect = document.getElementById(`cliente-select-${userId}`);
    const clienteId = clienteSelect.value;

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
    checkbox.setAttribute('data-cliente', clienteId);

    const label = document.createElement('label');
    label.className = 'form-check-label';
    label.htmlFor = checkbox.id;
    label.textContent = selectedText;

    container.appendChild(checkbox);
    container.appendChild(label);
    listaDiv.appendChild(container);

    // Actualizar JSON
    actualizarJsonSociedades(userId);

    // Bloquear el cliente si no está ya bloqueado
    if (!clienteSelect.hasAttribute('disabled')) {
        clienteSelect.setAttribute('disabled', 'true');
    }

    // También establecer el hidden para que se guarde correctamente
    const hiddenInput = document.getElementById(`input-cliente-id-${userId}`);
    hiddenInput.value = clienteId;
}


function actualizarJsonSociedades(userId) {
    const checkboxes = document.querySelectorAll(`#lista-sociedades-${userId} .sociedad-checkbox`);
    const inputHidden = document.getElementById(`sociedades-json-${userId}`);

    const seleccionadas = [];
    checkboxes.forEach(cb => {
        if (cb.checked) {
            seleccionadas.push({
                id_sociedad: cb.value,
                id_cliente: cb.dataset.cliente
            });
        }
    });

    inputHidden.value = JSON.stringify(seleccionadas);
}
</script>
@endsection
