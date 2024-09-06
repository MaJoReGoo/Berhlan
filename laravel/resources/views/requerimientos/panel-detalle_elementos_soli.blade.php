<?php
$server = '/Berhlan/public';
?>

@foreach ($DatosUsuario as $DatLog)

    <head>
        <!-- -------------- Meta and Title -------------- -->

        <meta charset="utf-8">
        <title>
            Intranet | Requisición Personal | Solicitud requisicion elementos

        </title>
        @include('includes-CDN/include-head')
        <link rel="stylesheet" href="{{ asset('css/requerimientos/panel-detalle_elementos_soli.css') }}">
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
                                <a href="<?= $server ?>/panel/menu/4" title="Requisición de personal">
                                    <font color="#34495e">
                                        Requerimientos >
                                    </font>

                                    <font color="#34495e">
                                        Requisición de equipos ó elementos >
                                    </font>

                                    <font color="#b4c056">
                                        Solicitud # {{ $solicitudElementos[0]->consecutivo_elementos }}
                                    </font>
                                </a>


                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="<?= $server ?>/panel/requerimientos/elementos" class="btn btn-primary btn-sm ml10"
                            title="Listado elementos">
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
                            <div class="panel-header p5 text-white text-center" style="background-color:#39405a">
                                Solicitud Requisición de elementos {{ $solicitudElementos[0]->consecutivo_elementos }}
                            </div>
                            <br>
                            <!-- -------------- Message Body -------------- -->
                            <div class="table-responsive">
                                <section id="infoSolicitud">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-2 text-center">
                                            <label style="color: #34495e;">
                                                <b>Centro de operación</b>
                                            </label>
                                            <p class="text-dark">{{ $datosSolicitud[0]->centro_operacion }}</p>
                                        </div>
                                        <div class="col-md-5 text-center">
                                            <label style="color: #34495e;">
                                                <b>Cargo</b>
                                            </label>
                                            <p class="text-dark">{{ $datosSolicitud[0]->cargo }}</p>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <label style="color: #34495e;">
                                                <b>Fecha Ingreso</b>
                                            </label>
                                            <p class="text-dark">{{ $datosSolicitud[0]->fecha_aprox_ingreso }}</p>
                                        </div>

                                    </div>
                                </section>
                                <br>
                                <br>


                                @if ($area == '10')
                                    <form id="form-elementos" class="allcp-form"
                                        action="{{ route('gestionarSolicitudTicElementos') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name = "id_soli_elementos"
                                            value="{{ $solicitudElementos[0]->id_soli_elementos }}">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <label style="color: #34495e;">
                                                    Comentarios
                                                </label>
                                                <div>
                                                    <textarea name="comentario_tic_soli_elementos" cols="80" rows="3"
                                                        {{ $solicitudElementos[0]->comentario_tic_soli_elementos != null ? 'disabled' : '' }}>{{ $solicitudElementos[0]->comentario_tic_soli_elementos }}</textarea>
                                                </div>


                                            </div>

                                            <div class="col-md-3">
                                                <label style="color: #34495e;">
                                                    <b>Estado</b>
                                                </label>

                                                <select name="estado_tic_soli_elementos"
                                                    {{ $solicitudElementos[0]->estado_tic_soli_elementos != 1 ? 'disabled' : '' }}
                                                    required>
                                                    <option value="">Pendiente</option>
                                                    <option value="2"
                                                        {{ $solicitudElementos[0]->estado_tic_soli_elementos == 2 ? 'selected' : '' }}>
                                                        Entregado parcial</option>
                                                    <option value="3"
                                                        {{ $solicitudElementos[0]->estado_tic_soli_elementos == 3 ? 'selected' : '' }}>
                                                        Entregado</option>
                                                    <option value="4"
                                                        {{ $solicitudElementos[0]->estado_tic_soli_elementos == 4 ? 'selected' : '' }}>
                                                        Cancelado</option>
                                                </select>


                                            </div>
                                            <br>

                                            <div class="col-md-2">
                                                @if ($solicitudElementos[0]->estado_tic_soli_elementos == 1)
                                                    <br>
                                                    <br>
                                                    <button class=" btn btn-primary">Enviar</button>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                @endif

                                @if ($area == '17')
                                    <form id="form-elementos" class="allcp-form"
                                        action="{{ route('gestionarSolicitudSopElementos') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name = "id_soli_elementos"
                                            value="{{ $solicitudElementos[0]->id_soli_elementos }}">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <label style="color: #34495e;">
                                                    Comentarios
                                                </label>
                                                <div>
                                                    <textarea name="comentario_sop_soli_elementos" cols="80" rows="3"
                                                        {{ $solicitudElementos[0]->comentario_sop_soli_elementos != null ? 'disabled' : '' }}>{{ $solicitudElementos[0]->comentario_sop_soli_elementos }}</textarea>
                                                </div>


                                            </div>

                                            <div class="col-md-3">
                                                <label style="color: #34495e;">
                                                    <b>Estado</b>
                                                </label>

                                                <select name="estado_sop_soli_elementos"
                                                    {{ $solicitudElementos[0]->estado_sop_soli_elementos != 1 ? 'disabled' : '' }}
                                                    required>
                                                    <option value="">Pendiente</option>
                                                    <option value="2"
                                                        {{ $solicitudElementos[0]->estado_sop_soli_elementos == 2 ? 'selected' : '' }}>
                                                        Entregado parcial</option>
                                                    <option value="3"
                                                        {{ $solicitudElementos[0]->estado_sop_soli_elementos == 3 ? 'selected' : '' }}>
                                                        Entregado</option>
                                                    <option value="4"
                                                        {{ $solicitudElementos[0]->estado_sop_soli_elementos == 4 ? 'selected' : '' }}>
                                                        Cancelado</option>
                                                </select>


                                            </div>
                                            <br>

                                            <div class="col-md-2">
                                                @if ($solicitudElementos[0]->estado_sop_soli_elementos == 1)
                                                    <br>
                                                    <br>
                                                    <button class=" btn btn-primary">Enviar</button>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                @endif
                                <br>
                                <br>
                                <div class="d-flex justify-content-center" style="gap: 10px;">
                                    @foreach ($herramientas as $herramienta)
                                        <div class="checkbox-wrapper-19 d-flex align-items-center">
                                            <input id="{{ $herramienta->id_herramienta }}" type="checkbox"
                                                value="{{ $herramienta->id_herramienta }}" disabled
                                                {{ $elementos->contains('nombre_herramienta', $herramienta->nombre_herramienta) ? 'checked' : '' }}>
                                            <label style="min-height: 0px" class="check-box"
                                                for="{{ $herramienta->id_herramienta }}"></label>
                                            &nbsp;&nbsp;&nbsp;
                                            <p class="text-dark" style="margin: 0px">
                                                {{ $herramienta->nombre_herramienta }}</p>
                                        </div>
                                    @endforeach
                                </div>
                                
                                @if ($area == 17)
                                    <div class="p15">
                                        <table id="soli-dotaciones-table"
                                            class="table table-hover text-dark text-center">
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
                                @endif

                                <br>
                                <br>
                                <div class="p15">
                                    <table id="soli-candidatos-table" class="table table-hover text-dark text-center">
                                        <thead>
                                            <tr style="background-color: #F8F8F8; color: black;">
                                                <th style="text-align: center;">
                                                    Consecutivo
                                                </th>
                                                <th style="text-align: center;">
                                                    Nombre de la persona
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
                                                    Fecha induccion
                                                </th>
                                                <th style="text-align: center;">
                                                    Fecha inicio laboral
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($ingresos as $ingreso)
                                                <tr>
                                                    <td>{{ $ingreso->consecutivo }}</td>
                                                    <td>{{ $ingreso->nombre_soli_ingreso }}</td>
                                                    <td>{{ $ingreso->genero_soli_ingreso }}</td>
                                                    <td>{{ $ingreso->cedula_soli_ingreso }}</td>
                                                    <td>{{ $ingreso->correo_soli_ingreso }}</td>
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
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <br>
                            </div>


                        </div>
                        <!-- -------------- /Column Center -------------- -->
                    </div>



                </section>

            </section>
        </div>

        <!-- -------------- Scripts -------------- -->
        @include('includes-CDN/include-script')
        <script type="module" src="{{ asset('/js/requerimientos/panel-detalle_elementos_soli.js') }}"></script>

    </body>
@endforeach
