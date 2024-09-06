<?php
$server = '/Berhlan/public';

use App\Models\Requerimientos\PanelGrupos;
use App\Models\Requerimientos\PanelSolicitudes;
use App\Models\Requerimientos\PanelCategorias;
use App\Models\Requerimientos\PanelPriorizaciones;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelAreas;
?>

@foreach($DatosUsuario as $DatLog)
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
  <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

  <!-- -------------- CSS - theme -------------- -->
  <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/skin/default_skin/css/theme.css">

  <!-- -------------- CSS - Para gráficos -------------- -->
  <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/allcp/forms/css/circulo.css">

  <!-- -------------- CSS - allcp forms -------------- -->
  <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/allcp/forms/css/forms.min.css">
  <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/allcp/forms/css/forms.css">

  <!-- -------------- Plugins -------------- -->
  <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

  <!-- -------------- Favicon -------------- -->
  <link rel="shortcut icon" href="<?= $server ?>/panelfiles/assets/img/favicon.ico">

  <!-- Editor -->
  <script type="text/javascript" src="<?= $server ?>/panelfiles/ckeditor/ckeditor.js"></script>

  <!-- -------------- DataTables -------------- -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
</head>


<?php
if ($Desde != '')
  $Desdehora = $Desde . " 00:00:01";
else
  $Desdehora = "";

if ($Hasta != '')
  $Desdehasta = $Hasta . " 23:59:59";
else
  $Desdehasta = "";

//Calculo la información de los estados antes del body
$EstadosRq = PanelSolicitudes::ConEstadosRequerimientos($Grupo, $Desdehora, $Desdehasta);
$t   = 0;
$val1 = $val2 = $val3 = $val4 = $pval1 = $pval2 = $pval3 = $pval4 = 0;
$ttt[0] = 1;
$ttt[1] = 2;
$ttt[2] = 3;
$ttt[3] = 5;
?>
@foreach($EstadosRq as $DatEst)
<?php
$t = $t + $DatEst->cant;
?>
@endforeach



