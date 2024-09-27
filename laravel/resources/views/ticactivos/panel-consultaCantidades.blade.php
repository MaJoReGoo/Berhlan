<?php

use App\Models\TicActivos\PanelConsultas;
use App\Models\TicActivos\PanelTipos;
use App\Models\Parametrizacion\PanelEmpresas;

?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Activos TIC | Cantidad de activos
      </title>
      <meta name="keywords" content="panel, cms, usuarios, servicio"/>
      <meta name="description" content="Intranet para grupo Berhlan">
      <meta name="author" content="USUARIO" >
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!-- -------------- Fonts -------------- -->
      <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
      <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

      <!-- -------------- CSS - theme -------------- -->
      <link rel="stylesheet" type="text/css" href="{{asset('/panelfiles/assets/skin/default_skin/css/theme.css')}}">

      <!-- -------------- CSS - Para circulo -------------- -->
      <link rel="stylesheet" type="text/css" href="{{asset('/panelfiles/assets/allcp/forms/css/circulo.css')}}">

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

    <body onload="CANEMPRESA1(), CANEMPRESA2(), CANEMPRESA3(), CANEMPRESA4()">
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
                      Cantidad de activos
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="{{ asset ('/panel/ticactivos/consultasact')}}" class="btn btn-primary btn-sm ml10" title="Activos TIC > Consultas">
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
                            Cantidad de activos
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        $EmpresasActivos = PanelConsultas::EmpresasActivos();
                        $e = 0;
                        ?>
                        @foreach($EmpresasActivos as $DatEmA)
                          <tr>
                            <th style="vertical-align: top;">
                              <?php
                              $e++;
                              $Empresa = PanelEmpresas::getEmpresa($DatEmA->empresa);
                              ?>
                              Activos para la empresa
                              <?=$Empresa[0]->nombre?>
                            </th>
                            <td style="vertical-align: top;">
                              <table valign="top" style="width:700px;">
                                <tr>
                                  <th>
                                    <?php
                                    $TipoActivos = PanelConsultas::ActivosEmpresa($DatEmA->empresa);
                                    $t           = 0;
                                    $nombre      = "";
                                    $valores     = "";
                                    ?>

                                    @foreach($TipoActivos as $DatTip)
                                      <?php
                                      $t = $t + $DatTip->cant;
                                      ?>
                                    @endforeach

                                    @foreach($TipoActivos as $DatTip)
                                      <?php
                                      $val  = $DatTip->cant;
                                      $prom = round((($val*100)/$t), 2);

                                      $TpActivo = PanelTipos::getTipo($DatTip->tipo);
                                      $nombre   = $nombre."'".$TpActivo[0]->descripcion.": ".$prom."% (".$val.")', ";
                                      $valores  = $valores.$val.", ";
                                      ?>
                                    @endforeach
                                    <!-- -------------- Imagen circular -------------- -->
                                    <canvas id="canempresa<?=$e?>" width="100%" height="35"></canvas>
                                    <script type="text/javascript">
                                    function CANEMPRESA<?=$e?>()
                                     {
                                      var ctx = document.getElementById("canempresa<?=$e?>");
                                      var myPieChart = new Chart(ctx,
                                       {
                                        type: 'doughnut',
                                        data:
                                         {
                                          labels: [<?=$nombre?>],
                                          datasets: [
                                           {
                                            data: [<?=$valores?>],
                                            backgroundColor: ['#FEDA00', '#00833A', '#23469D', '#A8CB2A', '#6CBCED', '#232F76', '#000000', '#FF0000', '#800000', '#C0C0C0',
                                                              '#FFFF00', '#808000', '#00FF00', '#008000', '#00FFFF', '#008080', '#0000FF', '#000080', '#FF00FF', '#800080'],
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
                        @endforeach

                        <?php
                        $CentrosActivos = PanelConsultas::CentrosActivos();
                        $e = 0;
                        ?>
                        @foreach($CentrosActivos as $DatCeA)
                          <tr>
                            <th style="vertical-align: top;">
                              Activos en el centro de operación
                              <?=$DatCeA->descp?>
                            </th>
                            <td style="vertical-align: top;">
                              <table valign="top" class="table theme-warning br-t" style="width:700px;">
                                <?php
                                $CanTipoActivos = PanelConsultas::ActivosCentro($DatCeA->id_centro);
                                ?>
                                <tbody>
                                  <tr style="background-color:#67d3e0; color:#34495e;">
                                    <th>
                                      Compañía
                                    </th>
                                    <th>
                                      Tipo
                                    </th>
                                    <th style="text-align:right">
                                      Cantidad
                                    </th>
                                  </tr>
                                </tbody>
                                @foreach($CanTipoActivos as $DatCTA)
                                  <tr>
                                    <th>
                                      <?php
                                      $Empresa = PanelEmpresas::getEmpresa($DatCTA->empresa);
                                      echo $Empresa[0]->nombre;
                                      ?>
                                    </th>

                                    <th>
                                      <?php
                                      $TpActivo = PanelTipos::getTipo($DatCTA->tipo);
                                      echo $TpActivo[0]->descripcion;
                                      ?>
                                    </th>

                                    <td align="right">
                                      <?=$DatCTA->cant?>
                                    </td>
                                  </tr>
                                @endforeach
                              </table>
                            </td>
                          </tr>
                        @endforeach

                        <?php
                        $AreasActivos = PanelConsultas::AreasActivos();
                        $e = 0;
                        ?>
                        @foreach($AreasActivos as $DatArA)
                          <tr>
                            <th style="vertical-align: top;">
                              Activos en el área
                              <?=$DatArA->descp?>
                            </th>
                            <td style="vertical-align: top;">
                              <table valign="top" class="table theme-warning br-t" style="width:700px;">
                                <?php
                                $CanTipoActivos = PanelConsultas::ActivosArea($DatArA->id_area);
                                ?>
                                <tbody>
                                  <tr style="background-color:#67d3e0; color:#34495e;">
                                    <th>
                                      Centro de operación
                                    </th>
                                    <th>
                                      Tipo
                                    </th>
                                    <th style="text-align:right">
                                      Cantidad
                                    </th>
                                  </tr>
                                </tbody>
                                @foreach($CanTipoActivos as $DatCTA)
                                  <tr>
                                    <th>
                                      <?=$DatCTA->descp?>
                                    </th>

                                    <th>
                                      <?php
                                      $TpActivo = PanelTipos::getTipo($DatCTA->tipo);
                                      echo $TpActivo[0]->descripcion;
                                      ?>
                                    </th>

                                    <td align="right">
                                      <?=$DatCTA->cant?>
                                    </td>
                                  </tr>
                                @endforeach
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

      <!-- -------------- Para los graficos -------------- -->
      <script src="{{ asset ('/panelfiles/assets/js/Chart.min.js')}}"></script>

      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach
