<?php
$server = '/Berhlan/public';

use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Disciplinarios\PanelTipofaltas;
use App\Models\Disciplinarios\PanelSolicitudes;

$e = 0;
?>
@foreach($DatosSolicitudes as $DatSol)
  <?php $e++;?>
@endforeach


@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Procesos disciplinarios | Atender procesos
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
                  <a href="<?=$server?>/panel/menu/45" title="Procesos disciplinarios">
                    <font color="#34495e">
                      Procesos disciplinarios >
                    </font>
                    <font color="#b4c056">
                      Atender procesos
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/menu/45" class="btn btn-primary btn-sm ml10" title="Procesos disciplinarios">
                REGRESAR &nbsp;
                <span class="fa fa-arrow-left"></span>
              </a>
            </div>
          </header>
          <!-- -------------- /Topbar -------------- -->

          <!-- -------------- Content -------------- -->

          <br>
          <div class="col-sm-3 col-xl-4">
            <div class="col-xs-12 ph10 text-center  panel panel-body">
              <i class="fa fa-check-circle fa-3x" style="color:green; text-shadow: 1px -1px 1px #000;">
                <?php
                $ano = date('Y');
                $mes = date('m');
                echo $atendidosmes = PanelSolicitudes::AtendidosMes($ano, $mes);
                $pendientesmes = PanelSolicitudes::PendientesMes($ano, $mes);
                ?>
              </i>
              <h6 class="text-muted" style="padding-top: 30px">
                <font color="#2a2f43">
                  Procesos atendidos en el mes
                </font>
              </h6>
            </div>
          </div>

          <div class="col-sm-3 col-xl-4">
            <div class="col-xs-12 ph10 text-center  panel panel-body">
              <i class="fa fa-exclamation-circle fa-3x" style="color:red; text-shadow: 1px -1px 1px #000;"> <?=$e?></i>
              <h6 class="text-muted" style="padding-top: 30px">
                <font color="#2a2f43">
                  Procesos pendientes de respuesta
                </font>
              </h6>
            </div>
          </div>

          <div class="col-sm-3 col-xl-4">
            <div class="col-xs-12 ph10 text-center  panel panel-body">
              <i class="fa fa-exclamation-triangle fa-3x" style="color:orange; text-shadow: 1px -1px 1px #000;">
                <?= $pendientesmes?>
              </i>
              <h6 class="text-muted" style="padding-top: 30px">
                <font color="#2a2f43">
                  Procesos pendientes de respuesta en el mes
                </font>
              </h6>
            </div>
          </div>

          <section id="content" class="table-layout animated fadeIn">
            <div class="chute chute-center pt5">
              <!-- -------------- Column Center -------------- -->

              <div class="panel m3">
                <!-- -------------- Message Body -------------- -->
                <div class="nano-content">
                  <div class="table-responsive">
                    <table id="message-table" class="table allcp-form theme-warning br-t">
                      <thead>
                        <tr>
                          <th style="background-color:#67d3e0; color:#34495e; text-align:left;">
                            Colaborador que cometió la falta
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>
                            <div class="allcp-form">
                              {!! Form::open(array('action' => 'Disciplinarios\AtenderDisciplinariosPanelController@AtenderEmpleado', 'class' => 'form', 'id'=>'form-wizard')) !!}
                                <div class="row">
                                  <div class="col-md-4">
                                    <label class="field prepend-icon">
                                      {!! Form::text('empleado', $Empconsulta, array('', 'id'=>'empleado', 'class'=>'gui-input', 'placeholder'=>'Identificación')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa ">CC.</i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    {!! Form::submit('Consultar', array('class'=>'button')) !!}
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

              <br>

              <div class="panel m3">
                <!-- -------------- Message Body -------------- -->
                <div class="nano-content">
                  <div class="table-responsive">
                    <table id="message-table" class="table allcp-form theme-warning br-t">
                      <thead>
                        <tr style="background-color:#39405a">
                          <th>
                            Solicitudes pendientes por atender
                          </th>
                        </tr>
                      </thead>

                      <tr>
                        <td>
                          <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped datatable">
                            <thead>
                              <tr style="background-color: #F8F8F8; color:#000000">
                                <th style="text-align:left">
                                  #
                                </th>
                                <th style="text-align:center;">
                                  P.D.
                                </th>
                                <th style="text-align:center">
                                  Centro de operación
                                </th>
                                <th style="text-align: center">
                                  Colaborador
                                </th>
                                <th style="text-align: center">
                                  Estado
                                </th>
                                <th style="text-align: center">
                                  Tipo de falta
                                </th>
                                <th style="text-align: center">
                                  Fecha de la falta
                                </th>
                                <th style="text-align:left;">
                                  Solicitado por
                                </th>
                                <th style="text-align: center">
                                  Fecha solicitud
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

                                  <td style="text-align:center;" nowrap>
                                    <font color="#2A2F43">
                                      <b>
                                        PD-<?=$DatSol->id_solicitud?>
                                      </b>
                                    </font>
                                  </td>

                                  <td style="text-align:left">
                                    <font color="#2A2F43">
                                      <?php
                                      $empleado = PanelEmpleados::getEmpleado($DatSol->colaborador);
                                      $centro   = PanelCentrosOp::getCentroOp($empleado[0]->centro_op);
                                      echo $centro[0]->descripcion;
                                      ?>
                                    </font>
                                  </td>

                                  <td style="text-align:left">
                                    <font color="#2A2F43">
                                      <?php
                                      if($DatSol->estado == 1)
                                        echo "<font color=\"red\">";

                                        echo $empleado[0]->identificacion;
                                        echo " - ";echo $empleado[0]->primer_nombre;
                                        echo " ";
                                        echo $empleado[0]->ot_nombre;
                                        echo " ";
                                        echo $empleado[0]->primer_apellido;
                                        echo " ";
                                        echo $empleado[0]->ot_apellido;
                                      if($DatSol->estado == 1)
                                        echo "</font>";

                                      echo "<br>";
                                      $cargo = PanelCargos::getCargo($empleado[0]->cargo);
                                      echo $cargo[0]->descripcion;
                                      echo "<br>";
                                      $Area = PanelAreas::getArea($cargo[0]->area);
                                      echo $Area[0]->descripcion;
                                      echo "<br>";
                                      $Empresa = PanelEmpresas::getEmpresa($Area[0]->empresa);
                                      echo $Empresa[0]->nombre;
                                      ?>
                                    </font>
                                  </td>

                                  <td style="text-align:center">
                                    <font color="#2A2F43">
                                      <?php
                                      if($DatSol->estado == 0)
                                        echo "Atendido";
                                      else
                                        echo "Pendiente";
                                      ?>
                                    </font>
                                  </td>

                                  <?php
                                  $Faltas = PanelTipofaltas::Tipofalta($DatSol->tipo_falta);
                                  ?>
                                  <td style="text-align:center">
                                    <font color="#2A2F43">
                                      <?=$Faltas[0]->descripcion?>
                                    </font>
                                  </td>

                                  <td style="text-align:center">
                                    <font color="#2A2F43">
                                      <?=$DatSol->fecha_falta?>
                                    </font>
                                  </td>

                                  <td style="text-align:left">
                                    <font color="#2A2F43">
                                      <?php
                                      $empleado1 = PanelEmpleados::getEmpleado($DatSol->usr_solicita);
                                      echo $empleado1[0]->primer_nombre;
                                      echo " ";
                                      echo $empleado1[0]->ot_nombre;
                                      echo " ";
                                      echo $empleado1[0]->primer_apellido;
                                      echo " ";
                                      echo $empleado1[0]->ot_apellido;
                                      ?>
                                    </font>
                                  </td>

                                  <td style="text-align:center">
                                    <font color="#2A2F43">
                                      <?=$DatSol->fecha_solicita?>
                                    </font>
                                  </td>

                                  <td style="text-align: center">
                                    <button type="button" class="btn btn-default light" onclick="window.location.href='<?=$server?>/panel/disciplinarios/atender/procesar/<?=$DatSol->id_solicitud?>'" title="Más información">
                                      <?php
                                      if($DatSol->estado == 0)
                                        echo "<i class=\"fa fa-exclamation-circle fa-lg\" style=\"color:#AEBF25;\"></i>";
                                      else
                                        echo "<i class=\"fa fa-legal fa-lg\" style=\"color:red;\"></i>";
                                      ?>
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
      <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
      <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
      <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>


      <script>
        $(document).ready(function() {

            let datatable = $('.datatable').DataTable({
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
