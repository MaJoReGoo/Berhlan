<?php
$server ='/Berhlan/public';

use App\Models\Procesos\PanelProcesos;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Procesos internos
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

      <!-- -------------- Plugins -------------- -->
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

      <!-- -------------- Favicon -------------- -->
      <link rel="shortcut icon" href="<?=$server?>/panelfiles/assets/img/favicon.ico">

      <!-- Alerts Personalizados -->

      <!-- This is what you need -->

      <script src="<?=$server?>/panelfiles/sweetalert/dist/sweetalert.min.js"></script>

      <link rel="stylesheet" href="<?=$server?>/panelfiles/sweetalert/dist/sweetalert.css">
    </head>

    <body class="sales-stats-page">
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
                  <a href="<?=$server?>/panel/menu/6" title="Procesos internos">
                    <font color="#34495e">
                      Procesos internos > Procesos
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/menu/6" class="btn btn-primary btn-sm ml10" title="Procesos internos">
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
              <div class="panel m10">
                <!-- -------------- Message Body -------------- -->
                <div class="table-responsive">
                  <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                    <thead>
                      <div style="padding-left: 10px">
                        <?php
                        $u   = 0;
                        $col = "";
                        ?>
                        @foreach($DatosMacroProcesos as $DatMacroP)
                          <?php
                          $fondo = $DatMacroP->fondo;
                          ?>
                          <tr>
                            <td colspan="5">
                              <button type="button" style="background:#<?=$fondo?>; cursor:default;" class="btn btn-default light">
                                <b>
                                  <font color="white">
                                    <?=$DatMacroP->descripcion?>
                                  </font>
                                </b>
                              </button>
                            </td>
                          </tr>

                          <tr style="background-color: #F8F8F8">
                            <td align="center">
                              #
                            </td>
                            <th style="text-align: left">
                              Proceso
                            </th>
                            <th style="text-align: center">
                              Archivo
                            </th>
                            <th style="text-align: center">
                              Fecha
                              <i class="fa fa-upload fa-lg" ></i>
                            </th>
                            <th style="text-align: center">
                              Modificar
                            </th>
                          </tr>

                          <?php
                          $Procesos = PanelProcesos::getProcesosMacro($DatMacroP->id_macroproceso);
                          ?>
                          @foreach($Procesos as $DatProcesos)
                            <?php
                            $fondo1 = $DatProcesos->fondo;

                            if($u%2 == 0)
                              $col = "#e5eaee";
                            else
                              $col = "";
                            $u++;
                            ?>

                            <tr style="background-color: <?=$col?>">
                              <td align="center">
                                <button type="button"  style="background:#<?=$fondo1?>; cursor:default;" class="btn btn-default light">
                                  <b>
                                    <font color="#001137">
                                      <?php
                                      echo $u;
                                      ?>
                                   </font>
                                  </b>
                                </button>
                              </td>

                              <td>
                                <?=$DatProcesos->descripcion?>
                              </td>

                              <td align="center">
                                <button type="button"  style="background:#f7f9f9;" class="btn btn-default light" onclick="window.location.href='<?=$server?>/archivos/Procesos/<?=$DatProcesos->ruta1."?".date('i:s')?>'" title="<?=$DatProcesos->ruta1?>">
                                  <i class="fa fa-file-excel-o fa-lg" style="color:#28B463;"></i>
                                </button>
                              </td>

                              <td align="center">
                                <font size="1">
                                  <?=$DatProcesos->fecha1?>
                                </font>
                              </td>

                              <!-- Modificar -->
                              <td style="text-align: center">
                                <button type="button" class="btn btn-default light" onclick="window.location.href='<?=$server?>/panel/procesos/procesos/modificar/<?=$DatProcesos->id_proceso?>'" title="Editar proceso">
                                  <i class="fa fa-pencil fa-lg" style="color:#AEBF25;"></i>
                                </button>
                              </td>
                              <!-- Modificar -->
                            </tr>
                          @endforeach
                        @endforeach
                      </div>
                    </thead>
                  </table>
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
      <script src="<?=$server?>/panelfiles/assets/js/demo/widgets_sidebar.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/pages/dashboard2.js"></script>

      <!-- -------------- Page JS -------------- -->
      <script src="<?=$server?>/panelfiles/assets/js/demo/charts/highcharts.js"></script>

      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach