<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Restablecer contraseña | Rensar Consulting</title>
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
                    <h4 class="mt-0">Restablecer tu contraseña</h4>
                    <p class="text-muted mb-4">
                        Ingresa tu nueva contraseña para tu cuenta.
                    </p>

                    <!-- Estado de sesión -->
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <!-- Token de restablecimiento -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email', $request->email) }}"
                                required
                                autofocus
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nueva contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva contraseña</label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                required
                                autocomplete="new-password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirmar contraseña -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                required
                                autocomplete="new-password"
                                class="form-control @error('password_confirmation') is-invalid @enderror">
                            @error('password_confirmation')
                            <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-primary" type="submit">
                                <i class="mdi mdi-lock-reset"></i> Restablecer contraseña
                            </button>
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
