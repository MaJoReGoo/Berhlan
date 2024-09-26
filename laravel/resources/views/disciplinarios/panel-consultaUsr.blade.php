<?php

use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Disciplinarios\PanelMotivos;
use App\Models\Disciplinarios\PanelTipofaltas;
use App\Models\Disciplinarios\PanelSolicitudes;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Procesos disciplinarios | Consulta
      </title>
      <meta name="keywords" content="panel, cms, usuarios, servicio"/>
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
      <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css">

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
                  <a href="{{ asset ('/panel/menu/45')}}" title="Procesos disciplinarios">
                    <font color="#34495e">
                      Procesos disciplinarios >
                    </font>
                    <font color="#b4c056">
                      Consulta solicitudes
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="{{ asset ('/panel/menu/45')}}" class="btn btn-primary btn-sm ml10" title="Procesos disciplinarios">
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
                    <table id="message-table" class="table allcp-form theme-warning br-t">
                      <thead>
                        <tr>
                          <th style="background-color:#67d3e0; color:#34495e; text-align:left;">
                            Consulta parametrizada
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>
                            <div class="allcp-form">
                              {!! Form::open(array('action' => 'Disciplinarios\ConsultasDisciplinariosPanelController@ConsultaUsrListado', 'class' => 'form', 'id'=>'form-wizard')) !!}
                                <div class="row">
                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Número de solicitud
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::number('solicitud', null, array('', 'id'=>'solicitud', 'class'=>'gui-input', 'placeholder'=>'Proceso disciplinario', 'min'=>'1')) !!}
                                      <label for="username" class="field-icon">
                                        <i>PD -</i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Identificación del colaborador que cometió la falta
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::number('identificacion', null, array('', 'id'=>'identificacion', 'class'=>'gui-input', 'placeholder'=>'Identificación', 'min'=>'1')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-user"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Colaborador que cometió la falta
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="usr_falta" id="usr_falta">
                                        <option value="">
                                          Falta cometida por
                                        </option>
                                        <?php
                                        $Usrfalta = PanelSolicitudes::UsrFaltaSolicitudesUsr($DatLog->empleado);
                                        ?>
                                        @foreach($Usrfalta as $DatUrf)
                                          <?php
                                          $Empleado = PanelEmpleados::getEmpleado($DatUrf->colaborador);
                                          $Cargo    = PanelCargos::getCargo($Empleado[0]->cargo);
                                          $Area     = PanelAreas::getArea($Cargo[0]->area);
                                          ?>
                                          <option value="<?=$DatUrf->colaborador?>">
                                            <?php
                                            echo $Empleado[0]->primer_nombre;
                                            echo " ";
                                            echo $Empleado[0]->ot_nombre;
                                            echo " ";
                                            echo $Empleado[0]->primer_apellido;
                                            echo " ";
                                            echo $Empleado[0]->ot_apellido;
                                            echo " &nbsp;&nbsp;-&nbsp;&nbsp; ";
                                            echo $Cargo[0]->descripcion;
                                            echo " - ";
                                            echo $Area[0]->descripcion;
                                            ?>
                                          </option>
                                        @endforeach
                                      </select>
                                      <i class="arrow"></i>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Estado de la solicitud
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="estado" id="estado">
                                        <option value="">
                                          Estado
                                        </option>
                                        <option value="0">
                                          Atendida, finalizada
                                        </option>
                                        <option value="1">
                                          En proceso
                                        </option>
                                      </select>
                                      <i class="arrow"></i>
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <br>
                                  <div class="col-md-3">
                                    <label style="color:#34495e;">
                                      <b>
                                        Fecha de solicitud desde
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::date('soldesde', null, array('', 'id'=>'soldesde', 'class'=>'gui-input', 'maxlength'=>'10')) !!}
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color:#34495e;">
                                      <b>
                                        Fecha de solicitud hasta
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::date('solhasta', null, array('', 'id'=>'solhasta', 'class'=>'gui-input', 'maxlength'=>'10')) !!}
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color:#34495e;">
                                      <b>
                                        Tipo de falta
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="tpfalta" id="tpfalta">
                                        <option value="">
                                          Tipo de falta
                                        </option>
                                        <?php
                                        $Faltas = PanelTipofaltas::TipofaltasActivas();
                                        ?>
                                        @foreach($Faltas as $DatFal)
                                          <option value="<?=$DatFal->id_tipofalta?>">
                                            <?=$DatFal->descripcion?>
                                          </option>
                                        @endforeach
                                      </select>
                                      <i class="arrow"></i>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Causa de la solicitud
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('causa', null, array('', 'id'=>'causa', 'class'=>'gui-input', 'placeholder'=>'Palabra clave')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-bars"></i>
                                      </label>
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <br>
                                  <div class="col-md-3">
                                    <label style="color:#34495e;">
                                      <b>
                                        Motivo de cierre
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="motivo" id="motivo">
                                        <option value="">
                                          Motivo de cierre
                                        </option>
                                        <?php
                                        $Motivos = PanelMotivos::MotivosActivos();
                                        ?>
                                        @foreach($Motivos as $DatMot)
                                          <option value="<?=$DatMot->id_motivocierre?>">
                                            <?=$DatMot->descripcion?>
                                          </option>
                                        @endforeach
                                      </select>
                                      <i class="arrow"></i>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <br><br>
                                    {!! Form::submit('Consultar', array('class'=>'button')) !!}
                                    <br><br>
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
      <script src="{{ asset ('/panelfiles/assets/js/pages/allcp_forms-elements.js')}}"></script>
      <script src="{{ asset ('/panelfiles/assets/js/demo/widgets_sidebar.js')}}"></script>

      <!-- -------------- Page JS -------------- -->
      <script src="{{ asset ('/panelfiles/assets/js/demo/charts/highcharts.js')}}"></script>

      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach
