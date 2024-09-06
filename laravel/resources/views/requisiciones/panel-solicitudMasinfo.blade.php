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
            Intranet | Requisición de personal
        </title>

        @include('includes-CDN/include-head')
        <link rel="stylesheet" href="{{ asset('css/requisiciones/panel-solicitudMasinfo.css') }}">
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
                                <a href="<?= $server ?>/panel/requisiciones/solicitud"
                                    title="Requisición de personal > Solicitud <?= $DatosSolicitud[0]->num_solicitud ?>">
                                    <font color="#34495e">
                                        Requisición de personal > Solicitud <?= $DatosSolicitud[0]->num_solicitud ?> >
                                    </font>
                                    <font color="#b4c056">
                                        Más información
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="<?= $server ?>/panel/requisiciones/solicitud" class="btn btn-primary btn-sm ml10"
                            title="Requisición de personal > Solicitud <?= $DatosSolicitud[0]->num_solicitud ?>">
                            REGRESAR &nbsp;
                            <span class="fa fa-arrow-left"></span>
                        </a>
                    </div>
                </header>
                <!-- -------------- /Topbar -------------- -->

                <!-- -------------- Content -------------- -->
                <!-- -------------- Content -------------- -->
                <section id="content" class="table-layout animated fadeIn">
                    <div class="chute chute-center pt20">
                        <!-- -------------- Column Center -------------- -->
                        <div class="panel m3">

                            <div class="table-responsive">

                                <table class="table theme-warning br-t">
                                    <thead>
                                        <tr style="background-color:#39405a">
                                            <th>
                                                <font color="white">
                                                    Solicitud {{ $DatosSolicitud[0]->num_solicitud }}
                                                </font>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="nano-content pt20">
                                                    <div class="row d-flex align-items-center text-dark">
                                                        <div class="col-md-2 text-center ">
                                                            <h6>Solicitud N°</h6>
                                                            <p>{{ $DatosSolicitud[0]->num_solicitud }}</p>
                                                        </div>
                                                        <div class="col-md-2 text-center">
                                                            <h6>Estado:</h6>
                                                            <p>{{ $DatosSolicitud[0]->nombre_estado }}</p>
                                                        </div>
                                                        <div class="col-md-2 text-center">
                                                            <h6>Motivo:</h6>
                                                            <p>{{ $DatosSolicitud[0]->motivo }}</p>
                                                        </div>
                                                        <div class="col-md-3 text-center">
                                                            <h6>Centro operación:</h6>
                                                            <p>{{ $DatosSolicitud[0]->centro_operacion }}</p>
                                                        </div>
                                                        <div class="col-md-2 text-center">
                                                            <h6>Numero de vacantes:</h6>
                                                            <p>{{ $DatosSolicitud[0]->num_vacantes }}</p>
                                                        </div>
                                                    </div>
                                                    <hr style="margin: 6px;">
                                                    <br>
                                                    <div class="row d-flex align-items-center text-dark">
                                                        <div class="col-md-2 text-center">
                                                            <h6>Cargo Solicitado:</h6>
                                                            <p>{{ $DatosSolicitud[0]->cargo }}</p>
                                                        </div>
                                                        <div class="col-md-3 text-center">
                                                            <h6>Solicitado por:</h6>
                                                            <p>{{ $DatosSolicitud[0]->usr_solicita }}</p>
                                                        </div>
                                                        <div class="col-md-2 text-center">
                                                            <h6>Reemplaza a:</h6>
                                                            <p>{{ $DatosSolicitud[0]->reemplaza_a }}</p>
                                                        </div>

                                                        <div class="col-md-3 text-center">
                                                            <h6>Fecha de solicitud:</h6>
                                                            <p>{{ $DatosSolicitud[0]->fecha_solicita }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <hr style="margin: 6px;">
                                                    <br>
                                                    <div class="row d-flex align-items-center text-dark">
                                                        <div class="col-md-4 text-center">
                                                            <h6>Aplicativos:</h6>
                                                            <p>{{ $DatosSolicitud[0]->aplicativos != '' ? $DatosSolicitud[0]->aplicativos : 'No hay información' }}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-3 text-center">
                                                            <h6>Observaciones:</h6>
                                                            <p>{{ $DatosSolicitud[0]->observaciones }}</p>
                                                        </div>

                                                    </div>
                                                    <hr style="margin: 6px;">
                                                    <br>

                                                    <div class="row d-flex align-items-center text-dark">
                                                        <div class="col-md-12">
                                                            <label style="color: #34495e; display:flex; justify-content:center">
                                                                <b>Requiere activos:</b>
                                                            </label>
                                                            <br>
                                                            <div class="d-flex justify-content-center" style="gap: 10px;">

                                                                @foreach ($herramientas as $herramienta)
                                                                    <div class="checkbox-wrapper-19 d-flex align-items-center">
                                                                        <input id="{{ $herramienta->id_herramienta }}" type="checkbox"
                                                                            value="{{ $herramienta->id_herramienta }}" disabled
                                                                            {{ $soliRequiere->contains($herramienta->nombre_herramienta) ? 'checked' : '' }}>
                                                                        <label style="min-height: 0px" class="check-box"
                                                                            for="{{ $herramienta->id_herramienta }}"></label>
                                                                        &nbsp;&nbsp;&nbsp;
                                                                        <p class="text-dark" style="margin: 0px">
                                                                            {{ $herramienta->nombre_herramienta }}</p>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>


                                                    @if ($DatosSolicitud[0]->estado != 1)
                                                        <hr style="margin: 6px;">
                                                        <br>
                                                        <div class="row d-flex align-items-center text-dark">
                                                            <div class="col-md-2 text-center">
                                                                <h6>Salario:</h6>
                                                                <p>{{ $DatosSolicitud[0]->salario }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-3 text-center">
                                                                <h6>Tipo contrato:</h6>
                                                                @if (isset($DatosSolicitud[0]->nombre_tipo_contrato))
                                                                <p>{{ $DatosSolicitud[0]->nombre_tipo_contrato }}</p>
                                                                @else
                                                                    <p>No hay información</p>
                                                                @endif

                                                            </div>
                                                            <div class="col-md-4 text-center">
                                                                <h6>Condiciones:</h6>
                                                                <p>{{ $DatosSolicitud[0]->condiciones }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-3 text-center">
                                                                <h6>Responsable del proceso:</h6>
                                                                <p>{{ $DatosSolicitud[0]->responsable_proceso }}
                                                                </p>
                                                            </div>

                                                        </div>
                                                        <hr style="margin: 6px;">
                                                        <br>
                                                        <div class="row d-flex align-items-center text-dark">
                                                            <div class="col-md-6 text-center">
                                                                <h6>Nivel Cargo:</h6>
                                                                <p>{{ $DatosSolicitud[0]->fk_nivel_cargo }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-6 text-center">
                                                                <h6>Fecha estimada de ingreso:</h6>
                                                                <p>{{ $DatosSolicitud[0]->fecha_aprox_ingreso }}
                                                                </p>
                                                            </div>
                                                        </div>



                                                        <br>
                                                        <br>

                                                        <div id="linea_temporal"></div>
                                                        <br>
                                                        <br>
                                                        <br>

                                                        <div class="panel-header p5 text-white" style="background-color:#39405a">
                                                            Información de ingresos
                                                        </div>
                                                        <br>

                                                        <table class="table table-hover text-dark text-center" id="ingresos">
                                                            <thead >
                                                                <tr>
                                                                    <th style="background-color:#39405a; color:white;">Consecutivo</th>
                                                                    <th style="background-color:#39405a; color:white;">Consecutivo Examen</th>
                                                                    <th style="background-color:#39405a; color:white;">Nombre</th>
                                                                    <th style="background-color:#39405a; color:white;">Genero</th>
                                                                    <th style="background-color:#39405a; color:white;">Cédula</th>
                                                                    <th style="background-color:#39405a; color:white;">Correo</th>
                                                                    <th style="background-color:#39405a; color:white;">Telefono</th>
                                                                    <th style="background-color:#39405a; color:white;">Fecha induccion</th>
                                                                    <th style="background-color:#39405a; color:white;">Fecha inicio laboral</th>
                                                                    <th style="background-color:#39405a; color:white;">Estado</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($ingresos as $ingreso)
                                                                    <tr>
                                                                        <td>{{ $ingreso->consecutivo }}</td>
                                                                        <td>{{$ingreso->fk_id_soli_examen == null ? 'No se requiere examen' : 'SSL-'. $ingreso->fk_id_soli_examen}}</td>
                                                                        <td>{{ $ingreso->nombre_soli_ingreso }}</td>
                                                                        <td>{{ $ingreso->genero_soli_ingreso }}</td>
                                                                        <td>{{ $ingreso->cedula_soli_ingreso }}</td>
                                                                        <td>{{ $ingreso->correo_soli_ingreso }}</td>
                                                                        <td>{{ $ingreso->telefono_soli_ingreso }}</td>
                                                                        @if ($ingreso->fecha_induccion == null)
                                                                        <td>Pendiente por diligencimiento</td>
                                                                        @else
                                                                        <td>{{ $ingreso->fecha_induccion }}</td>
                                                                        @endif
                                                                        @if ($ingreso->fecha_inicio_laboral == null)
                                                                        <td>Pendiente por diligencimiento</td>
                                                                        @else
                                                                        <td>{{ $ingreso->fecha_inicio_laboral }}</td>
                                                                        @endif
                                                                        <td>{{ $ingreso->nombre_estado_ingreso }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        <br>
                                                        <hr style="margin: 6px">
                                                        <br>
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

                                                                    @foreach ($dotaciones as $dotacion)
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

                                                        <hr style="margin: 6px">
                                                        <br>

                                                        <table class="table table-hover text-dark text-center" id="novedades-solicitudes" style="width: 100%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="background-color:#39405a; text-align: center; color:white;"
                                                                        colspan="2">
                                                                        Novedades de la solicitud</th>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col"
                                                                        style="text-align:center; background-color:#39405a; color:white;">
                                                                        Fecha</th>
                                                                    <th scope="col"
                                                                        style="text-align:center; background-color:#39405a; color:white;">
                                                                        Descripción
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody style="color: black; text-align: center;">
                                                                @foreach ($novedades as $novedad)
                                                                    <tr>
                                                                        <td style="word-wrap: break-word;">
                                                                            {{ \Carbon\Carbon::parse($novedad->fecha_novedad)->format('d-m-Y') }}
                                                                        </td>
                                                                        <td style="word-wrap: break-word;">
                                                                            {{ $novedad->descripcion_novedad }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <br>
                    </div>
                </section>

                @include('includes-CDN/include-script')

                <script>
                    window.tiempos_estados_solicitud = @json($tiempos_estados_solicitud);
                </script>
                <script type="module" src="{{ asset('js/requisiciones/panel-solicitudMasinfo.js') }}"></script>

    </body>

    </html>
@endforeach
