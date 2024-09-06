<?php
$server = '/Berhlan/public';
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Empresas
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

      <!-- This is what you need -->

      <script src="<?=$server?>/panelfiles/sweetalert/dist/sweetalert.min.js"></script>

      <link rel="stylesheet" href="<?=$server?>/panelfiles/sweetalert/dist/sweetalert.css">

      <!-- Alerts Personalizados -->

      <style>
        .table-fixed thead,
        .table-fixed tfoot
         {
          width: 100%;
         }

        .table-fixed thead,
        .table-fixed tbody,
        .table-fixed tfoot,
        .table-fixed tr,
        .table-fixed td,
        .table-fixed th
         {
          display: flex;
          flex: 100%;
         }

        .table-fixed tbody td,
        .table-fixed thead > tr> th,
        .table-fixed tfoot > tr> td
         {
          border-bottom-width: 0;
         }

        .table-fixed tbody tr, .table-fixed tbody td, .table-fixed th
         {
          width: 100%;
         }

        .table-fixed tbody
         {
          height: auto;
          overflow: auto;
          width: 100%;
          flex-flow: row wrap;
          max-height: 70vh;
         }

        .table-responsive
         {
          overflow: auto;
         }

        .table-fixed tbody td, .table-fixed th
         {
          width: 112px;
         }
      </style>
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
                      Parametrización > Empresas
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/parametrizacion/empresas/agregar" class="btn btn-primary btn-sm ml10" title="Nueva empresa">
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
                  <br>
                  <div style="padding-left: 10px">
                    Cantidad de empresas:
                    <?=$EmpresasActivas+$EmpresasInactivas?>
                    <font color="#b4c056">
                      (<?=$EmpresasActivas?>)
                    </font>
                  </div>

                  <br>

                  <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                    <thead>
                      <tr style="background-color: #F8F8F8">
                        <th style="text-align: left">
                          Nit
                        </th>
                        <th style="text-align: left">
                          Nombre
                        </th>
                        <th style="text-align: center">
                          Logo
                        </th>
                        <th style="text-align: center">
                          Modificar
                        </th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach($DatosEmpresas as $DatEmpresas)
                        <?php
                        if($DatEmpresas->estado == '0')
                          $color = '#F6565A';
                        else
                          $color = '#AEBF25';
                        ?>

                        <tr class="message-unread">
                          <td style="text-align: left ">
                            <i class="fa fa-building-o fa-lg" style="color:<?=$color?>;"></i>
                            &nbsp;
                            <font color="#2A2F43">
                              <b>
                                <?=$DatEmpresas->identificacion?>
                              </b>
                            </font>
                          </td>

                          <td style="text-align: left">
                            <font color="#2A2F43">
                              <?=$DatEmpresas->nombre?>
                            </font>
                          </td>

                          <td style="text-align: center">
                            <?php
                            $ruta  = "/Berhlan/public/archivos/Logos/".$DatEmpresas->identificacion.".png";
                            ?>
                            <img src="<?=$ruta?>" class="img-responsive mauto" style="width: 80px; border-radius:6px; border:1;"/>
                          </td>

                          <!-- Modificar -->
                          <td style="text-align: center">
                            <button type="button" class="btn btn-default light" onclick="window.location.href='<?=$server?>/panel/parametrizacion/empresas/modificar/<?=$DatEmpresas->id_empresa?>'">
                              <i class="fa fa-pencil fa-lg" style="color:#AEBF25;"></i>
                            </button>
                          </td>
                          <!-- Modificar -->
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

      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach