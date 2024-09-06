<?php
$server = '/Berhlan/public';

use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Bpack\PanelMotivos;
use App\Models\Bpack\PanelSolicitudesAN;
use App\Models\Bpack\PanelItemEtiquetas;
?>

@foreach($DatosUsuario as $DatLog)
<!DOCTYPE html>
<html>

<head>
  <!-- -------------- Meta and Title -------------- -->
  <meta charset="utf-8">
  <title>
    Intranet | Bcloud | Solicitud pendiente de corrección
  </title>
  <meta name="keywords" content="panel, cms, usuarios, servicio" />
  <meta name="description" content="Intranet para grupo Berhlan">
  <meta name="author" content="USUARIO">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- -------------- Fonts -------------- -->
  <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
  <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

  <!-- -------------- CSS - theme -------------- -->
  <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/skin/default_skin/css/theme.css">

  <!-- -------------- CSS - allcp forms -------------- -->
  <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/allcp/forms/css/forms.min.css">
  <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/allcp/forms/css/forms.css">

  <!-- -------------- Plugins -------------- -->
  <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

  <!-- -------------- Favicon -------------- -->
  <link rel="shortcut icon" href="<?= $server ?>/panelfiles/assets/img/favicon.ico">

  <!-- Editor -->
  <script type="text/javascript" src="<?= $server ?>/panelfiles/ckeditor/ckeditor.js"></script>

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
              <a href="<?= $server ?>/panel/bpack/correcaprueba/0" title="Bcloud > Solicitudes pendientes de > Solicitudes pendientes de corrección por rechazo en aprobación">
                <font color="#34495e">
                  Bcloud > Solicitudes pendientes de > Solicitudes pendientes de corrección por rechazo en aprobación >
                </font>
                <font color="#b4c056">
                  Solicitud <?= $DatosSolicitud[0]->id_solicitud ?>
                </font>
              </a>
            </li>
          </ul>
        </div>

        <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
          <a href="<?= $server ?>/panel/bpack/correcaprueba/0" class="btn btn-primary btn-sm ml10" title="Bcloud > Solicitudes pendientes de > Solicitudes pendientes de corrección por rechazo en aprobación">
            REGRESAR &nbsp;
            <span class="fa fa-arrow-left"></span>
          </a>
        </div>
      </header>
      <!-- -------------- /Topbar -------------- -->


      <?php
      if ($DatosSolicitud[0]->id_nvdesarrollo != 0)  //Si es nuevo desarrollo
      {
        $color  = '#21618c';
        $inicio = "SBM";
        $des    = "Nuevos desarrollos";
      } else {
        $inicio = "SBA";
        if ($DatosSolicitud[0]->tipo == 'AR') {
          $color = 'green';
          $des    = "Actualizaci&oacute;n para reimpresiones";
        } else {
          $color = 'red';
          $des    = "Actualizaci&oacute;n para abastecimiento";
        }
      }
      ?>

      <!-- -------------- Content -------------- -->
      <section id="content" class="table-layout animated fadeIn">
        <div class="chute chute-center pt20">
          <div class="allcp-form">
            {!! Form::open(array('action' => 'Bpack\CorreccionRechazoApruebaPanelController@CorreccionRechazoApruebaProcesarDB', 'class' => 'form', 'id'=>'form-wizard', 'files' => true, 'name' => 'frmenvio')) !!}
            {!! Form::hidden('solicitud', $DatosSolicitud[0]->id_solicitud) !!}
            {!! Form::hidden('soltipo', $inicio) !!}
            <!-- -------------- Column Center -------------- -->
            <div class="panel m3">
              <!-- -------------- Message Body -------------- -->
              <div class="nano-content">
                <div class="table-responsive">
                  <table id="message-table" class="table allcp-form theme-warning br-t">
                    <thead>
                      <tr style="background-color:#67d3e0">
                        <th style="color:black; text-align:left;">
                          Solicitud
                          <?php
                          echo $inicio;
                          if ($inicio == "SBM")
                            echo $DatosSolicitud[0]->id_nvdesarrollo;
                          else
                            echo $DatosSolicitud[0]->id_actualizacion;

                          echo " &nbsp;&nbsp;-&nbsp;&nbsp; ";
                          $estado = PanelSolicitudesAN::DesEstado($DatosSolicitud[0]->estado);
                          echo $estado[0]->descripcion;
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
                              <?= $DatosSolicitud[0]->cliente ?>
                            </td>

                            <th style="text-align:left">
                              Tipo:
                            </th>
                            <td style="text-align:left">
                              <i class="fa fa-dot-circle-o fa-lg" style="color:<?= $color ?>;"></i>
                              &nbsp;
                              <?= $des ?>
                            </td>
                          </tr>

                          <?php
                          if ($inicio == "SBM")  //Si es nuevo desarrollo
                          {
                            echo "<tr style=\"background-color: #F8F8F8; color:#000000\">";
                            echo "<th style=\"text-align:left\">";
                            echo "Artes:";
                            echo "</td>";
                            echo "<td>";
                          ?>
                            <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.open('<?= $server ?>/archivos/Bpack/Solicitudes/<?= $DatosSolicitud[0]->artes . "?" . date('i:s') ?>','_blank')" title="<?= $DatosSolicitud[0]->artes ?>">
                              <i class="fa fa-file-image-o fa-lg" style="color:#b4c056;"></i>
                            </button>
                            <label class="field prepend-icon append-button file">
                              <span class="button">
                                Artes
                              </span>
                              {!! Form::file('fileT1', array('', 'id'=>'fileT1', 'class'=>'gui-file', 'accept'=>'.ai, .jpg, .jpeg, .gif, .png, .pdf, .psd, .rar, .zip',
                              'onChange'=>"document.getElementById('uploaderT1').value = this.value;")) !!}
                              {!! Form::text('uploaderT1', null, array('id'=>'uploaderT1', 'class'=>'gui-input', 'placeholder'=>'* Seleccione el archivo')) !!}
                              <label class="field-icon">
                                <i class="fa fa-cloud-upload"></i>
                              </label>
                            </label>
                            <?php
                            echo "</td>";

                            echo "<th style=\"text-align:left\">";
                            echo "Formato (proyecciones):";
                            echo "</td>";
                            echo "<td>";
                            if ($DatosSolicitud[0]->formato != '') {
                            ?>
                              <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.open('<?= $server ?>/archivos/Bpack/Solicitudes/<?= $DatosSolicitud[0]->formato . "?" . date('i:s') ?>','_blank')" title="<?= $DatosSolicitud[0]->formato ?>">
                                <i class="fa fa-file-image-o fa-lg" style="color:#b4c056;"></i>
                              </button>
                            <?php
                            } else {
                              echo "No adjunto";
                            }
                            ?>
                            <label class="field prepend-icon append-button file">
                              <span class="button">
                                Formato
                              </span>
                              {!! Form::file('fileT2', array('', 'id'=>'fileT2', 'class'=>'gui-file', 'accept'=>'.ai, .jpg, .jpeg, .gif, .png, .pdf, .psd, .rar, .zip',
                              'onChange'=>"document.getElementById('uploaderT2').value = this.value;")) !!}
                              {!! Form::text('uploaderT2', null, array('id'=>'uploaderT2', 'class'=>'gui-input', 'placeholder'=>'Seleccione el archivo')) !!}
                              <label class="field-icon">
                                <i class="fa fa-cloud-upload"></i>
                              </label>
                            </label>
                          <?php
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
                              <?= $DatosSolicitud[0]->observaciones ?>
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
                    <tbody>
                      <tr style="background-color:#67d3e0">
                        <th style="color:black; text-align:left;">
                          #
                        </th>
                        <th style="color:black; text-align:left;">
                          Ítem - Referencia
                        </th>
                        <?php
                        if ($inicio == "SBA") {
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
                          Motivo de rechazo
                        </th>
                        <th style="color:black; text-align:center;">
                          Sherpa digital
                        </th>
                        <?php
                        if ($inicio == "SBA") {
                          echo "<th style=\"color:black; text-align:center;\">";
                          echo "P.C. física existente";
                          echo "</th>";
                        }
                        ?>
                      </tr>

                      <?php
                      $DetSolicitud = PanelSolicitudesAN::DetSolicitudan($DatosSolicitud[0]->id_solicitud);
                      $b = 1;
                      ?>
                      @foreach($DetSolicitud as $DatSol)
                      {!! Form::hidden('aprobado_'.$DatSol->registro, $DatSol->aprobado) !!}
                      <tr>
                        <th width="40">
                          <label style="color:black;">
                            <b>
                              <?php
                              echo $b;
                              $b++;
                              $reg = $DatSol->registro;
                              ?>
                            </b>
                          </label>
                        </th>

                        <td>
                          <?php
                          if ($DatSol->aprobado == "N") {
                            if (($inicio == "SBA") || ($DatSol->item != 0)) {
                              $DatosItem = PanelItemEtiquetas::Items();
                          ?>
                              <label class="field select">
                                <select name="item_<?= $reg ?>" id="item_<?= $reg ?>">
                                  @foreach($DatosItem as $DatIte)
                                  <option value="<?= $DatIte->f120_id ?>" <?php
                                                                          if ($DatSol->item == $DatIte->f120_id)
                                                                            echo " selected ";
                                                                          ?>>
                                    <?= $DatIte->f120_id . ' - ' . $DatIte->f120_notas ?>
                                  </option>
                                  @endforeach
                                </select>
                                <i class="arrow"></i>
                              </label>
                            <?php
                            } else if ($inicio == "SBM")  //Si es nuevo desarrollo
                            {
                            ?>
                              <label class="field prepend-icon">
                                {!! Form::text('referencia_'.$reg, $DatSol->referencia, array('required', 'id'=>'referencia_'.$reg, 'class'=>'gui-input', 'placeholder'=>'Referencia')) !!}
                                <label for="username" class="field-icon">
                                  <i class="fa fa-navicon"></i>
                                </label>
                              </label>
                          <?php
                            }
                          } else {
                            echo "<label style=\"color:#34495e;\">";
                            if ($DatSol->item != 0)
                              echo $DatSol->item . " - ";
                            echo $DatSol->referencia;
                            echo "</label>";
                          }
                          ?>
                        </td>

                        <?php
                        if ($inicio == "SBA") {
                        ?>
                          <td align="center">
                            <table>
                              <tr>
                                <td align="center">
                                  <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.open('<?= $server ?>/archivos/Bpack/Solicitudes/<?= $DatSol->ruta_arte ?>','_blank')" title="<?= $DatSol->ruta_arte ?>">
                                    <i class="fa fa-file-image-o fa-lg" style="color:#b4c056;"></i>
                                  </button>
                                </td>

                                <?php
                                if ($DatSol->aprobado == "N") {
                                  $textarc = "uploader1_" . $reg;
                                ?>
                                  <td align="center">
                                    <label class="field prepend-icon append-button file">
                                      <span class="button">
                                        Arte
                                      </span>
                                      {!! Form::file('file1_'.$reg, array('', 'id'=>'file1_'.$reg, 'class'=>'gui-file', 'accept'=>'.ai, .jpg, .jpeg, .gif, .png, .pdf, .psd, .rar, .zip',
                                      'onChange'=>"document.getElementById('$textarc').value = this.value;")) !!}
                                      {!! Form::text($textarc, null, array('id'=>$textarc, 'class'=>'gui-input', 'placeholder'=>'Seleccione el archivo')) !!}
                                      <label class="field-icon">
                                        <i class="fa fa-cloud-upload"></i>
                                      </label>
                                    </label>
                                  </td>
                                <?php
                                }
                                ?>
                              </tr>
                            </table>
                          </td>
                        <?php
                        }
                        ?>

                        <td align="center" width="80">
                          <?php
                          if ($DatSol->aprobado == "N") {
                          ?>
                            <label class="field select">
                              <select name="version_<?= $reg ?>" id="version_<?= $reg ?>">
                                <option value="<?= $DatSol->version ?>">
                                  <?= $DatSol->version ?>
                                </option>
                                <?php
                                for ($u = 1; $u < 51; $u++) {
                                  echo "<option value=\"$u\">";
                                  echo $u;
                                  echo "</option>";
                                }
                                ?>
                              </select>
                              <i class="arrow"></i>
                            </label>
                          <?php
                          } else {
                            echo "<label style=\"color:#34495e;\">";
                            echo $DatSol->version;
                            echo "</label>";
                          }
                          ?>
                        </td>

                        <td align="center">
                          <label style="color:#34495e;">
                            <?php
                            if ($DatSol->ruta == "F")
                              echo "Flexografía";
                            else
                              echo "Digital";
                            echo " ($DatSol->uso%)";
                            ?>
                          </label>
                        </td>

                        <td align="center">
                          <label style="color:#34495e;">
                            <?php
                            if ($DatSol->aprobado == "S") {
                              echo "No aplica";
                              echo "<br>";
                              echo "<label style=\"color:green;\">";
                              echo "Registro aprobado";
                              echo "</label>";
                            } else {
                              $Rmotivo = PanelMotivos::getMotivo($DatSol->motivo_rechazo);
                              echo $Rmotivo[0]->descripcion;
                            }
                            ?>
                          </label>
                        </td>

                        <td align="center">
                          <?php
                          if ($DatSol->aprobado == "N") {
                            echo "<label style=\"color:#34495e;\">";
                            echo "No aplica";
                            echo "</label>";
                          } else {
                          ?>
                            <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.open('<?= $server ?>/archivos/Bpack/Solicitudes/<?= $DatSol->ruta_sherpa . "?" . date('i:s') ?>','_blank')" title="<?= $DatSol->ruta_sherpa ?>">
                              <i class="fa fa-file-pdf-o fa-lg" style="color:#b90202;"></i>
                            </button>
                          <?php
                          }
                          ?>
                        </td>

                        <?php
                        if ($inicio == "SBA") {
                          echo "<td align=\"center\">";
                          echo "<label style=\"color:#34495e;\">";
                          if ($DatSol->aprobado == "N") {
                            echo "No aplica";
                          } else {
                            if ($DatSol->prueba_fisica == "S")
                              echo "Sí";
                            else
                              echo "No";
                          }
                          echo "</label>";
                          echo "</td>";
                        }
                        ?>
                      </tr>
                      @endforeach

                      <tr>
                        <td colspan="3">
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

                        <td colspan="5" align="left">
                          {!! Form::submit('Guardar', array('class'=>'button')) !!}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            {!! Form::close() !!}
          </div>

          <br>

          <table id="message-table" class="table allcp-form theme-warning br-t" border="1">
            <tr>
              <td align="center">
                <i class="fa fa-1x" style="color:#2A2F43;"><b>1</b></i>
                <br>
                <i class="fa fa-1x" style="color:#2A2F43;"><b>Inicio</b></i>
              </td>
              <td align="center">
                <i class="fa fa-1x" style="color:#2A2F43;"><b>2. Planeación</b></i>
                <br>
                <i class="fa fa-1x" style="color:#2A2F43;">Pendiente de ruta</i>
              </td>
              <td align="center" style="background-color:#67d3e0">
                <i class="fa fa-1x" style="color:#2A2F43;"><b>Publicidad</b></i>
                <br>
                <i class="fa fa-1x" style="color:#2A2F43;">Pendiente de corrección</i>
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
                        if ($inicio == "SBM")
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
                                <?= $DatMov->observaciones ?>
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
                                if ($DatMov->motivo_rechazo != 0) {
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
  <script src="<?= $server ?>/panelfiles/assets/js/jquery/jquery-1.11.3.min.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js"></script>

  <!-- -------------- JvectorMap Plugin -------------- -->
  <script src="<?= $server ?>/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js"></script>

  <!-- -------------- HighCharts Plugin -------------- -->
  <script src="<?= $server ?>/panelfiles/assets/js/plugins/highcharts/highcharts.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/d3.min.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/c3.min.js"></script>

  <!-- -------------- Theme Scripts -------------- -->
  <script src="<?= $server ?>/panelfiles/assets/js/utility/utility.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/demo/demo.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/main.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/pages/allcp_forms-elements.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/demo/widgets_sidebar.js"></script>

  <!-- -------------- Page JS -------------- -->
  <script src="<?= $server ?>/panelfiles/assets/js/demo/charts/highcharts.js"></script>

  <!-- -------------- /Scripts -------------- -->
</body>

</html>
@endforeach