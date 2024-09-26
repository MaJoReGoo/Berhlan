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
        Intranet | Atender solicitud
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
      <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.css')}}">

      <!-- -------------- Plugins -------------- -->
      <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css')}}">

      <!-- -------------- Favicon -------------- -->
      <link rel="shortcut icon" href="{{ asset ('/panelfiles/assets/img/favicon.ico')}}">

      <!-- Editor -->
      <script type="text/javascript" src="{{ asset ('/panelfiles/ckeditor/ckeditor.js')}}"></script>
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
                  <a href="javascript:history.back()" title="Bcloud > Pendientes de > Impresión muestras físicas">
                    <font color="#34495e">
                      Bcloud > Pendientes de > Impresión muestras físicas >
                    </font>
                    <font color="#b4c056">
                      Atender
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="javascript:history.back()" class="btn btn-primary btn-sm ml10" title="Bcloud > Pendientes de > Impresión muestras físicas">
                REGRESAR &nbsp;
                <span class="fa fa-arrow-left"></span>
              </a>
            </div>
          </header>
          <!-- -------------- /Topbar -------------- -->

          <!-- -------------- Content -------------- -->
          <section id="content" class="table-layout animated fadeIn">
            <div class="chute chute-center pt20">
              <!-- -------------- Column Center -------------- -->
              <div class="panel m3">
                <!-- -------------- Message Body -------------- -->
                <div class="nano-content">
                  <div class="table-responsive">
                    <table id="message-table" class="table allcp-form theme-warning br-t">
                      <thead>
                        <tr style="background-color:#39405a">
                          <th>
                            Muestra física SMF<?=$DatosMuestra[0]->id_solicitud?>
                          </th>
                        </tr>
                      </thead>

                      <tr>
                        <td>
                          <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Descripción:
                              </th>
                              <td style="text-align:left">
                                <?=$DatosMuestra[0]->descripcion?>
                              </td>

                              <th style="text-align:left">
                                Tamaño:
                              </th>
                              <td style="text-align:left">
                                <?=$DatosMuestra[0]->tamano?>
                              </td>

                              <th style="text-align:left">
                                Cantidad:
                              </th>
                              <td style="text-align:left">
                                <?=$DatosMuestra[0]->cantidad?>
                              </td>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Observaciones:
                              </th>
                              <td style="text-align:justify;">
                                <?=$DatosMuestra[0]->observaciones?>
                              </td>

                              <th style="text-align:left">
                                Archivo:
                              </th>
                              <td style="text-align:justify;">
                                <?php
                                if($DatosMuestra[0]->archivo != '')
                                 {
                                  ?>
                                  <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.open('{{ asset ('/archivos/Bpack/Muestras/')}}<?=$DatosMuestra[0]->archivo?>','_blank')" title="<?=$DatosMuestra[0]->archivo?>">
                                    <i class="fa fa-file-image-o fa-lg" style="color:#b4c056;"></i>
                                  </button>
                                  <?php
                                 }
                                else
                                 {
                                  echo "No adjunto";
                                 }
                                ?>
                              </td>

                              <th style="text-align:left">
                                Solicitado por:
                              </th>
                              <td style="text-align:left">
                                <?php
                                $empleado = PanelEmpleados::getEmpleado($DatosMuestra[0]->usr_crea);
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
                                echo $DatosMuestra[0]->fecha_crea;
                                ?>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>

              <br>

              <div class="panel m4">
                <!-- -------------- Message Body -------------- -->
                <div class="nano-content">
                  <div class="table-responsive">
                    <table id="message-table" class="table allcp-form theme-warning br-t">
                      <thead>
                        <tr>
                          <th style="background-color:#67d3e0; color:#34495e; text-align:left;">
                            Solicitud de impresión muestra física SMF<?=$DatosMuestra[0]->id_solicitud?>
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>
                            <div class="allcp-form">
                              {!! Form::open(array('action' => 'Bpack\MuestrasPanelController@ProcesarDB', 'class' => 'form', 'id'=>'form-wizard')) !!}
                                {!! Form::hidden('muestra', $DatosMuestra[0]->id_solicitud) !!}
                                <div class="row">
                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Observaciones
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::textarea('observaciones', '', array('', 'id'=>'observaciones', 'class'=>'gui-input', 'style'=>'height: 80px; resize: vertical;', 'placeholder'=>'Observaciones.')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-reorder"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-2">
                                    <label style="color: #34495e">
                                      <b>
                                        Remisión
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('remision', null, array('required', 'id'=>'remision', 'class'=>'gui-input', 'placeholder'=>'* Remisión')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-reorder"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-2">
                                    <br><br>
                                    {!! Form::submit('Finalizar', array('class'=>'button')) !!}
                                  </div>
                                </div>
                              {!! Form::close() !!}
                            </div>
                          </td>
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
      <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js')}}"></script>
      <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js')}}"></script>

      <!-- -------------- JvectorMap Plugin -------------- -->
      <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js"></script>
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
      <!-- -------------- /Scripts -------------- -->

    </body>
  </html>
@endforeach
