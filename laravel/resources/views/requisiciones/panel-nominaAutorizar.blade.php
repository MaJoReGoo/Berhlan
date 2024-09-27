<?php

use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Requisiciones\PanelTpcontratos;
use App\Models\Requisiciones\PanelMotivos;

?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <title>
            Intranet | Requisición de personal | Gestión de solicitudes
        </title>

        @include('includes-CDN/include-head')
        <link rel="stylesheet" href="{{ asset('css/requisiciones/panel-nominaAutorizar.css') }}">

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
                                <a href="{{ asset ('/panel/requisiciones/nomina')}}"
                                    title="Requisición de personal > Autorización por nómina">
                                    <font color="#34495e">
                                        Requisición de personal > Gestión de solicitudes >
                                    </font>
                                    <font color="#b4c056">
                                        Solicitud {{ $DatosSolicitud[0]->num_solicitud }}
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset ('/panel/requisiciones/nomina')}}" class="btn btn-primary btn-sm ml10"
                            title="Requisición de personal > Autorización por nómina">
                            REGRESAR &nbsp;
                            <span class="fa fa-arrow-left"></span>
                        </a>
                    </div>
                </header>
                <!-- -------------- /Topbar -------------- -->

                <!-- -------------- Content -------------- -->
                <section id="content" class="table-layout animated fadeIn">
                    <div class="chute chute-center pt20">
                        <!-- -------------- Column Center -------------- -->
                        <div class="panel m3">
                            <!-- -------------- Message Body -------------- -->
                            <div class="nano-content">
                                <div class="table-responsive">
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr style="background-color:#39405a">
                                                <th>
                                                    Solicitud {{ $DatosSolicitud[0]->num_solicitud }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td>
                                                <table id="message-table"
                                                    class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Cargo solicitado:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            $nombrec = PanelCargos::getCargo($DatosSolicitud[0]->cargo);
                                                            $Area = PanelAreas::getArea($nombrec[0]->area);
                                                            $Empresa = PanelEmpresas::getEmpresa($Area[0]->empresa);
                                                            echo $nombrec[0]->descripcion . ' - ' . $Area[0]->descripcion . ' - ' . $Empresa[0]->nombre;
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Centro de operación:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            $centro = PanelCentrosOp::getCentroOp($DatosSolicitud[0]->centro_operacion);
                                                            echo $centro[0]->descripcion;
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Motivo:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            if ($DatosSolicitud[0]->motivo == 'RP') {
                                                                echo 'Reemplazo de personal';
                                                            } elseif ($DatosSolicitud[0]->motivo == 'CN') {
                                                                echo 'Cargo nuevo / Incremento de personal';
                                                            } elseif ($DatosSolicitud[0]->motivo == 'LM') {
                                                                echo 'Licencia de maternidad';
                                                            } elseif ($DatosSolicitud[0]->motivo == 'IP') {
                                                                echo 'Incapacidad permanente';
                                                            }
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Reemplaza a:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?= $DatosSolicitud[0]->reemplaza_a ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Número de vacantes:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?= $DatosSolicitud[0]->num_vacantes ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Observaciones:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?= $DatosSolicitud[0]->observaciones ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Aplicativos a los que deberá tener acceso:
                                                        </th>
                                                        <td style="text-align:justify;">
                                                            {{ $DatosSolicitud[0]->aplicativos }}
                                                        </td>

                                                        <th style="text-align:left">
                                                            Fecha de solicitud:
                                                        </th>
                                                        <td style="text-align:left">
                                                            {{ $DatosSolicitud[0]->fecha_solicita }}
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Solicitado por:
                                                        </th>
                                                        <td colspan="3" style="text-align:left">
                                                            <?php
                                                            $Empleado = PanelEmpleados::getEmpleado($DatosSolicitud[0]->usr_solicita);
                                                            $Cargo = PanelCargos::getCargo($Empleado[0]->cargo);
                                                            $Area = PanelAreas::getArea($Cargo[0]->area);
                                                            echo $Empleado[0]->primer_nombre;
                                                            echo ' ';
                                                            echo $Empleado[0]->ot_nombre;
                                                            echo ' ';
                                                            echo $Empleado[0]->primer_apellido;
                                                            echo ' ';
                                                            echo $Empleado[0]->ot_apellido;
                                                            echo ' (';
                                                            echo $Cargo[0]->descripcion;
                                                            echo ' - ';
                                                            echo $Area[0]->descripcion;
                                                            echo ')';
                                                            ?>
                                                        </td>


                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Estado de la solicitud:
                                                        </th>
                                                        <td style="text-align:left">
                                                            @php
                                                                if ($DatosSolicitud[0]->estado == '1') {
                                                                    echo 'Pendiente';
                                                                } elseif (
                                                                    $DatosSolicitud[0]->estado == '5' ||
                                                                    $DatosSolicitud[0]->estado == '3'
                                                                ) {
                                                                    echo 'Activo';
                                                                } elseif ($DatosSolicitud[0]->estado == '9') {
                                                                    echo 'Aplazado';
                                                                } elseif ($DatosSolicitud[0]->estado == '10') {
                                                                    echo 'Finalizado';
                                                                }
                                                            @endphp
                                                        </td>
                                                        @if ($DatosSolicitud[0]->fecha_nomina !== null)
                                                            <th style="text-align:left">
                                                                Fecha de aprobacion:
                                                            </th>
                                                            <td style="text-align:left">

                                                                {{ \Carbon\Carbon::parse($DatosSolicitud[0]->fecha_nomina)->format('d-m-Y') }}
                                                            </td>
                                                        @endif


                                                    </tr>


                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>


                        @if ($DatosSolicitud[0]->estado == '1' && $nivelPermiso[0] == '2')
                            @include('requisiciones/includes/nominaAutorizar/panel-acciones')
                        @else
                            @include('requisiciones/includes/nominaAutorizar/panel-informacion')
                        @endif

                        @if ($DatosSolicitud[0]->estado != '1')
                            <div class="panel m4">
                                @include('requisiciones/includes/nominaAutorizar/panel-novedades')
                            </div>
                            <br>
                            <div class="panel m4">
                                @include('requisiciones/includes/nominaAutorizar/panel-cambio_estado')
                                <br>
                                <br>
                                <div class="panel-header p5 text-white" style="background-color:#39405a">
                                    Información de ingresos
                                </div>
                                <div class="nano-content p20 allcp-form">
                                    <table class="table table-hover text-dark" id="ingresos">
                                        <thead>
                                            <tr>
                                                <th>Consecutivo</th>
                                                <th>Consecutivo Examen</th>
                                                <th>Nombre</th>
                                                <th>Cédula</th>
                                                <th>Correo</th>
                                                <th>Telefono</th>
                                                <th>Estado</th>
                                                @if ($DatosSolicitud[0]->requiere_dotacion == 'Si')
                                                    <th>Pedir Dotación</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($ingresos as $ingreso)
                                                <tr>
                                                    <td>{{ $ingreso->consecutivo }}</td>
                                                    <td>{{ $ingreso->fk_id_soli_examen == null ? 'No se requiere examen' : 'SSL-' . $ingreso->fk_id_soli_examen }}
                                                    </td>
                                                    <td>{{ $ingreso->nombre_soli_ingreso }}</td>
                                                    <td>{{ $ingreso->cedula_soli_ingreso }}</td>
                                                    <td>{{ $ingreso->correo_soli_ingreso }}</td>
                                                    <td>{{ $ingreso->telefono_soli_ingreso }}</td>
                                                    <td>{{ $ingreso->nombre_estado_ingreso }}</td>
                                                    @if ($DatosSolicitud[0]->requiere_dotacion == 'Si')
                                                        @if ($ingreso->estado_soli_ingreso == '0' || $ingreso->estado_soli_ingreso == '2')
                                                            <td>
                                                                <button data-id ='{{ $ingreso->id_soli_ingreso }}'
                                                                    class="btn btn-primary pedir_dotacion">Pedir
                                                                    dotación</button>
                                                            </td>
                                                        @else
                                                            <td>Pendente a aprobar</td>
                                                        @endif
                                                    @endif

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="panel-header p5 text-white" style="background-color:#39405a">
                                    Información de dotaciones
                                </div>
                                <div class="nano-content p20 allcp-form">
                                    <table class="table table-hover text-dark text-center" id="dotaciones">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Nombre dotación</th>
                                                <th class="text-center">Talla dotación</th>
                                                <th class="text-center">Cantidad dotación</th>
                                                <th class="text-center">Nombre persona</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($dotacionesSoli as $dotacion)
                                                <tr>
                                                    <td>{{ $dotacion->nombre_dotacion }}</td>
                                                    <td>{{ $dotacion->nombre_talla_dotacion }}</td>
                                                    <td>{{ $dotacion->cantidad_dotacion }}</td>
                                                    <td>{{ $dotacion->nombre_soli_ingreso }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <div id="linea_temporal"></div>

                        @include('requisiciones/modales/panel-pedir_dotacion')

                        <!-- -------------- /Column Center -------------- -->
                    </div>

                </section>
                <!-- -------------- /Content -------------- -->
            </section>
        </div>


        @include('includes-CDN/include-script')

        <script>
            window.tiempos_estados_solicitud = @json($tiempos_estados_solicitud);
            window.niveles_cargos = @json($niveles_cargos);
            window.estado_soli = @json($DatosSolicitud[0]->estado);
            window.fecha_aprobacion = @json($DatosSolicitud[0]->fecha_nomina);
            window.dias_aplazados_db = @json($DatosSolicitud[0]->dias_aplazado);
            window.fecha_aplazado = @json($DatosSolicitud[0]->fecha_aplazado);
            window.consecutivo = @json($consecutivo);
            window.num_solicitud = @json($DatosSolicitud[0]->num_solicitud);
        </script>

        <!-- -------------- /Scripts -------------- -->

        <script type="module" src="{{ asset('/js/requisiciones/panel-nominaAutorizar.js') }}"></script>

    </body>

    </html>
@endforeach
