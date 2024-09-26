<?php

use App\Models\Disciplinarios\PanelSolicitudes;
use App\Models\Disciplinarios\PanelMotivos;
use App\Models\Disciplinarios\PanelTipofaltas;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Procesos disciplinarios | Informe
      </title>
      <meta name="keywords" content="panel, cms, usuarios, servicio"/>
      <meta name="description" content="Intranet para grupo Berhlan">
      <meta name="author" content="USUARIO" >
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!-- -------------- Fonts -------------- -->
      <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
      <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

      <!-- -------------- CSS - theme -------------- -->
      <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/skin/default_skin/css/theme.css')}}">

      <!-- -------------- CSS - Para circulo -------------- -->
      <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/circulo.css')}}">

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

    <body onload="CIRCIERRE(), BARTPFALTA()">
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
                  <a href="{{ asset ('/panel/disciplinarios/informe')}}" title="Procesos disciplinarios > Informe">
                    <font color="#34495e">
                      Procesos disciplinarios > Informe >
                    </font>
                    <font color="#b4c056">
                      Detalle
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="{{ asset ('/panel/disciplinarios/informe')}}" class="btn btn-primary btn-sm ml10" title="Procesos disciplinarios > Informe">
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
                            Informe procesos disciplinarios
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
                            if($Desde == '')
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
                            if($Hasta == '')
                              echo "No ingresada";
                            else
                              echo $Hasta;
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
                              echo $Cantidad = PanelSolicitudes::TSolicitudes($Desde, $Hasta);
                              ?>
                            </font>
                          </th>
                        </tr>

                        <tr>
                          <th style="vertical-align: top;">
                            Solicitudes por estado:
                          </th>
                          <td style="vertical-align: top;" colspan="3">
                            <table id="message-table" class="table theme-warning br-t" valign="top" style="width:800px;">
                              <tr style="background-color:#67d3e0; color:#34495e;">
                                <th colspan="2">
                                  En proceso
                                </th>
                                <th colspan="2">
                                  Atendidas
                                </th>
                              </tr>

                              <?php
                              $Slenproceso = PanelSolicitudes::EstadoSolicitudes($Desde, $Hasta, 1);
                              $Slatendidas = PanelSolicitudes::EstadoSolicitudes($Desde, $Hasta, 0);
                              $sumsol      = $Slenproceso + $Slatendidas;
                              ?>
                              <tr>
                                <td style="text-align:left">
                                  <?=$Slenproceso?>
                                </td>
                                <td style="text-align:left">
                                  <?php
                                  if($sumsol > 0)
                                   {
                                    $prog = round((($Slenproceso*100)/$sumsol), 2);
                                    echo "<progress id=\"file\" max=\"100\" value=\"$prog\" style=\"width:50px;\"> $prog% </progress>";
                                    echo " ";
                                    echo $prog."%";
                                   }
                                  else
                                   {
                                    echo "0";
                                   }
                                  ?>
                                </td>

                                <td style="text-align:left">
                                  <?=$Slatendidas?>
                                </td>
                                <td style="text-align:left">
                                  <?php
                                  if($sumsol > 0)
                                   {
                                    $prog = round((($Slatendidas*100)/$sumsol), 2);
                                    echo "<progress id=\"file\" max=\"100\" value=\"$prog\" style=\"width:50px;\"> $prog% </progress>";
                                    echo " ";
                                    echo $prog."%";
                                   }
                                  else
                                   {
                                    echo "0";
                                   }
                                  ?>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>

                        <tr>
                          <th style="vertical-align: top;">
                            Solicitudes según el cierre:
                          </th>
                          <td style="vertical-align: top;" colspan="3">
                            <table valign="top" style="width:700px;">
                              <tr>
                                <th>
                                  <?php
                                  $TipoCierreSl = PanelSolicitudes::TipocierreSolicitudes($Desde, $Hasta);
                                  $t            = 0;
                                  $nombre       = "";
                                  $valores      = "";
                                  ?>
                                  @foreach($TipoCierreSl as $DatTpc)
                                    <?php
                                    $t = $t + $DatTpc->cant;
                                    ?>
                                  @endforeach

                                  @foreach($TipoCierreSl as $DatTpc)
                                    <?php
                                    $val  = $DatTpc->cant;
                                    $prom = round((($val*100)/$t), 2);

                                    $TpCierre = PanelMotivos::getMotivo($DatTpc->motivo_cierre);
                                    $nombre   = $nombre."'".$TpCierre[0]->descripcion.": ".$prom."% (".$val.")', ";
                                    $valores  = $valores.$val.", ";
                                    ?>
                                  @endforeach

                                  <!-- -------------- Imagen circular -------------- -->
                                  <canvas id="circierre" width="100%" height="25"></canvas>
                                  <script type="text/javascript">
                                  function CIRCIERRE()
                                   {
                                    var ctx = document.getElementById("circierre");
                                    var myPieChart = new Chart(ctx,
                                     {
                                      type: 'doughnut',
                                      data:
                                       {
                                        labels: [<?=$nombre?>],
                                        datasets: [
                                         {
                                          data: [<?=$valores?>],
                                          backgroundColor: ['#FEDA00', '#00833A', '#23469D', '#A8CB2A', '#6CBCED', '#232F76'],
                                         }],
                                       },
                                      options:
                                       {
                                        legend:
                                         {
                                          display: true,
                                          labels:
                                           {
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

                        <tr>
                          <th style="vertical-align: top;">
                            Solicitudes según el tipo de falta:
                          </th>
                          <td style="vertical-align: top;" colspan="3">
                            <?php
                            $TipoFaltaSl = PanelSolicitudes::TipofaltaSolicitudes($Desde, $Hasta);
                            $nombre = $valores = "";
                            $mayor = 0;
                            ?>
                            @foreach($TipoFaltaSl as $DatTpf)
                              <?php
                              $TpFalta = PanelTipofaltas::Tipofalta($DatTpf->tipo_falta);
                              $nombre  = $nombre."'".$TpFalta[0]->descripcion."', ";
                              $valores = $valores.$DatTpf->cant.", ";
                              if($DatTpf->cant > $mayor)
                                $mayor = $DatTpf->cant;
                              ?>
                            @endforeach

                            <table valign="top" style="width:700px;">
                              <tr>
                                <th>
                                  <br>
                                  <!-- -------------- Diagrama de barras -------------- -->
                                  <canvas id="bartpfalta" width="100%" height="65"></canvas>
                                  <script type="text/javascript">
                                  function BARTPFALTA()
                                   {
                                    var ctx = document.getElementById("bartpfalta");
                                    var myPieChart = new Chart(ctx,
                                     {
                                      type: 'bar',
                                      data:
                                       {
                                        labels: [<?php echo $nombre;?>],
                                        datasets: [
                                         {
                                          label: "Cantidad de faltas",
                                          backgroundColor: "#232F76",
                                          borderColor: "#FEDA00",
                                          data: [<?=$valores?>],
                                          borderWidth: 3
                                         }],
                                       },
                                     options:
                                      {
                                       animation:
                                        {
                                         onComplete : function()
                                          {
                                           var chartInstance = this.chart,
                                           ctx = chartInstance.ctx;
                                           ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle,
                                           Chart.defaults.global.defaultFontFamily);
                                           ctx.textAlign = 'center';
                                           ctx.textBaseline="top";
                                           ctx.font="20px Lato, Arial";
                                           ctx.fillStyle="white";
                                           this.data.datasets.forEach(function(dataset, i)
                                            {
                                             var meta = chartInstance.controller.getDatasetMeta(i);
                                             meta.data.forEach(function(bar, index)
                                              {
                                               if (dataset.data[index] > 0)
                                                {
                                                 var data = dataset.data[index];
                                                 ctx.fillText(data, bar._model.x, bar._model.y);
                                                }
                                              });
                                            });
                                          }
                                        },
                                       scales:
                                        {
                                         xAxes: [
                                          {
                                           time:
                                            {
                                             unit: 'month'
                                            },
                                           gridLines:
                                            {
                                             display: false
                                            },
                                           ticks:
                                            {
                                             maxTicksLimit: 18
                                            }
                                          }],
                                         yAxes: [
                                          {
                                           ticks:
                                            {
                                             min: 0,
                                             max: <?=$mayor?>,
                                             maxTicksLimit: 10
                                            },
                                           gridLines:
                                            {
                                             display: true
                                            }
                                          }],
                                        },
                                       legend:
                                        {
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
      <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js')}}"></script>
      <script src="<{{ asset ('/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js')}}"></script>

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

      <!-- -------------- Para los graficos -------------- -->
      <script src="{{ asset ('/panelfiles/assets/js/Chart.min.js')}}"></script>

      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach
