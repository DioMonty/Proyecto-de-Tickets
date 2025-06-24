<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login | Rensar Consulting</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('backend/assets/images/logo-dark-sm.png')}}">

    <!-- Theme Config Js -->
    <script src="{{asset('backend/assets/js/hyper-config.js')}}"></script>

    <!-- App css -->
    <link href="{{asset('backend/assets/css/app-saas.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg pb-0">

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="card-body d-flex flex-column h-100 gap-3">

                <!-- Logo -->
                <div class="auth-brand d-flex justify-content-center align-items-center mb-4">
                    <a href="index.html" class="logo-dark">
                        <span><img src="{{asset('backend/assets/images/logo-dark.png')}}" alt="dark logo" height="60"></span>
                    </a>
                    <a href="index.html" class="logo-light">
                        <span><img src="{{asset('backend/assets/images/logo-dark.pngs')}}" alt="logo" height="22"></span>
                    </a>
                </div>

                <div class="my-auto">
                    <!-- title-->
                    <h4 class="mt-0">Iniciar sesión</h4>
                    <p class="text-muted mb-4">Introduzca su dirección de correo electrónico y contraseña para acceder a la cuenta.</p>

                    <!-- form -->
                    <form method="POST" action="{{route('login')}}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Dirección de correo electrónico</label>
                            <input name="email"class="form-control" type="email" id="email"  placeholder="Introduce tu correo electrónico" required autofocus value="{{old('email')}}">
                            <div class="invalid-feedback">
                                Por favor, ingrese su correo electronico.
                            </div>
                            @if ($errors->has('email'))
                                <code>{{$errors->first('email')}}</code>
                            @endif
                        </div>
                        <div class="mb-3">
                            <a href="pages-recoverpw-2.html" class="text-muted float-end"><small>¿Olvidaste la contraseña?</small></a>
                            <label for="password" class="form-label">Contraseña</label>
                            <input name="password" class="form-control" type="password"  id="password" required autofocus placeholder="Introduce tu contraseña">
                            <div class="invalid-feedback">
                                Por favor, ingrese su contraseña.
                            </div>
                            @if ($errors->has('password'))
                                <code>{{$errors->first('password')}}</code>
                            @endif
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                <label class="form-check-label" for="checkbox-signin">Recordarme</label>
                            </div>
                        </div>
                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-login"></i> Ingresar al Sistema </button>
                        </div>
                    </form>
                    <!-- end form-->
                </div>

                <!-- Footer-->
                <footer class="footer footer-alt">
                    <p class="text-muted">¿No tienes una cuenta? <a href="pages-register-2.html" class="text-muted ms-1"><b>Registrate</b></a></p>
                </footer>

            </div> <!-- end .card-body -->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial">
                <h2 class="mb-3">Lidera la transformación digital con SAP</h2>
                <p class="lead"><i class="mdi mdi-format-quote-open"></i> Especialistas en consultoría SAP que potencian la eficiencia y el crecimiento de tu negocio! . <i class="mdi mdi-format-quote-close"></i>
                </p>
                <p>
                    - Portal de Rensar Consulting
                </p>
            </div> <!-- end auth-user-testimonial-->
        </div>
        <!-- end Auth fluid right content -->
    </div>
    <!-- end auth-fluid-->
    <!-- Vendor js -->
    <script src="{{asset('backend/assets/js/vendor.min.js')}}"></script>

    <!-- App js -->
    <script src="{{asset('backend/assets/js/app.min.js')}}"></script>

</body>

</html>