<?php

use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Bcloud | Solicitudes pendientes de ruta
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

      <!-- Alerts Personalizados -->
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
                  <a href="{{ asset ('/panel/bpack/solpendientes')}}" title="Bcloud > Solicitudes pendientes de">
                    <font color="#34495e">
                       Bcloud > Solicitudes pendientes de >
                    </font>
                    <font color="#b4c056">
                      Solicitudes pendientes de ruta
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="{{ asset ('/panel/bpack/solpendientes')}}" class="btn btn-primary btn-sm ml10" title="Bcloud > Solicitudes pendientes de">
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
                    Planeación - Solicitudes pendientes de ruta
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
                          Solicitado por
                        </th>
                        <th style="text-align: center">
                          Solicitado hace
                        </th>
                        <th style="text-align: center">
                          Atender
                        </th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php $u = 1; ?>
                      @foreach($PenRuta as $DatRut)
                        <?php
                        if($DatRut->id_nvdesarrollo != 0)  //Si es nuevo desarrollo
                         {
                          $color  = '#21618c';
                          $inicio = "SBM";
                          $des    = "Nuevos desarrollos";
                         }
                        else
                         {
                          $inicio = "SBA";
                          if($DatRut->tipo == 'AR')
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
                                  echo $DatRut->id_nvdesarrollo;
                                else
                                  echo $DatRut->id_actualizacion;
                                ?>
                              </b>
                            </font>
                          </td>

                          <td style="text-align: justify;">
                            <font color="#2A2F43">
                              <?=$DatRut->cliente?>
                            </font>
                          </td>

                          <td style="text-align: center;">
                            <font color="#2A2F43">
                              <?=$des?>
                            </font>
                          </td>

                          <td style="text-align: center">
                            <font color="#2A2F43">
                              <?php
                              $empleado = PanelEmpleados::getEmpleado($DatRut->usr_crea);
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
                              echo $DatRut->fecha_crea;
                              ?>
                            </font>
                          </td>

                          <td style="text-align: center;">
                            <font color="#6CBCED">
                              <?php
                              $fecha1 = new DateTime($DatRut->fecha_crea);
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
                            <button type="button" class="btn btn-default light" onclick="window.location.href='{{ asset ('/panel/bpack/penruta/procesar/')}}<?=$DatRut->id_solicitud?>'">
                              <i class="fa fa-pencil fa-lg" style="color:#AEBF25;"></i>
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

      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach
