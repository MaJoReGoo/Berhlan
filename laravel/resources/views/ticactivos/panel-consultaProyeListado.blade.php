<?php
$server ='/Berhlan/public';

use App\Models\TicActivos\PanelTipos;
use App\Models\TicActivos\PanelMarcas;
use App\Models\TicActivos\PanelActivos;
use App\Models\Parametrizacion\PanelEmpleados;
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
        Intranet | Activos TIC | Consulta proyección mantenimientos
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
                  <a href="<?=$server?>/panel/ticactivos/consultasproye" title="Activos TIC > Consulta proyección de mantenimientos">
                    <font color="#34495e">
                      Activos TIC > Consulta proyección de mantenimientos >
                    </font>
                    <font color="#b4c056">
                      Resultado
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/ticactivos/consultasproye" class="btn btn-primary btn-sm ml10" title="Activos TIC > Consulta proyección de mantenimientos">
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
                    Resultado de la consulta - Fecha de corte <?=$fechacorte?>
                  </div>

                  <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                    <thead>
                      <tr style="background-color: #F8F8F8">
                        <th style="text-align:center;">
                          #
                        </th>
                        <th style="text-align:center;">
                          Num.
                        </th>
                        <th style="text-align:center;">
                          Tipo
                        </th>
                        <th style="text-align:center;">
                          Marca y modelo
                        </th>
                        <th style="text-align:center;">
                          Fecha esperada
                        </th>
                        <th style="text-align:center;">
                          Meses entre mtto
                        </th>
                        <th style="text-align:center;">
                          Fecha último evento
                        </th>
                        <th style="text-align:center;">
                          Código interno
                        </th>
                        <th style="text-align:center;">
                          Activo fijo
                        </th>
                        <th style="text-align:center;">
                          Compañía
                        </th>
                        <th style="text-align:center;">
                          Colaborador
                        </th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php $u = 1; ?>
                      @foreach($DatosActivos as $DatAct)
                        <?php
                        $acti          = $DatAct->id_activo;
                        $ultfecha      = $DatAct->ultfecha;
                        $Activo        = PanelActivos::Activo($acti);
                        $meses         = $Activo[0]->mes_mtto;
                        $fechaesperada = date('Y-m-d', strtotime($ultfecha."+".$meses." month"));

                        if(strtotime($fechacorte) >= strtotime($fechaesperada))
                         {
                          ?>
                          <tr class="message-unread">
                            <td style="text-align:right;">
                              <font color="#2A2F43">
                                <?php
                                print $u;
                                $u++;
                                ?>
                              </font>
                            </td>

                            <td style="text-align:center;">
                              <font color="#2A2F43">
                                <b>
                                  AC<?=$DatAct->id_activo?>
                                </b>
                              </font>
                            </td>

                            <td style="text-align:center;">
                              <font color="#2A2F43">
                                <?php
                                $Tipo = PanelTipos::getTipo($Activo[0]->tipo);
                                echo $Tipo[0]->descripcion;
                                ?>
                              </font>
                            </td>

                            <td style="text-align:center;">
                              <font color="#2A2F43">
                                <?php
                                $Marca = PanelMarcas::getMarca($Activo[0]->marca);
                                echo $Marca[0]->descripcion;
                                ?>
                              </font>
                            </td>

                            <td style="text-align:center;">
                              <font color="#2A2F43">
                                <?=$fechaesperada?>
                              </font>
                            </td>

                            <td style="text-align:center;">
                              <font color="#2A2F43">
                                <?=$meses?>
                              </font>
                            </td>

                            <td style="text-align:center;">
                              <font color="#2A2F43">
                                <?=substr($DatAct->ultfecha, 0, 10)?>
                              </font>
                            </td>

                            <td style="text-align:center;">
                              <font color="#2A2F43">
                                <?=$Activo[0]->cod_interno?>
                              </font>
                            </td>

                            <td style="text-align:center;">
                              <font color="#2A2F43">
                                <?=$Activo[0]->activofijo?>
                              </font>
                            </td>

                            <td style="text-align:center;">
                              <font color="#2A2F43">
                                <?php
                                $Empresa = PanelEmpresas::getEmpresa($Activo[0]->empresa);
                                echo $Empresa[0]->nombre;
                                ?>
                              </font>
                            </td>

                            <td style="text-align:center;">
                              <font color="#2A2F43">
                                <?php
                                $empleado = PanelEmpleados::getEmpleado($Activo[0]->empleado);
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
                                echo " - ";
                                $Area = PanelAreas::getArea($cargo[0]->area);
                                echo $Area[0]->descripcion;
                                echo "<br>";
                                $Centro = PanelCentrosOp::getCentroOp($empleado[0]->centro_op);
                                echo $Centro[0]->descripcion;
                                echo "<br>";
                                $Empres = PanelEmpresas::getEmpresa($Area[0]->empresa);
                                echo $Empres[0]->nombre;
                                ?>
                              </font>
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