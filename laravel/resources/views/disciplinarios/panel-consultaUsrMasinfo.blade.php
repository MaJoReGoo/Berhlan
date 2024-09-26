<?php

use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Disciplinarios\PanelTipofaltas;
use App\Models\Disciplinarios\PanelMotivos;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Procesos disciplinarios | Consulta
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
                                <a href="javascript:history.back()"
                                    title="Procesos disciplinarios > Consulta solicitudes > Listado">
                                    <font color="#34495e">
                                        Procesos disciplinarios > Consulta solicitudes > Listado >
                                    </font>
                                    <font color="#b4c056">
                                        Más información
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="javascript:history.back()" class="btn btn-primary btn-sm ml10"
                            title="Procesos disciplinarios > Consulta solicitudes > Listado">
                            REGRESAR &nbsp;
                            <span class="fa fa-arrow-left"></span>
                        </a>
                    </div>
                </header>
                <!-- -------------- /Topbar -------------- -->

                <!-- -------------- Content -------------- -->
                <section id="content" class="table-layout animated fadeIn">
                    <div class="chute chute-center pt20">
                        <!-- -------------- Column Center -------------- -->
                        <div class="panel m3">
                            <!-- -------------- Message Body -------------- -->
                            <div class="nano-content">
                                <div class="table-responsive">
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr style="background-color:#39405a">
                                                <th>
                                                    Solicitud PD-<?= $DatosSolicitud[0]->id_solicitud ?>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tr>
                                            <td>
                                                <table id="message-table"
                                                    class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Estado:
                                                        </th>
                                                        <th style="text-align:left">
                                                            <?php
                                                            if ($DatosSolicitud[0]->estado == 0) {
                                                                echo "<font color=\"green\">";
                                                                echo 'Atendida, finalizada';
                                                            } else {
                                                                echo "<font color=\"red\">";
                                                                echo 'En proceso';
                                                            }
                                                            ?>
                                                            </font>
                                                        </th>

                                                        <th style="text-align:left">
                                                            Solicitado por:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            $empleadosol = PanelEmpleados::getEmpleado($DatosSolicitud[0]->usr_solicita);
                                                            echo $empleadosol[0]->primer_nombre;
                                                            echo ' ';
                                                            echo $empleadosol[0]->ot_nombre;
                                                            echo ' ';
                                                            echo $empleadosol[0]->primer_apellido;
                                                            echo ' ';
                                                            echo $empleadosol[0]->ot_apellido;
                                                            echo '<br>';
                                                            echo $DatosSolicitud[0]->fecha_solicita;
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Colaborador que cometió la falta:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            $empleadofal = PanelEmpleados::getEmpleado($DatosSolicitud[0]->colaborador);
                                                            echo $empleadofal[0]->primer_nombre;
                                                            echo ' ';
                                                            echo $empleadofal[0]->ot_nombre;
                                                            echo ' ';
                                                            echo $empleadofal[0]->primer_apellido;
                                                            echo ' ';
                                                            echo $empleadofal[0]->ot_apellido;
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Cargo:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            $cargo = PanelCargos::getCargo($empleadofal[0]->cargo);
                                                            echo $cargo[0]->descripcion;
                                                            echo '<br>';
                                                            $Area = PanelAreas::getArea($cargo[0]->area);
                                                            echo $Area[0]->descripcion . ' - ';
                                                            $Empresa = PanelEmpresas::getEmpresa($Area[0]->empresa);
                                                            echo $Empresa[0]->nombre;
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Tipo de falta:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            $Faltas = PanelTipofaltas::Tipofalta($DatosSolicitud[0]->tipo_falta);
                                                            echo $Faltas[0]->descripcion;
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Fecha en que se cometió la falta:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?= $DatosSolicitud[0]->fecha_falta ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Fecha conocimiento de falta:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?= $DatosSolicitud[0]->fecha_conocimiento ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Causa de la solicitud:
                                                        </th>
                                                        <td style="text-align:justify;">
                                                            <?= $DatosSolicitud[0]->causa ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Testigos:
                                                        </th>
                                                        <td style="text-align:justify;">
                                                            <?= $DatosSolicitud[0]->testigos ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Pruebas (url):
                                                        </th>
                                                        <td style="text-align:left;">
                                                            <?php
                                                            $ruta = $DatosSolicitud[0]->pruebas;
                                                            if ($ruta != '') {
                                                                echo "<a href=\"$ruta\" title=\"Enlace a pruebas\" target=\"_blank\">";
                                                                echo $ruta;
                                                                echo '</a>';
                                                            } else {
                                                                echo 'Sin enlace';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <?php
                            if($DatosSolicitud[0]->motivo_cierre > 0)
                             {
                              ?>
                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Motivo de cierre:
                                                        </th>
                                                        <td style="text-align:left;">
                                                            <?php
                                                            $motivo = PanelMotivos::getMotivo($DatosSolicitud[0]->motivo_cierre);
                                                            echo $motivo[0]->descripcion;
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Fecha de llamado a descargos:
                                                            <br>
                                                            Fecha de medida correctiva:
                                                        </th>
                                                        <td style="text-align:left;">
                                                            <?= $DatosSolicitud[0]->fecha_descargos ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Resultado del proceso:
                                                        </th>
                                                        <td style="text-align:justify;">
                                                            <?= $DatosSolicitud[0]->resultado ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Observaciones:
                                                        </th>
                                                        <td style="text-align:justify;">
                                                            <?= $DatosSolicitud[0]->obs_cierre ?>
                                                        </td>
                                                    </tr>

                                                    <?php
                              if($DatosSolicitud[0]->suspension > 0)
                               {
                                ?>
                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Días de suspensión:
                                                        </th>
                                                        <td style="text-align:justify;" colspan="3">
                                                            <?= $DatosSolicitud[0]->suspension ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                               }
                              ?>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Usuario que atiende:
                                                        </th>
                                                        <td style="text-align:left;">
                                                            <?php
                                                            $empleado1 = PanelEmpleados::getEmpleado($DatosSolicitud[0]->usr_cierre);
                                                            echo $empleado1[0]->primer_nombre;
                                                            echo ' ';
                                                            echo $empleado1[0]->ot_nombre;
                                                            echo ' ';
                                                            echo $empleado1[0]->primer_apellido;
                                                            echo ' ';
                                                            echo $empleado1[0]->ot_apellido;
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Fecha cierre de proceso:
                                                        </th>
                                                        <td style="text-align:left;">
                                                            <?= $DatosSolicitud[0]->fecha_cierre ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                             }
                            ?>
                                                    @if ($DatLog->empleado == 1944 || $DatLog->empleado == 154 || $DatLog->empleado == 439 || $DatLog->empleado == 258)
                                                        <tr style="background-color: #F8F8F8; color:#000000">
                                                            <th style="text-align:left">
                                                                Textos:
                                                            </th>
                                                            <td style="text-align:left;" colspan="3">
                                                                <button type="button" style="background:#f7f9f9;"
                                                                    class="btn btn-default light"
                                                                    onclick="window.open('{{ asset ('/panel/disciplinarios/textos/')}}<?= $DatosSolicitud[0]->id_solicitud ?>','_blank')"
                                                                    title="Citación - Acta - Decisión">
                                                                    <i class="fa fa-file-word-o fa-lg"
                                                                        style="color:#226dbd;"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </td>
                                        </tr>
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
