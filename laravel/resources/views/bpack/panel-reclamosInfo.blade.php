<?php
$server = '/Berhlan/public';

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
        Intranet | Consulta reclamos y quejas
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
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/allcp/forms/css/forms.css">

      <!-- -------------- Plugins -------------- -->
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

      <!-- -------------- Favicon -------------- -->
      <link rel="shortcut icon" href="<?=$server?>/panelfiles/assets/img/favicon.ico">

      <!-- Editor -->
      <script type="text/javascript" src="<?=$server?>/panelfiles/ckeditor/ckeditor.js"></script>
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
                  <a href="<?=$server?>/panel/bpack/reclamos" title="Bcloud > Consulta reclamos y quejas">
                    <font color="#34495e">
                      Bcloud > Consulta reclamos y quejas >
                    </font>
                    <font color="#b4c056">
                      Mas información
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/bpack/reclamos" class="btn btn-primary btn-sm ml10" title="Bcloud > Consulta reclamos y quejas">
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
                            <?php
                            if($DatosReclamo[0]->tipo_sol == 'Q')
                              echo "Queja";
                            else
                              echo "Reclamo";
                            ?>
                            <?=$DatosReclamo[0]->id_reclamo?>
                          </th>
                        </tr>
                      </thead>

                      <tr>
                        <td>
                          <table id="message-table" class="table allcp-form theme-warning br-t">
                            <tr style="background-color:#d7dbdd; color:#000000">
                              <th style="text-align:left" colspan="4">
                                Reporte
                              </th>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Fecha de solicitud:
                              </th>
                              <td style="text-align:left">
                                <?=$DatosReclamo[0]->fecha_ingreso?>
                              </td>

                              <th style="text-align:left">
                                Reportada por:
                              </th>
                              <td style="text-align:left">
                                <?php
                                $empleado = PanelEmpleados::getEmpleado($DatosReclamo[0]->usr_reclamo);
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
                                ?>
                              </td>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Tipo de solicitud:
                              </th>
                              <td style="text-align:left">
                                <?php
                                if($DatosReclamo[0]->tipo_sol == 'Q')
                                  echo "Queja";
                                else
                                  echo "Reclamo";
                                ?>
                              </td>

                              <th style="text-align:left">
                                Estado:
                              </th>
                              <td style="text-align:left">
                                <?php
                                if($DatosReclamo[0]->estado == 'I')
                                  echo "Pendiente de respuesta por Bpack";
                                else if($DatosReclamo[0]->estado == 'R')
                                  echo "Rechazada por Berhlan, pendiente de respuesta por Bpack";
                                else if($DatosReclamo[0]->estado == 'A')
                                  echo "Atendida, pendiente de cierre";
                                else if($DatosReclamo[0]->estado == 'F')
                                  echo "Finalizada";
                                ?>
                              </td>
                            </tr>

                            <tr style="background-color:#d7dbdd; color:#000000">
                              <th style="text-align:left" colspan="4">
                                Producto
                              </th>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Tipo de material:
                              </th>
                              <td style="text-align:left">
                                <?php
                                if($DatosReclamo[0]->material == 'E')
                                  echo "Etiqueta";
                                else
                                  echo "Funda";
                                ?>
                              </td>

                              <th style="text-align:left">
                                Lote del insumo:
                              </th>
                              <td style="text-align:left">
                                <?=$DatosReclamo[0]->lote?>
                              </td>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Ítem:
                              </th>
                              <td style="text-align:left">
                                <?=$DatosReclamo[0]->item?>
                              </td>

                              <th style="text-align:left">
                                Referencia:
                              </th>
                              <td style="text-align:left">
                                <?=$DatosReclamo[0]->referencia?>
                              </td>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Fecha de ingreso a planta:
                              </th>
                              <td style="text-align:left">
                                <?=$DatosReclamo[0]->ingreso?>
                              </td>

                              <th style="text-align:left">
                                Rechazo material:
                              </th>
                              <td style="text-align:left">
                                <?php
                                if($DatosReclamo[0]->rechazo == 'S')
                                  echo "S&iacute;";
                                else
                                  echo "No";
                                ?>
                              </td>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Cantidad que ingresa:
                              </th>
                              <td style="text-align:left">
                                <?=$DatosReclamo[0]->cantidad_ingr?>
                              </td>

                              <th style="text-align:left">
                                Cantidad objeto de reclamo:
                              </th>
                              <td style="text-align:left">
                                <?=$DatosReclamo[0]->cantidad_recl?>
                                &nbsp;&nbsp;
                                (Número de unidades que no cumplen especificación)
                              </td>
                            </tr>

                            <tr style="background-color:#d7dbdd; color:#000000">
                              <th style="text-align:left" colspan="4">
                                Descripción de la no conformidad:
                              </th>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <td style="text-align:left" colspan="4">
                                <?=$DatosReclamo[0]->noconformidad?>
                              </td>
                            </tr>

                            <?php
                            if($DatosReclamo[0]->atributo_aplica == 'S')
                             {
                              ?>
                              <tr style="background-color:#d7dbdd; color:#000000">
                                <th style="text-align:left" colspan="4">
                                  Muestreo atributos
                                </th>
                              </tr>

                              <tr style="background-color: #F8F8F8; color:#000000">
                                <th style="text-align:left">
                                  Número de muestras:
                                </th>
                                <td style="text-align:left">
                                  <?=$DatosReclamo[0]->atributo_muestra?>
                                </td>

                                <th style="text-align:left">
                                  Número de defectuosos:
                                </th>
                                <td style="text-align:left">
                                  <?=$DatosReclamo[0]->atributo_defectuoso?>
                                </td>
                              </tr>

                              <tr style="background-color: #F8F8F8; color:#000000">
                                <th style="text-align:left">
                                  Variable:
                                </th>
                                <td style="text-align:left">
                                  <?=$DatosReclamo[0]->atributo_variable?>
                                </td>

                                <th style="text-align:left">
                                  Estado de la calidad:
                                </th>
                                <td style="text-align:left">
                                  <?php
                                  if($DatosReclamo[0]->atributo_estado == "D")
                                    echo "Derogado";
                                  else
                                    echo "Rechazado";
                                  ?>
                                </td>
                              </tr>
                              <?php
                             }

                            if($DatosReclamo[0]->variable_aplica == 'S')
                             {
                              ?>
                              <tr style="background-color:#d7dbdd; color:#000000">
                                <th style="text-align:left" colspan="4">
                                  Muestreo variable
                                </th>
                              </tr>

                              <tr style="background-color: #F8F8F8; color:#000000">
                                <th style="text-align:left">
                                  Número de muestras:
                                </th>
                                <td style="text-align:left">
                                  <?=$DatosReclamo[0]->variable_muestra?>
                                </td>

                                <th style="text-align:left">
                                  Número de defectuosos:
                                </th>
                                <td style="text-align:left">
                                  <?=$DatosReclamo[0]->variable_defectuoso?>
                                </td>
                              </tr>

                              <tr style="background-color: #F8F8F8; color:#000000">
                                <th style="text-align:left">
                                  Variable:
                                </th>
                                <td style="text-align:left">
                                  <?=$DatosReclamo[0]->variable_variable?>
                                </td>

                                <th style="text-align:left">
                                  Estado de la calidad:
                                </th>
                                <td style="text-align:left">
                                  <?php
                                  if($DatosReclamo[0]->variable_estado == "D")
                                    echo "Derogado";
                                  else
                                    echo "Rechazado";
                                  ?>
                                </td>
                              </tr>
                              <?php
                             }

                            ?>
                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Registro fotográfico:
                              </th>
                              <td style="text-align:left" colspan="3">
                                <?php
                                if($DatosReclamo[0]->archivo != '')
                                 {
                                  ?>
                                  <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.open('<?=$server?>/archivos/Bpack/Reclamos/<?=$DatosReclamo[0]->archivo?>','_blank')" title="<?=$DatosReclamo[0]->archivo?>">
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
                            </tr>

                            <?php
                            if(($DatosReclamo[0]->estado == 'A') || ($DatosReclamo[0]->estado == 'R') || ($DatosReclamo[0]->estado == 'F'))
                             {
                              ?>
                              <tr style="background-color:#d7dbdd; color:#000000">
                                <th style="text-align:left" colspan="4">
                                  Atención por Bpack
                                </th>
                              </tr>

                              <tr style="background-color: #F8F8F8; color:#000000">
                                <th style="text-align:left">
                                  Usuario que atendió el reclamo:
                                </th>
                                <td style="text-align:left">
                                  <?php
                                  $empleado = PanelEmpleados::getEmpleado($DatosReclamo[0]->usr_atiende);
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
                                  ?>
                                </td>

                                <th style="text-align:left">
                                  Fecha de atención al reclamo:
                                </th>
                                <td style="text-align:left">
                                  <?=$DatosReclamo[0]->fecha_atiende?>
                                </td>
                              </tr>

                              <tr style="background-color: #F8F8F8; color:#000000">
                                <th style="text-align:left">
                                  Fecha en que se recoge el material rechazado:
                                </th>
                                <td style="text-align:left">
                                  <?=$DatosReclamo[0]->fecha_recogida?>
                                </td>

                                <th style="text-align:left">
                                  Fecha ingreso del material rechazado a BPACK:
                                </th>
                                <td style="text-align:left">
                                  <?=$DatosReclamo[0]->fecha_planta?>
                                </td>
                              </tr>

                              <tr style="background-color: #F8F8F8; color:#000000">
                                <th style="text-align:left">
                                  Calidad del envió:
                                </th>
                                <td style="text-align:left">
                                  <?php
                                  if($DatosReclamo[0]->calidad_envio == "B")
                                    echo "Bueno";
                                  else if($DatosReclamo[0]->calidad_envio == "R")
                                    echo "Regular";
                                  else
                                    echo "Malo";
                                  ?>
                                </td>

                                <th style="text-align:left">
                                  Fotografía:
                                </th>
                                <td style="text-align:left">
                                  <?php
                                  if($DatosReclamo[0]->registro_envio != '')
                                   {
                                    ?>
                                    <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.open('<?=$server?>/archivos/Bpack/Reclamos/<?=$DatosReclamo[0]->registro_envio?>','_blank')" title="<?=$DatosReclamo[0]->registro_envio?>">
                                      <i class="fa fa-file-image-o fa-lg" style="color:#b4c056;"></i>
                                    </button>
                                    <?php
                                   }
                                  else
                                   {
                                    echo "No adjunta";
                                   }
                                  ?>
                                </td>
                              </tr>

                              <tr style="background-color: #F8F8F8; color:#000000">
                                <th style="text-align:left">
                                  ¿Se realizó visita?
                                </th>
                                <td style="text-align:left">
                                  <?php
                                  if($DatosReclamo[0]->visita == "S")
                                    echo "Sí";
                                  else
                                    echo "No";
                                  ?>
                                </td>

                                <th style="text-align:left">
                                  Fecha propuesta para implementación plan de acción:
                                </th>
                                <td style="text-align:justify; ">
                                  <?=$DatosReclamo[0]->fecha_implementacion?>
                                </td>
                              </tr>

                              <tr style="background-color: #F8F8F8; color:#000000">
                                <th style="text-align:left">
                                  Causa raíz:
                                </th>
                                <td style="text-align:justify;">
                                  <?=$DatosReclamo[0]->causa?>
                                </td>

                                <th style="text-align:left">
                                  Plan de acción correctivo:
                                </th>
                                <td style="text-align:justify; ">
                                  <?=$DatosReclamo[0]->accion?>
                                </td>
                              </tr>

                              <tr style="background-color: #F8F8F8; color:#000000">
                                <th style="text-align:left">
                                  Recibido en Bpack por
                                </th>
                                <td style="text-align:justify;">
                                  <?=$DatosReclamo[0]->recibido?>
                                </td>

                                <th style="text-align:left">
                                  Disposición del producto:
                                </th>
                                <td style="text-align:justify; ">
                                  <?php
                                  if($DatosReclamo[0]->disposicion == "A")
                                    echo "Acuerdo económico";
                                  else if($DatosReclamo[0]->disposicion == "C")
                                    echo "Nota crédito";
                                  else if($DatosReclamo[0]->disposicion == "N")
                                    echo "No aplica";
                                  else if($DatosReclamo[0]->disposicion == "R")
                                    echo "Reposición mano a mano";
                                  ?>
                                </td>
                              </tr>

                              <tr style="background-color: #F8F8F8; color:#000000">
                                <th style="text-align:left">
                                  Observaciones:
                                </th>
                                <td style="text-align:justify;" colspan="3">
                                  <?=$DatosReclamo[0]->observaciones?>
                                </td>
                              </tr>
                              <?php
                             }

                            if($DatosReclamo[0]->estado == 'R')
                             {
                              ?>
                              <tr style="background-color:#d7dbdd; color:#000000">
                                <th style="text-align:left" colspan="4">
                                  Solicitud de cierre fue rechazada por Berhlan
                                </th>
                              </tr>

                              <tr style="background-color: #F8F8F8; color:#000000">
                                <th style="text-align:left">
                                  Rechazado por:
                                </th>
                                <td style="text-align:left">
                                  <?php
                                  $empleado = PanelEmpleados::getEmpleado($DatosReclamo[0]->usr_cierra);
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
                                  echo $DatosReclamo[0]->fecha_cierre;
                                  ?>
                                </td>

                                <th style="text-align:left">
                                  Motivo:
                                </th>
                                <td style="text-align:justify;">
                                  <?=$DatosReclamo[0]->obs_rechazo?>
                                </td>
                              </tr>
                              <?php
                             }

                            if($DatosReclamo[0]->estado == 'F')
                             {
                              ?>
                              <tr style="background-color:#d7dbdd; color:#000000">
                                <th style="text-align:left" colspan="4">
                                  Cierre por Berhlan
                                </th>
                              </tr>

                              <tr style="background-color: #F8F8F8; color:#000000">
                                <th style="text-align:left">
                                  Usuario que cierra la solicitud:
                                </th>
                                <td style="text-align:left">
                                  <?php
                                  $empleado = PanelEmpleados::getEmpleado($DatosReclamo[0]->usr_cierra);
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
                                  echo $DatosReclamo[0]->fecha_cierre;
                                  ?>
                                </td>

                                <th style="text-align:left">
                                  Fecha de cierre:
                                </th>
                                <td style="text-align:justify;">
                                  <?=$DatosReclamo[0]->fecha_cierre?>
                                </td>
                              </tr>

                              <tr style="background-color: #F8F8F8; color:#000000">
                                <th style="text-align:left">
                                  Sugerencias para mejorar el servicio:
                                </th>
                                <td style="text-align:justify;" colspan="3">
                                  <?=$DatosReclamo[0]->obs_mejoras?>
                                </td>
                              </tr>
                              <?php
                             }
                            ?>
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
      <!-- -------------- /Scripts -------------- -->

    </body>
  </html>
@endforeach