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
            Intranet | Requisición de personal | Consulta adm
        </title>
        @include('includes-CDN/include-head')
        <link rel="stylesheet" href="{{asset('css/requisiciones/panel-consultaAdm.css')}}">
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
                                <a href="<?= $server ?>/panel/menu/32" title="Requisiciones">
                                    <font color="#34495e">
                                        Requisiciones >
                                    </font>
                                    <font color="#b4c056">
                                        Consulta adm. solicitudes
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="<?= $server ?>/panel/menu/32" class="btn btn-primary btn-sm ml10"
                            title="Requisiciones">
                            REGRESAR &nbsp;
                            <span class="fa fa-arrow-left"></span>
                        </a>
                    </div>
                </header>
                <!-- -------------- /Topbar -------------- -->

                <!-- -------------- Content -------------- -->
                <section id="content" class="table-layout animated fadeIn">


                        <!-- -------------- Column Center -------------- -->
                        <div class="panel m10">
                            <!-- -------------- Message Body -------------- -->
                            <div class="table-responsive">

                                <table class="table theme-warning br-t">
                                    <thead>
                                        <tr style="background-color:#39405a">
                                            <th>
                                                <font color="white">
                                                    Consulta parametrizada
                                                </font>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tr>
                                        <td>
                                            <table id="table-solicitudes"
                                                class="table tc-checkbox-1 theme-warning br-t table-striped text-center text-dark">
                                                <thead>
                                                    <tr style="background-color: #F8F8F8; color: black;">
                                                        <th style="text-align: center;">
                                                            # Solicitud
                                                        </th>
                                                        <th style="text-align: center;">
                                                            Solicitada por
                                                        </th>
                                                        <th style="text-align: center;">
                                                            Centro operación
                                                        </th>
                                                        <th style="text-align: center;">
                                                            Cargo
                                                        </th>
                                                        <th style="text-align: center;">
                                                            Motivo
                                                        </th>
                                                        <th style="text-align: center;">
                                                            Fecha solicitud
                                                        </th>
                                                        <th style="text-align: center;">
                                                            Estado
                                                        </th>
                                                        <th style="text-align: center;">
                                                            Mas info
                                                        </th>

                                                    </tr>
                                                </thead>

                                                <br>
                                                <tbody>
                                                </tbody>

                                            </table>

                                        </td>
                                    </tr>
                                </table>

                            </div>


                        </div>
                        <!-- -------------- /Column Center -------------- -->

                </section>
                <!-- -------------- /Content -------------- -->
            </section>
        </div>

        @include('includes-CDN/include-script')
        <script type="module" src="{{asset('/js/requisiciones/panel-consultaAdm.js')}}"></script>

    </body>

    </html>
@endforeach
