<?php

use App\Models\Requerimientos\PanelGrupos;
use App\Models\Requerimientos\PanelSolicitudes;
use App\Models\Requerimientos\PanelCategorias;
use App\Models\Requerimientos\PanelPriorizaciones;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelAreas;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Requerimientos | Informe
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

        <!-- -------------- CSS - Para gráficos -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/panelfiles/assets/allcp/forms/css/circulo.css') }}">

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


    <?php
    function nombremes($mes)
    {
        if ($mes == 1) {
            $nonmes = 'Enero';
        } elseif ($mes == 2) {
            $nonmes = 'Febrero';
        } elseif ($mes == 3) {
            $nonmes = 'Marzo';
        } elseif ($mes == 4) {
            $nonmes = 'Abril';
        } elseif ($mes == 5) {
            $nonmes = 'Mayo';
        } elseif ($mes == 6) {
            $nonmes = 'Junio';
        } elseif ($mes == 7) {
            $nonmes = 'Julio';
        } elseif ($mes == 8) {
            $nonmes = 'Agosto';
        } elseif ($mes == 9) {
            $nonmes = 'Septiembre';
        } elseif ($mes == 10) {
            $nonmes = 'Octubre';
        } elseif ($mes == 11) {
            $nonmes = 'Noviembre';
        } elseif ($mes == 12) {
            $nonmes = 'Diciembre';
        }

        return $nonmes;
    }

    for ($a = $Meses - 1; $a >= 0; $a--) {
        $Nombre[$a] = nombremes(date('m', strtotime("-$a month")));
    }

    $nomb = "'" . implode("', '", $Nombre) . "'";

    $Empleados = PanelGrupos::getGrupoEmpleados($Grupo);
    $bar = '';
    ?>
    @foreach ($Empleados as $DatEmp)
        <?php
        $bar = $bar . ', BAREMPLEADO' . $DatEmp->id_empleado . '()';
        ?>
    @endforeach

    <body onload="BARENCUESTA(), BARENCUESTA1() <?= $bar ?>;">
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
                                <?php
                                $nomgrupo = PanelGrupos::getGrupo($Grupo);
                                ?>
                                <a href="{{ asset('/panel/requerimientos/informe') }}"
                                    title="Requerimientos > Informe">
                                    <font color="#34495e">
                                        Requerimientos > Informe > Grupo <?= $nomgrupo[0]->descripcion ?> >
                                    </font>
                                    <font color="#b4c056">
                                        Informe requerimientos por meses
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset('/panel/requerimientos/informe') }}" class="btn btn-primary btn-sm ml10"
                            title="Requerimientos > Informe">
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
                                                <th style="color:white;" colspan="2">
                                                    Informe requerimientos por meses para el grupo
                                                    <?= $nomgrupo[0]->descripcion ?>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <th>
                                                    Periodo:
                                                </th>
                                                <td>
                                                    Últimos <?= $Meses ?> meses
                                                </td>
                                            </tr>

                                            <tr>
                                                <th colspan="2">
                                                    <hr style="border-top: 3px solid #8c8b8b;">
                                                </th>
                                            </tr>

                                            <tr>
                                                <th style="vertical-align: top;">
                                                    Percepción de los usuarios:
                                                    <br>
                                                    (cantidades, fecha de cierre)
                                                </th>
                                                <td style="vertical-align: top;">
                                                    <table valign="top" style="width:800px;">
                                                        <tr>
                                                            <th>
                                                                <br>
                                                                <?php
                                  $mayor = 0;
                                  for($a=($Meses-1);$a>=0;$a--)
                                   {
                                    $Ano = date('Y', strtotime("-$a month"));
                                    $Mes = date('m', strtotime("-$a month"));
                                    $EncuestaRq = PanelSolicitudes::ConEncuestaReqMensual($Grupo, $Ano, $Mes);
                                    $muy = $sas = $ins = 0;

                                    ?>
                                                                @foreach ($EncuestaRq as $DatEnc)
                                                                    <?php
                                                                    if ($DatEnc->cant > $mayor) {
                                                                        $mayor = $DatEnc->cant;
                                                                    }

                                                                    if ($DatEnc->calificacion == 'M') {
                                                                        $muy = $DatEnc->cant;
                                                                    } elseif ($DatEnc->calificacion == 'S') {
                                                                        $sas = $DatEnc->cant;
                                                                    } elseif ($DatEnc->calificacion == 'I') {
                                                                        $ins = $DatEnc->cant;
                                                                    }
                                                                    ?>
                                                                @endforeach
                                                                <?php
                                    $m[] = $muy;
                                    $s[] = $sas;
                                    $i[] = $ins;
                                   }

                                  $val1 = "'".implode("', '", $m)."'";
                                  $val2 = "'".implode("', '", $s)."'";
                                  $val3 = "'".implode("', '", $i)."'";

                                  $mayor = $mayor + 4;
                                  ?>
                                                                <!-- -------------- Diagrama de barras -------------- -->
                                                                <canvas id="barencuesta" width="100%"
                                                                    height="40"></canvas>
                                                                <script type="text/javascript">
                                                                    function BARENCUESTA() {
                                                                        var ctx = document.getElementById("barencuesta");
                                                                        var myPieChart = new Chart(ctx, {
                                                                            type: 'bar',
                                                                            data: {
                                                                                labels: [<?php echo $nomb; ?>],
                                                                                datasets: [{
                                                                                        label: "Muy satisfecho",
                                                                                        backgroundColor: ['#FEDA00', '#FEDA00', '#FEDA00', '#FEDA00', '#FEDA00', '#FEDA00',
                                                                                            '#FEDA00', '#FEDA00', '#FEDA00', '#FEDA00', '#FEDA00', '#FEDA00'
                                                                                        ],
                                                                                        borderColor: "#000000",
                                                                                        data: [<?= $val1 ?>],
                                                                                        borderWidth: 1
                                                                                    },
                                                                                    {
                                                                                        label: "Satisfecho",
                                                                                        backgroundColor: ['#FF8C19', '#FF8C19', '#FF8C19', '#FF8C19', '#FF8C19', '#FF8C19',
                                                                                            '#FF8C19', '#FF8C19', '#FF8C19', '#FF8C19', '#FF8C19', '#FF8C19'
                                                                                        ],
                                                                                        borderColor: "#000000",
                                                                                        data: [<?= $val2 ?>],
                                                                                        borderWidth: 1
                                                                                    },
                                                                                    {
                                                                                        label: "Insatisfecho",
                                                                                        backgroundColor: ['red', 'red', 'red', 'red', 'red', 'red', 'red', 'red', 'red',
                                                                                            'red', 'red', 'red'
                                                                                        ],
                                                                                        borderColor: "#000000",
                                                                                        data: [<?= $val3 ?>],
                                                                                        borderWidth: 1
                                                                                    }
                                                                                ],
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
                                                                                        ctx.font = "23px Lato, Arial";
                                                                                        ctx.fillStyle = "white";

                                                                                        ctx.shadowBlur = 5;
                                                                                        ctx.shadowOffsetX = 2;
                                                                                        ctx.shadowOffsetY = 2;
                                                                                        ctx.shadowColor = "#333";

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
                                                                                            display: true
                                                                                        },
                                                                                        ticks: {
                                                                                            maxTicksLimit: 12
                                                                                        }
                                                                                    }],
                                                                                    yAxes: [{
                                                                                        ticks: {
                                                                                            min: 0,
                                                                                            max: <?= $mayor ?>,
                                                                                            maxTicksLimit: 5
                                                                                        },
                                                                                        gridLines: {
                                                                                            display: true
                                                                                        }
                                                                                    }],
                                                                                },
                                                                                legend: {
                                                                                    display: true
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
                                                <th colspan="2">
                                                    <hr style="border-top: 3px solid #8c8b8b;">
                                                </th>
                                            </tr>

                                            <tr>
                                                <th style="vertical-align: top;">
                                                    Percepción de los usuarios:
                                                    <br>
                                                    (porcentaje, fecha de cierre)
                                                </th>
                                                <td style="vertical-align: top;">
                                                    <table valign="top" style="width:800px;">
                                                        <tr>
                                                            <th>
                                                                <br>
                                                                <?php
                                  for($a=($Meses-1);$a>=0;$a--)
                                   {
                                    $Ano = date('Y', strtotime("-$a month"));
                                    $Mes = date('m', strtotime("-$a month"));
                                    $EncuestaRq = PanelSolicitudes::ConEncuestaReqMensual($Grupo, $Ano, $Mes);
                                    $muy = $sas = $ins = $t = 0;

                                    ?>
                                                                @foreach ($EncuestaRq as $DatEnc)
                                                                    <?php
                                                                    $t = $t + $DatEnc->cant;
                                                                    ?>
                                                                @endforeach

                                                                @foreach ($EncuestaRq as $DatEnc)
                                                                    <?php
                                                                    $val = $DatEnc->cant;
                                                                    $prog = round(($val * 100) / $t, 1);

                                                                    if ($DatEnc->calificacion == 'M') {
                                                                        $muy = $prog;
                                                                    } elseif ($DatEnc->calificacion == 'S') {
                                                                        $sas = $prog;
                                                                    } elseif ($DatEnc->calificacion == 'I') {
                                                                        $ins = $prog;
                                                                    }
                                                                    ?>
                                                                @endforeach
                                                                <?php
                                    $m1[] = $muy;
                                    $s1[] = $sas;
                                    $i1[] = $ins;
                                   }

                                  $valpor1 = "'".implode("', '", $m1)."'";
                                  $valpor2 = "'".implode("', '", $s1)."'";
                                  $valpor3 = "'".implode("', '", $i1)."'";

                                  ?>
                                                                <!-- -------------- Diagrama de barras -------------- -->
                                                                <canvas id="barencuesta1" width="100%"
                                                                    height="25"></canvas>
                                                                <script type="text/javascript">
                                                                    function BARENCUESTA1() {
                                                                        var ctx = document.getElementById("barencuesta1");
                                                                        var myPieChart = new Chart(ctx, {
                                                                            type: 'bar',
                                                                            data: {
                                                                                labels: [<?php echo $nomb; ?>],
                                                                                datasets: [{
                                                                                        label: "Muy satisfecho",
                                                                                        backgroundColor: ['#FEDA00', '#FEDA00', '#FEDA00', '#FEDA00', '#FEDA00', '#FEDA00',
                                                                                            '#FEDA00', '#FEDA00', '#FEDA00', '#FEDA00', '#FEDA00', '#FEDA00'
                                                                                        ],
                                                                                        borderColor: "#000000",
                                                                                        data: [<?= $valpor1 ?>],
                                                                                        formatter: (data) => data + "%",
                                                                                        borderWidth: 1
                                                                                    },
                                                                                    {
                                                                                        label: "Satisfecho",
                                                                                        backgroundColor: ['#FF8C19', '#FF8C19', '#FF8C19', '#FF8C19', '#FF8C19', '#FF8C19',
                                                                                            '#FF8C19', '#FF8C19', '#FF8C19', '#FF8C19', '#FF8C19', '#FF8C19'
                                                                                        ],
                                                                                        borderColor: "#000000",
                                                                                        data: [<?= $valpor2 ?>],
                                                                                        borderWidth: 1
                                                                                    },
                                                                                    {
                                                                                        label: "Insatisfecho",
                                                                                        backgroundColor: ['red', 'red', 'red', 'red', 'red', 'red', 'red', 'red', 'red',
                                                                                            'red', 'red', 'red'
                                                                                        ],
                                                                                        borderColor: "#000000",
                                                                                        data: [<?= $valpor3 ?>],
                                                                                        borderWidth: 1
                                                                                    }
                                                                                ],
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
                                                                                        ctx.font = "14px Lato, Arial";
                                                                                        ctx.fillStyle = "#000000";

                                                                                        ctx.shadowBlur = 7;
                                                                                        ctx.shadowOffsetX = 4;
                                                                                        ctx.shadowOffsetY = 4;
                                                                                        ctx.shadowColor = "#FFFFFF";

                                                                                        this.data.datasets.forEach(function(dataset, i) {
                                                                                            var meta = chartInstance.controller.getDatasetMeta(i);
                                                                                            meta.data.forEach(function(bar, index) {
                                                                                                if (dataset.data[index] > 0) {
                                                                                                    var data = dataset.data[index] + " %";
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
                                                                                            display: true
                                                                                        },
                                                                                        ticks: {
                                                                                            maxTicksLimit: 12
                                                                                        }
                                                                                    }],
                                                                                    yAxes: [{
                                                                                        ticks: {
                                                                                            min: 0,
                                                                                            max: 100,
                                                                                            maxTicksLimit: 5
                                                                                        },
                                                                                        gridLines: {
                                                                                            display: true
                                                                                        }
                                                                                    }],
                                                                                },
                                                                                legend: {
                                                                                    display: true
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
                                                <th colspan="2">
                                                    <hr style="border-top: 3px solid #8c8b8b;">
                                                </th>
                                            </tr>

                                            <?php
                                            $n = 0;
                                            ?>
                                            @foreach ($Empleados as $DatEmp)
                                                <tr>
                                                    <th style="vertical-align: top;">
                                                        Percepción de los usuarios:
                                                        <br>
                                                        <font color="black">
                                                            <?= $DatEmp->primer_nombre ?>
                                                            <?= $DatEmp->ot_nombre ?>
                                                            <?= $DatEmp->primer_apellido ?>
                                                            <?= $DatEmp->ot_apellido ?>
                                                        </font>
                                                        <br>
                                                        (fecha de cierre)
                                                    </th>

                                                    <td style="vertical-align: top;">
                                                        <table valign="top" style="width:800px;">
                                                            <tr>
                                                                <th>
                                                                    <br>
                                                                    <?php
                                    $n++;
                                    $mayor = 0;
                                    $mp = array();
                                    $sp = array();
                                    $xp = array();

                                    $nombregra = "barempleado".$DatEmp->id_empleado;

                                    for($a=($Meses-1);$a>=0;$a--)
                                     {
                                      $Ano = date('Y', strtotime("-$a month"));
                                      $Mes = date('m', strtotime("-$a month"));
                                      $EncuestaRq = PanelSolicitudes::ConEncuestaReqMensualEmp($Grupo, $Ano, $Mes, $DatEmp->id_empleado);
                                      $muy = $sas = $ins = 0;

                                      ?>
                                                                    @foreach ($EncuestaRq as $DatEnc)
                                                                        <?php
                                                                        if ($DatEnc->cant > $mayor) {
                                                                            $mayor = $DatEnc->cant;
                                                                        }

                                                                        if ($DatEnc->calificacion == 'M') {
                                                                            $muy = $DatEnc->cant;
                                                                        } elseif ($DatEnc->calificacion == 'S') {
                                                                            $sas = $DatEnc->cant;
                                                                        } elseif ($DatEnc->calificacion == 'I') {
                                                                            $ins = $DatEnc->cant;
                                                                        }
                                                                        ?>
                                                                    @endforeach
                                                                    <?php
                                      $mp[] = $muy;
                                      $sp[] = $sas;
                                      $xp[] = $ins;
                                     }

                                    $val1 = "'".implode("', '", $mp)."'";
                                    $val2 = "'".implode("', '", $sp)."'";
                                    $val3 = "'".implode("', '", $xp)."'";

                                    $mayor = $mayor + 4;
                                    ?>
                                                                    <!-- -------------- Diagrama de barras -------------- -->
                                                                    <canvas id="<?= $nombregra ?>" width="100%"
                                                                        height="40"></canvas>
                                                                    <script type="text/javascript">
                                                                        function BAREMPLEADO<?= $DatEmp->id_empleado ?>() {
                                                                            var ctx = document.getElementById("<?= $nombregra ?>");
                                                                            var myPieChart = new Chart(ctx, {
                                                                                type: 'bar',
                                                                                data: {
                                                                                    labels: [<?php echo $nomb; ?>],
                                                                                    datasets: [{
                                                                                            label: "Muy satisfecho",
                                                                                            backgroundColor: ['#FEDA00', '#FEDA00', '#FEDA00', '#FEDA00', '#FEDA00', '#FEDA00',
                                                                                                '#FEDA00', '#FEDA00', '#FEDA00', '#FEDA00', '#FEDA00', '#FEDA00'
                                                                                            ],
                                                                                            borderColor: "#000000",
                                                                                            data: [<?= $val1 ?>],
                                                                                            borderWidth: 2
                                                                                        },
                                                                                        {
                                                                                            label: "Satisfecho",
                                                                                            backgroundColor: ['#FF8C19', '#FF8C19', '#FF8C19', '#FF8C19', '#FF8C19', '#FF8C19',
                                                                                                '#FF8C19', '#FF8C19', '#FF8C19', '#FF8C19', '#FF8C19', '#FF8C19'
                                                                                            ],
                                                                                            borderColor: "#000000",
                                                                                            data: [<?= $val2 ?>],
                                                                                            borderWidth: 2
                                                                                        },
                                                                                        {
                                                                                            label: "Insatisfecho",
                                                                                            backgroundColor: ['red', 'red', 'red', 'red', 'red', 'red', 'red', 'red', 'red',
                                                                                                'red', 'red', 'red'
                                                                                            ],
                                                                                            borderColor: "#000000",
                                                                                            data: [<?= $val3 ?>],
                                                                                            borderWidth: 2
                                                                                        }
                                                                                    ],
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
                                                                                            ctx.font = "23px Lato, Arial";
                                                                                            ctx.fillStyle = "white";

                                                                                            ctx.shadowBlur = 5;
                                                                                            ctx.shadowOffsetX = 2;
                                                                                            ctx.shadowOffsetY = 2;
                                                                                            ctx.shadowColor = "#333";

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
                                                                                                display: true
                                                                                            },
                                                                                            ticks: {
                                                                                                maxTicksLimit: 12
                                                                                            }
                                                                                        }],
                                                                                        yAxes: [{
                                                                                            ticks: {
                                                                                                min: 0,
                                                                                                max: <?= $mayor ?>,
                                                                                                maxTicksLimit: 5
                                                                                            },
                                                                                            gridLines: {
                                                                                                display: true
                                                                                            }
                                                                                        }],
                                                                                    },
                                                                                    legend: {
                                                                                        display: true
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
                                            @endforeach
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

        <!-- -------------- Para los gráficos -------------- -->
        <script src="{{ asset('/panelfiles/assets/js/Chart.min.js') }}"></script>
        <!-- El mismo archivo pero apuntando a internet -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> -->
        <!-- -------------- /Scripts -------------- -->
    </body>

    </html>
@endforeach
