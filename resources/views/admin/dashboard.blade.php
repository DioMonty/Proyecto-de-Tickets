@extends('admin.layouts.master')

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
                                    <!-- Contenedor header card -->
                                    <!-- Contenedor header card -->
                                    <div
                                        class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
                                        <!-- Icono + texto -->
                                        <div class="d-flex align-items-center mb-2 mb-md-0">
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

                                        
                                        <style>
                                            /* ancho fijo */
                                            .dropdown-fixed {
                                                min-width: 180px; /* puedes ajustar este valor */
                                                width: 180px;
                                                text-align: left;
                                            }
                                        
                                            /* en pantallas pequeñas que ocupe todo */
                                            @media (max-width: 768px) {
                                                .dropdown-fixed {
                                                    width: 100% !important;
                                                    min-width: 100% !important;
                                                }
                                            }
                                        </style>
                                        
                                        <div class="order-first order-md-last mb-2 mb-md-0 text-md-end">
                                            <div class="btn-group w-100 w-md-auto">
                                                <button type="button"
                                                    class="btn btn-sm btn-success dropdown-toggle dropdown-fixed"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="ri-user-line me-1"></i> Seleccionar Cliente
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end dropdown-fixed">
                                                    <h6 class="dropdown-header">Clientes disponibles</h6>
                                                    
                                                    <!-- Opción para todos -->
                                                    <a class="dropdown-item cliente-option" href="#" data-id="0">
                                                        <i class="ri-user-line me-1"></i> Todos los clientes
                                                    </a>
                                        
                                                    <!-- Opciones dinámicas -->
                                                    @foreach ($clientes as $cliente)
                                                        <a class="dropdown-item cliente-option" href="#" data-id="{{ $cliente->id }}">
                                                            <i class="ri-user-line me-1"></i> {{ $cliente->descripcion }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
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
                                            <h2 class="m-b-20-cant-total">{{ $cantidad->totales ?? 0 }}</h2>
                                        </div>
                                        <div class="col-6 text-end">
                                            <p class="text-muted fw-semibold mb-1">Comparación</p>
                                            <span class="badge bg-primary fs-6"> +{{ $cantidad->completos_mes ?? 0 }}</span>
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
                                            <i class="ri-time-line float-end text-muted fs-2 "
                                                style="opacity: 0.4;"></i>
                                            <h6 class="text-muted text-uppercase mt-2">Tickets Pendientes</h6>
                                            <h2 class="m-b-20-pen">{{ $estados->pendientes ?? 0 }}</h2>
                                            <span class="badge bg-danger">Live</span>
                                            <span class="text-muted">Actualizado en tiempo real</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <i class="ri-calculator-line float-end text-muted fs-2 "
                                                style="opacity: 0.4;"></i>
                                            <h6 class="text-muted text-uppercase mt-2">Tickets Estimados</h6>
                                            <h2 class="m-b-20-esti">{{ $estados->estimados ?? 0 }}</h2>
                                            <span class="badge bg-danger">Live</span>
                                            <span class="text-muted">Actualizado en tiempo real</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <div class="card  h-100">
                                        <div class="card-body">
                                            <i class="ri-check-double-line float-end text-muted fs-2 "
                                                style="opacity: 0.4;"></i>
                                            <h6 class="text-muted text-uppercase mt-2">Tickets Aprobados</h6>
                                            <h2 class="m-b-20-apro">{{ $estados->aprobados ?? 0 }}</h2>
                                            <span class="badge bg-danger">Live</span>
                                            <span class="text-muted">Actualizado en tiempo real</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <i class="ri-todo-line float-end text-muted fs-2 "
                                                style="opacity: 0.4;"></i>
                                            <h6 class="text-muted text-uppercase mt-2">Tickets Planificados</h6>
                                            <h2 class="m-b-20-plan">{{ $estados->planificados ?? 0 }}</h2>
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
                                                    <h2 class="m-b-20-obse">{{ $estados->obserbados ?? 0 }}</h2>
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
                                                    <h2 class="m-b-20-prue">{{ $estados->prueba_cliente ?? 0 }}</h2>
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
                                                    <h2 class="m-b-20-cerr">{{ $estados->cerrados ?? 0 }}</h2>
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
                                                    <h2 class="m-b-20-canc">{{ $estados->cancelados ?? 0 }}</h2>
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
                    <h4 class="header-title">Todos los Usuarios</h4>
                    <div dir="ltr">
                        <div id="simple-donut" class="apex-charts"
                            data-colors="#39afd1,#ffbc00,#313a46,#fa5c7c,#0acf97"></div>
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
                <h4 class="header-title">Total de Tickets de Consultor</h4>
                <div dir="ltr">
                <div id="distributed-column"
                    data-colors="#727cf5,#6c757d,#0acf97,#fa5c7c,#ffbc00,#39afd1"
                    style="min-height:380px"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-4">Total de Facturas</h4>
                <div dir="ltr">
                    <div id="gradient-donut" class="apex-charts" data-colors="#0acf97,#fa5c7c,#ffbc00"></div>
                </div>
            </div>
        <!-- end card body-->
        </div>
    <!-- end card -->
    </div>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Total de estado por Consultor</h4>
                <div dir="ltr">
                    <div id="stacked-bar" class="apex-charts"
                    data-colors="#727cf5,#0acf97,#fa5c7c,#6c757d,#39afd1"></div>
                </div>
            </div>
        <!-- end card body-->
        </div>
    <!-- end card -->
    </div>
    
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-4">Tickets mensuales (Consultores ABAP)</h4>

                <div dir="ltr">
                    <div class="mt-3 chartjs-chart" style="height: 320px;">
                        <canvas id="dataset-example"
                        data-colors="#727cf5,#fa5c7c,#0acf97,#ffbc00,#f56f36,#8e44ad"></canvas>
                    </div>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->

    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-4">Tickets mensuales Facturados(Consultores ABAP)</h4>

                <div dir="ltr">
                    <div class="mt-3 chartjs-chart" style="height: 320px;">
                        <canvas id="dataset-example-facturados"
                        data-colors="#727cf5,#fa5c7c,#0acf97,#ffbc00,#f56f36,#8e44ad"></canvas>
                    </div>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->

    <!-- end row-->

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
                                        <h4> <i class="mdi mdi-deskphone"></i> Llamanos al : +51 934 808 790</h4>
                                    </div>
                                </div> <!-- end card-body-->
                            </div>
                        </div> <!-- end col-->
                    </div>

</div> <!-- container -->



<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.0/dayjs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.0/plugin/quarterOfYear.min.js"></script>
<!-- jQuery (solo si lo necesitas, si no, elimina el wrapper del script) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


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
                series: [{{ $pendientes->count() ?? null }}, {{ $estimados->count() ?? null }}, {{ $aprobados->count() ?? null }}, {{ $cerrados->count() ?? null }}, {{ $facturados->count() ?? null }}],
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

        // === DONUT CHART ===
        var donutColors = ["#39afd1", "#ffbc00", "#313a46"],
        donutDataColors = $("#simple-donut").data("colors"),
        donutOptions = {
            chart: {
                height: 320,
                type: "donut"
            },
            series: [{{ $administradores->count() ?? null }}, {{ $consultores->count() ?? null }}, {{ $users->count() ?? null }}],
            labels: ["Admin", "Consultores", "Clientes"],
            colors: (donutColors = donutDataColors ? donutDataColors.split(",") : donutColors),
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
    new ApexCharts(document.querySelector("#simple-donut"), donutOptions).render();
    var colors = ["#0acf97", "#fa5c7c", "#ffbc00"],
        dataColors = $("#gradient-donut").data("colors"),
        options = {
            chart: {
                height: 320,
                type: "donut"
            },
            series: [{{ $oc->count() ?? null }}, {{ $bolsa->count() ?? null }}, {{ $cerrados->count() ?? null }}],
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
            labels: ["Orden de Compra", "Bolsa", "Sin Factura"],
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
    document.addEventListener('DOMContentLoaded', function () {
    const el = document.querySelector('#distributed-column');
    if (!el) return;

  // lee colores desde data-colors (fallback si no existe)
    const dataColors = el.getAttribute('data-colors');
    const colors = dataColors
    ? dataColors.split(',').map(s => s.trim())
    : ["#727cf5","#6c757d","#0acf97","#fa5c7c","#ffbc00","#39afd1"];

    const options = {
    chart: {
        height: 380,
        type: 'bar',
        toolbar: { show: false },
        events: {
        click: function (event, chartContext, config) {
            console.log(event, chartContext, config);
        }
        }
    },
    colors: colors,
    plotOptions: {
        bar: { columnWidth: '45%', distributed: true }
    },
    dataLabels: { enabled: false },
    series: [{ data: [{{ $a->count() ?? null }}, {{ $b->count() ?? null }}, {{ $c->count() ?? null }}, {{ $d->count() ?? null }}, {{ $e->count() ?? null }}, {{ $f->count() ?? null }}] }],
    xaxis: {
        categories: ["Camila","Brisza","Keila","Diosanto","Bryan","Diego"],
        labels: { style: { colors: colors, fontSize: '14px' } }
    },
    legend: { offsetY: 7 },
    grid: {
        row: { colors: ['transparent','transparent'], opacity: 0.2 },
        borderColor: '#f1f3fa'
    }
    };

    const chart = new ApexCharts(el, options);
    chart.render();

  // Si el gráfico está en un tab/modal/collapse oculto al renderizar,
  // fuerza un reflow cuando se muestre:
    const triggerResize = () => window.dispatchEvent(new Event('resize'));
    document.addEventListener('shown.bs.tab', triggerResize);
    document.addEventListener('shown.bs.collapse', triggerResize);
    document.addEventListener('shown.bs.modal', triggerResize);
});
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Obtener colores desde el atributo data-colors del div
    var defaultColors = ["#727cf5", "#0acf97", "#fa5c7c", "#6c757d", "#ffb822", "#a700cd","#39afd1"];
    var dataColors = $("#stacked-bar").data("colors");
    var colors = defaultColors;

    var options = {
        chart: {
            height: 380,
            type: "bar",
            stacked: true,
            toolbar: { show: false }
        },
        plotOptions: {
            bar: { horizontal: true }
        },
        stroke: { show: false },
        series: [
            { name: "Pendiente", data: [{{ $pendientes_a->count() }}, {{ $pendientes_b->count() }}, {{ $pendientes_c->count() }}, {{ $pendientes_d->count() }}, {{ $pendientes_e->count() }}, {{ $pendientes_f->count() }}] },
            { name: "Estimado", data: [{{ $estimados_a->count() }}, {{ $estimados_b->count() }}, {{ $estimados_c->count() }}, {{ $estimados_d->count() }}, {{ $estimados_e->count() }}, {{ $estimados_f->count() }}] },
            { name: "Aprobado", data: [{{ $aprobados_a->count() }}, {{ $aprobados_b->count() }}, {{ $aprobados_c->count() }}, {{ $aprobados_d->count() }}, {{ $aprobados_e->count() }}, {{ $aprobados_f->count() }}] },
            { name: "Planificados", data: [{{ $planificados_a->count() }}, {{ $planificados_b->count() }}, {{ $planificados_c->count() }}, {{ $planificados_d->count() }}, {{ $planificados_e->count() }}, {{ $planificados_f->count() }}] },
            { name: "Observados", data: [{{ $observados_a->count() }}, {{ $observados_b->count() }}, {{ $observados_c->count() }}, {{ $observados_d->count() }}, {{ $observados_e->count() }}, {{ $observados_f->count() }}] },
            { name: "Prueba Cliente", data: [{{ $prueba_cliente_a->count() }}, {{ $prueba_cliente_b->count() }}, {{ $prueba_cliente_c->count() }}, {{ $prueba_cliente_d->count() }}, {{ $prueba_cliente_e->count() }}, {{ $prueba_cliente_f->count() }}] },
            { name: "Cerrado", data: [{{ $cerrados_a-> count() }}, {{ $cerrados_b-> count() }}, {{ $cerrados_c-> count() }}, {{ $cerrados_d-> count() }}, {{ $cerrados_e-> count() }}, {{ $cerrados_f-> count() }}] }
            
        ],
        xaxis: {
            categories: ['Camila', 'Brisza', 'Keila', 'Diosanto', 'Bryan', 'Diego'],
            labels: {
                formatter: function (val) {
                    return val; // aquí puedes modificar cómo se muestran los labels
                }
            }
        },
        yaxis: {
            title: { text: undefined }
        },
        colors: colors,
        tooltip: {
            y: {
                formatter: function (val) {
                    return val; // aquí puedes agregar sufijos como " tickets"
                }
            }
        },
        fill: { opacity: 1 },
        states: { hover: { filter: "none" } },
        legend: { position: "top", horizontalAlign: "center", offsetY: 10 },
        grid: { borderColor: "#f1f3fa" }
    };

    var chart = new ApexCharts(document.querySelector("#stacked-bar"), options);
    chart.render();
});

</script>

<script>
    function hexToRGB(e, a) {
        var t = parseInt(e.slice(1, 3), 16),
            o = parseInt(e.slice(3, 5), 16),
            n = parseInt(e.slice(5, 7), 16);
        return a
            ? "rgba(" + t + ", " + o + ", " + n + ", " + a + ")"
            : "rgb(" + t + ", " + o + ", " + n + ")";
    }

    (function ($) {
        "use strict";

        function initDatasetExample() {
            var ctx = document.getElementById("dataset-example");
            var colors = ctx.getAttribute("data-colors");
            colors = colors ? colors.split(",") : ["#727cf5,#fa5c7c,#0acf97,#ffbc00, #f56f36, #8e44ad"];

            new Chart(ctx.getContext("2d"), {
                type: "line",
                data: {
                    labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    datasets: [
                        {
                            label: "Camila",
                            data: [{{ $ticketsPorMes_a[1] }}, {{ $ticketsPorMes_a[2] }}, {{ $ticketsPorMes_a[3] }}, {{ $ticketsPorMes_a[4] }}, {{ $ticketsPorMes_a[5] }}, {{ $ticketsPorMes_a[6] }}, {{ $ticketsPorMes_a[7] }}, {{ $ticketsPorMes_a[8] }}, {{ $ticketsPorMes_a[9] }}, {{ $ticketsPorMes_a[10] }}, {{ $ticketsPorMes_a[11] }}, {{ $ticketsPorMes_a[12] }}],
                            borderColor: colors[0],
                            backgroundColor: hexToRGB(colors[0], 0.3),
                        },
                        {
                            label: "Brisza",
                            data: [{{ $ticketsPorMes_b[1] }}, {{ $ticketsPorMes_b[2] }}, {{ $ticketsPorMes_b[3] }}, {{ $ticketsPorMes_b[4] }}, {{ $ticketsPorMes_b[5] }}, {{ $ticketsPorMes_b[6] }}, {{ $ticketsPorMes_b[7] }}, {{ $ticketsPorMes_b[8] }}, {{ $ticketsPorMes_b[9] }}, {{ $ticketsPorMes_b[10] }}, {{ $ticketsPorMes_b[11] }}, {{ $ticketsPorMes_b[12] }}],
                            borderColor: colors[1],
                            fill: "-1",
                            backgroundColor: hexToRGB(colors[1], 0.3),
                        },
                        {
                            label: "Keila",
                            data: [{{ $ticketsPorMes_c[1] }}, {{ $ticketsPorMes_c[2] }}, {{ $ticketsPorMes_c[3] }}, {{ $ticketsPorMes_c[4] }}, {{ $ticketsPorMes_c[5] }}, {{ $ticketsPorMes_c[6] }}, {{ $ticketsPorMes_c[7] }}, {{ $ticketsPorMes_c[8] }}, {{ $ticketsPorMes_c[9] }}, {{ $ticketsPorMes_c[10] }}, {{ $ticketsPorMes_c[11] }}, {{ $ticketsPorMes_c[12] }}],
                            borderColor: colors[2],
                            fill: 1,
                            backgroundColor: hexToRGB(colors[2], 0.3),
                        },
                        {
                            label: "Diego",
                            data: [{{ $ticketsPorMes_f[1] }}, {{ $ticketsPorMes_f[2] }}, {{ $ticketsPorMes_f[3] }}, {{ $ticketsPorMes_f[4] }}, {{ $ticketsPorMes_f[5] }}, {{ $ticketsPorMes_f[6] }}, {{ $ticketsPorMes_f[7] }}, {{ $ticketsPorMes_f[8] }}, {{ $ticketsPorMes_f[9] }}, {{ $ticketsPorMes_f[10] }}, {{ $ticketsPorMes_f[11] }}, {{ $ticketsPorMes_f[12] }}],
                            borderColor: colors[3],
                            fill: "-1",
                            backgroundColor: hexToRGB(colors[3], 0.3),
                        },
                        {
                            label: "Bryan",
                            data: [{{ $ticketsPorMes_e[1] }}, {{ $ticketsPorMes_e[2] }}, {{ $ticketsPorMes_e[3] }}, {{ $ticketsPorMes_e[4] }}, {{ $ticketsPorMes_e[5] }}, {{ $ticketsPorMes_e[6] }}, {{ $ticketsPorMes_e[7] }}, {{ $ticketsPorMes_e[8] }}, {{ $ticketsPorMes_e[9] }}, {{ $ticketsPorMes_e[10] }}, {{ $ticketsPorMes_e[11] }}, {{ $ticketsPorMes_e[12] }}],
                            borderColor: colors[4],
                            fill: 8,
                            backgroundColor: hexToRGB(colors[4], 0.3),
                        },
                        {
                            label: "Diosanto",
                            data: [{{ $ticketsPorMes_d[1] }}, {{ $ticketsPorMes_d[2] }}, {{ $ticketsPorMes_d[3] }}, {{ $ticketsPorMes_d[4] }}, {{ $ticketsPorMes_d[5] }}, {{ $ticketsPorMes_d[6] }}, {{ $ticketsPorMes_c[7] }}, {{ $ticketsPorMes_d[8] }}, {{ $ticketsPorMes_d[9] }}, {{ $ticketsPorMes_d[10] }}, {{ $ticketsPorMes_d[11] }}, {{ $ticketsPorMes_d[12] }}],
                            borderColor: colors[5],
                            backgroundColor: hexToRGB(colors[5], 0.3), // <-- corregido
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { filler: { propagate: false } },
                    interaction: { intersect: false },
                    scales: {
                        x: { grid: { display: false } },
                        y: { stacked: true, grid: { display: false } },
                    },
                },
            });
        }

        $(window).on("load", initDatasetExample);
    })(window.jQuery);
</script>

<script>
    function hexToRGB(e, a) {
        var t = parseInt(e.slice(1, 3), 16),
            o = parseInt(e.slice(3, 5), 16),
            n = parseInt(e.slice(5, 7), 16);
        return a
            ? "rgba(" + t + ", " + o + ", " + n + ", " + a + ")"
            : "rgb(" + t + ", " + o + ", " + n + ")";
    }

    (function ($) {
        "use strict";

        function initDatasetExample() {
            var ctx = document.getElementById("dataset-example-facturados");
            var colors = ctx.getAttribute("data-colors");
            colors = colors ? colors.split(",") : ["#727cf5,#fa5c7c,#0acf97,#ffbc00, #f56f36, #8e44ad"];

            new Chart(ctx.getContext("2d"), {
                type: "line",
                data: {
                    labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    datasets: [
                        {
                            label: "Camila",
                            data: [{{ $ticketsFacPorMes_a[1] }}, {{ $ticketsFacPorMes_a[2] }}, {{ $ticketsFacPorMes_a[3] }}, {{ $ticketsFacPorMes_a[4] }}, {{ $ticketsFacPorMes_a[5] }}, {{ $ticketsFacPorMes_a[6] }}, {{ $ticketsFacPorMes_a[7] }}, {{ $ticketsFacPorMes_a[8] }}, {{ $ticketsFacPorMes_a[9] }}, {{ $ticketsFacPorMes_a[10] }}, {{ $ticketsFacPorMes_a[11] }}, {{ $ticketsFacPorMes_a[12] }}],
                            borderColor: colors[0],
                            backgroundColor: hexToRGB(colors[0], 0.3),
                        },
                        {
                            label: "Brisza",
                            data: [{{ $ticketsFacPorMes_b[1] }}, {{ $ticketsFacPorMes_b[2] }}, {{ $ticketsFacPorMes_b[3] }}, {{ $ticketsFacPorMes_b[4] }}, {{ $ticketsFacPorMes_b[5] }}, {{ $ticketsFacPorMes_b[6] }}, {{ $ticketsFacPorMes_b[7] }}, {{ $ticketsFacPorMes_b[8] }}, {{ $ticketsFacPorMes_b[9] }}, {{ $ticketsFacPorMes_b[10] }}, {{ $ticketsFacPorMes_b[11] }}, {{ $ticketsFacPorMes_b[12] }}],
                            borderColor: colors[1],
                            fill: "-1",
                            backgroundColor: hexToRGB(colors[1], 0.3),
                        },
                        {
                            label: "Keila",
                            data: [{{ $ticketsFacPorMes_c[1] }}, {{ $ticketsFacPorMes_c[2] }}, {{ $ticketsFacPorMes_c[3] }}, {{ $ticketsFacPorMes_c[4] }}, {{ $ticketsFacPorMes_c[5] }}, {{ $ticketsFacPorMes_c[6] }}, {{ $ticketsFacPorMes_c[7] }}, {{ $ticketsFacPorMes_c[8] }}, {{ $ticketsFacPorMes_c[9] }}, {{ $ticketsFacPorMes_c[10] }}, {{ $ticketsFacPorMes_c[11] }}, {{ $ticketsFacPorMes_c[12] }}],
                            borderColor: colors[2],
                            fill: 1,
                            backgroundColor: hexToRGB(colors[2], 0.3),
                        },
                        {
                            label: "Diego",
                            data: [{{ $ticketsFacPorMes_f[1] }}, {{ $ticketsFacPorMes_f[2] }}, {{ $ticketsFacPorMes_f[3] }}, {{ $ticketsFacPorMes_f[4] }}, {{ $ticketsFacPorMes_f[5] }}, {{ $ticketsFacPorMes_f[6] }}, {{ $ticketsFacPorMes_f[7] }}, {{ $ticketsFacPorMes_f[8] }}, {{ $ticketsFacPorMes_f[9] }}, {{ $ticketsFacPorMes_f[10] }}, {{ $ticketsFacPorMes_f[11] }}, {{ $ticketsFacPorMes_f[12] }}],
                            borderColor: colors[3],
                            fill: "-1",
                            backgroundColor: hexToRGB(colors[3], 0.3),
                        },
                        {
                            label: "Bryan",
                            data: [{{ $ticketsFacPorMes_e[1] }}, {{ $ticketsFacPorMes_e[2] }}, {{ $ticketsFacPorMes_e[3] }}, {{ $ticketsFacPorMes_e[4] }}, {{ $ticketsFacPorMes_e[5] }}, {{ $ticketsFacPorMes_e[6] }}, {{ $ticketsFacPorMes_e[7] }}, {{ $ticketsFacPorMes_e[8] }}, {{ $ticketsFacPorMes_e[9] }}, {{ $ticketsFacPorMes_e[10] }}, {{ $ticketsFacPorMes_e[11] }}, {{ $ticketsFacPorMes_e[12] }}],
                            borderColor: colors[4],
                            fill: 8,
                            backgroundColor: hexToRGB(colors[4], 0.3),
                        },
                        {
                            label: "Diosanto",
                            data: [{{ $ticketsFacPorMes_d[1] }}, {{ $ticketsFacPorMes_d[2] }}, {{ $ticketsFacPorMes_d[3] }}, {{ $ticketsFacPorMes_d[4] }}, {{ $ticketsFacPorMes_d[5] }}, {{ $ticketsFacPorMes_d[6] }}, {{ $ticketsFacPorMes_c[7] }}, {{ $ticketsFacPorMes_d[8] }}, {{ $ticketsFacPorMes_d[9] }}, {{ $ticketsFacPorMes_d[10] }}, {{ $ticketsFacPorMes_d[11] }}, {{ $ticketsFacPorMes_d[12] }}],
                            borderColor: colors[5],
                            backgroundColor: hexToRGB(colors[5], 0.3), // <-- corregido
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { filler: { propagate: false } },
                    interaction: { intersect: false },
                    scales: {
                        x: { grid: { display: false } },
                        y: { stacked: true, grid: { display: false } },
                    },
                },
            });
        }

        $(window).on("load", initDatasetExample);
    })(window.jQuery);
</script>


<script>
    sessionStorage.setItem('justLoggedIn', '1');
</script>

<script>
$(document).ready(function () {
    // 🔹 Al cargar la página, traer los totales globales (todos los clientes)
    cargarDashboard(0);

    // 🔹 Cuando se selecciona un cliente en el dropdown
    $(document).on('click', '.cliente-option', function (e) {
        e.preventDefault();

        let clienteId = $(this).data('id');   // id del cliente
        let clienteNombre = $(this).text();   // nombre del cliente

        // Cambiar el texto del botón
        $('.btn.dropdown-toggle').html('<i class="ri-user-line me-1"></i> ' + clienteNombre);

        // Cargar dashboard filtrado por cliente
        cargarDashboard(clienteId);
    });

    // 🔹 Función para cargar los datos del dashboard
    function cargarDashboard(clienteId = 0) {
        $.ajax({
            url: "{{ url('/dashboard/cliente') }}/" + clienteId,
            type: 'GET',
            beforeSend: function () {
                // Mostrar "cargando..." temporal en los contadores
                $('.m-b-20-pen, .m-b-20-esti, .m-b-20-apro, .m-b-20-plan, .m-b-20-obse, .m-b-20-prue, .m-b-20-cerr, .m-b-20-canc, .m-b-20-cant-total, .badge.bg-primary.fs-6')
                    .text('...');
            },
            success: function (data) {
                // Actualizar cada contador
                $('.m-b-20-pen').text(data.pendientes ?? 0);
                $('.m-b-20-esti').text(data.estimados ?? 0);
                $('.m-b-20-apro').text(data.aprobados ?? 0);
                $('.m-b-20-plan').text(data.planificados ?? 0);
                $('.m-b-20-obse').text(data.observados ?? 0);
                $('.m-b-20-prue').text(data.prueba_cliente ?? 0);
                $('.m-b-20-cerr').text(data.cerrados ?? 0);
                $('.m-b-20-canc').text(data.cancelados ?? 0);
                $('.m-b-20-cant-total').text(data.totales ?? 0);
                $('.badge.bg-primary.fs-6').text('+' + (data.mes ?? 0));
            },
            error: function () {
                alert("⚠️ Error al cargar datos del dashboard");
            }
        });
    }
});
</script>



@endsection