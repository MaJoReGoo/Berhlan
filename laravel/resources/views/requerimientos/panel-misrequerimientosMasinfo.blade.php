<?php

use App\Models\Requerimientos\PanelGrupos;
use App\Models\Requerimientos\PanelSolicitudes;
use App\Models\Requerimientos\PanelCategorias;
use App\Models\Requerimientos\PanelPriorizaciones;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelNotificaciones;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    @include('includes-panel/C_util')
    <?php
    $O_Util = new Util();
    ?>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Mis requerimientos
        </title>
        <meta name="keywords" content="panel, cms, usuarios, servicio" />
        <meta name="description" content="Intranet para grupo Berhlan">
        <meta name="author" content="USUARIO">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- -------------- Fonts -------------- -->
        <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
        <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic'
            rel='stylesheet' type='text/css'>

        <!-- -------------- CSS - theme -------------- -->
        <link rel="stylesheet" type="text/css"
            href="{{ asset('/panelfiles/assets/skin/default_skin/css/theme.css') }}">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/panelfiles/assets/allcp/forms/css/forms.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/panelfiles/assets/allcp/forms/css/forms.css') }}">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/panelfiles/assets/js/plugins/c3charts/c3.min.css') }}">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="{{ asset('/panelfiles/assets/img/favicon.ico') }}">

        <!-- Editor -->
        <script type="text/javascript" src="{{ asset('/panelfiles/ckeditor/ckeditor.js') }}"></script>

        <link rel="stylesheet" href="{{ asset('/panelfiles/sweetalert/dist/sweetalert.css') }}">

        <link rel="stylesheet" type="text/css"
            href="{{ asset('/public/css/requerimientos/panel-misrequerimientosMasinfo.blade.css') }}">


        <!-- Sweetalert -->
        <script src="https://{{ asset('/panelfiles/sweetalert/dist/sweetalert.min.js') }}"></script>
        <link rel="stylesheet" href="https://{{ asset('/panelfiles/sweetalert/dist/sweetalert.css') }}">

        <script language="JavaScript">
            //<!--

            function infoEmpleado(texto) {
                Swal.fire({
                    icon: 'info',
                    title: "<i>Información del Empleado</i>",
                    html: texto,
                    confirmButtonText: "Cerrar!",
                });
            }

            function infoSolicitud(texto) {
                Swal.fire({
                    icon: 'info',
                    title: "<i>Información de Solicitud</i>",
                    html: texto,
                    confirmButtonText: "Cerrar!",
                });
            }

            function executeProcess(event) {
                document.getElementById('btnEnviar').disabled = true;
                document.getElementById('btnEnviar').classList.add("my-button-env-dsb");
                event.preventDefault();
                document.forms['formcerrar'].submit();
            }

            function executeProcessR(event) {
                document.getElementById('btnEnviarR').disabled = true;
                document.getElementById('btnEnviarR').classList.add("my-button-envR-dsb");
                event.preventDefault();
                document.forms['formrechazar'].submit();
            }
            //-->
        </script>

        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="{{ asset('/panelfiles/sweetalert/dist/sweetalert.css') }}">

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
                                <a href="{{ asset('/panel/requerimientos/misrequerimientos') }}"
                                    title="Requerimientos > Mis requerimientos">
                                    <font color="#34495e">
                                        Requerimientos > Mis requerimientos >
                                    </font>
                                    <font color="#b4c056">
                                        Más información
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset('/panel/requerimientos/misrequerimientos') }}"
                            class="btn btn-primary btn-sm ml10" title="Requerimientos > Mis requerimientos">
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
                                            <tr style="background-color:#2B547E; color: #FFFFFF">
                                                <th>
                                                    Requerimiento
                                                    <?= $DatosSolicitud[0]->num_solicitud ?>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tr>
                                            <td>
                                                <table id="message-table"
                                                    class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Grupo:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            $nombreg = PanelGrupos::NombreGrupo($DatosSolicitud[0]->grupo);
                                                            echo $nombreg[0]->descripcion;

                                                            $nomgrupo = PanelGrupos::getGrupo($DatosSolicitud[0]->grupo);

                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Estado:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            $estado = $DatosSolicitud[0]->estado;
                                                            if ($estado == 1) {
                                                                echo 'Pendiente de asignaci&oacute;n';
                                                            } elseif ($estado == 2) {
                                                                echo 'Asignado, en proceso';
                                                            } elseif ($estado == 3) {
                                                                echo 'Atendido, pendiente encuesta de satisfacci&oacute;n';
                                                            } elseif ($estado == 4) {
                                                                echo 'Finalizado';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Fecha de realización:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?= $DatosSolicitud[0]->fecha_solicita ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Solicitado por:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            $empleadosol = PanelEmpleados::getEmpleado($DatosSolicitud[0]->usr_solicita);
                                                            echo $empleadosol[0]->primer_nombre;
                                                            echo ' ';
                                                            echo $empleadosol[0]->ot_nombre;
                                                            echo ' ';
                                                            echo $empleadosol[0]->primer_apellido;
                                                            echo ' ';
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
                                                        <td style="text-align:left" colspan="3">
                                                            Cordial saludo, requiero
                                                            <?= $DatosSolicitud[0]->descripcion ?>
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

                                                            <button type="button" style="background:#f7f9f9;"
                                                                class="btn btn-default light"
                                                                onclick="window.open('{{ asset('/archivos/Requerimientos/') }}<?= $DatosSolicitud[0]->archivo ?>','_blank')"
                                                                title="Descargar">
                                                                <i class="fa <?= $icono ?> fa-lg"
                                                                    style="color:#<?= $fonicono ?>;"></i>
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
                                                                echo 'No aplica';
                                                            } else {
                                                                $creado = PanelEmpleados::getEmpleado($creadopor);
                                                                echo $creado[0]->primer_nombre;
                                                                echo ' ';
                                                                echo $creado[0]->ot_nombre;
                                                                echo ' ';
                                                                echo $creado[0]->primer_apellido;
                                                                echo ' ';
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
                                                                echo 'No aplica';
                                                            } else {
                                                                $atendido = PanelEmpleados::getEmpleado($atendidopor);
                                                                echo $atendido[0]->primer_nombre;
                                                                echo ' ';
                                                                echo $atendido[0]->ot_nombre;
                                                                echo ' ';
                                                                echo $atendido[0]->primer_apellido;
                                                                echo ' ';
                                                                echo $atendido[0]->ot_apellido;
                                                            }
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Fecha de cierre:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            if ($DatosSolicitud[0]->fecha_cierre == null) {
                                                                echo 'Pendiente';
                                                            } else {
                                                                echo $DatosSolicitud[0]->fecha_cierre;
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Observaciones de cierre:
                                                        </th>
                                                        <td style="text-align:left; font-size: 17px; color:blue; "
                                                            colspan="3">
                                                            <?= $DatosSolicitud[0]->desc_cierre ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Categoría:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            if ($DatosSolicitud[0]->categoria == '0') {
                                                                echo 'Pendiente';
                                                            } else {
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
                            if ($DatosSolicitud[0]->categoria == '0') {
                              echo "Pendiente";
                            } else if ($DatosSolicitud[0]->depende_de == "T") {
                              echo "Indefinido - Depende de terceros";
                            } else if ($DatosSolicitud[0]->depende_de == "P") {
                              echo "Indefinido - Proyecto de duración no establecida";
                            } else {
                              $Prioridad = PanelPriorizaciones::getCriterio($categ[0]->criticidad);
                              $Valor     = PanelPriorizaciones::getTiempo($DatosSolicitud[0]->grupo, $Prioridad[0]->id_criterio);
                            ?>
                                                            <button type="button"
                                                                style="text-align:left; cursor:default; outline:none; width:110px; "
                                                                tabindex="-1" class="btn btn-default light">
                                                                <b>
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-exclamation-triangle fa-lg"
                                                                            style="color:<?= $Prioridad[0]->color ?>; text-shadow: 1px 1px 1px #000;"></i>
                                                                    </label>
                                                                    &nbsp;&nbsp;
                                                                    <?php
                                                                    echo $Valor[0]->tiempo;
                                                                    echo ' día';
                                                                    if ($Valor[0]->tiempo != 1) {
                                                                        echo 's';
                                                                    }
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

                                                            <button type="button" style="background:#f7f9f9;"
                                                                class="btn btn-default light"
                                                                onclick="window.open('{{ asset('/archivos/Requerimientos/') }}<?= $DatosSolicitud[0]->archivo_cierre ?>','_blank')"
                                                                title="Descargar">
                                                                <i class="fa <?= $icono ?> fa-lg"
                                                                    style="color:#<?= $fonicono ?>;"></i>
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

                                                            if ($calificacion == '') {
                                                                echo 'Pendiente';
                                                            } elseif ($calificacion == 'M') {
                                                                echo 'Muy satisfecho';
                                                            } elseif ($calificacion == 'S') {
                                                                echo 'Satisfecho';
                                                            } elseif ($calificacion == 'I') {
                                                                echo 'Insatisfecho';
                                                            }
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Fecha de encuesta:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            if ($DatosSolicitud[0]->fecha_calificacion == null) {
                                                                echo 'Pendiente';
                                                            } else {
                                                                echo $DatosSolicitud[0]->fecha_calificacion;
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Observaciones encuesta de satisfacción:
                                                        </th>
                                                        <td style="text-align:justify;" colspan="3">
                                                            <?= $DatosSolicitud[0]->des_calificacion ?>
                                                        </td>
                                                    </tr>

                                                    <?php
                                                    if ($DatosSolicitud[0]->reintegro == 1 || $DatosSolicitud[0]->reintegro == 2) {
                                                        echo "<tr style=\"background-color: #F8F8F8; color:#000000\">";
                                                        echo "<th style=\"text-align:left\">";
                                                        echo 'Reintegro informado por:';
                                                        echo '</th>';

                                                        echo "<td style=\"text-align:left\">";
                                                        if ($DatosSolicitud[0]->reintegro == 1) {
                                                            echo 'Pendiente por reintegro';
                                                        } else {
                                                            $reint = PanelEmpleados::getEmpleado($DatosSolicitud[0]->usr_reintegro);
                                                            echo $reint[0]->primer_nombre;
                                                            echo ' ';
                                                            echo $reint[0]->ot_nombre;
                                                            echo ' ';
                                                            echo $reint[0]->primer_apellido;
                                                            echo ' ';
                                                            echo $reint[0]->ot_apellido;
                                                            echo '<br>';
                                                            echo $DatosSolicitud[0]->fecha_reintegro;
                                                        }
                                                        echo '</td>';

                                                        echo "<th style=\"text-align:left\">";
                                                        echo 'Observaciones de reintegro:';
                                                        echo '</th>';

                                                        echo "<td style=\"text-align:justify\">";
                                                        if ($DatosSolicitud[0]->reintegro == 2) {
                                                            echo $DatosSolicitud[0]->obs_reintegro;
                                                        }
                                                        echo '</td>';
                                                        echo '</tr>';
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

                            <!-- -------------- Adjuntos Iniciales -------------- -->
                            <div class="nano-content">
                                <div class="table-responsive">
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr style="background-color:#2B547E; color: #ffffff">
                                                <th>
                                                    Archivos Adjuntos Iniciales
                                                </th>
                                            </tr>
                                        </thead>

                                        <tr>
                                            <td>
                                                <table id="message-table"
                                                    class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                    <tr>
                                                        <th
                                                            style="text-align: left; background-color:#FFFFFF; color: black;">
                                                            #
                                                        </th>
                                                        <th
                                                            style="text-align:center; background-color:#FFFFFF; color: black;">
                                                            Adjunto
                                                        </th>
                                                        <th
                                                            style="text-align: center; background-color:#FFFFFF; color: black;">
                                                            Fecha y hora
                                                        </th>
                                                        <th
                                                            style="text-align: left; background-color:#FFFFFF; color: black;">
                                                            Colaborador
                                                        </th>
                                                    </tr>

                                                    <?php
                                                    $ArchivosAdjuntos = PanelSolicitudes::getSolicitudFilesIni($DatosSolicitud[0]->num_solicitud);
                                                    $adj = 1;
                                                    ?>
                                                    @foreach ($ArchivosAdjuntos as $DatArchAd)
                                                        <tr style="background-color: #F8F8F8; color:#000000">
                                                            <td style="text-align:left">
                                                                <?php
                                                                echo $adj;
                                                                $adj++;
                                                                ?>
                                                            </td>

                                                            <td style="text-align:center">
                                                                <?php
                            $nombrearc = $DatArchAd->archivo;

                            if ($nombrearc == '') {
                              echo "No";
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
                                $fonicono = "269ec5";
                                $icono    = "fa-file-image-o";
                              } else {
                                $fonicono = "000000";
                                $icono    = "fa-file-archive-o";
                              }
                            ?>

                                                                <button type="button" style="background:##e5eaee;"
                                                                    class="btn btn-default light"
                                                                    onclick="window.open('{{ asset('/archivos/Requerimientos/') }}<?= $nombrearc . '?' . date('i:s') ?>','_blank')"
                                                                    title="Descargar">
                                                                    <i class="fa <?= $icono ?> fa-lg"
                                                                        style="color:#<?= $fonicono ?>;"></i>
                                                                </button>
                                                                <?php
                            }
                            ?>
                                                            </td>

                                                            <td style="text-align:center">
                                                                <?= $O_Util->fecha_texto_hora($DatArchAd->fecha) ?>
                                                            </td>

                                                            <td style="text-align:center">
                                                                <?php
                                                                $empleado = PanelEmpleados::getEmpleado($DatArchAd->usuario);

                                                                $cargo = PanelCargos::getCargo($empleado[0]->cargo);
                                                                $centro = PanelCentrosOp::getCentroOp($empleado[0]->centro_op);

                                                                $NomEmpleado = $empleado[0]->primer_nombre . ' ' . $empleado[0]->ot_nombre;
                                                                $ApeEmpleado = $empleado[0]->primer_apellido . ' ' . $empleado[0]->ot_apellido;
                                                                $CelEmpleado = $empleado[0]->numtel;
                                                                $CedulaEmpleado = $empleado[0]->identificacion;
                                                                $EmailEmpleado = $empleado[0]->correo;
                                                                $CargoEmpleado = $cargo[0]->descripcion;
                                                                $CentroEmpleado = $centro[0]->descripcion;

                                                                $infoEmpleado = '';
                                                                $infoEmpleado .= $NomEmpleado . ' ' . $ApeEmpleado . '<br/>';
                                                                $infoEmpleado .= $CelEmpleado . '<br/>';
                                                                $infoEmpleado .= $CedulaEmpleado . '<br/>';
                                                                $infoEmpleado .= $EmailEmpleado . '<br/>';
                                                                $infoEmpleado .= $CargoEmpleado . '<br/>';
                                                                $infoEmpleado .= $CentroEmpleado . '<br/>';
                                                                ?>
                                                                <button type="button" class="btn btn-default light"
                                                                    onClick="infoEmpleado('<?= $infoEmpleado ?>')">
                                                                    <i class="fa fa-user fa-lg"
                                                                        style="color:#269ec5;"></i>&nbsp;
                                                                </button>
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
                        <br>

                        <div class="panel m3">

                            <!-- -------------- Seguimiento -------------- -->
                            <div class="nano-content">
                                <div class="table-responsive">
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr style="background-color:#2B547E; color: #ffffff">
                                                <th>
                                                    Seguimiento
                                                </th>
                                            </tr>
                                        </thead>

                                        <tr>
                                            <td>
                                                <table id="message-table"
                                                    class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                    <tr>
                                                        <th
                                                            style="text-align: left; background-color:#FFFFFF; color: black;">
                                                            #
                                                        </th>
                                                        <th
                                                            style="text-align: left; background-color:#FFFFFF; color: black;">
                                                            Descripción
                                                        </th>
                                                        <th
                                                            style="text-align:center; background-color:#FFFFFF; color: black;">
                                                            Adjunto
                                                        </th>
                                                        <th
                                                            style="text-align: center; background-color:#FFFFFF; color: black;">
                                                            Fecha y hora
                                                        </th>
                                                        <th
                                                            style="text-align: left; background-color:#FFFFFF; color: black;">
                                                            Colaborador
                                                        </th>
                                                    </tr>

                                                    <?php
                                                    $Seguimientos = PanelSolicitudes::getSolicitudes($DatosSolicitud[0]->num_solicitud);
                                                    $e = 1;
                                                    ?>
                                                    @foreach ($Seguimientos as $DatSeg)
                                                        <tr style="background-color: #F8F8F8; color:#000000">
                                                            <td style="text-align:left">
                                                                <?php
                                                                echo $e;
                                                                $e++;
                                                                ?>
                                                            </td>

                                                            <td style="text-align:left">
                                                                <?php
                                                                if (isset($DatSeg->cierre)) {
                                                                    if ($DatSeg->cierre == 1) {
                                                                        $ColorFont = '#00763b';
                                                                    }

                                                                    if ($DatSeg->rechazo == 1) {
                                                                        $ColorFont = '#d9480f';
                                                                    }
                                                                } else {
                                                                    $ColorFont = '#000000';
                                                                }

                                                                if (isset($DatSeg->rechazo)) {
                                                                    if ($DatSeg->rechazo == 0 && $DatSeg->cierre == 0) {
                                                                        $ColorFont = '#000000';
                                                                    }
                                                                } else {
                                                                    $ColorFont = '#000000';
                                                                } ?>

                                                                <font style="color: <?= $ColorFont ?>;">
                                                                    <?= $DatSeg->descripcion ?></font>
                                                            </td>

                                                            <td style="text-align:center">
                                                                <?php
                            $nombrearc = $DatSeg->archivo;

                            if ($nombrearc == '') {
                              echo "No";
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
                                $fonicono = "269ec5";
                                $icono    = "fa-file-image-o";
                              } else {
                                $fonicono = "000000";
                                $icono    = "fa-file-archive-o";
                              }
                            ?>

                                                                <button type="button" style="background:##e5eaee;"
                                                                    class="btn btn-default light"
                                                                    onclick="window.open('{{ asset('/archivos/Requerimientos/') }}<?= $nombrearc . '?' . date('i:s') ?>','_blank')"
                                                                    title="Descargar">
                                                                    <i class="fa <?= $icono ?> fa-lg"
                                                                        style="color:#<?= $fonicono ?>;"></i>
                                                                </button>
                                                                <?php
                            }
                            ?>
                                                            </td>

                                                            <td style="text-align:center">
                                                                <?= $O_Util->fecha_texto_hora($DatSeg->fecha) ?>
                                                            </td>

                                                            <td style="text-align:center">
                                                                <?php
                                                                $empleado = PanelEmpleados::getEmpleado($DatSeg->usuario);

                                                                $cargo = PanelCargos::getCargo($empleado[0]->cargo);
                                                                $centro = PanelCentrosOp::getCentroOp($empleado[0]->centro_op);

                                                                $NomEmpleado = $empleado[0]->primer_nombre . ' ' . $empleado[0]->ot_nombre;
                                                                $ApeEmpleado = $empleado[0]->primer_apellido . ' ' . $empleado[0]->ot_apellido;
                                                                $CelEmpleado = $empleado[0]->numtel;
                                                                $CedulaEmpleado = $empleado[0]->identificacion;
                                                                $EmailEmpleado = $empleado[0]->correo;
                                                                $CargoEmpleado = $cargo[0]->descripcion;
                                                                $CentroEmpleado = $centro[0]->descripcion;

                                                                $infoEmpleado = '';
                                                                $infoEmpleado .= $NomEmpleado . ' ' . $ApeEmpleado . '<br/>';
                                                                $infoEmpleado .= $CelEmpleado . '<br/>';
                                                                $infoEmpleado .= $CedulaEmpleado . '<br/>';
                                                                $infoEmpleado .= $EmailEmpleado . '<br/>';
                                                                $infoEmpleado .= $CargoEmpleado . '<br/>';
                                                                $infoEmpleado .= $CentroEmpleado . '<br/>';
                                                                ?>
                                                                <button type="button" class="btn btn-default light"
                                                                    onClick="infoEmpleado('<?= $infoEmpleado ?>')">
                                                                    <i class="fa fa-user fa-lg"
                                                                        style="color:#269ec5;"></i>&nbsp;
                                                                </button>
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

                        <?php
          if ($estado < 3 && $DatosSolicitud[0]->notificacion_cierre == 0)  //Si el requerimiento aun no se ha cerrado
          {
          ?>
                        <br>
                        <div class="panel m2">
                            <!-- -------------- Message Body -------------- -->
                            <div class="nano-content">
                                <div class="table-responsive">
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr>
                                                <th style="background-color:#2B547E; color:#ffffff; text-align:left;">
                                                    Agregar información
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <font color="#34495e">
                                                        Cordial saludo,
                                                    </font>
                                                    <div class="allcp-form">
                                                        {!! Form::open([
                                                            'action' => 'Requerimientos\MisRequerimientosPanelController@InformacionAgregarDB',
                                                            'class' => 'form',
                                                            'id' => 'form-wizard',
                                                        ]) !!}
                                                        {!! Form::hidden('solicitud', $DatosSolicitud[0]->num_solicitud) !!}
                                                        {!! Form::hidden('titulo_solicitud', $DatosSolicitud[0]->descripcion) !!}
                                                        {!! Form::hidden('grupo', $DatosSolicitud[0]->grupo) !!}
                                                        {!! Form::hidden('ruta', '') !!}
                                                        <div class="section">
                                                            <div class="col-md-5">
                                                                <label class="field prepend-icon">
                                                                    {!! Form::textarea('descripcion', '', [
                                                                        'cols' => 4,
                                                                        'required',
                                                                        'id' => 'descripcion',
                                                                        'class' => 'gui-input',
                                                                        'style' => 'height: 80px;',
                                                                        'placeholder' => '* Ingrese aquí la información adicional al requerimiento, sea breve y puntual.',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-reorder"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <br>
                                                                {!! Form::submit('Adicionar información', ['class' => 'my-button']) !!}
                                                            </div>
                                                        </div>
                                                        {!! Form::hidden('correoNotificacion', $DatosSolicitud[0]->email_notificacion) !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php
          }
          ?>
                        <!-- -------------- /Column Center -------------- -->

                        <!-- CERRAR -->

                        <?php
          if ($DatosSolicitud[0]->estado == 4) { ?>
                        <br />
                        <table id="message-table" class="table allcp-form theme-warning br-t">
                            <thead>
                                <tr style="background-color:#2B547E; color: #FFFFFF">
                                    <th>
                                        EL TICKET YA FUE CERRADO !
                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <?php } else {
            if ($DatosSolicitud[0]->usr_cierre != 0 && $DatosSolicitud[0]->notificacion_cierre != 0) {
            ?>
                        <br>
                        <table id="message-table" class="table allcp-form theme-warning br-t">
                            <thead>
                                <tr style="background-color:#2B547E; color: #FFFFFF">
                                    <th>
                                        CERRAR TICKET
                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <div class="panel m3">
                            <div class="nano-content">
                                <div class="table-responsive">
                                    {!! Form::open([
                                        'action' => 'Requerimientos\AtenderRequerimientosPanelController@AtenderCerrarDB',
                                        'class' => 'form',
                                        'id' => 'formcerrar',
                                        'name' => 'formcerrar',
                                        'files' => true,
                                    ]) !!}
                                    {!! Form::hidden('solicitud', $DatosSolicitud[0]->num_solicitud) !!}
                                    {!! Form::hidden('grupo', $DatosSolicitud[0]->grupo) !!}
                                    {!! Form::hidden('asignado', $DatosSolicitud[0]->usr_cierre) !!}
                                    {!! Form::hidden('titulo_solicitud', $DatosSolicitud[0]->descripcion) !!}



                                    <?php
                    if (isset($DatosSolicitud[0]->fecha_propuesta_cierre)) {
                      $ParametrosNotificaciones = PanelNotificaciones::getNotificacion(1);
                      $FechaCierreMinimo = date("Y-m-d", strtotime($DatosSolicitud[0]->fecha_propuesta_cierre . "+" . $ParametrosNotificaciones->dias_min . "days"));
                      $FechaCierreMaximo = date("Y-m-d", strtotime($DatosSolicitud[0]->fecha_propuesta_cierre . "+" . $ParametrosNotificaciones->dias_max . "days"));

                      if (($DatosSolicitud[0]->fecha_propuesta_cierre != '')
                        && ($FechaCierreMaximo < date('Y-m-d'))
                        && $DatosSolicitud[0]->estado != 4
                      ) { ?>
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr style="background-color:#fa5252">
                                                <th>
                                                    <spam style="color: #ffffff;">LA FECHA DE VENCIMIENTO MÁXIMO DEL
                                                        TICKET YA FUE SUPERADA !</spam>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <?php
                      } else {
                      ?>
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <tr>
                                            <td width="500">
                                                <label class="field prepend-icon">
                                                    <?php if ($DatosSolicitud[0]->estado != 4 && $DatosSolicitud[0]->notificacion_cierre != 0) { ?>
                                                    {!! Form::textarea('descripcion', '', [
                                                        'cols' => 4,
                                                        'required',
                                                        'id' => 'descripcion',
                                                        'class' => 'gui-input',
                                                        'style' => 'height:45px;',
                                                        'placeholder' => '* Mensaje de Cierre, sea breve y puntual.',
                                                        'required' => 'required',
                                                    ]) !!}
                                                    <?php } else { ?>
                                                    {!! Form::textarea('descripcion', '', [
                                                        'cols' => 4,
                                                        'required',
                                                        'id' => 'descripcion',
                                                        'class' => 'gui-input',
                                                        'style' => 'height:45px;',
                                                        'placeholder' => '* Mensaje de Cierre, sea breve y puntual.',
                                                        'disabled' => true,
                                                    ]) !!}
                                                    <?php } ?>
                                                    <label for="username" class="field-icon">
                                                        <i class="fa fa-reorder"></i>
                                                    </label>
                                                </label>
                                            </td>

                                            <td>
                                                <label class="field prepend-icon append-button file">
                                                    <span class="button" style="background-color: #8e949e;">
                                                        Archivo
                                                    </span>
                                                    <?php if ($DatosSolicitud[0]->estado != 4 && $DatosSolicitud[0]->notificacion_cierre != 0) { ?>
                                                    {!! Form::file('file1', [
                                                        '',
                                                        'id' => 'file1',
                                                        'class' => 'gui-file',
                                                        'onChange' => "document.getElementById('uploader1').value = this.value;",
                                                    ]) !!}
                                                    {!! Form::text('uploader1', null, [
                                                        'id' => 'uploader1',
                                                        'class' => 'gui-input',
                                                        'placeholder' => 'Seleccione el archivo',
                                                    ]) !!}
                                                    <?php } else { ?>
                                                    {!! Form::file('file1', [
                                                        '',
                                                        'id' => 'file1',
                                                        'class' => 'gui-file',
                                                        'onChange' => "document.getElementById('uploader1').value = this.value;",
                                                    ]) !!}
                                                    {!! Form::text('uploader1', null, [
                                                        'id' => 'uploader1',
                                                        'class' => 'gui-input',
                                                        'placeholder' => 'Seleccione el archivo',
                                                        'disabled' => true,
                                                    ]) !!}
                                                    <?php } ?>

                                                    <label class="field-icon">
                                                        <i class="fa fa-cloud-upload"></i>
                                                    </label>
                                                </label>
                                            </td>

                                            <td>
                                                {!! Form::hidden('correoNotificacion', $DatosSolicitud[0]->email_notificacion) !!}
                                                <?php if ($DatosSolicitud[0]->estado != 4 && $DatosSolicitud[0]->notificacion_cierre != 0) { ?>
                                                <input type="submit" name="btEnviar" value="Cerrar" id="btnEnviar"
                                                    class="my-button-env" style="color: #ffffff;"
                                                    onclick="executeProcess(event)" />
                                                <?php } else { ?>
                                                {!! Form::submit('Cerrar', ['class' => 'button', 'disabled' => true, 'style' => 'background-color: #00763b']) !!}
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <?php
                      }
                      ?>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                  }
                }
        ?>
                        <!-- CERRAR -->

                        <!-- RECHAZAR -->

                        <?php
        if ($DatosSolicitud[0]->estado == 4) { ?>
                        <!--br />
          <table id="message-table" class="table allcp-form theme-warning br-t">
            <thead>
              <tr style="background-color:#2B547E; color: #FFFFFF">
                <th>
                  EL TICKET YA FUE CERRADO !
                </th>
              </tr>
            </thead>
          </table -->
                        <?php } else {
          if ($DatosSolicitud[0]->usr_cierre != 0 && $DatosSolicitud[0]->notificacion_cierre != 0) {
          ?>
                        <br>
                        <table id="message-table" class="table allcp-form theme-warning br-t">
                            <thead>
                                <tr style="background-color:#2B547E; color: #FFFFFF">
                                    <th>
                                        RECHAZAR TICKET
                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <div class="panel m3">
                            <div class="nano-content">
                                <div class="table-responsive">
                                    {!! Form::open([
                                        'action' => 'Requerimientos\AtenderRequerimientosPanelController@RechazarCerrarNotificacion',
                                        'class' => 'form',
                                        'id' => 'formrechazar',
                                        'name' => 'formrechazar',
                                        'files' => true,
                                    ]) !!}
                                    {!! Form::hidden('solicitud', $DatosSolicitud[0]->num_solicitud) !!}
                                    {!! Form::hidden('grupo', $DatosSolicitud[0]->grupo) !!}
                                    {!! Form::hidden('aplreintegro', $nomgrupo[0]->reintegro) !!}
                                    {!! Form::hidden('asignado', $DatosSolicitud[0]->usr_cierre) !!}
                                    {!! Form::hidden('titulo_solicitud', $DatosSolicitud[0]->descripcion) !!}



                                    <?php
                  if (isset($DatosSolicitud[0]->fecha_propuesta_cierre)) {
                    $ParametrosNotificaciones = PanelNotificaciones::getNotificacion(1);
                    $FechaCierreMinimo = date("Y-m-d", strtotime($DatosSolicitud[0]->fecha_propuesta_cierre . "+" . $ParametrosNotificaciones->dias_min . "days"));
                    $FechaCierreMaximo = date("Y-m-d", strtotime($DatosSolicitud[0]->fecha_propuesta_cierre . "+" . $ParametrosNotificaciones->dias_max . "days"));

                    if (($DatosSolicitud[0]->fecha_propuesta_cierre != '')
                      && ($FechaCierreMaximo < date('Y-m-d'))
                      && $DatosSolicitud[0]->estado != 4
                    ) { ?>
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr style="background-color:#fa5252">
                                                <th>
                                                    <spam style="color: #ffffff;">LA FECHA DE VENCIMIENTO MÁXIMO DEL
                                                        TICKET YA FUE SUPERADA !</spam>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <?php
                    } else {
                    ?>
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <tr>
                                            <td width="500">
                                                <label class="field prepend-icon">
                                                    <?php if ($DatosSolicitud[0]->estado != 4 && $DatosSolicitud[0]->notificacion_cierre != 0) { ?>
                                                    {!! Form::textarea('comentario_rechazo', '', [
                                                        'cols' => 4,
                                                        'required',
                                                        'id' => 'comentario_rechazo',
                                                        'class' => 'gui-input',
                                                        'style' => 'height:45px;',
                                                        'placeholder' => '* Motivo del Rechazo, sea breve y puntual.',
                                                    ]) !!}
                                                    <?php } else { ?>
                                                    {!! Form::textarea('comentario_rechazo', '', [
                                                        'cols' => 4,
                                                        'required',
                                                        'id' => 'comentario_rechazo',
                                                        'class' => 'gui-input',
                                                        'style' => 'height:45px;',
                                                        'placeholder' => '* Motivo del Rechazo, sea breve y puntual.',
                                                        'disabled' => true,
                                                    ]) !!}
                                                    <?php } ?>
                                                    <label for="username" class="field-icon">
                                                        <i class="fa fa-reorder"></i>
                                                    </label>
                                                </label>
                                            </td>

                                            <td>
                                                <label class="field prepend-icon append-button file">
                                                    <span class="button" style="background-color: #8e949e;">
                                                        Archivo
                                                    </span>
                                                    <?php if ($DatosSolicitud[0]->estado != 4 && $DatosSolicitud[0]->notificacion_cierre != 0) { ?>
                                                    {!! Form::file('file2', [
                                                        '',
                                                        'id' => 'file2',
                                                        'class' => 'gui-file',
                                                        'onChange' => "document.getElementById('uploader2').value = this.value;",
                                                    ]) !!}
                                                    {!! Form::text('uploader2', null, [
                                                        'id' => 'uploader2',
                                                        'class' => 'gui-input',
                                                        'placeholder' => 'Seleccione el archivo',
                                                    ]) !!}
                                                    <?php } else { ?>
                                                    {!! Form::file('file2', [
                                                        '',
                                                        'id' => 'file2',
                                                        'class' => 'gui-file',
                                                        'onChange' => "document.getElementById('uploader2').value = this.value;",
                                                    ]) !!}
                                                    {!! Form::text('uploader2', null, [
                                                        'id' => 'uploader2',
                                                        'class' => 'gui-input',
                                                        'placeholder' => 'Seleccione el archivo',
                                                        'disabled' => true,
                                                    ]) !!}
                                                    <?php } ?>

                                                    <label class="field-icon">
                                                        <i class="fa fa-cloud-upload"></i>
                                                    </label>
                                                </label>
                                            </td>

                                            <td>
                                                {!! Form::hidden('correoNotificacion', $DatosSolicitud[0]->email_notificacion) !!}
                                                <?php if ($DatosSolicitud[0]->estado != 4 && $DatosSolicitud[0]->notificacion_cierre != 0) { ?>
                                                <input type="submit" name="btEnviarR" value="Rechazar"
                                                    id="btnEnviarR" class="my-button-envR" style="color: #ffffff;"
                                                    onclick="executeProcessR(event)" />
                                                <?php } else { ?>
                                                {!! Form::submit('Rechazar', ['class' => 'button', 'disabled' => true, 'style' => 'background-color: #d9480f']) !!}
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <?php
                    }

                    if (isset($DatosSolicitud[0]->fecha_propuesta_cierre)) {
                      $ParametrosNotificaciones = PanelNotificaciones::getNotificacion(1);
                      $FechaCierreMinimo = date("Y-m-d", strtotime($DatosSolicitud[0]->fecha_propuesta_cierre . "+" . $ParametrosNotificaciones->dias_min . "days"));
                      $FechaCierreMaximo = date("Y-m-d", strtotime($DatosSolicitud[0]->fecha_propuesta_cierre . "+" . $ParametrosNotificaciones->dias_max . "days"));
                    ?>
                                    <br>
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr style="background-color:#2B547E; color: #FFFFFF">
                                                <th>
                                                    FECHAS DE CIERRE DE TICKET
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <table>
                                        <tr>
                                            <td>
                                                Fecha de Notificación: <span
                                                    style="color: #1864ab;"><?= $O_Util->fecha_texto($DatosSolicitud[0]->fecha_propuesta_cierre) ?></span>
                                                <br />
                                                Fecha de Cierre Mínimo: <span
                                                    style="color: #66a80f;"><?= $O_Util->fecha_texto($FechaCierreMinimo) ?></span>
                                                <br />
                                                Fecha de Cierre Máximo: <span
                                                    style="color: #e03131;"><?= $O_Util->fecha_texto($FechaCierreMaximo) ?></span>
                                                <br />
                                            </td>
                                        </tr>
                                    </table>
                                    <?php } ?>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <?php
                  }
                }
              }
      ?>
                        <!-- CERRAR -->

                    </div>
                </section>
                <!-- -------------- /Content -------------- -->
            </section>
        </div>
        <!-- -------------- /Body Wrap  -------------- -->

        <!-- -------------- Scripts -------------- -->

        <!-- -------------- jQuery -------------- -->
        <script src="{{ asset('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js') }}"></script>

        <!-- -------------- JvectorMap Plugin -------------- -->
        <script src="{{ asset('/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js') }}">
        </script>

        <!-- -------------- HighCharts Plugin -------------- -->
        <script src="{{ asset('/panelfiles/assets/js/plugins/highcharts/highcharts.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/plugins/c3charts/d3.min.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/plugins/c3charts/c3.min.js') }}"></script>

        <!-- -------------- Theme Scripts -------------- -->
        <script src="{{ asset('/panelfiles/assets/js/utility/utility.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/demo/demo.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/main.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/pages/allcp_forms-elements.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/demo/widgets_sidebar.js') }}"></script>

        <!-- -------------- Page JS -------------- -->
        <script src="{{ asset('/panelfiles/assets/js/demo/charts/highcharts.js') }}"></script>

        <!-- -------------- /Scripts -------------- -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    </body>

    </html>
@endforeach
