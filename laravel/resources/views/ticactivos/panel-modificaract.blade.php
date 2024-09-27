<?php

use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\TicActivos\PanelTipos;
use App\Models\TicActivos\PanelMarcas;
use App\Models\TicActivos\PanelLicencias;
use App\Models\TicActivos\PanelSoftware;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Activos TIC | Editar activo
        </title>
        <meta name="description" content="Intranet para grupo Berhlan">
        <meta name="author" content="USUARIO">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- -------------- Fonts -------------- -->
        <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
        <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic'
            rel='stylesheet' type='text/css'>

        <!-- -------------- CSS - theme -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/skin/default_skin/css/theme.css')}}">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.css">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css')}}">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="{{ asset ('/panelfiles/assets/img/favicon.ico')}}">

        <!-- Editor -->
        <script type="text/javascript" src="{{ asset ('/panelfiles/ckeditor/ckeditor.js')}}"></script>


        {{-- Importar styles y funcionamiento del Select2 --}}
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">


        <script type="text/javascript" src="{{ asset ('/panelfiles/select2/dist/js/select2.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/select2/dist/css/select2.min.css')}}">
        <script>
            jQuery(document).ready(function($) {
                $("#empleado").select2({
                    closeOnSelect: true,
                    width: '250px'
                });
            });
            jQuery(document).ready(function($) {
                $("#licoffice").select2({
                    closeOnSelect: true,
                    width: '250px'
                });
            });
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
                                <a href="{{ asset ('/panel/ticactivos/consultasparam')}}"
                                    title="Activos TIC > Consulta parametrizada">
                                    <font color="#34495e">
                                        Activos TIC > Consulta parametrizada > Resultado > Más información >
                                    </font>
                                    <font color="#b4c056">
                                        Editar
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset ('/panel/ticactivos/consultasparam')}}" class="btn btn-primary btn-sm ml10"
                            title="Activos TIC > Consulta parametrizada">
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
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr>
                                                <th style="background-color:#67d3e0; color:#34495e; text-align:left;">
                                                    Actualice los datos del activo
                                                    &nbsp;&nbsp;
                                                    <font size="3">
                                                        AC<?= $DatosActivo[0]->id_activo ?>
                                                        &nbsp;&nbsp;-&nbsp;&nbsp;
                                                        <?php
                                                        $Tipo = PanelTipos::getTipo($DatosActivo[0]->tipo);
                                                        echo $Tipo[0]->descripcion;
                                                        ?>
                                                    </font>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="allcp-form">
                                                        {!! Form::open([
                                                            'action' => 'TicActivos\ActivosTicActivosPanelController@ModificarDB',
                                                            'class' => 'form',
                                                            'id' => 'form-wizard',
                                                            'files' => true,
                                                        ]) !!}
                                                        {!! Form::hidden('activo', $DatosActivo[0]->id_activo) !!}
                                                        {!! Form::hidden('tipo', $DatosActivo[0]->tipo) !!}
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Estado
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="estado" id="estado" required>
                                                                        <option value="1" style="color:green;"
                                                                            <?php
                                                                            if ($DatosActivo[0]->estado == 1) {
                                                                                echo ' selected ';
                                                                            }
                                                                            ?>>Activo</option>

                                                                        <option value="0" style="color:red;"
                                                                            <?php
                                                                            if ($DatosActivo[0]->estado == 0) {
                                                                                echo ' selected ';
                                                                            }
                                                                            ?>>Inactivo</option>
                                                                    </select>
                                                                    <i class="arrow"></i>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Colaborador
                                                                    </b>
                                                                </label>
                                                                <label class="field select"
                                                                    style="width: 100%; height: 100%;">
                                                                    <select name="empleado" id="empleado" required
                                                                        style="width: 100%; height: 100%;">
                                                                        <option value="<?= $DatosActivo[0]->empleado ?>"
                                                                            style="width: 100%; height: 100%;">
                                                                            <?php
                                                                            $emple = $DatosActivo[0]->empleado;
                                                                            $Empleado = PanelEmpleados::getEmpleado($emple);
                                                                            $Cargo = PanelCargos::getCargo($Empleado[0]->cargo);
                                                                            $Area = PanelAreas::getArea($Cargo[0]->area);
                                                                            echo $Empleado[0]->primer_nombre;
                                                                            echo ' ';
                                                                            echo $Empleado[0]->ot_nombre;
                                                                            echo ' ';
                                                                            echo $Empleado[0]->primer_apellido;
                                                                            echo ' ';
                                                                            echo $Empleado[0]->ot_apellido;
                                                                            echo ' &nbsp;&nbsp;-&nbsp;&nbsp; ';
                                                                            echo $Cargo[0]->descripcion;
                                                                            echo ' - ';
                                                                            echo $Area[0]->descripcion;
                                                                            ?>
                                                                        </option>
                                                                        <?php
                                                                        $Empleado = PanelEmpleados::EmpleadosActivos();
                                                                        ?>
                                                                        @foreach ($Empleado as $DatEmp)
                                                                            <?php
                                                                            $Cargo = PanelCargos::getCargo($DatEmp->cargo);
                                                                            $Area = PanelAreas::getArea($Cargo[0]->area);
                                                                            ?>
                                                                            <option value="<?= $DatEmp->id_empleado ?>"
                                                                                style="width: 100%; height: 100%;">
                                                                                <?php
                                                                                echo $DatEmp->primer_nombre;
                                                                                echo ' ';
                                                                                echo $DatEmp->ot_nombre;
                                                                                echo ' ';
                                                                                echo $DatEmp->primer_apellido;
                                                                                echo ' ';
                                                                                echo $DatEmp->ot_apellido;
                                                                                echo ' &nbsp;&nbsp;-&nbsp;&nbsp; ';
                                                                                echo $Cargo[0]->descripcion;
                                                                                echo ' - ';
                                                                                echo $Area[0]->descripcion;
                                                                                ?>
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-4">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Compañía
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="empresa" id="empresa" required>
                                                                        <option value="<?= $DatosActivo[0]->empresa ?>">
                                                                            <?php
                                                                            $Empresa = PanelEmpresas::getEmpresa($DatosActivo[0]->empresa);
                                                                            echo $Empresa[0]->nombre;
                                                                            ?>
                                                                        </option>
                                                                        <?php
                                                                        $Empresas = PanelEmpresas::getEmpresasActivas();
                                                                        ?>
                                                                        @foreach ($Empresas as $DatEmp)
                                                                            <option value="<?= $DatEmp->id_empresa ?>">
                                                                                <?= $DatEmp->nombre ?>
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <i class="arrow"></i>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Marca y modelo
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="marca" id="marca" required>
                                                                        <option value="<?= $DatosActivo[0]->marca ?>">
                                                                            <?php
                                                                            $Marca = PanelMarcas::getMarca($DatosActivo[0]->marca);
                                                                            echo $Marca[0]->descripcion;
                                                                            ?>
                                                                        </option>
                                                                        <?php
                                                                        $Marcas = PanelMarcas::getMarcasActivas();
                                                                        ?>
                                                                        @foreach ($Marcas as $DatMar)
                                                                            <option value="<?= $DatMar->id_marca ?>">
                                                                                <?= $DatMar->descripcion ?>
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <i class="arrow"></i>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Serial
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::text('serial', $DatosActivo[0]->serial, [
                                                                        '',
                                                                        'id' => 'serial',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => 'Serial',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-barcode"></i>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-4">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Código interno
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::text('codigoint', $DatosActivo[0]->cod_interno, [
                                                                        '',
                                                                        'id' => 'codigoint',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => 'Código interno',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-barcode"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Activo fijo
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::text('activofijo', $DatosActivo[0]->activofijo, [
                                                                        '',
                                                                        'id' => 'activofijo',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => 'Activo fijo',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-barcode"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Usuario y contraseña
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::text('usrclave', $DatosActivo[0]->usrclave, [
                                                                        '',
                                                                        'id' => 'usrclave',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => 'usuario=admin   contraseña=123456',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-key"></i>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-4">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        PDF con factura
                                                                    </b>
                                                                    <?php
                                                                    if ($DatosActivo[0]->factura != '') {
                                                                        $ruta = "window.open('" . $server . '/archivos/Activostic/Facturas/' . $DatosActivo[0]->factura . "','_blank')";
                                                                        $icono = 'fa-file-pdf-o';
                                                                    } else {
                                                                        $ruta = '';
                                                                        $icono = 'fa-eye-slash ';
                                                                    }
                                                                    ?>
                                                                    &nbsp;
                                                                    <button type="button" style="background:#f7f9f9;"
                                                                        class="btn btn-default light"
                                                                        onclick="<?= $ruta ?>"
                                                                        title="<?= $DatosActivo[0]->factura ?>">
                                                                        <i class="fa <?= $icono ?> fa-lg"
                                                                            style="color:#b90202;"></i>
                                                                    </button>
                                                                </label>
                                                                <label class="field prepend-icon append-button file">
                                                                    <span class="button">
                                                                        PDF
                                                                    </span>
                                                                    {!! Form::file('file1', [
                                                                        '',
                                                                        'id' => 'file1',
                                                                        'accept' => '.pdf',
                                                                        'class' => 'gui-file',
                                                                        'onChange' => "document.getElementById('uploader1').value = this.value;",
                                                                    ]) !!}
                                                                    {!! Form::text('uploader1', null, ['id' => 'uploader1', 'class' => 'gui-input', 'placeholder' => 'Factura']) !!}
                                                                    <label class="field-icon">
                                                                        <i class="fa fa-cloud-upload"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Foto
                                                                    </b>
                                                                    <?php
                                                                    if ($DatosActivo[0]->foto != '') {
                                                                        $ruta = "window.open('" . $server . '/archivos/Activostic/Fotos/' . $DatosActivo[0]->foto . "','_blank')";
                                                                        $icono = 'fa-file-image-o';
                                                                    } else {
                                                                        $ruta = '';
                                                                        $icono = 'fa-eye-slash ';
                                                                    }
                                                                    ?>
                                                                    &nbsp;
                                                                    <button type="button" style="background:#f7f9f9;"
                                                                        class="btn btn-default light"
                                                                        onclick="<?= $ruta ?>"
                                                                        title="<?= $DatosActivo[0]->foto ?>">
                                                                        <i class="fa <?= $icono ?> fa-lg"
                                                                            style="color:#6CBCED;"></i>
                                                                    </button>
                                                                </label>
                                                                <label class="field prepend-icon append-button file">
                                                                    <span class="button">
                                                                        JPG
                                                                    </span>
                                                                    {!! Form::file('file2', [
                                                                        '',
                                                                        'id' => 'file2',
                                                                        'accept' => '.jpg',
                                                                        'class' => 'gui-file',
                                                                        'onChange' => "document.getElementById('uploader2').value = this.value;",
                                                                    ]) !!}
                                                                    {!! Form::text('uploader2', null, ['id' => 'uploader2', 'class' => 'gui-input', 'placeholder' => 'Foto']) !!}
                                                                    <label class="field-icon">
                                                                        <i class="fa fa-cloud-upload"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Acta firmada
                                                                    </b>
                                                                    <?php
                                                                    if ($DatosActivo[0]->actafirmada != '') {
                                                                        $ruta = "window.open('" . $server . '/archivos/Activostic/Actas_firmadas/' . $DatosActivo[0]->actafirmada . "','_blank')";
                                                                        $icono = 'fa-file-pdf';
                                                                    } else {
                                                                        $ruta = '';
                                                                        $icono = 'fa-eye-slash ';
                                                                    }
                                                                    ?>
                                                                    &nbsp;
                                                                    <button type="button" style="background:#f7f9f9;"
                                                                        class="btn btn-default light"
                                                                        onclick="<?= $ruta ?>"
                                                                        title="<?= $DatosActivo[0]->actafirmada ?>">
                                                                        <i class="fa <?= $icono ?> fa-lg"
                                                                            style="color:#b90202;"></i>
                                                                    </button>
                                                                </label>
                                                                <label class="field prepend-icon append-button file">
                                                                    <span class="button">
                                                                        PDF
                                                                    </span>
                                                                    {!! Form::file('file3', [
                                                                        '',
                                                                        'id' => 'file3',
                                                                        'accept' => '.pdf',
                                                                        'class' => 'gui-file',
                                                                        'onChange' => "document.getElementById('uploader3').value = this.value;",
                                                                    ]) !!}
                                                                    {!! Form::text('uploader3', null, ['id' => 'uploader3', 'class' => 'gui-input', 'placeholder' => 'Acta']) !!}
                                                                    <label class="field-icon">
                                                                        <i class="fa fa-cloud-upload fa-lg"></i>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Garantía hasta
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('garantia', $DatosActivo[0]->garantia, [
                                                                        '',
                                                                        'id' => 'garantia',
                                                                        'class' => 'gui-input',
                                                                        'maxlength' => '10',
                                                                    ]) !!}
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Fecha de adquisición
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('adquisicion', $DatosActivo[0]->fechaadq, [
                                                                        '',
                                                                        'id' => 'adquisicion',
                                                                        'class' => 'gui-input',
                                                                        'maxlength' => '10',
                                                                    ]) !!}
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Valor compra
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::number('valcompra', $DatosActivo[0]->valor_compra, [
                                                                        '',
                                                                        'id' => 'valcompra',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => 'Valor compra',
                                                                        'min' => '0',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-dollar"></i>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <?php
                                                        //Verifico si esta habilitado el control de mantenimiento
                                                        if ($DatosActivo[0]->mantenimiento == 'S') {
                                                            $color1 = 'green';
                                                            $color2 = 'grey';
                                                            $activo1 = 'active';
                                                            $activo2 = '';
                                                            $chequeado1 = 'checked';
                                                            $chequeado2 = '';
                                                            $visible = '';
                                                        } else {
                                                            $color1 = 'grey';
                                                            $color2 = 'red';
                                                            $activo1 = '';
                                                            $activo2 = 'active';
                                                            $chequeado1 = '';
                                                            $chequeado2 = 'checked';
                                                            $visible = 'disabled';
                                                        }
                                                        ?>

                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Aplica control de mantenimiento
                                                                    </b>
                                                                </label>
                                                                <label class="option block">
                                                                    <div class="btn-group btn-group-toggle"
                                                                        data-toggle="buttons">
                                                                        <label
                                                                            class="btn btn-secondary <?= $activo1 ?>"
                                                                            onclick="COLOR('S')">
                                                                            <i class="fa fa-wrench fa-1x"
                                                                                id="mantenimientos"
                                                                                style="color:<?= $color1 ?>;"> Sí</i>
                                                                            <input type="radio" name="mantenimiento"
                                                                                value="S" autocomplete="off"
                                                                                <?= $chequeado1 ?>>
                                                                        </label>
                                                                        <label
                                                                            class="btn btn-secondary <?= $activo2 ?>"
                                                                            onclick="COLOR('N')">
                                                                            <i class="fa fa-times-circle fa-1x"
                                                                                id="mantenimienton"
                                                                                style="color:<?= $color2 ?>;"> No</i>
                                                                            <input type="radio" name="mantenimiento"
                                                                                value="N" autocomplete="off"
                                                                                <?= $chequeado2 ?>>
                                                                        </label>
                                                                    </div>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Meses entre mantenimientos
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="meses" id="meses"
                                                                        <?= $visible ?> required>
                                                                        <?php
                                                                        if ($DatosActivo[0]->mes_mtto != 0) {
                                                                            $mes = $DatosActivo[0]->mes_mtto;
                                                                            echo "<option value=\"$mes\">";
                                                                            echo $DatosActivo[0]->mes_mtto;
                                                                            echo '</option>';
                                                                        } else {
                                                                            echo "<option value=\"\">";
                                                                            echo 'Seleccione el mes';
                                                                            echo '</option>';
                                                                        }

                                                                        for ($u = 1; $u < 73; $u++) {
                                                                            echo "<option value=\"$u\">";
                                                                            echo $u;
                                                                            echo '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <i class="arrow"></i>
                                                                </label>
                                                            </div>

                                                            <?php
                                                            if ($DatosActivo[0]->mantenimiento == 'N') {
                                                                $visible1 = 'disabled';
                                                            } elseif ($DatosActivo[0]->fechamtto != null) {
                                                                $visible1 = 'disabled';
                                                            } else {
                                                                $visible1 = '';
                                                            }
                                                            ?>

                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Fecha inicial
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('fechainicial', $DatosActivo[0]->fechamtto, [
                                                                        'required',
                                                                        $visible1,
                                                                        'id' => 'fechainicial',
                                                                        'class' => 'gui-input',
                                                                        'maxlength' => '10',
                                                                    ]) !!}
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Dirección MAC
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::text('mac1', $DatosActivo[0]->mac1, [
                                                                        '',
                                                                        'id' => 'mac1',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => 'Dirección MAC (A1-B2-C3-D4-E5-F6)',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-bars"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Dirección IP
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::textarea('ip1', $DatosActivo[0]->ip1, [
                                                                        '',
                                                                        'id' => 'ip1',
                                                                        'class' => 'gui-input',
                                                                        'style' => 'height: 58px;',
                                                                        'placeholder' => '123.123.123.123 / 255.255.255.0 / 123.123.123.1',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-reorder"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Observaciones
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::textarea('observaciones', $DatosActivo[0]->observaciones, [
                                                                        '',
                                                                        'id' => 'observaciones',
                                                                        'class' => 'gui-input',
                                                                        'style' => 'height: 58px;',
                                                                        'placeholder' => 'Observaciones',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-reorder"></i>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <?php
                                if($Tipo[0]->campos_pc == "S")
                                 {
                                  ?>
                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Tamaño del DD
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::text('tamanodd', $DatosActivo[0]->tamano_dd, [
                                                                        '',
                                                                        'id' => 'tamanodd',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => '256GB - 512GB',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-bars"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Tipo de DD
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::text('tipodd', $DatosActivo[0]->tipo_dd, [
                                                                        '',
                                                                        'id' => 'tipodd',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => 'HDD - SSD',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-bars"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Tamaño de RAM
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::text('tamanoram', $DatosActivo[0]->tamano_ram, [
                                                                        '',
                                                                        'id' => 'tamanoram',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => '6GB - 8GB - 16GB',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-bars"></i>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Tipo de RAM
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::text('tiporam', $DatosActivo[0]->tipo_ram, [
                                                                        '',
                                                                        'id' => 'tiporam',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => 'DDR3 - DDR4',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-bars"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Procesador
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::text('procesador', $DatosActivo[0]->procesador, [
                                                                        '',
                                                                        'id' => 'procesador',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => 'CORE i3 i6 i9 # # GHz',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-gear"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Licencia de office
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="licoffice" id="licoffice">
                                                                        <option value="<?= $DatosActivo[0]->office ?>">
                                                                            <?php
                                                                            if ($DatosActivo[0]->office == 0) {
                                                                                echo 'Sin licencia';
                                                                            } else {
                                                                                $Licencia = PanelLicencias::LicenciasyTipo($DatosActivo[0]->office);
                                                                                echo $Licencia[0]->tpdes . ' - ' . $Licencia[0]->lice;
                                                                            }
                                                                            ?>
                                                                        </option>
                                                                        <?php
                                                                        $Licencias = PanelLicencias::getLicenciasTpActivas();
                                                                        ?>
                                                                        @foreach ($Licencias as $DatLic)
                                                                            <option
                                                                                value="<?= $DatLic->id_licencia ?>">
                                                                                <?php
                                                                                echo $DatLic->tpdes . ' - ' . $DatLic->lice;
                                                                                ?>
                                                                            </option>
                                                                        @endforeach
                                                                    </select>

                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Dirección MAC 2
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::text('mac2', $DatosActivo[0]->mac2, [
                                                                        '',
                                                                        'id' => 'mac2',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => 'A1-B2-C3-D4-E5-F6',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-bars"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Dirección IP 2
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::textarea('ip2', $DatosActivo[0]->ip2, [
                                                                        '',
                                                                        'id' => 'ip2',
                                                                        'class' => 'gui-input',
                                                                        'style' => 'height: 58px;',
                                                                        'placeholder' => '123.123.123.123 / 255.255.255.0 / 123.123.123.1',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-bars"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Control remoto
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::text('remoto', $DatosActivo[0]->controlremoto, [
                                                                        '',
                                                                        'id' => 'remoto',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => 'Anydesk 123456789',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-bars"></i>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <br>
                                                            <?php
                                                            if ($DatosActivo[0]->lic_windows == 'S') {
                                                                $color3 = 'green';
                                                                $color4 = 'grey';
                                                                $activo3 = 'active';
                                                                $activo4 = '';
                                                                $chequeado3 = 'checked';
                                                                $chequeado4 = '';
                                                            } else {
                                                                $color3 = 'grey';
                                                                $color4 = 'red';
                                                                $activo3 = '';
                                                                $activo4 = 'active';
                                                                $chequeado3 = '';
                                                                $chequeado4 = 'checked';
                                                            }
                                                            ?>
                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Licencia de Windows
                                                                    </b>
                                                                </label>
                                                                <label class="option block">
                                                                    <div class="btn-group btn-group-toggle"
                                                                        data-toggle="buttons">
                                                                        <label
                                                                            class="btn btn-secondary <?= $activo3 ?>"
                                                                            onclick="COLOR1('S')">
                                                                            <i class="fa fa-1x" id="licencias"
                                                                                style="color:<?= $color3 ?>;"> Sí</i>
                                                                            <input type="radio" name="licencia"
                                                                                value="S" autocomplete="off"
                                                                                <?= $chequeado3 ?>>
                                                                        </label>
                                                                        <label
                                                                            class="btn btn-secondary <?= $activo4 ?>"
                                                                            onclick="COLOR1('N')">
                                                                            <i class="fa fa-1x" id="licencian"
                                                                                style="color:<?= $color4 ?>;"> No</i>
                                                                            <input type="radio" name="licencia"
                                                                                value="N" autocomplete="off"
                                                                                <?= $chequeado4 ?>>
                                                                        </label>
                                                                    </div>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-8">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Software instalado
                                                                    </b>
                                                                </label>
                                                                <?php
                                                                $Software = PanelSoftware::getSoftwareActivos();
                                                                $e = 0;
                                                                ?>
                                                                <table id="message-table"
                                                                    class="table allcp-form theme-warning br-t">
                                                                    <tr>
                                                                        {!! Form::hidden('programas[]', 300) !!}
                                                                        @foreach ($Software as $DatSof)
                                                                            <td>
                                                                                <label class="option block"
                                                                                    style="color:#34495e;">
                                                                                    <?php
                                                                                    $e++;
                                                                                    $seleccionado = '';
                                                                                    $Licencia = PanelSoftware::Programainstalado($DatosActivo[0]->id_activo, $DatSof->id_software);
                                                                                    if ($Licencia->count() > 0) {
                                                                                        $seleccionado = 'checked';
                                                                                    }
                                                                                    ?>
                                                                                    {!! Form::checkbox('programas[]', $DatSof->id_software, $seleccionado) !!}
                                                                                    <span
                                                                                        class="checkbox"></span><b><?= $DatSof->descripcion ?></b>
                                                                                </label>
                                                                            </td>
                                                                            <?php
                                                                            if ($e % 4 == 0) {
                                                                                echo '</tr><tr>';
                                                                            }
                                                                            ?>
                                                                        @endforeach
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <?php
                                 }

                                if(($Tipo[0]->campo1 != "") || ($Tipo[0]->campo2 != "") || ($Tipo[0]->campo3 != ""))
                                 {
                                  ?>
                                                        <div class="row">
                                                            <br>
                                                            <?php
                                 }

                                if($Tipo[0]->campo1 != "")
                                 {
                                  ?>
                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        <?= $Tipo[0]->campo1 ?>
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::textarea('campo1', $DatosActivo[0]->campo1, [
                                                                        '',
                                                                        'id' => 'campo1',
                                                                        'class' => 'gui-input',
                                                                        'style' => 'height: 58px;',
                                                                        'placeholder' => $Tipo[0]->campo1,
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-bars"></i>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                            <?php
                                 }

                                if($Tipo[0]->campo2 != "")
                                 {
                                  ?>
                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        <?= $Tipo[0]->campo2 ?>
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::textarea('campo2', $DatosActivo[0]->campo2, [
                                                                        '',
                                                                        'id' => 'campo2',
                                                                        'class' => 'gui-input',
                                                                        'style' => 'height: 58px;',
                                                                        'placeholder' => $Tipo[0]->campo2,
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-bars"></i>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                            <?php
                                 }

                                if($Tipo[0]->campo3 != "")
                                 {
                                  ?>
                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        <?= $Tipo[0]->campo3 ?>
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::textarea('campo3', $DatosActivo[0]->campo3, [
                                                                        '',
                                                                        'id' => 'campo3',
                                                                        'class' => 'gui-input',
                                                                        'style' => 'height: 58px;',
                                                                        'placeholder' => $Tipo[0]->campo3,
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-bars"></i>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                            <?php
                                 }

                                if(($Tipo[0]->campo1 != "") || ($Tipo[0]->campo2 != "") || ($Tipo[0]->campo3 != ""))
                                  echo "</div>";
                                ?>

                                                            <div class="row">
                                                                <br>
                                                                <div class="col-md-4">
                                                                    {!! Form::submit('Editar activo', ['class' => 'button']) !!}
                                                                    <br><br>
                                                                </div>
                                                            </div>
                                                            {!! Form::close() !!}
                                                        </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <script language="javascript" type="text/javascript">
                                        function COLOR(id1) {
                                            icono1 = document.getElementById('mantenimientos');
                                            icono2 = document.getElementById('mantenimienton');
                                            meses = document.getElementById('meses');
                                            fecha = document.getElementById('fechainicial');

                                            if (id1 == "S") {
                                                icono1.style.color = 'green';
                                                icono2.style.color = 'grey';
                                                meses.disabled = '';
                                                if (fecha.value == '') {
                                                    fecha.disabled = '';
                                                }
                                            } else {
                                                icono1.style.color = 'grey';
                                                icono2.style.color = 'red';
                                                meses.disabled = 'disabled';
                                                fecha.disabled = 'disabled';
                                                meses.value = '';
                                            }
                                        }

                                        function COLOR1(id1) {
                                            icono1 = document.getElementById('licencias');
                                            icono2 = document.getElementById('licencian');

                                            if (id1 == "S") {
                                                icono1.style.color = 'green';
                                                icono2.style.color = 'grey';
                                            } else {
                                                icono1.style.color = 'grey';
                                                icono2.style.color = 'red';
                                            }
                                        }
                                    </script>
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
    </body>

    </html>
@endforeach
