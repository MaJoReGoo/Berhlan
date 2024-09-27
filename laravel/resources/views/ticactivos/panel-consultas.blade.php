<?php

?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Activos TIC | Consultas
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

        {{-- Importar styles y funcionamiento del Select2 --}}
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

        <script type="text/javascript" src="{{ asset ('/panelfiles/select2/dist/js/select2.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/select2/dist/css/select2.min.css')}}">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.css')}}">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css')}}">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="{{ asset ('/panelfiles/assets/img/favicon.ico')}}">

        <link rel="stylesheet" type="text/css" href="{{ asset ('/public/css/ticactivos/panel-consultas.blade.css')}}">

        <!-- Editor -->
        <script type="text/javascript" src="{{ asset ('/panelfiles/ckeditor/ckeditor.js')}}"></script>
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
                                <a href="{{ asset ('/panel/menu/64')}}" title="Activos TIC">
                                    <font color="#34495e">
                                        Activos TIC >
                                    </font>
                                    <font color="#b4c056">
                                        Consultas
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset ('/panel/menu/64')}}" class="btn btn-primary btn-sm ml10" title="Activos TIC">
                            REGRESAR &nbsp;
                            <span class="fa fa-arrow-left"></span>
                        </a>
                    </div>
                </header>
                <!-- -------------- /Topbar -------------- -->

                <!-- -------------- Content -------------- -->
                <br>


                <div class="chute chute-center pt15">
                    <div class="row">
                        <div class="col-sm-6 col-xl-3">
                            <button class="col-xs-12 panel panel-body cards"
                                onclick="location.href='{{ asset ('/panel/ticactivos/conexempleados')}}"
                                title="Consulta tareas realizadas">
                                <div class="col-xs-12 ph10 text-center">
                                    <img src="{{ asset ('/panelfiles/iconos/tic_activos/rechazado.png')}}"
                                        class="img-responsive mauto " style="width: 128px; height:128px;" />
                                    <h6 class="text-muted" style="padding-top: 40px">
                                        <font color="#2a2f43">
                                            Activos asociados a excolaboradores
                                        </font>
                                        </h5>
                                </div>
                            </button>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <button class="col-xs-12 panel panel-body cards"
                                onclick="location.href='{{ asset ('/panel/ticactivos/concantidades')}} "title="Consulta tareas realizadas"
                                title="Consulta tareas realizadas">
                                <div class="col-xs-12 ph10 text-center">
                                    <img src="{{ asset ('/panelfiles/iconos/tic_activos/medios-de-comunicacion-social.png')}}"
                                        class="img-responsive mauto " style="width: 128px; height:128px;" />
                                    <h6 class="text-muted" style="padding-top: 40px">
                                        <font color="#2a2f43">
                                            Cantidad de activos
                                        </font>
                                        </h5>
                                </div>
                            </button>
                        </div>



                        <div class="col-sm-6 col-xl-3">
                            <button class="col-xs-12 panel panel-body cards"
                                onclick="location.href='{{ asset ('/panel/ticactivos/consultasedades')}}"
                                title="Consulta tareas realizadas">
                                <div class="col-xs-12 ph10 text-center">
                                    <img src="{{ asset ('/panelfiles/iconos/tic_activos/reloj-de-arena.png')}}"
                                        class="img-responsive mauto " style="width: 128px; height:128px;" />
                                    <h6 class="text-muted" style="padding-top: 40px">
                                        <font color="#2a2f43">
                                            Edades por activo
                                        </font>
                                        </h5>
                                </div>
                            </button>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <button class="col-xs-12 panel panel-body cards"
                                onclick="location.href='{{ asset ('/panel/ticactivos/consultasmtto')}}"
                                title="Consulta tareas realizadas">
                                <div class="col-xs-12 ph10 text-center">
                                    <img src="{{ asset ('/panelfiles/iconos/tic_activos/mantenimiento.png')}}"
                                        class="img-responsive mauto " style="width: 128px; height:128px;" />
                                    <h6 class="text-muted" style="padding-top: 40px">
                                        <font color="#2a2f43">
                                            Mantenimientos realizados
                                        </font>
                                        </h5>
                                </div>
                            </button>
                        </div>




                    </div>


                    <div class="row">
                        <div class="col-sm-6 col-xl-3">
                            <button class="col-xs-12 panel panel-body cards"
                                onclick="location.href='{{ asset ('/panel/ticactivos/consultasesperados')}}"
                                title="Consulta tareas realizadas">
                                <div class="col-xs-12 ph10 text-center">
                                    <img src="{{ asset ('/panelfiles/iconos/tic_activos/instalacion.png')}}"
                                        class="img-responsive mauto " style="width: 128px; height:128px;" />
                                    <h6 class="text-muted" style="padding-top: 40px">
                                        <font color="#2a2f43">
                                            Mantenimientos (esperados vs. realizados)
                                        </font>
                                        </h5>
                                </div>
                            </button>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <button class="col-xs-12 panel panel-body cards"
                                onclick="location.href='{{ asset ('/panel/ticactivos/consultasparam')}}"
                                title="Consulta tareas realizadas">
                                <div class="col-xs-12 ph10 text-center">
                                    <img src="{{ asset ('/panelfiles/iconos/tic_activos/filtrar.png')}}"
                                        class="img-responsive mauto " style="width: 128px; height:128px;" />
                                    <h6 class="text-muted" style="padding-top: 40px">
                                        <font color="#2a2f43">
                                            Parametrizada
                                        </font>
                                        </h5>
                                </div>
                            </button>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <button class="col-xs-12 panel panel-body cards"
                                onclick="location.href='{{ asset ('/panel/ticactivos/consultasproye')}}"
                                title="Consulta tareas realizadas">
                                <div class="col-xs-12 ph10 text-center">
                                    <img src="{{ asset ('/panelfiles/iconos/tic_activos/proyeccion.png')}}"
                                        class="img-responsive mauto " style="width: 128px; height:128px;" />
                                    <h6 class="text-muted" style="padding-top: 40px">
                                        <font color="#2a2f43">
                                            Proyección de mantenimientos
                                        </font>
                                        </h5>
                                </div>
                            </button>
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <button class="col-xs-12 panel panel-body cards"
                                onclick="location.href='{{ asset ('/panel/ticactivos/consultastareas')}}"
                                title="Consulta tareas realizadas">
                                <div class="col-xs-12 ph10 text-center">
                                    <img src="{{ asset ('/panelfiles/iconos/tic_activos/tareas-diarias.png')}}"
                                        class="img-responsive mauto " style="width: 128px; height:128px;" />
                                    <h6 class="text-muted" style="padding-top: 40px">
                                        <font color="#2a2f43">
                                            Tareas realizadas
                                        </font>
                                        </h5>
                                </div>
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-xl-3">
                            <button class="col-xs-12 panel panel-body cards" data-toggle="modal" data-target="#consultasxusuario"
                                title="Consulta tareas realizadas">
                                <div class="col-xs-12 ph10 text-center">
                                    <img src="{{ asset ('/panelfiles/iconos/tic_activos/buscarporactivo.png')}}"
                                        class="img-responsive mauto " style="width: 128px; height:128px;" />
                                    <h6 class="text-muted" style="padding-top: 40px">
                                        <font color="#2a2f43">
                                            Consulta activos por usuario
                                        </font>
                                        </h5>
                                </div>
                            </button>
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <button class="col-xs-12 panel panel-body cards" data-toggle="modal" data-target="#consultasxactivo"
                                title="Consulta tareas realizadas">
                                <div class="col-xs-12 ph10 text-center">
                                    <img src="{{ asset ('/panelfiles/iconos/tic_activos/busquedaporusuario.png')}}"
                                        class="img-responsive mauto " style="width: 128px; height:128px;" />
                                    <h6 class="text-muted" style="padding-top: 40px">
                                        <font color="#2a2f43">
                                            Consulta usuario por activo
                                        </font>
                                        </h5>
                                </div>
                            </button>
                        </div>
                    </div>







                </div>


            </section>
        </div>
        @include('ticactivos.modales.modal-activosConsultaActivos')
        @include('ticactivos.modales.modal-activosConsulta')
        <!-- -------------- /Body Wrap  -------------- -->

        <!-- -------------- Scripts -------------- -->

        <!-- -------------- jQuery -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js')}}"></script>

        <!-- -------------- JvectorMap Plugin -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js')}}"></script>

        <!-- -------------- HighCharts Plugin -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/plugins/highcharts/highcharts.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/plugins/c3charts/d3.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.js')}}"></script>

        <!-- -------------- Theme Scripts -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/utility/utility.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/demo/demo.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/main.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/pages/allcp_forms-elements.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/demo/widgets_sidebar.js')}}"></script>

        <!-- -------------- Page JS -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/demo/charts/highcharts.js')}}"></script>

        <!-- -------------- /Scripts -------------- -->

        <script>
            $('#consultasxusuario').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Botón que activó el modal
                var id = button.data('id'); // Extraer el ID del empleado de los datos del botón

                $('#body_activos').html('');
                // Realizar una solicitud AJAX para obtener los datos del empleado
                $.ajax({
                    type: 'GET',
                    url: '{{ asset ('/panel/ticactivos/conexempleados/')}}' +
                        id,
                    success: function(data) {

                        for (let i = 0; i < data.length; i++) {

                        }

                        // Actualizar el contenido del modal con los datos obtenidos

                    },
                    error: function(xhr, status, error) {
                        // Manejar errores si es necesario
                        console.error(xhr.responseText);
                    }
                });
            });
        </script>

    </body>

    </html>
@endforeach
