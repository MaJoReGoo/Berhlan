<?php

?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Requisición de personal | Gestión de permisos de autorización
        </title>
        @include('includes-CDN/include-head')
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
                                <a href="{{ asset('/panel/menu/32') }}" title="Ssl">
                                    <font color="#34495e">
                                        Requisición de personal >
                                    </font>
                                    <font color="#b4c056">
                                        Gestión de permisos de autorización
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">

                        <a href="{{ asset('/panel/menu/128') }}" class="btn btn-primary btn-sm ml10"
                            title="Requisición de personal">
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
                        <br>
                        <div class="panel m3 notificaciones">
                            <!-- -------------- Message Body -------------- -->
                            <div class="nano-content">
                                <div class="table-responsive allcp-form" style="padding: 20px;">
                                    <p style="color: black;">Se parametrizan las personas que tendran permisos de
                                        autorización de:</p>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-10 m4">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr style="background-color:#39405a; color:white;">
                                                        <th style="text-align: center;">Nivel</th>
                                                        <th style="text-align: center;">Descripción</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="color: black;">
                                                    <tr>
                                                        <th>Nivel 1</th>
                                                        <td>Este permiso permite ver las solicitudes del mismo centro de
                                                            operacion al que pertenece el usuario y cambiar el estado de
                                                            la solicitud</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nivel 2</th>
                                                        <td>Este permiso permite ver las solicitudes de todos los
                                                            centros de operacion , gestionar dichas solicitudes y
                                                            cambiar el estado de la solicitud </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br>


                                    <div class="table-responsive allcp-form autorizacion" style="padding: 20px;">
                                        <div style="display: flex; justify-content: flex-end;margin-right: 107px;">
                                            <button type="button"
                                                class="btn btn-primary permisos-autorización">Editar</button>
                                        </div>
                                        <form action="{{ route('GestionarPermisosAutorizar') }}" method="post"
                                            id="">
                                            @csrf
                                            @foreach ($nivelesPermisos as $nivelPermiso)
                                                <div class="row" style="color: black; display: flex;">
                                                    <div class="col-md-2"
                                                        style="text-align: center; display: flex; flex-direction: column; justify-content: center">
                                                        <label style="color: #34495e">
                                                            <b>
                                                                Niveles
                                                            </b>
                                                        </label>
                                                        <div>
                                                            <b>Nivel {{ $nivelPermiso }}</b>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-8">
                                                        <label style="color: #34495e">
                                                            <b>
                                                                Personas con permisos:
                                                            </b>
                                                        </label>

                                                        <select multiple="multiple" disabled style="width: 100%;"
                                                            id="permiso-{{ $nivelPermiso }}"
                                                            name="permiso-{{ $nivelPermiso }}[]">
                                                            @foreach ($empleados as $empleado)
                                                                <option value="{{ $empleado->id_empleado }}">
                                                                    {{ $empleado->primer_nombre . ' ' . $empleado->ot_nombre . ' ' . $empleado->primer_apellido . ' ' . $empleado->ot_apellido }}
                                                                </option>
                                                            @endforeach
                                                        </select>


                                                    </div>

                                                </div>

                                                <br>
                                                <br>
                                            @endforeach

                                            <button type="submit" class="btn btn-primary enviar-permiso"
                                                style="display: none;">Enviar</button>
                                        </form>


                                    </div>



                                </div>
                            </div>
                        </div>

                    </div>
                </section>

            </section>
        </div>

        @include('includes-CDN/include-script')

        <script>
            window.empleadosPermisos = @json($empleadosPermisos);
        </script>
        <script type="module" src="{{ asset('js/requisiciones/panel-gestionarPermisosSolicitudes.js') }}"></script>

    </body>

    </html>
@endforeach
