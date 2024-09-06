<?php

use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\MuestrasComerciales\PanelMuestrasComerciales;

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

    <!-- -------------- CSS -------------- -->
    @include('includes-CDN/include-head')
    <!-- -------------- CSS -------------- -->

    <!-- Select 2 -->
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

    <script>
        function MostrarDiv(valor) {

            // alert(valor.value);

            if (valor.value == 2) {
                var rechazo = document.getElementById("rechazo");

                if (rechazo.style.display === "none") {
                    rechazo.style.display = "block";
                } else {
                    rechazo.style.display = "none";
                }
            }

            if (valor.value == 1 || valor.value == 3) {
                var rechazo = document.getElementById("rechazo");

                if (rechazo.style.display === "block") {
                    rechazo.style.display = "none";
                } else {
                    rechazo.style.display = "none";
                }
            }
        }

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
                    window.location.href = '<?= $server ?>/panel/itemmuestracomercial-eliminar/' + id + '/' + idmc;
                }
            });
        }
        //-->
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
                                                    {!! Form::open(array('action' => 'MuestrasComerciales\MuestrasComercialesPanelController@MuestrasComercialesModificarDB', 'class' => 'form', 'id'=>'form-wizard', 'files' => true)) !!}
                                                    {!! Form::hidden('id', $MuestraComercial[0]->id) !!}
                                                    {!! Form::hidden('gestionado', 2278) !!}
                                                    {!! Form::hidden('consecutivo', $MuestraComercial[0]->consecutivo) !!}
                                                    {!! Form::hidden('marca', $MuestraComercial[0]->marca) !!}

                                                    <?php
                                                    $IdComercial = $MuestraComercial[0]->id_empleado;
                                                    $idmc =  $MuestraComercial[0]->id;
                                                    $logsItems = PanelMuestrasComerciales::getUltimoLogMuestraComercial($idmc);
                                                    $Items = $logsItems[0]->items;
                                                    $Items = trim($Items, '"');
                                                    ?>
                                                    <input type="hidden" name="itemslogs" value='<?= $Items ?>'>

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
                                                                <input type="date" id="fecha_entrega" name="fecha_entrega" value="<?= $FechaEstimada[0] ?>" required style="width: 100%">
                                                                <label class="field-icon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <?php
                                                            $DataComercial = PanelEmpleados::getEmpleado($MuestraComercial[0]->id_empleado);
                                                            $NombreEmpleadoComercial = $DataComercial[0]->primer_nombre . ' ' . $DataComercial[0]->ot_nombre . ' ' . $DataComercial[0]->primer_apellido . ' ' . $DataComercial[0]->ot_apellido;
                                                            ?>
                                                            <label style="color: #0BACBF">Asesor Comercial / Colaborador *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="empleado" value="<?= $NombreEmpleadoComercial ?>" type="text" readonly style="width: 100%">
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-user"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!-- Fecha, Empleado -->

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <br />
                                                            <?php $FechaMercadeo = explode(' ', $MuestraComercial[0]->fecha_mercadeo); ?>
                                                            <label style="color: #4ECCDB">Fecha Plazo de Mercadeo</label>
                                                            <label for="datepicker1" class="field prepend-icon">
                                                                <input type="date" id="fecha_mercadeo" name="fecha_mercadeo" value="<?= $FechaMercadeo[0] ?>" required style="width: 100%" readonly>
                                                                <label class="field-icon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <br />
                                                            <?php $FechaCalidad = explode(' ', $MuestraComercial[0]->fecha_calidad); ?>
                                                            <label style="color: #4ECCDB">Fecha Plazo de Logística de Despacho</label>
                                                            <label for="datepicker1" class="field prepend-icon">
                                                                <input type="date" id="fecha_calidad" name="fecha_calidad" value="<?= $FechaCalidad[0] ?>" required style="width: 100%" readonly>
                                                                <label class="field-icon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                    </div>


                                                    <!-- Destinatario y Motivo -->
                                                    <div class="row">
                                                        <br />
                                                        <div class="col-md-4">
                                                            <label style="color: #0BACBF">Destinatario *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="destinatario" value="<?= $MuestraComercial[0]->nombre_destinatario ?>" type="text" required style="width: 100%">
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-user"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label style="color: #0BACBF">Cel. Destinatario *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="cel-destinatario" value="<?= $MuestraComercial[0]->celular_destinatario ?>" type="text" required style="width: 100%">
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
                                                                    <option value="1">Muestras Showroom</option>
                                                                    <option value="2">Obsequios</option>
                                                                    <option value="3">Eventos</option>
                                                                    <option value="4">Muestras Directas Cliente</option>
                                                                    <option value="5">Muestras Para Comercial</option>
                                                                    <option value="6">E-Commerce</option>
                                                                    <option value="7">Muestras Publicidad</option>
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
                                                                <input name="razon_social" value="<?= $MuestraComercial[0]->nombre_cliente ?>" type="text" style="width: 100%">
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-file"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label style="color: #0BACBF">Nit. Cliente *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="nit" value="<?= $MuestraComercial[0]->nit_cliente ?>" type="text" style="width: 100%">
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-file"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label style="color: #0BACBF">Dirección Cliente *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="direccion" value="<?= $MuestraComercial[0]->direccion_cliente ?>" type="text" required style="width: 100%">
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-map-marker"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label style="color: #0BACBF">Ciudad *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="ciudad" value="<?= $MuestraComercial[0]->ciudad ?>" type="text" required style="width: 100%">
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-map-marker"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <!--  Cliente, Nit y Dirección -->

                                                    <br />

                                                    <div class="section" style="padding-top: 30px">
                                                        <h4 class="col-md-12" style="color: #ffffff; background-color: #2A2F43; font-size: 13px; padding-top: 10px; padding-bottom: 10px">DATOS APROBACIÓN MERCADEO</h4>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3 form-group">
                                                            <br />
                                                            <label style="color: #0BACBF">Aprobado Mercadeo *</label>
                                                            <label class="field select">
                                                                <select name="aprobado_mercadeo" id="aprobado_mercadeo" required>
                                                                    <?php
                                                                    if ($MuestraComercial[0]->aprobado_mercadeo == 0) { ?>
                                                                        <option value="0">Seleccione</option>
                                                                        <option value="<?= $idEmpleado ?>"><?= $NombreEmpleado ?></option>
                                                                    <?php } else {
                                                                        $DataMercadeo = PanelEmpleados::getEmpleado($MuestraComercial[0]->aprobado_mercadeo);
                                                                        $IdAprobadoMercadeo = $DataMercadeo[0]->id_empleado;
                                                                        $NombreEmpleadoMercadeo = $DataMercadeo[0]->primer_nombre . ' ' . $DataMercadeo[0]->ot_nombre . ' ' . $DataMercadeo[0]->primer_apellido . ' ' . $DataMercadeo[0]->ot_apellido;
                                                                    ?>
                                                                        <option value="<?= $IdAprobadoMercadeo ?>"><?= $NombreEmpleadoMercadeo ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <i class="arrow"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <br />
                                                            <label style="color: #4ECCDB">Fecha Aprobado Mercadeo ( <font style="color:#F6565A">* Automática </font> )</label>
                                                            <?php $FechaMercadeoAprobado = explode(' ', $MuestraComercial[0]->fecha_mercadeo_aprobado); ?>
                                                            <label for="datepicker1" class="field prepend-icon">
                                                                <input type="date" id="fecha_mercadeo_aprobado" name="fecha_mercadeo_aprobado" value="<?= $FechaMercadeoAprobado[0] ?>" required style="width: 100%" readonly>
                                                                <label class="field-icon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <br />
                                                            <label style="color: #0BACBF">Observaciones Generales Mercadeo ( <font style="color:#F6565A">* Solo Si Aplica</font>)</label>
                                                            <label class="field prepend-icon">
                                                                <input name="observaciones_mercadeo" value="<?= $MuestraComercial[0]->observaciones_mercadeo ?>" type="text" style="width: 100%">
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-file"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-2 form-group">
                                                            <br />
                                                            <label style="color: #0BACBF">Aprobado / Rechazado *</label>
                                                            <label class="field select">
                                                                <select name="estado" id="estado" required onChange="MostrarDiv(this)">
                                                                    <?php
                                                                    if ($MuestraComercial[0]->estado == 0) { ?>
                                                                        <option value="0">Seleccione</option>
                                                                        <option value="1">Aprobado</option>
                                                                        <option value="2">Rechazado</option>
                                                                        <option value="3">Cancelado</option>
                                                                    <?php } ?>

                                                                    <?php
                                                                    if ($MuestraComercial[0]->estado == 1) { ?>
                                                                        <option value="1">Aprobado</option>
                                                                        <option value="2">Rechazado</option>
                                                                        <option value="3">Cancelado</option>
                                                                    <?php } ?>

                                                                    <?php
                                                                    if ($MuestraComercial[0]->estado == 2) { ?>
                                                                        <option value="2">Rechazado</option>
                                                                        <option value="1">Aprobado</option>
                                                                        <option value="3">Cancelado</option>
                                                                    <?php } ?>

                                                                    <?php
                                                                    if ($MuestraComercial[0]->estado == 3) { ?>
                                                                        <option value="3">Cancelado</option>
                                                                        <option value="1">Aprobado</option>
                                                                        <option value="2">Rechazado</option>
                                                                    <?php } ?>

                                                                </select>
                                                                <i class="arrow"></i>
                                                            </label>
                                                        </div>

                                                        <?php
                                                        if ($MuestraComercial[0]->estado == 2) {
                                                            $display = 'display:block';
                                                        } else {
                                                            $display = 'display:none';
                                                        }
                                                        ?>
                                                        <div id="rechazo" style="<?= $display ?>">
                                                            <div class="col-md-3 form-group">
                                                                <br />
                                                                <label style="color: #0BACBF">Motivo de Rechazado ( <font style="color:#F6565A">* Solo Si Aplica</font>)</label>
                                                                <label class="field select">
                                                                    <select name="motivo_rechazo" id="motivo_rechazo" required>
                                                                        <?php
                                                                        if ($MuestraComercial[0]->motivo_rechazo == 0) { ?>
                                                                            <option value="0">Seleccione</option>
                                                                            <option value="1">No. de Unidades (* Muchas Unidades)</option>
                                                                            <option value="2">Producto Fuera de Portafolio</option>
                                                                            <option value="3">Producto Inactivo</option>
                                                                            <option value="0">No Aplica</option>
                                                                        <?php } ?>

                                                                        <?php
                                                                        if ($MuestraComercial[0]->motivo_rechazo == 1) { ?>
                                                                            <option value="1">No. de Unidades (* Muchas Unidades)</option>
                                                                            <option value="2">Producto Fuera de Portafolio</option>
                                                                            <option value="3">Producto Inactivo</option>
                                                                            <option value="0">No Aplica</option>
                                                                        <?php } ?>

                                                                        <?php
                                                                        if ($MuestraComercial[0]->motivo_rechazo == 2) { ?>
                                                                            <option value="2">Producto Fuera de Portafolio</option>
                                                                            <option value="1">No. de Unidades (* Muchas Unidades)</option>
                                                                            <option value="3">Producto Inactivo</option>
                                                                            <option value="0">No Aplica</option>
                                                                        <?php } ?>

                                                                        <?php
                                                                        if ($MuestraComercial[0]->motivo_rechazo == 3) { ?>
                                                                            <option value="3">Producto Inactivo</option>
                                                                            <option value="1">No. de Unidades (* Muchas Unidades)</option>
                                                                            <option value="2">Producto Fuera de Portafolio</option>
                                                                            <option value="0">No Aplica</option>
                                                                        <?php } ?>

                                                                    </select>
                                                                    <i class="arrow"></i>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <br />
                                                                <label style="color: #0BACBF">Observaciones de Rechazo ( <font style="color:#F6565A">* Solo Si Aplica</font>)</label>
                                                                <label class="field prepend-icon">
                                                                    <input name="observaciones_rechazo" value="<?= $MuestraComercial[0]->observaciones_rechazo ?>" type="text" style="width: 100%">
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-file"></i>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="section" style="padding-top: 30px">
                                                        <h4 class="col-md-12" style="color: #ffffff; background-color: #2A2F43; font-size: 13px; padding-top: 10px; padding-bottom: 10px">DATOS APROBACIÓN LOGÍSTICA DE DESPACHO</h4>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <br />
                                                            <?php
                                                            $idGest = 2278;
                                                            $Gestionado = PanelEmpleados::getEmpleado($idGest);
                                                            ?>
                                                            <label style="color: #0BACBF">Gestionado Por *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="gestionado_nombre" value="<?= $Gestionado[0]->primer_nombre . ' ' . $Gestionado[0]->ot_nombre . ' ' . $Gestionado[0]->primer_apellido . ' ' . $Gestionado[0]->ot_apellido ?>" type="text" required style="width: 100%" readonly>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-user"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <br />
                                                            <label style="color: #0BACBF">Despachado Por *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="despachado" value="<?= $MuestraComercial[0]->despachado ?>" type="text" required style="width: 100%">
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-user"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2 form-group">
                                                            <br />
                                                            <label style="color: #0BACBF">¿ Despachado ? *</label>
                                                            <label class="field select">
                                                                <select name="estado_despachado" id="estado_despachado" required>
                                                                    <?php
                                                                    if ($MuestraComercial[0]->estado_despachado == 0) { ?>
                                                                        <option value="0">Seleccione</option>
                                                                        <option value="1">Despachado</option>
                                                                        <option value="2">Sin Despachar</option>
                                                                    <?php } ?>

                                                                    <?php
                                                                    if ($MuestraComercial[0]->estado_despachado == 1) { ?>
                                                                        <option value="1">Despachado</option>
                                                                        <option value="2">Sin Despachar</option>
                                                                    <?php } ?>

                                                                    <?php
                                                                    if ($MuestraComercial[0]->estado_despachado == 2) { ?>
                                                                        <option value="2">Sin Despachar</option>
                                                                        <option value="1">Despachado</option>
                                                                    <?php } ?>
                                                                </select>
                                                                <i class="arrow"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <br />
                                                            <label style="color: #0BACBF">Aprobado Calidad *</label>
                                                            <label class="field select">
                                                                <select name="aprobado_calidad" id="aprobado_calidad" required>
                                                                    <?php
                                                                    if ($MuestraComercial[0]->aprobado_calidad == 0) { ?>
                                                                        <option value="0">Seleccione</option>
                                                                        <option value="<?= $idEmpleado ?>"><?= $NombreEmpleado ?></option>
                                                                    <?php } else {
                                                                        $DataCalidad = PanelEmpleados::getEmpleado($MuestraComercial[0]->aprobado_calidad);
                                                                        $IdAprobadoCalidad = $DataCalidad[0]->id_empleado;
                                                                        $NombreEmpleadoCalidad = $DataCalidad[0]->primer_nombre . ' ' . $DataCalidad[0]->ot_nombre . ' ' . $DataCalidad[0]->primer_apellido . ' ' . $DataCalidad[0]->ot_apellido;
                                                                    ?>
                                                                        <option value="<?= $IdAprobadoCalidad ?>"><?= $NombreEmpleadoCalidad ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <i class="arrow"></i>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <br />
                                                            <label style="color: #4ECCDB">Fecha Despacho Calidad ( <font style="color:#F6565A">* Automática </font>)</label>
                                                            <?php $FechaCalidadAprobado = explode(' ', $MuestraComercial[0]->fecha_calidad_aprobado); ?>
                                                            <label for="datepicker1" class="field prepend-icon">
                                                                <input type="date" id="fecha_calidad_aprobado" name="fecha_calidad_aprobado" value="<?= $FechaCalidadAprobado[0] ?>" required style="width: 100%" readonly>
                                                                <label class="field-icon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <br />
                                                            <label style="color: #4ECCDB">Adjuntar Imágen o Documento</label>
                                                            <label class="field prepend-icon append-button file">
                                                                <span class="button" style="cursor: pointer">
                                                                    Archivo
                                                                </span>
                                                                <input type="file" name="archivo" id="archivo" class="gui-file" onchange="document.getElementById('subir').value = this.value;">
                                                                <input type="text" name="subir" id="subir" class="gui-input" placeholder="Seleccione el archivo">
                                                                <label class="field-icon">
                                                                    <i class="fa fa-cloud-upload"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <center>
                                                                <br />
                                                                <?php if ($MuestraComercial[0]->archivo_calidad != 'No Hay Archivo' && $MuestraComercial[0]->archivo_calidad != '') { ?>
                                                                    <a href="<?= $server ?>/archivos/muestrasComerciales/<?= $MuestraComercial[0]->archivo_calidad ?>" title="Documento" target="_blank">
                                                                        <font color="#F6565A">Ver Archivo</font><br /><br />
                                                                        <button type="button" class="btn btn-default light">
                                                                            <i class="fa fa-file fa-lg" style="color:#269ec5;"></i>&nbsp;
                                                                        </button>
                                                                    </a>
                                                            </center>
                                                        <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <br />
                                                            <label style="color: #0BACBF">Observaciones Generales Calidad ( <font style="color:#F6565A">* Solo Si Aplica</font>)</label>
                                                            <label class="field prepend-icon">
                                                                <input name="observaciones_calidad" value="<?= $MuestraComercial[0]->observaciones_calidad ?>" type="text" style="width: 100%">
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-file"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <?php if (($CargoEmpleado == 154 || $CargoEmpleado == 159 || $CargoEmpleado == 161 || $CargoEmpleado == 212 || $CargoEmpleado == 281 || $CargoEmpleado == 311) || ($IdComercial == $idEmpleado)) { ?>
                                                        <div class="section" style="padding-top: 30px">
                                                            <h4 class="col-md-12" style="background-color: #f4f4f4; font-size: 13px; padding-top: 10px; padding-bottom: 10px">DATOS ÍTEMS</h4>
                                                        </div>

                                                        <div id="items_siesa">
                                                            <div class="section cloned-row">
                                                                <div class="col-md-6">
                                                                    <br /><br />
                                                                    <label style="color: #4ECCDB">Item SIESA</label>
                                                                    <label class="field select">
                                                                        <label class="field select">
                                                                            <select name="items[]" id="items">
                                                                                <option value="0">Seleccione</option>
                                                                                <?php $numrows = 0; ?>
                                                                                @foreach($newDataRTPItems as $DataRTPItems)
                                                                                <option value="<?= $newDataRTPItems[$numrows]['item'] . ';' . $newDataRTPItems[$numrows]['descripcion'] . ';' . $newDataRTPItems[$numrows]['maquila'] ?>"><?= $newDataRTPItems[$numrows]['item'] . ' | ' . $newDataRTPItems[$numrows]['descripcion'] . ' | ' . $newDataRTPItems[$numrows]['maquila'] ?></option>
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
                                                                        <input name="cantidad[]" value="" type="text" style="width: 100%">
                                                                        <label for="username" class="field-icon">
                                                                            <i class="fa fa-file"></i>
                                                                        </label>
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <br /><br />
                                                                    <label style="color: #4ECCDB">Maquila</label>
                                                                    <label class="field select">
                                                                        <select name="maquila[]" id="maquila[]">
                                                                            <option value="">Seleccione</option>
                                                                            <option value="1">Si</option>
                                                                            <option value="2">No</option>
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
                                                                        <input name="observaciones[]" value="" type="text" style="width: 100%">
                                                                        <label for="username" class="field-icon">
                                                                            <i class="fa fa-file"></i>
                                                                        </label>
                                                                        <br /><br />
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <div class="section">
                                                        <br />
                                                        <?php if (($CargoEmpleado == 154 || $CargoEmpleado == 159 || $CargoEmpleado == 161 || $CargoEmpleado == 212 || $CargoEmpleado == 281 || $CargoEmpleado == 311) || ($IdComercial == $idEmpleado)) { ?>
                                                            <div class="col-md-2 spawn-button-column">
                                                                <input type="button" class="form-control btn-info" value="Agregar +" id="clone">
                                                            </div>
                                                            <div class="col-md-2 spawn-button-column">
                                                                <input type="button" class="form-control btn-danger" value="Eliminar -" id="remove">
                                                            </div>
                                                        <?php } ?>
                                                        <div class="col-md-4">
                                                            {!! Form::submit('Modificar Pedido',
                                                            array('class'=>'btn btn-primary')) !!}
                                                        </div>
                                                    </div>

                                                    {!! Form::close() !!}
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="section" style="padding-top: 30px">
                                    <h4 class="col-md-12" style="color: #ffffff; background-color: #2A2F43; font-size: 13px; padding-top: 10px; padding-bottom: 10px">DATOS ÍTEMS SOLICITUD</h4>
                                </div>

                                <!-- ITEMS MUETRAS COMERCIALES -->
                                <table id="message-table" class="table allcp-form theme-warning br-t table-striped">
                                    <thead>
                                        <tr style="background-color: #F8F8F8; color:#000000">
                                            <th style="text-align:center">
                                                Item
                                            </th>
                                            <th style="text-align:center">
                                                Descripción
                                            </th>
                                            <th style="text-align:center">
                                                Marca
                                            </th>
                                            <th style="text-align: center">
                                                Maquila
                                            </th>
                                            <th style="text-align: center">
                                                Cantidad
                                            </th>
                                            <th style="text-align: center">
                                                Observaciones
                                            </th>
                                            <th style="text-align:center">
                                                Modificar
                                            </th>
                                            <th style="text-align:center">
                                                Eliminar
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $ModalId = 0;
                                        $CantidadTotal = 0;
                                        ?>
                                        @foreach($ItemsMuestraComercial as $DataItemsMC)
                                        <?php
                                        $CantidadTotal = $CantidadTotal + $DataItemsMC->cantidad;
                                        ?>
                                        <tr class="message-unread">
                                            <td style="text-align:center">
                                                <font color="#2A2F43">
                                                    <?= $DataItemsMC->id_item_siesa; ?>
                                                </font>
                                            </td>
                                            <td style="text-align:center">
                                                <font color="#2A2F43">
                                                    <?= $DataItemsMC->descripcion_item; ?>
                                                </font>
                                            </td>
                                            <td style="text-align:center">
                                                <font color="#2A2F43">
                                                    <?= $DataItemsMC->marca; ?>
                                                </font>
                                            </td>
                                            <?php
                                            if ($DataItemsMC->maquila == 1) {
                                                $titMaquila = 'Si';
                                            } else {
                                                $titMaquila = 'No';
                                            }
                                            ?>
                                            <td style="text-align:center">
                                                <font color="#2A2F43">
                                                    <?= $titMaquila; ?>
                                                </font>
                                            </td>
                                            <td style="text-align:center">
                                                <font color="#2A2F43">
                                                    <?= $DataItemsMC->cantidad; ?>
                                                </font>
                                            </td>
                                            <td style="text-align: center">
                                                <div style="height:100px; width:100%; overflow:auto;">
                                                    <br />
                                                    <button type="button" class="btn btn-default light" data-toggle="modal" data-target="#myModal<?= $ModalId ?>"><i class="fa fa-edit fa-2x" style="color: #4682b4"></i>&nbsp;</button>
                                                    <br />
                                                    <font color="#2A2F43">Ver + </font>
                                                </div>
                                            </td>
                                            <td style="text-align: center">
                                                <?php if (($CargoEmpleado == 154 || $CargoEmpleado == 159 || $CargoEmpleado == 161 || $CargoEmpleado == 212 || $CargoEmpleado == 281 || $CargoEmpleado == 311) || ($IdComercial == $idEmpleado)) { ?>
                                                    <button type="button" class="btn btn-default light" onclick="window.location.href='<?= $server ?>/panel/muestrascomerciales-modificar-item/<?= $DataItemsMC->id ?>/<?= $MuestraComercial[0]->id ?>'" title="Modificar Solicitud">
                                                        <i class="fa fa-pencil fa-lg" style="color:#AEBF25;"></i>
                                                    </button>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-default light">
                                                        <i class="fa fa-lock fa-lg" style="color:#F6565A;"></i>
                                                    </button>
                                                <?php } ?>
                                            </td>
                                            <td style="text-align: center">
                                                <?php if (($CargoEmpleado == 154 || $CargoEmpleado == 159 || $CargoEmpleado == 161 || $CargoEmpleado == 212 || $CargoEmpleado == 281 || $CargoEmpleado == 311) || ($IdComercial == $idEmpleado)) { ?>
                                                    <button type="button" class="btn btn-default light" onClick="eliminar_item_solicitud(<?= $DataItemsMC->id ?>,<?= $MuestraComercial[0]->id ?>)" title="Eliminar Solicitud">
                                                        <i class="fa fa-trash fa-lg" style="color:#F6565A;"></i>
                                                    </button>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-default light">
                                                        <i class="fa fa-lock fa-lg" style="color:#F6565A;"></i>
                                                    </button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php $ModalId++; ?>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <font color="#2A2F43">
                                                    <strong>Cantidad Total de Muestras:</strong>
                                                    <font style="color:#F6565A"><?= $CantidadTotal; ?></font>
                                                </font>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- ITEMS MUETRAS COMERCIALES -->
                                <br />
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

    <template id="my-template">
        <div class="section cloned-row">
            <div class="col-md-6">
                <br /><br />
                <label style="color: #4ECCDB">Item SIESA *</label>
                <label class="field select">
                    <label class="field select">
                        <select name="items[]" id="items" required>
                            <option value="">Seleccione</option>
                            <?php $numrows = 0; ?>
                            @foreach($newDataRTPItems as $DataRTPItems)
                            <option value="<?= $newDataRTPItems[$numrows]['item'] . ';' . $newDataRTPItems[$numrows]['descripcion'] . ';' . $newDataRTPItems[$numrows]['maquila'] ?>"><?= $newDataRTPItems[$numrows]['item'] . ' | ' . $newDataRTPItems[$numrows]['descripcion'] . ' | ' . $newDataRTPItems[$numrows]['maquila'] ?></option>
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
                <label style="color: #0BACBF">Cantidad (Unidades) *</label>
                <label class="field prepend-icon">
                    <input name="cantidad[]" value="" type="text" style="width: 100%">
                    <label for="username" class="field-icon">
                        <i class="fa fa-file"></i>
                    </label>
                </label>
            </div>
            <div class="col-md-3">
                <br /><br />
                <label style="color: #4ECCDB">Maquila *</label>
                <label class="field select">
                    <select name="maquila[]" id="maquila[]" required>
                        <option value="">Seleccione</option>
                        <option value="1">Si</option>
                        <option value="2">No</option>
                    </select>
                    <i class="arrow"></i>
                </label>
                <br /><br />
            </div>
            <!-- Destinatario y Motivo -->
            <br />
            <div class="col-md-12">
                <label style="color: #0BACBF">Observaciones</label>
                <label class="field prepend-icon">
                    <input name="observaciones[]" value="" type="text" style="width: 100%">
                    <label for="username" class="field-icon">
                        <i class="fa fa-file"></i>
                    </label>
                </label>
                <br /><br />
            </div>
            <br />
        </div>
    </template>

    <!-- -------------- Scripts -------------- -->
    @include('includes-CDN/include-script')
    <!-- -------------- /Scripts -------------- -->

    <script type="module">
        import {
            configureSelect2
        } from '<?= $server ?>/js/select2.js';

        configureSelect2();

        $("#remove").click(function() {
            $(".cloned-row:last").remove(".cloned-row:last");
        });

        $("#clone").click(function() {
            let $template = $('#my-template').get(0);
            let templateContent = $template.content;
            let $clone = $(document.importNode(templateContent, true));

            $("#items_siesa").append($clone);
            console.log($clone)
            configureSelect2();
        });
    </script>

    <?php $ModalId = 0; ?>
    @foreach($ItemsMuestraComercial as $DatItemsMuestraComercial)
    <?php
    $Observaciones = $DatItemsMuestraComercial->observaciones;
    ?>
    <!-- Modal -->
    <div class="modal fade" id="myModal<?= $ModalId ?>" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Observaciones</h4>
                </div>
                <div class="modal-body">
                    <p><?= $Observaciones ?></p>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
@endforeach