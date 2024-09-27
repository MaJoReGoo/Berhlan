<?php

use App\Models\Requerimientos\PanelGrupos;
use App\Models\Requerimientos\PanelCategorias;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Parametrizacion\PanelEmpresas;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Requerimientos | Consulta
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

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="{{ asset('/panelfiles/assets/img/favicon.ico') }}">

        <!-- Editor -->
        <script type="text/javascript" src="{{ asset('/panelfiles/ckeditor/ckeditor.js') }}"></script>

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



        <link rel="stylesheet" type="text/css"
            href="{{ asset('/public/css/requerimientos/panel-consultaGruFormulario.blade.css') }}">


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
                                <a href="{{ asset('/panel/requerimientos/consultagru') }}"
                                    title="Requerimientos > Consulta parametrizada">
                                    <font color="#34495e">
                                        Requerimientos > Consulta parametrizada >
                                    </font>
                                    <font color="#b4c056">
                                        Grupo <?= $nomgrupo[0]->descripcion ?>
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset('/panel/requerimientos/consultagru') }}" class="btn btn-primary btn-sm ml10"
                            title="Requerimientos > Consulta parametrizada">
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
                                            <tr>
                                                <th style="background-color:#67d3e0; color:#34495e; text-align:left;">
                                                    Consulta parametrizada para el grupo
                                                    <?= $nomgrupo[0]->descripcion ?>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="allcp-form">
                                                        {!! Form::open([
                                                            'action' => 'Requerimientos\ConsultasRequerimientosPanelController@ConsultaGruListado',
                                                            'class' => 'form',
                                                            'id' => 'form-wizard',
                                                        ]) !!}
                                                        {!! Form::hidden('grupo', $Grupo) !!}
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Número de requerimiento
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::number('requerimiento', null, [
                                                                        '',
                                                                        'id' => 'descripcion',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => 'Requerimiento',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-wrench"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Estado de la solicitud
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="estado" id="estado">
                                                                        <option value="">
                                                                            Estado
                                                                        </option>
                                                                        <option value="1">Pendiente de asignación
                                                                        </option>
                                                                        <option value="2">Asignado, en proceso
                                                                        </option>
                                                                        <option value="3">Atendido, pendiente
                                                                            encuesta de satisfacción</option>
                                                                        <option value="4">Finalizado</option>
                                                                    </select>

                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Usuario que requiere
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="empleado" id="empleado">
                                                                        <option value="">
                                                                            Colaborador
                                                                        </option>
                                                                        <?php
                                                                        $Empleado = PanelEmpleados::EmpleadosT();
                                                                        ?>
                                                                        @foreach ($Empleado as $DatEmp)
                                                                            <?php
                                                                            $Cargo = PanelCargos::getCargo($DatEmp->cargo);
                                                                            $Area = PanelAreas::getArea($Cargo[0]->area);
                                                                            ?>
                                                                            <option value="<?= $DatEmp->id_empleado ?>">
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

                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Centro de operación de quién requiere
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="centro_op" id="centro_op">
                                                                        <option value="">
                                                                            Centro de operación
                                                                        </option>
                                                                        <?php
                                                                        $Centros = PanelCentrosOp::getCentrosOp();
                                                                        ?>
                                                                        @foreach ($Centros as $DatCnts)
                                                                            <option value="<?= $DatCnts->id_centro ?>">
                                                                                <?= $DatCnts->descripcion ?>
                                                                            </option>
                                                                        @endforeach
                                                                    </select>

                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Cargo de quién requiere
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="cargo" id="cargo">
                                                                        <option value="">
                                                                            Cargo
                                                                        </option>
                                                                        <?php
                                                                        $Cargos = PanelCargos::getCargos();
                                                                        ?>
                                                                        @foreach ($Cargos as $DatCrg)
                                                                            <?php
                                                                            $Area = PanelAreas::getArea($DatCrg->area);
                                                                            foreach ($Area as $DatArea) {
                                                                                $Empresa = PanelEmpresas::getEmpresa($DatArea->empresa);
                                                                                $NombreArea = $DatArea->descripcion;
                                                                                foreach ($Empresa as $DatEmpresa) {
                                                                                    $NombreEmpresa = $DatEmpresa->nombre;
                                                                                }
                                                                            }
                                                                            ?>
                                                                            <option value="<?= $DatCrg->id_cargo ?>">
                                                                                <?= $DatCrg->descripcion . ' - ' . $NombreArea . ' - ' . $NombreEmpresa ?>
                                                                            </option>
                                                                        @endforeach
                                                                    </select>

                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Fecha de solicitud desde
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('soldesde', null, ['', 'id' => 'soldesde', 'class' => 'gui-input', 'maxlength' => '10']) !!}
                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Fecha de solicitud hasta
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('solhasta', null, ['', 'id' => 'solhasta', 'class' => 'gui-input', 'maxlength' => '10']) !!}
                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Que el requerimiento contenga
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::text('descripcion', null, [
                                                                        '',
                                                                        'id' => 'descripcion',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => 'Descripción',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-server"></i>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Usuario del grupo, que crea el requerimiento
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="usrcrea" id="usrcrea">
                                                                        <option value="">
                                                                            Usuario del grupo
                                                                        </option>
                                                                        <?php
                                                                        $EmpleadoGrupo = PanelGrupos::getGrupoEmpleados($Grupo);
                                                                        ?>
                                                                        @foreach ($EmpleadoGrupo as $DatEmG)
                                                                            <option
                                                                                value="<?= $DatEmG->id_empleado ?>">
                                                                                <?= $DatEmG->primer_nombre ?>
                                                                                <?= $DatEmG->ot_nombre ?>
                                                                                <?= $DatEmG->primer_apellido ?>
                                                                                <?= $DatEmG->ot_apellido ?>
                                                                            </option>
                                                                        @endforeach
                                                                    </select>

                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Asignado / Atendido por
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="atiende" id="atiende">
                                                                        <option value="">
                                                                            Usuario que atiende
                                                                        </option>
                                                                        <?php
                                                                        $EmpleadoGrupo = PanelGrupos::getGrupoEmpleados($Grupo);
                                                                        ?>
                                                                        @foreach ($EmpleadoGrupo as $DatEmG)
                                                                            <option
                                                                                value="<?= $DatEmG->id_empleado ?>">
                                                                                <?= $DatEmG->primer_nombre ?>
                                                                                <?= $DatEmG->ot_nombre ?>
                                                                                <?= $DatEmG->primer_apellido ?>
                                                                                <?= $DatEmG->ot_apellido ?>
                                                                            </option>
                                                                        @endforeach
                                                                    </select>

                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Fecha de cierre desde
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('cierredesde', null, ['', 'id' => 'cierredesde', 'class' => 'gui-input']) !!}
                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Fecha de cierre hasta
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('cierrehasta', null, ['', 'id' => 'cierrehasta', 'class' => 'gui-input']) !!}
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Categoría de cierre
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="categoria" id="categoria">
                                                                        <option value="">
                                                                            Categoría
                                                                        </option>
                                                                        <?php
                                                                        $Categorias = PanelCategorias::getCategoriasGrupo($Grupo);
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
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Criticidad
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="criticidad" id="criticidad">
                                                                        <option value="">
                                                                            Criticidad
                                                                        </option>
                                                                        <option value="1">Crítico</option>
                                                                        <option value="2">Alto</option>
                                                                        <option value="3">Medio</option>
                                                                        <option value="4">Bajo</option>
                                                                    </select>

                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Apreciación del usuario
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="apreciacion" id="apreciacion">
                                                                        <option value="">
                                                                            Apreciación
                                                                        </option>
                                                                        <option value="M">Muy satisfecho</option>
                                                                        <option value="S">Satisfecho</option>
                                                                        <option value="I">Insatisfecho</option>
                                                                    </select>

                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Fecha de apreciación desde
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('aprdesde', null, ['', 'id' => 'aprdesde', 'class' => 'gui-input']) !!}
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Fecha de apreciación hasta
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('aprhasta', null, ['', 'id' => 'aprhasta', 'class' => 'gui-input']) !!}
                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Controla reintegro
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="reintegro" id="reintegro">
                                                                        <option value="">
                                                                            Reintegro
                                                                        </option>
                                                                        <option value="S">Sí controla reintegro
                                                                        </option>
                                                                    </select>

                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Proyecto / Depende de terceros
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="depende" id="depende">
                                                                        <option value=""></option>
                                                                        <option value="T">Depende de terceros
                                                                        </option>
                                                                        <option value="P">Es un proyecto</option>
                                                                    </select>

                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <br><br>
                                                                {!! Form::submit('Consultar', ['class' => 'button']) !!}
                                                                <br><br>
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

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script src="{{ asset('/js/select2.js') }}"></script>

        <!-- -------------- /Scripts -------------- -->
    </body>

    </html>
@endforeach
