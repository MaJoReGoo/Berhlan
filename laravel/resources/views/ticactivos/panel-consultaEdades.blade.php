<?php
$server = '/Berhlan/public';


use App\Models\TicActivos\PanelConsultas;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Activos TIC | Consulta edades activos
      </title>
      <meta name="keywords" content="panel, cms, usuarios, servicio"/>
      <meta name="description" content="Intranet para grupo Berhlan">
      <meta name="author" content="USUARIO" >
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!-- -------------- Fonts -------------- -->
      <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
      <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

      <!-- -------------- CSS - theme -------------- -->
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/skin/default_skin/css/theme.css">

      <!-- -------------- CSS - allcp forms -------------- -->
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/allcp/forms/css/forms.min.css">
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/allcp/forms/css/forms.css">

      <!-- -------------- Plugins -------------- -->
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

      <!-- -------------- Favicon -------------- -->
      <link rel="shortcut icon" href="<?=$server?>/panelfiles/assets/img/favicon.ico">

      <!-- Editor -->
      <script type="text/javascript" src="<?=$server?>/panelfiles/ckeditor/ckeditor.js"></script>
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
                  <a href="<?=$server?>/panel/ticactivos/consultasact" title="Activos TIC">
                    <font color="#34495e">
                      Activos TIC >
                    </font>
                    <font color="#b4c056">
                      Consulta edades por tipo de activo
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/ticactivos/consultasact" class="btn btn-primary btn-sm ml10" title="Activos TIC">
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
                    <div style="text-align: right;">
                      <b>
                        Nota:
                      </b>
                      no se tienen en cuenta los activos sin fecha de adquisición asignada.
                    </div>

                    <table id="message-table" class="table theme-warning br-t">
                      <thead>
                        <tr style="background-color:#39405a">
                          <th style="color:white;" colspan="20">
                            Edades por tipo de activos - periodicidad 6 meses
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>
                          </td>
                          <?php
                          $TpActivos = PanelConsultas::TiposActivos();
                          ?>
                          @foreach($TpActivos as $DatTip)
                            <th style="text-align:center;">
                              <?=$DatTip->descripcion?>
                            </th>
                          @endforeach
                        </tr>

                        <?php
                        $sql = "SELECT ((TIMESTAMPDIFF(MONTH, MIN(fechaadq), MAX(fechaadq))+1)/6) AS intervalo "
                              ."FROM acti_activo WHERE estado = 1 AND fechaadq IS NOT NULL;";
                        $NumIntervalos = PanelConsultas::ProyeccionSql($sql);
                        $intervalo     = $NumIntervalos[0]->intervalo;
                        $intervalo1    = floor($intervalo);

                        if($intervalo < 1)
                          $intervalo = 1;
                        else if($intervalo > $intervalo1)
                          $intervalo = $intervalo1 + 1;

                        $fecha_actual = date("Y-m-d");

                        $u = 0;
                        ?>
                        @foreach($TpActivos as $DatTip)
                          <?php
                          $total[$u] = 0;
                          $u++;
                          ?>
                        @endforeach

                        <?php
                        for($i=1;$i<=$intervalo;$i++)
                         {
                          echo "<tr>";
                            echo "<th style=\"text-align:center;\">";
                              echo (($i-1)*6)." a ".($i*6);
                            echo "</th>";
                            $u = 0;
                            ?>

                            @foreach($TpActivos as $DatTip)
                              <th style="text-align:center;">
                                <?php
                                $mulinicio = ($i-1) * 6;
                                $mulfinal  = $i * 6;
                                $fechainicial = date("Y-m-d", strtotime($fecha_actual."- ".$mulfinal." month"));
                                $fechafinal   = date("Y-m-d", strtotime($fecha_actual."- ".$mulinicio." month"));

                                $CanActivos = PanelConsultas::CanActivosPeriodos($DatTip->tipo, $fechainicial, $fechafinal);
                                echo $CanActivos;
                                $total[$u] = $total[$u] + $CanActivos;
                                $u++;
                                ?>
                              </th>
                            @endforeach

                            <?php
                          echo "</tr>";
                         }
                        ?>

                        <tr style="background-color:#f2f4f4">
                          <th style="text-align:center; color:black;">
                            Total
                          </th>
                          <?php
                          $u=0;
                          ?>
                          @foreach($TpActivos as $DatTip)
                            <th style="text-align:center; color:black;">
                              <?php
                              echo $total[$u];
                              $u++;
                              ?>
                            </th>
                          @endforeach
                        </tr>
                      </tbody>
                    </table>

                    <br>

                    <table id="message-table" class="table theme-warning br-t">
                      <thead>
                        <tr style="background-color:#39405a">
                          <th style="color:white;" colspan="20">
                            Edades por tipo de activos - periodicidad anual
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>
                          </td>
                          @foreach($TpActivos as $DatTip)
                            <th style="text-align:center;">
                              <?=$DatTip->descripcion?>
                            </th>
                          @endforeach
                        </tr>

                        <?php
                        $sql = "SELECT ((TIMESTAMPDIFF(MONTH, MIN(fechaadq), MAX(fechaadq))+1)/12) AS intervalo "
                              ."FROM acti_activo WHERE estado = 1 AND fechaadq IS NOT NULL;";
                        $NumIntervalos = PanelConsultas::ProyeccionSql($sql);
                        $intervalo     = $NumIntervalos[0]->intervalo;
                        $intervalo1    = floor($intervalo);

                        if($intervalo < 1)
                          $intervalo = 1;
                        else if($intervalo > $intervalo1)
                          $intervalo = $intervalo1 + 1;

                        $fecha_actual = date("Y-m-d");

                        $u = 0;
                        ?>
                        @foreach($TpActivos as $DatTip)
                          <?php
                          $total[$u] = 0;
                          $u++;
                          ?>
                        @endforeach

                        <?php
                        for($i=1;$i<=$intervalo;$i++)
                         {
                          echo "<tr>";
                            echo "<th style=\"text-align:center;\">";
                              echo ($i-1)." a ".$i;
                            echo "</th>";
                            $u = 0;
                            ?>

                            @foreach($TpActivos as $DatTip)
                              <th style="text-align:center;">
                                <?php
                                $mulinicio = ($i-1) * 12;
                                $mulfinal  = $i * 12;
                                $fechainicial = date("Y-m-d", strtotime($fecha_actual."- ".$mulfinal." month"));
                                $fechafinal   = date("Y-m-d", strtotime($fecha_actual."- ".$mulinicio." month"));

                                $CanActivos = PanelConsultas::CanActivosPeriodos($DatTip->tipo, $fechainicial, $fechafinal);
                                echo $CanActivos;
                                $total[$u] = $total[$u] + $CanActivos;
                                $u++;
                                ?>
                              </th>
                            @endforeach

                            <?php
                          echo "</tr>";
                         }
                        ?>

                        <tr style="background-color:#f2f4f4">
                          <th style="text-align:center; color:black;">
                            Total
                          </th>
                          <?php
                          $u=0;
                          ?>
                          @foreach($TpActivos as $DatTip)
                            <th style="text-align:center; color:black;">
                              <?php
                              echo $total[$u];
                              $u++;
                              ?>
                            </th>
                          @endforeach
                        </tr>
                      </tbody>
                    </table>

                    <br>

                    <table id="message-table" class="table theme-warning br-t">
                      <thead>
                        <tr style="background-color:#39405a">
                          <th style="color:white;" colspan="20">
                            Edades por tipo de activos - periodicidad bienal
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>
                          </td>
                          @foreach($TpActivos as $DatTip)
                            <th style="text-align:center;">
                              <?=$DatTip->descripcion?>
                            </th>
                          @endforeach
                        </tr>

                        <?php
                        $sql = "SELECT ((TIMESTAMPDIFF(MONTH, MIN(fechaadq), MAX(fechaadq))+1)/24) AS intervalo "
                              ."FROM acti_activo WHERE estado = 1 AND fechaadq IS NOT NULL;";
                        $NumIntervalos = PanelConsultas::ProyeccionSql($sql);
                        $intervalo     = $NumIntervalos[0]->intervalo;
                        $intervalo1    = floor($intervalo);

                        if($intervalo < 1)
                          $intervalo = 1;
                        else if($intervalo > $intervalo1)
                          $intervalo = $intervalo1 + 1;

                        $fecha_actual = date("Y-m-d");

                        $u = 0;
                        ?>
                        @foreach($TpActivos as $DatTip)
                          <?php
                          $total[$u] = 0;
                          $u++;
                          ?>
                        @endforeach

                        <?php
                        for($i=1;$i<=$intervalo;$i++)
                         {
                          echo "<tr>";
                            echo "<th style=\"text-align:center;\">";
                              echo (($i-1)*2)." a ".($i*2);
                            echo "</th>";
                            $u = 0;
                            ?>

                            @foreach($TpActivos as $DatTip)
                              <th style="text-align:center;">
                                <?php
                                $mulinicio = ($i-1) * 24;
                                $mulfinal  = $i * 24;
                                $fechainicial = date("Y-m-d", strtotime($fecha_actual."- ".$mulfinal." month"));
                                $fechafinal   = date("Y-m-d", strtotime($fecha_actual."- ".$mulinicio." month"));

                                $CanActivos = PanelConsultas::CanActivosPeriodos($DatTip->tipo, $fechainicial, $fechafinal);
                                echo $CanActivos;
                                $total[$u] = $total[$u] + $CanActivos;
                                $u++;
                                ?>
                              </th>
                            @endforeach

                            <?php
                          echo "</tr>";
                         }
                        ?>

                        <tr style="background-color:#f2f4f4">
                          <th style="text-align:center; color:black;">
                            Total
                          </th>
                          <?php
                          $u=0;
                          ?>
                          @foreach($TpActivos as $DatTip)
                            <th style="text-align:center; color:black;">
                              <?php
                              echo $total[$u];
                              $u++;
                              ?>
                            </th>
                          @endforeach
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
      <script src="<?=$server?>/panelfiles/assets/js/jquery/jquery-1.11.3.min.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js"></script>

      <!-- -------------- JvectorMap Plugin -------------- -->
      <script src="<?=$server?>/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js"></script>

      <!-- -------------- HighCharts Plugin -------------- -->
      <script src="<?=$server?>/panelfiles/assets/js/plugins/highcharts/highcharts.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/plugins/c3charts/d3.min.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/plugins/c3charts/c3.min.js"></script>

      <!-- -------------- Theme Scripts -------------- -->
      <script src="<?=$server?>/panelfiles/assets/js/utility/utility.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/demo/demo.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/main.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/pages/allcp_forms-elements.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/demo/widgets_sidebar.js"></script>

      <!-- -------------- Page JS -------------- -->
      <script src="<?=$server?>/panelfiles/assets/js/demo/charts/highcharts.js"></script>

      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach