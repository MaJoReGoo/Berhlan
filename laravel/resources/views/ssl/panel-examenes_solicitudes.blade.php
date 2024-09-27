<?php

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
            Intranet | Ssl | Solicitudes Examenes Ocupacionales
        </title>
        @include('includes-CDN/include-head')

        <link rel="stylesheet" type="text/css" href="{{ asset ('/public/css/ssl/panel-examenes_solicitudes.blade.css')}}">

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
                                <a href="{{ asset ('/panel/menu/128')}}" title="Requisición de personal">
                                    <font color="#34495e">
                                        Ssl >
                                    </font>
                                    <font color="#b4c056">
                                        Solicitudes examenes ocupacionales
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
                        <div class="panel m3">

                            <!-- -------------- Message Body -------------- -->
                            <div class="nano-content">
                                <div class="table-responsive">
                                    <table class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr style="background-color:#39405a">
                                                <th>
                                                    Solicitudes examenes ocupacionales
                                                </th>
                                            </tr>
                                        </thead>

                                        <tr>
                                            <td colspan="2">
                                                <table id="message-table"
                                                    class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                    <thead>
                                                        <tr style="background-color: #F8F8F8; color:#000000">
                                                            <th style="text-align:center">
                                                                Consecutivo
                                                            </th>
                                                            <th style="text-align:center">
                                                                Num solicitud requisición
                                                            </th>
                                                            <th style="text-align: center">
                                                                Estado solicitud
                                                            <th style="text-align: center">
                                                                Persona
                                                            </th>
                                                            <th style="text-align: center">
                                                                Numero cedula
                                                            </th>
                                                            <th style="text-align: center">
                                                                Cargo
                                                            </th>
                                                            <th style="text-align: center">
                                                                Centro operacion
                                                            </th>
                                                            <th style="text-align: center">
                                                                Gestionar
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                        @foreach ($soli_examenes as $examen)
                                                            <tr class="message-unread">
                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        {{ $examen->consec_examen }}
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <b>
                                                                            {{ $examen->fk_num_solicitud }}
                                                                        </b>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        @php
                                                                            if ($examen->estado_examen == 1 && $examen->asistencia == null) {
                                                                                echo 'Pendiente';
                                                                            } else if ($examen->estado_examen == 2 && $examen->asistencia == null) {
                                                                                echo 'Agendado';
                                                                            } else if ($examen->estado_examen == 2 && $examen->asistencia == 1) {
                                                                                echo 'Reprogramado';
                                                                            } else if ($examen->estado_examen == 3) {
                                                                                echo 'Pendiente de resultado';
                                                                            } else if ($examen->estado_examen == 4) {
                                                                                echo 'Cerrado (No Apto)';
                                                                            } else if ($examen->estado_examen == 5) {
                                                                                echo 'Cerrado (Apto)';
                                                                            }
                                                                        @endphp
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        {{ $examen->nombre_soli_ingreso }}
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        {{ $examen->cedula_soli_ingreso }}
                                                                    </font>
                                                                </td>
                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        {{ $examen->cargo }}
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        {{ $examen->centro_operacion }}
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <b>
                                                                            <a class="btn btn-default"
                                                                                href="{{ asset ('/panel/ssl/examenes/solicitud/')}}<?= $examen->id_soli_examen ?>">
                                                                                <img style="height: 30px" width="30px"
                                                                                    src="{{ $server }}/images/detalle_new.png">
                                                                                </img>
                                                                            </a>
                                                                        </b>
                                                                    </font>
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
                        </div>
                        <!-- -------------- /Column Center -------------- -->
                    </div>
                </section>


                <!-- -------------- /Content -------------- -->
            </section>
        </div>

        @include('includes-CDN/include-script')

        <script>
            $(document).ready(function() {

                let datatable = $('#message-table').DataTable({
                    ordering: true,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    },
                    "order": [
                        [0, "desc"],
                    ]
                });

            });
        </script>

    </body>

    </html>
@endforeach
