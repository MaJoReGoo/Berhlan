<?php
$server = '/Berhlan/public';

use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelNotificaciones;
use App\Models\Requerimientos\PanelSolicitudes;
use App\Models\Requerimientos\PanelGrupos;
use App\Models\Requerimientos\PanelCategorias;

?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>
    @include('includes-panel/C_util')
    <?php
    $O_Util = new Util();
    ?>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Requerimientos | Atender
        </title>

        @include('includes-CDN/include-head')
        {{-- <meta name="keywords" content="panel, cms, usuarios, servicio" />
        <meta name="description" content="Intranet para grupo Berhlan">
        <meta name="author" content="USUARIO">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- -------------- Fonts -------------- -->
        <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
        <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic'
            rel='stylesheet' type='text/css'>

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
        <script type="text/javascript" src="<?= $server ?>/panelfiles/ckeditor/ckeditor.js"></script> --}}

        <style>
            .my-button {
                padding: 10px 20px;
                background-color: #22b8cf;
                color: #ffffff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .my-button:hover {
                background-color: #1a8a9b;
                color: #ffffff;
            }

            .my-button:active {
                background-color: #22b8cf;
                color: #003070;
            }

            /* Botón 2 */
            .my-button-2 {
                padding: 10px 20px;
                background-color: #ffc400;
                color: #003070;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .my-button-2:hover {
                background-color: #c19912;
                color: #003070;
            }

            .my-button-2:active {
                background-color: #ffc400;
                color: #003070;
            }

            .select2-container .select2-selection--single {
                height: 40px;
                /* Cambia la altura según lo necesites */
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                top: 6px;
            }

            /* Botón 2 */
        </style>

        {{-- <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script-->
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <link rel="stylesheet" href="<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.css">

        <!-- Sweetalert -->
        <script src="https://<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.min.js"></script>
        <link rel="stylesheet" href="https://<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.css">  --}}

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

            function infoImagen(imagen) {

                Swal.fire({
                    title: "Sweet!",
                    text: "Imágen",
                    imageUrl: imagen,
                    imageWidth: 600,
                    imageHeight: 600,
                    imageAlt: "Soporte Gráfico"
                });

                $('#galleryModal').on('show.bs.modal', function(e) {
                    $('#galleryImage').attr("src", $(e.relatedTarget).data("large-src"));
                });
            }

            function executeProcess(event) {
                document.getElementById('btnEnviar').disabled = true;
                document.getElementById('btnEnviar').classList.add("my-button-env-dsb");
                event.preventDefault();
                document.forms['formasignar'].submit();
            }

            //-->
        </script>

        <style>
            .my-button-env {
                padding: 10px 20px;
                background-color: #22b8cf;
                color: #ffffff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .my-button-env-dsb {
                padding: 10px 20px;
                background-color: #999999;
                color: #ffffff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
        </style>
        {{-- <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
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
                                <?php
                                $nomgrupo = PanelGrupos::getGrupo($DatosSolicitud[0]->grupo);
                                ?>
                                <a href="<?= $server ?>/panel/requerimientos/atender/listado/<?= $nomgrupo[0]->id_grupo ?>"
                                    title="Requerimientos > Grupo <?= $nomgrupo[0]->descripcion ?> > Atender">
                                    <font color="#34495e">
                                        Requerimientos > Grupo <?= $nomgrupo[0]->descripcion ?> > Atender >
                                    </font>
                                    <font color="#b4c056">
                                        Requerimiento <?= $DatosSolicitud[0]->num_solicitud ?>
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="<?= $server ?>/panel/requerimientos/atender/listado/<?= $nomgrupo[0]->id_grupo ?>"
                            class="btn btn-primary btn-sm ml10" id="regresar"
                            title="Requerimientos > Grupo <?= $nomgrupo[0]->descripcion ?> > Atender">
                            REGRESAR
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
                                            <tr style="background-color:#2B547E; color:#ffffff">
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
                                                            echo ' ';
                                                            echo ' ';
                                                            ?>
                                                            &nbsp;
                                                            &nbsp;
                                                            &nbsp;
                                                            @php
                                                                $cargosol = PanelCargos::getCargo(
                                                                    $empleadosol[0]->cargo,
                                                                );
                                                                $centrosol = PanelCentrosOp::getCentroOp(
                                                                    $empleadosol[0]->centro_op,
                                                                );

                                                                $NomEmpleadoSol =
                                                                    $empleadosol[0]->primer_nombre .
                                                                    ' ' .
                                                                    $empleadosol[0]->ot_nombre;
                                                                $ApeEmpleadoSol =
                                                                    $empleadosol[0]->primer_apellido .
                                                                    ' ' .
                                                                    $empleadosol[0]->ot_apellido;
                                                                $CelEmpleadoSol = $empleadosol[0]->numtel;
                                                                $CedulaEmpleadoSol = $empleadosol[0]->identificacion;
                                                                $EmailEmpleadoSol = $empleadosol[0]->correo;
                                                                $CargoEmpleadoSol = $cargosol[0]->descripcion;
                                                                $CentroEmpleadoSol = $centrosol[0]->descripcion;

                                                                $infoEmpleadoSol = '';
                                                                $infoEmpleadoSol .=
                                                                    $NomEmpleadoSol . ' ' . $ApeEmpleadoSol . '<br />';
                                                                $infoEmpleadoSol .= $CelEmpleadoSol . '<br />';
                                                                $infoEmpleadoSol .= $CedulaEmpleadoSol . '<br />';
                                                                $infoEmpleadoSol .= $EmailEmpleadoSol . '<br />';
                                                                $infoEmpleadoSol .= $CargoEmpleadoSol . '<br />';
                                                                $infoEmpleadoSol .= $CentroEmpleadoSol . '<br />';

                                                            @endphp



                                                            <button type="button" class="btn btn-default light"
                                                                onClick="infoEmpleado('<?= $infoEmpleadoSol ?>')">
                                                                <i class="fa fa-user fa-lg"
                                                                    style="color:#269ec5;"></i>&nbsp;
                                                            </button>



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
                                                                onclick="window.open('<?= $server ?>/archivos/Requerimientos/<?= $DatosSolicitud[0]->archivo . '?' . date('i:s') ?>','_blank')"
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
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

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
                                                                onclick="window.open('<?= $server ?>/archivos/Requerimientos/<?= $nombrearc . '?' . date('i:s') ?>','_blank')"
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

                        <!-- TRASLADAR -->
                        <div class="panel m3">
                            <div class="nano-content">
                                <div class="table-responsive">
                                    {!! Form::open([
                                        'action' => 'Requerimientos\AtenderRequerimientosPanelController@AtenderTrasladarDB',
                                        'class' => 'form',
                                        'id' => 'form-wizard',
                                    ]) !!}
                                    {!! Form::hidden('solicitud', $DatosSolicitud[0]->num_solicitud) !!}
                                    {!! Form::hidden('nombregrupo', $nomgrupo[0]->descripcion) !!}
                                    {!! Form::hidden('grupoant', $DatosSolicitud[0]->grupo) !!}
                                    {!! Form::hidden('titulo_solicitud', $DatosSolicitud[0]->descripcion) !!}
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <tr>
                                            <th style="color:#34495e; text-align:left;" width="250">
                                                Trasladar requerimiento a otro grupo
                                            </th>

                                            <td width="300">
                                                <label class="field select">
                                                    <select name="grupo" id="grupo" required>
                                                        <option value="">
                                                            * Grupo
                                                        </option>
                                                        <?php
                                                        $Grupos = PanelGrupos::getGruposActivos();
                                                        ?>
                                                        @foreach ($Grupos as $DatGru)
                                                            <?php
                                                            if ($DatGru->id_grupo != $DatosSolicitud[0]->grupo) {
                                                                echo "<option value=\"$DatGru->id_grupo\">";
                                                                echo $DatGru->descripcion;
                                                                echo '</option>';
                                                            }
                                                            ?>
                                                        @endforeach
                                                    </select>

                                                </label>
                                            </td>

                                            <td>
                                                {!! Form::hidden('correoNotificacion', $DatosSolicitud[0]->email_notificacion) !!}
                                                {!! Form::submit('Trasladar', ['class' => 'btn btn-primary']) !!}
                                            </td>
                                        </tr>
                                    </table>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <!-- TRASLADAR -->

                        <br>


                        <!-- ASIGNAR -->
                        <div class="panel m3">
                            <div class="nano-content">
                                <div class="table-responsive">
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr style="background-color:#2B547E; color:#ffffff;">
                                                <th>
                                                    Asignación de Requerimiento
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                    {!! Form::open([
                                        'action' => 'Requerimientos\AtenderRequerimientosPanelController@AtenderAsignarDB',
                                        'class' => 'form',
                                        'name' => 'formasignar',
                                        'id' => 'formasignar',
                                    ]) !!}
                                    {!! Form::hidden('solicitud', $DatosSolicitud[0]->num_solicitud) !!}
                                    {!! Form::hidden('grupo', $DatosSolicitud[0]->grupo) !!}
                                    {!! Form::hidden('titulo_solicitud', $DatosSolicitud[0]->descripcion) !!}
                                    {!! Form::hidden('fechacreacion', $DatosSolicitud[0]->fecha_solicita) !!}
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <tr>
                                            <td width="500">
                                                <label class="field select">
                                                    <select name="asignado" id="asignado" required>
                                                        <?php
                                                        if ($DatosSolicitud[0]->usr_cierre == 0) {
                                                            echo "<option value=\"\">";
                                                            echo '* Asignado a';
                                                            echo '</option>';
                                                        } else {
                                                            $EmpleadoGru = PanelEmpleados::getEmpleado($DatosSolicitud[0]->usr_cierre);
                                                            $idemp = $EmpleadoGru[0]->id_empleado;
                                                            echo "<option value=\"$idemp\">";
                                                            echo $EmpleadoGru[0]->primer_nombre;
                                                            echo ' ';
                                                            echo $EmpleadoGru[0]->ot_nombre;
                                                            echo ' ';
                                                            echo $EmpleadoGru[0]->primer_apellido;
                                                            echo ' ';
                                                            echo $EmpleadoGru[0]->ot_apellido;
                                                            echo '</option>';
                                                        }

                                                        $EmpleadosGru = PanelGrupos::getGrupoEmpleados($DatosSolicitud[0]->grupo);
                                                        ?>
                                                        @foreach ($EmpleadosGru as $DatEmp)
                                                            <?php
                                                            if ($DatEmp->estado == 1) {
                                                                echo "<option value=\"$DatEmp->id_empleado\">";
                                                                echo $DatEmp->primer_nombre;
                                                                echo ' ';
                                                                echo $DatEmp->ot_nombre;
                                                                echo ' ';
                                                                echo $DatEmp->primer_apellido;
                                                                echo ' ';
                                                                echo $DatEmp->ot_apellido;
                                                                echo '</option>';
                                                            }
                                                            ?>
                                                        @endforeach
                                                    </select>

                                                </label>
                                            </td>

                                            <td width="300">
                                                <label class="field select">
                                                    <select name="categoria" id="categoria" required>
                                                        <?php
                                                        if ($DatosSolicitud[0]->categoria == 0) {
                                                            echo "<option value=\"\">";
                                                            echo '* Categoría';
                                                            echo '</option>';
                                                        } else {
                                                            $Categoria = PanelCategorias::getCategoria($DatosSolicitud[0]->categoria);
                                                            $idcta = $Categoria[0]->id_categoria;
                                                            echo "<option value=\"$idcta\">";
                                                            echo $Categoria[0]->descripcion;
                                                            echo '</option>';
                                                        }

                                                        $Categorias = PanelCategorias::getCategoriasGrupo($DatosSolicitud[0]->grupo);
                                                        ?>

                                                        @foreach ($Categorias as $DatCat)
                                                            <?php
                                                            if ($DatCat->estado == 1) {
                                                                echo "<option value=\"$DatCat->id_categoria\">";
                                                                echo $DatCat->descripcion;
                                                                echo '</option>';
                                                            }
                                                            ?>
                                                        @endforeach
                                                    </select>

                                                </label>
                                            </td>

                                            <td width="300">
                                                <label class="field select">
                                                    <select name="depende" id="depende">
                                                        <option value="">Seleccione sí:</option>
                                                        <option value="T" <?php
                                                        if ($DatosSolicitud[0]->depende_de == 'T') {
                                                            echo ' selected ';
                                                        }
                                                        ?>>Depende de terceros
                                                        </option>
                                                        <option value="P" <?php
                                                        if ($DatosSolicitud[0]->depende_de == 'P') {
                                                            echo ' selected ';
                                                        }
                                                        ?>>Es un proyecto
                                                        </option>
                                                    </select>

                                                </label>
                                            </td>

                                            <td>
                                                {!! Form::hidden('correoNotificacion', $DatosSolicitud[0]->email_notificacion) !!}
                                                <input type="submit" name="btEnviar" value="Asignar" id="btnEnviar"
                                                    class="btn btn-primary" style="color: #ffffff;"
                                                    onclick="executeProcess(event)" />
                                            </td>
                                        </tr>
                                    </table>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <!-- ASIGNAR -->



                        <?php //if ($DatosSolicitud[0]->grupo == 1) {

          if ($DatosSolicitud[0]->usr_cierre != 0) {
          ?>
                        <br>
                        <div class="panel m3">
                            <div class="nano-content">
                                <div class="table-responsive">
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr>
                                                <th style="background-color:#2B547E; color:#ffffff; text-align:left;">
                                                    Cerrar Ticket
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                    {!! Form::open([
                                        'action' => 'Requerimientos\AtenderRequerimientosPanelController@AtenderCerrarNotificacion',
                                        'class' => 'form',
                                        'id' => 'form-wizard',
                                        'files' => true,
                                    ]) !!}
                                    {!! Form::hidden('solicitud', $DatosSolicitud[0]->num_solicitud) !!}
                                    {!! Form::hidden('grupo', $DatosSolicitud[0]->grupo) !!}
                                    {!! Form::hidden('aplreintegro', $nomgrupo[0]->reintegro) !!}
                                    {!! Form::hidden('titulo_solicitud', $DatosSolicitud[0]->descripcion) !!}

                                    <table id="message-table" class="table allcp-form theme-warning br-t"
                                        border="1">
                                        <tr>
                                            <?php
                      if (isset($DatosSolicitud[0]->fecha_propuesta_cierre)) {
                        $ParametrosNotificaciones = PanelNotificaciones::getNotificacion(1);
                        $FechaCierreMinimo = date("Y-m-d", strtotime($DatosSolicitud[0]->fecha_propuesta_cierre . "+" . $ParametrosNotificaciones->dias_min . "days"));
                        $FechaCierreMaximo = date("Y-m-d", strtotime($DatosSolicitud[0]->fecha_propuesta_cierre . "+" . $ParametrosNotificaciones->dias_max . "days"));
                      }

                      if (isset($DatosSolicitud[0]->fecha_propuesta_cierre) && ($FechaCierreMaximo < date('Y-m-d')) && $DatosSolicitud[0]->estado != 4) { ?>
                                            <td style="background-color:#fa5252;">
                                                <spam style="color: #ffffff;">
                                                    <center>LA FECHA DE VENCIMIENTO MÁXIMO DEL TICKET <br /> YA FUE
                                                        SUPERADA !</center>
                                                </spam>
                                            </td>
                                            <?php
                      } else { ?>
                                            <td style="color:#ffffff; text-align:left;">

                                            </td>
                                            <?php } ?>
                                            <td>

                                                <div class="section">
                                                    <div class="col-md-3 form-group">
                                                        <label style="color: #2B547E">Fecha de Plazo Para
                                                            Cierre</label>
                                                        <label for="datepicker1" class="field prepend-icon">
                                                            <?php
                              if (isset($DatosSolicitud[0]->fecha_propuesta_cierre)) {
                                $ParametrosNotificaciones = PanelNotificaciones::getNotificacion(1);
                                $FechaCierreMinimo = date("Y-m-d", strtotime($DatosSolicitud[0]->fecha_propuesta_cierre . "+" . $ParametrosNotificaciones->dias_min . "days"));
                                $FechaCierreMaximo = date("Y-m-d", strtotime($DatosSolicitud[0]->fecha_propuesta_cierre . "+" . $ParametrosNotificaciones->dias_max . "days"));
                              ?>
                                                            Fecha de Notificación: <span
                                                                style="color: #1864ab;"><?= $O_Util->fecha_texto($DatosSolicitud[0]->fecha_propuesta_cierre) ?></span>
                                                            <br />
                                                            Fecha de Cierre: <span
                                                                style="color: #66a80f;"><?= $O_Util->fecha_texto($FechaCierreMinimo) ?></span>
                                                            <br />
                                                            Fecha Cierre Máx: <span
                                                                style="color: #e03131;"><?= $O_Util->fecha_texto($FechaCierreMaximo) ?></span>
                                                            <br />
                                                            <?php } ?>
                                                        </label>
                                                    </div>
                                                    <?php
                                                    //if ($DatosSolicitud[0]->notificacion_cierre == 0) {
                                                    ?>
                                                    <div class="col-md-3 form-group">
                                                        <br />
                                                        {!! Form::textarea('comentario_cierre', '', [
                                                            'cols' => 4,
                                                            'required',
                                                            'id' => 'comentario_cierre',
                                                            'class' => 'gui-input',
                                                            'style' => 'height: 45px;',
                                                            'placeholder' => '* Comentario de Cierre',
                                                        ]) !!}
                                                    </div>
                                                    <?php
                          // }

                          if ($nomgrupo[0]->reintegro == 1) {
                            ?>
                                                    <br />
                                                    <div class="col-md-2 form-group">
                                                        <label class="field select">
                                                            <select name="reintegro" id="reintegro" required>
                                                                <option value="">
                                                                    * Controla reintegro
                                                                </option>
                                                                <option value="1">Sí</option>
                                                                <option value="0">No</option>
                                                            </select>

                                                        </label>
                                                    </div>
                                                    <?php
                            }


                          if (isset($DatosSolicitud[0]->fecha_propuesta_cierre) && ($FechaCierreMaximo < date('Y-m-d')) && $DatosSolicitud[0]->estado != 4) { ?>
                                                    <div class="col-md-2 form-group">
                                                        <br />
                                                        {!! Form::hidden('correoNotificacion', $DatosSolicitud[0]->email_notificacion) !!}
                                                        {!! Form::submit('Enviar Notificación', [
                                                            'class' => 'button',
                                                            'disabled',
                                                            'style' => 'background-color: #00763b; color:white;',
                                                        ]) !!}
                                                    </div>
                                                    <div class="col-md-1 form-group">
                                                        <br />
                                                        <i class="fa fa-whatsapp fa-2x"
                                                            style="color: #999999"></i>&nbsp;
                                                    </div>
                                                    <?php
                          } else { ?>
                                                    <br>
                                                    <div class="col-md-3 form-group">
                                                        <label class="field prepend-icon append-button file">
                                                            <span class="button btn btn-primary" style="cursor: pointer">
                                                                Adjuntar
                                                            </span>
                                                            <input type="file" name="archivo" id="archivo2"
                                                                class="gui-file"
                                                                onchange="document.getElementById('subir2').value = this.value;">
                                                            <input type="text" name="subir2" id="subir2"
                                                                class="gui-input" placeholder="Seleccione el archivo">
                                                            <label class="field-icon">
                                                                <i class="fa fa-cloud-upload"></i>
                                                            </label>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-2 form-group" style="display: flex;">
                                                        <br />
                                                        {!! Form::hidden('correoNotificacion', $DatosSolicitud[0]->email_notificacion) !!}
                                                        {!! Form::submit('Enviar Notificación', ['class' => 'button', 'style' => 'background-color: #00763b; color:white;']) !!}
                                                    </div>
                                                    <?php
                                                    //$builder = new \AshAllenDesign\ShortURL\Classes\Builder();
                                                    //$urlCorta = 'https://localhost/Berhlan/public/panel/requerimientos/atender/procesar/' . $DatosSolicitud[0]->num_solicitud;
                                                    $shortURL = 'https://localhost/Berhlan/public/panel/requerimientos/atender/procesar/' . $DatosSolicitud[0]->num_solicitud;
                                                    //$shortURLObject = $builder->destinationUrl($urlCorta)->make();
                                                    //$shortURL = $shortURLObject->default_short_url;
                                                    ?>
                                                    <div class="col-md-1 form-group"
                                                        style="display: flex; justify-content: center;align-items: center;">
                                                        <br />
                                                        <a href="https://wa.me/57<?= $DatosSolicitud[0]->cel_notificacion ?>?text=Hola%20le%20hablamos%20de%20el%20área%20de%20Tics%20de%20Berhlan!
                                %0ALe%20Informamos%20que%20ya%20puede%20cerrar%20su%20requerimiento%20(<?= $DatosSolicitud[0]->num_solicitud ?>)%20en%20Plataforma!
                        %0A<?= $shortURL ?>"
                                                            target="blank"><i class="fa fa-whatsapp fa-2x"
                                                                style="color: #444444"></i></a>&nbsp;
                                                    </div>
                                                    <?php } ?>
                                                </div>

                                            </td>
                                        </tr>
                                    </table>
                                    {!! Form::close() !!}

                                    <?php
                  if (
                    isset($DatosSolicitud[0]->fecha_propuesta_cierre)
                    && ($FechaCierreMaximo < date('Y-m-d'))
                    && $DatosSolicitud[0]->estado != 4
                    && $DatosUsuario[0]->id_usuario == 432 // Definimos el Usuario de Cierre
                  ) { ?>
                                    <div class="panel m3">
                                        <div class="nano-content">
                                            <div class="table-responsive">
                                                {!! Form::open([
                                                    'action' => 'Requerimientos\AtenderRequerimientosPanelController@AtenderCerrarDB',
                                                    'class' => 'form',
                                                    'id' => 'form-wizard',
                                                    'files' => true,
                                                ]) !!}
                                                {!! Form::hidden('solicitud', $DatosSolicitud[0]->num_solicitud) !!}
                                                {!! Form::hidden('grupo', $DatosSolicitud[0]->grupo) !!}
                                                {!! Form::hidden('aplreintegro', $nomgrupo[0]->reintegro) !!}
                                                {!! Form::hidden('asignado', $DatosSolicitud[0]->usr_cierre) !!}

                                                <table id="message-table" class="table allcp-form theme-warning br-t">
                                                    <tr>
                                                        <th
                                                            style="background-color:#2B547E; color:#ffffff; text-align:left;">
                                                            Cerrar Ticket
                                                        </th>

                                                        <td width="500">
                                                            <label class="field prepend-icon">
                                                                {!! Form::textarea('descripcion', '', [
                                                                    'cols' => 4,
                                                                    'required',
                                                                    'id' => 'descripcion',
                                                                    'class' => 'gui-input',
                                                                    'style' => 'height:45px;',
                                                                    'placeholder' => '* Describa la actividad realizada, sea breve y puntual.',
                                                                ]) !!}
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-reorder"></i>
                                                                </label>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label class="field prepend-icon append-button file">
                                                                <span class="button">
                                                                    Archivo
                                                                </span>
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
                                                                <label class="field-icon">
                                                                    <i class="fa fa-cloud-upload"></i>
                                                                </label>
                                                            </label>
                                                        </td>

                                                        <?php
                              if ($nomgrupo[0]->reintegro == 1) {
                              ?>
                                                        <td>
                                                            <label class="field select">
                                                                <select name="reintegro" id="reintegro" required>
                                                                    <option value="">
                                                                        * Controla reintegro
                                                                    </option>
                                                                    <option value="1">Sí</option>
                                                                    <option value="0">No</option>
                                                                </select>

                                                            </label>
                                                        </td>
                                                        <?php
                              }
                              ?>

                                                        <td>
                                                            {!! Form::hidden('correoNotificacion', $DatosSolicitud[0]->email_notificacion) !!}
                                                            {!! Form::submit('Cerrar', ['class' => 'button', 'style' => 'background-color: #00763b']) !!}
                                                        </td>
                                                    </tr>
                                                </table>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                        <?php
          } else { ?>
                        <br>
                        <div class="panel m3">
                            <div class="nano-content">
                                <div class="table-responsive">
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr>
                                                <th style="background-color:#2B547E; color:#ffffff; text-align:left;">
                                                    Cerrar Ticket
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                    {!! Form::open([
                                        'action' => 'Requerimientos\AtenderRequerimientosPanelController@AtenderCerrarNotificacion',
                                        'class' => 'form',
                                        'id' => 'form-wizard',
                                        'files' => true,
                                    ]) !!}
                                    {!! Form::hidden('solicitud', $DatosSolicitud[0]->num_solicitud) !!}
                                    {!! Form::hidden('grupo', $DatosSolicitud[0]->grupo) !!}
                                    {!! Form::hidden('aplreintegro', $nomgrupo[0]->reintegro) !!}

                                    <table id="message-table" class="table allcp-form">
                                        <tr>
                                            <th style="background-color: #8e949e; color:#ffffff; text-align:left;"
                                                width="400">
                                                Cerrar (Enviar notificación al Usuario Para Cerrar el Caso)
                                            </th>
                                            <td>
                                                {!! Form::hidden('correoNotificacion', $DatosSolicitud[0]->email_notificacion) !!}
                                                {!! Form::submit('Cerrar', ['class' => 'button', 'disabled' => 'true', 'style' => 'background-color: #00763b']) !!}
                                            </td>
                                        </tr>
                                    </table>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <?php
          }
          //}
          ?>


                        <br>

                        <div class="panel m3">
                            <div class="nano-content">
                                <div class="table-responsive">

                                    <!-- AGREGAR INFORMACIÓN -->
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr>
                                                <th style="background-color:#2B547E; color:#ffffff; text-align:left;">
                                                    Agregar información
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                    {!! Form::open([
                                        'action' => 'Requerimientos\MisRequerimientosPanelController@InformacionAgregarDB',
                                        'class' => 'form',
                                        'id' => 'form-wizard',
                                        'files' => true,
                                    ]) !!}
                                    {!! Form::hidden('solicitud', $DatosSolicitud[0]->num_solicitud) !!}
                                    {!! Form::hidden('titulo_solicitud', $DatosSolicitud[0]->descripcion) !!}
                                    {!! Form::hidden('grupo', $DatosSolicitud[0]->grupo) !!}
                                    {!! Form::hidden('ruta', '/panel/requerimientos/atender/procesar/') !!}

                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <tr>
                                            <td width="800">
                                                <label class="field prepend-icon">
                                                    {!! Form::textarea('descripcion', '', [
                                                        'cols' => 4,
                                                        'required',
                                                        'id' => 'descripcion',
                                                        'class' => 'gui-input',
                                                        'style' => 'height: 45px;',
                                                        'placeholder' => '* Ingrese aquí la información adicional al requerimiento, sea breve y puntual.',
                                                    ]) !!}
                                                    <label for="username" class="field-icon">
                                                        <i class="fa fa-reorder"></i>
                                                    </label>
                                                </label>
                                            </td>
                                            <td style="color:#34495e; text-align:right;" width="200">
                                                <label class="field prepend-icon append-button file">
                                                    <span class="button" style="background-color: #8e949e;">
                                                        Archivo
                                                    </span>
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
                                                    <label class="field-icon">
                                                        <i class="fa fa-cloud-upload"></i>
                                                    </label>
                                                </label>
                                            </td>

                                            <td>
                                                {!! Form::hidden('correoNotificacion', $DatosSolicitud[0]->email_notificacion) !!}
                                                {!! Form::submit('Adicionar información', ['class' => 'my-button-2']) !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><br /></td>
                                        </tr>
                                    </table>
                                    {!! Form::close() !!}
                                    <!-- AGREGAR INFORMACIÓN -->

                                    <!-- SEGUIMIENTO -->
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr style="background-color:#2B547E; color:#ffffff">
                                                <th>
                                                    Seguimiento
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <table id="message-table" class="table allcp-form theme-warning br-t"
                                        border="1" style="border-color:#2B547E">
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
                                                            style="text-align:left; background-color:#FFFFFF; color: black;">
                                                            Descripción
                                                        </th>
                                                        <th
                                                            style="text-align:center; background-color:#FFFFFF; color: black;">
                                                            Adjunto
                                                        </th>
                                                        <th
                                                            style="text-align:center; background-color:#FFFFFF; color: black;">
                                                            Fecha y hora
                                                        </th>
                                                        <th
                                                            style="text-align:center; background-color:#FFFFFF; color: black;">
                                                            Colaborador
                                                        </th>
                                                    </tr>

                                                    <?php
                                                    $Seguimientos = PanelSolicitudes::getSolicitudes($DatosSolicitud[0]->num_solicitud);
                                                    $e = 1;
                                                    $numModal = 0;
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
                                                                if ($DatSeg->cierre == 1) {
                                                                    $ColorFont = '#00763b';
                                                                }

                                                                if ($DatSeg->rechazo == 1) {
                                                                    $ColorFont = '#d9480f';
                                                                }

                                                                if ($DatSeg->rechazo == 0 && $DatSeg->cierre == 0) {
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
                                                                <?php if (($ext1 == 'jpg') || ($ext1 == 'png') || ($ext1 == 'gif') || ($ext1 == 'JPG') || ($ext1 == 'PNG') || ($ext1 == 'GIF')) { ?>
                                                                <button type="button" style="background:#e5eaee;"
                                                                    class="btn btn-default light" data-toggle="modal"
                                                                    data-target="#myModal<?= $numModal ?>"
                                                                    title="Descargar">
                                                                    <i class="fa <?= $icono ?> fa-lg"
                                                                        style="color:#<?= $fonicono ?>;"></i>
                                                                </button>

                                                                <?php } else { ?>
                                                                <button type="button" style="background:##e5eaee;"
                                                                    class="btn btn-default light"
                                                                    onclick="window.open('<?= $server ?>/archivos/Requerimientos/<?= $nombrearc . '?' . date('i:s') ?>','_blank')"
                                                                    title="Descargar">
                                                                    <i class="fa <?= $icono ?> fa-lg"
                                                                        style="color:#<?= $fonicono ?>;"></i>
                                                                </button>
                                                                <?php }
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
                                                        <?php $numModal++; ?>
                                                    @endforeach
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- SEGUIMIENTO -->

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
        <!-- Modal -->
        <?php $numModalD = 0; ?>
        @foreach ($Seguimientos as $DatSegD)
            <?php $nombrearcD = $DatSegD->archivo; ?>
            <div class="modal fade" id="myModal<?= $numModalD ?>" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">

                            <img class="img-responsive" style="margin:0 auto;"
                                src="http://192.168.1.210<?= $server ?>/archivos/Requerimientos/<?= $nombrearcD ?>"
                                alt="">

                        </div>

                    </div>

                </div>
            </div>
            <?php $numModalD++; ?>
        @endforeach
        <!-- -------------- Scripts -------------- -->

        <!-- -------------- jQuery -------------- -->
        {{-- <script src="<?= $server ?>/panelfiles/assets/js/jquery/jquery-1.11.3.min.js"></script>
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> --}}

        @include('includes-CDN/include-script')


        <script type="module">
            import {
                configureSelect2
            } from "/Berhlan/public/js/select2.js";

            $(document).ready(function($) {
                configureSelect2();
                // Obtener la ruta anterior del localStorage
                const rutaAnterior = localStorage.getItem('rutaAnterior');
                // Obtener la URL del servidor desde PHP
                const server = '<?php echo $server; ?>';

                // Construir la URL completa
                const urlCompleta = `${server}/panel/requerimientos/atender${rutaAnterior}`;

                // Asignar la URL al atributo href del enlace
                document.getElementById('regresar').setAttribute('href', urlCompleta);
            });
        </script>
    </body>

    </html>
@endforeach
