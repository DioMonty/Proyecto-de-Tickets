@extends('consultor.layouts.master')

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="uil-home-alt"></i> Dashboard </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Panel de Control</li>
                        </ol>
                    </nav>
                </div>
                <h4 class="page-title">Panel de Control</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <!-- Columna izquierda: tarjeta grande -->
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <!-- Encabezado con icono -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm">
                                <span class="avatar-title bg-primary-lighten text-primary rounded">
                                    <i class="ri-stack-line font-24"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <a href="javascript:void(0);" class="font-16 fw-bold text-secondary">
                                REQUERIMIENTOS TOTALES
                                <i class="mdi mdi-checkbox-marked-circle-outline text-success"></i>
                            </a>
                            <p class="text-muted mb-0">Resumen general del último trimestre</p>
                        </div>
                    </div>

                    <!-- Estado -->
                    <span class="badge badge-lg bg-light text-secondary rounded-pill me-1">En
                        crecimiento</span>
                    <span class="font-12 fw-semibold text-muted">
                        <i class="mdi mdi-clock-time-four me-1"></i> Actualizado en tiempo real
                    </span>

                    <!-- Footer con mensaje -->
                    <div class="mt-3">
                        <p class="text-muted fw-semibold mb-1">Resumen</p>
                        <p class="text-muted mb-0">
                            Este periodo muestra un crecimiento constante en los requerimientos,
                            reflejando un mayor nivel de actividad y participación de las áreas
                            involucradas.
                        </p>
                    </div>

                    <!-- Footer con métricas -->
                    <div class="row mt-3">
                        <div class="col-6">
                            <p class="text-muted fw-semibold mb-1">Cantidad</p>
                            <h2 class="m-b-20">{{ $estados->totales ?? 0 }}</h2>
                        </div>
                        <div class="col-6 text-end">
                            <p class="text-muted fw-semibold mb-1">Comparación</p>
                            <span class="badge bg-primary fs-6">+{{ $estados->mes ?? 0 }}</span>
                            <p class="text-muted mb-0">vs periodo anterior</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Columna derecha: tarjetas 2x2 -->
        <div class="col-lg-6">
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="ri-time-line float-end text-muted fs-2 " style="opacity: 0.4;"></i>
                            <h6 class="text-muted text-uppercase mt-2">Tickets Pendientes</h6>
                            <h2 class="m-b-20">{{ $estados->pendientes ?? 0 }}</h2>
                            <span class="badge bg-danger">Live</span>
                            <span class="text-muted">Actualizado en tiempo real</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="ri-calculator-line float-end text-muted fs-2 " style="opacity: 0.4;"></i>
                            <h6 class="text-muted text-uppercase mt-2">Tickets Estimados</h6>
                            <h2 class="m-b-20">{{ $estados->estimados ?? 0 }}</h2>
                            <span class="badge bg-danger">Live</span>
                            <span class="text-muted">Actualizado en tiempo real</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 mb-3">
                    <div class="card  h-100">
                        <div class="card-body">
                            <i class="ri-check-double-line float-end text-muted fs-2 " style="opacity: 0.4;"></i>
                            <h6 class="text-muted text-uppercase mt-2">Tickets Aprobados</h6>
                            <h2 class="m-b-20">{{ $estados->aprobados ?? 0 }}</h2>
                            <span class="badge bg-danger">Live</span>
                            <span class="text-muted">Actualizado en tiempo real</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="ri-todo-line float-end text-muted fs-2 " style="opacity: 0.4;"></i>
                            <h6 class="text-muted text-uppercase mt-2">Tickets Planificados</h6>
                            <h2 class="m-b-20">{{ $estados->planificados ?? 0 }}</h2>
                            <span class="badge bg-danger">Live</span>
                            <span class="text-muted">Actualizado en tiempo real</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-sm-6 col-lg-3">
                            <div
                                class="card rounded-0 shadow-none m-0 card tilebox-one border-start border-light">
                                <div class="card-body">
                                    <i class="ri-error-warning-line float-end text-muted"></i>
                                    <h6 class="text-muted text-uppercase mt-2">Tickets Observados
                                    </h6>
                                    <h2 class="m-b-20">{{ $estados->obserbados ?? 0 }}</h2>
                                    <span class="badge bg-danger">Live</span>
                                    <span class="text-muted">Actualizado en tiempo real</span>
                                </div> <!-- end card-body-->
                            </div> <!--end card-->
                        </div><!-- end col -->

                        <div class="col-sm-6 col-lg-3">
                            <div
                                class="card rounded-0 shadow-none m-0 card tilebox-one border-start border-light">
                                <div class="card-body">
                                    <i class="ri-flask-line float-end text-muted"></i>
                                    <h6 class="text-muted text-uppercase mt-2">Tickets
                                        Pruebas Cliente</h6>
                                    <h2 class="m-b-20">{{ $estados->prueba_cliente ?? 0 }}</h2>
                                    <span class="badge bg-danger">Live</span>
                                    <span class="text-muted">Actualizado en tiempo real</span>
                                </div> <!-- end card-body-->
                            </div> <!--end card-->
                        </div><!-- end col -->

                        <div class="col-sm-6 col-lg-3">
                            <div
                                class="card rounded-0 shadow-none m-0 card tilebox-one border-start border-light">
                                <div class="card-body">
                                    <i class="ri-lock-line float-end text-muted"></i>
                                    <h6 class="text-muted text-uppercase mt-2">Tickets Cerrados
                                    </h6>
                                    <h2 class="m-b-20">{{ $estados->cerrados ?? 0 }}</h2>
                                    <span class="badge bg-danger">Live</span>
                                    <span class="text-muted">Actualizado en tiempo real</span>
                                </div> <!-- end card-body-->
                            </div> <!--end card-->
                        </div><!-- end col -->
                        <div class="col-sm-6 col-lg-3">
                            <div
                                class="card rounded-0 shadow-none m-0 card tilebox-one border-start border-light">
                                <div class="card-body">
                                    <i class="ri-close-circle-line float-end text-muted"></i>
                                    <h6 class="text-muted text-uppercase mt-2">Tickets Cancelados
                                    </h6>
                                    <h2 class="m-b-20">{{ $estados->cancelados ?? 0 }}</h2>
                                    <span class="badge bg-danger">Live</span>
                                    <span class="text-muted">Actualizado en tiempo real</span>
                                </div> <!-- end card-body-->
                            </div> <!--end card-->
                        </div><!-- end col -->

                    </div> <!-- end row -->
                </div>
            </div> <!-- end card-box-->
        </div> <!-- end col-->
    </div>


    
    
    <!-- end row-->
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Estados de Tickets</h4>
                    <div dir="ltr">
                        <div id="simple-pie" class="apex-charts"
                            data-colors="#727cf5,#6c757d,#0acf97,#fa5c7c,#ffbc00"></div>
                    </div>
                </div>
                <!-- end card body-->
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Total de Facturas</h4>
                    <div dir="ltr">
                        <div id="gradient-donut" class="apex-charts" data-colors="#0acf97,#fa5c7c,#ffbc00"></div>
                    </div>
                </div>
            <!-- end card body-->
            </div>
        <!-- end card -->
        </div>
    </div>
    <!-- end row-->
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-4">Total de Tickets</h4>
                <div dir="ltr">
                    <div id="line-chart" class="apex-charts" data-colors="#ffbc00"></div>
                </div>
            </div>
            <!-- end card body-->
        </div>
        <!-- end card -->
    </div>

    

    <div class="row">
        <div class="col-lg-4">
            <div class="card text-white bg-info overflow-hidden">
                <div class="card-body">
                    <div class="toll-free-box text-center">
                        <h4> <i class="mdi mdi-deskphone"></i> Email: azambrano@rensar-fac.com</h4>
                    </div>
                </div> <!-- end card-body-->
            </div>
        </div> <!-- end col-->

        <div class="col-lg-4">
            <div class="card text-white bg-danger overflow-hidden">
                <div class="card-body">
                    <div class="toll-free-box text-center">
                        <h4> <i class="mdi mdi-headset"></i> ¿Necesitas ayuda? Contáctanos.</h4>
                    </div>
                </div> <!-- end card-body-->
            </div>
        </div> <!-- end col-->

        <div class="col-lg-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="text-center">
                        <h4> <i class="mdi mdi-deskphone"></i> Llamanos al : +51 934 808 790 </h4>
                    </div>
                </div> <!-- end card-body-->
            </div>
        </div> <!-- end col-->
    </div>


