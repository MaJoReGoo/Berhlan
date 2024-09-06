<?php
$server = '/Berhlan/public';
$urlCompleta = $_SERVER['REQUEST_URI'];

use App\Models\Requerimientos\PanelGrupos;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Requerimientos\PanelCategorias;
use App\Models\Requerimientos\PanelPriorizaciones;
use App\Models\Requerimientos\PanelSolicitudes;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>

            <?php
            $r = 0;
            ?>
            @foreach ($DatosSolicitudes as $DatSol)
                <?php
                if ($DatSol->categoria == '0') {
                    $r++;
                }
                ?>
            @endforeach

            Intranet <?php
            if ($r > 0) {
                echo '(' . $r . ')';
            }
            ?> | Requerimientos | Atender
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
        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/skin/default_skin/css/theme.css">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/allcp/forms/css/forms.min.css">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="<?= $server ?>/panelfiles/assets/img/favicon.ico">

        <!-- -------------- DataTables -------------- -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">

        <script src="<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.min.js"></script>

        <link rel="stylesheet" href="<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.css">

        <!-- Sweetalert -->
        <script src="https://<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.min.js"></script>
        <link rel="stylesheet" href="https://<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.css">

        <script language="JavaScript">
            //<!--

            function infoEmpleado(texto) {
                Swal.fire({
                    icon: 'info',
                    title: "<i>Información del Solicitante</i>",
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

            function cambiarGrupo() {
                var myElement = document.getElementById('grupoSel');
                var grupo = myElement.value;
                location = 'https://192.168.1.210<?= $server ?>/panel/requerimientos/atender/listado/' + grupo;
            }

            function cambiarCategoria() {
                var myElement = document.getElementById('categoriaSel');
                var categoria = myElement.value;
                location = 'https://192.168.1.210<?= $server ?>/panel/requerimientos/atender/listado-categoria/<?= $Grupo ?>/' +
                    categoria;
            }
            //-->
        </script>
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
                                $nomgrupo = PanelGrupos::getGrupo($Grupo);
                                ?>
                                <a href="<?= $server ?>/panel/requerimientos/atender" id="retorno" title="Requerimientos > Atender">
                                    <font color="#34495e">
                                        Requerimientos > Grupo
                                        <?= $nomgrupo[0]->descripcion ?> >
                                    </font>
                                    <font color="#b4c056">
                                        Atender
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="javascript:history.back()" class="btn btn-primary btn-sm ml10" id = "regresar"
                            title="Requerimientos > Atender">
                            REGRESAR &nbsp;
                            <span class="fa fa-arrow-left"></span>
                        </a>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="<?= $server ?>/panel/requerimientos/atender/listado/<?= $Grupo ?> " id="requerimientos"
                            class="btn btn-primary btn-sm ml10" id = "regresar" title="Requerimientos > Atender">
                            Requirimientos &nbsp;
                            <i class="fa fa-cogs" aria-hidden="true"></i>
                        </a>
                    </div>
                    <!-- -------------- /Topbar -------------- -->

                    <!-- -------------- Content -------------- -->
                    <br>
                    <?php
                    $totalreq = 0;
                    $porcatg = 0;
                    $criticos = 0;
                    $altos = 0;
                    $medios = 0;
                    $bajos = 0;
                    $terceros = 0;
                    $proyectos = 0;
                    $notificados = 0;
                    $todos = 0;

                    ?>
                    @php
                        if (isset($DatosSolicitudesAbiertas)) {
                            $SoliAbiertas = count($DatosSolicitudesAbiertas);
                        }

                    @endphp
                    @foreach ($DatosSolicitudes as $DatSol)
                        <?php
                        $totalreq++;
                        if ($DatSol->categoria != '0') {
                            $crt = PanelCategorias::getCategoria($DatSol->categoria);
                            if ($crt[0]->criticidad == 1 && $DatSol->depende_de == '') {
                                $criticos++;
                            } elseif ($crt[0]->criticidad == 2 && $DatSol->depende_de == '') {
                                $altos++;
                            } elseif ($crt[0]->criticidad == 3 && $DatSol->depende_de == '') {
                                $medios++;
                            } elseif ($crt[0]->criticidad == 4 && $DatSol->depende_de == '') {
                                $bajos++;
                            }

                            if ($DatSol->depende_de == 'T') {
                                $terceros++;
                            } elseif ($DatSol->depende_de == 'P') {
                                $proyectos++;
                            }
                        } else {
                            $porcatg++;
                        }

                        if ($DatSol->notificacion_cierre == 1) {
                            $notificados++;
                        }
                        ?>
                    @endforeach

                    <br>

                    <div class="chute chute-center pt0">
                        <!-- -------------- Column Center -------------- -->
                        <div class="panel m3">
                            <div class="table-responsive">
                                <table class="table allcp-form theme-warning br-t">

                                    <tr style="color:#000000;">

                                        <th style="text-align:center;">
                                            Por Categorizar
                                        </th>
                                        <th style="text-align:center;;">
                                            Críticos
                                        </th>
                                        <th style="text-align:center;">
                                            Altos
                                        </th>
                                        <th style="text-align:center;">
                                            Medios
                                        </th>
                                        <th style="text-align:center;">
                                            Bajos
                                        </th>
                                        <th style="text-align:center;">
                                            Terceros
                                        </th>
                                        <th style="text-align:center;">
                                            Proyectos
                                        </th>
                                        <th style="text-align:center;">
                                            Abiertos
                                        </th>
                                        <th style="text-align:center;">
                                            Notificados
                                        </th>
                                        <th style="text-align:center;" >
                                            Todos
                                        </th>
                                    </tr>

                                    <tr style="color:#000000;">
                                        <th style="text-align:center; background-color: #ced4da;">
                                            <i class="fa fa-check-square-o fa-xl" style="color:#2B547E;">
                                                <?= $porcatg ?></i>
                                        </th>
                                        <th style="text-align:center; background-color: #ced4da;">
                                            <i class="fa fa-check-square-o fa-xl" style="color:#2B547E;;">

                                                <?= $criticos ?></i>
                                        </th>
                                        <th style="text-align:center; background-color: #ced4da;">
                                            <i class="fa fa-check-square-o fa-xl" style="color:#2B547E;">
                                                <?= $altos ?></i>
                                        </th>
                                        <th style="text-align:center; background-color: #ced4da;">
                                            <i class="fa fa-check-square-o fa-xl" style="color:#2B547E;">
                                                <?= $medios ?></i>
                                        </th>
                                        <th style="text-align:center; background-color: #ced4da;">
                                            <i class="fa fa-check-square-o fa-xl" style="color:#2B547E;">
                                                <?= $bajos ?></i>
                                        </th>
                                        <th style="text-align:center; background-color: #ced4da;">
                                            <i class="fa fa-check-square-o fa-xl" style="color:#2B547E;">
                                                <?= $terceros ?></i>
                                        </th>
                                        <th style="text-align:center; background-color: #ced4da;">
                                            <i class="fa fa-check-square-o fa-xl" style="color:#2B547E;">
                                                <?= $proyectos ?></i>
                                        </th>

                                        <th style="text-align:center;">
                                            <?php
                                        if (isset($idus)) { ?>
                                            <a class="reset"
                                                href="<?= $server ?>/panel/requerimientos/atender/listado-persona/<?= $Grupo ?>/<?= $idus ?>">
                                                <i class="fa fa-check-square-o fa-xl" style="color:#ff3300;">
                                                    <?= $totalreq - $notificados ?></i>

                                            </a>
                                            <?php } ?>

                                            <?php

                                        if (!isset($idus) && !isset($categoria)&& !isset($DatosSolicitudesAbiertas) ) { ?>

                                            <a class="reset"
                                                href="<?= $server ?>/panel/requerimientos/atender/listado/<?= $Grupo ?> ">
                                                <i class="fa fa-check-square-o fa-xl" style="color:#ff3300;">
                                                    <?= $totalreq - $notificados ?></i>

                                            </a>
                                            <?php } ?>

                                            <?php

                                        if (!isset($idus) && !isset($categoria) && isset($DatosSolicitudesAbiertas)) { ?>

                                            <a class="reset"
                                                href="<?= $server ?>/panel/requerimientos/atender/listado/<?= $Grupo ?> ">
                                                <i class="fa fa-check-square-o fa-xl" style="color:#ff3300;">
                                                    <?= $SoliAbiertas - $notificados ?></i>

                                            </a>
                                            <?php } ?>
                                        </th>

                                        <th style="text-align:center;">
                                            <?php
                    if (isset($idus)) { ?>
                                            <a class="reset"
                                                href="<?= $server ?>/panel/requerimientos/atender/listado-persona-notificado/<?= $Grupo ?>/<?= $idus ?>">
                                                <i class="fa fa-check-square-o fa-xl" style="color:#66a80f;">
                                                    <?= $notificados ?></i>
                                            </a>
                                            <?php }

                    if (isset($categoria)) { ?>
                                            <a class="reset"
                                                href="<?= $server ?>/panel/requerimientos/atender/listado-categoria-notificado/<?= $Grupo ?>/<?= $categoria ?>">
                                                <i class="fa fa-check-square-o fa-xl" style="color:#66a80f;">
                                                    <?= $notificados ?></i>
                                            </a>
                                            <?php }

                    if (!isset($idus) && !isset($categoria) ) { ?>
                                            <a class="reset"
                                                href="<?= $server ?>/panel/requerimientos/atender/listado-notificado/<?= $Grupo ?>">
                                                <i class="fa fa-check-square-o fa-xl" style="color:#66a80f;">
                                                    <?= $notificados ?></i>
                                            </a>
                                            <?php } ?>
                                        </th>
                                        <th style="text-align:center; background-color: #495057; width: 100px;" >
                                            <?php
                    if (isset($idus)) { ?>
                                            <a class="reset"
                                                href="<?= $server ?>/panel/requerimientos/atender/listado-persona-todos/<?= $Grupo ?>/<?= $idus ?>">
                                                <i class="fa fa-check-square-o fa-xl" style="color:#66a80f;">
                                                    <?= $totalreq ?></i>
                                            </a>
                                            <?php }

                    if (isset($categoria)) { ?>
                                            <a class="reset"
                                                href="<?= $server ?>/panel/requerimientos/atender/listado-categoria-todos/<?= $Grupo ?>/<?= $categoria ?>">
                                                <i class="fa fa-check-square-o fa-xl" style="color:#66a80f;">
                                                    <?= $totalreq ?></i>
                                            </a>
                                            <?php }

                    if (!isset($idus) && !isset($categoria) && !isset($DatosSolicitudesAbiertas) ) { ?>
                                            <a class="reset"
                                                href="<?= $server ?>/panel/requerimientos/atender/listado-todos/<?= $Grupo ?>">
                                                <i class="fa fa-check-square-o fa-xl" style="color:#66a80f;">
                                                    <?= $totalreq ?></i>
                                            </a>
                                            <?php }
                                            if (!isset($idus) && !isset($categoria) && isset($DatosSolicitudesAbiertas)
                                            ) { ?>
                                            <a class="reset"
                                                href="<?= $server ?>/panel/requerimientos/atender/listado-todos/<?= $Grupo ?>">
                                                <i class="fa fa-check-square-o fa-xl" style="color:#66a80f;">
                                                    <?= $SoliAbiertas ?></i>
                                            </a>
                                            <?php } ?>
                                        </th>
                                    </tr>

                                    <?php if ($Grupo == 1 && $DatosUsuario[0]->id_usuario == 432) {
                  if ($RequerimientosVencidosCant[0]->NumReqV == 0) {
                    $EstadoBut = ' disabled = "true" ';
                  } else {
                    $EstadoBut = '';
                  }
                ?>
                                    <tr>
                                        <td colspan="10">
                                            {!! Form::open([
                                                'action' => 'Requerimientos\AtenderRequerimientosPanelController@CerrarRequerimientosVencidos',
                                                'class' => 'form',
                                                'id' => 'form-wizard',
                                                'files' => true,
                                            ]) !!}
                                            {!! Form::hidden('grupo', $Grupo) !!}
                                            {!! Form::submit('Cerrar Requerimientos Vencidos ( ' . $RequerimientosVencidosCant[0]->NumReqV . ' ) ', [
                                                'class' => 'button',
                                                $EstadoBut,
                                            ]) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                    <?php }

                $EmpleadoRq = PanelSolicitudes::RequerimientosAsignados($Grupo);
                $r = 0;
                ?>
                                    <tr style="color:#000000;">
                                        @foreach ($EmpleadoRq as $DatEmR)
                                            <th style="text-align:left;" colspan="4">
                                                <?php
                                                $r++;
                                                $empleado = PanelEmpleados::getEmpleado($DatEmR->usr_cierre);

                                                $rqnotificadosus = PanelSolicitudes::cantRequerimientosNotificadosUs($DatEmR->usr_cierre, $Grupo);
                                                $NombreCompleto = $empleado[0]->primer_nombre . ' ' . $empleado[0]->ot_nombre;
                                                $Apellidos = $empleado[0]->primer_apellido . ' ' . $empleado[0]->ot_apellido;
                                                $idEmpleado = $empleado[0]->id_empleado;

                                                print '<a href="' . $server . '/panel/requerimientos/atender/listado-persona/' . $Grupo . '/' . $idEmpleado . '">' . $NombreCompleto . ' ' . $Apellidos . '</a> ';

                                                echo "| <font color='#ff3300'> " . $DatEmR->cant - $rqnotificadosus . "</font>  Abiertos  | <font color='#66a80f'> " . $rqnotificadosus . " </font>  Notificados  | <font color='#444444'> " . $DatEmR->cant . ' </font> Todos ';
                                                echo '</th>';
                                                if ($r % 2 == 0) {
                                                    echo "</tr><tr style=\"color:#000000;\">";
                                                }
                                                ?>
                                        @endforeach
                                        <?php
                                        if ($r % 2 != 0) {
                                            echo "<th colspan=\"4\"></th>";
                                        }
                                        ?>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </header>

                <br>

                <section id="content" class="table-layout animated fadeIn">
                    <div class="chute chute-center pt5">
                        <!-- -------------- Column Center -------------- -->
                        <div class="panel m3">
                            <!-- -------------- Message Body -------------- -->
                            <div class="nano-content">
                                <div class="table-responsive">
                                    <table class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr style="background-color:#2B547E; color: #ffffff">
                                                <th>
                                                    <b id="textoReq">REQUERIMIENTOS</b>
                                                    <font color="#CADB47" id="titulo">
                                                    </font>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tr>
                                            <td>
                                                <table id="message-table"
                                                    class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                    <thead>
                                                        <tr style="background-color: #F8F8F8; color:#000000">
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
                                                                Fecha
                                                            </th>
                                                            <th style="text-align: center">
                                                                Solicitado por
                                                            </th>
                                                            <th style="text-align: center">
                                                                Solicitud
                                                            </th>
                                                            <th style="text-align: center">
                                                                Descripcion
                                                            </th>
                                                            <th style="text-align: center">
                                                                Creado por
                                                            </th>
                                                            <th style="text-align: center">
                                                                Asignado a
                                                            </th>
                                                            <th style="text-align: center">
                                                                Categoría
                                                            </th>
                                                            <th style="text-align: center">
                                                                Más info.
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                        $u = 1;
                                                        $ModalId = 0;
                                                        $urlPartida = explode('/', $urlCompleta);
                                                        ?>
                                                        @foreach ($DatosSolicitudes as $DatSol)
                                                            <!--  Todos Tickets Usuarios y Grupos -->
                                                            <?php if (($urlPartida[6] == 'listado-todos' || $urlPartida[6] == 'listado-persona-todos')) { ?>
                                                            <tr class="message-unread">
                                                                <td style="text-align:left">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        print $u;
                                                                        $u++;
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <button type="button"
                                                                        style="text-align:center; background-color:transparent; cursor:default; outline:none;"
                                                                        tabindex="-1" class="btn btn-default light">
                                                                        <?php
                                  if ($DatSol->categoria != '0') {
                                    $nombrec    = PanelCategorias::getCategoria($DatSol->categoria);
                                    $Criticidad = PanelPriorizaciones::getCriterio($nombrec[0]->criticidad);

                                    if ($DatSol->depende_de == "T") {
                                  ?>
                                                                        <label for="username" class="field-icon"
                                                                            title="Depende de terceros">
                                                                            <i class="fa fa-cog fa-2x"
                                                                                style="color:#9A5B2F; text-shadow: 2px 2px 2px #000;"></i>
                                                                        </label>
                                                                        <?php
                                    } else if ($DatSol->depende_de == "P") {
                                    ?>
                                                                        <label for="username" class="field-icon"
                                                                            title="Proyecto">
                                                                            <i class="fa fa-cog fa-2x"
                                                                                style="color:#E8DAEF; text-shadow: 2px 2px 2px #000;"></i>
                                                                        </label>
                                                                        <?php
                                    } else if ($DatSol->depende_de == "") {
                                    ?>
                                                                        <label for="username" class="field-icon"
                                                                            title="<?= $Criticidad[0]->descripcion ?>">
                                                                            <i class="fa fa-exclamation-triangle fa-2x"
                                                                                style="color:<?= $Criticidad[0]->color ?>; text-shadow: 1px 1px 1px #000;"></i>
                                                                        </label>
                                                                        <?php
                                    }
                                  } else {
                                    ?>
                                                                        <b>
                                                                            Pen.
                                                                        </b>
                                                                        <?php
                                  }
                                  ?>
                                                                    </button>
                                                                </td>

                                                                <td style="text-align:right">
                                                                    <font color="#2A2F43">
                                                                        <b>
                                                                            <?= $DatSol->num_solicitud ?>
                                                                        </b>
                                                                        <?php
                                  if ($DatSol->fecha_propuesta_cierre != '' && ($DatSol->estado == 1 || $DatSol->estado == 2)) { ?>
                                                                        <br />
                                                                        <span style="color: #e03131;">Ticket
                                                                            Notificado</span>
                                                                        <?php } ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?= $DatSol->fecha_solicita ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <?php
                                                                    $empleado = PanelEmpleados::getEmpleado($DatSol->usr_solicita);

                                                                    $cargo = PanelCargos::getCargo($DatSol->cargo_solicitud);
                                                                    $centro = PanelCentrosOp::getCentroOp($DatSol->centro_solicitud);

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
                                                                    <button type="button"
                                                                        class="btn btn-default light"
                                                                        onClick="infoEmpleado('<?= $infoEmpleado ?>')">
                                                                        <i class="fa fa-user fa-lg"
                                                                            style="color:#269ec5;"></i>&nbsp;
                                                                    </button>
                                                                    <br />
                                                                    <font color="#2A2F43" style="font-size: 12px;">
                                                                        <?= $NomEmpleado ?><br /><?= $ApeEmpleado ?>
                                                                    </font>
                                                                    <br />
                                                                    <font style="color: #1F75FE; font-size:11px">
                                                                        <?= $CentroEmpleado ?></font>
                                                                </td>

                                                                <td style="text-align:center;" width="100">
                                                                    <div
                                                                        style="height:100px; width:100%; overflow:auto;">
                                                                        <br />
                                                                        <button type="button"
                                                                            class="btn btn-default light"
                                                                            data-toggle="modal"
                                                                            data-target="#myModal<?= $ModalId ?>"><i
                                                                                class="fa fa-edit fa-2x"
                                                                                style="color: #4682b4"></i>&nbsp;</button>
                                                                        <br />
                                                                        <font color="#2A2F43">Ver + </font>
                                                                    </div>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <?= substr($DatSol->descripcion, 0, 200) ?>...
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        $creadopor = $DatSol->creado_por;
                                                                        if ($creadopor != 0) {
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
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        if ($DatSol->usr_cierre == '0') {
                                                                            echo 'Pendiente';
                                                                        } else {
                                                                            $asignado = PanelEmpleados::getEmpleado($DatSol->usr_cierre);
                                                                            echo $asignado[0]->primer_nombre;
                                                                            echo ' ';
                                                                            echo $asignado[0]->ot_nombre;
                                                                            echo ' ';
                                                                            echo $asignado[0]->primer_apellido;
                                                                            echo ' ';
                                                                            echo $asignado[0]->ot_apellido;
                                                                        }
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:left">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        if ($DatSol->categoria == '0') {
                                                                            echo 'Pendiente';
                                                                        } else {
                                                                            echo $nombrec[0]->descripcion;
                                                                        }
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align: center">
                                                                    <button type="button"
                                                                        class="btn btn-default light posicion"
                                                                        onClick="window.location.href='<?= $server ?>/panel/requerimientos/atender/procesar/<?= $DatSol->num_solicitud ?>'">
                                                                        <i class="fa fa-info-circle fa-2x"
                                                                            style="color: #39a65d"></i>&nbsp;
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                            <!--  Todos Tickets Usuarios y Grupos -->

                                                            <!-- Tickets sin Notificar Usuarios y Grupos -->
                                                            <?php if ($DatSol->notificacion_cierre != 1 && ($urlPartida[6] == 'listado' || $urlPartida[6] == 'listado-persona')) { ?>
                                                            <tr class="message-unread">
                                                                <td style="text-align:left">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        print $u;
                                                                        $u++;
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <button type="button"
                                                                        style="text-align:center; background-color:transparent; cursor:default; outline:none;"
                                                                        tabindex="-1" class="btn btn-default light">
                                                                        <?php
                                  if ($DatSol->categoria != '0') {
                                    $nombrec    = PanelCategorias::getCategoria($DatSol->categoria);
                                    $Criticidad = PanelPriorizaciones::getCriterio($nombrec[0]->criticidad);

                                    if ($DatSol->depende_de == "T") {
                                  ?>
                                                                        <label for="username" class="field-icon"
                                                                            title="Depende de terceros">
                                                                            <i class="fa fa-cog fa-2x"
                                                                                style="color:#9A5B2F; text-shadow: 2px 2px 2px #000;"></i>
                                                                        </label>
                                                                        <?php
                                    } else if ($DatSol->depende_de == "P") {
                                    ?>
                                                                        <label for="username" class="field-icon"
                                                                            title="Proyecto">
                                                                            <i class="fa fa-cog fa-2x"
                                                                                style="color:#E8DAEF; text-shadow: 2px 2px 2px #000;"></i>
                                                                        </label>
                                                                        <?php
                                    } else if ($DatSol->depende_de == "") {
                                    ?>
                                                                        <label for="username" class="field-icon"
                                                                            title="<?= $Criticidad[0]->descripcion ?>">
                                                                            <i class="fa fa-exclamation-triangle fa-2x"
                                                                                style="color:<?= $Criticidad[0]->color ?>; text-shadow: 1px 1px 1px #000;"></i>
                                                                        </label>
                                                                        <?php
                                    }
                                  } else {
                                    ?>
                                                                        <b>
                                                                            Pen.
                                                                        </b>
                                                                        <?php
                                  }
                                  ?>
                                                                    </button>
                                                                </td>

                                                                <td style="text-align:right">
                                                                    <font color="#2A2F43">
                                                                        <b>
                                                                            <?= $DatSol->num_solicitud ?>
                                                                        </b>
                                                                        <?php
                                  if ($DatSol->fecha_propuesta_cierre != '' && ($DatSol->estado == 1 || $DatSol->estado == 2)) { ?>
                                                                        <br />
                                                                        <span style="color: #e03131;">Ticket
                                                                            Notificado</span>
                                                                        <?php } ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?= $DatSol->fecha_solicita ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <?php
                                                                    $empleado = PanelEmpleados::getEmpleado($DatSol->usr_solicita);

                                                                    $cargo = PanelCargos::getCargo($DatSol->cargo_solicitud);
                                                                    $centro = PanelCentrosOp::getCentroOp($DatSol->centro_solicitud);

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
                                                                    <button type="button"
                                                                        class="btn btn-default light"
                                                                        onClick="infoEmpleado('<?= $infoEmpleado ?>')">
                                                                        <i class="fa fa-user fa-lg"
                                                                            style="color:#269ec5;"></i>&nbsp;
                                                                    </button>
                                                                    <br />
                                                                    <font color="#2A2F43" style="font-size: 12px;">
                                                                        <?= $NomEmpleado ?><br /><?= $ApeEmpleado ?>
                                                                    </font>
                                                                    <br />
                                                                    <font style="color: #1F75FE; font-size:11px">
                                                                        <?= $CentroEmpleado ?></font>
                                                                </td>

                                                                <td style="text-align:center;" width="100">
                                                                    <div
                                                                        style="height:100px; width:100%; overflow:auto;">
                                                                        <br />
                                                                        <button type="button"
                                                                            class="btn btn-default light"
                                                                            data-toggle="modal"
                                                                            data-target="#myModal<?= $ModalId ?>"><i
                                                                                class="fa fa-edit fa-2x"
                                                                                style="color: #4682b4"></i>&nbsp;</button>
                                                                        <br />
                                                                        <font color="#2A2F43">Ver + </font>
                                                                    </div>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <?= substr($DatSol->descripcion, 0, 200) ?>...
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        $creadopor = $DatSol->creado_por;
                                                                        if ($creadopor != 0) {
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
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        if ($DatSol->usr_cierre == '0') {
                                                                            echo 'Pendiente';
                                                                        } else {
                                                                            $asignado = PanelEmpleados::getEmpleado($DatSol->usr_cierre);
                                                                            echo $asignado[0]->primer_nombre;
                                                                            echo ' ';
                                                                            echo $asignado[0]->ot_nombre;
                                                                            echo ' ';
                                                                            echo $asignado[0]->primer_apellido;
                                                                            echo ' ';
                                                                            echo $asignado[0]->ot_apellido;
                                                                        }
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:left">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        if ($DatSol->categoria == '0') {
                                                                            echo 'Pendiente';
                                                                        } else {
                                                                            echo $nombrec[0]->descripcion;
                                                                        }
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align: center">
                                                                    <button type="button"
                                                                        class="btn btn-default light posicion"
                                                                        onClick="window.location.href='<?= $server ?>/panel/requerimientos/atender/procesar/<?= $DatSol->num_solicitud ?>'">
                                                                        <i class="fa fa-info-circle fa-2x"
                                                                            style="color: #39a65d"></i>&nbsp;
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                            <!--  Tickets sin Notificar Usuarios y Grupos -->

                                                            <!--  Tickets Notificados Usuarios y Grupos -->
                                                            <?php if ($DatSol->notificacion_cierre == 1 && ($urlPartida[6] == 'listado-notificado' || $urlPartida[6] == 'listado-persona-notificado')) { ?>
                                                            <tr class="message-unread">
                                                                <td style="text-align:left">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        print $u;
                                                                        $u++;
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <button type="button"
                                                                        style="text-align:center; background-color:transparent; cursor:default; outline:none;"
                                                                        tabindex="-1" class="btn btn-default light">
                                                                        <?php
                                  if ($DatSol->categoria != '0') {
                                    $nombrec    = PanelCategorias::getCategoria($DatSol->categoria);
                                    $Criticidad = PanelPriorizaciones::getCriterio($nombrec[0]->criticidad);

                                    if ($DatSol->depende_de == "T") {
                                  ?>
                                                                        <label for="username" class="field-icon"
                                                                            title="Depende de terceros">
                                                                            <i class="fa fa-cog fa-2x"
                                                                                style="color:#9A5B2F; text-shadow: 2px 2px 2px #000;"></i>
                                                                        </label>
                                                                        <?php
                                    } else if ($DatSol->depende_de == "P") {
                                    ?>
                                                                        <label for="username" class="field-icon"
                                                                            title="Proyecto">
                                                                            <i class="fa fa-cog fa-2x"
                                                                                style="color:#E8DAEF; text-shadow: 2px 2px 2px #000;"></i>
                                                                        </label>
                                                                        <?php
                                    } else if ($DatSol->depende_de == "") {
                                    ?>
                                                                        <label for="username" class="field-icon"
                                                                            title="<?= $Criticidad[0]->descripcion ?>">
                                                                            <i class="fa fa-exclamation-triangle fa-2x"
                                                                                style="color:<?= $Criticidad[0]->color ?>; text-shadow: 1px 1px 1px #000;"></i>
                                                                        </label>
                                                                        <?php
                                    }
                                  } else {
                                    ?>
                                                                        <b>
                                                                            Pen.
                                                                        </b>
                                                                        <?php
                                  }
                                  ?>
                                                                    </button>
                                                                </td>

                                                                <td style="text-align:right">
                                                                    <font color="#2A2F43">
                                                                        <b>
                                                                            <?= $DatSol->num_solicitud ?>
                                                                        </b>
                                                                        <?php
                                  if ($DatSol->fecha_propuesta_cierre != '' && ($DatSol->estado == 1 || $DatSol->estado == 2)) { ?>
                                                                        <br />
                                                                        <span style="color: #e03131;">Ticket
                                                                            Notificado</span>
                                                                        <?php } ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?= $DatSol->fecha_solicita ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <?php
                                                                    $empleado = PanelEmpleados::getEmpleado($DatSol->usr_solicita);

                                                                    $cargo = PanelCargos::getCargo($DatSol->cargo_solicitud);
                                                                    $centro = PanelCentrosOp::getCentroOp($DatSol->centro_solicitud);

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
                                                                    <button type="button"
                                                                        class="btn btn-default light"
                                                                        onClick="infoEmpleado('<?= $infoEmpleado ?>')">
                                                                        <i class="fa fa-user fa-lg"
                                                                            style="color:#269ec5;"></i>&nbsp;
                                                                    </button>
                                                                    <br />
                                                                    <font color="#2A2F43" style="font-size: 12px;">
                                                                        <?= $NomEmpleado ?><br /><?= $ApeEmpleado ?>
                                                                    </font>
                                                                    <br />
                                                                    <font style="color: #1F75FE; font-size:11px">
                                                                        <?= $CentroEmpleado ?></font>
                                                                </td>

                                                                <td style="text-align:center;" width="100">
                                                                    <div
                                                                        style="height:100px; width:100%; overflow:auto;">
                                                                        <br />
                                                                        <button type="button"
                                                                            class="btn btn-default light"
                                                                            data-toggle="modal"
                                                                            data-target="#myModal<?= $ModalId ?>"><i
                                                                                class="fa fa-edit fa-2x"
                                                                                style="color: #4682b4"></i>&nbsp;</button>
                                                                        <br />
                                                                        <font color="#2A2F43">Ver + </font>
                                                                    </div>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <?= substr($DatSol->descripcion, 0, 200) ?>...
                                                                    <!-- font color="#2A2F43">
                                < ?php
                                if ($DatSol->archivo == '')
                                  echo "No";
                                else
                                  echo "Sí";
                                ?>
                              </font -->
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        $creadopor = $DatSol->creado_por;
                                                                        if ($creadopor != 0) {
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
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        if ($DatSol->usr_cierre == '0') {
                                                                            echo 'Pendiente';
                                                                        } else {
                                                                            $asignado = PanelEmpleados::getEmpleado($DatSol->usr_cierre);
                                                                            echo $asignado[0]->primer_nombre;
                                                                            echo ' ';
                                                                            echo $asignado[0]->ot_nombre;
                                                                            echo ' ';
                                                                            echo $asignado[0]->primer_apellido;
                                                                            echo ' ';
                                                                            echo $asignado[0]->ot_apellido;
                                                                        }
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:left">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        if ($DatSol->categoria == '0') {
                                                                            echo 'Pendiente';
                                                                        } else {
                                                                            echo $nombrec[0]->descripcion;
                                                                        }
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align: center">
                                                                    <button type="button"
                                                                        class="btn btn-default light posicion"
                                                                        onClick="window.location.href='<?= $server ?>/panel/requerimientos/atender/procesar/<?= $DatSol->num_solicitud ?>'">
                                                                        <i class="fa fa-info-circle fa-2x"
                                                                            style="color: #39a65d"></i>&nbsp;
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                            <!-- Tickets Notificados Usuarios y Grupos -->

                                                            <!-- Tickets sin Notificar Caegoria -->
                                                            <?php if ($DatSol->notificacion_cierre != 1 && $urlPartida[6] == 'listado-categoria') { ?>
                                                            <tr class="message-unread">
                                                                <td style="text-align:left">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        print $u;
                                                                        $u++;
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <button type="button"
                                                                        style="text-align:center; background-color:transparent; cursor:default; outline:none;"
                                                                        tabindex="-1" class="btn btn-default light">
                                                                        <?php
                                  if ($DatSol->categoria != '0') {
                                    $nombrec    = PanelCategorias::getCategoria($DatSol->categoria);
                                    $Criticidad = PanelPriorizaciones::getCriterio($nombrec[0]->criticidad);

                                    if ($DatSol->depende_de == "T") {
                                  ?>
                                                                        <label for="username" class="field-icon"
                                                                            title="Depende de terceros">
                                                                            <i class="fa fa-cog fa-2x"
                                                                                style="color:#9A5B2F; text-shadow: 2px 2px 2px #000;"></i>
                                                                        </label>
                                                                        <?php
                                    } else if ($DatSol->depende_de == "P") {
                                    ?>
                                                                        <label for="username" class="field-icon"
                                                                            title="Proyecto">
                                                                            <i class="fa fa-cog fa-2x"
                                                                                style="color:#E8DAEF; text-shadow: 2px 2px 2px #000;"></i>
                                                                        </label>
                                                                        <?php
                                    } else if ($DatSol->depende_de == "") {
                                    ?>
                                                                        <label for="username" class="field-icon"
                                                                            title="<?= $Criticidad[0]->descripcion ?>">
                                                                            <i class="fa fa-exclamation-triangle fa-2x"
                                                                                style="color:<?= $Criticidad[0]->color ?>; text-shadow: 1px 1px 1px #000;"></i>
                                                                        </label>
                                                                        <?php
                                    }
                                  } else {
                                    ?>
                                                                        <b>
                                                                            Pen.
                                                                        </b>
                                                                        <?php
                                  }
                                  ?>
                                                                    </button>
                                                                </td>

                                                                <td style="text-align:right">
                                                                    <font color="#2A2F43">
                                                                        <b>
                                                                            <?= $DatSol->num_solicitud ?>
                                                                        </b>
                                                                        <?php
                                  if ($DatSol->fecha_propuesta_cierre != '' && ($DatSol->estado == 1 || $DatSol->estado == 2)) { ?>
                                                                        <br />
                                                                        <span style="color: #e03131;">Ticket
                                                                            Notificado</span>
                                                                        <?php } ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?= $DatSol->fecha_solicita ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <?php
                                                                    $empleado = PanelEmpleados::getEmpleado($DatSol->usr_solicita);

                                                                    $cargo = PanelCargos::getCargo($DatSol->cargo_solicitud);
                                                                    $centro = PanelCentrosOp::getCentroOp($DatSol->centro_solicitud);

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
                                                                    <button type="button"
                                                                        class="btn btn-default light"
                                                                        onClick="infoEmpleado('<?= $infoEmpleado ?>')">
                                                                        <i class="fa fa-user fa-lg"
                                                                            style="color:#269ec5;"></i>&nbsp;
                                                                    </button>
                                                                    <br />
                                                                    <font color="#2A2F43" style="font-size: 12px;">
                                                                        <?= $NomEmpleado ?><br /><?= $ApeEmpleado ?>
                                                                    </font>
                                                                    <br />
                                                                    <font style="color: #1F75FE; font-size:11px">
                                                                        <?= $CentroEmpleado ?></font>
                                                                </td>

                                                                <td style="text-align:center;" width="100">
                                                                    <div
                                                                        style="height:100px; width:100%; overflow:auto;">
                                                                        <br />
                                                                        <button type="button"
                                                                            class="btn btn-default light"
                                                                            data-toggle="modal"
                                                                            data-target="#myModal<?= $ModalId ?>"><i
                                                                                class="fa fa-edit fa-2x"
                                                                                style="color: #4682b4"></i>&nbsp;</button>
                                                                        <br />
                                                                        <font color="#2A2F43">Ver + </font>
                                                                    </div>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <?= substr($DatSol->descripcion, 0, 200) ?>...
                                                                    <!-- font color="#2A2F43">
                                < ?php
                                if ($DatSol->archivo == '')
                                  echo "No";
                                else
                                  echo "Sí";
                                ?>
                              </font -->
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        $creadopor = $DatSol->creado_por;
                                                                        if ($creadopor != 0) {
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
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        if ($DatSol->usr_cierre == '0') {
                                                                            echo 'Pendiente';
                                                                        } else {
                                                                            $asignado = PanelEmpleados::getEmpleado($DatSol->usr_cierre);
                                                                            echo $asignado[0]->primer_nombre;
                                                                            echo ' ';
                                                                            echo $asignado[0]->ot_nombre;
                                                                            echo ' ';
                                                                            echo $asignado[0]->primer_apellido;
                                                                            echo ' ';
                                                                            echo $asignado[0]->ot_apellido;
                                                                        }
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:left">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        if ($DatSol->categoria == '0') {
                                                                            echo 'Pendiente';
                                                                        } else {
                                                                            echo $nombrec[0]->descripcion;
                                                                        }
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align: center">
                                                                    <button type="button"
                                                                        class="btn btn-default light posicion"
                                                                        onClick="window.location.href='<?= $server ?>/panel/requerimientos/atender/procesar/<?= $DatSol->num_solicitud ?>'">
                                                                        <i class="fa fa-info-circle fa-2x"
                                                                            style="color: #39a65d"></i>&nbsp;
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                            <!--  Tickets sin Notificar Usuarios y Grupos -->

                                                            <!--  Tickets Notificados Usuarios y Grupos -->
                                                            <?php if ($DatSol->notificacion_cierre == 1 && $urlPartida[6] == 'listado-categoria-notificado') { ?>
                                                            <tr class="message-unread">
                                                                <td style="text-align:left">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        print $u;
                                                                        $u++;
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <button type="button"
                                                                        style="text-align:center; background-color:transparent; cursor:default; outline:none;"
                                                                        tabindex="-1" class="btn btn-default light">
                                                                        <?php
                                  if ($DatSol->categoria != '0') {
                                    $nombrec    = PanelCategorias::getCategoria($DatSol->categoria);
                                    $Criticidad = PanelPriorizaciones::getCriterio($nombrec[0]->criticidad);

                                    if ($DatSol->depende_de == "T") {
                                  ?>
                                                                        <label for="username" class="field-icon"
                                                                            title="Depende de terceros">
                                                                            <i class="fa fa-cog fa-2x"
                                                                                style="color:#9A5B2F; text-shadow: 2px 2px 2px #000;"></i>
                                                                        </label>
                                                                        <?php
                                    } else if ($DatSol->depende_de == "P") {
                                    ?>
                                                                        <label for="username" class="field-icon"
                                                                            title="Proyecto">
                                                                            <i class="fa fa-cog fa-2x"
                                                                                style="color:#E8DAEF; text-shadow: 2px 2px 2px #000;"></i>
                                                                        </label>
                                                                        <?php
                                    } else if ($DatSol->depende_de == "") {
                                    ?>
                                                                        <label for="username" class="field-icon"
                                                                            title="<?= $Criticidad[0]->descripcion ?>">
                                                                            <i class="fa fa-exclamation-triangle fa-2x"
                                                                                style="color:<?= $Criticidad[0]->color ?>; text-shadow: 1px 1px 1px #000;"></i>
                                                                        </label>
                                                                        <?php
                                    }
                                  } else {
                                    ?>
                                                                        <b>
                                                                            Pen.
                                                                        </b>
                                                                        <?php
                                  }
                                  ?>
                                                                    </button>
                                                                </td>

                                                                <td style="text-align:right">
                                                                    <font color="#2A2F43">
                                                                        <b>
                                                                            <?= $DatSol->num_solicitud ?>
                                                                        </b>
                                                                        <?php
                                  if ($DatSol->fecha_propuesta_cierre != '' && ($DatSol->estado == 1 || $DatSol->estado == 2)) { ?>
                                                                        <br />
                                                                        <span style="color: #e03131;">Ticket
                                                                            Notificado</span>
                                                                        <?php } ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?= $DatSol->fecha_solicita ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <?php
                                                                    $empleado = PanelEmpleados::getEmpleado($DatSol->usr_solicita);

                                                                    $cargo = PanelCargos::getCargo($DatSol->cargo_solicitud);
                                                                    $centro = PanelCentrosOp::getCentroOp($DatSol->centro_solicitud);

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
                                                                    <button type="button"
                                                                        class="btn btn-default light"
                                                                        onClick="infoEmpleado('<?= $infoEmpleado ?>')">
                                                                        <i class="fa fa-user fa-lg"
                                                                            style="color:#269ec5;"></i>&nbsp;
                                                                    </button>
                                                                    <br />
                                                                    <font color="#2A2F43" style="font-size: 12px;">
                                                                        <?= $NomEmpleado ?><br /><?= $ApeEmpleado ?>
                                                                    </font>
                                                                    <br />
                                                                    <font style="color: #1F75FE; font-size:11px">
                                                                        <?= $CentroEmpleado ?></font>
                                                                </td>

                                                                <td style="text-align:center;" width="100">
                                                                    <div
                                                                        style="height:100px; width:100%; overflow:auto;">
                                                                        <br />
                                                                        <button type="button"
                                                                            class="btn btn-default light"
                                                                            data-toggle="modal"
                                                                            data-target="#myModal<?= $ModalId ?>"><i
                                                                                class="fa fa-edit fa-2x"
                                                                                style="color: #4682b4"></i>&nbsp;</button>
                                                                        <br />
                                                                        <font color="#2A2F43">Ver + </font>
                                                                    </div>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <?= substr($DatSol->descripcion, 0, 200) ?>...
                                                                    <!-- font color="#2A2F43">
                                < ?php
                                if ($DatSol->archivo == '')
                                  echo "No";
                                else
                                  echo "Sí";
                                ?>
                              </font -->
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        $creadopor = $DatSol->creado_por;
                                                                        if ($creadopor != 0) {
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
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        if ($DatSol->usr_cierre == '0') {
                                                                            echo 'Pendiente';
                                                                        } else {
                                                                            $asignado = PanelEmpleados::getEmpleado($DatSol->usr_cierre);
                                                                            echo $asignado[0]->primer_nombre;
                                                                            echo ' ';
                                                                            echo $asignado[0]->ot_nombre;
                                                                            echo ' ';
                                                                            echo $asignado[0]->primer_apellido;
                                                                            echo ' ';
                                                                            echo $asignado[0]->ot_apellido;
                                                                        }
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:left">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        if ($DatSol->categoria == '0') {
                                                                            echo 'Pendiente';
                                                                        } else {
                                                                            echo $nombrec[0]->descripcion;
                                                                        }
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align: center">
                                                                    <button type="button"
                                                                        class="btn btn-default light posicion"
                                                                        style="display:none;"
                                                                        onClick="window.location.href='<?= $server ?>/panel/requerimientos/atender/procesar/<?= $DatSol->num_solicitud ?>'">
                                                                        <i class="fa fa-info-circle fa-2x"
                                                                            style="color: #39a65d"></i>&nbsp;
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                            <!-- Tickets Notificados Usuarios y Grupos -->
                                                            <?php $ModalId++; ?>
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

        <!-- -------------- DataTables -------------- -->
        <!--  <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

        <script type="module">
            import { datatablesLanguage } from '<?= $server ?>/js/lang/datatables-lang.js';

            $(document).ready(function($) {

                let urlActual = window.location.href;
                let indice = urlActual.indexOf("atender");
                let resto = urlActual.substring(indice + "atender".length);
                localStorage.setItem('rutaAnterior', resto);

                let cortarString = resto.split('/');
                let estadoRequerimiento
                switch (cortarString[1]) {
                    case 'listado':
                        estadoRequerimiento = 'ABIERTOS'
                        break;

                    case 'listado-notificado':
                        estadoRequerimiento = 'NOTIFICADOS'
                        break;

                    case 'listado-todos':
                        estadoRequerimiento = 'TODOS'
                        break;
                    case 'listado-persona':
                        <?php
                        if (isset($idus)) {
                            $empleadoT = PanelEmpleados::getEmpleado($idus);

                            $NombreCompletoT = $empleadoT[0]->primer_nombre . ' ' . $empleadoT[0]->ot_nombre;
                            $ApellidosT = $empleadoT[0]->primer_apellido . ' ' . $empleadoT[0]->ot_apellido;
                        } else {
                            $NombreCompletoT = '';
                            $ApellidosT = '';
                        }
                        ?>
                        $('#textoReq').text('REQUERIMIENTOS DE: ');
                        estadoRequerimiento = '<?= ' ' . $NombreCompletoT . ' ' . $ApellidosT ?>'
                        estadoRequerimiento += ' (ABIERTOS)';
                        break;
                    case 'listado-persona-notificado':
                        <?php
                        if (isset($idus)) {
                            $empleadoN = PanelEmpleados::getEmpleado($idus);

                            $NombreCompletoN = $empleadoN[0]->primer_nombre . ' ' . $empleadoN[0]->ot_nombre;
                            $ApellidosN = $empleadoN[0]->primer_apellido . ' ' . $empleadoN[0]->ot_apellido;
                        } else {
                            $NombreCompletoN = '';
                            $ApellidosN = '';
                        }
                        ?>
                        $('#textoReq').text('REQUERIMIENTOS DE: ');
                        estadoRequerimiento = '<?= ' ' . $NombreCompletoN . ' ' . $ApellidosN ?>';
                        estadoRequerimiento += ' (NOTIFICADOS)';
                        break;
                    case 'listado-persona-todos':
                        <?php
                        if (isset($idus)) {
                            $empleadoA = PanelEmpleados::getEmpleado($idus);

                            $NombreCompletoA = $empleadoA[0]->primer_nombre . ' ' . $empleadoA[0]->ot_nombre;
                            $ApellidosA = $empleadoA[0]->primer_apellido . ' ' . $empleadoA[0]->ot_apellido;
                        } else {
                            $NombreCompletoA = '';
                            $ApellidosA = '';
                        }
                        ?>
                        $('#textoReq').text('REQUERIMIENTOS DE: ');
                        estadoRequerimiento = '<?= ' ' . $NombreCompletoA . ' ' . $ApellidosA ?>';
                        estadoRequerimiento += ' (TODOS)';
                        break;

                }
                $("#titulo").text(estadoRequerimiento);

                let datatable = $('#message-table').DataTable({
                    "order": [
                        [1, "desc"],
                        [8, "desc"],
                        [3, "asc"]
                    ],
                    "language": datatablesLanguage
                });

                if (localStorage.getItem('searchTerm') !== null) {
                    datatable.search(localStorage.getItem('searchTerm')).draw();
                }

                if (localStorage.getItem('page') == null) {
                    let page = datatable.page.info().page;
                    localStorage.setItem("page", page);
                }

                $('#message-table').on('search.dt', function() {
                    localStorage.setItem('searchTerm', datatable.search());
                });

                $('#message-table').on('draw.dt', function() {
                    let anterior = datatable.page.info().page;
                    localStorage.setItem("page", anterior)
                    $('button.btn.btn-default.light.posicion').on('click', function(event) {
                        let posX = window.scrollX;
                        let posY = window.scrollY;
                        localStorage.setItem('X', posX)
                        localStorage.setItem('Y', posY)
                    });
                });

                if (localStorage.getItem('page') !== null) {
                    datatable.page(parseInt(localStorage.getItem('page'))).draw(false);
                }



                $('#regresar').on('click', function() {
                    localStorage.removeItem("page");
                    localStorage.removeItem("X");
                    localStorage.removeItem("Y");
                })

                $('#retorno').on('click', function () {
                    localStorage.removeItem("page");
                    localStorage.removeItem('X')
                    localStorage.removeItem('Y')
                });

                $('a').on('click', function () {
                    localStorage.removeItem("page");
                    localStorage.removeItem('X')
                    localStorage.removeItem('Y')
                });


                $('.reset').on('click', function() {
                    localStorage.removeItem("page");
                    localStorage.removeItem('X')
                    localStorage.removeItem('Y')
                })

                $('#requerimientos').on('click', function() {
                    localStorage.removeItem("page");
                    localStorage.removeItem('X')
                    localStorage.removeItem('Y')
                })


                if (localStorage.getItem('X') !== null && localStorage.getItem('Y') !== null) {
                    window.scrollTo(parseInt(localStorage.getItem('X')), parseInt(localStorage.getItem('Y')));
                }

            });


            window.setInterval("reFresh()", 600000);

            function reFresh() {
                location.reload(true);
            }
        </script>

        <!-- -------------- /Scripts -------------- -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        <!-- -------------- /Scripts -------------- -->

        <?php $ModalId = 0; ?>
        @foreach ($DatosSolicitudes as $DatSol)
            <?php
            $Solicitud = $DatSol->descripcion;
            ?>
            <!-- Modal -->
            <div class="modal fade" id="myModal<?= $ModalId ?>" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Solicitud Requerimiento</h4>
                        </div>
                        <div class="modal-body">
                            <p><?= $Solicitud ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar!!</button>
                        </div>
                    </div>

                </div>
            </div>
            <?php
            $ModalId++;
            ?>
        @endforeach
    </body>

    </html>
@endforeach
