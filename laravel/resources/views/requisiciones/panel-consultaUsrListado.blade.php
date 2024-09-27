<?php

use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Requisiciones\PanelRequisiciones;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Requisición de personal | Consulta
        </title>
        @include('includes-CDN/include-head')
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
                                <a href="{{ asset ('/panel/requisiciones/consultausr')}}"
                                    title="Requisiciones > Consulta solicitudes">
                                    <font color="#34495e">
                                        Requisiciones > Consulta solicitudes >
                                    </font>
                                    <font color="#b4c056">
                                        Listado
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset ('/panel/requisiciones/consultausr')}}" class="btn btn-primary btn-sm ml10"
                            title="Requisiciones > Consulta solicitudes">
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
                                            <tr style="background-color:#39405a">
                                                <th>
                                                    Solicitudes con los parámetros dados
                                                </th>
                                            </tr>
                                        </thead>

                                        <tr>
                                            <td colspan="2">
                                                <table id="message-table"
                                                    class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                    <thead>
                                                        <tr style="background-color: #F8F8F8; color:#000000">
                                                            <th style="text-align:left">
                                                                #
                                                            </th>
                                                            <th style="text-align:right">
                                                                Sol.
                                                            </th>
                                                            <th style="text-align: center">
                                                                Cargo
                                                            <th style="text-align: center">
                                                                Centro de operación
                                                            </th>
                                                            <th style="text-align: center">
                                                                Motivo
                                                            </th>
                                                            <th style="text-align: center">
                                                                Reemplaza a
                                                            </th>
                                                            <th style="text-align: center">
                                                                Num. vacantes
                                                            </th>
                                                            <th style="text-align: center">
                                                                Fecha de solicitud
                                                            </th>
                                                            <th style="text-align: center">
                                                                Fecha de cierre
                                                            </th>
                                                            <th style="text-align: center">
                                                                Estado
                                                            </th>
                                                            <th style="text-align: center">
                                                                Más info.
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                        $u = 1;
                                                        ?>
                                                        @foreach ($DatosSolicitudes as $DatSol)
                                                            <tr class="message-unread">
                                                                <td style="text-align:left">
                                                                    <font color="#2A2F43">
                                                                        (<?php
                                                                        print $u;
                                                                        $u++;
                                                                        ?>)
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:right">
                                                                    <font color="#2A2F43">
                                                                        <b>
                                                                            <?= $DatSol->num_solicitud ?>
                                                                        </b>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:left">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        $nombrec = PanelCargos::getCargo($DatSol->cargo);
                                                                        $Area = PanelAreas::getArea($nombrec[0]->area);
                                                                        $Empresa = PanelEmpresas::getEmpresa($Area[0]->empresa);
                                                                        echo $nombrec[0]->descripcion;
                                                                        echo '<br>';
                                                                        echo $Area[0]->descripcion . ' - ' . $Empresa[0]->nombre;
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:left">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        $nombcen = PanelCentrosOp::getCentroOp($DatSol->centro_operacion);
                                                                        echo $nombcen[0]->descripcion;
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:left">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        if ($DatSol->motivo == 'RP') {
                                                                            echo 'Reemplazo de personal';
                                                                        } elseif ($DatSol->motivo == 'CN') {
                                                                            echo 'Cargo nuevo / Incremento de personal';
                                                                        } elseif ($DatSol->motivo == 'LM') {
                                                                            echo 'Licencia de maternidad';
                                                                        } elseif ($DatSol->motivo == 'IP') {
                                                                            echo 'Incapacidad permanente';
                                                                        }
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:justify;">
                                                                    <font color="#2A2F43">
                                                                        <?= $DatSol->reemplaza_a ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?= $DatSol->num_vacantes ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?= $DatSol->fecha_solicita ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?= $DatSol->fecha_cierre ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:left">
                                                                    <?php
                                                                    if ($DatSol->estado == 2 || $DatSol->estado == 4 || $DatSol->estado == 7) {
                                                                        $color = 'red';
                                                                    } elseif ($DatSol->estado == 6) {
                                                                        $color = 'green';
                                                                    } else {
                                                                        $color = '#2A2F43';
                                                                    }

                                                                    echo '<font color=' . $color . '>';
                                                                    $estado = PanelRequisiciones::getEstadoSolicitud($DatSol->estado);
                                                                    echo $estado[0]->descripcion;
                                                                    echo '</font>';
                                                                    ?>
                                                                </td>

                                                                <td style="text-align: center">
                                                                    <button type="button" class="btn btn-default light"
                                                                        onclick="window.location.href='{{ asset ('/panel/requisiciones/consultausr/masinfo/')}}<?= $DatSol->num_solicitud ?>'"
                                                                        title="Más información">
                                                                        <i class="fa fa-exclamation-circle fa-lg"
                                                                            style="color:#AEBF25;"></i>
                                                                    </button>
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
                        </div>
                        <!-- -------------- /Column Center -------------- -->
                    </div>
                </section>
                <!-- -------------- /Content -------------- -->
            </section>
        </div>

        @include('includes-CDN/include-script')

    </body>

    </html>
@endforeach
