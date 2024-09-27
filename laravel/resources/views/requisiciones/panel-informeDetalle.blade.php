<?php

use App\Models\Requisiciones\PanelRequisiciones;
use App\Models\Requisiciones\PanelMotivos;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Requisición de personal | Informe
        </title>
        @include('includes-CDN/include-head')
    </head>

    <body onload="CIRESTADOS(), BARMOTIVOS()">
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
                                <a href="{{ asset ('/panel/requisiciones/informe')}}" title="Requisiciones > Informe">
                                    <font color="#34495e">
                                        Requisiciones > Informe >
                                    </font>
                                    <font color="#b4c056">
                                        Detalle
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset ('/panel/requisiciones/informe')}}" class="btn btn-primary btn-sm ml10"
                            title="Requisiciones > Informe">
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
                                    <table id="message-table" class="table theme-warning br-t">
                                        <thead>
                                            <tr style="background-color:#39405a">
                                                <th style="color:white;" colspan="6">
                                                    Informe requisición de personal
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <th>
                                                    Fecha desde:
                                                </th>
                                                <td>
                                                    <?php
                                                    if ($Desde == '') {
                                                        echo 'No ingresada';
                                                    } else {
                                                        echo $Desde;
                                                    }
                                                    ?>
                                                </td>

                                                <th>
                                                    Fecha hasta:
                                                </th>
                                                <td>
                                                    <?php
                                                    if ($Hasta == '') {
                                                        echo 'No ingresada';
                                                    } else {
                                                        echo $Hasta;
                                                    }
                                                    ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th width="240">
                                                    Cantidad de solicitudes:
                                                </th>
                                                <th colspan="3">
                                                    <font size="4">
                                                        <?php
                                                        echo $Cantidad = PanelRequisiciones::TSolicitudes($Desde, $Hasta);
                                                        ?>
                                                    </font>
                                                </th>
                                            </tr>

                                            <tr>
                                                <th style="vertical-align: top;">
                                                    Solicitudes por estado:
                                                </th>
                                                <td style="vertical-align: top;" colspan="3">
                                                    <table valign="top" style="width:830px;">
                                                        <tr>
                                                            <th>
                                                                <?php
                                                                $EstadosSl = PanelRequisiciones::ConEstadosSolicitudes($Desde, $Hasta);
                                                                $t = $val = $prog = 0;
                                                                $texto = $valores = '';
                                                                ?>

                                                                @foreach ($EstadosSl as $DatEst)
                                                                    <?php
                                                                    $t = $t + $DatEst->cant;
                                                                    ?>
                                                                @endforeach

                                                                @foreach ($EstadosSl as $DatEst)
                                                                    <?php
                                                                    $val = $DatEst->cant;
                                                                    $prog = round(($val * 100) / $t, 1);

                                                                    $valores = $valores . "'$prog', ";

                                                                    $estado = PanelRequisiciones::getEstadoSolicitud($DatEst->estado);
                                                                    $texto = $texto . "'" . $estado[0]->descripcion . ": $prog% ($val)', ";
                                                                    ?>
                                                                @endforeach

                                                                <!-- -------------- Imagen circular -------------- -->
                                                                <canvas id="cirestados" width="100%"
                                                                    height="20"></canvas>
                                                                <script type="text/javascript">
                                                                    function CIRESTADOS() {
                                                                        var ctx = document.getElementById("cirestados");
                                                                        var myPieChart = new Chart(ctx, {
                                                                            type: 'doughnut',
                                                                            data: {
                                                                                labels: [{{ $texto }}],
                                                                                datasets: [{
                                                                                    data: [{{ $valores }}],
                                                                                    backgroundColor: ['#A8CB2A', '#23469D', '#FEDA00', '#6CBCED', '#00833A', '#232F76',
                                                                                        '#e8daef', '#ffbf95'
                                                                                    ],
                                                                                    borderColor: "white",
                                                                                    borderWidth: 2
                                                                                }],
                                                                            },
                                                                            options: {
                                                                                legend: {
                                                                                    display: true,
                                                                                    labels: {
                                                                                        fontSize: 12
                                                                                    },
                                                                                    position: 'right'
                                                                                }
                                                                            }
                                                                        });
                                                                    }
                                                                </script>
                                                                <!-- -------------- /Imagen circular -------------- -->
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th style="vertical-align: top;">
                                                    Solicitudes por motivos:
                                                </th>
                                                <td style="vertical-align: top;" colspan="3">
                                                    <table valign="top" style="width:700px;">
                                                        <tr>
                                                            <th align="center">
                                                                <br>

                                                                <?php
                                                                $MotivosSl = PanelRequisiciones::ConMotivosSolicitudes($Desde, $Hasta);
                                                                $texto = $valores = '';
                                                                $mayor = 0;
                                                                ?>
                                                                @foreach ($MotivosSl as $DatMot)
                                                                    <?php
                                                                    if ($DatMot->motivo == 'RP') {
                                                                        $texto = $texto . "'Reemplazo de personal', ";
                                                                    } elseif ($DatMot->motivo == 'CN') {
                                                                        $texto = $texto . "'Incremento de personal (C.N.)', ";
                                                                    } elseif ($DatMot->motivo == 'LM') {
                                                                        $texto = $texto . "'Licencia de maternidad', ";
                                                                    } elseif ($DatMot->motivo == 'IP') {
                                                                        $texto = $texto . "'Incapacidad permanente', ";
                                                                    }

                                                                    $valores = $valores . "'$DatMot->cant', ";

                                                                    if ($mayor < $DatMot->cant) {
                                                                        $mayor = $DatMot->cant;
                                                                    }
                                                                    ?>
                                                                @endforeach

                                                                <!-- -------------- Diagrama de barras -------------- -->
                                                                <canvas id="barmotivos" width="100%"
                                                                    height="25"></canvas>
                                                                <script type="text/javascript">
                                                                    function BARMOTIVOS() {
                                                                        var ctx = document.getElementById("barmotivos");
                                                                        var myPieChart = new Chart(ctx, {
                                                                            type: 'bar',
                                                                            data: {
                                                                                labels: [{{ $texto }}],
                                                                                datasets: [{
                                                                                    label: "Cantidad",
                                                                                    backgroundColor: "#A8CB2A",
                                                                                    borderColor: "#00833A",
                                                                                    data: [{{ $valores }}],
                                                                                    borderWidth: 3
                                                                                }],
                                                                            },
                                                                            options: {
                                                                                animation: {
                                                                                    onComplete: function() {
                                                                                        var chartInstance = this.chart,
                                                                                            ctx = chartInstance.ctx;
                                                                                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart
                                                                                            .defaults.global.defaultFontStyle,
                                                                                            Chart.defaults.global.defaultFontFamily);
                                                                                        ctx.textAlign = 'center';
                                                                                        ctx.textBaseline = "top";
                                                                                        ctx.font = "20px Lato, Arial";
                                                                                        ctx.fillStyle = "white";
                                                                                        this.data.datasets.forEach(function(dataset, i) {
                                                                                            var meta = chartInstance.controller.getDatasetMeta(i);
                                                                                            meta.data.forEach(function(bar, index) {
                                                                                                if (dataset.data[index] > 0) {
                                                                                                    var data = dataset.data[index];
                                                                                                    ctx.fillText(data, bar._model.x, bar._model.y);
                                                                                                }
                                                                                            });
                                                                                        });
                                                                                    }
                                                                                },
                                                                                scales: {
                                                                                    xAxes: [{
                                                                                        time: {
                                                                                            unit: 'month'
                                                                                        },
                                                                                        gridLines: {
                                                                                            display: false
                                                                                        },
                                                                                        ticks: {
                                                                                            maxTicksLimit: 6
                                                                                        }
                                                                                    }],
                                                                                    yAxes: [{
                                                                                        ticks: {
                                                                                            min: 0,
                                                                                            max: {{ $mayor }},
                                                                                            maxTicksLimit: 8
                                                                                        },
                                                                                        gridLines: {
                                                                                            display: true
                                                                                        }
                                                                                    }],
                                                                                },
                                                                                legend: {
                                                                                    display: false
                                                                                }
                                                                            }
                                                                        });
                                                                    }
                                                                </script>
                                                                <!-- -------------- /Imagen barras -------------- -->
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th style="vertical-align: top;">
                                                    Cargos solicitados:
                                                </th>

                                                <td style="vertical-align: top;" colspan="3">
                                                    <?php
                                                    $CargosSl = PanelRequisiciones::ConCargosSolicitudes($Desde, $Hasta);
                                                    ?>
                                                    <table id="message-table" class="table theme-warning br-t"
                                                        valign="top" style="width:800px;">
                                                        <tr style="background-color:#67d3e0; color:#34495e;">
                                                            <th>
                                                                Cargo
                                                            </th>
                                                            <th style="text-align:center" colspan="2">
                                                                Cantidad
                                                            </th>
                                                            <th style="text-align:right">
                                                                %
                                                            </th>
                                                            <th style="text-align:center">
                                                                Contratados
                                                            </th>
                                                            <th style="text-align:center">
                                                                En proceso
                                                            </th>
                                                        </tr>

                                                        <?php
                                                        $t = 0;
                                                        $u = 0;
                                                        $alt = 0;
                                                        $sumc = 0;
                                                        $sume = 0;
                                                        ?>
                                                        @foreach ($CargosSl as $DatCar)
                                                            <?php
                                                            $t = $t + $DatCar->cant;
                                                            ?>
                                                        @endforeach

                                                        @foreach ($CargosSl as $DatCar)
                                                            <tr>
                                                                <?php
                                                                echo "<td style=\"text-align:left\">";
                                                                $nombrec = PanelCargos::getCargo($DatCar->cargo);
                                                                $Area = PanelAreas::getArea($nombrec[0]->area);
                                                                $Empresa = PanelEmpresas::getEmpresa($Area[0]->empresa);
                                                                echo $nombrec[0]->descripcion;
                                                                echo '<br>';
                                                                echo $Area[0]->descripcion . ' - ' . $Empresa[0]->nombre;
                                                                echo '</td>';

                                                                echo "<th style=\"text-align:right\">";
                                                                echo $cta = $DatCar->cant;
                                                                $prog = round(($cta * 100) / $t, 2);
                                                                if ($alt == 0) {
                                                                    $alt = $prog;
                                                                }
                                                                echo '</th>';

                                                                echo "<th style=\"text-align:center\">";
                                                                echo "<progress id=\"file\" max=\"$alt\" value=\"$prog\" style=\"width:50px;\"> $prog% </progress>";
                                                                echo '</th>';

                                                                echo "<th style=\"text-align:right\">";
                                                                echo $prog . ' %';
                                                                echo '</th>';

                                                                echo "<th style=\"text-align:right\">";
                                                                echo $contratados = PanelRequisiciones::CargoContratados($DatCar->cargo);
                                                                $sumc = $sumc + $contratados;
                                                                echo '</th>';

                                                                echo "<th style=\"text-align:right\">";
                                                                echo $proceso = PanelRequisiciones::CargoEnproceso($DatCar->cargo);
                                                                $sume = $sume + $proceso;
                                                                echo '</th>';
                                                                ?>
                                                            </tr>
                                                        @endforeach

                                                        <tr>
                                                            <td>
                                                            </td>

                                                            <th colspan="2" style="text-align:center">
                                                                <font size="3">
                                                                    <?= $t ?>
                                                                </font>
                                                            </th>

                                                            <td>
                                                            </td>

                                                            <th style="text-align:right">
                                                                <font size="3">
                                                                    <?= $sumc ?>
                                                                </font>
                                                            </th>

                                                            <th style="text-align:right">
                                                                <font size="3">
                                                                    <?= $sume ?>
                                                                </font>
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th style="vertical-align: top;">
                                                    Solicitudes rechazadas por nómina:
                                                </th>

                                                <td style="vertical-align: top;" colspan="3">
                                                    <?php
                                                    $RechaNomina = PanelRequisiciones::ConRechazosNomina($Desde, $Hasta);

                                                    ?>
                                                    <table id="message-table" class="table theme-warning br-t"
                                                        valign="top" style="width:800px;">
                                                        <tr style="background-color:#67d3e0; color:#34495e;">
                                                            <th>
                                                                Motivo de rechazo
                                                            </th>
                                                            <th style="text-align:center" colspan="2">
                                                                Cantidad
                                                            </th>
                                                            <th style="text-align:right">
                                                                %
                                                            </th>
                                                        </tr>

                                                        <?php
                                                        $t = 0;
                                                        $u = 0;
                                                        $alt = 0;
                                                        $sumc = 0;
                                                        $sume = 0;
                                                        ?>
                                                        @foreach ($RechaNomina as $DatRec)
                                                            <?php
                                                            $t = $t + $DatRec->cant;
                                                            ?>
                                                        @endforeach

                                                        @foreach ($RechaNomina as $DatRec)
                                                            <tr>
                                                                <?php
                                                                $motivo = PanelMotivos::where('id_motivo', $DatRec->rechazo_nomina)->get();

                                                                echo "<td style=\"text-align:left\">";
                                                                echo $motivo[0]->descripcion;
                                                                echo '</td>';

                                                                echo "<th style=\"text-align:right\">";
                                                                echo $cta = $DatRec->cant;
                                                                $prog = round(($cta * 100) / $t, 2);
                                                                if ($alt == 0) {
                                                                    $alt = $prog;
                                                                }
                                                                echo '</th>';

                                                                echo "<th style=\"text-align:center\">";
                                                                echo "<progress id=\"file\" max=\"$alt\" value=\"$prog\" style=\"width:50px;\"> $prog% </progress>";
                                                                echo '</th>';

                                                                echo "<th style=\"text-align:right\">";
                                                                echo $prog . ' %';
                                                                echo '</th>';
                                                                ?>
                                                            </tr>
                                                        @endforeach

                                                        <tr>
                                                            <td>
                                                            </td>

                                                            <th colspan="2" style="text-align:center">
                                                                <font size="3">
                                                                    <?= $t ?>
                                                                </font>
                                                            </th>

                                                            <td>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th style="vertical-align: top;">
                                                    Solicitudes no autorizadas por gerencia de personas:
                                                </th>

                                                <td style="vertical-align: top;" colspan="3">
                                                    <?php
                                                    $RechaGerencia = PanelRequisiciones::ConRechazosGerencia($Desde, $Hasta);
                                                    ?>
                                                    <table id="message-table" class="table theme-warning br-t"
                                                        valign="top" style="width:800px;">
                                                        <tr style="background-color:#67d3e0; color:#34495e;">
                                                            <th>
                                                                Motivo de rechazo
                                                            </th>
                                                            <th style="text-align:center" colspan="2">
                                                                Cantidad
                                                            </th>
                                                            <th style="text-align:right">
                                                                %
                                                            </th>
                                                        </tr>

                                                        <?php
                                                        $t = 0;
                                                        $u = 0;
                                                        $alt = 0;
                                                        $sumc = 0;
                                                        $sume = 0;
                                                        ?>
                                                        @foreach ($RechaGerencia as $DatRec)
                                                            <?php
                                                            $t = $t + $DatRec->cant;
                                                            ?>
                                                        @endforeach

                                                        @foreach ($RechaGerencia as $DatRec)
                                                            <tr>
                                                                <?php
                                                                $motivo = PanelMotivos::where('id_motivo', $DatRec->rechazo_gerencia)->get();
                                                                echo "<td style=\"text-align:left\">";
                                                                echo $motivo[0]->descripcion;
                                                                echo '</td>';

                                                                echo "<th style=\"text-align:right\">";
                                                                echo $cta = $DatRec->cant;
                                                                $prog = round(($cta * 100) / $t, 2);
                                                                if ($alt == 0) {
                                                                    $alt = $prog;
                                                                }
                                                                echo '</th>';

                                                                echo "<th style=\"text-align:center\">";
                                                                echo "<progress id=\"file\" max=\"$alt\" value=\"$prog\" style=\"width:50px;\"> $prog% </progress>";
                                                                echo '</th>';

                                                                echo "<th style=\"text-align:right\">";
                                                                echo $prog . ' %';
                                                                echo '</th>';
                                                                ?>
                                                            </tr>
                                                        @endforeach

                                                        <tr>
                                                            <td>
                                                            </td>

                                                            <th colspan="2" style="text-align:center">
                                                                <font size="3">
                                                                    <?= $t ?>
                                                                </font>
                                                            </th>

                                                            <td>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th style="vertical-align: top;">
                                                    Solicitudes canceladas:
                                                </th>

                                                <td style="vertical-align: top;" colspan="3">
                                                    <?php
                                                    $RechaGerencia = PanelRequisiciones::ConSolicitudesCanceladas($Desde, $Hasta);
                                                    ?>
                                                    <table id="message-table" class="table theme-warning br-t"
                                                        valign="top" style="width:800px;">
                                                        <tr style="background-color:#67d3e0; color:#34495e;">
                                                            <th>
                                                                Motivo de rechazo
                                                            </th>
                                                            <th style="text-align:center" colspan="2">
                                                                Cantidad
                                                            </th>
                                                            <th style="text-align:right">
                                                                %
                                                            </th>
                                                        </tr>

                                                        <?php
                                                        $t = 0;
                                                        $u = 0;
                                                        $alt = 0;
                                                        $sumc = 0;
                                                        $sume = 0;
                                                        ?>
                                                        @foreach ($RechaGerencia as $DatRec)
                                                            <?php
                                                            $t = $t + $DatRec->cant;
                                                            ?>
                                                        @endforeach

                                                        @foreach ($RechaGerencia as $DatRec)
                                                            <tr>
                                                                <?php
                                                                $motivo = PanelMotivos::where('id_motivo', $DatRec->motivo_rechazo)->get();
                                                                echo "<td style=\"text-align:left\">";
                                                                echo $motivo[0]->descripcion;
                                                                echo '</td>';

                                                                echo "<th style=\"text-align:right\">";
                                                                echo $cta = $DatRec->cant;
                                                                $prog = round(($cta * 100) / $t, 2);
                                                                if ($alt == 0) {
                                                                    $alt = $prog;
                                                                }
                                                                echo '</th>';

                                                                echo "<th style=\"text-align:center\">";
                                                                echo "<progress id=\"file\" max=\"$alt\" value=\"$prog\" style=\"width:50px;\"> $prog% </progress>";
                                                                echo '</th>';

                                                                echo "<th style=\"text-align:right\">";
                                                                echo $prog . ' %';
                                                                echo '</th>';
                                                                ?>
                                                            </tr>
                                                        @endforeach

                                                        <tr>
                                                            <td>
                                                            </td>

                                                            <th colspan="2" style="text-align:center">
                                                                <font size="3">
                                                                    <?= $t ?>
                                                                </font>
                                                            </th>

                                                            <td>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th style="vertical-align: top;">
                                                    Motivos por los cuales no fueron superadas las entrevistas:
                                                    <br><br>
                                                    (Entrevistas informadas dentro del período de fecha dado)
                                                </th>

                                                <td style="vertical-align: top;" colspan="3">
                                                    <?php
                                                    $RechaEntrevista = PanelRequisiciones::ConMotCandRechazadosEntrevistas($Desde, $Hasta);
                                                    ?>
                                                    <table id="message-table" class="table theme-warning br-t"
                                                        valign="top" style="width:800px;">
                                                        <tr style="background-color:#67d3e0; color:#34495e;">
                                                            <th>
                                                                Motivo de rechazo
                                                            </th>
                                                            <th style="text-align:center" colspan="2">
                                                                Cantidad
                                                            </th>
                                                            <th style="text-align:right">
                                                                %
                                                            </th>
                                                        </tr>

                                                        <?php
                                                        $t = 0;
                                                        $u = 0;
                                                        $alt = 0;
                                                        $sumc = 0;
                                                        $sume = 0;
                                                        ?>
                                                        @foreach ($RechaEntrevista as $DatRec)
                                                            <?php
                                                            $t = $t + $DatRec->cant;
                                                            ?>
                                                        @endforeach

                                                        @foreach ($RechaEntrevista as $DatRec)
                                                            <tr>
                                                                <?php
                                                                $motivo = PanelMotivos::where('id_motivo', $DatRec->rechazo_entrevista)->get();
                                                                echo "<td style=\"text-align:left\">";
                                                                echo $motivo[0]->descripcion;
                                                                echo '</td>';

                                                                echo "<th style=\"text-align:right\">";
                                                                echo $cta = $DatRec->cant;
                                                                $prog = round(($cta * 100) / $t, 2);
                                                                if ($alt == 0) {
                                                                    $alt = $prog;
                                                                }
                                                                echo '</th>';

                                                                echo "<th style=\"text-align:center\">";
                                                                echo "<progress id=\"file\" max=\"$alt\" value=\"$prog\" style=\"width:50px;\"> $prog% </progress>";
                                                                echo '</th>';

                                                                echo "<th style=\"text-align:right\">";
                                                                echo $prog . ' %';
                                                                echo '</th>';
                                                                ?>
                                                            </tr>
                                                        @endforeach

                                                        <tr>
                                                            <td>
                                                            </td>

                                                            <th colspan="2" style="text-align:center">
                                                                <font size="3">
                                                                    <?= $t ?>
                                                                </font>
                                                            </th>

                                                            <td>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th style="vertical-align: top;">
                                                    Motivos por los cuales no se contrató, aun siendo aprobados en la
                                                    entrevista:
                                                    <br><br>
                                                    (Contrataciones informadas dentro del período de fecha dado)
                                                </th>

                                                <td style="vertical-align: top;" colspan="3">
                                                    <?php
                                                    $RechaContratacion = PanelRequisiciones::ConMotCandRechazadosContratacion($Desde, $Hasta);
                                                    ?>
                                                    <table id="message-table" class="table theme-warning br-t"
                                                        valign="top" style="width:800px;">
                                                        <tr style="background-color:#67d3e0; color:#34495e;">
                                                            <th>
                                                                Motivo de rechazo
                                                            </th>
                                                            <th style="text-align:center" colspan="2">
                                                                Cantidad
                                                            </th>
                                                            <th style="text-align:right">
                                                                %
                                                            </th>
                                                        </tr>

                                                        <?php
                                                        $t = 0;
                                                        $u = 0;
                                                        $alt = 0;
                                                        $sumc = 0;
                                                        $sume = 0;
                                                        ?>
                                                        @foreach ($RechaContratacion as $DatRec)
                                                            <?php
                                                            $t = $t + $DatRec->cant;
                                                            ?>
                                                        @endforeach

                                                        @foreach ($RechaContratacion as $DatRec)
                                                            <tr>
                                                                <?php
                                                                $motivo = PanelMotivos::where('id_motivo', $DatRec->rechazo_contrato)->get();

                                                                echo "<td style=\"text-align:left\">";
                                                                echo $motivo[0]->descripcion;
                                                                echo '</td>';

                                                                echo "<th style=\"text-align:right\">";
                                                                echo $cta = $DatRec->cant;
                                                                $prog = round(($cta * 100) / $t, 2);
                                                                if ($alt == 0) {
                                                                    $alt = $prog;
                                                                }
                                                                echo '</th>';

                                                                echo "<th style=\"text-align:center\">";
                                                                echo "<progress id=\"file\" max=\"$alt\" value=\"$prog\" style=\"width:50px;\"> $prog% </progress>";
                                                                echo '</th>';

                                                                echo "<th style=\"text-align:right\">";
                                                                echo $prog . ' %';
                                                                echo '</th>';
                                                                ?>
                                                            </tr>
                                                        @endforeach

                                                        <tr>
                                                            <td>
                                                            </td>

                                                            <th colspan="2" style="text-align:center">
                                                                <font size="3">
                                                                    <?= $t ?>
                                                                </font>
                                                            </th>

                                                            <td>
                                                            </td>
                                                        </tr>
                                                    </table>
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

        @include('includes-CDN/include-script')

    </body>

    </html>
@endforeach
