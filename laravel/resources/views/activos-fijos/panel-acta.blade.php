<?php
{{ asset = '/Berhlan/public'}};

use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\TicActivos\PanelTipos;
use App\Models\ActivosFijos\PanelTextos;
use App\Models\TicActivos\PanelMarcas;
use App\Models\TicActivos\PanelActivos;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Activos TIC | Acta
      </title>
      <meta name="description" content="Intranet para grupo Berhlan">
      <meta name="author" content="USUARIO" >
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!-- -------------- Fonts -------------- -->
      <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
      <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

      <!-- -------------- CSS - theme -------------- -->
      <link rel="stylesheet" type="text/css" href="<{{ asset ('/panelfiles/assets/skin/default_skin/css/theme.css') }}">

      <!-- -------------- CSS - allcp forms -------------- -->
      <link rel="stylesheet" type="text/css" href="<{{ asset ('/panelfiles/assets/allcp/forms/css/forms.min.css') }}">
      <link rel="stylesheet" type="text/css" href="<{{ asset ('/panelfiles/assets/allcp/forms/css/forms.css') }}">

      <!-- -------------- Plugins -------------- -->
      <link rel="stylesheet" type="text/css" href="<{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css') }}">

      <!-- -------------- Favicon -------------- -->
      <link rel="shortcut icon" href="<{{ asset ('/panelfiles/assets/img/favicon.ico') }}">

      <!-- Editor -->
      <script type="text/javascript" src="<{{ asset ('/panelfiles/ckeditor/ckeditor.js') }}"></script>
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
                  <a href="<{{asset ('/panel/activos/consulta/parametrizada/detalle/') }}{{$DatosActivo[0]->id_activo}}" title="Activos TIC">
                    <font color="#34495e">
                      Activos TIC >
                    </font>
                    <font color="#b4c056">
                      Acta de entrega
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<{{ asset ('/panel/activos/consulta/parametrizada/detalle/') }}{{$DatosActivo[0]->id_activo}}" class="btn btn-primary btn-sm ml10" title="Activos TIC">
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
              <div class="panel m4">
                <!-- -------------- Message Body -------------- -->
                <div class="nano-content">
                  <div class="table-responsive">
                    <div id="imprime">
                      <table id="message-table" class="table allcp-form theme-warning br-t">
                        <tbody>
                          <tr>
                            <th style="font-size:26px; color:#34495e; text-align:left;" width="90%">
                              Acta de entrega activo fijo No. <?=$DatosActivo[0]->id_activo?>
                              <br>
                              <font size="3">
                                <?php
                                echo date('Y-m-d');
                                ?>
                              </font>
                            </th>

                            <td style="text-align:right;" colspan="3" width="10%">
                              <?php
                              $empresa = PanelEmpresas::getEmpresa($DatosActivo[0]->empresa);
                              $ruta    = "/Berhlan/public/archivos/Logos/".$empresa[0]->identificacion.".png";
                              ?>
                              <img src="<?=$ruta?>" style="width: 110px;"/>
                            </td>
                          </tr>
                        </tbody>
                      </table>

                      <table id="message-table" class="table allcp-form theme-warning br-t" cellpadding="6">
                        <tbody>
                          <tr>
                            <td style="font-size:16px; color:#34495e; text-align:left;" colspan="4">
                              Se hace entrega de
                              <b>
                                <font size="4">
                                  <?php
                                  $Tipo = PanelTipos::getTipo($DatosActivo[0]->tipo);
                                  echo $Tipo[0]->descripcion;
                                  ?>
                                </font>
                              </b>
                              con las siguientes características:
                            </td>
                          </tr>

                          <tr>
                            <td style="font-size:16px; color:#34495e; text-align:left;" colspan="4">
                              <table border="1" class="table theme-warning br-t" width="100%" cellpadding="6" cellspacing="0">


                                <tr>
                                  <th align="left">
                                    Código interno:
                                  </th>
                                  <td>
                                    <?=$DatosActivo[0]->cod_interno?>
                                  </td>

                                  <th align="left">
                                    Activo fijo:
                                  </th>
                                  <td>
                                    <?=$DatosActivo[0]->activo_fijo?>
                                  </td>
                                </tr>

                                <tr>
                                    <th align="left">
                                        Color</th>
                                    <td>
                                        <?=$DatosActivo[0]->color?>
                                      </td>
                                </tr>
                              </table>
                            </td>
                          </tr>

                          <tr>
                            <td style="color:#34495e; text-align:justify;" colspan="4">
                              <b>Observaciones: </b><?=$DatosActivo[0]->observaciones?>
                              <br><br>
                              <hr style="width:100%; color:#34495e; text-align:center;">
                            </td>
                          </tr>

                          <tr>
                            <td style="color:#34495e; text-align:justify;" colspan="4">
                              <?php
                              $Textos = PanelTextos::getTextos();
                              echo $Textos[0]->texto1;
                              ?>
                              <br><br>
                              <hr style="width:100%; color:#34495e; text-align:center;">
                              <br>
                              <hr style="width:100%; color:#34495e;">
                            </td>
                          </tr>


                            <tr>
                              <td style="color:#34495e; text-align:justify;" colspan="4">
                                <?php
                                echo $Textos[0]->texto2;
                                ?>
                              </td>
                            </tr>


                          <tr>
                            <td style="color:#34495e;" colspan="2">
                              <br>
                              Hace entrega,
                            </td>

                            <td style="color:#34495e;" colspan="2">
                              <br>
                              Recibe,
                            </td>
                          </tr>

                          <tr>
                            <td style="color:#34495e;" width="100">
                              <br>
                              Nombre:
                            </td>

                            <td style="color:#34495e;">
                              <?php
                              $empleado = PanelEmpleados::getEmpleado($DatLog->empleado);
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
                              $Area = PanelAreas::getArea($cargo[0]->area);
                              echo $Area[0]->descripcion;
                              ?>
                            </td>

                            <td style="color:#34495e;" width="100">
                              <br>
                              Colaborador:
                            </td>

                            <td style="color:#34495e;">
                              <?php
                              $empleado = PanelEmpleados::getEmpleado($DatosActivo[0]->empleado);
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
                              $Area = PanelAreas::getArea($cargo[0]->area);
                              echo $Area[0]->descripcion;
                              ?>
                            </td>
                          </tr>

                          <tr>
                            <td style="color:#34495e;">
                              <br>
                              Firma:
                            </td>

                            <td style="color:#34495e;">
                              <br>
                              <hr style="width:95%; color:#34495e;">
                            </td>

                            <td style="color:#34495e;">
                              <br>
                              Firma:
                              <br><br>
                              C.C.:
                            </td>

                            <td style="color:#34495e;">
                              <br>
                              <hr style="width:100%; color:#34495e;">
                              <br>
                              <hr style="width:100%; color:#34495e;">
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                    &nbsp;&nbsp;
                    <button class="btn btn-primary light" onclick="imprime('imprime')" style="background-color:#2b3980;">Imprimir</button>
                    <br><br>

                    <script language="javascript" type="text/javascript">
                    function imprime(imprime)
                     {
                      var ficha = document.getElementById(imprime);
                      var ventimp = window.open(' ','popimpr');
                      ventimp.document.write(ficha.innerHTML);
                      ventimp.document.close();
                      ventimp.print();
                      ventimp.close();
                     }
                    </script>
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
      <script src="<{{ asset ('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js') }}"></script>
      <script src="<{{ asset ('/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js') }}"></script>

      <!-- -------------- JvectorMap Plugin -------------- -->
      <script src="<{{ asset ('/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js') }}"></script>
      <script src="<{{ asset ('/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js') }}"></script>

      <!-- -------------- HighCharts Plugin -------------- -->
      <script src="<{{ asset ('/panelfiles/assets/js/plugins/highcharts/highcharts.js') }}"></script>
      <script src="<{{ asset ('/panelfiles/assets/js/plugins/c3charts/d3.min.js') }}"></script>
      <script src="<{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.js') }}"></script>

      <!-- -------------- Theme Scripts -------------- -->
      <script src="<{{ asset ('/panelfiles/assets/js/utility/utility.js') }}"></script>
      <script src="<{{ asset ('/panelfiles/assets/js/demo/demo.js') }}"></script>
      <script src="<{{ asset ('/panelfiles/assets/js/main.js') }}"></script>
      <script src="<{{ asset ('/panelfiles/assets/js/pages/allcp_forms-elements.js') }}"></script>
      <script src="<{{ asset ('/panelfiles/assets/js/demo/widgets_sidebar.js') }}"></script>

      <!-- -------------- Page JS -------------- -->
      <script src="<{{ asset ('/panelfiles/assets/js/demo/charts/highcharts.js') }}"></script>
      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach
