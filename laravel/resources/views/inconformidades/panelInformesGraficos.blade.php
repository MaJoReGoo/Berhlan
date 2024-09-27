<?php

?>

@foreach ($DatosUsuario as $DatLog)

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>
            Intranet | Mejora continua | Informes gráficos
        </title>
        <meta name="keywords" content="panel, cms, usuarios, servicio" />
        <meta name="description" content="Intranet para grupo Berhlan">
        <meta name="author" content="USUARIO">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- -------------- Fonts -------------- -->
        <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
        <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic'
            rel='stylesheet' type='text/css'>

        <!-- -------------- CSS - theme -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/skin/default_skin/css/theme.css')}}">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.css')}}">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css')}}">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="{{ asset ('/panelfiles/assets/img/favicon.ico')}}">

        <!-- Editor -->
        <script type="text/javascript" src="{{ asset ('/panelfiles/ckeditor/ckeditor.js')}}"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

        <script type="text/javascript" src="{{ asset ('/panelfiles/select2/dist/js/select2.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/select2/dist/css/select2.min.css')}}">

        <!-- Importar style select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <link rel="stylesheet" type="text/css" href="{{ asset ('/public/css/inconformidades/panelInformesGraficos.blade.css')}}">

    </head>

    <body>
        <!-- -------------- Body Wrap  -------------- -->
        <div id="main">
            <!-- -------------- Header  -------------- -->
            <header class="navbar navbar-fixed-top bg-dark">
                @include('includes-panel/headerInterno-panel')
            </header>
            <!-- -------------- /Header  -------------- -->

            <!-- -------------- Sidebar  -------------- -->
            <aside id="sidebar_left" class="nano nano-light affix">
                <!-- -------------- Sidebar Left Wrapper  -------------- -->
                <div class="sidebar-left-content nano-content">
                    <!-- -------------- Sidebar Menu  -------------- -->
                    @include('includes-panel/menuModulosEscritorio-panel')
                    <!-- -------------- /Sidebar Menu  -------------- -->

                    <!-- -------------- Sidebar Hide Button -------------- -->
                    <div class="sidebar-toggler">
                        <a href="#">
                            <span class="fa fa-arrow-circle-o-left"></span>
                        </a>
                    </div>
                    <!-- -------------- /Sidebar Hide Button -------------- -->
                </div>
                <!-- -------------- /Sidebar Left Wrapper  -------------- -->
            </aside>
            <!-- -------------- Main Wrapper -------------- -->
            <section id="content_wrapper">
                <!-- -------------- Topbar -------------- -->
                <header id="topbar" class="ph10">
                    <div class="topbar-left">
                        <ul class="nav nav-list nav-list-topbar pull-left">
                            <li class="active">
                                <a href="{{ asset ('/panel/menu/118')}}" title="Inconformidades">
                                    <font color="#34495e">
                                        Mejora continua >
                                    </font>
                                    <font color="#b4c056">
                                        Informes gráficos no conformidad
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset ('/panel/menu/118')}}" class="btn btn-primary btn-sm ml10"
                            title="Inconformidades">
                            REGRESAR &nbsp;
                            <span class="fa fa-arrow-left"></span>
                        </a>
                    </div>
                </header>
                <!-- -------------- /Topbar -------------- -->

                <section id="content" class="table-layout animated fadeIn">

                    <div class="chute chute-center pt30">
                        <!-- -------------- Column Center -------------- -->
                        <div class="panel m4">
                            <!-- -------------- Message Body -------------- -->
                            <div class="nano-content">
                                <div class="table-responsive">
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr>
                                                <th style="background-color:#67d3e0; color:#34495e; text-align:left;">
                                                    Informe gráficos
                                                </th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>

                                                <td>
                                                    <h3 style="text-align: center">Gráfica Tratamientos de no
                                                        conformidad</h3>
                                                    <div class="allcp-form">

                                                        <div id="trata">
                                                            <div class="row">

                                                                <div class="col-md-3">

                                                                    <label for="fecha_ini" style="color: #34495e">
                                                                        <b>
                                                                            Desde la fecha:
                                                                        </b>
                                                                    </label>

                                                                    <input type="date" id="fecha_ini_trata"
                                                                        class="form-control" max="{{ date('Y-m-d') }}">
                                                                </div>

                                                                <div class="col-md-3">

                                                                    <label for="fecha_final" style="color: #34495e">
                                                                        <b>
                                                                            Hasta la fecha:
                                                                        </b>
                                                                    </label>

                                                                    <input type="date" id="fecha_final_trata"
                                                                        class="form-control" max="{{ date('Y-m-d') }}"
                                                                        disabled>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <br>
                                                                    <br>
                                                                    <button id="btn_search_trata"
                                                                        style="margin-right: 40px;"
                                                                        class="btn btn-primary mb-2">
                                                                        <img
                                                                            src="{{ asset ('/images/informacion.png')}}">
                                                                        Consultar
                                                                        </img>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <br>
                                                    <br>
                                                    <canvas id="tratamientos" width="100%" height="20"></canvas>
                                                </td>


                                            </tr>
                                            <tr>

                                                <td>
                                                    <h3 style="text-align: center">Grafica Reporte acciones correctivas
                                                        o/y mejoras</h3>
                                                    <div class="allcp-form">

                                                        <div id="trata">
                                                            <div class="row">

                                                                <div class="col-md-3">

                                                                    <label for="fecha_ini" style="color: #34495e">
                                                                        <b>
                                                                            Desde la fecha:
                                                                        </b>
                                                                    </label>

                                                                    <input type="date" id="fecha_ini_repor"
                                                                        class="form-control"
                                                                        max="{{ date('Y-m-d') }}">
                                                                </div>

                                                                <div class="col-md-3">

                                                                    <label for="fecha_final" style="color: #34495e">
                                                                        <b>
                                                                            Hasta la fecha:
                                                                        </b>
                                                                    </label>

                                                                    <input type="date" id="fecha_final_repor"
                                                                        class="form-control" max="{{ date('Y-m-d') }}"
                                                                        disabled>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <br>
                                                                    <br>
                                                                    <button id="btn_search_reporte"
                                                                        style="margin-right: 40px;"
                                                                        class="btn btn-primary mb-2">
                                                                        <img
                                                                            src="{{ asset ('/images/informacion.png')}}">
                                                                        Consultar
                                                                        </img>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <br>
                                                    <br>
                                                    <canvas id="reportes" width="100%" height="20"></canvas>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        </div>







        <!-- -------------- Scripts -------------- -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>



        <script src="https://cdnjs.cloudflare.com/ajax/libs/autosize.js/4.0.2/autosize.min.js"></script>

        <!-- -------------- jQuery -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js')}}"></script>

        <!-- -------------- JvectorMap Plugin -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js')}}"></script>

        <!-- -------------- HighCharts Plugin -------------- -->


        <!-- -------------- Theme Scripts -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/utility/utility.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/demo/demo.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/main.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/pages/allcp_forms-elements.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/demo/widgets_sidebar.js')}}"></script>

        <!-- -------------- Page JS -------------- -->

        <!-- -------------- /Scripts -------------- -->

        <!-- Importar script select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/autosize.js/4.0.2/autosize.min.js"></script>

        <script src="https://kit.fontawesome.com/6b7caabff8.js" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                let datosTratamiento = @json($datosTratamiento);
                let cantidades_tratamiento = datosTratamiento.map(resultado => resultado.cantidad);
                let descripciones_tratamiento = datosTratamiento.map(resultado => resultado.descripcion);
                let datosReporte = @json($datosReporte);
                let cantidades_reporte = datosReporte.map(resultado => resultado.cantidad);
                let descripciones_reporte = datosReporte.map(resultado => resultado.descripcion);

                $("#fecha_ini_trata").change(function() {
                    var fechaIni = $("#fecha_ini_trata").val();
                    $("#fecha_final_trata").attr("min",fechaIni).removeAttr("disabled").val('');
                });

                $("#fecha_ini_repor").change(function() {
                    var fechaIni = $("#fecha_ini_repor").val();
                    $("#fecha_final_repor").attr("min",fechaIni).removeAttr("disabled").val('');
                });

                function generarColorRGBA(alpha) {
                    var r = Math.floor(Math.random() * 256);
                    var g = Math.floor(Math.random() * 256);
                    var b = Math.floor(Math.random() * 256);
                    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
                }

                let colores_trata = [];
                let colores_reporte = [];
                for (var i = 0; i < descripciones_tratamiento.length; i++) {
                    colores_trata.push(generarColorRGBA(1));
                }
                for (var i = 0; i < descripciones_reporte.length; i++) {
                    colores_reporte.push(generarColorRGBA(1));
                }

                var ctx1 = document.getElementById('tratamientos').getContext('2d');
                var tratamientos = new Chart(ctx1, {
                    type: 'bar',
                    data: {
                        labels: descripciones_tratamiento,
                        datasets: [{
                            label: '',
                            data: cantidades_tratamiento,
                            backgroundColor: colores_trata,
                            borderColor: colores_trata,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            // x: {
                            //     ticks: {
                            //         minRotation: 30, // Rotar las etiquetas 90 grados (vertical)
                            //     }
                            // },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                var ctx2 = document.getElementById('reportes').getContext('2d');
                var reporte = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: descripciones_reporte,
                        datasets: [{
                            label: '',
                            data: cantidades_reporte,
                            backgroundColor: colores_reporte,
                            borderColor: colores_reporte,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });


                $('#btn_search_trata').click(function() {
                    var fecha_ini_trata = $('#fecha_ini_trata').val();
                    var fecha_final_trata = $('#fecha_final_trata').val();
                    let token = $('meta[name="csrf-token"]').attr("content");
                    $.ajax({
                        url: '{{ route('updateGraficaTrata') }}',
                        type: 'POST', // Cambia la petición a POST
                        dataType: 'json',
                        data: {
                            fecha_ini_trata: fecha_ini_trata,
                            fecha_final_trata: fecha_final_trata,
                            _token: token
                        },
                        success: function(data) {

                            if (data.message) {
                                window.location.reload();
                            } else {
                                let cantidades_tratamiento = data.map(resultado => resultado
                                    .cantidad);
                                let descripciones_tratamiento = data.map(resultado => resultado
                                    .descripcion);
                                tratamientos.data.labels = descripciones_tratamiento;
                                tratamientos.data.datasets[0].data = cantidades_tratamiento;
                                tratamientos.update();
                            }
                        }
                    });
                });

                $('#btn_search_reporte').click(function() {
                    var fecha_ini_repor = $('#fecha_ini_repor').val();
                    var fecha_final_repor = $('#fecha_final_repor').val();
                    let token = $('meta[name="csrf-token"]').attr("content");
                    $.ajax({
                        url: '{{ route('updateGraficaReporte') }}',
                        type: 'POST', // Cambia la petición a POST
                        dataType: 'json',
                        data: {
                            fecha_ini_repor: fecha_ini_repor,
                            fecha_final_repor: fecha_final_repor,
                            _token: token
                        },
                        success: function(data) {
                            if (data.message) {
                                window.location.reload();
                            } else {
                                let cantidades_reporte = data.map(resultado => resultado.cantidad);
                                let descripciones_reporte = data.map(resultado => resultado
                                    .descripcion);
                                reporte.data.labels = descripciones_reporte;
                                reporte.data.datasets[0].data = cantidades_reporte;
                                reporte.update();
                            }
                        }
                    });
                });

            });
        </script>
    </body>
@endforeach
