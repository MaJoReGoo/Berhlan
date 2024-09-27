<?php

use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\TicActivos\PanelTipos;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Activos TIC | Consulta proyección mantenimientos
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
        <link rel="stylesheet" type="text/css"
            href="{{ asset('/panelfiles/assets/skin/default_skin/css/theme.css') }}">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/panelfiles/assets/allcp/forms/css/forms.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/panelfiles/assets/allcp/forms/css/forms.css') }}">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/panelfiles/assets/js/plugins/c3charts/c3.min.css') }}">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="{{ asset('/panelfiles/assets/img/favicon.ico') }}">

        <!-- Editor -->
        <script type="text/javascript" src="{{ asset('/panelfiles/ckeditor/ckeditor.js') }}"></script>
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
                                <a href="{{ asset('/panel/ticactivos/consultasact') }}" title="Activos TIC">
                                    <font color="#34495e">
                                        Activos TIC >
                                    </font>
                                    <font color="#b4c056">
                                        Consulta proyección de mantenimientos
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset('/panel/ticactivos/consultasact') }}" class="btn btn-primary btn-sm ml10"
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
                        <div class="panel m3">
                            <!-- -------------- Message Body -------------- -->
                            <div class="nano-content">
                                <div class="table-responsive">
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr>
                                                <th style="background-color:#67d3e0; color:#34495e; text-align:left;">
                                                    Consulta proyección de mantenimientos
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="allcp-form">
                                                        {!! Form::open([
                                                            'action' => 'TicActivos\ConsultasTicActivosPanelController@ProyeccionListado',
                                                            'class' => 'form',
                                                            'id' => 'form-wizard',
                                                        ]) !!}
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Compañía
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="empresa" id="empresa">
                                                                        <option value="">
                                                                            Compañía
                                                                        </option>
                                                                        <?php
                                                                        $Empresas = PanelEmpresas::getEmpresasActivas();
                                                                        ?>
                                                                        @foreach ($Empresas as $DatEmpresas)
                                                                            <option
                                                                                value="<?= $DatEmpresas->id_empresa ?>">
                                                                                <?= $DatEmpresas->nombre ?>
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <i class="arrow"></i>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Tipo de hardware
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="tipohd" id="tipohd">
                                                                        <option value="">
                                                                            Tipo de hardware
                                                                        </option>
                                                                        <?php
                                                                        $Tipo = PanelTipos::getTiposActivos();
                                                                        ?>
                                                                        @foreach ($Tipo as $DatTip)
                                                                            <option
                                                                                value="<?= $DatTip->id_tipoactivo ?>">
                                                                                <?= $DatTip->descripcion ?>
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <i class="arrow"></i>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-4">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Centro de operación
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="centro" id="centro">
                                                                        <option value="">
                                                                            Centro de operación
                                                                        </option>
                                                                        <?php
                                                                        $Centros = PanelCentrosOp::getCentrosOpActivos();
                                                                        ?>
                                                                        @foreach ($Centros as $DatCen)
                                                                            <option value="<?= $DatCen->id_centro ?>">
                                                                                <?= $DatCen->descripcion ?>
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <i class="arrow"></i>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Fecha de corte hasta
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('fecha', null, ['required', 'id' => 'fecha', 'class' => 'gui-input', 'maxlength' => '10']) !!}
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <br><br>
                                                            <div class="col-md-4">
                                                                {!! Form::submit('Consultar', ['class' => 'button']) !!}
                                                                <br><br>
                                                            </div>
                                                        </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
        <script src="{{ asset('/panelfiles/assets/js/pages/allcp_forms-elements.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/demo/widgets_sidebar.js') }}"></script>

        <!-- -------------- Page JS -------------- -->
        <script src="{{ asset('/panelfiles/assets/js/demo/charts/highcharts.js') }}"></script>

        <!-- -------------- /Scripts -------------- -->
    </body>

    </html>
@endforeach
