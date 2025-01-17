<?php

use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\TicActivos\PanelTipos;
use App\Models\TicActivos\PanelMarcas;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\TicActivos\PanelLicencias;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Activos TIC | Consulta parametrizada
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

        {{-- Importar styles y funcionamiento del Select2 --}}
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">


        <script type="text/javascript" src="{{ asset ('/panelfiles/select2/dist/js/select2.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/select2/dist/css/select2.min.css')}}">
        <script>
            jQuery(document).ready(function($) {
                $(".select2_init").select2({
                    closeOnSelect: true,
                    width: '100%'
                });
            });
        </script>
    </head>

    <link rel="stylesheet" type="text/css" href="{{ asset('/public/css/archivo-digital/panel-archivoCentral.blade.css') }}">

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
                                <a href="{{ asset ('/panel/menu/108')}}" title="Activos TIC">
                                    <font color="#34495e">
                                        Archivo Central >
                                    </font>
                                    <font color="#b4c056">
                                        Consulta parametrizada
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset ('/panel/menu/108')}}" class="btn btn-primary btn-sm ml10" title="Activos TIC">
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
                                <div class="card-title">
                                    <div class="row titulo title-background"><span>Consulta Parametrizada</span></div>
                                </div>
                                <div class="table-responsive">
                                    <table id="message-table" class="table allcp-form theme-warning br-t">

                                        <br>
                                        <div class="allcp-form">
                                            <form action="{{ route('ConsultasArchivoCentral') }}" method="GET">
                                                <div class="row">


                                                    <div class="col-md-3">
                                                        <label style="color: #34495e">
                                                            <b>
                                                                Dependencia
                                                            </b>
                                                        </label>
                                                        <label class="field select">
                                                            <select class="select2_init" name="dependencia"
                                                                id="dependencia">
                                                                <option value="">
                                                                    Seleccione una ....
                                                                </option>
                                                                @foreach ($DatosDependencias as $DatDepen)
                                                                    <option value="<?= $DatDepen->dependencia ?>">
                                                                        <?= $DatDepen->dependencia ?>
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </label>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label style="color: #34495e">
                                                            <b>
                                                                Codigo Caja
                                                            </b>
                                                        </label>
                                                        <label class="field prepend-icon">
                                                            <select class="select2_init" name="codigo_caja"
                                                                id="codigo_caja">
                                                                <option value="">
                                                                    Seleccione un ...
                                                                </option>

                                                                @foreach ($DatosRegistros as $DatTip)
                                                                    <option value="<?= $DatTip->codigo_caja ?>">
                                                                        <?= $DatTip->codigo_caja ?>
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </label>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label style="color: #34495e">
                                                            <b>
                                                                Asunto o Titulo unidad documental
                                                            </b>
                                                        </label>
                                                        <label class="field select">
                                                            <select class="select2_init" name="asunto" id="asunto">
                                                                <option value="">
                                                                    Seleccione un ...
                                                                </option>
                                                                @foreach ($DatosRegistrosAsunto as $DatTip)
                                                                    <option
                                                                        value="<?= $DatTip->titulo_unidad_documental ?>">
                                                                        <?= $DatTip->titulo_unidad_documental ?>
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label style="color: #34495e">
                                                            <b>
                                                                Historia Laboral
                                                            </b>
                                                        </label>
                                                        <label class="field select">
                                                            <select class="select2_init" name="empleado"
                                                                id="empleado">
                                                                <option value="">
                                                                    Seleccione un Empleado
                                                                </option>
                                                                <?php
                                                                $Empleado = PanelEmpleados::EmpleadosActivos();
                                                                ?>
                                                                @foreach ($Empleado as $DatEmp)
                                                                    <?php
                                                                    $Cargo = PanelCargos::getCargo($DatEmp->cargo);
                                                                    $Area = PanelAreas::getArea($Cargo[0]->area);
                                                                    ?>
                                                                    <option value="{{ $DatEmp->id_empleado }}">

                                                                        {{ $DatEmp->primer_nombre }}
                                                                        {{ $DatEmp->ot_nombre }}
                                                                        {{ $DatEmp->primer_apellido }}
                                                                        {{ $DatEmp->ot_apellido }}
                                                                        -
                                                                        {{ $Cargo[0]->descripcion }}
                                                                        -
                                                                        {{ $Area[0]->descripcion }}

                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </label>
                                                    </div>
                                                </div>
                                                <br>

                                                <div class="row">
                                                    <div
                                                        style="display: flex; justify-content: flex-end; align-items: center; margin: 20px;">
                                                        <br><br>
                                                        <button id="btn_adjuntar" type="submit"
                                                            class="btn btn-primary mb-2">
                                                            <img src="{{ asset ('/images/informacion.png')}}">
                                                            Consultar
                                                            </img>
                                                        </button>
                                                        <br><br>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

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
    </body>

    </html>
@endforeach
