<?php
$server = '/Berhlan/public';

use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Parametrizacion\PanelEmpleados;

use App\Models\Requisiciones\PanelRequisiciones;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | SSL | Gestión de notificaciones y permisos
        </title>

        @include('includes-CDN/include-head')

        <link rel="stylesheet" type="text/css" href="{{ asset ('/public/css/ssl/panel-gestion_noticaciones_permisos.blade.css')}}">

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
                                <a href="{{ asset ('/panel/menu/128')}}" title="Ssl">
                                    <font color="#34495e">
                                        Ssl >
                                    </font>
                                    <font color="#b4c056">
                                        Gestión de notificaciones y permisos
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">

                        <a href="{{ asset ('/panel/menu/128')}}" class="btn btn-primary btn-sm ml10"
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
                        <div class="box">
                            <button id="notificaciones" class="btn btn-success">Notificaciones</button>
                            <button id="permisos" class="btn btn-danger">Permisos</button>
                        </div>
                        <br>
                        <div class="panel m3 notificaciones">
                            <!-- -------------- Message Body -------------- -->
                            <div class="nano-content">
                                <div class="table-responsive allcp-form" style="padding: 20px;">
                                    <p style="color: black;">Se parametrizan las personas que van a recibir solicitud
                                        cuando se cree una solicitud de examen:</p>
                                    <br>
                                    <br>
                                    <form action="{{ route('gestionarNotificaciones') }}" method="post">
                                        <div style="display: flex; justify-content: flex-end;margin-right: 107px;">
                                            <button type="button" class=" btn btn-primary editar-notificaciones" >Editar</button>
                                        </div>

                                        @foreach ($centros_op as $centro)
                                            @csrf

                                            <div class="row" style="color: black; display: flex;">
                                                <div class="col-md-2"
                                                    style="text-align: center; display: flex; flex-direction: column; justify-content: center">
                                                    <label style="color: #34495e">
                                                        <b>
                                                            Centro Operación
                                                        </b>
                                                    </label>
                                                    <div>
                                                        <b>{{ $centro->descripcion }}</b>
                                                    </div>
                                                </div>


                                                <div class="col-md-8">
                                                    <label style="color: #34495e">
                                                        <b>
                                                            Personas a notificar
                                                        </b>
                                                    </label>

                                                    <select multiple="multiple" name="{{ $centro->id_centro }}[]"
                                                        disabled style="width: 100%;" id="{{ $centro->id_centro }}">
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

                                        <button type="submit" class="btn btn-primary confirmar-noti" style="display: none;">Enviar</button>
                                    </form>


                                </div>
                            </div>
                        </div>

                        <div class="panel m3 permisos" hidden>
                            <!-- -------------- Message Body -------------- -->
                            <div class="nano-content p50">

                                <div class="row">
                                    <div class="col-md-10 m4">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Nivel</th>
                                                    <th scope="col">descripcion</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th style="color: black;">Nivel 1</th>
                                                    <td>Este permiso permite visualizar únicamente las solicitudes del
                                                        mismo centro de operación al que pertenece el usuario.</td>
                                                </tr>
                                                <tr>
                                                    <th style="color: black;">Nivel 2</th>
                                                    <td>Este permiso permite visualizar las solicitudes del mismo centro
                                                        de operación al que pertenece el usuario y gestionar dichas
                                                        solicitudes.</td>
                                                </tr>
                                                <tr>
                                                    <th style="color: black;">Nivel 3</th>
                                                    <td>Este permiso permite visualizar todas las solicitudes de
                                                        exámenes de todos los centros de operación, gestionar todas las
                                                        solicitudes y subir los conceptos de cada solicitud.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>



                                <div class="table-responsive allcp-form" style="padding: 20px;">

                                    <form action="{{ route('gestionarPermisos') }}" method="post">
                                        @csrf
                                        <div style="display: flex; justify-content: flex-end;margin-right: 107px;">
                                            <button type="button" class="btn btn-primary editar-permisos">Editar</button>
                                        </div>
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

                                        <button type="submit" class="btn btn-primary confirmar-permi" style="display: none;">Enviar</button>
                                    </form>


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

        <script type="module">
            import {
                configureSelect2
            } from '{{ asset ('/js/select2.js')}}';
            $(document).ready(function() {

                let empleadoNoti = <?php echo json_encode($empleadoNoti); ?>;

                let empleadoPermisos = <?php echo json_encode($empleadoPermisos); ?>;


                Object.entries(empleadoPermisos).forEach(([clave, valor]) => {
                    $(`#permiso-${clave}`).val(valor).trigger('change');
                });

                Object.entries(empleadoNoti).forEach(([clave, valor]) => {
                    $(`#${clave}`).val(valor).trigger('change');
                });

                function actualizarOpciones() {
                    let empleadosSeleccionados = [];
                    $('.permisos select').each(function() {
                        $(this).find('option:selected').each(function() {
                            empleadosSeleccionados.push($(this).val());
                        });

                    });

                    $('.permisos select').each(function() {
                        $(this).find('option').each(function() {
                            if (empleadosSeleccionados.includes($(this).val())) {
                                $(this).prop('disabled', true);
                            } else {
                                $(this).prop('disabled', false);

                            }
                        });

                    });
                }

                configureSelect2();

                $('.editar-notificaciones').on('click', function() {
                    $('.notificaciones select').prop("disabled", false);
                    $('.confirmar-noti').show();
                })

                $('.editar-permisos').on('click', function() {
                    $('.permisos select').prop("disabled", false);
                    $('.confirmar-permi').show();
                })


                $("#notificaciones").click(function() {
                    $(".permisos").hide();
                    $(".notificaciones").show();
                    $(this).removeClass("btn-danger");
                    $(this).addClass("btn-success");
                    $("#permisos").addClass("btn-danger");
                });


                $("#permisos").click(function() {
                    $(".notificaciones").hide();
                    $(".permisos").show();
                    $(this).removeClass("btn-danger");
                    $(this).addClass("btn-success");
                    $("#notificaciones").addClass("btn-danger");
                });

                $('.permisos select').on('change', function() {
                    actualizarOpciones()
                });

                $('form').on('submit', function(event) {
                    $('.permisos select').each(function() {
                        $(this).find('option').each(function() {
                            $(this).prop('disabled', false);
                        });
                    });
                });

                actualizarOpciones()


            });
        </script>

    </body>

    </html>
@endforeach
