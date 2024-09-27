<?php

?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Requisición de personal | Gestion de ingresos
        </title>
        @include('includes-CDN/include-head')
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
                                <a href="{{ asset ('/panel/menu/32')}}" title="Requisiciones">
                                    <font color="#34495e">
                                        Requisiciones >
                                    </font>
                                    <font color="#b4c056">
                                        Gestión de ingresos
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset ('/panel/menu/32')}}" class="btn btn-primary btn-sm ml10"
                            title="Requisiciones">
                            REGRESAR &nbsp;
                            <span class="fa fa-arrow-left"></span>
                        </a>
                    </div>
                </header>
                <!-- -------------- /Topbar -------------- -->

                <!-- -------------- Content -------------- -->
                <section>
                    <br>
                    <div class="d-flex justify-content-center cambio-listado" style="gap:20px">
                        <button id="ingresos" class="btn btn-success">Listado de ingresos</button>
                        <button id="examenes_ingresos" class="btn btn-danger">Examenes ingresos</button>
                    </div>
                    <div class="chute chute-center p30">
                        <!-- -------------- Column Center -------------- -->
                        <div class="panel m3">
                            <!-- -------------- Message Body -------------- -->
                            <div class="nano-content">
                                <!-- -------------- Message Body -------------- -->
                                <div class="table-responsive">

                                    <table class="table theme-warning br-t info-ingresos">
                                        <thead>
                                            <tr style="background-color:#39405a">
                                                <th>
                                                    <font color="white">
                                                        Listado de ingresos
                                                    </font>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tr>
                                            <td>
                                                <table id="table-gestion_ingresos"
                                                    class="table table-hover text-center text-dark">
                                                    <thead>
                                                        <tr style="background-color: #F8F8F8; color: black;">
                                                            <th style="text-align: center;">
                                                                Consecutivo
                                                            </th>
                                                            <th style="text-align: center;">
                                                                Nombre
                                                            </th>
                                                            <th style="text-align: center;">
                                                                Genero
                                                            </th>
                                                            <th style="text-align: center;">
                                                                Cedula
                                                            </th>
                                                            <th style="text-align: center;">
                                                                Correo
                                                            </th>
                                                            <th style="text-align: center;">
                                                                Teléfono
                                                            </th>
                                                            <th style="text-align: center;">
                                                                Estado
                                                            </th>
                                                            <th style="text-align: center;">
                                                                Gestionar
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


                                    <table class="table theme-warning br-t info-examenes-ingresos" hidden>
                                        <thead>
                                            <tr style="background-color:#39405a">
                                                <th>
                                                    <font color="white">
                                                        Examenes de ingresos
                                                    </font>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tr>
                                            <td>
                                                <table id="table-examenes_ingresos"
                                                    class="table table-hover text-center text-dark">
                                                    <thead>
                                                        <tr style="background-color: #F8F8F8; color: black;">
                                                            <th style="text-align: center;">
                                                                Consecutivo
                                                            </th>
                                                            <th style="text-align: center;">
                                                                Cedula
                                                            </th>
                                                            <th style="text-align: center;">
                                                                Nombre
                                                            </th>
                                                            <th style="text-align: center;">
                                                                Lugar examen
                                                            </th>
                                                            <th style="text-align: center;">
                                                                Hora examen
                                                            </th>
                                                            <th style="text-align: center;">
                                                                Estado
                                                            </th>
                                                            <th style="text-align: center;">
                                                                Resultado
                                                            </th>
                                                            <th style="text-align: center;">
                                                                Concepto
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


                                    <!-- Modal -->
                                    <div class="modal fade allcp-form" id="modalGestionarIngresos" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-center" id="infoIngreso"></h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-2 text-center">
                                                            <label style="color: #34495e;">
                                                                <b>Consecutivo</b>
                                                            </label>
                                                            <p class="text-dark" id="consecutivo"></p>
                                                        </div>

                                                        <div class="col-md-4 text-center">
                                                            <label style="color: #34495e;">
                                                                <b>Nombre</b>
                                                            </label>
                                                            <p class="text-dark" id="nombre_soli_ingreso"></p>
                                                        </div>

                                                        <div class="col-md-3 text-center">
                                                            <label style="color: #34495e;">
                                                                <b>Genero</b>
                                                            </label>
                                                            <p class="text-dark" id="genero_soli_ingreso"></p>
                                                        </div>

                                                        <div class="col-md-3 text-center">
                                                            <label style="color: #34495e;">
                                                                <b>Cedula</b>
                                                            </label>
                                                            <p class="text-dark" id="cedula_soli_ingreso"></p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-2 text-center">
                                                            <label style="color: #34495e;">
                                                                <b>Correo</b>
                                                            </label>
                                                            <p class="text-dark" id="correo_soli_ingreso"></p>
                                                        </div>

                                                        <div class="col-md-4 text-center">
                                                            <label style="color: #34495e;">
                                                                <b>Telefono</b>
                                                            </label>
                                                            <p class="text-dark" id="telefono_soli_ingreso"></p>
                                                        </div>

                                                        <div class="col-md-3 text-center">
                                                            <label style="color: #34495e;">
                                                                <b>Estado</b>
                                                            </label>
                                                            <p class="text-dark" id="estado_diligencia_ingreso"></p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <form id="gestionarIngreso"
                                                        action="{{ route('gestionarIngreso') }}" method="POST">
                                                        @csrf
                                                        <div class="row d-flex justify-content-center">
                                                            <input type="hidden" name="id_soli_ingreso"
                                                                id="id_soli_ingreso">
                                                            <div class="col-md-3 text-center">
                                                                <label style="color: #34495e;">
                                                                    <b>Fecha inducción</b>
                                                                </label>
                                                                <label class="field">
                                                                    <input style="text-align: center;" type="date"
                                                                        class="gui-input" name="fecha_induccion"
                                                                        id="fecha_induccion" required>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-3 text-center">
                                                                <label style="color: #34495e;">
                                                                    <b>Fecha inicio laboral</b>
                                                                </label>
                                                                <label class="field">
                                                                    <input style="text-align: center;" type="date"
                                                                        class="gui-input" name="fecha_inicio_laboral"
                                                                        id ="fecha_inicio_laboral" required>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-2" id="gestionar">
                                                                <br>
                                                                <br>
                                                                <button class="btn btn-primary">Gestionar</button>
                                                            </div>

                                                        </div>
                                                    </form>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- -------------- /Column Center -------------- -->

                </section>

                <!-- -------------- /Content -------------- -->
            </section>

        </div>

        @include('includes-CDN/include-script')
        <script type="module" src="{{ asset('/js/requisiciones/panel-gestion_de_ingresos.js') }}"></script>

    </body>

    </html>
@endforeach
