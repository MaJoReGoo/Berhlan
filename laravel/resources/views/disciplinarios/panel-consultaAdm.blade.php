<?php

use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Disciplinarios\PanelMotivos;
use App\Models\Disciplinarios\PanelTipofaltas;
use App\Models\Disciplinarios\PanelSolicitudes;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Procesos disciplinarios | Consulta adm
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

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <link rel="stylesheet" type="text/css" href="{{ asset ('/public/css/disciplinarios/panel-consultaAdm.blade.css')}}">

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
                                <a href="{{ asset ('/panel/menu/45')}}" title="Procesos disciplinarios">
                                    <font color="#34495e">
                                        Procesos disciplinarios >
                                    </font>
                                    <font color="#b4c056">
                                        Consulta adm. solicitudes
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset ('/panel/menu/45')}}" class="btn btn-primary btn-sm ml10"
                            title="Procesos disciplinarios">
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
                                                    Consulta parametrizada
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="allcp-form">
                                                        {!! Form::open([
                                                            'action' => 'Disciplinarios\ConsultasDisciplinariosPanelController@ConsultaAdmListado',
                                                            'class' => 'form',
                                                            'id' => 'form-wizard',
                                                        ]) !!}
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Colaborador que cometió la falta
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::text('empleado', null, [
                                                                        '',
                                                                        'id' => 'empleado',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => 'Identificación ó Nombre',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-user"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Número de solicitud
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::number('solicitud', null, [
                                                                        '',
                                                                        'id' => 'solicitud',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => 'Proceso disciplinario',
                                                                        'min' => '1',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i>PD -</i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <br><br>
                                                                {!! Form::submit('Consultar', ['class' => 'button']) !!}
                                                                <br><br>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <br>
                                                                <hr>
                                                                </hr>
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Otros parámetros de consulta
                                                                    </b>
                                                                    <br><br><br>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
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
                                                                        <option value="0">
                                                                            Atendida, finalizada
                                                                        </option>
                                                                        <option value="1">
                                                                            En proceso
                                                                        </option>
                                                                    </select>

                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Usuario que solicita
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="usr_solicita" id="usr_solicita">
                                                                        <option value="">
                                                                            Solicitado por
                                                                        </option>
                                                                        <?php
                                                                        $UsrSolicita = PanelSolicitudes::UsrSolicitaSolicitudes();
                                                                        ?>
                                                                        @foreach ($UsrSolicita as $DatUrs)
                                                                            <?php
                                                                            $Empleado = PanelEmpleados::getEmpleado($DatUrs->usr_solicita);
                                                                            $Cargo = PanelCargos::getCargo($Empleado[0]->cargo);
                                                                            $Area = PanelAreas::getArea($Cargo[0]->area);
                                                                            ?>
                                                                            <option
                                                                                value="<?= $DatUrs->usr_solicita ?>">
                                                                                <?php
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
                                                        </div>

                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-3">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Fecha en que se cometió la falta desde
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('faltadesde', null, ['', 'id' => 'soldesde', 'class' => 'gui-input', 'maxlength' => '10']) !!}
                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Fecha en que se cometió la falta hasta
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('faltahasta', null, ['', 'id' => 'solhasta', 'class' => 'gui-input', 'maxlength' => '10']) !!}
                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Tipo de falta
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="tpfalta" id="tpfalta">
                                                                        <option value="">
                                                                            Tipo de falta
                                                                        </option>
                                                                        <?php
                                                                        $Faltas = PanelTipofaltas::TipofaltasActivas();
                                                                        ?>
                                                                        @foreach ($Faltas as $DatFal)
                                                                            <option
                                                                                value="<?= $DatFal->id_tipofalta ?>">
                                                                                <?= $DatFal->descripcion ?>
                                                                            </option>
                                                                        @endforeach
                                                                    </select>

                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Causa de la solicitud
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::text('causa', null, ['', 'id' => 'causa', 'class' => 'gui-input', 'placeholder' => 'Palabra clave']) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-book"></i>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-3">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Motivo de cierre
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="motivo" id="motivo">
                                                                        <option value="">
                                                                            Motivo de cierre
                                                                        </option>
                                                                        <?php
                                                                        $Motivos = PanelMotivos::MotivosActivos();
                                                                        ?>
                                                                        @foreach ($Motivos as $DatMot)
                                                                            <option
                                                                                value="<?= $DatMot->id_motivocierre ?>">
                                                                                <?= $DatMot->descripcion ?>
                                                                            </option>
                                                                        @endforeach
                                                                    </select>

                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Usuario que atendió solicitud
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="usr_cierre" id="usr_cierre">
                                                                        <option value="">
                                                                            Atendido por
                                                                        </option>
                                                                        <?php
                                                                        $Usrcierran = PanelSolicitudes::UsrCierreSolicitudes();
                                                                        ?>
                                                                        @foreach ($Usrcierran as $DatUrc)
                                                                            <?php
                                                                            $Empleado = PanelEmpleados::getEmpleado($DatUrc->usr_cierre);
                                                                            $Cargo = PanelCargos::getCargo($Empleado[0]->cargo);
                                                                            $Area = PanelAreas::getArea($Cargo[0]->area);
                                                                            ?>
                                                                            <option value="<?= $DatUrc->usr_cierre ?>">
                                                                                <?php
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
                                                                        @endforeach
                                                                    </select>

                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color:#34495e">
                                                                    <b>
                                                                        Fecha de cierre desde
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('cierredesde', null, ['', 'id' => 'cierredesde', 'class' => 'gui-input', 'maxlength' => '10']) !!}
                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color:#34495e">
                                                                    <b>
                                                                        Fecha de cierre hasta
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('cierrehasta', null, ['', 'id' => 'cierrehasta', 'class' => 'gui-input', 'maxlength' => '10']) !!}
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-3">
                                                                <label style="color:#34495e">
                                                                    <b>
                                                                        Fecha desde
                                                                        (llamado a descargos / medida correctiva)
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('descargosdesde', null, [
                                                                        '',
                                                                        'id' => 'descargosdesde',
                                                                        'class' => 'gui-input',
                                                                        'maxlength' => '10',
                                                                    ]) !!}
                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color:#34495e">
                                                                    <b>
                                                                        Fecha hasta
                                                                        (llamado a descargos / medida correctiva)
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('descargoshasta', null, [
                                                                        '',
                                                                        'id' => 'descargoshasta',
                                                                        'class' => 'gui-input',
                                                                        'maxlength' => '10',
                                                                    ]) !!}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                    <br>
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

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js')}}"></script>

        <script src="{{ asset ('/js/select2.js')}}"></script>
    </body>

    </html>
@endforeach
