<?php

use App\Models\Bpack\PanelSolicitudesAN;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Bcloud | Consulta sherpas aprobadas
      </title>
      <meta name="description" content="Intranet para grupo Berhlan">
      <meta name="author" content="USUARIO" >
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!-- -------------- Fonts -------------- -->
      <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
      <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

      <!-- -------------- CSS - theme -------------- -->
      <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/skin/default_skin/css/theme.css')}}">

      <!-- -------------- CSS - allcp forms -------------- -->
      <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.min.css')}}">

      <!-- -------------- Plugins -------------- -->
      <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css')}}">

      <!-- -------------- Favicon -------------- -->
      <link rel="shortcut icon" href="{{ asset ('/panelfiles/assets/img/favicon.ico')}}">

      <!-- -------------- DataTables -------------- -->
      <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">

      <script src="{{ asset ('/panelfiles/sweetalert/dist/sweetalert.min.js')}}"></script>

      <link rel="stylesheet" href="{{ asset ('/panelfiles/sweetalert/dist/sweetalert.css')}}">
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
                  <a href="{{ asset ('/panel/bpack/otconsultas')}}" title="Bcloud > Otras consultas">
                    <font color="#34495e">
                       Bcloud > Otras consultas >
                    </font>
                    <font color="#b4c056">
                      Consulta sherpas digitales aprobadas
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="{{ asset ('/panel/bpack/otconsultas')}}" class="btn btn-primary btn-sm ml10" title="Bcloud > Otras consultas">
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
                  <div style="padding-left: 10px; background-color:#39405a; color: white;">
                    Sherpas digitales aprobadas
                  </div>
                  <br>

                  <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                    <thead>
                      <tr style="background-color: #F8F8F8">
                        <th style="text-align: center">
                          Solicitud
                        </th>
                        <th style="text-align: center;">
                          Cliente
                        </th>
                        <th style="text-align: center;">
                          Referencia
                        </th>
                        <th style="text-align: center;">
                          Ítem
                        </th>
                        <th style="text-align: center;">
                          Versión
                        </th>
                        <th style="text-align: center;">
                          Fecha
                        </th>
                        <th style="text-align: center">
                          Sherpa
                        </th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      $u = 1;
                      $itemant = "";
                      ?>
                      @foreach($DatosSolicitudes as $DatSol)
                        <?php
                        if($DatSol->item != $itemant)
                         {
                          $itemant = $DatSol->item;

                          if($DatSol->id_nvdesarrollo != 0)  //Si es nuevo desarrollo
                           {
                            $color  = '#21618c';
                            $inicio = "SBM";
                           }
                          else
                           {
                            $inicio = "SBA";
                            if($DatSol->tipo == 'AR')
                              $color = 'green';
                            else
                              $color = 'red';
                           }
                          ?>

                          <tr class="message-unread">
                            <td style="text-align: center;">
                              <i class="fa fa-dot-circle-o fa-lg" style="color:<?=$color?>;"></i>
                              &nbsp;
                              <font color="#2A2F43">
                                <b>
                                  <?php
                                  echo $inicio;
                                  if($inicio == "SBM")
                                    echo $DatSol->id_nvdesarrollo;
                                  else
                                    echo $DatSol->id_actualizacion;
                                  ?>
                                </b>
                              </font>
                            </td>

                            <td style="text-align:left;">
                              <font color="#2A2F43">
                                <?=$DatSol->cliente?>
                              </font>
                            </td>

                            <td style="text-align:left;">
                              <font color="#2A2F43">
                                <?=$DatSol->referencia?>
                              </font>
                            </td>

                            <td style="text-align:center;">
                              <font color="#2A2F43">
                                <?=$DatSol->item?>
                              </font>
                            </td>

                            <td style="text-align:center;">
                              <font color="#2A2F43">
                                <?=$DatSol->version?>
                              </font>
                            </td>

                            <td style="text-align: center">
                              <font color="#2A2F43">
                                <?php
                                $fechafin = PanelSolicitudesAN::fechafin($DatSol->id_solicitud);
                                echo $fechafin[0]->fecha;
                                ?>
                              </font>
                            </td>

                            <td style="text-align:center;">
                              <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.open('{{ asset ('/archivos/Bpack/Solicitudes/')}}<?=$DatSol->ruta_sherpa."?".date('i:s')?>','_blank')" title="<?=$DatSol->ruta_sherpa?>">
                                <i class="fa fa-file-pdf-o fa-lg" style="color:#b90202;"></i>
                              </button>
                            </td>
                          </tr>
                          <?php
                         }
                        ?>
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
      <script src="{{ asset ('/panelfiles/assets/js/demo/widgets_sidebar.js')}}"></script>
      <script src="{{ asset ('/panelfiles/assets/js/pages/dashboard2.js')}}"></script>

      <!-- -------------- Page JS -------------- -->
      <script src="{{ asset ('/panelfiles/assets/js/demo/charts/highcharts.js')}}"></script>

      <!-- -------------- DataTables -------------- -->
      <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
      <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
      <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

      <script>
      $('#message-table').DataTable(
       {
        "order": [[ 5, "desc" ]],
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