</div> <!-- container -->

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.0/dayjs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.0/plugin/quarterOfYear.min.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // === PIE CHART ===
        var pieColors = ["#727cf5", "#6c757d", "#0acf97", "#fa5c7c", "#ffbc00"],
            pieDataColors = $("#simple-pie").data("colors"),
            pieOptions = {
                chart: {
                    height: 320,
                    type: "pie"
                },
                series: [{{ $pendientes->count() }}, {{ $estimados->count() }}, {{ $aprobados->count() }}, {{ $cerrados->count() }}, {{ $facturados->count() }}],
                labels: ["Pendiente", "Estimado", "Aprobado", "Cerrado", "Facturado"],
                colors: (pieColors = pieDataColors ? pieDataColors.split(",") : pieColors),
                legend: {
                    show: true,
                    position: "bottom",
                    horizontalAlign: "center",
                    fontSize: "14px",
                    offsetY: 7
                },
                responsive: [{
                    breakpoint: 600,
                    options: {
                        chart: {
                            height: 240
                        },
                        legend: {
                            show: false
                        }
                    }
                }]
            };
        new ApexCharts(document.querySelector("#simple-pie"), pieOptions).render();

    var colors = ["#0acf97", "#fa5c7c", "#ffbc00"],
        dataColors = $("#gradient-donut").data("colors"),
        options = {
            chart: {
                height: 320,
                type: "donut"
            },
            series: [{{ $oc->count() }}, {{ $bolsa->count() }}, {{ $cerrados->count() }}],
            legend: {
                show: true,
                position: "bottom",
                horizontalAlign: "center",
                verticalAlign: "middle",
                floating: false,
                fontSize: "14px",
                offsetX: 0,
                offsetY: 7,
            },
            labels: ["Orden de Compra", "Bolsa", "Sin Facturar"],
            colors: (colors = dataColors ? dataColors.split(",") : colors),
            responsive: [{
                breakpoint: 600,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: false
                    }
                },
            }],
            fill: {
                type: "gradient"
            },
        };

    var chart = new ApexCharts(
        document.querySelector("#gradient-donut"),
        options
    );
    chart.render();
    
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        var colors = ["#ffbc00"],
            dataColors = document.querySelector("#line-chart").getAttribute("data-colors"),
            options = {
                chart: { 
                    height: 380, 
                    type: "line", 
                    zoom: { enabled: false } 
                },
                dataLabels: { enabled: false },
                colors: dataColors ? dataColors.split(",") : colors,
                stroke: { width: [4], curve: "straight" },
                series: [
                    { 
                        name: "Tickets", 
                        data: [{{ $ticketsPorMes[1] }}, {{ $ticketsPorMes[2] }}, {{ $ticketsPorMes[3] }}, {{ $ticketsPorMes[4] }}, {{ $ticketsPorMes[5] }}, {{ $ticketsPorMes[6] }}, {{ $ticketsPorMes[7] }}, {{ $ticketsPorMes[8] }}, {{ $ticketsPorMes[9] }}, {{ $ticketsPorMes[10] }}, {{ $ticketsPorMes[11] }}, {{ $ticketsPorMes[12] }}] 
                    },
                ],
                title: { 
                    text: "Tickets Por Mes", 
                    align: "center" 
                },
                grid: {
                    row: { colors: ["transparent", "transparent"], opacity: 0.2 },
                    borderColor: "#f1f3fa",
                },
                xaxis: {
                    categories: [
                        "Enero","Febrero","Marzo","Abril","Mayo","Junio",
                        "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre",
                    ],
                },
                responsive: [
                    {
                        breakpoint: 600,
                        options: { 
                            chart: { toolbar: { show: false } }, 
                            legend: { show: false } 
                        },
                    },
                ],
            };

        var chart = new ApexCharts(document.querySelector("#line-chart"), options);
        chart.render();
    });
</script>

<script>
    sessionStorage.setItem('justLoggedIn', '1');
</script>


@endsection

