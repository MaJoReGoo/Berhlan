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
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.css')}}">

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
                    width: '100%'
                });
            });
            jQuery(document).ready(function($) {
                $("#tipo").select2({
                    closeOnSelect: true,
                    width: '100%'
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
                                <a href="{{ asset ('/panel/activos/consulta/parametrizada/detalle/')}}{{ $DatosActivo[0]->id_activo }}"
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
                        <a href="{{ asset ('/panel/activos/consulta/parametrizada/detalle/')}}{{ $DatosActivo[0]->id_activo }}"
                            class="btn btn-primary btn-sm ml10" title="Activos TIC > Consulta parametrizada">
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
                                                        <form action="{{ route('ModificarDB') }}" method="post"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            {!! Form::hidden('activo', $DatosActivo[0]->id_activo) !!}
                                                            {!! Form::hidden('tipo', $DatosActivo[0]->tipo) !!}
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Tipo activo fijo
                                                                        </b>
                                                                    </label>
                                                                    <label class="field select">
                                                                        <select name="tipo" id="tipo" required>
                                                                            <option
                                                                                value="<?= $DatosActivo[0]->tipo ?>">
                                                                                <?php
                                                                                $Tipo = PanelTipos::getTipo($DatosActivo[0]->tipo);
                                                                                echo $Tipo[0]->descripcion;
                                                                                ?>
                                                                            </option>
                                                                            <?php
                                                                            $Tipos = PanelTipos::getTiposActivos();
                                                                            ?>
                                                                            @foreach ($Tipos as $DatTip)
                                                                                <option
                                                                                    value="<?= $DatTip->id_tipoactivo ?>">
                                                                                    <?= $DatTip->descripcion ?>
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                    </label>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Colaborador
                                                                        </b>
                                                                    </label>
                                                                    <label class="field select">
                                                                        <select name="empleado" id="empleado" required>
                                                                            <option
                                                                                value="<?= $DatosActivo[0]->empleado ?>">
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
                                                                                <option
                                                                                    value="<?= $DatEmp->id_empleado ?>">
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
                                                                <div class="col-md-4">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Compañía
                                                                        </b>
                                                                    </label>
                                                                    <label class="field select">
                                                                        <select name="empresa" id="empresa" required>
                                                                            <option
                                                                                value="<?= $DatosActivo[0]->empresa ?>">
                                                                                <?php
                                                                                $Empresa = PanelEmpresas::getEmpresa($DatosActivo[0]->empresa);
                                                                                echo $Empresa[0]->nombre;
                                                                                ?>
                                                                            </option>
                                                                            <?php
                                                                            $Empresas = PanelEmpresas::getEmpresasActivas();
                                                                            ?>
                                                                            @foreach ($Empresas as $DatEmp)
                                                                                <option
                                                                                    value="<?= $DatEmp->id_empresa ?>">
                                                                                    <?= $DatEmp->nombre ?>
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <i class="arrow"></i>
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
                                                                        {!! Form::text('codigo_interno', $DatosActivo[0]->cod_interno, [
                                                                            '',
                                                                            'id' => 'codigo_interno',
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
                                                                        {!! Form::text('activo_fijo', $DatosActivo[0]->activo_fijo, [
                                                                            '',
                                                                            'id' => 'activo_fijo',
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
                                                                            Foto
                                                                        </b>
                                                                        <?php
                                                                        if ($DatosActivo[0]->foto != '') {
                                                                            $ruta = "window.open('" . $server . '/archivos/ActivosFijos/Fotos/' . $DatosActivo[0]->foto . "','_blank')";
                                                                            $icono = 'fa-file-image-o';
                                                                        } else {
                                                                            $ruta = '';
                                                                            $icono = 'fa-eye-slash ';
                                                                        }
                                                                        ?>
                                                                        &nbsp;
                                                                        <button type="button"
                                                                            style="background:#f7f9f9;"
                                                                            class="btn btn-default light"
                                                                            onclick="<?= $ruta ?>"
                                                                            title="<?= $DatosActivo[0]->foto ?>">
                                                                            <i class="fa <?= $icono ?> fa-lg"
                                                                                style="color:#6CBCED;"></i>
                                                                        </button>
                                                                    </label>
                                                                    <label
                                                                        class="field prepend-icon append-button file">
                                                                        <span class="button">
                                                                            JPG
                                                                        </span>
                                                                        {!! Form::file('file2', [
                                                                            '',
                                                                            'id' => 'file2',
                                                                            'accept' => '.pdf,.jpg,.jpeg,.png"',
                                                                            'class' => 'gui-file',
                                                                            'onChange' => "document.getElementById('uploader2').value = this.value;",
                                                                        ]) !!}
                                                                        {!! Form::text('uploader2', null, ['id' => 'uploader2', 'class' => 'gui-input', 'placeholder' => 'Foto']) !!}
                                                                        <label class="field-icon">
                                                                            <i class="fa fa-cloud-upload"></i>
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
                                                                                    style="color:<?= $color1 ?>;">
                                                                                    Sí</i>
                                                                                <input type="radio"
                                                                                    name="mantenimiento"
                                                                                    value="S" autocomplete="off"
                                                                                    <?= $chequeado1 ?>>
                                                                            </label>
                                                                            <label
                                                                                class="btn btn-secondary <?= $activo2 ?>"
                                                                                onclick="COLOR('N')">
                                                                                <i class="fa fa-times-circle fa-1x"
                                                                                    id="mantenimienton"
                                                                                    style="color:<?= $color2 ?>;">
                                                                                    No</i>
                                                                                <input type="radio"
                                                                                    name="mantenimiento"
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
                                                                } elseif ($DatosActivo[0]->fecha_mtto != null) {
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
                                                                        {!! Form::date('fechainicial', $DatosActivo[0]->fecha_mtto, [
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
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Acta firmada
                                                                        </b>
                                                                        <?php
                                                                        if ($DatosActivo[0]->acta_firmada != '') {
                                                                            $ruta = "window.open('" . $server . '/archivos/ActivosFijos/Actas_firmadas/' . $DatosActivo[0]->acta_firmada . "','_blank')";
                                                                            $icono = 'fa-file-image-o';
                                                                        } else {
                                                                            $ruta = '';
                                                                            $icono = 'fa-eye-slash ';
                                                                        }
                                                                        ?>
                                                                        &nbsp;
                                                                        <button type="button"
                                                                            style="background:#f7f9f9;"
                                                                            class="btn btn-default light"
                                                                            onclick="<?= $ruta ?>"
                                                                            title="<?= $DatosActivo[0]->acta_firmada ?>">
                                                                            <i class="fa <?= $icono ?> fa-lg"
                                                                                style="color:#b90202;"></i>
                                                                        </button>
                                                                    </label>
                                                                    <label
                                                                        class="field prepend-icon append-button file">
                                                                        <span class="button">
                                                                            PDF
                                                                        </span>
                                                                        {!! Form::file('file3', [
                                                                            '',
                                                                            'id' => 'file3',
                                                                            'accept' => '.pdf,.jpg,.jpeg,.png"',
                                                                            'class' => 'gui-file',
                                                                            'onChange' => "document.getElementById('uploader3').value = this.value;",
                                                                        ]) !!}
                                                                        {!! Form::text('uploader3', null, ['id' => 'uploader3', 'class' => 'gui-input', 'placeholder' => 'Acta']) !!}
                                                                        <label class="field-icon">
                                                                            <i class="fa fa-cloud-upload fa-lg"></i>
                                                                        </label>
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Estado
                                                                        </b>
                                                                    </label>
                                                                    <label class="field select">
                                                                        <select name="estado" id="estado"
                                                                            required>
                                                                            <option value="1"
                                                                                style="color:green;"
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
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Color
                                                                        </b>
                                                                    </label>
                                                                    <label class="field prepend-icon">
                                                                        {!! Form::text('color', $DatosActivo[0]->color, [
                                                                            '',
                                                                            'id' => 'color',
                                                                            'class' => 'gui-input',
                                                                            'placeholder' => 'Color',
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
                                                                    {!! Form::submit('Editar activo', ['class' => 'button']) !!}
                                                                    <br><br>
                                                                </div>
                                                            </div>
                                                        </form>
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
        {{--   <script>
            document.getElementById('ingresarActivosFijos').addEventListener('submit', function(event) {
                // Evitar que el formulario se envíe de forma predeterminada
                event.preventDefault();
                // Realizar la petición AJAX para enviar el formulario
                fetch(this.action, {
                        method: this.method,
                        body: new FormData(this),
                    })
                    .then(response => {
                        // Si la respuesta es exitosa, recargar la página
                        if (response.ok) {
                            Swal.fire({
                                icon: "success",
                                title: "Activo guardado Correctamente!",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error al enviar el formulario:', error);
                    });
            });
        </script> --}}
    </body>

    </html>
@endforeach
