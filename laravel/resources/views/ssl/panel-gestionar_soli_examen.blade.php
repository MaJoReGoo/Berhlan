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
            Intranet | Requisición de personal | Solicitudes Examenes Ocupacionales | Solicitud
        </title>
        @include('includes-CDN/include-head')

        <link rel="stylesheet" type="text/css"
            href="{{ asset('/public/css/ssl/panel-gestionar_soli_examen.blade.css') }}">

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
                                <a href="{{ asset('/panel/menu/128') }}" title="Requisición de personal">
                                    <font color="#34495e">
                                        Ssl >
                                    </font>
                                    <font color="#34495e">
                                        Solicitudes examenes ocupacionales >
                                    </font>
                                    <font color="#b4c056">
                                        Solicitud {{ $soli_examenes[0]->id_soli_examen }}
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
                {{-- @dd($soli_examenes) --}}
                <!-- -------------- Content -------------- -->
                <section id="content" class="table-layout animated fadeIn">
                    <div class="chute chute-center pt30">
                        <!-- -------------- Column Center -------------- -->
                        <div class="panel m3">
                            <!-- -------------- Message Body -------------- -->
                            <div class="nano-content">

                                <div class="table-responsive allcp-form" style="padding: 25px;">

                                    <div class="row" style="color: black;">

                                        <div class="col-md-3" style="text-align: center;">
                                            <label style="color: #34495e">
                                                <b>
                                                    Consecutivo
                                                </b>
                                            </label>
                                            <div>
                                                <b>{{ $soli_examenes[0]->consec_examen }}</b>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="text-align: center;">
                                            <label style="color: #34495e">
                                                <b>
                                                    Nombre de la persona
                                                </b>
                                            </label>
                                            <div>
                                                <b>{{ $soli_examenes[0]->nombre_soli_ingreso }}</b>
                                            </div>
                                        </div>


                                        <div class="col-md-3" style="text-align: center;">
                                            <label style="color: #34495e">
                                                <b>
                                                    Cedula
                                                </b>
                                            </label>
                                            <div>
                                                <b>{{ $soli_examenes[0]->cedula_soli_ingreso }}</b>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="text-align: center;">
                                            <label style="color:#34495e;">
                                                <b>
                                                    Estado de la solicitud
                                                </b>
                                            </label>
                                            <div>
                                                <b>
                                                    @php
                                                        if (
                                                            $soli_examenes[0]->estado_examen == 1 &&
                                                            $soli_examenes[0]->asistencia == null
                                                        ) {
                                                            echo 'Pendiente';
                                                        } elseif (
                                                            $soli_examenes[0]->estado_examen == 2 &&
                                                            $soli_examenes[0]->asistencia == null
                                                        ) {
                                                            echo 'Agendado';
                                                        } elseif (
                                                            $soli_examenes[0]->estado_examen == 2 &&
                                                            $soli_examenes[0]->asistencia == 1
                                                        ) {
                                                            echo 'Reprogramado';
                                                        } elseif ($soli_examenes[0]->estado_examen == 3) {
                                                            echo 'Pendiente de resultado';
                                                        } elseif ($soli_examenes[0]->estado_examen == 4) {
                                                            echo 'Cerrado (No Apto)';
                                                        } elseif ($soli_examenes[0]->estado_examen == 5) {
                                                            echo 'Cerrado (Apto)';
                                                        }
                                                    @endphp
                                                </b>

                                            </div>
                                        </div>


                                    </div>

                                    <br><br>

                                    <div class="row" style="color: black;">

                                        <div class="col-md-3" style="text-align: center;">
                                            <label style="color: #34495e">
                                                <b>
                                                    Cargo
                                                </b>
                                            </label>
                                            <div>
                                                <b>{{ $soli_examenes[0]->cargo }}</b>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="text-align: center;">
                                            <label style="color: #34495e">
                                                <b>
                                                    Centro operación
                                                </b>
                                            </label>
                                            <div>
                                                <b>{{ $soli_examenes[0]->centro_operacion }}</b>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="text-align: center;">
                                            <label style="color: #34495e">
                                                <b>
                                                    Empresa responsable
                                                </b>
                                            </label>
                                            <div>
                                                <b>{{ $soli_examenes[0]->responsable_proceso }}</b>
                                            </div>
                                        </div>

                                    </div>

                                    <br>
                                    <br>



                                    <div class="row">
                                        <form action="{{ route('programarExamen') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id_soli_examen"
                                                value="{{ $soli_examenes[0]->id_soli_examen }}">

                                            <div class="col-md-3" style="text-align: center;">
                                                <label style="color:#34495e;">
                                                    <b>
                                                        Lugar (Nombre IPS)
                                                    </b>
                                                </label>
                                                <label class="field">
                                                    <input style="text-align: center;" type="text" class="gui-input"
                                                        name="lugar" {{ $soli_examenes[0]->lugar ? 'disabled' : '' }}
                                                        {{ $nivelPermiso[0] == 1 ? 'disabled' : '' }}
                                                        value="{{ $soli_examenes[0]->lugar ? $soli_examenes[0]->lugar : '' }}"
                                                        required>
                                                </label>
                                            </div>
                                            <div class="col-md-3 fecha" style="text-align: center;">
                                                <label style="color:#34495e;">
                                                    <b>
                                                        Fecha
                                                    </b>
                                                </label>
                                                <label class="field">
                                                    <input style="text-align: center;" type="date" class="gui-input"
                                                        min="{{ \Carbon\Carbon::now()->toDateString() }}"
                                                        name="fecha" {{ $soli_examenes[0]->fecha ? 'disabled' : '' }}
                                                        {{ $nivelPermiso[0] == 1 ? 'disabled' : '' }}
                                                        value="{{ $soli_examenes[0]->fecha ? \Carbon\Carbon::parse($soli_examenes[0]->fecha)->format('Y-m-d') : '' }}"
                                                        required>
                                                </label>



                                            </div>
                                            <div class="col-md-2 hora" style="text-align: center;">
                                                <label style="color:#34495e;">
                                                    <b>
                                                        Hora
                                                    </b>
                                                </label>
                                                <label class="field">
                                                    <input style="text-align: center;" type="time" class="gui-input"
                                                        name="hora" {{ $soli_examenes[0]->hora ? 'disabled' : '' }}
                                                        {{ $nivelPermiso[0] == 1 ? 'disabled' : '' }}
                                                        value="{{ $soli_examenes[0]->hora ? $soli_examenes[0]->hora : '' }}"
                                                        required>
                                                </label>
                                            </div>
                                            <div class="col-md-4" style="text-align: center;">
                                                <label style="color:#34495e;">
                                                    <b>
                                                        Preparación
                                                    </b>
                                                </label>
                                                <label class="field">
                                                    <textarea name="preparacion" cols="42" rows="4" {{ $soli_examenes[0]->preparacion ? 'disabled' : '' }}
                                                        {{ $nivelPermiso[0] == 1 ? 'disabled' : '' }}>{{ $soli_examenes[0]->preparacion }}</textarea>
                                                </label>
                                            </div>
                                    </div>

                                    {{-- Replantear esto --}}
                                    <br>
                                    <br>


                                    @if ($soli_examenes[0]->lugar == null && $nivelPermiso[0] != 1)
                                        <br>
                                        <div style="display: flex; justify-content: flex-end;">
                                            <button type="submit" class="btn btn-primary">Programar Examen</button>
                                        </div>
                                    @endif




                                    </form>
                                    @if ($soli_examenes[0]->lugar != null)
                                        <form action="" method="post" class="form-confirm-examen"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" name="id_soli_examen"
                                                value="{{ $soli_examenes[0]->id_soli_examen }}">
                                            <div class="row">

                                                <div class="col-md-3" style="text-align: center;">
                                                    <label style="color:#34495e;">
                                                        <b>
                                                            Asistencia:
                                                        </b>
                                                    </label>
                                                    <label class="field select">

                                                        <select class="gui-input" name="asistencia" required
                                                            {{ $reprogramacion == null && $soli_examenes[0]->asistencia == 1 ? 'disabled' : '' }}
                                                            {{ $soli_examenes[0]->asistencia == 2 ? 'disabled' : '' }}
                                                            {{ $nivelPermiso[0] == 1 ? 'disabled' : '' }}>
                                                            @if ($soli_examenes[0]->asistencia == null)
                                                                <option value="">Seleccione una opción
                                                                </option>
                                                            @endif

                                                            <option value="1"
                                                                {{ $soli_examenes[0]->asistencia == 1 ? 'selected' : '' }}>
                                                                No asistió
                                                            </option>
                                                            <option value="2"
                                                                {{ $soli_examenes[0]->asistencia == 2 ? 'selected' : '' }}>
                                                                Asistió
                                                            </option>
                                                        </select>
                                                    </label>
                                                </div>

                                                @if ($nivelPermiso[0] != 1)
                                                    <div class="col-md-2 reprogramar" hidden>
                                                        <label
                                                            style="color: #34495e; display:flex; justify-content:center; ">
                                                            <b>
                                                                ¿Desea reprogramar el examen?
                                                            </b>
                                                        </label>
                                                        <div class="box">
                                                            <label class="radio-button">
                                                                <input type="radio" name="reprogramar"
                                                                    value="Si">
                                                                <span class="radio"></span>
                                                                Sí
                                                            </label>
                                                            <label class="radio-button">
                                                                <input type="radio" name="reprogramar"
                                                                    value="No">
                                                                <span class="radio"></span>
                                                                No
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="reprogramacion" hidden>
                                                        <div class="col-md-3" style="text-align: center;">
                                                            <label style="color:#34495e;">
                                                                <b>
                                                                    Fecha
                                                                </b>
                                                            </label>
                                                            <label class="field">
                                                                <input style="text-align: center;" type="date"
                                                                    min="{{ date('Y-m-d') }}" class="gui-input"
                                                                    name="nuevafecha">
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2" style="text-align: center;">
                                                            <label style="color:#34495e;">
                                                                <b>
                                                                    Hora
                                                                </b>
                                                            </label>
                                                            <label class="field">
                                                                <input style="text-align: center;" type="time"
                                                                    class="gui-input" name="nuevahora">
                                                            </label>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-2 enviar-reprogramar" hidden>
                                                        <br>
                                                        <br>
                                                        <button type="submit" id="enviar-reprogramar"
                                                            class="btn btn-primary">Reprogramar</button>
                                                    </div>
                                                @endif

                                                <div class="concepto">
                                                    @if ($nivelPermiso[0] == 3)
                                                        @if ($soli_examenes[0]->concepto == null)
                                                            <div class="col-md-4" style="text-align: center;">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Adjuntar Concepto
                                                                    </b>
                                                                </label>

                                                                <label class="field">
                                                                    <input type="file" name="concepto"
                                                                        class="gui-input">
                                                                </label>
                                                            </div>
                                                        @endif

                                                        @if ($soli_examenes[0]->estado_examen != 4 && $soli_examenes[0]->estado_examen != 5)
                                                            <div class="col-md-3">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Estado:
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select class="gui-input" name="estado_examen">
                                                                        <option value="">Seleccione una opción
                                                                        </option>
                                                                        <option value="4"
                                                                            {{ $soli_examenes[0]->estado_examen == 4 ? 'selected' : '' }}>
                                                                            No apto
                                                                        </option>
                                                                        <option value="5"
                                                                            {{ $soli_examenes[0]->estado_examen == 5 ? 'selected' : '' }}>
                                                                            Apto
                                                                        </option>
                                                                    </select>
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endif

                                                    @if ($soli_examenes[0]->concepto == null && ($nivelPermiso[0] == 3 || $soli_examenes[0]->asistencia == 1))
                                                        <div class="col-md-2">
                                                            <br>
                                                            <br>
                                                            <button type="submit"
                                                                class="btn btn-primary">Enviar</button>
                                                        </div>
                                                    @endif

                                                </div>


                                                @if ($soli_examenes[0]->concepto != null)
                                                    <div class="col-md-3 d-flex align-items-center"
                                                        style="flex-direction: column;">
                                                        <label style="color:#34495e;">
                                                            <b>
                                                                Concepto
                                                            </b>
                                                        </label>

                                                        <label class="field">
                                                            <a
                                                                href="{{ route('descargarConcepto', ['archivo' => $soli_examenes[0]->concepto]) }}">
                                                                {{ $soli_examenes[0]->concepto }}
                                                            </a>
                                                        </label>
                                                    </div>
                                                @endif

                                                @if ($soli_examenes[0]->estado_examen == 4 || $soli_examenes[0]->estado_examen == 5)
                                                    <div class="col-md-4">
                                                        <label style="color:#34495e;">
                                                            <b>
                                                                Estado:
                                                            </b>
                                                        </label>
                                                        <label class="field select">
                                                            <select class="gui-input" name="estado_examen" disabled>
                                                                <option
                                                                    {{ $soli_examenes[0]->estado_examen == 4 ? 'selected' : '' }}>
                                                                    No apto
                                                                </option>
                                                                <option
                                                                    {{ $soli_examenes[0]->estado_examen == 5 ? 'selected' : '' }}>
                                                                    Apto
                                                                </option>
                                                            </select>
                                                        </label>
                                                    </div>
                                                @endif


                                            </div>

                                            <br>
                                            <br>
                                            <br>

                                            <div class="row">

                                                <table class="table table-bordered text-dark"
                                                    id="table-reprogramaciones">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="4" style="text-align: center;">
                                                                Reprogramaciones</th>
                                                        </tr>
                                                        <tr>
                                                            <th style="text-align: center;">#</th>
                                                            <th style="text-align: center;">Fecha</th>
                                                            <th style="text-align: center;">Hora</th>
                                                            <th style="text-align: center;">Fecha de la acción</th>
                                                        </tr>
                                                    </thead>



                                                    <tbody style="color: black; text-align: center;">
                                                        @foreach ($reprogramaciones as $key => $reprogramacion)
                                                            <tr>

                                                                <th style="text-align: center;">{{ $key + 1 }}
                                                                </th>
                                                                <td style="text-align: center;">
                                                                    {{ \Carbon\Carbon::parse($reprogramacion->fecha)->format('d/m/Y') }}
                                                                </td>
                                                                <td style="text-align: center;">
                                                                    {{ \Carbon\Carbon::parse($reprogramacion->hora)->format('H:i') }}
                                                                </td>
                                                                <td style="text-align: center;">
                                                                    {{ \Carbon\Carbon::parse($reprogramacion->created_at)->format('d/m/Y H:i') }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
                                    @endif
                                    </table>
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


        <script>
            $(document).ready(function() {


                let datatable = $('#table-reprogramaciones').DataTable({
                    ordering: true,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    },
                    "order": [
                        [0, "desc"],
                    ]
                });


                let estado = '<?= $soli_examenes[0]->asistencia ?>';
                if (estado == 1) {
                    $('.reprogramar').show();
                    $('input[name=reprogramar]').prop('required', true);
                    $('.enviar-reprogramar').show();
                    $('.form-confirm-examen').attr('action', '{{ route('reprogramarExamen') }}');
                }
                if (estado == 2) {
                    $('.concepto').show();
                    $('.form-confirm-examen').attr('action', '{{ route('confirmarExamen') }}');
                    $('input[name=reprogramar]').prop('required', false);
                } else {
                    $('.concepto').hide();
                }

                $('.form-confirm-examen').on('submit', function() {
                    $('select[name=asistencia]').prop('disabled', false);
                });

                $('input[name=concepto]').change(function() {
                    if ($(this).val()) {
                        $('select[name=estado_examen]').attr('required', 'required');
                    } else {
                        $('select[name=estado_examen]').removeAttr('required');
                    }
                });


                $('select[name=asistencia]').on('change', function() {
                    if ($(this).val() == 1) {
                        $('.reprogramar').show();
                        $('input[name=reprogramar]').prop('required', true);
                        $('input[name=concepto]').prop('required', false);
                        $('.concepto').hide();
                        $('.enviar-reprogramar').show();
                        if ($('input[name=reprogramar]:checked').val() == 'Si') {
                            $('.reprogramacion').show();
                            $('input[name=nuevafecha]').prop('required', true);
                            $('input[name=nuevahora]').prop('required', true);
                        }
                        $('.form-confirm-examen').attr('action', '{{ route('reprogramarExamen') }}');
                    } else {
                        $('.reprogramar').hide();
                        $('.concepto').show();
                        $('input[name=reprogramar]').prop('required', false);
                        $('.reprogramacion').hide();
                        $('.hora').show();
                        $('.fecha').show();
                        $('.enviar-reprogramar').hide();
                        $('.form-confirm-examen').attr('action', '{{ route('confirmarExamen') }}');
                    }
                });

                $('input[name=reprogramar]').on('change', function() {
                    if ($(this).val() == 'Si') {
                        $('.hora').hide();
                        $('.fecha').hide();
                        $('.reprogramacion').show();
                        $('input[name=nuevafecha]').prop('required', true);
                        $('input[name=nuevahora]').prop('required', true);
                    } else {
                        $('.reprogramacion').hide();
                        $('.hora').show();
                        $('.fecha').show();
                        $('input[name=nuevafecha]').prop('required', false);
                        $('input[name=nuevahora]').prop('required', false);
                    }
                });



            });
        </script>

    </body>

    </html>
@endforeach
