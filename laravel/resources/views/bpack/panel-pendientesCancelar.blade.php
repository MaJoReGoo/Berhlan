<?php
$server ='/Berhlan/public';

use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Bpack\PanelSolicitudesAN;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Bcloud | Cancelar solicitud
      </title>
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
      <script src="<?=$server?>/panelfiles/sweetalert/dist/sweetalert.min.js"></script>

      <link rel="stylesheet" href="<?=$server?>/panelfiles/sweetalert/dist/sweetalert.css">

      <!-- -------------- DataTables -------------- -->
      <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">

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
                  <a href="<?=$server?>/panel/menu/3" title="Bcloud">
                    <font color="#34495e">
                       Bcloud >
                    </font>
                    <font color="#b4c056">
                      Cancelar solicitud (actualización, nuevo desarrollo)
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/menu/3" class="btn btn-primary btn-sm ml10" title="Bcloud">
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
                  <div style="padding-left: 10px">
                    <b>Cancelar solicitud - Solicitudes abiertas</b>
                  </div>
                  <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                    <thead>
                      <tr style="background-color: #F8F8F8">
                        <th style="text-align: right;">
                          #
                        </th>
                        <th style="text-align: center">
                          Solicitud
                        </th>
                        <th style="text-align: center;">
                          Cliente
                        </th>
                        <th style="text-align: center">
                          Tipo
                        </th>
                        <th style="text-align: center">
                          Estado
                        </th>
                        <th style="text-align: center">
                          Con flexografía
                        </th>
                        <th style="text-align: center">
                          Solicitado por
                        </th>
                        <th style="text-align: center">
                          Solicitado hace
                        </th>
                        <th style="text-align: center">
                          Seleccionar
                        </th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php $u = 1; ?>
                      @foreach($PendientesSol as $DatCon)
                        <?php
                        if($DatCon->id_nvdesarrollo != 0)  //Si es nuevo desarrollo
                         {
                          $color  = '#21618c';
                          $inicio = "SBM";
                          $des    = "Nuevos desarrollos";
                         }
                        else
                         {
                          $inicio = "SBA";
                          if($DatCon->tipo == 'AR')
                           {
                            $color = 'green';
                            $des    = "Actualizaci&oacute;n para reimpresiones";
                           }
                          else
                           {
                            $color = 'red';
                            $des    = "Actualizaci&oacute;n para abastecimiento";
                           }
                         }
                        ?>

                        <tr class="message-unread">
                          <td style="text-align: right;">
                            <font color="#2A2F43">
                              <?php
                              print $u;
                              $u++;
                              ?>
                            </font>
                          </td>

                          <td style="text-align: center;">
                            <i class="fa fa-dot-circle-o fa-lg" style="color:<?=$color?>;"></i>
                            &nbsp;
                            <font color="#2A2F43">
                              <b>
                                <?php
                                echo $inicio;
                                if($inicio == "SBM")
                                  echo $DatCon->id_nvdesarrollo;
                                else
                                  echo $DatCon->id_actualizacion;
                                ?>
                              </b>
                            </font>
                          </td>

                          <td style="text-align: justify;">
                            <font color="#2A2F43">
                              <?=$DatCon->cliente?>
                            </font>
                          </td>

                          <td style="text-align: center;">
                            <font color="#2A2F43">
                              <?=$des?>
                            </font>
                          </td>

                          <td style="text-align: center;">
                            <font color="#2A2F43">
                              <?php
                              $estado = PanelSolicitudesAN::DesEstado($DatCon->estado);
                              echo $estado[0]->descripcion;
                              ?>
                            </font>
                          </td>

                          <td style="text-align: justify;">
                            <font color="#2A2F43">
                              <?php
                              $b = 0;
                              if($inicio == "SBA")
                               {
                                $conflexo = PanelSolicitudesAN::SolDetConFlexo($DatCon->id_solicitud);
                                ?>
                                Ítem:
                                @foreach($conflexo as $DatFle)
                                  <?php
                                  if($b > 0)
                                    echo " - ";
                                  echo $DatFle->item;
                                  $b++;
                                  ?>
                                @endforeach
                                <?php
                                if($b == 0)
                                  echo "No aplica";
                               }
                              else
                               {
                                $cantipo = PanelSolicitudesAN::SolDetCan($DatCon->id_solicitud);
                                ?>
                                @foreach($cantipo as $DatTip)
                                  <?php
                                  if($b > 0)
                                    echo " - ";
                                  echo $DatTip->cantidad;
                                  echo $DatTip->ruta;
                                  $b++;
                                  ?>
                                @endforeach
                                <?php
                               }
                              ?>
                            </font>
                          </td>

                          <td style="text-align: center">
                            <font color="#2A2F43">
                              <?php
                              $empleado = PanelEmpleados::getEmpleado($DatCon->usr_crea);
                              echo $empleado[0]->primer_nombre;
                              echo " ";
                              echo $empleado[0]->ot_nombre;
                              echo " ";
                              echo $empleado[0]->primer_apellido;
                              echo " ";
                              echo $empleado[0]->ot_apellido;
                              echo "<br>";
                              $cargo = PanelCargos::getCargo($empleado[0]->cargo);
                              echo $cargo[0]->descripcion;
                              echo "<br>";
                              echo $DatCon->fecha_crea;
                              ?>
                            </font>
                          </td>

                          <td style="text-align: center;">
                            <font color="#6CBCED">
                              <?php
                              $fecha1 = new DateTime($DatCon->fecha_crea);
                              $fecha2 = new DateTime("now");
                              $diff  = $fecha1->diff($fecha2);
                              if($diff->y > 0)
                                echo $ano = ($diff->y > 1) ? $diff->y . ' años ' : $diff->y . ' año ';
                              if($diff->m > 0)
                                echo $mes = ($diff->m > 1) ? $diff->m . ' meses ' : $diff->m . ' mes ';
                              if($diff->d > 0)
                                echo $dia = ($diff->d > 1) ? $diff->d . ' días ' : $diff->d . ' día ';
                              if($diff->h > 0)
                                echo $dia = ($diff->h > 1) ? $diff->h . ' horas ' : $diff->h . ' hora ';
                              ?>
                            </font>
                          </td>

                          <td style="text-align: center">
                            <button type="button" class="btn btn-default light" onclick="window.location.href='<?=$server?>/panel/bpack/cancelarsol/procesar/<?=$DatCon->id_solicitud?>'">
                              <i class="fa fa-times fa-lg" style="color:red;"></i>
                            </button>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
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

       <!-- -------------- DataTables -------------- -->
       <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
       <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
       <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
       <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

      <script>
        $(document).ready(function() {

            let datatable = $('#message-table').DataTable({
                ordering: true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
            
        })
      </script>
    </body>
  </html>
@endforeach
