<?php

use App\Models\Requerimientos\PanelGrupos;
use App\Models\Requerimientos\PanelSolicitudes;
use App\Models\Requerimientos\PanelCategorias;
use App\Models\Requerimientos\PanelPriorizaciones;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Parametrizacion\PanelCargos;
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
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/skin/default_skin/css/theme.css">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.css')}}">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css')}}">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="{{ asset ('/panelfiles/assets/img/favicon.ico')}}">

        <!-- Editor -->
        <script type="text/javascript" src="{{ asset ('/panelfiles/ckeditor/ckeditor.js')}}"></script>

         <link rel="stylesheet" type="text/css" href="{{ asset ('/public/css/requerimientos/panel-misrequerimientos.blade.css')}}">


        <script language="JavaScript">
            //<!--

            function infoEmpleado(texto) {
                Swal.fire({
                    icon: 'info',
                    title: "<i>Información Empleado Asignado</i>",
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
                    text: "Modal with a custom image.",
                    imageUrl: imagen,
                    imageWidth: 800,
                    imageHeight: 600,
                    imageAlt: "Custom image"
                });
            }
            //-->
        </script>

        <!-- Ajax -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

        <script language="JavaScript">
            function MostrarDiv(valor) {
                if (valor.value != 0) {
                    $('#notificaciones').html('<div class="col-md-6">' +
                        '<br>' +
                        '<label style="color: #34495e">' +
                        '<b>' +
                        'Información de Notificación' +
                        '</b>' +
                        '</label>' +
                        '<label class="field">' +
                        '<label style="color: #444444">' +
                        'Email' +
                        '</label>' +
                        '<label class="field prepend-icon">' +
                        '{!! Form::email('email_notificacion', null, [
                            'required',
                            'id' => 'email_notificacion',
                            'class' => 'gui-input',
                            'placeholder' => ' * Email',
                        ]) !!}' +
                        '<label for="username" class="field-icon">' +
                        '<i class="fa fa-envelope"></i>' +
                        '</label>' +
                        '</label>' +
                        '</label>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<br><br><br>' +
                        '<label class="fieldt">' +
                        '<label style="color: #444444">' +
                        'Celular (WhatsApp)' +
                        '</label>' +
                        '<label class="field prepend-icon">' +
                        '{!! Form::text('cel_notificacion', null, [
                            'required',
                            'id' => 'cel_notificacion',
                            'class' => 'gui-input',
                            'placeholder' => '* Celular (WhatsApp)',
                        ]) !!}' +
                        '<label for="username" class="field-icon">' +
                        '<i class="fa fa-phone"></i>' +
                        '</label>' +
                        '</label>' +
                        '</label>' +
                        '</div>');
                } else {
                    $('#notificaciones').html('{!! Form::hidden('email_notificacion', null, [
                        'id' => 'email_notificacion',
                        'class' => 'gui-input',
                        'placeholder' => ' * Email',
                    ]) !!}' +
                        '{!! Form::hidden('cel_notificacion', null, [
                            'id' => 'cel_notificacion',
                            'class' => 'gui-input',
                            'placeholder' => '* Celular (WhatsApp)',
                        ]) !!}');
                }

            }
        </script>
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
                                <a href="{{ asset ('/panel/menu/4')}}" title="Requerimientos">
                                    <font color="#34495e">
                                        Requerimientos >
                                    </font>
                                    <font color="#b4c056">
                                        Mis requerimientos
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset ('/panel/menu/4')}}" class="btn btn-primary btn-sm ml10"
                            title="Requerimientos">
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

                                    <?php
                $idEmpleado =  $DatosUsuario[0]->empleado;
                $CantRerParaCerrar = PanelSolicitudes::getSolicitudesAbiertasUsuario($idEmpleado);

                if ($CantRerParaCerrar == 0) { ?>
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr>
                                                <th style="background-color:#2B547E; color:#ffffff; text-align:left;">
                                                    Nuevo requerimiento
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="allcp-form">
                                                        {!! Form::open([
                                                            'action' => 'Requerimientos\MisRequerimientosPanelController@SolicitudAgregarDB',
                                                            'class' => 'form',
                                                            'id' => 'form-wizard',
                                                            'files' => true,
                                                        ]) !!}
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Cordial saludo, requiero
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::textarea('descripcion', '', [
                                                                        'required',
                                                                        'id' => 'descripcion',
                                                                        'class' => 'gui-input',
                                                                        'style' => 'height: 130px; resize: vertical;',
                                                                        'placeholder' => '* Ingrese aquí su necesidad, sea breve y puntual.
                                                                                                      Ejemplos:
                                                                                                      (-) Ayuda con la impresora de hipoclorito que se encuentra atascada.
                                                                                                      (-) Toma corriente de cosméticos no tiene energía.
                                                                                                      (-) Reestabler contraseña de SIESA para el usuario JUAN.PEREZ que la olvidó.',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-reorder"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="section">
                                                                <div class="col-md-6">
                                                                    <div class="col-md-12">
                                                                        <label style="color: #34495e">
                                                                            <strong>Archivos Adjunto | (Word, Excel,
                                                                                PDF, Imagen)</strong><br />
                                                                            <span style="color: #e03131;">* Puede subir
                                                                                varios de ser
                                                                                necesario</span><br /><br />
                                                                        </label>
                                                                        <label
                                                                            class="field prepend-icon append-button file">
                                                                            <span class="button"
                                                                                style="background-color: #8e949e;">
                                                                                Archivo
                                                                            </span>
                                                                            {!! Form::file('files[]', [
                                                                                '',
                                                                                'id' => 'files[]',
                                                                                'accept' => '.docx, .doc, .xls, .xlsx, .pdf, .jpg, .jpeg, .gif, .png',
                                                                                'class' => 'gui-file',
                                                                                'multiple',
                                                                                'onChange' => "document.getElementById('uploader1').value = this.value;",
                                                                            ]) !!}
                                                                            {!! Form::text('uploader1', null, [
                                                                                'id' => 'uploader1',
                                                                                'class' => 'gui-input',
                                                                                'placeholder' => 'Adjunte un archivo de ser necesario (Word, Excel, PDF, Imagen)',
                                                                            ]) !!}
                                                                            <label class="field-icon">
                                                                                <i class="fa fa-cloud-upload"></i>
                                                                            </label>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">

                                                                    <!-- NOTIFICACIÓN -->
                                                                    <div id="notificaciones">
                                                                        <div class="col-md-6">
                                                                            <br>
                                                                            <label style="color: #34495e">
                                                                                <b>
                                                                                    Información de Notificación
                                                                                </b>
                                                                            </label>
                                                                            <label class="field">
                                                                                <label style="color: #444444">
                                                                                    Email
                                                                                </label>
                                                                                <label class="field prepend-icon">
                                                                                    {!! Form::email('email_notificacion', null, [
                                                                                        'required' => 'true',
                                                                                        'id' => 'email_notificacion',
                                                                                        'class' => 'gui-input',
                                                                                        'placeholder' => ' * Email',
                                                                                    ]) !!}
                                                                                    <label for="username"
                                                                                        class="field-icon">
                                                                                        <i class="fa fa-envelope"></i>
                                                                                    </label>
                                                                                </label>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <br><br><br>
                                                                            <label class="fieldt">
                                                                                <label style="color: #444444">
                                                                                    Celular (WhatsApp)
                                                                                </label>
                                                                                <label class="field prepend-icon">
                                                                                    {!! Form::text('cel_notificacion', null, [
                                                                                        'required' => 'true',
                                                                                        'id' => 'cel_notificacion',
                                                                                        'class' => 'gui-input',
                                                                                        'placeholder' => '* Celular (WhatsApp)',
                                                                                    ]) !!}
                                                                                    <label for="username"
                                                                                        class="field-icon">
                                                                                        <i class="fa fa-phone"></i>
                                                                                    </label>
                                                                                </label>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <!-- NOTIFICACIÓN -->

                                                                    <div class="col-md-6">
                                                                        <br>
                                                                        <label style="color: #34495e">
                                                                            <b>
                                                                                Requerimiento dirigido a
                                                                            </b>
                                                                        </label>
                                                                        <label class="field select">
                                                                            <select name="grupo" id="grupo"
                                                                                required>
                                                                                <option value="">* Grupo</option>
                                                                                <?php
                                                                                $Grupos = PanelGrupos::getGruposActivos();
                                                                                ?>
                                                                                @foreach ($Grupos as $DatGru)
                                                                                    <option
                                                                                        value="<?= $DatGru->id_grupo ?>">
                                                                                        <?= $DatGru->descripcion ?>
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <i class="arrow"></i>
                                                                        </label>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <br><br><br>
                                                                        {!! Form::submit('Crear', ['class' => 'my-button', 'style' => 'color: #ffffff']) !!}
                                                                    </div>
                                                                </div>



                                                            </div>
                                                        </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <?php } else { ?>
                                    <div style="padding: 10px 10px 10px 10px;">
                                        <span style="color: #000000; font-size: 18px">Para crear un nuevo Ticket <span
                                                style="color: #bf616a"><strong> debe primero cerrar </strong></span>,
                                            los tickets (<span
                                                style="color: #bf616a"><strong><?= $CantRerParaCerrar ?></strong></span>)
                                            pendientes de cierre.</span>
                                        <br />
                                    </div>
                                    <?php } ?>


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
                                            <tr style="background-color:#2B547E; color: #ffffff">
                                                <th>
                                                    Mis requerimientos
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <font size="1">
                                                        ( Abiertos &nbsp;&nbsp;-&nbsp;&nbsp; Cerrados en los últimos 20
                                                        días )
                                                    </font>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tr>
                                            <td colspan="2">
                                                <table id="message-table"
                                                    class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                    <thead>
                                                        <tr style="background-color: #F8F8F8; color:#000000">
                                                            <th style="text-align:left">
                                                                #
                                                            </th>
                                                            <th style="text-align:right">
                                                                Req.
                                                            </th>
                                                            <th style="text-align: center">
                                                                Grupo
                                                            </th>
                                                            <th style="text-align: center">
                                                                Solicitud
                                                            </th>
                                                            <th style="text-align: center">
                                                                Archivo
                                                            </th>
                                                            <th style="text-align: center">
                                                                Fecha
                                                            </th>
                                                            <th style="text-align: center">
                                                                Estado
                                                            </th>
                                                            <th style="text-align: center">
                                                                Categoría
                                                            </th>
                                                            <th style="text-align: center">
                                                                Tiempo esperado
                                                                <br>
                                                                de respuesta
                                                            </th>
                                                            <th style="text-align: center">
                                                                Asignado
                                                            </th>
                                                            <th style="text-align: center">
                                                                Fecha de cierre
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
                                                        $fechaanterior = date('Y-m-d', strtotime('-20 days')); // 20 días antes
                                                        $DatosSolicitudes = PanelSolicitudes::getSolicitudes20dias($DatLog->empleado, $fechaanterior);
                                                        ?>

                                                        @foreach ($DatosSolicitudes as $DatSol)
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
                                                                    <font color="#2A2F43">
                                                                        <b>
                                                                            <?= $DatSol->num_solicitud ?>
                                                                            <?php
                                  if ($DatSol->fecha_propuesta_cierre != '' && ($DatSol->estado == 1 || $DatSol->estado == 2)) { ?>
                                                                            <br />
                                                                            <span style="color: #e03131;">Ticket
                                                                                Pendiente de Cierre</span>
                                                                            <?php }
                                  ?>
                                                                        </b>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        $nombreg = PanelGrupos::NombreGrupo($DatSol->grupo);
                                                                        echo $nombreg[0]->descripcion;
                                                                        ?>
                                                                    </font>
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
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        if ($DatSol->archivo == '') {
                                                                            echo 'No';
                                                                        } else {
                                                                            echo 'Sí';
                                                                        }
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?= $O_Util->fecha_texto_hora($DatSol->fecha_solicita) ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        $estado = $DatSol->estado;
                                                                        if ($estado == 1) {
                                                                            echo 'Pendiente de asignaci&oacute;n';
                                                                        } elseif ($estado == 2) {
                                                                            echo 'Asignado, en proceso';
                                                                        } elseif ($estado == 3) {
                                                                            echo "<font color=\"blue\">Atendido, pendiente encuesta de satisfacci&oacute;n</font>";
                                                                        } elseif ($estado == 4) {
                                                                            echo "<font color=\"blue\">Finalizado</font>";
                                                                        }
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        if ($DatSol->categoria == '0') {
                                                                            echo 'Pendiente';
                                                                        } else {
                                                                            $categ = PanelCategorias::getCategoria($DatSol->categoria);
                                                                            echo $categ[0]->descripcion;
                                                                        }
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                if ($DatSol->categoria == '0') {
                                  echo "Pendiente";
                                } else if ($DatSol->depende_de == 'T') {
                                  echo "Indefinido (Depende de terceros)";
                                } else if ($DatSol->depende_de == 'P') {
                                  echo "Indefinido (Proyecto)";
                                } else {
                                  $Prioridad = PanelPriorizaciones::getCriterio($categ[0]->criticidad);
                                  $Valor     = PanelPriorizaciones::getTiempo($DatSol->grupo, $Prioridad[0]->id_criterio);
                                ?>
                                                                        <button type="button"
                                                                            style="text-align:left; cursor:default; outline:none; width:110px; "
                                                                            tabindex="-1"
                                                                            class="btn btn-default light">
                                                                            <b>
                                                                                <label for="username"
                                                                                    class="field-icon">
                                                                                    <i class="fa fa-exclamation-triangle fa-1x"
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
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <?php
                              if ($DatSol->usr_cierre != 0) {
                                $empleado = PanelEmpleados::getEmpleado($DatSol->usr_cierre);

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
                                                                    <font color="#2A2F43">
                                                                        <?= $NomEmpleado ?><br /><?= $ApeEmpleado ?>
                                                                    </font>
                                                                    <?php
                              } else { ?>
                                                                    <button type="button"
                                                                        class="btn btn-default light" disabled>
                                                                        <i class="fa fa-user fa-lg"
                                                                            style="color:#269ec5;"></i>&nbsp;
                                                                    </button>
                                                                    <br />
                                                                    <font color="#2A2F43"> Pendiende por Asignar
                                                                    </font>
                                                                    <?php }  ?>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?= $DatSol->fecha_cierre ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align: center">
                                                                    <button type="button"
                                                                        class="btn btn-default light"
                                                                        onclick="window.location.href='{{ asset ('/panel/requerimientos/misrequerimientos/masinfo/<?= $DatSol->num_solicitud ?>'"
                                                                        title="Más información">
                                                                        <?php
                                                                        if ($estado > 2) {
                                                                            echo '<div>';
                                                                        }
                                                                        ?>
                                                                        <i class="fa fa-plus fa-lg"
                                                                            style="color:#67d3e0;"></i>
                                                                        <?php
                                                                        if ($estado > 2) {
                                                                            echo '</div>';
                                                                        }
                                                                        ?>
                                                                    </button>
                                                                </td>
                                                            </tr>
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
        <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js')}}"></script>

        <!-- -------------- JvectorMap Plugin -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js')}}"></script>

        <!-- -------------- HighCharts Plugin -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/plugins/highcharts/highcharts.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/plugins/c3charts/d3.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.js')}}"></script>

        <!-- -------------- Theme Scripts -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/utility/utility.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/demo/demo.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/main.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/pages/allcp_forms-elements.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/demo/widgets_sidebar.js')}}"></script>

        <!-- -------------- Page JS -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/demo/charts/highcharts.js')}}"></script>

        <!-- -------------- /Scripts -------------- -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
