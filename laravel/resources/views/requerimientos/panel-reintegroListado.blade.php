<?php
$server = '/Berhlan/public';

use App\Models\Requerimientos\PanelGrupos;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Requerimientos\PanelCategorias;
use App\Models\Requerimientos\PanelPriorizaciones;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Requerimientos | Reintegro
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

      <!-- -------------- DataTables -------------- -->
      <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">

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
                  <?php
                  $nomgrupo = PanelGrupos::getGrupo($Grupo);
                  ?>
                  <a href="<?=$server?>/panel/requerimientos/reintegro" title="Requerimientos > Reintegro">
                    <font color="#34495e">
                      Requerimientos > Grupo
                      <?=$nomgrupo[0]->descripcion?> >
                    </font>
                    <font color="#b4c056">
                      Reintegro
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/requerimientos/reintegro" class="btn btn-primary btn-sm ml10" title="Requerimientos > Reintegro">
                REGRESAR &nbsp;
                <span class="fa fa-arrow-left"></span>
              </a>
            </div>
          </header>
          <!-- -------------- /Topbar -------------- -->

          <!-- -------------- Content -------------- -->
          <br>
          <section id="content" class="table-layout animated fadeIn">
            <div class="chute chute-center pt5">
              <!-- -------------- Column Center -------------- -->
              <div class="panel m3">
                <!-- -------------- Message Body -------------- -->
                <div class="nano-content">
                  <div class="table-responsive">
                    <table class="table allcp-form theme-warning br-t">
                      <thead>
                        <tr style="background-color:#39405a">
                          <th>
                            Requerimientos pendientes de reintegro
                          </th>
                        </tr>
                      </thead>

                      <tr>
                        <td>
                          <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                            <thead>
                              <tr style="background-color: #F8F8F8; color:#000000">
                                <th style="text-align:left">
                                  #
                                </th>
                                <th style="text-align:right">
                                  Req.
                                </th>
                                <th style="text-align: center">
                                  Solicitado por
                                </th>
                                <th style="text-align: center">
                                  Solicitud
                                </th>
                                <th style="text-align: center">
                                  Fecha de cierre
                                </th>
                                <th style="text-align: center">
                                  Atendido por
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
                              @foreach($DatosSolicitudes as $DatSol)
                                <tr class="message-unread">
                                  <td style="text-align:left">
                                    <font color="#2A2F43">
                                      <?php
                                      print $u;
                                      $u++;
                                      ?>
                                    </font>
                                  </td>

                                  <td style="text-align:right">
                                    <font color="#2A2F43">
                                      <b>
                                        <?=$DatSol->num_solicitud?>
                                      </b>
                                    </font>
                                  </td>

                                  <td style="text-align:left">
                                    <font color="#2A2F43">
                                      <?php
                                      $empleado = PanelEmpleados::getEmpleado($DatSol->usr_solicita);
                                      echo $empleado[0]->primer_nombre;
                                      echo " ";
                                      echo $empleado[0]->ot_nombre;
                                      echo " ";
                                      echo $empleado[0]->primer_apellido;
                                      echo " ";
                                      echo $empleado[0]->ot_apellido;
                                      echo "<br>";
                                      $cargo = PanelCargos::getCargo($DatSol->cargo_solicitud);
                                      echo $cargo[0]->descripcion;
                                      echo "<br>";
                                      $centro = PanelCentrosOp::getCentroOp($DatSol->centro_solicitud);
                                      echo $centro[0]->descripcion;
                                      ?>
                                    </font>
                                  </td>

                                  <td style="text-align:justify" width="320">
                                    <div style="height:140px; width:100%; overflow:auto;">
                                      <font color="#2A2F43">
                                        <?=$DatSol->descripcion?>
                                      </font>
                                    </div>
                                  </td>

                                  <td style="text-align:center">
                                    <font color="#2A2F43">
                                      <?=$DatSol->fecha_cierre?>
                                    </font>
                                  </td>

                                  <td style="text-align:center">
                                    <font color="#2A2F43">
                                      <?php
                                      $asignado = PanelEmpleados::getEmpleado($DatSol->usr_cierre);
                                      echo $asignado[0]->primer_nombre;
                                      echo " ";
                                      echo $asignado[0]->ot_nombre;
                                      echo " ";
                                      echo $asignado[0]->primer_apellido;
                                      echo " ";
                                      echo $asignado[0]->ot_apellido;
                                      ?>
                                    </font>
                                  </td>

                                  <td style="text-align: center">
                                    <button type="button" style="background-color:transparent;" class="btn btn-default light" onclick="window.location.href='<?=$server?>/panel/requerimientos/reintegro/finalizar/<?=$DatSol->num_solicitud?>'" title="Más información">
                                      <i class="fa fa-exclamation-circle fa-lg" style="color:#AEBF25;"></i>
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

      <!-- -------------- DataTables -------------- -->
     <!--  <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
      <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
      <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
      <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

      <script>
      $('#message-table').DataTable(
       {
        "language":
                   {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                   }
       }
       );

      window.setInterval("reFresh()",600000);
      function reFresh()
       {
        location.reload(true);
       }
      </script>

      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach