@extends('consultor.layouts.master')

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
                                <li class="breadcrumb-item"><a href="#"><i class="uil-home-alt"></i> Soporte </a></li>
                                <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                            </ol>
                        </nav>
                    </div>
                    <h4 class="page-title">FAQ</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->


        <div class="row">
            <div class="col-sm-12">
                <div class="text-center">
                    <h3 class="">Preguntas frecuentes</h3>
                    <p class="text-muted mt-3"> En esta sección encontrarás respuestas rápidas a las dudas
                        más comunes sobre nuestra plataforma. <br />Queremos que tu experiencia sea sencilla
                        y
                        segura, por eso reunimos aquí la <br />información que necesitas para usar nuestros
                        servicios sin complicaciones.</p>
                    <a href="{{ route('manual.download') }}" class="btn btn-warning btn-sm mt-2">
                        <i class="mdi mdi-download me-1"></i>
                        Descargar información de soporte
                    </a>
                    <button type="button" class="btn btn-success btn-sm mt-2" data-bs-toggle="popover"
                        data-bs-placement="right" data-bs-custom-class="success-popover"
                        data-bs-title="Correo Electronico" data-bs-content="azambrano@rensar-fac.com.">
                        <i class="mdi mdi-email-outline me-1"></i>
                        Envíenos su pregunta por correo
                        electrónico
                    </button>
                </div>
            </div><!-- end col -->
        </div><!-- end row -->


        <div class="container-fluid mt-4 mb-4">
            <div class="row justify-content-center">
                <div class="col-12" style="max-width: 1100px;">
                    <div class="row g-3">

                        <!-- COLUMNA IZQUIERDA (4 preguntas) -->
                        <div class="col-md-6">
                            <div class="accordion custom-accordion" id="accordion-left">

                                <!-- Pregunta 1 -->
                                <div class="card mb-2">
                                    <div class="card-header" id="headingLeft1">
                                        <h5 class="m-0">
                                            <a class="custom-accordion-title d-block py-1"
                                                data-bs-toggle="collapse" href="#collapseLeft1"
                                                aria-expanded="true" aria-controls="collapseLeft1">

                                                Q. ¿Cómo cambio mi contraseña?
                                                <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseLeft1" class="collapse" aria-labelledby="headingLeft1"
                                        data-bs-parent="#accordion-left">
                                        <div class="card-body">Para cambiar tu contraseña, ingresa a la
                                            sección "Mi cuenta" en la parte superior de la plataforma. Una
                                            vez dentro, desplázate hacia abajo hasta encontrar el apartado
                                            "Actualizar contraseña". Allí deberás ingresar tu contraseña
                                            actual, la nueva contraseña y su confirmación antes de guardar
                                            los cambios.</div>
                                    </div>
                                </div>

                                <!-- Pregunta 2 -->
                                <div class="card mb-2">
                                    <div class="card-header" id="headingLeft2">
                                        <h5 class="m-0">
                                            <a class="custom-accordion-title collapsed d-block py-1"
                                                data-bs-toggle="collapse" href="#collapseLeft2"
                                                aria-expanded="false" aria-controls="collapseLeft2">
                                                Q. ¿Olvidé mi contraseña, qué hago?
                                                <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseLeft2" class="collapse" aria-labelledby="headingLeft2"
                                        data-bs-parent="#accordion-left">
                                        <div class="card-body">En la pantalla de inicio de sesión, haz clic
                                            en "Olvidé mi contraseña". Ingresa tu correo electrónico y
                                            recibirás un mensaje con un enlace para restablecer tu
                                            contraseña. Podrás crear una nueva sin necesidad de recordar la
                                            anterior.</div>
                                    </div>
                                </div>

                                <!-- Pregunta 3 -->
                                <div class="card mb-2">
                                    <div class="card-header" id="headingLeft3">
                                        <h5 class="m-0">
                                            <a class="custom-accordion-title collapsed d-block py-1"
                                                data-bs-toggle="collapse" href="#collapseLeft3"
                                                aria-expanded="false" aria-controls="collapseLeft3">
                                                Q. ¿Dónde puedo ver o actualizar mis datos personales?
                                                <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseLeft3" class="collapse" aria-labelledby="headingLeft3"
                                        data-bs-parent="#accordion-left">
                                        <div class="card-body">Accede a la sección "Mi cuenta", donde podrás
                                            actualizar tu nombre completo, correo electrónico y foto de
                                            perfil de forma sencilla.</div>
                                    </div>
                                </div>

                                <!-- Pregunta 4 -->
                                <div class="card mb-0">
                                    <div class="card-header" id="headingLeft4">
                                        <h5 class="m-0">
                                            <a class="custom-accordion-title collapsed d-block py-1"
                                                data-bs-toggle="collapse" href="#collapseLeft4"
                                                aria-expanded="false" aria-controls="collapseLeft4">
                                                Q. ¿Cómo contacto con soporte?
                                                <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseLeft4" class="collapse" aria-labelledby="headingLeft4"
                                        data-bs-parent="#accordion-left">
                                        <div class="card-body">Puedes escribirnos directamente al correo
                                            azambrano@rensar-fac.com, indicando el motivo de tu consulta o
                                            problema. Nuestro equipo de soporte te responderá lo antes
                                            posible.</div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- COLUMNA DERECHA (4 preguntas) -->
                        <div class="col-md-6">
                            <div class="accordion custom-accordion" id="accordion-right">

                                <!-- Pregunta 5 -->
                                <div class="card mb-2">
                                    <div class="card-header" id="headingRight1">
                                        <h5 class="m-0">
                                            <a class="custom-accordion-title d-block py-1"
                                                data-bs-toggle="collapse" href="#collapseRight1"
                                                aria-expanded="true" aria-controls="collapseRight1">
                                                Q. ¿Qué hago si encuentro un error en el sistema?
                                                <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseRight1" class="collapse"
                                        aria-labelledby="headingRight1" data-bs-parent="#accordion-right">
                                        <div class="card-body">Si detectas un error, por favor envíanos un
                                            correo al azambrano@rensar-fac.com detallando el inconveniente.
                                            Esto nos ayudará a resolverlo rápidamente.</div>
                                    </div>
                                </div>

                                <!-- Pregunta 6 -->
                                <div class="card mb-2">
                                    <div class="card-header" id="headingRight2">
                                        <h5 class="m-0">
                                            <a class="custom-accordion-title collapsed d-block py-1"
                                                data-bs-toggle="collapse" href="#collapseRight2"
                                                aria-expanded="false" aria-controls="collapseRight2">
                                                Q. ¿Puedo cerrar sesión desde cualquier dispositivo?

                                                <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseRight2" class="collapse"
                                        aria-labelledby="headingRight2" data-bs-parent="#accordion-right">
                                        <div class="card-body">Sí, puedes cerrar sesión desde cualquier
                                            navegador o dispositivo usando la opción "Cerrar sesión" en el
                                            menú superior. Si olvidaste cerrar sesión en un equipo ajeno, te
                                            recomendamos cambiar tu contraseña para proteger tu cuenta.
                                        </div>
                                    </div>
                                </div>

                                <!-- Pregunta 7 -->
                                <div class="card mb-2">
                                    <div class="card-header" id="headingRight3">
                                        <h5 class="m-0">
                                            <a class="custom-accordion-title collapsed d-block py-1"
                                                data-bs-toggle="collapse" href="#collapseRight3"
                                                aria-expanded="false" aria-controls="collapseRight3">
                                                Q. ¿Mi información personal está segura?

                                                <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseRight3" class="collapse"
                                        aria-labelledby="headingRight3" data-bs-parent="#accordion-right">
                                        <div class="card-body">Sí. Utilizamos medidas de seguridad para
                                            proteger tu información. Tus datos personales y credenciales se
                                            manejan de forma confidencial y no se comparten con terceros sin
                                            tu consentimiento.</div>
                                    </div>
                                </div>

                                <!-- Pregunta 8 -->
                                <div class="card mb-0">
                                    <div class="card-header" id="headingRight4">
                                        <h5 class="m-0">
                                            <a class="custom-accordion-title collapsed d-block py-1"
                                                data-bs-toggle="collapse" href="#collapseRight4"
                                                aria-expanded="false" aria-controls="collapseRight4">
                                                Q. ¿Cómo puedo cambiar mi correo electrónico?
                                                <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseRight4" class="collapse"
                                        aria-labelledby="headingRight4" data-bs-parent="#accordion-right">
                                        <div class="card-body">Desde la sección "Mi cuenta", puedes
                                            actualizar tu correo electrónico. Solo ingresa la nueva
                                            dirección, confirma el cambio y guarda la información.</div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div> <!-- container -->

</div> <!-- content -->

@endsection