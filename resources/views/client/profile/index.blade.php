@extends('client.layouts.master')

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
                                        <li class="breadcrumb-item"><a href="#"><i class="uil-home-alt"></i> Mi Cuenta </a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Informacion General</li>
                                    </ol>
                                </nav>
                    </div>
                    <h4 class="page-title">Mi Cuenta</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-4 col-lg-5">
                <div class="card text-center">
                    <div class="card-body">
                        <img src="{{asset(Auth::user()->image)}}" class="rounded-circle avatar-lg img-thumbnail"
                            alt="profile-image">

                        <h4 class="mb-0 mt-2">{{Auth::user()->name}}</h4>
                        <p class="text-muted font-14">{{Auth::user()->role}}</p>

                        <div class="text-start mt-3">
                            <p class="text-muted mb-2 font-13"><strong>Telefono :</strong><span class="ms-2">{{ Auth::user()->phone ?? 'Sin número'}}</span></p>

                            <p class="text-muted mb-2 font-13"><strong>Correo Electronico :</strong> <span class="ms-2 ">{{Auth::user()->email}}</span></p>

                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card -->



            </div> <!-- end col-->

            <div class="col-xl-8 col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                        </ul>
                        <div class="tab-content">
                            <!-- end about me section content -->
                            <div class="tab-pane show active" id="settings">
                                <form method="POST" action="{{route('client.profile.update')}}" enctype="multipart/form-data">
                                    @csrf
                                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle me-1"></i> Informacion Personal</h5>
                                    <div class="profile-widget-header">
                                        <img src="{{asset(Auth::user()->image)}}" alt="image"
                                            class="rounded-circle avatar-lg img-thumbnail ">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstname" class="form-label">Imagen</label>
                                                <input name="image" type="file" class="form-control">
                                            </div>
                                        </div>

                                    </div> <!-- end row -->

                                    @php
                                    $completo = Auth::user()->name;
                                    $nameParts = explode(',', $completo, 2);
                                    $nombre = isset($nameParts[0]) ? trim($nameParts[0]) : '';
                                    $apellido = isset($nameParts[1]) ? trim($nameParts[1]) : '';    
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstname" class="form-label">Nombres</label>
                                                <input name="name" type="text" class="form-control" id="firstname" placeholder="Ingresa tu nombre" value="{{$nombre}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="apellido" class="form-label">Apellidos</label>
                                                <input name="apellido" type="text" class="form-control" id="apellido"
                                                placeholder="Ingresa tus apellidos"
                                                value="{{ $apellido }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="useremail" class="form-label">Direccion de Correo Electronico</label>
                                                <input name="email" type="email" class="form-control" id="useremail" placeholder="Ingresa tu correo electronico" value="{{Auth::user()->email}}">
                                            </div>
                                        </div>

                                    </div> <!-- end row -->

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i> Guardar Cambios</button>
                                    </div>
                                </form>
                            </div>
                            <!-- end settings content-->

                        </div> <!-- end tab-content -->
                    </div> <!-- end card body -->
                </div> <!-- end card -->
            </div> <!-- end col -->


            <div class="col-xl-8 col-lg-7 ms-auto">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                        </ul>
                        <div class="tab-content">
                            <!-- end about me section content -->
                            <div class="tab-pane show active">
                                @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                <span class="alert alert-danger">{{ $error }}</span>
                                @endforeach

                                @endif
                                <form method="POST" action="{{route('client.password.update')}}" enctype="multipart/form-data">
                                    @csrf
                                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle me-1"></i> Actualizar Contraseñas</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="current_password" class="form-label">Contraseña Actual</label>
                                                <div class="input-group input-group-merge">
                                                    <input name="current_password"
                                                        type="password"
                                                        id="current_password"
                                                        class="form-control"
                                                        placeholder="Ingresa tu contraseña actual">
                                                    <span class="input-group-text toggle-password" role="button">
                                                        <i class="mdi mdi-eye-off"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Nueva Contraseña</label>
                                                <div class="input-group input-group-merge">
                                                    <input name="password"
                                                        type="password"
                                                        id="password"
                                                        class="form-control"
                                                        placeholder="Ingresa tu nueva contraseña">
                                                    <span class="input-group-text toggle-password" role="button">
                                                        <i class="mdi mdi-eye-off"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                                                <div class="input-group input-group-merge">
                                                    <input name="password_confirmation"
                                                        type="password"
                                                        id="password_confirmation"
                                                        class="form-control"
                                                        placeholder="Repite tu nueva contraseña">
                                                    <span class="input-group-text toggle-password" role="button">
                                                        <i class="mdi mdi-eye-off"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i>Confirmar la Contraseña</button>
                                    </div>
                                </form>
                            </div> <!-- end row -->
                            <!-- end row -->
                        </div>
                        <!-- end settings content-->

                    </div> <!-- end tab-content -->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

    </div>
    <!-- end row-->

</div>
<!-- container -->

</div>

<script>
document.addEventListener('click', function(e) {
    const toggle = e.target.closest('.toggle-password');
    if (!toggle) return;

    const input = toggle.closest('.input-group').querySelector('input');
    const icon = toggle.querySelector('i');

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("mdi-eye-off");
        icon.classList.add("mdi-eye");
    } else {
        input.type = "password";
        icon.classList.remove("mdi-eye");
        icon.classList.add("mdi-eye-off");
    }
});
</script>
@endsection