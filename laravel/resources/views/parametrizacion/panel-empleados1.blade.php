<?php
$server ='/Berhlan/public';

use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelCentrosOp;

?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Empleados
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

      <!-- -------------- DataTables -------------- -->
      <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">

      <!-- Alerts Personalizados -->

      <!-- This is what you need -->

      <script src="<?=$server?>/panelfiles/sweetalert/dist/sweetalert.min.js"></script>

      <link rel="stylesheet" href="<?=$server?>/panelfiles/sweetalert/dist/sweetalert.css">

      <!-- Alerts Personalizados -->
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
                  <a href="<?=$server?>/panel/menu/7" title="Parametrizacion">
                    <font color="#34495e">
                      Parametrización > Empleados
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/parametrizacion/empleados/agregar" class="btn btn-primary btn-sm ml10" title="Nuevo empleado">
                <span class="fa fa-plus pr5"></span>
                <span class="fa fa-credit-card pr5"></span>
              </a>

              <a href="<?=$server?>/panel/menu/7" class="btn btn-primary btn-sm ml10" title="Parametrización">
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
                  <table class="table allcp-form theme-warning br-t">
                    <thead>
                      <tr style="background-color:#39405a">
                        <th>
                          <font color="white">
                            Empleados
                          </font>
                        </th>
                      </tr>
                    </thead>

                    <tr>
                      <td>
                        <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                          <thead>
                            <tr style="background-color: #F8F8F8">
                              <th style="text-align: center;">
                                #
                              </th>
                              <th style="text-align: left">
                                E.
                              </th>
                              <th style="text-align: left">
                                Identificación
                              </th>
                              <th style="text-align: left">
                                Nombres
                              </th>
                              <th style="text-align: left">
                                Apellidos
                              </th>
                              <th style="text-align: left">
                                Cargo
                              </th>
                              <th style="text-align: left">
                                Centro de operación
                              </th>
                              <th style="text-align: left">
                                Fecha de
                                <br>
                                nacimiento
                              </th>
                              <th style="text-align: center">
                                Modificar
                              </th>
                            </tr>
                          </thead>

                          <tbody>
                            <?php $u = 1;?>

                            @foreach($DatosEmpleados as $DatEmpleados)
                              <tr class="message-unread">
                                <td style="text-align: right">
                                  <font color="#2A2F43">
                                    <?php
                                    print $u;
                                    $u++;
                                    ?>
                                  </font>
                                </td>

                                <td style="text-align: right">
                                  <?php
                                  if($DatEmpleados->estado == '0')
                                    echo "<i class=\"fa fa-user fa-lg\" style=\"color:#F6565A\">.</i>";
                                  else
                                    echo "<i class=\"fa fa-user fa-lg\" style=\"color:#AEBF25\"></i>";
                                  ?>
                                </td>

                                <td style="text-align: left ">
                                  <font color="#2A2F43">
                                    <b>
                                      <?=$DatEmpleados->identificacion?>
                                    </b>
                                  </font>
                                </td>

                                <td style="text-align: left ">
                                  <font color="#2A2F43">
                                    <?=$DatEmpleados->primer_nombre." ".$DatEmpleados->ot_nombre?>
                                  </font>
                                </td>

                                <td style="text-align: left">
                                  <font color="#2A2F43">
                                    <?=$DatEmpleados->primer_apellido." ".$DatEmpleados->ot_apellido?>
                                  </font>
                                </td>

                                <?php
                                $Cargo = PanelCargos::getCargo($DatEmpleados->cargo);
                                ?>
                                <td style="text-align: left">
                                  @foreach($Cargo as $DatCargo)
                                    <font color="#2A2F43">
                                      <?=$DatCargo->descripcion?>
                                      <br>
                                      <?php
                                      $Area = PanelAreas::getArea($DatCargo->area);
                                      ?>
                                      @foreach($Area as $DatArea)
                                        <?php
                                        echo $DatArea->descripcion." - ";
                                        $Empresa = PanelEmpresas::getEmpresa($DatArea->empresa);
                                        ?>
                                        @foreach($Empresa as $DatEmpresa)
                                          <?=$DatEmpresa->nombre?>
                                        @endforeach
                                      @endforeach
                                    </font>
                                  @endforeach
                                </td>

                                <?php
                                $Centro = PanelCentrosOp::getCentroOp($DatEmpleados->centro_op);
                                ?>
                                <td style="text-align: left">
                                  @foreach($Centro as $DatCentro)
                                    <font color="#2A2F43">
                                      <?=$DatCentro->descripcion?>
                                    </font>
                                  @endforeach
                                </td>

                                <td style="text-align: left">
                                  <font color="#2A2F43">
                                    <?=$DatEmpleados->fecha_nacimiento?>
                                  </font>
                                </td>

                                <td style="text-align: center">
                                  <button type="button" class="btn btn-default light" onclick="window.location.href='<?=$server?>/panel/parametrizacion/empleados/modificar/<?=$DatEmpleados->id_empleado?>'">
                                    <i class="fa fa-pencil fa-lg" style="color:#AEBF25;"></i>
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
        $('#message-table').DataTable(
         {
          "language":
                     {
                      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                     }
         }
         );
      </script>

      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach