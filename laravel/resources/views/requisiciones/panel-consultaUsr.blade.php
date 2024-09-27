<?php

use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Requisiciones\PanelRequisiciones;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Requisición de personal | Consulta
        </title>
        @include('includes-CDN/include-head')
        <link rel="stylesheet" href="{{ asset('css/requisiciones/panel-consultaUsr.css') }}">
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
                                <a href="{{ asset('/panel/menu/32') }}" title="Requisiciones">
                                    <font color="#34495e">
                                        Requisiciones >
                                    </font>
                                    <font color="#b4c056">
                                        Consulta solicitudes
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset('/panel/menu/32') }}" class="btn btn-primary btn-sm ml10"
                            title="Requisiciones">
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
                                                            'action' => 'Requisiciones\ConsultasRequisicionesPanelController@ConsultaUsrListado',
                                                            'class' => 'form',
                                                            'id' => 'form-wizard',
                                                        ]) !!}
                                                        <div class="row">
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
                                                                        'placeholder' => 'Solicitud',
                                                                        'min' => '1',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-user-plus"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Cargo
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
                                                                        Centro de operación
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

                                                            <div class="col-md-3">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Motivo de la solicitud
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="motivo" id="motivo">
                                                                        <option value="">Motivo de la solicitud
                                                                        </option>
                                                                        <option value="RP">Reemplazo de personal
                                                                        </option>
                                                                        <option value="CN">Cargo nuevo / Incremento
                                                                            de personal</option>
                                                                        <option value="LM">Licencia de maternidad
                                                                        </option>
                                                                        <option value="IP">Incapacidad permanente
                                                                        </option>
                                                                    </select>

                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Reemplaza a
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::text('reemplaza', null, [
                                                                        '',
                                                                        'id' => 'reemplaza',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => 'Reemplaza a',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-user-times"></i>
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
                                                                        <?php
                                                                        $estados = PanelRequisiciones::getEstadosSolicitud();
                                                                        ?>
                                                                        @foreach ($estados as $DatEst)
                                                                            <option value="<?= $DatEst->id_estado ?>">
                                                                                <?= $DatEst->descripcion ?>
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
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Fecha de cierre desde
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('cierredesde', null, ['', 'id' => 'cierredesde', 'class' => 'gui-input', 'maxlength' => '10']) !!}
                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Fecha de cierre hasta
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('cierrehasta', null, ['', 'id' => 'cierrehasta', 'class' => 'gui-input', 'maxlength' => '10']) !!}
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
                    </div>
                </section>
            </section>
        </div>

        @include('includes-CDN/include-script')

        <script type="module">
            import {
                configureSelect2
            } from '{{ asset('/js/select2funcion.js') }}';
            $(document).ready(function() {
                configureSelect2();
            });
        </script>
    </body>

    </html>
@endforeach
