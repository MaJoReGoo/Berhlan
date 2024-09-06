<?php
$server = '/Berhlan/public';
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Empleados
        </title>
        @include('includes-CDN/include-head')
        <link rel="stylesheet" href="{{asset('css/parametrizacion/panel-empleados.css')}}">
    </head>

    <body class="sales-stats-page">
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
                                <a href="<?= $server ?>/panel/menu/7" title="Parametrizacion">
                                    <font color="#34495e">
                                        Parametrización > Empleados
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">

                        <a class="btn btn-primary btn-sm ml10" title="Crear empleados" data-toggle="modal" data-target="#modalAgregarEmpleado">
                            <i class="fa-solid fa-user-plus fa-xl"></i>
                        </a>

                        <a class="btn btn-primary btn-sm ml10" name="cotizacion2" href="{{ route('empleados.siesa') }}"
                            title="Actualizar empleados">
                            <i class="fa-solid fa-user-tie fa-xl"></i>
                        </a>
                        <a class="btn btn-primary btn-sm ml10" name="cotizacion2" href="{{ route('cargos.siesa') }}"
                            title="Actualizar cargos">
                            <i class="fa-regular fa-id-card fa-xl"></i>
                        </a>
                        <a class="btn btn-primary btn-sm ml10" name="cotizacion2" href="{{ route('areas.siesa') }}"
                            title="Actualizar areas">
                            <i class="fa-solid fa-users-gear fa-xl"></i>
                        </a>
                        <a class="btn btn-primary btn-sm ml10" name="cotizacion2" href="{{ route('centros.siesa') }}"
                            title="Actualizar centros">
                            <i class="fa-solid fa-building-user fa-xl"></i>
                        </a>

                        <a class="btn btn-primary btn-sm ml10" name="cotizacion2"
                            href="{{ route('empleadosina.siesa') }}" title="Inactivar empleados">
                            <i class="fa-solid fa-user-minus fa-xl"></i>
                        </a>


                        <a href="<?= $server ?>/panel/menu/7" class="btn btn-primary btn-sm ml10"
                            title="Parametrización">
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
                        <div class="panel m10">
                            <!-- -------------- Message Body -------------- -->
                            <div class="table-responsive">
                                <table class="table allcp-form theme-warning br-t">
                                    <thead>
                                        <tr style="background-color:#39405a">
                                            <th>
                                                <font color="white">
                                                    Empleados
                                                </font>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tr>
                                        <td>
                                            <table id="tabla-empleados"
                                                class="table tc-checkbox-1 theme-warning br-t table-striped text-dark">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center;">
                                                            #
                                                        </th>
                                                        <th style="text-align: left">
                                                            E.
                                                        </th>
                                                        <th style="text-align: left">
                                                            Identificación
                                                        </th>
                                                        <th style="text-align: left">
                                                            Nombres
                                                        </th>
                                                        <th style="text-align: left">
                                                            Apellidos
                                                        </th>
                                                        <th style="text-align: left">
                                                            Cargo
                                                        </th>
                                                        <th style="text-align: left">
                                                            Centro de operación
                                                        </th>
                                                        <th style="text-align: left">
                                                            Fecha de
                                                            <br>
                                                            nacimiento
                                                        </th>
                                                        <th style="text-align: center">
                                                            Modificar
                                                        </th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php $u = 1; ?>

                                                    @foreach ($DatosEmpleados as $DatEmpleados)
                                                        <tr class="message-unread">
                                                            <td style="text-align: right">
                                                                <font color="#2A2F43">
                                                                    <?php
                                                                    print $u;
                                                                    $u++;
                                                                    ?>
                                                                </font>
                                                            </td>
                                                            <td style="text-align: right">
                                                                <?php
                                                                if ($DatEmpleados->estado == '0') {
                                                                    echo "<i class=\"fa fa-user fa-lg\" style=\"color:#F6565A\">.</i>";
                                                                } else {
                                                                    echo "<i class=\"fa fa-user fa-lg\" style=\"color:#AEBF25\"></i>";
                                                                }
                                                                ?>
                                                            </td>

                                                            <td style="text-align: left ">
                                                                <font color="#2A2F43">
                                                                    <b>
                                                                        <?= $DatEmpleados->identificacion ?>
                                                                    </b>
                                                                </font>
                                                            </td>

                                                            <td style="text-align: left ">
                                                                <font color="#2A2F43">
                                                                    {{ $DatEmpleados->primer_nombre . ' ' . $DatEmpleados->ot_nombre }}
                                                                </font>
                                                            </td>

                                                            <td style="text-align: left">
                                                                <font color="#2A2F43">
                                                                    {{ $DatEmpleados->primer_apellido . ' ' . $DatEmpleados->ot_apellido }}
                                                                </font>
                                                            </td>

                                                            <td style="text-align: left">
                                                                <font color="#2A2F43">
                                                                    {{ $DatEmpleados->cargo }}
                                                                </font>
                                                            </td>


                                                            <td style="text-align: left">
                                                                <font color="#2A2F43">
                                                                    {{ $DatEmpleados->centro_op }}
                                                                </font>
                                                            </td>

                                                            <td style="text-align: left">
                                                                <font color="#2A2F43">
                                                                    <?= $DatEmpleados->fecha_nacimiento ?>
                                                                </font>
                                                            </td>

                                                            <td style="text-align: center">
                                                                <button type="button" class="btn btn-default light"
                                                                    onclick="window.location.href='<?= $server ?>/panel/parametrizacion/empleados/modificar/<?= $DatEmpleados->id_empleado ?>'">
                                                                    <i class="fa fa-pencil fa-lg"
                                                                        style="color:#AEBF25;"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- -------------- /Column Center -------------- -->
                    </div>

                </section>
                <!-- -------------- /Content -------------- -->
            </section>
            @include('parametrizacion.modales.modal-agregarEmpleado')
        </div>

        @include('includes-CDN/include-script')

        <script type="module" src="{{ asset('js/parametrizacion/panel-empleados.js') }}"></script>

    </body>

    </html>
@endforeach
