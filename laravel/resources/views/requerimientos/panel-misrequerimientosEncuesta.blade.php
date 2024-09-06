<?php
$server = '/Berhlan/public';

use App\Models\Requerimientos\PanelGrupos;
use App\Models\Requerimientos\PanelSolicitudes;
use App\Models\Requerimientos\PanelCategorias;
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
    Intranet | Mis requerimientos | Encuesta
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
              <a href="<?= $server ?>/panel/menu/4" title="Requerimientos">
                <font color="#34495e">
                  Requerimientos > Mis requerimientos >
                </font>
                <font color="#b4c056">
                  Encuesta
                </font>
              </a>
            </li>
          </ul>
        </div>

        <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
          <a href="<?= $server ?>/panel/menu/4" class="btn btn-primary btn-sm ml10" title="Requerimientos">
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

          <div class="panel m2">
            <!-- -------------- Message Body -------------- -->
            <div class="nano-content">
              <div class="table-responsive">
                <table id="message-table" class="table allcp-form theme-warning br-t">
                  <thead>
                    <tr>
                      <th style="background-color:#67d3e0; color:#34495e; text-align:left;">
                        Antes de continuar, por favor responda la siguiente pregunta:
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr>
                      <td>
                        <div class="allcp-form">
                          {!! Form::open(array('action' => 'Requerimientos\MisRequerimientosPanelController@EncuestaDB', 'class' => 'form', 'id'=>'form-wizard')) !!}
                          {!! Form::hidden('solicitud', $DatosSolicitud[0]->num_solicitud) !!}
                          <div class="row">
                            <div class="col-md-5">
                              <label style="color:#34495e;">
                                El requerimiento
                                <b>
                                  <?= $DatosSolicitud[0]->num_solicitud ?>
                                </b>
                                se encuentra cerrado, ¿Qué tan satisfecho se encuentra con nuestro servicio?
                              </label>
                              <br>
                              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary" onclick="COLOR('M')">
                                  <button type="button" class="btn btn-default light" data-toggle="modal"><i class="fa fa-thumbs-up fa-2x" style="color: #5c940d"></i>&nbsp;
                                    <input type="radio" name="encuesta" value="M" autocomplete="off" style="background-color: #5c940d;">
                                  </button>
                                  <br />
                                  <label style="color:#34495e;" id="M">
                                    Muy satisfecho
                                  </label>
                                </label>
                                <label class="btn btn-secondary btn-lg active" onclick="COLOR('S')">
                                  <button type="button" class="btn btn-default light" data-toggle="modal"><i class="fa fa-hand-o-right fa-2x" style="color: #4682b4"></i>&nbsp;
                                    <input type="radio" name="encuesta" value="S" autocomplete="off" checked>
                                  </button>
                                  <br />
                                  <label style="color:#34495e;" id="S">
                                    Satisfecho
                                  </label>
                                </label>
                                <label class="btn btn-secondary" onclick="COLOR('I')">
                                  <button type="button" class="btn btn-default light" data-toggle="modal"><i class="fa fa-thumbs-down fa-2x" style="color: #f03e3e"></i>&nbsp;
                                    <input type="radio" name="encuesta" value="I" autocomplete="off">
                                  </button>
                                  <br />
                                  <label style="color:#34495e;" id="I">
                                    Insatisfecho
                                  </label>
                                </label>
                              </div>
                            </div>

                            <div class="col-md-5" style="text-align: justify">
                              <label style="color:#34495e;">
                                <b>
                                  Solicitud:
                                </b>
                                <?= $DatosSolicitud[0]->descripcion ?>
                              </label>
                              <br><br>

                              <?php
                              if ($DatosSolicitud[0]->depende_de == 'T') {
                                echo "<label style=\"color:#34495e;\">";
                                echo "<b>";
                                echo "Nota: ";
                                echo "</b>";
                                echo "El tiempo de respuesta del requerimiento dependía de terceros";
                                echo "</label>";
                                echo "<br>";
                              } else if ($DatosSolicitud[0]->depende_de == 'P') {
                                echo "<label style=\"color:#34495e;\">";
                                echo "<b>";
                                echo "Nota: ";
                                echo "</b>";
                                echo "El requerimiento fue catalogado como un proyecto.";
                                echo "</label>";
                                echo "<br>";
                              }
                              ?>

                              <label style="color:#34495e;">

                                <?php
                                $ultimoMensajeCant = PanelSolicitudes::getUltimoComentarioCierreCant($DatosSolicitud[0]->num_solicitud);
                                if ($ultimoMensajeCant != 0) {
                                  $ultimoMensaje = PanelSolicitudes::getUltimoComentarioCierre($DatosSolicitud[0]->num_solicitud);
                                  $Mensaje = $ultimoMensaje[0]->descripcion;
                                } else {
                                  $Mensaje = '';
                                }

                                ?>
                                <b>
                                  Respuesta:
                                </b>
                                <font color="blue">
                                  <?= $Mensaje ?>
                                </font>
                              </label>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-5">
                              <br>
                              <label class="field prepend-icon">
                                {!! Form::textarea('descripcion', '', array('required', 'id'=>'descripcion', 'class'=>'gui-input', 'style'=>'height: 50px;',
                                'placeholder'=>'Justifique su respuesta.')) !!}
                                <label for="username" class="field-icon">
                                  <i class="fa fa-reorder"></i>
                                </label>
                              </label>
                            </div>

                            <div class="col-md-12">
                              <br>
                              {!! Form::submit('Guardar respuesta', array('class'=>'button')) !!}
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

          <script language="javascript" type="text/javascript">
            function COLOR(id) {
              icono1 = document.getElementById('M');
              icono2 = document.getElementById('S');
              icono3 = document.getElementById('I');

              if (id == "M") {
                icono1.style.color = 'green';
                icono1.style.fontWeight = 'bold';
                icono2.style.color = '#34495e';
                icono2.style.fontWeight = '';
                icono3.style.color = '#f03e3e';
                icono3.style.fontWeight = '';
              } else if (id == "S") {
                icono1.style.color = '#green';
                icono1.style.fontWeight = '';
                icono2.style.color = '#34495e';
                icono2.style.fontWeight = 'bold';
                icono3.style.color = '#f03e3e';
                icono3.style.fontWeight = '';
              } else if (id == "I") {
                icono1.style.color = '#green';
                icono1.style.fontWeight = '';
                icono2.style.color = '#34495e';
                icono2.style.fontWeight = '';
                icono3.style.color = '#f03e3e';
                icono3.style.fontWeight = 'bold';
              }
            }
          </script>

          <br>

          <div class="panel m3">
            <!-- -------------- Message Body -------------- -->
            <div class="nano-content">
              <div class="table-responsive">
                <table id="message-table" class="table allcp-form theme-warning br-t">
                  <thead>
                    <tr style="background-color:#39405a">
                      <th>
                        Requerimiento
                        <?= $DatosSolicitud[0]->num_solicitud ?>
                      </th>
                    </tr>
                  </thead>

                  <tr>
                    <td>
                      <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                        <tr style="background-color: #F8F8F8; color:#000000">
                          <th style="text-align:left">
                            Grupo:
                          </th>
                          <td style="text-align:left">
                            <?php
                            $nombreg = PanelGrupos::NombreGrupo($DatosSolicitud[0]->grupo);
                            echo $nombreg[0]->descripcion;
                            ?>
                          </td>

                          <th style="text-align:left">
                            Fecha de realización:
                          </th>
                          <td style="text-align:left">
                            <?= $DatosSolicitud[0]->fecha_solicita ?>
                          </td>
                        </tr>

                        <tr style="background-color: #F8F8F8; color:#000000">
                          <th style="text-align:left">
                            Archivo adjunto:
                          </th>
                          <td style="text-align:left">
                            <?php
                            $nombrearc = $DatosSolicitud[0]->archivo;
                            if ($nombrearc == '') {
                              echo "No adjunto";
                            } else {
                              $ext  = explode('.', $nombrearc);
                              $ext1 = end($ext);

                              if (($ext1 == 'xlsx') || ($ext1 == 'xls') || ($ext1 == 'XLSX') || ($ext1 == 'XLS') || ($ext1 == 'xlsm') || ($ext1 == 'XLSM')) {
                                $fonicono = "28B463";
                                $icono    = "fa-file-excel-o";
                              } else if (($ext1 == 'docx') || ($ext1 == 'doc') || ($ext1 == 'DOCX') || ($ext1 == 'DOC')) {
                                $fonicono = "226dbd";
                                $icono    = "fa-file-word-o";
                              } else if (($ext1 == 'pdf') || ($ext1 == 'PDF')) {
                                $fonicono = "b90202";
                                $icono    = "fa-file-pdf-o";
                              } else if (($ext1 == 'pptx') || ($ext1 == 'ppt') || ($ext1 == 'PPTX') || ($ext1 == 'PPT')) {
                                $fonicono = "ff4e22";
                                $icono    = "fa-file-powerpoint-o";
                              } else if (($ext1 == 'jpg') || ($ext1 == 'png') || ($ext1 == 'gif') || ($ext1 == 'JPG') || ($ext1 == 'PNG') || ($ext1 == 'GIF')) {
                                $fonicono = "f4d03f";
                                $icono    = "fa-file-image-o";
                              } else {
                                $fonicono = "000000";
                                $icono    = "fa-file-archive-o";
                              }
                            ?>

                              <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.open('<?= $server ?>/archivos/Requerimientos/<?= $DatosSolicitud[0]->archivo ?>','_blank')" title="Descargar">
                                <i class="fa <?= $icono ?> fa-lg" style="color:#<?= $fonicono ?>;"></i>
                              </button>
                            <?php
                            }
                            ?>
                          </td>

                          <th style="text-align:left">
                            Creado por:
                          </th>
                          <td style="text-align:left">
                            <?php
                            $creadopor = $DatosSolicitud[0]->creado_por;
                            if ($creadopor == 0) {
                              echo "No aplica";
                            } else {
                              $creado = PanelEmpleados::getEmpleado($creadopor);
                              echo $creado[0]->primer_nombre;
                              echo " ";
                              echo $creado[0]->ot_nombre;
                              echo " ";
                              echo $creado[0]->primer_apellido;
                              echo " ";
                              echo $creado[0]->ot_apellido;
                            }
                            ?>
                          </td>
                        </tr>

                        <tr style="background-color: #F8F8F8; color:#000000">
                          <th style="text-align:left">
                            Asignado / Atendido por:
                          </th>
                          <td style="text-align:left">
                            <?php
                            $atendidopor = $DatosSolicitud[0]->usr_cierre;
                            if ($atendidopor == 0) {
                              echo "No aplica";
                            } else {
                              $atendido = PanelEmpleados::getEmpleado($atendidopor);
                              echo $atendido[0]->primer_nombre;
                              echo " ";
                              echo $atendido[0]->ot_nombre;
                              echo " ";
                              echo $atendido[0]->primer_apellido;
                              echo " ";
                              echo $atendido[0]->ot_apellido;
                            }
                            ?>
                          </td>

                          <th style="text-align:left">
                            Fecha de cierre:
                          </th>
                          <td style="text-align:left">
                            <?php
                            if ($DatosSolicitud[0]->fecha_cierre == NULL)
                              echo "Pendiente";
                            else
                              echo $DatosSolicitud[0]->fecha_cierre;
                            ?>
                          </td>
                        </tr>

                        <tr style="background-color: #F8F8F8; color:#000000">
                          <th style="text-align:left">
                            Categoría:
                          </th>
                          <td style="text-align:left">
                            <?php
                            if ($DatosSolicitud[0]->categoria == '0') {
                              echo "Pendiente";
                            } else {
                              $nombrec = PanelCategorias::NombreCategoria($DatosSolicitud[0]->categoria);
                              echo $nombrec[0]->descripcion;
                            }
                            ?>
                          </td>

                          <th style="text-align:left">
                            Archivo adjunto de cierre:
                          </th>
                          <td style="text-align:left">
                            <?php
                            $nombrearc1 = $DatosSolicitud[0]->archivo_cierre;
                            if ($nombrearc1 == '') {
                              echo "No adjunto";
                            } else {
                              $ext  = explode('.', $nombrearc1);
                              $ext1 = end($ext);

                              if (($ext1 == 'xlsx') || ($ext1 == 'xls') || ($ext1 == 'XLSX') || ($ext1 == 'XLS') || ($ext1 == 'xlsm') || ($ext1 == 'XLSM')) {
                                $fonicono = "28B463";
                                $icono    = "fa-file-excel-o";
                              } else if (($ext1 == 'docx') || ($ext1 == 'doc') || ($ext1 == 'DOCX') || ($ext1 == 'DOC')) {
                                $fonicono = "226dbd";
                                $icono    = "fa-file-word-o";
                              } else if (($ext1 == 'pdf') || ($ext1 == 'PDF')) {
                                $fonicono = "b90202";
                                $icono    = "fa-file-pdf-o";
                              } else if (($ext1 == 'pptx') || ($ext1 == 'ppt') || ($ext1 == 'PPTX') || ($ext1 == 'PPT')) {
                                $fonicono = "ff4e22";
                                $icono    = "fa-file-powerpoint-o";
                              } else if (($ext1 == 'jpg') || ($ext1 == 'png') || ($ext1 == 'gif') || ($ext1 == 'JPG') || ($ext1 == 'PNG') || ($ext1 == 'GIF')) {
                                $fonicono = "f4d03f";
                                $icono    = "fa-file-image-o";
                              } else {
                                $fonicono = "000000";
                                $icono    = "fa-file-archive-o";
                              }
                            ?>

                              <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.open('<?= $server ?>/archivos/Requerimientos/<?= $DatosSolicitud[0]->archivo_cierre ?>','_blank')" title="Descargar">
                                <i class="fa <?= $icono ?> fa-lg" style="color:#<?= $fonicono ?>;"></i>
                              </button>
                            <?php
                            }
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

          <div class="panel m3">
            <!-- -------------- Message Body -------------- -->
            <div class="nano-content">
              <div class="table-responsive">
                <table id="message-table" class="table allcp-form theme-warning br-t">
                  <thead>
                    <tr style="background-color:#39405a">
                      <th>
                        Seguimiento
                      </th>
                    </tr>
                  </thead>

                  <tr>
                    <td>
                      <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                        <tr>
                          <th style="text-align: left; background-color:#FFFFFF; color: black;">
                            #
                          </th>
                          <th style="text-align: left; background-color:#FFFFFF; color: black;">
                            Descripción
                          </th>
                          <th style="text-align: center; background-color:#FFFFFF; color: black;">
                            Fecha y hora
                          </th>
                          <th style="text-align: left; background-color:#FFFFFF; color: black;">
                            Colaborador
                          </th>
                        </tr>

                        <?php
                        $Seguimientos = PanelSolicitudes::getSolicitudes($DatosSolicitud[0]->num_solicitud);
                        $e = 1;
                        ?>
                        @foreach($Seguimientos as $DatSeg)
                        <tr style="background-color: #F8F8F8; color:#000000">
                          <td style="text-align:left">
                            <?php
                            echo $e;
                            $e++;
                            ?>
                          </td>

                          <td style="text-align:left">
                            <?= $DatSeg->descripcion ?>
                          </td>

                          <td style="text-align:left">
                            <?= $DatSeg->fecha ?>
                          </td>

                          <td style="text-align:left">
                            <?php
                            $creado = PanelEmpleados::getEmpleado($DatSeg->usuario);
                            echo $creado[0]->primer_nombre;
                            echo " ";
                            echo $creado[0]->ot_nombre;
                            echo " ";
                            echo $creado[0]->primer_apellido;
                            echo " ";
                            echo $creado[0]->ot_apellido;
                            ?>
                          </td>
                        </tr>
                        @endforeach
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
