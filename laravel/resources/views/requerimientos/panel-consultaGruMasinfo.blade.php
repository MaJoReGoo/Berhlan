<?php

use App\Models\Requerimientos\PanelGrupos;
use App\Models\Requerimientos\PanelSolicitudes;
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
      <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/skin/default_skin/css/theme.css') }}">

      <!-- -------------- CSS - allcp forms -------------- -->
      <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.css">

      <!-- -------------- Plugins -------------- -->
      <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css') }}">

      <!-- -------------- Favicon -------------- -->
      <link rel="shortcut icon" href="{{ asset ('/panelfiles/assets/img/favicon.ico') }}">

      <!-- Editor -->
      <script type="text/javascript" src="{{ asset ('/panelfiles/ckeditor/ckeditor.js') }}"></script>
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
                  <a href="{{ asset ('/panel/requerimientos/consultagru/formulario/') }}<?=$DatosSolicitud[0]->grupo?>" title="Requerimientos > Consulta parametrizada">
                    <font color="#34495e">
                      Requerimientos > Consulta parametrizada >
                    </font>
                    <font color="#b4c056">
                      Más información
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="{{ asset ('/panel/requerimientos/consultagru/formulario/') }}<?=$DatosSolicitud[0]->grupo?>" class="btn btn-primary btn-sm ml10" title="Requerimientos > Consulta parametrizada">
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
                        <tr style="background-color:#39405a">
                          <th>
                            Requerimiento
                            <?=$DatosSolicitud[0]->num_solicitud?>
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
                                Estado:
                              </th>
                              <td style="text-align:left">
                                <?php
                                $estado = $DatosSolicitud[0]->estado;
                                if($estado == 1)
                                  echo "Pendiente de asignaci&oacute;n";
                                else if($estado == 2)
                                  echo "Asignado, en proceso";
                                else if($estado == 3)
                                  echo "Atendido, pendiente encuesta de satisfacci&oacute;n";
                                else if($estado == 4)
                                  echo "Finalizado";
                                ?>
                              </td>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Fecha de realización:
                              </th>
                              <td style="text-align:left">
                                <?=$DatosSolicitud[0]->fecha_solicita?>
                              </td>

                              <th style="text-align:left">
                                Solicitado por:
                              </th>
                              <td style="text-align:left">
                                <?php
                                $empleadosol = PanelEmpleados::getEmpleado($DatosSolicitud[0]->usr_solicita);
                                echo $empleadosol[0]->primer_nombre;
                                echo " ";
                                echo $empleadosol[0]->ot_nombre;
                                echo " ";
                                echo $empleadosol[0]->primer_apellido;
                                echo " ";
                                echo $empleadosol[0]->ot_apellido;
                                ?>
                              </td>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Centro de operación:
                              </th>
                              <td style="text-align:left">
                                <?php
                                $centro = PanelCentrosOp::getCentroOp($DatosSolicitud[0]->centro_solicitud);
                                echo $centro[0]->descripcion;
                                ?>
                              </td>

                              <th style="text-align:left">
                                Cargo de solicitud:
                              </th>
                              <td style="text-align:left">
                                <?php
                                $cargo = PanelCargos::getCargo($DatosSolicitud[0]->cargo_solicitud);
                                echo $cargo[0]->descripcion;
                                ?>
                              </td>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Descripción:
                              </th>
                              <td style="text-align:justify;" colspan="3">
                                Cordial saludo, requiero
                                <?=$DatosSolicitud[0]->descripcion?>
                              </td>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Archivo adjunto:
                              </th>
                              <td style="text-align:left">
                                <?php
                                $nombrearc = $DatosSolicitud[0]->archivo;
                                if($nombrearc == '')
                                 {
                                  echo "No adjunto";
                                 }
                                else
                                 {
                                  $ext  = explode('.', $nombrearc);
                                  $ext1 = end($ext);

                                  if(($ext1 == 'xlsx') || ($ext1 == 'xls') || ($ext1 == 'XLSX') || ($ext1 == 'XLS') || ($ext1 == 'xlsm') || ($ext1 == 'XLSM'))
                                   {
                                    $fonicono = "28B463";
                                    $icono    = "fa-file-excel-o";
                                   }
                                  else if(($ext1 == 'docx') || ($ext1 == 'doc') || ($ext1 == 'DOCX') || ($ext1 == 'DOC'))
                                   {
                                    $fonicono = "226dbd";
                                    $icono    = "fa-file-word-o";
                                   }
                                  else if(($ext1 == 'pdf') || ($ext1 == 'PDF'))
                                   {
                                    $fonicono = "b90202";
                                    $icono    = "fa-file-pdf-o";
                                   }
                                  else if(($ext1 == 'pptx') || ($ext1 == 'ppt') || ($ext1 == 'PPTX') || ($ext1 == 'PPT'))
                                   {
                                    $fonicono = "ff4e22";
                                    $icono    = "fa-file-powerpoint-o";
                                   }
                                  else if(($ext1 == 'jpg') || ($ext1 == 'png') || ($ext1 == 'gif') || ($ext1 == 'JPG') || ($ext1 == 'PNG') || ($ext1 == 'GIF'))
                                   {
                                    $fonicono = "f4d03f";
                                    $icono    = "fa-file-image-o";
                                   }
                                  else
                                   {
                                    $fonicono = "000000";
                                    $icono    = "fa-file-archive-o";
                                   }
                                  ?>

                                  <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.open('{{ asset ('/archivos/Requerimientos/') }}<?=$DatosSolicitud[0]->archivo?>','_blank')"  title="Descargar">
                                    <i class="fa <?=$icono?> fa-lg" style="color:#<?=$fonicono?>;"></i>
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
                                if($creadopor == 0)
                                 {
                                  echo "No aplica";
                                 }
                                else
                                 {
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
                                if($atendidopor == 0)
                                 {
                                  echo "No aplica";
                                 }
                                else
                                 {
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
                                if($DatosSolicitud[0]->fecha_cierre == NULL)
                                  echo "Pendiente";
                                else
                                  echo $DatosSolicitud[0]->fecha_cierre;
                                ?>
                              </td>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Observaciones de cierre:
                              </th>
                              <td style="text-align:left" colspan="3">
                                <?=$DatosSolicitud[0]->desc_cierre?>
                              </td>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Categoría:
                              </th>
                              <td style="text-align:left">
                                <?php
                                if($DatosSolicitud[0]->categoria == '0')
                                 {
                                  echo "Pendiente";
                                 }
                                else
                                 {
                                  $categ = PanelCategorias::getCategoria($DatosSolicitud[0]->categoria);
                                  echo $categ[0]->descripcion;
                                 }
                                ?>
                              </td>

                              <th style="text-align:left">
                                Tiempo esperado de respuesta:
                              </th>
                              <td style="text-align:left">
                                <?php
                                if($DatosSolicitud[0]->categoria == '0')
                                 {
                                  echo "Pendiente";
                                 }
                                else if($DatosSolicitud[0]->depende_de == "T")
                                 {
                                  echo "Indefinido - Depende de terceros";
                                 }
                                else if($DatosSolicitud[0]->depende_de == "P")
                                 {
                                  echo "Indefinido - Proyecto de duración no establecida";
                                 }
                                else
                                 {
                                  $Prioridad = PanelPriorizaciones::getCriterio($categ[0]->criticidad);
                                  $Valor     = PanelPriorizaciones::getTiempo($DatosSolicitud[0]->grupo, $Prioridad[0]->id_criterio);
                                  ?>
                                  <button type="button" style="text-align:left; cursor:default; outline:none; width:110px; " tabindex="-1" class="btn btn-default light">
                                    <b>
                                      <label for="username" class="field-icon" title="<?=$Prioridad[0]->descripcion?>">
                                        <i class="fa fa-exclamation-triangle fa-lg" style="color:<?=$Prioridad[0]->color?>; text-shadow: 1px 1px 1px #000;"></i>
                                      </label>
                                      &nbsp;&nbsp;
                                      <?php
                                      echo $Valor[0]->tiempo;
                                        echo " día";
                                      if($Valor[0]->tiempo != 1)
                                        echo "s";
                                      ?>
                                    </b>
                                  </button>
                                  <?php
                                 }
                                ?>
                              </td>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Archivo adjunto de cierre:
                              </th>
                              <td style="text-align:left" colspan="3">
                                <?php
                                $nombrearc1 = $DatosSolicitud[0]->archivo_cierre;
                                if($nombrearc1 == '')
                                 {
                                  echo "No adjunto";
                                 }
                                else
                                 {
                                  $ext  = explode('.', $nombrearc1);
                                  $ext1 = end($ext);

                                  if(($ext1 == 'xlsx') || ($ext1 == 'xls') || ($ext1 == 'XLSX') || ($ext1 == 'XLS') || ($ext1 == 'xlsm') || ($ext1 == 'XLSM'))
                                   {
                                    $fonicono = "28B463";
                                    $icono    = "fa-file-excel-o";
                                   }
                                  else if(($ext1 == 'docx') || ($ext1 == 'doc') || ($ext1 == 'DOCX') || ($ext1 == 'DOC'))
                                   {
                                    $fonicono = "226dbd";
                                    $icono    = "fa-file-word-o";
                                   }
                                  else if(($ext1 == 'pdf') || ($ext1 == 'PDF'))
                                   {
                                    $fonicono = "b90202";
                                    $icono    = "fa-file-pdf-o";
                                   }
                                  else if(($ext1 == 'pptx') || ($ext1 == 'ppt') || ($ext1 == 'PPTX') || ($ext1 == 'PPT'))
                                   {
                                    $fonicono = "ff4e22";
                                    $icono    = "fa-file-powerpoint-o";
                                   }
                                  else if(($ext1 == 'jpg') || ($ext1 == 'png') || ($ext1 == 'gif') || ($ext1 == 'JPG') || ($ext1 == 'PNG') || ($ext1 == 'GIF'))
                                   {
                                    $fonicono = "f4d03f";
                                    $icono    = "fa-file-image-o";
                                   }
                                  else
                                   {
                                    $fonicono = "000000";
                                    $icono    = "fa-file-archive-o";
                                   }
                                  ?>

                                  <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.open('{{ asset ('/archivos/Requerimientos/') }}<?=$DatosSolicitud[0]->archivo_cierre?>','_blank')" title="Descargar">
                                    <i class="fa <?=$icono?> fa-lg" style="color:#<?=$fonicono?>;"></i>
                                  </button>
                                  <?php
                                 }
                                ?>
                              </td>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Resultado encuesta de satisfacción:
                              </th>
                              <td style="text-align:left">
                                <?php
                                $calificacion = $DatosSolicitud[0]->calificacion;

                                if($calificacion == '')
                                  echo "Pendiente";
                                else if($calificacion == 'M')
                                  echo "Muy satisfecho";
                                else if($calificacion == 'S')
                                  echo "Satisfecho";
                                else if($calificacion == 'I')
                                  echo "Insatisfecho";
                                ?>
                              </td>

                              <th style="text-align:left">
                                Fecha de encuesta:
                              </th>
                              <td style="text-align:left">
                                <?php
                                if($DatosSolicitud[0]->fecha_calificacion == NULL)
                                  echo "Pendiente";
                                else
                                  echo $DatosSolicitud[0]->fecha_calificacion;
                                ?>
                              </td>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Observaciones encuesta de satisfacción:
                              </th>
                              <td style="text-align:justify;" colspan="3">
                                <?=$DatosSolicitud[0]->des_calificacion?>
                              </td>
                            </tr>

                            <?php
                            if(($DatosSolicitud[0]->reintegro == 1) || ($DatosSolicitud[0]->reintegro == 2))
                             {
                              echo "<tr style=\"background-color: #F8F8F8; color:#000000\">";
                                echo "<th style=\"text-align:left\">";
                                  echo "Reintegro informado por:";
                                echo "</th>";

                                echo "<td style=\"text-align:left\">";
                                  if($DatosSolicitud[0]->reintegro == 1)
                                   {
                                    echo "Pendiente por reintegro";
                                   }
                                  else
                                   {
                                    $reint = PanelEmpleados::getEmpleado($DatosSolicitud[0]->usr_reintegro);
                                    echo $reint[0]->primer_nombre;
                                    echo " ";
                                    echo $reint[0]->ot_nombre;
                                    echo " ";
                                    echo $reint[0]->primer_apellido;
                                    echo " ";
                                    echo $reint[0]->ot_apellido;
                                    echo "<br>";
                                    echo $DatosSolicitud[0]->fecha_reintegro;
                                   }
                                echo "</td>";

                                echo "<th style=\"text-align:left\">";
                                  echo "Observaciones de reintegro:";
                                echo "</th>";

                                echo "<td style=\"text-align:justify\">";
                                  if($DatosSolicitud[0]->reintegro == 2)
                                    echo $DatosSolicitud[0]->obs_reintegro;
                                echo "</td>";
                              echo "</tr>";
                             }
                            ?>
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
                    {!! Form::open(array('action' => 'Requerimientos\MisRequerimientosPanelController@InformacionAgregarDB', 'class' => 'form', 'id'=>'form-wizard')) !!}
                      {!! Form::hidden('solicitud', $DatosSolicitud[0]->num_solicitud) !!}
                      {!! Form::hidden('ruta', '/panel/requerimientos/consultagru/masinfo/') !!}
                      <table id="message-table" class="table allcp-form theme-warning br-t">
                        <thead>
                          <tr>
                            <th style="background-color:#67d3e0; color:#34495e; text-align:left;" colspan="2">
                              Agregar información adicional
                            </th>
                          </tr>

                          <tr>
                            <td>
                              <font color="#34495e">
                                Cordial saludo,
                              </font>
                              <label class="field prepend-icon">
                                {!! Form::textarea('descripcion', '', array('cols' => 4, 'required', 'id'=>'descripcion', 'class'=>'gui-input', 'style'=>'height: 65px;',
                                    'placeholder'=>'* Ingrese aquí la información adicional al requerimiento, sea breve y puntual.')) !!}
                                <label for="username" class="field-icon">
                                  <i class="fa fa-reorder"></i>
                                </label>
                              </label>
                            </td>

                            <td>
                              <br>
                              {!! Form::submit('Adicionar información', array('class'=>'button')) !!}
                            </td>
                          </tr>
                        </thead>
                      </table>
                    {!! Form::close() !!}
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
                            <tr >
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
                                  <?=$DatSeg->descripcion?>
                                </td>

                                <td style="text-align:left">
                                  <?=$DatSeg->fecha?>
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
      <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js') }}"></script>
      <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js') }}"></script>

      <!-- -------------- JvectorMap Plugin -------------- -->
      <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js') }}"></script>
      <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js') }}"></script>

      <!-- -------------- HighCharts Plugin -------------- -->
      <script src="{{ asset ('/panelfiles/assets/js/plugins/highcharts/highcharts.js') }}"></script>
      <script src="{{ asset ('/panelfiles/assets/js/plugins/c3charts/d3.min.js') }}"></script>
      <script src="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.js') }}"></script>

      <!-- -------------- Theme Scripts -------------- -->
      <script src="{{ asset ('/panelfiles/assets/js/utility/utility.js') }}"></script>
      <script src="{{ asset ('/panelfiles/assets/js/demo/demo.js') }}"></script>
      <script src="{{ asset ('/panelfiles/assets/js/main.js') }}"></script>
      <script src="{{ asset ('/panelfiles/assets/js/pages/allcp_forms-elements.js') }}"></script>
      <script src="{{ asset ('/panelfiles/assets/js/demo/widgets_sidebar.js') }}"></script>

      <!-- -------------- Page JS -------------- -->
      <script src="{{ asset ('/panelfiles/assets/js/demo/charts/highcharts.js') }}"></script>

      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach
