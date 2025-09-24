<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Registrarse | Rensar Consulting</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/logo-dark-sm.png') }}">

    <!-- Theme Config Js -->
    <script src="{{ asset('backend/assets/js/hyper-config.js') }}"></script>

    <!-- App css -->
    <link href="{{ asset('backend/assets/css/app-saas.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg pb-0">

    <div class="auth-fluid">
        <!-- Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="card-body d-flex flex-column h-100 gap-3">

                <!-- Logo -->
                <div class="auth-brand d-flex justify-content-center align-items-center mb-4">
                    <a  class="logo-dark">
                        <span><img src="{{ asset('backend/assets/images/logo-dark.png') }}" alt="dark logo" height="60"></span>
                    </a>
                    <a  class="logo-light">
                        <span><img src="{{ asset('backend/assets/images/logo-light.png') }}" alt="logo" height="22"></span>
                    </a>
                </div>

                <div class="my-auto">
                    <!-- title-->
                    <h4 class="mt-3">Regístrate gratis</h4>
                    <p class="text-muted mb-4">¿No tienes cuenta? Crea tu cuenta; solo te llevará un minuto.</p>

                    <!-- form -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nombres Completos</label>
                            <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellidos Completos</label>
                            <input class="form-control" type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" required>
                            @error('apellido')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="email" class="form-label">Dirección de correo electrónico</label>
                            <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input class="form-control" type="password" id="password" name="password" required>
                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-signup" required>
                                <label class="form-check-label" for="checkbox-signup">
                                    Acepto <a href="#" class="text-muted">Términos y condiciones</a>
                                </label>
                            </div>
                        </div>

                        <div class="mb-3 d-grid text-center">
                            <button class="btn btn-primary" type="submit">
                                <i class="mdi mdi-account-circle"></i> Registrarse
                            </button>
                        </div>
                    </form>
                    <!-- end form-->
                </div>

                <!-- Footer-->
                <footer class="footer footer-alt">
                    <p class="text-muted">¿Ya tienes cuenta? 
                        <a href="{{ route('login') }}" class="text-muted ms-1"><b>Iniciar Sesión</b></a>
                    </p>
                </footer>

            </div> <!-- end .card-body -->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial">
                <h2 class="mb-3">Lidera la transformación digital con SAP</h2>
                <p class="lead"><i class="mdi mdi-format-quote-open"></i>  Especialistas en consultoría SAP. <i class="mdi mdi-format-quote-close"></i></p>
                <p>- Portal de Rensar Consulting</p>
            </div>
        </div>
        <!-- end Auth fluid right content -->
    </div>
    <!-- end auth-fluid-->

    <!-- Vendor js -->
    <script src="{{ asset('backend/assets/js/vendor.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('backend/assets/js/app.min.js') }}"></script>

</body>

</html>
