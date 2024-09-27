<?php

use App\Models\TicActivos\PanelTpOffice;
use App\Models\TicActivos\PanelActivos;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Activos TIC | Licencias de office
        </title>
        <meta name="description" content="Intranet para grupo Berhlan">
        <meta name="author" content="USUARIO">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- -------------- Fonts -------------- -->
        <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
        <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic'
            rel='stylesheet' type='text/css'>

        <!-- -------------- CSS - theme -------------- -->
        <link rel="stylesheet" type="text/css"
            href="{{ asset('/panelfiles/assets/skin/default_skin/css/theme.css') }}">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/panelfiles/assets/allcp/forms/css/forms.min.css') }}">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/panelfiles/assets/js/plugins/c3charts/c3.min.css') }}">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="{{ asset('/panelfiles/assets/img/favicon.ico') }}">

        <!-- Alerts Personalizados -->

        <script src="{{ asset('/panelfiles/sweetalert/dist/sweetalert.min.js') }}"></script>

        <link rel="stylesheet" href="{{ asset('/panelfiles/sweetalert/dist/sweetalert.css') }}">

        <!-- -------------- DataTables -------------- -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
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
                                <a href="{{ asset('/panel/menu/64') }}" title="Activos TIC">
                                    <font color="#34495e">
                                        Activos TIC >
                                    </font>
                                    <font color="#b4c056">
                                        Licencias de office
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset('/panel/ticactivos/licencias/agregar') }}"
                            class="btn btn-primary btn-sm ml10" title="Nueva licencia">
                            <span class="fa fa-plus pr5"></span>
                            <span class="fa fa-navicon pr5"></span>
                        </a>

                        <a href="{{ asset('/panel/menu/64') }}" class="btn btn-primary btn-sm ml10"
                            title="Activos TIC">
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
                                <br>
                                <div style="padding-left: 10px">
                                    Cantidad de licencias office:
                                    <?= $LicenciasActivas + $LicenciasInactivas ?>
                                    <font color="#b4c056">
                                        (<?= $LicenciasActivas ?>)
                                    </font>
                                </div>

                                <br>

                                <table id="message-table"
                                    class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                    <thead>
                                        <tr style="background-color: #F8F8F8">
                                            <th style="text-align:center;">
                                                #
                                            </th>
                                            <th style="text-align:center;">
                                                Tipo
                                            </th>
                                            <th style="text-align:center;">
                                                Licencia
                                            </th>
                                            <th style="text-align:center;">
                                                Código interno
                                            </th>
                                            <th style="text-align:center;">
                                                Asignado a:
                                            </th>
                                            <th style="text-align:center;">
                                                Medio
                                            </th>
                                            <th style="text-align:center;">
                                                Usuario
                                            </th>
                                            <th style="text-align:center;">
                                                Contraseña
                                            </th>
                                            <th style="text-align: center">
                                                Modificar
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $u = 1; ?>
                                        @foreach ($DatosLicencias as $DatLic)
                                            <?php
                                            if ($DatLic->estado == '0') {
                                                $color = '#F6565A';
                                            } else {
                                                $color = '#AEBF25';
                                            }
                                            ?>

                                            <tr class="message-unread">
                                                <td style="text-align:left;">
                                                    <font color="#2A2F43">
                                                        <?php
                                                        print $u;
                                                        $u++;
                                                        ?>
                                                    </font>
                                                </td>

                                                <td style="text-align:left;">
                                                    <i class="fa fa-tag fa-lg" style="color:<?= $color ?>;"></i>
                                                    &nbsp;
                                                    <font color="#2A2F43">
                                                        <b>
                                                            <?php
                                                            $tipo = PanelTpOffice::getTpOffice($DatLic->tipo);
                                                            echo $tipo[0]->descripcion;
                                                            ?>
                                                        </b>
                                                    </font>
                                                </td>

                                                <td style="text-align:center;">
                                                    <font color="#2A2F43">
                                                        <b>
                                                            <?= $DatLic->descripcion ?>
                                                        </b>
                                                    </font>
                                                </td>

                                                <td style="text-align:center;">
                                                    <font color="#2A2F43">
                                                        <b>
                                                            <?= $DatLic->codigoint ?>
                                                        </b>
                                                    </font>
                                                </td>

                                                <td style="text-align:center;">
                                                    <font color="#2A2F43">
                                                        <b>
                                                            <?php
                                $Activos = PanelActivos::ActivosLicencias($DatLic->id_licencia);
                                $e       = 0;
                                if($Activos->count() > 0)
                                 {
                                  ?>
                                                            @foreach ($Activos as $DatAct)
                                                                <?php
                                                                if ($e > 0) {
                                                                    echo '<br>';
                                                                }
                                                                $e++;
                                                                echo 'AC' . $DatAct->id_activo;
                                                                echo ' - Cod.';
                                                                echo $DatAct->cod_interno;
                                                                ?>
                                                            @endforeach
                                                            <?php
                                 }
                                ?>
                                                        </b>
                                                    </font>
                                                </td>

                                                <td style="text-align:center;">
                                                    <font color="#2A2F43">
                                                        <b>
                                                            <?php
                                                            if ($DatLic->medio == 'F') {
                                                                echo 'Física';
                                                            } else {
                                                                echo 'Virtual';
                                                            }
                                                            ?>
                                                        </b>
                                                    </font>
                                                </td>

                                                <td style="text-align:center;">
                                                    <font color="#2A2F43">
                                                        <b>
                                                            <?= $DatLic->usuario ?>
                                                        </b>
                                                    </font>
                                                </td>

                                                <td style="text-align:center;">
                                                    <font color="#2A2F43">
                                                        <b>
                                                            <?= $DatLic->clave ?>
                                                        </b>
                                                    </font>
                                                </td>

                                                <!-- Modificar -->
                                                <td style="text-align: center">
                                                    <button type="button" class="btn btn-default light"
                                                        onclick="window.location.href='{{ asset('/panel/ticactivos/licencias/modificar/') }}<?= $DatLic->id_licencia ?>'">
                                                        <i class="fa fa-pencil fa-lg" style="color:#AEBF25;"></i>
                                                    </button>
                                                </td>
                                                <!-- Modificar -->
                                            </tr>
                                        @endforeach
                                    </tbody>
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
        <script src="{{ asset('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js') }}"></script>

        <!-- -------------- JvectorMap Plugin -------------- -->
        <script src="{{ asset('/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js') }}">
        </script>

        <!-- -------------- HighCharts Plugin -------------- -->
        <script src="{{ asset('/panelfiles/assets/js/plugins/highcharts/highcharts.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/plugins/c3charts/d3.min.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/plugins/c3charts/c3.min.js') }}"></script>

        <!-- -------------- Theme Scripts -------------- -->
        <script src="{{ asset('/panelfiles/assets/js/utility/utility.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/demo/demo.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/main.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/demo/widgets_sidebar.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/pages/dashboard2.js') }}"></script>

        <!-- -------------- Page JS -------------- -->
        <script src="{{ asset('/panelfiles/assets/js/demo/charts/highcharts.js') }}"></script>

        <!-- -------------- DataTables -------------- -->
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

        <script>
            $(document).ready(function() {

                let datatable = $('#message-table').DataTable({
                    ordering: true,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    }
                });
            })
        </script>
    </body>

    </html>
@endforeach
