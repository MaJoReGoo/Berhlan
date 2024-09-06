<?php

use App\Models\Parametrizacion\PanelEmpleados;

$Empleado = PanelEmpleados::getEmpleado($MuestraComercial[0]->id_empleado);
$idEmpleado = $Empleado[0]->id_empleado;
$NombreEmpleado = $Empleado[0]->primer_nombre . ' ' . $Empleado[0]->ot_nombre . ' ' . $Empleado[0]->primer_apellido . ' ' . $Empleado[0]->ot_apellido;
$server = '/Berhlan/public';
$FechaHoy = date('Y-m-d');
?>

@foreach($DatosUsuario as $DatLog)
<!DOCTYPE html>
<html>

<head>
    <!-- -------------- Meta and Title -------------- -->
    <meta charset="utf-8">
    <title>
        Intranet | Editar Muestras Comerciales
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

    <!-- -------------- Favicon -------------- -->
    <link rel="shortcut icon" href="<?= $server ?>/panelfiles/assets/img/favicon.ico">

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}

    <script src="https://<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.css">

    <script>
        function eliminar_item_solicitud(id, idmc) {
            Swal.fire({
                title: "Eliminar Solicitud e Items?",
                text: "¿Está seguro de Eliminarla del Sistema?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sí, Eliminar!",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'https://localhost<?= $server ?>/panel/itemmuestracomercial-eliminar/' + id + '/' + idmc;
                }
            });
        }
        //-->
    </script>

    <!-- Select 2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Select 2 -->

    <script language="JavaScript">
        //<!--
        jQuery(document).ready(function($) {
            $("select[name='item']").select2({
                closeOnSelect: true,
                height: 'resolve'
            });
        });
    </script>

    <style>
        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 42px !important;
            user-select: none;
            -webkit-user-select: none;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            visibility: hidden !important;
        }
    </style>

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
                            <a href="<?= $server ?>/noticias/noticias" title="Muestras Comerciales">
                                <font color="#34495e">
                                    Muestras Comerciales >
                                </font>
                                <font color="#b4c056">
                                    Agregar
                                </font>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                    <a href="javascript:history.back()" class="btn btn-primary btn-sm ml10" title="Procesos internos > Documentos">
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
                    <div class="panel m4">
                        <!-- -------------- Message Body -------------- -->
                        <div class="nano-content">
                            <div class="table-responsive">
                                <table class="table allcp-form theme-warning br-t">
                                    <thead>
                                        <tr style="background-color:#67d3e0">
                                            <th style="color:black; text-align:left;">
                                                Ingrese la información de las Muestras Comerciales
                                            </th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="allcp-form">
                                                    {!! Form::open(array('action' => 'MuestrasComerciales\MuestrasComercialesPanelController@MuestrasComercialesModificarItemDB', 'class' => 'form', 'id'=>'form-wizard', 'files' => true)) !!}
                                                    {!! Form::hidden('idmc', $MuestraComercial[0]->id) !!}
                                                    {!! Form::hidden('id', $ItemMuestraComercial[0]->id) !!}
                                                    {!! Form::hidden('marca', $MuestraComercial[0]->marca) !!}

                                                    <!-- Fecha, Empleado -->
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <?php $FechaSolicitud = explode(' ', $MuestraComercial[0]->fecha_solicitud); ?>
                                                            <label style="color: #4ECCDB">Fecha de Solicitud</label>
                                                            <label for="datepicker1" class="field prepend-icon">
                                                                <input type="date" id="fecha_solicitud" name="fecha_solicitud" value="<?= $FechaSolicitud[0] ?>" required style="width: 100%" readonly>
                                                                <label class="field-icon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <?php $FechaEstimada = explode(' ', $MuestraComercial[0]->fecha_estimada_entrega); ?>
                                                            <label style="color: #4ECCDB">Fecha Estimada Entrega</label>
                                                            <label for="datepicker1" class="field prepend-icon">
                                                                <input type="date" id="fecha_entrega" name="fecha_entrega" value="<?= $FechaEstimada[0] ?>" required style="width: 100%" readonly>
                                                                <label class="field-icon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label style="color: #0BACBF">Asesor Comercial / Colaborador *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="empleado" value="<?= $NombreEmpleado ?>" type="text" readonly style="width: 100%">
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-user"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!-- Fecha, Empleado -->


                                                    <!-- Destinatario y Motivo -->
                                                    <div class="row">
                                                        <br />
                                                        <div class="col-md-4">
                                                            <label style="color: #0BACBF">Destinatario *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="destinatario" value="<?= $MuestraComercial[0]->nombre_destinatario ?>" type="text" required style="width: 100%" readonly>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-user"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label style="color: #0BACBF">Cel. Destinatario *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="cel-destinatario" value="<?= $MuestraComercial[0]->celular_destinatario ?>" type="text" required style="width: 100%" readonly>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-phone-square"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <?php
                                                        $Motivo =  $MuestraComercial[0]->motivo;

                                                        switch ($Motivo) {

                                                            case 1:
                                                                $titMotivo = 'Muestras Showroom';
                                                                break;
                                                            case 2:
                                                                $titMotivo = 'Obsequios';
                                                                break;
                                                            case 3:
                                                                $titMotivo = 'Eventos';
                                                                break;
                                                            case 4:
                                                                $titMotivo = 'Muestras Directas Cliente';
                                                                break;
                                                            case 5:
                                                                $titMotivo = 'Muestras Para Comercial';
                                                                break;
                                                            case 6:
                                                                $titMotivo = 'E-Commerce';
                                                                break;
                                                            case 7:
                                                                $titMotivo = 'Muestras Publicidad';
                                                                break;
                                                        }
                                                        ?>
                                                        <div class="col-md-4 form-group">
                                                            <label style="color: #0BACBF">Motivo *</label>
                                                            <label class="field select">
                                                                <select name="motivo" id="motivo" required>
                                                                    <option value="<?= $Motivo ?>"><?= $titMotivo ?></option>
                                                                </select>
                                                                <i class="arrow"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!-- Destinatario y Motivo -->

                                                    <!-- Cliente, Nit y Dirección -->
                                                    <div class="row">
                                                        <br />
                                                        <div class="col-md-3">
                                                            <label style="color: #0BACBF">Razón Social Cliente *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="razon_social" value="<?= $MuestraComercial[0]->nombre_cliente ?>" type="text" style="width: 100%" readonly>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-file"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label style="color: #0BACBF">Nit. Cliente *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="nit" value="<?= $MuestraComercial[0]->nit_cliente ?>" type="text" style="width: 100%" readonly>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-file"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label style="color: #0BACBF">Dirección Cliente *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="direccion" value="<?= $MuestraComercial[0]->direccion_cliente ?>" type="text" required style="width: 100%" readonly>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-map-marker"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label style="color: #0BACBF">Ciudad *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="ciudad" value="<?= $MuestraComercial[0]->ciudad ?>" type="text" required style="width: 100%" readonly>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-map-marker"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <!--  Cliente, Nit y Dirección -->

                                                    <br />

                                                    <div class="section" style="padding-top: 30px">
                                                        <h4 class="col-md-12" style="color: #ffffff; background-color: #2A2F43; font-size: 13px; padding-top: 10px; padding-bottom: 10px">DATOS APROBACIÓN</h4>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label style="color: #0BACBF">Gestionado Por *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="gestionado" value="<?= $MuestraComercial[0]->gestionado ?>" type="text" required style="width: 100%" readonly>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-user"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label style="color: #0BACBF">Despachado Por *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="despachado" value="<?= $MuestraComercial[0]->despachado ?>" type="text" required style="width: 100%" readonly>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-user"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label style="color: #0BACBF">Aprobado Mercadeo *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="aprobado_mercadeo" value="<?= $MuestraComercial[0]->aprobado_mercadeo ?>" type="text" required style="width: 100%" readonly>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-user"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label style="color: #0BACBF">Aprobado Calidad *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="aprobado_calidad" value="<?= $MuestraComercial[0]->aprobado_calidad ?>" type="text" required style="width: 100%" readonly>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-user"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2 form-group">
                                                            <br />
                                                            <label style="color: #0BACBF">Aprobado / Rechazado *</label>
                                                            <label class="field select">
                                                                <select name="estado" id="estado" required>
                                                                    <?php
                                                                    if ($MuestraComercial[0]->estado == 0) { ?>
                                                                        <option value="0">Seleccione</option>
                                                                    <?php } ?>

                                                                    <?php
                                                                    if ($MuestraComercial[0]->estado == 1) { ?>
                                                                        <option value="1">Aprobado</option>
                                                                    <?php } ?>

                                                                    <?php
                                                                    if ($MuestraComercial[0]->estado == 2) { ?>
                                                                        <option value="2">Rechazado</option>
                                                                    <?php } ?>

                                                                </select>
                                                                <i class="arrow"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <br />
                                                            <label style="color: #0BACBF">Motivo de Rechazado ( <font style="color:#F6565A">* Solo Si Aplica</font>)</label>
                                                            <label class="field select">
                                                                <select name="motivo_rechazo" id="motivo_rechazo" required>
                                                                    <?php
                                                                    if ($MuestraComercial[0]->motivo_rechazo == 0) { ?>
                                                                        <option value="0">Seleccione</option>
                                                                    <?php } ?>

                                                                    <?php
                                                                    if ($MuestraComercial[0]->motivo_rechazo == 1) { ?>
                                                                        <option value="1">No. de Unidades (* Muchas Unidades)</option>
                                                                    <?php } ?>

                                                                    <?php
                                                                    if ($MuestraComercial[0]->motivo_rechazo == 2) { ?>
                                                                        <option value="2">Producto Fuera de Portafolio</option>
                                                                    <?php } ?>

                                                                    <?php
                                                                    if ($MuestraComercial[0]->motivo_rechazo == 3) { ?>
                                                                        <option value="3">Producto Inactivo</option>
                                                                    <?php } ?>

                                                                </select>
                                                                <i class="arrow"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <br />
                                                            <label style="color: #0BACBF">Observaciones de Rechazo ( <font style="color:#F6565A">* Solo Si Aplica</font>)</label>
                                                            <label class="field prepend-icon">
                                                                <input name="observaciones_rechazo" value="<?= $MuestraComercial[0]->observaciones_rechazo ?>" type="text" style="width: 100%" readonly>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-file"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="section" style="padding-top: 30px">
                                                        <h4 class="col-md-12" style="background-color: #f4f4f4; font-size: 13px; padding-top: 10px; padding-bottom: 10px">DATOS ÍTEMS</h4>
                                                    </div>

                                                    <div class="row">
                                                        <div class="section cloned-row">
                                                            <div class="col-md-6">
                                                                <br /><br />
                                                                <label style="color: #4ECCDB">Item SIESA</label>
                                                                <label class="field select">
                                                                    <label class="field select">
                                                                        <select name="item" id="item">
                                                                            <option value="<?= $ItemMuestraComercial[0]->id_item_siesa . ';' . $ItemMuestraComercial[0]->descripcion_item . ';' . $ItemMuestraComercial[0]->marca ?>"><?= $ItemMuestraComercial[0]->descripcion_item . ' | ' . $ItemMuestraComercial[0]->marca ?></option>
                                                                            <?php $numrows = 0; ?>
                                                                            @foreach($newDataRTPItems as $DataRTPItems)
                                                                            <option value="<?= $newDataRTPItems[$numrows]['item'] . ';' . $newDataRTPItems[$numrows]['descripcion'] . ';' . $newDataRTPItems[$numrows]['maquila'] ?>"><?= $newDataRTPItems[$numrows]['descripcion'] . ' | ' . $newDataRTPItems[$numrows]['maquila'] ?></option>
                                                                            <?php $numrows++; ?>
                                                                            @endforeach
                                                                        </select>
                                                                        <i class="arrow"></i>
                                                                    </label>
                                                                    <i class="arrow"></i>
                                                                </label>
                                                                <br /><br />
                                                            </div>
                                                            <div class="col-md-3">
                                                                <br /><br />
                                                                <label style="color: #0BACBF">Cantidad *</label>
                                                                <label class="field prepend-icon">
                                                                    <input name="cantidad" value="<?= $ItemMuestraComercial[0]->cantidad ?>" type="text" style="width: 100%">
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-file"></i>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <br /><br />
                                                                <label style="color: #4ECCDB">Maquila</label>
                                                                <label class="field select">
                                                                    <select name="maquila" id="maquila">
                                                                        <?php if ($ItemMuestraComercial[0]->maquila == 1) { ?>
                                                                            <option value="1">Si</option>
                                                                            <option value="2">No</option>
                                                                        <?php } ?>

                                                                        <?php if ($ItemMuestraComercial[0]->maquila == 2) { ?>
                                                                            <option value="2">No</option>
                                                                            <option value="1">Si</option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <i class="arrow"></i>
                                                                </label>
                                                                <br /><br />
                                                            </div>
                                                            <!-- Destinatario y Motivo -->
                                                            <br />
                                                            <div class="col-md-12">
                                                                <label style="color: #0BACBF">Observaciones *</label>
                                                                <label class="field prepend-icon">
                                                                    <input name="observaciones" value="<?= $ItemMuestraComercial[0]->observaciones ?>" type="text" style="width: 100%">
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-file"></i>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="section">
                                                        <br />
                                                        <div class="col-md-12 text-right">
                                                            {!! Form::submit('Modificar Item',
                                                            array('class'=>'btn btn-primary')) !!}
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

    <!-- -------------- DataTables -------------- -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
@endforeach