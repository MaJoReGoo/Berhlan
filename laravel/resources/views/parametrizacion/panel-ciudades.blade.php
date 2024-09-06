<?php
$server ='/Berhlan/public';
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Ciudades
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

      <!-- -------------- DataTables -------------- -->
      <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">


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
                  <a href="<?=$server?>/panel/menu/7" title="Parametrizacion">
                    <font color="#34495e">
                      Parametrización > Ciudades
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/parametrizacion/ciudades/agregar" class="btn btn-primary btn-sm ml10" title="Nueva ciudad">
                <span class="fa fa-plus pr5"></span>
                <span class="fa fa-credit-card pr5"></span>
              </a>

              <a href="<?=$server?>/panel/menu/7" class="btn btn-primary btn-sm ml10" title="Parametrización">
                REGRESAR &nbsp;
                <span class="fa fa-arrow-left"></span>
              </a>
            </div>
          </header>
          <!-- -------------- /Topbar ---------------->

          <!-- -------------- Content ---------------->
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
                            <font color="white">
                            Ciudades</font>
                          </th>
                        </tr>
                      </thead>

                      <tr>
                        <td>
                          <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                            <thead>
                              <tr style="background-color: #F8F8F8">
                                <th style="text-align: left">
                                  #
                                </th>
                                <th style="text-align: left">
                                  E.
                                </th>
                                <th style="text-align: left">
                                  Código
                                </th>
                                <th style="text-align: left">
                                  Departamento
                                </th>
                                <th style="text-align: left">
                                  Ciudad
                                </th>
                                <th style="text-align: center">
                                  Modificar
                                </th>
                              </tr>
                            </thead>

                            <tbody>
                              <?php
                              $e=1;
                              ?>
                              @foreach($DatosCiudades as $DatCiudades)
                                <?php
                                if($DatCiudades->estado == '0')
                                  $color = '#F6565A';
                                else
                                  $color = '#AEBF25';
                                ?>

                                <tr class="message-unread">
                                  <td style="text-align: left ">
                                    <font color="#2A2F43">
                                      <?php
                                      echo $e;
                                      $e++;
                                      ?>
                                    </font>
                                  </td>

                                  <td style="text-align: left ">
                                    <i class="fa fa-map-marker fa-lg" style="color:<?=$color?>;"></i>
                                  </td>

                                  <td style="text-align: left ">
                                    <font color="#2A2F43">
                                      <b>
                                        <?=$DatCiudades->codigo?>
                                      </b>
                                    </font>
                                  </td>

                                  <td style="text-align: left">
                                    <font color="#2A2F43">
                                      <?=$DatCiudades->nom_depto?>
                                    </font>
                                  </td>

                                  <td style="text-align: left">
                                    <font color="#2A2F43">
                                      <?=$DatCiudades->nom_ciudad?>
                                    </font>
                                  </td>

                                  <td style="text-align: center">
                                    <button type="button" class="btn btn-default light" onclick="window.location.href='<?=$server?>/panel/parametrizacion/ciudades/modificar/<?=$DatCiudades->id_ciudad?>'">
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
      <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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