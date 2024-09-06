<?php
$server = '/Berhlan/public';

use App\Models\Requerimientos\PanelGrupos;
use App\Models\Requerimientos\PanelCategorias;
use App\Models\Requerimientos\PanelPriorizaciones;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Parametrizacion\PanelCargos;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Requerimientos | Consulta
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
                  <?php
                  $nomgrupo = PanelGrupos::getGrupo($Grupo);
                  ?>
                  <a href="<?=$server?>/panel/requerimientos/consultagru/formulario/<?=$Grupo?>" title="Requerimientos > Consulta parametrizada > Grupo <?=$nomgrupo[0]->descripcion?>">
                    <font color="#34495e">
                      Requerimientos > Consulta parametrizada > Grupo <?=$nomgrupo[0]->descripcion?> >
                    </font>
                    <font color="#b4c056">
                      Listado
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/requerimientos/consultagru/formulario/<?=$Grupo?>" class="btn btn-primary btn-sm ml10" title="Requerimientos > Consulta parametrizada > Grupo <?=$nomgrupo[0]->descripcion?>">
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
                            Requerimientos del grupo <?=$nomgrupo[0]->descripcion?> con los parámetros dados
                          </font>
                        </th>
                      </tr>
                    </thead>

                      <tr>
                        <td>
                          <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                            <thead>
                              <tr style="background-color: #F8F8F8;">
                                <th style="text-align:left">
                                  #
                                </th>
                                <th style="text-align:center">
                                  Crit.
                                </th>
                                <th style="text-align:right">
                                  Req.
                                </th>
                                <th style="text-align: center">
                                  Estado
                                </th>
                                <th style="text-align: center">
                                  Fecha
                                </th>
                                <th style="text-align: center">
                                  Solicitado por
                                </th>
                                <th style="text-align: center">
                                  Solicitud
                                </th>
                                <th style="text-align: center">
                                  Categoría
                                </th>
                                <th style="text-align: center">
                                  Fecha de cierre
                                </th>
                                <th style="text-align: center">
                                  Obs. de cierre
                                </th>
                                <th style="text-align:right">
                                  Apreciación
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
                              @foreach($Datosrequerimientos as $DatSol)
                                <tr class="message-unread">
                                  <td style="text-align:left">
                                    <?php
                                    print $u;
                                    $u++;
                                    ?>
                                  </td>

                                  <td style="text-align:center">
                                    <button type="button" style="text-align:center; background-color:#FAFAFA; cursor:default; outline:none;" tabindex="-1" class="btn btn-default light">
                                      <?php
                                      if($DatSol->categoria != '0')
                                       {
                                        $nombrec    = PanelCategorias::getCategoria($DatSol->categoria);
                                        $Criticidad = PanelPriorizaciones::getCriterio($nombrec[0]->criticidad);

                                        if($DatSol->depende_de == "T")
                                         {
                                          ?>
                                          <label for="username" class="field-icon" title="Depende de terceros">
                                            <i class="fa fa-cog fa-lg" style="color:#9A5B2F; text-shadow: 2px 2px 2px #000;"></i>
                                          </label>
                                          <?php
                                         }
                                        else if($DatSol->depende_de == "P")
                                         {
                                          ?>
                                          <label for="username" class="field-icon" title="Proyecto">
                                            <i class="fa fa-cog fa-lg" style="color:#E8DAEF; text-shadow: 2px 2px 2px #000;"></i>
                                          </label>
                                          <?php
                                         }
                                        else if($DatSol->depende_de == "")
                                         {
                                          ?>
                                          <label for="username" class="field-icon" title="<?=$Criticidad[0]->descripcion?>" title="<?=$Criticidad[0]->descripcion?>">
                                            <i class="fa fa-exclamation-triangle fa-lg" style="color:<?=$Criticidad[0]->color?>; text-shadow: 1px 1px 1px #000;"></i>
                                          </label>
                                          <?php
                                         }
                                       }
                                      else
                                       {
                                        ?>
                                        <b>
                                          Pen.
                                        </b>
                                        <?php
                                       }
                                      ?>
                                    </button>
                                  </td>

                                  <td style="text-align:right;">
                                    <b>
                                      <?=$DatSol->num_solicitud?>
                                    </b>
                                  </td>

                                  <td style="text-align:center">
                                    <?php
                                    $estado = $DatSol->estado;

            

                                   if($estado == 1)
                                      echo "Pendiente de asignaci&oacute;n";
                                    else if($estado == 2 && $DatSol->notificacion_cierre === null && $DatSol->fecha_propuesta_cierre === null)
                                      echo "Asignado, en proceso";
                                    else if($estado == 3 || ($estado == 2 && $DatSol->notificacion_cierre !== null && $DatSol->fecha_propuesta_cierre !== null ))
                                      echo "Atendido, pendiente encuesta de satisfacci&oacute;n";
                                    else if($estado == 4)
                                      echo "Finalizado";
                                    ?>
                                  </td>

                                  <td style="text-align:center">
                                    <?=$DatSol->fecha_solicita?>
                                  </td>

                                  <td style="text-align:left">
                                    <?php
                                    $empleado = PanelEmpleados::getEmpleado($DatSol->usr_solicita);
                                    echo $empleado[0]->primer_nombre;
                                    echo " ";
                                    echo $empleado[0]->ot_nombre;
                                    echo " ";
                                    echo $empleado[0]->primer_apellido;
                                    echo " ";
                                    echo $empleado[0]->ot_apellido;
                                    echo "<br>";
                                    $centro = PanelCentrosOp::getCentroOp($DatSol->centro_solicitud);
                                    echo $centro[0]->descripcion;
                                    echo "<br>";
                                    $cargo = PanelCargos::getCargo($DatSol->cargo_solicitud);
                                    echo $cargo[0]->descripcion;
                                    ?>
                                  </td>

                                  <td style="text-align:justify" width="280">
                                    <div style="height:100px; width:100%; overflow:auto;">
                                      <font color="#2A2F43">
                                        <?=$DatSol->descripcion?>
                                      </font>
                                    </div>
                                  </td>

                                  <td style="text-align:left">
                                    <?php
                                    if($DatSol->categoria == '0')
                                     {
                                      echo "Pendiente";
                                     }
                                    else
                                     {
                                      $nombrec = PanelCategorias::NombreCategoria($DatSol->categoria);
                                      echo $nombrec[0]->descripcion;
                                     }
                                    ?>
                                  </td>

                                  <td style="text-align:center">
                                    <?php
                                    if($DatSol->fecha_cierre)
                                      echo $DatSol->fecha_cierre;
                                    else
                                      echo "Pendiente";
                                    ?>
                                  </td>

                                  <td style="text-align:justify" width="280">
                                    <div style="height:100px; width:100%; overflow:auto;">
                                      <font color="#2A2F43">
                                        <?=$DatSol->desc_cierre?>
                                      </font>
                                    </div>
                                  </td>


                                  <td style="text-align:center">
                                    <?php
                                    $aprec = $DatSol->calificacion;
                                    if($aprec == "M")
                                      echo "Muy satisfecho";
                                    else if($aprec == "S")
                                      echo "Satisfecho";
                                    else if($aprec == "I")
                                      echo "Insatisfecho";
                                    else
                                      echo "Pendiente";
                                    ?>
                                  </td>

                                  <td style="text-align: center">
                                    <button type="button" class="btn btn-default light" onclick="window.location.href='<?=$server?>/panel/requerimientos/consultagru/masinfo/<?=$DatSol->num_solicitud?>'" title="Más información">
                                      <i class="fa fa-exclamation-circle fa-lg" style="color:#AEBF25;"></i>
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
