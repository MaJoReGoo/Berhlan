<?php
$server = '/Berhlan/public';

use App\Models\Parametrizacion\PanelUsuarios;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Requerimientos\PanelGrupos;
?>

@foreach ($DatosUsuario as $DatLog)
    @foreach ($DatosGrupo as $DatGru)
        <!DOCTYPE html>
        <html>

        <head>
            <!-- -------------- Meta and Title -------------- -->
            <meta charset="utf-8">
            <title>
                Intranet | Grupos | Asociar empleado
            </title>

            @include('includes-CDN/include-head')
            <link rel="stylesheet" href="{{ asset('/css/requerimientos/panel-empleadosAgregar.css') }}">
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
                                    <a href="<?= $server ?>/panel/requerimientos/grupos/modificar/<?= $DatGru->id_grupo ?>"
                                        title="Requerimientos > Grupos > Modificar">
                                        <font color="#34495e">
                                            Requerimientos > Grupos - Empleados >
                                        </font>
                                        <font color="#b4c056">
                                            Asociar
                                        </font>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                            <a href="<?= $server ?>/panel/requerimientos/grupos/modificar/<?= $DatGru->id_grupo ?>"
                                class="btn btn-primary btn-sm ml10" title="Requerimientos > Grupos > Modificar">
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
                                                <tr style="background-color:#39405a">
                                                    <th>
                                                        Asocie el empleado al grupo
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="allcp-form">
                                                            {!! Form::open([
                                                                'action' => 'Requerimientos\GruposRequerimientosPanelController@EmpleadosGruposAsociarDB',
                                                                'class' => 'form',
                                                                'id' => 'form-wizard',
                                                            ]) !!}
                                                            {!! Form::hidden('login', $DatLog->login) !!}
                                                            {!! Form::hidden('id_grupo', $DatGru->id_grupo) !!}

                                                            <div class="section">
                                                                <div class="col-md-4">
                                                                    <label style="color: #4ECCDB">
                                                                        Grupo
                                                                    </label>
                                                                    <label class="field prepend-icon">
                                                                        <b>
                                                                            <?= $DatGru->descripcion ?>
                                                                        </b>
                                                                    </label>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label style="color: #4ECCDB">
                                                                        Empleado
                                                                    </label>
                                                                    <label class="field select">
                                                                        <select name="empleado" id="empleado" required>
                                                                            <option value="">
                                                                                * Empleado
                                                                            </option>
                                                                            <?php
                                                                            $Usuarios = PanelUsuarios::getUsuariosActivos();
                                                                            ?>
                                                                            @foreach ($Usuarios as $DatUsr)
                                                                                <?php
                                                                                $Empleado = PanelEmpleados::getEmpleado($DatUsr->empleado);
                                                                                $Cargo = PanelCargos::getCargo($Empleado[0]->cargo);
                                                                                $Area = PanelAreas::getArea($Cargo[0]->area);
                                                                                ?>
                                                                                <option
                                                                                    value="<?= $Empleado[0]->id_empleado ?>">
                                                                                    <?php
                                                                                    echo $DatUsr->login;
                                                                                    echo ' - ';
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

                                                            <div class="section">
                                                                <div class="col-md-12">
                                                                    <br>
                                                                    {!! Form::submit('Asociar empleado', ['class' => 'button btn-primary']) !!}
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

                            <div class="chute chute-center pt30">
                                <div class="panel m10">
                                    <div class="table-responsive">
                                        <table id="message-table" class="table allcp-form theme-warning br-t">
                                            <thead>
                                                <tr>
                                                    <th colspan="4">
                                                        <font color="black">
                                                            Empleados asociados al grupo
                                                        </font>
                                                    </th>
                                                </tr>
                                            </thead>

                                            <thead>
                                                <tr style="background-color: #F8F8F8; color:#000000">
                                                    <th style="text-align: left">
                                                        #
                                                    </th>
                                                    <th style="text-align:left">
                                                        Empleado
                                                    </th>
                                                    <th style="text-align:left">
                                                        Cargo
                                                    </th>
                                                    <th style="text-align:left">
                                                        Centro de operación
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                $u = 1;
                                                $DatosEmpleados = PanelGrupos::getGrupoEmpleados($DatGru->id_grupo);
                                                ?>

                                                @foreach ($DatosEmpleados as $DatEmp)
                                                    <tr class="message-unread">
                                                        <td style="text-align:left">
                                                            <font color="#2A2F43">
                                                                <?php
                                                                echo $u;
                                                                $u++;
                                                                ?>
                                                            </font>
                                                        </td>

                                                        <td style="text-align: left ">
                                                            <i class="fa fa-user fa-lg" style="color:#6CBCED;"></i>
                                                            &nbsp;
                                                            <font color="#2A2F43">
                                                                <b>
                                                                    <?= $DatEmp->primer_nombre ?>
                                                                    <?= $DatEmp->ot_nombre ?>
                                                                    <?= $DatEmp->primer_apellido ?>
                                                                    <?= $DatEmp->ot_apellido ?>
                                                                </b>
                                                            </font>
                                                        </td>

                                                        <?php
                                                        $Cargo = PanelCargos::getCargo($DatEmp->cargo);
                                                        ?>
                                                        <td style="text-align: left">
                                                            @foreach ($Cargo as $DatCargo)
                                                                <font color="#2A2F43">
                                                                    <?= $DatCargo->descripcion ?>
                                                                    <br>
                                                                    <?php
                                                                    $Area = PanelAreas::getArea($DatCargo->area);
                                                                    ?>
                                                                    @foreach ($Area as $DatArea)
                                                                        <?php
                                                                        echo $DatArea->descripcion . ' - ';
                                                                        $Empresa = PanelEmpresas::getEmpresa($DatArea->empresa);
                                                                        ?>
                                                                        @foreach ($Empresa as $DatEmpresa)
                                                                            <?= $DatEmpresa->nombre ?>
                                                                        @endforeach
                                                                    @endforeach
                                                                </font>
                                                            @endforeach
                                                        </td>

                                                        <?php
                                                        $Centro = PanelCentrosOp::getCentroOp($DatEmp->centro_op);
                                                        ?>
                                                        <td style="text-align: left">
                                                            @foreach ($Centro as $DatCentro)
                                                                <font color="#2A2F43">
                                                                    <?= $DatCentro->descripcion ?>
                                                                </font>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endforeach
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

            @include('includes-CDN/include-script')
            <script type="module" src="{{ asset('/js/requerimientos/panel-empleadosAgregar.js') }}"></script>
        </body>

        </html>
    @endforeach
@endforeach
