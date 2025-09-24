<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Recuperar contraseña | Rensar Consulting</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/logo-dark-sm.png') }}">
    <link href="{{ asset('backend/assets/css/app-saas.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg pb-0">

    <div class="auth-fluid">
        <div class="auth-fluid-form-box">
            <div class="card-body d-flex flex-column h-100 gap-3">
                <div class="auth-brand d-flex justify-content-center align-items-center mb-4">
                    <a class="logo-dark">
                        <img src="{{ asset('backend/assets/images/logo-dark.png') }}" alt="logo" height="60">
                    </a>
                </div>

                <div class="my-auto">
                    <h4 class="mt-0">¿Olvidaste tu contraseña?</h4>
                    <p class="text-muted mb-4">
                        No hay problema. Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                    </p>

                    <!-- Estado de sesión -->
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input name="email" class="form-control @error('email') is-invalid @enderror" type="email" id="email" required value="{{ old('email') }}" autofocus>
                            @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-primary" type="submit">
                                <i class="mdi mdi-email-outline"></i> Enviar enlace de recuperación
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-muted">← Volver al inicio de sesión</a>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('manual.download') }}"
                                class="text-primary text-decoration-underline d-inline-flex align-items-center fw-semibold">
                                <i class="ri-download-line me-1"></i> Descargar Manual de restablecer contraseña
                            </a>
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

    <script src="{{ asset('backend/assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.min.js') }}"></script>

</body>

</html>