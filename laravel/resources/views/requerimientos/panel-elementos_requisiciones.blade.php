<?php
$server = '/Berhlan/public';
?>

@foreach ($DatosUsuario as $DatLog)

    <head>
        <!-- -------------- Meta and Title -------------- -->

        <meta charset="utf-8">
        <title>
            Intranet | Requisición Personal | Requisición de equipos ó elementos

        </title>
        @include('includes-CDN/include-head')
        <link rel="stylesheet" href="{{ asset('css/requerimientos/panel-elementos_requisiciones.css') }}">
    </head>

    <body>
        <div class="loading">
            @include('loading')
        </div>

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
                                <a href="<?= $server ?>/panel/menu/4" title="Requisición de personal">
                                    <font color="#34495e">
                                        Requerimientos >
                                    </font>
                                    <font color="#b4c056">
                                        Requisición de equipos ó elementos
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="<?= $server ?>/panel/menu/118" class="btn btn-primary btn-sm ml10"
                            title="Inconformidades">
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

                                <table class="table theme-warning br-t d">
                                    <thead>
                                        <tr style="background-color:#39405a">
                                            <th>
                                                <font color="white">
                                                    Listado elementos solicitudes de requisición de personal
                                                </font>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tr>
                                        <td>
                                            <table id="elementos-table"
                                                class="table tc-checkbox-1 theme-warning br-t table-striped text-center text-dark ">
                                                <thead>
                                                    <tr style="background-color: #F8F8F8; color: black;">
                                                        <th style="text-align: center;">
                                                            Consecutivo
                                                        </th>
                                                        <th style="text-align: center;">
                                                            Centro de operación
                                                        </th>
                                                        <th style="text-align: center;">
                                                            Cargo
                                                        </th>
                                                        <th style="text-align: center;">
                                                            Fecha aproximada de ingreso
                                                        </th>
                                                        <th style="text-align: center;">
                                                            Estado
                                                        </th>
                                                        <th style="text-align: center;">
                                                            Detalle
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>

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

            </section>
        </div>

        <!-- -------------- Scripts -------------- -->
        @include('includes-CDN/include-script')
        <script type="module" src="{{ asset('/js/requerimientos/panel-elementos_requisiciones.js') }}"></script>

    </body>

@endforeach