<body onload="BARATENDIDOS(), CIRPERCEPCION();">
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
              <a href="<?= $server ?>/panel/requerimientos/informe" title="Requerimientos > Informe">
                <font color="#34495e">
                  Requerimientos > Informe >
                </font>
                <font color="#b4c056">
                  Grupo <?= $nomgrupo[0]->descripcion ?>
                </font>
              </a>
            </li>
          </ul>
        </div>

        <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
          <a href="<?= $server ?>/panel/requerimientos/informe" class="btn btn-primary btn-sm ml10" title="Requerimientos > Informe">
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
                        Informe de requerimientos para el grupo <?= $nomgrupo[0]->descripcion ?>
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
                          if ($Desde == '')
                            echo "No ingresada";
                          else
                            echo $Desde;
                          ?>
                        </td>

                        <th>
                          Fecha hasta:
                        </th>
                        <td>
                          <?php
                          if ($Hasta == '')
                            echo "No ingresada";
                          else
                            echo $Hasta;
                          ?>
                        </td>
                      </tr>

                      <tr>
                        <th width="240">
                          Cantidad de requerimientos:
                        </th>
                        <th >
                          <font size="4">
                            <?php
                            echo $Cantidad = PanelSolicitudes::TRequerimientosGrupo($Grupo, $Desdehora, $Desdehasta);
                            ?>
                          </font>
                        </th>
                        <th width="240">
                            Cantidad de requerimientos atendidos:
                          </th>
                          <th >
                            <font size="4">
                              <?php
                              echo $Cantidad = PanelSolicitudes::TRequerimientosGrupoAtendidos($Grupo, $Desdehora, $Desdehasta);
                              ?>
                            </font>
                          </th>
                      </tr>

                      <tr>
                        <th width="240">
                          Requerimientos solicitados, establecidos como proyecto:
                        </th>
                        <th>
                          <font size="4">
                            <?php
                            echo $CantProyecto = PanelSolicitudes::TReqSolGrupoProyecto($Grupo, $Desdehora, $Desdehasta);
                            ?>
                          </font>
                        </th>

                        <th width="240">
                          Requerimientos solicitados, que dependen de terceros:
                        </th>
                        <th>
                          <font size="4">
                            <?php
                            echo $CantTerceros = PanelSolicitudes::TReqSolGrupoTerceros($Grupo, $Desdehora, $Desdehasta);
                            ?>
                          </font>
                        </th>
                      </tr>

                      <tr>
                        <th width="240">
                          Requerimientos atendidos, establecidos como proyecto:
                        </th>
                        <th>
                          <font size="4">
                            <?php
                            echo $Cantidad = PanelSolicitudes::TReqAteGrupoProyecto($Grupo, $Desdehora, $Desdehasta);
                            ?>
                          </font>
                        </th>

                        <th width="240">
                          Requerimientos atendidos, que dependen de terceros:
                        </th>
                        <th>
                          <font size="4">
                            <?php
                            echo $Cantidad = PanelSolicitudes::TReqAteGrupoTerceros($Grupo, $Desdehora, $Desdehasta);
                            ?>
                          </font>
                        </th>
                      </tr>

                      <tr>
                        <th colspan="4">
                          <hr style="border-top: 3px solid #8c8b8b;">
                        </th>
                      </tr>
                    <tr>
                      <th style="vertical-align: top;">
                        Requerimientos atendidos por:
                        <br>
                        (fecha cierre)
                      </th>
                      <td style="vertical-align: top;" colspan="3">
                        <table valign="top" style="width:800px;">
                          <tr>
                            <th>
                              <br>
                              @php
                              $EmpleadoRq = PanelSolicitudes::ConEmpleadosRequerimientos($Grupo, $Desdehora, $Desdehasta);
                              $e = 0;
                              $mayor = $nombres[0] = $valores[0] = 0;
                          @endphp

                          @foreach ($EmpleadoRq as $DatEmR)
                              @php
                                  if ($DatEmR->usr_atiende != '' && $DatEmR->usr_atiende != NULL) {
                                      $atiende = PanelEmpleados::getEmpleado($DatEmR->usr_atiende);
                                      $nombre = $atiende[0]->primer_nombre . "." . $atiende[0]->primer_apellido;
                                      $nombres[$e] = $nombre;
                                      $valores[$e] = $DatEmR->cant;
                                      $e++;
                                      if ($mayor < $DatEmR->cant)
                                          $mayor = $DatEmR->cant;
                                  }
                              @endphp
                          @endforeach

                          @php
                              $nomb = "'" . implode("', '", $nombres) . "'";
                              $val = implode(", ", $valores);
                          @endphp

                          @if (!isset($nomb) || !isset($val))
                              @php
                                  $nomb = 'No Definido';
                                  $val = 'No Definido';
                              @endphp
                          @endif
                              <!-- -------------- Diagrama de barras -------------- -->
                              <canvas id="baratendios" width="100%" height="35"></canvas>
                              <script type="text/javascript">
                                function BARATENDIDOS() {
                                  var ctx = document.getElementById("baratendios");
                                  var myPieChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                      labels: [<?php echo $nomb; ?>],
                                      datasets: [{
                                        label: "Atendidos",
                                        backgroundColor: ['#FEDA00', '#00833A', '#A8CB2A', '#6CBCED', '#FEDA00', '#00833A', '#A8CB2A', '#6CBCED', '#FEDA00', '#00833A', '#A8CB2A', '#6CBCED'],
                                        borderColor: "#000000",
                                        data: [<?= $val ?>],
                                        borderWidth: 2
                                      }],
                                    },
                                    options: {
                                      animation: {
                                        onComplete: function() {
                                          var chartInstance = this.chart,
                                            ctx = chartInstance.ctx;
                                          ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle,
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
                                            display: true
                                          },
                                          ticks: {
                                            maxTicksLimit: 10
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
                      <th colspan="4">
                        <hr style="border-top: 3px solid #8c8b8b;">
                      </th>
                    </tr>

                    <tr>
                      <th style="vertical-align: top;">
                        Requerimientos recibidos por áreas:
                        <br>
                        (fecha solicitud)
                      </th>
                      <td style="vertical-align: top;" colspan="3">
                        <?php
                        $AreasRq = PanelSolicitudes::ConAreasRequerimientos($Grupo, $Desdehora, $Desdehasta);
                        ?>
                        <table id="tablaareas" class="table theme-warning br-t" style="width:800px;">
                          <thead>
                            <tr style="background-color:#67d3e0; color:#34495e;">
                              <th>
                                Área
                              </th>
                              <th style="text-align:center">
                                Recibidos
                              </th>
                              <th style="text-align:center">
                              </th>
                              <th style="text-align:right">
                                %
                              </th>
                              <th style="text-align:right">
                                Cerrados
                              </th>
                              <th style="text-align:right">
                                Notificados
                              </th>
                              <th style="text-align:right">
                                Pendientes
                              </th>
                            </tr>
                          </thead>

                          <?php
                          $t   = 0;
                          $alt = 0;
                          ?>
                          @foreach($AreasRq as $DatAre)
                          <?php
                          $t = $t + $DatAre->cant;
                          ?>
                          @endforeach

                          @foreach($AreasRq as $DatAre)
                          <tr>
                            <td>
                              <?php
                              $nomArea = PanelAreas::getArea($DatAre->area);
                              echo $nomArea[0]->descripcion;
                              ?>
                            </td>

                            <?php
                            echo "<th style=\"text-align:right\">";
                            echo $cta = $DatAre->cant;
                            $prog = round((($cta * 100) / $t), 2);
                            if ($alt == 0)
                              $alt = $prog;
                            echo "</th>";

                            echo "<th style=\"text-align:center\">";
                            echo "<progress id=\"file\" max=\"$alt\" value=\"$prog\" style=\"width:50px;\"> $prog% </progress>";
                            echo "</th>";

                            echo "<th style=\"text-align:right\">";
                            echo $prog . " %";
                            echo "</th>";

                            echo "<th style=\"text-align:right\">";
                            echo $ctaAreaA = PanelSolicitudes::CtaAreaAtendido($Grupo, $Desdehora, $Desdehasta, $DatAre->area);
                            echo "</th>";

                            echo "<th style=\"text-align:right\">";
                            echo $ctaAreaN = PanelSolicitudes::CtaAreaNotificados($Grupo, $Desdehora, $Desdehasta, $DatAre->area);
                            echo "</th>";

                            echo "<th style=\"text-align:right\">";
                            echo $ctaArea = PanelSolicitudes::CtaAreaNoatendido($Grupo, $Desdehora, $Desdehasta, $DatAre->area);
                            echo "</th>";

                            ?>
                          </tr>
                          @endforeach
                        </table>
                      </td>
                    </tr>

                    <tr>
                      <th colspan="4">
                        <hr style="border-top: 3px solid #8c8b8b;">
                      </th>
                    </tr>

                    <tr>
                      <th style="vertical-align: top;">
                        Requerimientos atendidos por categorías:
                        <br>
                        (fecha cierre)
                      </th>
                      <td style="vertical-align: top;" colspan="3">
                        <?php
                        $CtgRq = PanelSolicitudes::ConCategoriasRequerimientos($Grupo, $Desdehora, $Desdehasta);
                        ?>
                        <table id="tablactg" class="table theme-warning br-t" style="width:800px;">
                          <thead>
                            <tr style="background-color:#67d3e0; color:#34495e;">
                              <th>
                                Categoría
                              </th>
                              <th style="text-align:center">
                                Criticidad
                              </th>
                              <th style="text-align:center">
                                Recibidos
                              </th>
                              <th>
                                Cerrados
                              </th>
                              <th style="text-align:right">
                                Notificados
                              </th>
                              <th style="text-align:right">
                                Pendientes
                              </th>
                            </tr>
                          </thead>

                          <?php
                          $t   = 0;
                          $alt = 0;
                          ?>
                          @foreach($CtgRq as $DatCtg)
                          <?php
                          $t = $t + $DatCtg->cant;
                          ?>
                          @endforeach

                          @foreach($CtgRq as $DatCtg)
                          <tr>
                            <td>
                              <?php
                              $nomCtg = PanelCategorias::getCategoria($DatCtg->categoria);
                              echo $nomCtg[0]->descripcion;
                              ?>
                            </td>

                            <th style="text-align:center">
                              <?php
                              $Criticidad = PanelPriorizaciones::getCriterio($nomCtg[0]->criticidad);
                              ?>
                              <button type="button" style="text-align:left; cursor:default; outline:none; width:110px; background-color:white;" tabindex="-1" class="btn btn-default light">
                                <label for="username" class="field-icon">
                                  <i class="fa fa-exclamation-triangle fa-2x" style="color:<?= $Criticidad[0]->color ?>; text-shadow: 1px 1px 1px #000;"></i>
                                </label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <?= $Criticidad[0]->descripcion ?>
                              </button>
                            </th>

                            <?php
                            echo "<th style=\"text-align:right\">";
                            echo $cta = PanelSolicitudes::ConCategoriasRequerimientosRecibidos($Grupo, $Desdehora, $Desdehasta,$DatCtg->categoria );
                            echo "</th>";

                            echo "<th style=\"text-align:right\">";
                            echo $ctaAnt = PanelSolicitudes::ConCategoriasRequerimientosAtendidos($Grupo, $Desdehora, $Desdehasta,$DatCtg->categoria );
                            echo "</th>";

                            echo "<th style=\"text-align:right\">";
                            echo $ctaAntN = PanelSolicitudes::ConCategoriasRequerimientosNotificados($Grupo, $Desdehora, $Desdehasta,$DatCtg->categoria );
                            echo "</th>";

                            echo "<th style=\"text-align:right\">";
                            echo $ctaPend = PanelSolicitudes::ConCategoriasRequerimientosPendientes($Grupo, $Desdehora, $Desdehasta,$DatCtg->categoria);
                            echo "</th>";


                            ?>
                          </tr>
                          @endforeach
                        </table>
                      </td>
                    </tr>

                    <tr>
                      <th colspan="4">
                        <hr style="border-top: 3px solid #8c8b8b;">
                      </th>
                    </tr>

                    <tr>
                      <th style="vertical-align: top;" rowspan="2">
                        Requerimientos atendidos según los tiempos de respuesta:
                        <br>
                        (fecha solicitud)
                      </th>
                      <td style="vertical-align: top;" colspan="3">
                        <?php
                        $LisTiempos = PanelSolicitudes::ConTiempos($Grupo, $Desdehora, $Desdehasta);
                        $a = $b = 0;
                        ?>
                        @foreach($LisTiempos as $DatTie)
                        <?php
                        if ($DatTie->diferencia > 0)
                          $a++;
                        else
                          $b++;
                        ?>
                        @endforeach

                        <table id="message-table" class="table theme-warning br-t" style="width:800px;">
                          <tr>
                            <th>
                              Dentro de tiempo establecido:
                            </th>
                            <th style="text-align:center;">
                              <button type="button" style="background:#67d3e0; cursor:default;" class="btn btn-default light">
                                <font color="#34495e" size="3">
                                  <?= $b ?>
                                </font>
                              </button>
                            </th>

                            <th>
                              Excedieron el tiempo establecido:
                            </th>
                            <th style="text-align:center;">
                              <button type="button" style="background:#67d3e0; cursor:default;" class="btn btn-default light">
                                <font color="red" size="3">
                                  <?= $a ?>
                                </font>
                              </button>
                            </th>
                          </tr>
                        </table>
                      </td>
                    </tr>

                    <tr>
                      <td style="vertical-align: top;" colspan="3">
                        <b>
                          Nota: Tiempo en días
                        </b>
                        <table id="tablatiempos" class="table theme-warning br-t" style="width:800px;">
                          <thead>
                            <tr style="background-color:#67d3e0; color:#34495e;">
                              <th>
                                Requerimiento
                              </th>
                              <th style="text-align:center">
                                Fecha de solicitud
                              </th>
                              <th style="text-align:center">
                                Fecha de cierre
                              </th>
                              <th style="text-align:center">
                                Tiempo esperado
                              </th>
                              <th style="text-align:center">
                                Tiempo que
                                <br>
                                permaneció abierto
                              </th>
                              <th style="text-align:center">
                                Diferencia
                              </th>
                            </tr>
                          </thead>

                          @foreach($LisTiempos as $DatTie)
                          <?php
                          if ($DatTie->diferencia > 0) {
                          ?>
                            <tr>
                              <th>
                                <button type="button" class="btn btn-default light" onclick="window.open('<?= $server ?>/panel/requerimientos/consultausr/masinfo1/<?= $DatTie->num_solicitud ?>','_blank','status=no','directories=no','menubar=no','toolbar=no','scrollbars=no','location=no','resizable=no','titlebar=no')" title="Más información">
                                  <font color="#34495e" size="3">
                                    <?= $DatTie->num_solicitud; ?>
                                  </font>
                                </button>
                              </th>
                              <td style="text-align:center;">
                                <?= substr($DatTie->fecha_solicita, 0, 16) ?>
                              </td>
                              <td style="text-align:center;">
                                <?= substr($DatTie->fecha_cierre, 0, 16) ?>
                              </td>
                              <td style="text-align:right;">
                                <?= $DatTie->tiempo ?>
                              </td>
                              <td style="text-align:right;">
                                <?= $DatTie->dias ?>
                              </td>
                              <th style="text-align:right;">
                                <?= $DatTie->diferencia ?>
                              </th>
                            </tr>
                          <?php
                          }
                          ?>
                          @endforeach
                        </table>
                      </td>
                    </tr>

                    <tr>
                      <th colspan="4">
                        <hr style="border-top: 3px solid #8c8b8b;">
                      </th>
                    </tr>
                    <tr>
                      <th style="vertical-align: top;">
                        Percepción de los usuarios:
                        <br>
                        (fecha de cierre)
                      </th>
                      <td style="vertical-align: top;" colspan="3">
                        <table valign="top" style="width:800px;">
                          <tr>
                            <th>
                              <?php
                              $EncuestaRq = PanelSolicitudes::ConEncuestaRequerimientos($Grupo, $Desdehora, $Desdehasta);
                              $t = 0;
                              $muy = $pmuy = $sas = $psas = $ins = $pins = 0;
                              ?>
                              @foreach($EncuestaRq as $DatEnc)
                              <?php
                              $t = $t + $DatEnc->cant;
                              ?>
                              @endforeach

                              @foreach($EncuestaRq as $DatEnc)
                              <?php
                              $val  = $DatEnc->cant;
                              $prog = round((($val * 100) / $t), 1);

                              if ($DatEnc->calificacion == 'M') {
                                $muy  = $DatEnc->cant;
                                $pmuy = $prog;
                              } else if ($DatEnc->calificacion == 'S') {
                                $sas  = $DatEnc->cant;
                                $psas = $prog;
                              } else if ($DatEnc->calificacion == 'I') {
                                $ins  = $DatEnc->cant;
                                $pins = $prog;
                              }
                              ?>
                              @endforeach
                              <?php
                              $texto = "'Muy satisfecho: $pmuy% ($muy)', 'Satisfecho: $psas% ($sas)', 'Insatisfecho: $pins% ($ins)'";
                              ?>
                              <!-- -------------- Imagen circular -------------- -->
                              <canvas id="cirpercepcion" width="100%" height="20"></canvas>
                              <script type="text/javascript">
                                function CIRPERCEPCION() {
                                  var ctx = document.getElementById("cirpercepcion");
                                  var myPieChart = new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                      labels: [<?= $texto ?>],
                                      datasets: [{
                                        data: [<?php echo $muy; ?>, <?php echo $sas; ?>, <?php echo $ins; ?>],
                                        backgroundColor: ['#FEDA00', '#FF8C19', 'red'],
                                        borderColor: 'white',
                                        borderWidth: 4
                                      }],
                                    },
                                    options: {
                                      legend: {
                                        display: true,
                                        labels: {
                                          fontSize: 14
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
  <script src="<?= $server ?>/panelfiles/assets/js/jquery/jquery-1.11.3.min.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js"></script>

  <!-- -------------- JvectorMap Plugin -------------- -->
  <script src="<?= $server ?>/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js"></script>

  <!-- -------------- HighCharts Plugin -------------- -->
  <script src="<?= $server ?>/panelfiles/assets/js/plugins/highcharts/highcharts.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/d3.min.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/c3.min.js"></script>

  <!-- -------------- Theme Scripts -------------- -->
  <script src="<?= $server ?>/panelfiles/assets/js/utility/utility.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/demo/demo.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/main.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/pages/allcp_forms-elements.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/demo/widgets_sidebar.js"></script>

  <!-- -------------- Page JS -------------- -->
  <script src="<?= $server ?>/panelfiles/assets/js/demo/charts/highcharts.js"></script>

  <!-- -------------- Para los gráficos -------------- -->
  <script src="<?= $server ?>/panelfiles/assets/js/Chart.min.js"></script>
  <!-- El mismo archivo pero apuntando a internet -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> -->

  <!-- -------------- DataTables -------------- -->
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

  <script>
    $('#tablatiempos').DataTable({
      "columnDefs": [{
        "searchable": false,
        "ordering": true,
        "targets": 0
      }],
      "order": [
        [5, "desc"],
        [4, "desc"]
      ],
      "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    }
    });

    $('#tablaareas').DataTable({
      "ordering": true,
      "order": [5, "desc"],
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
      }
    });

    $('#tablactg').DataTable({
      "ordering": true,
      "order": [5, "desc"],
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
      }
    });
  </script>
  <!-- -------------- /Scripts -------------- -->
</body>

</html>
@endforeach
