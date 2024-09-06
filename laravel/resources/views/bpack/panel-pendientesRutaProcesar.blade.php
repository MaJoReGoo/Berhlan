<?php
$server = '/Berhlan/public';

use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Bpack\PanelMotivos;
use App\Models\Bpack\PanelSolicitudesAN;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Bcloud | Solicitud pendiente de ruta
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
                  <a href="<?=$server?>/panel/bpack/penruta" title="Bcloud > Solicitudes pendientes de > Solicitudes pendientes de ruta">
                    <font color="#34495e">
                      Bcloud > Solicitudes pendientes de > Solicitudes pendientes de ruta >
                    </font>
                    <font color="#b4c056">
                      Solicitud <?=$DatosSolicitud[0]->id_solicitud?>
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/bpack/penruta" class="btn btn-primary btn-sm ml10" title="Bcloud > Solicitudes pendientes de > Solicitudes pendientes de ruta">
                REGRESAR &nbsp;
                <span class="fa fa-arrow-left"></span>
              </a>
            </div>
          </header>
          <!-- -------------- /Topbar -------------- -->


          <?php
          if($DatosSolicitud[0]->id_nvdesarrollo != 0)  //Si es nuevo desarrollo
           {
            $color  = '#21618c';
            $inicio = "SBM";
            $des    = "Nuevos desarrollos";
            }
          else
           {
            $inicio = "SBA";
            if($DatosSolicitud[0]->tipo == 'AR')
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
                            Solicitud
                            <?php
                            echo $inicio;
                            if($inicio == "SBM")
                              echo $DatosSolicitud[0]->id_nvdesarrollo;
                            else
                              echo $DatosSolicitud[0]->id_actualizacion;
                            ?>
                          </th>
                        </tr>
                      </thead>

                      <tr>
                        <td>
                          <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Cliente:
                              </th>
                              <td style="text-align:left">
                                <?=$DatosSolicitud[0]->cliente?>
                              </td>

                              <th style="text-align:left">
                                Tipo:
                              </th>
                              <td style="text-align:left">
                                <i class="fa fa-dot-circle-o fa-lg" style="color:<?=$color?>;"></i>
                                &nbsp;
                                <?=$des?>
                              </td>
                            </tr>

                            <?php
                            if($inicio == "SBM")  //Si es nuevo desarrollo
                             {
                              echo "<tr style=\"background-color: #F8F8F8; color:#000000\">";
                                echo "<th style=\"text-align:left\">";
                                  echo "Artes:";
                                echo "</td>";
                                echo "<td>";
                                  ?>
                                  <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.open('<?=$server?>/archivos/Bpack/Solicitudes/<?=$DatosSolicitud[0]->artes."?".date('i:s')?>','_blank')" title="<?=$DatosSolicitud[0]->artes?>">
                                    <i class="fa fa-file-image-o fa-lg" style="color:#b4c056;"></i>
                                  </button>
                                  <?php
                                echo "</td>";

                                echo "<th style=\"text-align:left\">";
                                  echo "Formato (proyecciones):";
                                echo "</td>";
                                echo "<td>";
                                  if($DatosSolicitud[0]->formato != '')
                                   {
                                    ?>
                                    <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.open('<?=$server?>/archivos/Bpack/Solicitudes/<?=$DatosSolicitud[0]->formato."?".date('i:s')?>','_blank')" title="<?=$DatosSolicitud[0]->formato?>">
                                      <i class="fa fa-file-image-o fa-lg" style="color:#b4c056;"></i>
                                    </button>
                                    <?php
                                   }
                                  else
                                   {
                                    echo "No adjunto";
                                   }
                                echo "</td>";
                              echo "</tr>";
                             }
                            ?>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Solicitado por:
                              </th>
                              <td style="text-align:left" nowrap>
                                <?php
                                $empleado = PanelEmpleados::getEmpleado($DatosSolicitud[0]->usr_crea);
                                echo $empleado[0]->identificacion;
                                echo " - ";
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
                                echo " (";
                                echo $DatosSolicitud[0]->fecha_crea;
                                echo ")";
                                ?>
                              </td>

                              <th style="text-align:left">
                                Observaciones:
                              </th>
                              <td style="text-align:justify;">
                                <?=$DatosSolicitud[0]->observaciones?>
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
                        <tr style="background-color:#67d3e0">
                          <th style="color:black; text-align:left;">
                            Rechazar solicitud
                            <?php
                            echo $inicio;
                            if($inicio == "SBM")
                              echo $DatosSolicitud[0]->id_nvdesarrollo;
                            else
                              echo $DatosSolicitud[0]->id_actualizacion;
                            ?>
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>
                            <div class="allcp-form">
                              {!! Form::open(array('action' => 'Bpack\RutasPanelController@RechazarDB', 'class' => 'form', 'id'=>'form-wizard', 'name' => 'frmenvio')) !!}
                                {!! Form::hidden('solicitud', $DatosSolicitud[0]->id_solicitud) !!}
                                <div class="row">
                                  <div class="col-md-3">
                                    <label style="color:#34495e;">
                                      <b>
                                        Motivo de rechazo
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="motivo" id="motivo" required style="height: 60px;">
                                        <option value="">
                                          *  Motivo de rechazo
                                        </option>
                                        <?php
                                        $Motivos = PanelMotivos::getMotivosActivos();
                                        ?>
                                        @foreach($Motivos as $DatMov)
                                          <option value="<?=$DatMov->id_motivo?>">
                                            <?=$DatMov->descripcion?>
                                          </option>
                                        @endforeach
                                      </select>
                                      <i class="arrow"></i>
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Observaciones
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::textarea('observaciones', '', array('', 'id'=>'observaciones', 'class'=>'gui-input', 'style'=>'height: 60px;', 'placeholder'=>'Observaciones.')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-reorder"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-2">
                                    <br><br>
                                    {!! Form::submit('Rechazar', array('class'=>'button')) !!}
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

              <br>

              <div class="panel m4">
                <!-- -------------- Message Body -------------- -->
                <div class="nano-content">
                  <div class="table-responsive">
                    <table id="message-table" class="table allcp-form theme-warning br-t">
                      <tbody>
                        <tr style="background-color:#67d3e0">
                          <th style="color:black; text-align:left;">
                            #
                          </th>
                          <th style="color:black; text-align:left;">
                            Ítem - Referencia
                          </th>

                          <?php
                          if($inicio == "SBA")
                           {
                            echo "<th style=\"color:black; text-align:center;\">";
                              echo "Arte";
                            echo "</th>";
                           }
                          ?>

                          <th style="color:black; text-align:center;">
                            Versión
                          </th>
                          <th style="color:black; text-align:center;">
                            Ruta
                          </th>
                          <th style="color:black; text-align:center;">
                            Uso
                          </th>
                        </tr>

                        {!! Form::open(array('action' => 'Bpack\RutasPanelController@PendientesRutaProcesarDB', 'class' => 'form', 'id'=>'form-wizard', 'name' => 'frmenvio')) !!}
                          {!! Form::hidden('solicitud', $DatosSolicitud[0]->id_solicitud) !!}
                          <div class="allcp-form">
                            <?php
                            $DetSolicitud = PanelSolicitudesAN::DetSolicitudan($DatosSolicitud[0]->id_solicitud);
                            $b = 1;
                            ?>
                            @foreach($DetSolicitud as $DatSol)
                              <tr>
                                <th>
                                  <label style="color:black;">
                                    <b><?php
                                    echo $b;
                                    $b++;
                                    ?></b>
                                  </label>
                                </th>

                                <td>
                                  <label style="color:#34495e;">
                                  <?php
                                  if($DatSol->item != 0)
                                    echo $DatSol->item." - ";
                                  echo $DatSol->referencia;
                                  ?>
                                  </label>
                                </td>

                                <?php
                                if($inicio == "SBA")
                                 {
                                  ?>
                                  <td>
                                    <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.open('<?=$server?>/archivos/Bpack/Solicitudes/<?=$DatSol->ruta_arte."?".date('i:s')?>','_blank')" title="<?=$DatSol->ruta_arte?>">
                                      <i class="fa fa-file-image-o fa-lg" style="color:#b4c056;"></i>
                                    </button>
                                  </td>
                                  <?php
                                 }
                                ?>

                                <td align="center">
                                  <label style="color:#34495e;">
                                    <?=$DatSol->version?>
                                  </label>
                                </td>

                                <td align="center" nowrap width="360">
                                  <label style="color:#34495e;">
                                    <label class="option block">
                                      <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary btn-lg active" onclick="COLOR('V','<?=$DatSol->registro?>')">
                                           <i class="fa fa-check fa-sm" id="tipof_<?=$DatSol->registro?>" style="color:green;"> Flexografía</i>
                                          <input type="radio" name="ruta_<?=$DatSol->registro?>" value="F" autocomplete="off" checked>
                                        </label>
                                        <label class="btn btn-secondary" onclick="COLOR('G','<?=$DatSol->registro?>')">
                                          <i class="fa fa-times fa-sm" id="tipod_<?=$DatSol->registro?>" style="color:grey;"> Digital</i>
                                          <input type="radio" name="ruta_<?=$DatSol->registro?>" value="D" autocomplete="off">
                                        </label>
                                      </div>
                                    </label>
                                  </label>
                                </td>

                                <td align="center">
                                  <label class="field select">
                                    <select name="uso_<?=$DatSol->registro?>" id="uso_<?=$DatSol->registro?>" required>
                                      <option value="0">
                                        Uso
                                      </option>
                                      <?php
                                      for($u = 0; $u < 101; $u++)
                                       {
                                        echo "<option value=\"$u\">";
                                          echo $u."%";
                                        echo "</option>";
                                       }
                                      ?>
                                    </select>
                                    <i class="arrow"></i>
                                  </label>
                                </td>
                              </tr>
                            @endforeach

                            <tr>
                              <td colspan="2">
                                <label style="color: #34495e">
                                  <b>
                                    Observaciones
                                  </b>
                                </label>
                                <label class="field prepend-icon">
                                  {!! Form::textarea('observaciones', '', array('', 'id'=>'observaciones', 'class'=>'gui-input', 'style'=>'height: 50px;', 'placeholder'=>'Observaciones.')) !!}
                                  <label for="username" class="field-icon">
                                    <i class="fa fa-reorder"></i>
                                  </label>
                                </label>
                              </td>

                              <td colspan="4">
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                {!! Form::submit('Guardar', array('class'=>'button')) !!}
                              </td>
                            </tr>
                          </div>
                        {!! Form::close() !!}
                      </tbody>
                    </table>

                    <script language="javascript" type="text/javascript">
                    function COLOR(id, pos)
                     {
                      icono1 = document.getElementById('tipof_'+pos);
                      icono2 = document.getElementById('tipod_'+pos);

                      if(id == "V")
                       {
                        icono1.style.color = 'green';
                        icono1.className   = 'fa fa-check fa-1';

                        icono2.style.color = 'grey';
                        icono2.className   = 'fa fa-times fa-1';
                       }
                      else
                       {
                        icono1.style.color = 'grey';
                        icono1.className   = 'fa fa-times fa-1';

                        icono2.style.color = 'green';
                        icono2.className   = 'fa fa-check fa-1';
                       }
                     }
                    </script>
                  </div>
                </div>
              </div>

              <br>

              <table id="message-table" class="table allcp-form theme-warning br-t" border="1">
                <tr>
                  <td align="center">
                    <i class="fa fa-1x" style="color:#2A2F43;"><b>1</b></i>
                    <br>
                    <i class="fa fa-1x" style="color:#2A2F43;"><b>Inicio</b></i>
                  </td>
                  <td align="center" style="background-color:#67d3e0">
                    <i class="fa fa-1x" style="color:#2A2F43;"><b>2. Planeación</b></i>
                    <br>
                    <i class="fa fa-1x" style="color:#2A2F43;">Pendiente de ruta</i>
                  </td>
                  <td align="center">
                    <i class="fa fa-1x" style="color:#2A2F43;"><b>3. Preprensa</b></i>
                    <br>
                    <i class="fa fa-1x" style="color:#2A2F43;">Pendiente de aprobación</i>
                  </td>
                  <td align="center">
                    <i class="fa fa-1x" style="color:#2A2F43;"><b>4. Publicidad</b></i>
                    <br>
                    <i class="fa fa-1x" style="color:#2A2F43;">Pendiente de aprobación</i>
                  </td>
                  <td align="center">
                    <i class="fa fa-1x" style="color:#2A2F43;"><b>5. Preprensa</b></i>
                    <br>
                    <i class="fa fa-1x" style="color:#2A2F43;">Pendiente de prueba de contrato</i>
                  </td>
                  <td align="center">
                    <i class="fa fa-1x" style="color:#2A2F43;"><b>6. Publicidad</b></i>
                    <br>
                    <i class="fa fa-1x" style="color:#2A2F43;">Pendiente de aprobación prueba de contrato</i>
                  </td>
                  <td align="center">
                    <i class="fa fa-1x" style="color:#2A2F43;"><b>7</b></i>
                    <br>
                    <i class="fa fa-1x" style="color:#2A2F43;"><b>Fin</b></i>
                  </td>
                </tr>
              </table>

              <br>

              <div class="panel m3">
                <!-- -------------- Message Body -------------- -->
                <div class="nano-content">
                  <div class="table-responsive">
                    <table id="message-table" class="table allcp-form theme-warning br-t">
                      <thead>
                        <tr style="background-color:#39405a">
                          <th>
                            Detalle movimientos
                            <?php
                            echo $inicio;
                            if($inicio == "SBM")
                              echo $DatosSolicitud[0]->id_nvdesarrollo;
                            else
                              echo $DatosSolicitud[0]->id_actualizacion;
                            ?>
                          </th>
                        </tr>
                      </thead>

                      <tr>
                        <td>
                          <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                            <thead>
                              <tr style="background-color: #F8F8F8; color:#000000">
                                <th style="text-align:left">
                                  #
                                </th>
                                <th style="text-align:center;">
                                  Estado
                                </th>
                                <th style="text-align:center;">
                                  Observaciones
                                </th>
                                <th style="text-align: center">
                                  Fecha
                                </th>
                                <th style="text-align:center;">
                                  Motivo de rechazo
                                </th>
                              </tr>
                            </thead>

                            <tbody>
                              <?php
                              $DatosMov = PanelSolicitudesAN::MovSolicitudan($DatosSolicitud[0]->id_solicitud);
                              $u = 1;
                              ?>
                              @foreach($DatosMov as $DatMov)
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
                                      <?php
                                      $estadomov = PanelSolicitudesAN::DesEstado($DatMov->estado);
                                      echo $estadomov[0]->descripcion;
                                      ?>
                                    </font>
                                  </td>

                                  <td style="text-align:justify;">
                                    <font color="#2A2F43">
                                      <?=$DatMov->observaciones?>
                                    </font>
                                  </td>

                                  <td style="text-align:center;" nowrap>
                                    <font color="#2A2F43">
                                      <?php
                                      echo $DatMov->fecha;
                                      echo "<br>";
                                      $empleado = PanelEmpleados::getEmpleado($DatMov->usuario);
                                      echo $empleado[0]->primer_nombre;
                                      echo " ";
                                      echo $empleado[0]->ot_nombre;
                                      echo " ";
                                      echo $empleado[0]->primer_apellido;
                                      echo " ";
                                      echo $empleado[0]->ot_apellido;
                                      echo "<br>(";
                                      echo $empleado[0]->identificacion;
                                      echo ") ";
                                      $cargo = PanelCargos::getCargo($empleado[0]->cargo);
                                      echo $cargo[0]->descripcion;
                                      ?>
                                    </font>
                                  </td>

                                  <td style="text-align:center;" nowrap>
                                    <font color="#2A2F43">
                                      <?php
                                      if($DatMov->motivo_rechazo != 0)
                                       {
                                        $desmotivo = PanelMotivos::getMotivo($DatMov->motivo_rechazo);
                                        echo $desmotivo[0]->descripcion;
                                       }
                                      ?>
                                    </font>
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

      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach