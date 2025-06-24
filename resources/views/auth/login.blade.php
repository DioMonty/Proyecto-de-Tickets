<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login | Rensar Consulting</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset('backend/assets/images/logo-dark-sm.png')}}">
    <link href="{{asset('backend/assets/css/app-saas.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg pb-0">

    <div class="auth-fluid">
        <div class="auth-fluid-form-box">
            <div class="card-body d-flex flex-column h-100 gap-3">
                <div class="auth-brand d-flex justify-content-center align-items-center mb-4">
                    <a class="logo-dark">
                        <img src="{{asset('backend/assets/images/logo-dark.png')}}" alt="logo" height="60">
                    </a>
                </div>

                <div class="my-auto">
                    <h4 class="mt-0">Iniciar sesión</h4>
                    <p class="text-muted mb-4">Introduzca su dirección de correo electrónico y contraseña para acceder a la cuenta.</p>

                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Direccion de Correo electrónico</label>
                            <input name="email" class="form-control @error('email') is-invalid @enderror" type="email" id="email" required value="{{ old('email') }}" autofocus>
                            @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <a href="{{ route('password.request') }}" class="text-muted float-end"><small>¿Olvidaste la contraseña?</small></a>
                            <label for="password" class="form-label">Contraseña</label>
                            <input name="password" class="form-control @error('password') is-invalid @enderror" type="password" id="password" required>
                            @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input name="remember" type="checkbox" class="form-check-input" id="checkbox-signin">
                                <label class="form-check-label" for="checkbox-signin">Recordarme</label>
                            </div>
                        </div>

                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-login"></i> Ingresar al Sistema </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial">
                <h2 class="mb-3">Lidera la transformación digital con SAP</h2>
                <p class="lead"><i class="mdi mdi-format-quote-open"></i> Especialistas en consultoría SAP. <i class="mdi mdi-format-quote-close"></i></p>
                <p>- Portal de Rensar Consulting</p>
            </div>
        </div>
    </div>

    <script src="{{asset('backend/assets/js/vendor.min.js')}}"></script>
    <script src="{{asset('backend/assets/js/app.min.js')}}"></script>

</body>

</html>