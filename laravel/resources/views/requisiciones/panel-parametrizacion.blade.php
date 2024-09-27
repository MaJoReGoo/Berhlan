<?php

?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Requisiciones de personal | Parametrización
        </title>

        @include('includes-CDN/include-head')

        <link rel="stylesheet" href="{{ asset('css/requisiciones/panel-parametrizacion.css') }}">
    </head>

    <body class="sales-stats-page">
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
                                        Requisiciones de personal >
                                    </font>
                                    <font color="#b4c056">
                                        Parametrización
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
                <section id="content" class="table-layout animated fadeIn">
                    <div class="chute chute-center">

                        <div class="mostrarTabla">
                            <button id="btn_motivos_rechazo" class="btn btn-success">Motivos Rechazo</button>
                            <button id="btn_tipos_de_contrato" class="btn btn-danger">Tipos de contrato</button>
                            <button id="btn_activos" class="btn btn-danger">Activos</button>
                            <button id="btn_dotaciones" class="btn btn-danger">Dotaciones</button>
                            <button id="btn_tallas" class="btn btn-danger">Tallas</button>
                        </div>


                        <div id="motivos_rechazo">
                            @include('requisiciones.includes.parametrizacion.panel-motivosRechazo')
                        </div>

                        <div id="tipos_contratos">
                            @include('requisiciones.includes.parametrizacion.panel-tpContrato')
                        </div>

                        <div id="activos">
                            @include('requisiciones.includes.parametrizacion.panel-activos')
                        </div>

                        <div id="dotaciones">
                            @include('requisiciones.includes.parametrizacion.panel-dotaciones')
                        </div>

                        <div id="tallas">
                            @include('requisiciones.includes.parametrizacion.panel-tallas')
                        </div>
                    </div>
                </section>
                <!-- -------------- /Content -------------- -->
            </section>
        </div>

        @include('includes-CDN/include-script')

        <script>
            window.MotivosCant = @json($MotivosCant);
            window.TipoContratoCant = @json($TipoContratoCant);
            window.ActivosCant = @json($ActivosCant);
            window.DotacionesCant = @json($DotacionesCant);
            window.tallasCant = @json($tallasCant);
        </script>

        <script type="module" src="{{ asset('js/requisiciones/panel-parametrizacion.js') }}"></script>

    </body>

    </html>
@endforeach
