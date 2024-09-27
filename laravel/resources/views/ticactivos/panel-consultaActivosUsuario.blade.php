<?php

use App\Models\TicActivos\PanelTipos;
use App\Models\TicActivos\PanelMarcas;
use App\Models\TicActivos\PanelActivos;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelCentrosOp;

?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Activos TIC | Consulta activos asociados a excolaboradores
        </title>
        <meta name="description" content="Intranet para grupo Berhlan">
        <meta name="author" content="USUARIO">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- -------------- Fonts -------------- -->
        <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
        <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic'
            rel='stylesheet' type='text/css'>

        <!-- -------------- CSS - theme -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/skin/default_skin/css/theme.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/skin/default_skin/css/prueba.css')}}">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.min.css')}}">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css')}}">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="{{ asset ('/panelfiles/assets/img/favicon.ico')}}">

        <!-- -------------- DataTables -------------- -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">

        <script src="{{ asset ('/panelfiles/sweetalert/dist/sweetalert.min.js')}}"></script>

        <link rel="stylesheet" href="{{ asset ('/panelfiles/sweetalert/dist/sweetalert.css')}}">
    </head>

    <body class="sales-stats-page">
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
                                <a href="{{ asset ('/panel/ticactivos/consultasact')}}" title="Activos TIC > Consultas">
                                    <font color="#34495e">
                                        Activos TIC > Consultas >
                                    </font>
                                    <font color="#b4c056">
                                        Consulta activos historicos
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset ('/panel/ticactivos/consultasact')}}" class="btn btn-primary btn-sm ml10"
                            title="Activos TIC > Consultas">
                            REGRESAR &nbsp;
                            <span class="fa fa-arrow-left"></span>
                        </a>
                    </div>
                </header>
                <!-- -------------- /Topbar -------------- -->

                <!-- -------------- Content -------------- -->
                <section id="content" class="table-layout animated fadeIn">
                    <div class="chute chute-center pt30">
                        <!-- -------------- Column Center -------------- -->
                        <div class="panel m10">
                            <!-- -------------- Message Body -------------- -->
                            <div class="table-responsive">
                                <table class="table allcp-form theme-warning br-t">
                                    <thead>
                                        <tr style="background-color:#39405a">
                                            <th>
                                                <font color="white">
                                                    Resultado de la consulta usuarios asignados a un activo especifico
                                                </font>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tr>
                                        <td>
                                            <table id="message-table"
                                                class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                <thead>
                                                    <tr style="background-color: #F8F8F8">
                                                        <th style="text-align:center;">
                                                            #
                                                        </th>
                                                        <th style="text-align:center;">
                                                            identificacion
                                                        </th>
                                                        <th style="text-align:center;">
                                                            Nombre Funcionario
                                                        </th>
                                                        <th style="text-align:center;">
                                                            Cargo
                                                        </th>
                                                        <th style="text-align:center;">
                                                            Area/Centro Operacion
                                                        </th>
                                                        <th style="text-align:center;">
                                                            Fecha asignada
                                                        </th>


                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php $u = 2;
                                                    ?>
                                                    <tr class="message-unread">
                                                        <td style="text-align:right;">
                                                            <font color="#2A2F43">
                                                                1
                                                            </font>
                                                        </td>


                                                        @php
                                                            $act = PanelActivos::Activo($activoI);
                                                            $empleados = PanelEmpleados::getEmpleado($act[0]->empleado)->first();

                                                        @endphp
                                                        <td style="text-align:center;">
                                                            <font color="#2A2F43">
                                                                {{ $empleados->identificacion }}
                                                            </font>
                                                        </td>
                                                        <td style="text-align:center;">
                                                            <font color="#2A2F43">
                                                                <b>
                                                                    {{ $empleados->primer_nombre }}
                                                                    {{ ' ' }}
                                                                    {{ $empleados->ot_nombre }}
                                                                    {{ ' ' }}
                                                                    {{ $empleados->primer_apellido }}
                                                                    {{ ' ' }}
                                                                    {{ $empleados->ot_apellido }}
                                                                </b>
                                                            </font>
                                                        </td>
                                                        <td style="text-align:center;">
                                                            <font color="#2A2F43">
                                                                @php
                                                                    $cargo = PanelCargos::getCargo($empleados->cargo);
                                                                    echo $cargo[0]->descripcion;
                                                                @endphp
                                                            </font>
                                                        </td>
                                                        <td style="text-align:center;">
                                                            <font color="#2A2F43" size="2">
                                                                @php
                                                                     $Area = PanelEmpleados::EmpleadoArea($act[0]->empleado);
                                                                    $centro = PanelCentrosOp::getCentroOp($empleados->centro_op);
                                                                    echo $Area[0]->descripcion;
                                                                    echo '/';
                                                                    echo $centro[0]->descripcion;
                                                                @endphp
                                                            </font>
                                                        </td>
                                                        <td style="text-align:center;">
                                                            <font color="#2A2F43" size="2">
                                                                Actualmente asignado
                                                            </font>
                                                        </td>
                                                    </tr>


                                                    @foreach ($Datosempleado as $DatActAsi )
                                                        @php
                                                            $empleado = PanelEmpleados::getEmpleado($DatActAsi[0][0]->id_empleado);
                                                        @endphp
                                                        <tr class="message-unread">
                                                            <td style="text-align:right;">
                                                                <font color="#2A2F43">
                                                                    <?php
                                                                    print $u;
                                                                    $u++;
                                                                    ?>
                                                                </font>
                                                            </td>

                                                            <td style="text-align:center;">
                                                                <font color="#2A2F43">
                                                                    {{ $DatActAsi[0][0]->identificacion }}
                                                                </font>
                                                            </td>
                                                            <td style="text-align:center;">
                                                                <font color="#2A2F43">
                                                                    <b>
                                                                        {{ $DatActAsi[0][0]->primer_nombre }}
                                                                        {{ ' ' }}
                                                                        {{ $DatActAsi[0][0]->ot_nombre }}
                                                                        {{ ' ' }}
                                                                        {{ $DatActAsi[0][0]->primer_apellido }}
                                                                        {{ ' ' }}
                                                                        {{ $DatActAsi[0][0]->ot_apellido }}
                                                                    </b>
                                                                </font>
                                                            </td>
                                                            <td style="text-align:center;">
                                                                <font color="#2A2F43">
                                                                    @php
                                                                        $cargo = PanelCargos::getCargo($empleado[0]->cargo);
                                                                        echo $cargo[0]->descripcion;
                                                                    @endphp
                                                                </font>
                                                            </td>
                                                            <td style="text-align:center;">
                                                                <font color="#2A2F43" size="2">
                                                                    @php
                                                                        $Area = PanelAreas::getArea($cargo[0]->area);
                                                                        $centro = PanelCentrosOp::getCentroOp($empleado[0]->centro_op);
                                                                        echo $Area[0]->descripcion;
                                                                        echo '/';
                                                                        echo $centro[0]->descripcion;
                                                                    @endphp

                                                                </font>
                                                            </td>

                                                            <td style="text-align:center;">
                                                                <font color="#2A2F43" size="2">
                                                                    {{ $DatActAsi[1]}}
                                                                </font>
                                                            </td>

                                                        </tr>
                                                        @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                        <!-- -------------- /Column Center -------------- -->
                    </div>
                </section>

                <!-- -------------- /Content -------------- -->
            </section>
        </div>



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
        <script src="{{ asset ('/panelfiles/assets/js/demo/widgets_sidebar.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/pages/dashboard2.js')}}"></script>

        <!-- -------------- Page JS -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/demo/charts/highcharts.js')}}"></script>

        <!-- -------------- DataTables -------------- -->
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

        <script>
            $('#message-table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
        </script>
        <script>
            $('#message-table2').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
        </script>

        <!-- -------------- /Scripts -------------- -->
    </body>

    </html>
@endforeach
