<?php

?>

@foreach ($DatosUsuario as $DatLog)

    <head>
        <!-- -------------- Meta and Title -------------- -->

        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>
            Intranet | Mejora continua | Consultar Informe
        </title>

        <meta name="keywords" content="panel, cms, usuarios, servicio" />
        <meta name="description" content="Intranet para grupo Berhlan">
        <meta name="author" content="USUARIO">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- -------------- Fonts -------------- -->
        <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
        <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic'
            rel='stylesheet' type='text/css'>


        <!-- -------------- CSS - theme -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/skin/default_skin/css/theme.css')}}">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.css')}}">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css')}}">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="{{ asset ('/panelfiles/assets/img/favicon.ico')}}">


        <!-- Editor -->
        <script type="text/javascript" src="{{ asset ('/panelfiles/ckeditor/ckeditor.js')}}"></script>

        {{-- Importar styles y funcionamiento del Select2 --}}
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

        <script type="text/javascript" src="{{ asset ('/panelfiles/select2/dist/js/select2.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/select2/dist/css/select2.min.css')}}">
        <!-- Importar style select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- -------------- DataTables -------------- -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">

        <link rel="stylesheet" type="text/css" href="{{ asset ('/public/css/inconformidades/panelConsultarInformesNoConformidad.blade.css')}}">

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
                                <a href="{{ asset ('/panel/menu/118')}}" title="Inconformidades">
                                    <font color="#34495e">
                                        Mejora Continua >
                                    </font>
                                    <font color="#b4c056">
                                        Consultar informes no conformidad
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset ('/panel/menu/118')}}" class="btn btn-primary btn-sm ml10"
                            title="Inconformidades">
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
                            <!-- -------------- Message Body -------------- -->
                            @if (isset($RegistrosTratamiento))
                                <div class="table-responsive">
                                    <table class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr style="background-color:#39405a">
                                                <th>
                                                    <font color="white">
                                                        Registros encontrados (Reporte de tratamiento no conformidad)
                                                    </font>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tr>

                                            <td>

                                                <table id="registros-table"
                                                    class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                    <thead>
                                                        <tr style="background-color: #F8F8F8">
                                                            <th style="text-align: center;">
                                                                Fecha
                                                            </th>
                                                            <th style="text-align: left">
                                                                Descripción
                                                            </th>
                                                            <th style="text-align: left">
                                                                Tipo
                                                            </th>
                                                            <th style="text-align: left">
                                                                Proceso
                                                            </th>
                                                            <th style="text-align: left">
                                                                Responsable
                                                            </th>

                                                            <th style="text-align: left">
                                                                Mostrar
                                                            </th>
                                                            <th style="text-align: left">
                                                                Descargar
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <div class="row"
                                                        style="display: flex; align-items: center; justify-content: space-around">

                                                        <form method="post"
                                                            action="{{ route('descargaTrataDbExcel') }}">
                                                            @csrf
                                                            <div class="col-md-3">

                                                                <label for="fecha_ini_trata" style="color: #34495e">
                                                                    <b>
                                                                        Desde la fecha:
                                                                    </b>
                                                                </label>

                                                                <input type="date" id="fecha_ini_trata"
                                                                    name="fecha_ini_trata" class="form-control"
                                                                    max="{{ date('Y-m-d') }}">
                                                            </div>

                                                            <div class="col-md-3">

                                                                <label for="fecha_final_trata" style="color: #34495e">
                                                                    <b>
                                                                        Hasta la fecha:
                                                                    </b>
                                                                </label>

                                                                <input type="date" id="fecha_final_trata"
                                                                    name="fecha_final_trata" class="form-control"
                                                                    max="{{ date('Y-m-d') }}" disabled>
                                                            </div>

                                                            <button id="btn_search_trata"
                                                                style="margin-right: 120px;margin-top: 32px;"
                                                                class="btn btn-success mb-2">
                                                                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                                                Descargar Excel
                                                                </img>
                                                            </button>
                                                        </form>

                                                        <div
                                                            style="display:flex; justify-content: flex-end; align-items: baseline; ">
                                                            <p style="padding-right: 16px;">Descargar Todo</p>
                                                            <form method="POST"
                                                                action="{{ route('downloadAllTrata') }}">
                                                                @csrf
                                                                <input type="hidden" name="reportes"
                                                                    value="{{ $RegistrosTratamiento }}">
                                                                <button class="btn btn-secondary" type="submit">
                                                                    <img style="height: 30px" width="30px"
                                                                        src="{{  asset ('/images/download.png')}}">
                                                                    </img>
                                                                </button>
                                                            </form>

                                                        </div>

                                                    </div>

                                                    <br>
                                                    <br>
                                                    <tbody>
                                                        @foreach ($RegistrosTratamiento as $regTratamiento)
                                                            <tr>
                                                                <td style="text-align: center ">
                                                                    <font color="#2A2F43">
                                                                        <b>
                                                                            {{ \Carbon\Carbon::parse($regTratamiento->fecha_diligencia_trata)->format('d-m-Y') }}
                                                                        </b>
                                                                    </font>
                                                                </td>
                                                                <td style="text-align: center ">
                                                                    <font color="#2A2F43">
                                                                        <b>
                                                                            {{ $regTratamiento->descripcion_trata }}
                                                                        </b>
                                                                    </font>
                                                                </td>
                                                                <td style="text-align: center ">
                                                                    <font color="#2A2F43">
                                                                        <b>
                                                                            {{ $regTratamiento->inconfor_trata }}
                                                                        </b>
                                                                    </font>
                                                                </td>
                                                                <td style="text-align: center ">
                                                                    <font color="#2A2F43">
                                                                        <b>
                                                                            {{ $regTratamiento->proceso_rela_trata }}
                                                                        </b>
                                                                    </font>
                                                                </td>
                                                                <td style="text-align: center ">
                                                                    <font color="#2A2F43">
                                                                        <b>
                                                                            {{ $regTratamiento->detectado_persona }}
                                                                        </b>
                                                                    </font>
                                                                </td>
                                                                <td style="text-align: center">
                                                                    <font color="#2A2F43">
                                                                        <button class="btn btn-secondary"
                                                                            onclick="window.location.href = '{{ asset ('/panel/noconformidades/ver/tratamiento/')}}{{ $regTratamiento->id_tratamiento }}'">
                                                                            <img style="height: 30px" width="30px"
                                                                                src="{{ asset ('/images/mostrar-informe.png')}}">
                                                                            </img>
                                                                        </button>
                                                                    </font>
                                                                </td>
                                                                <td style="text-align: center ">
                                                                    <font color="#2A2F43">
                                                                        <button class="btn btn-secondary"
                                                                            onclick="window.location.href = '{{ asset ('/panel/noconformidades/word/tratamiento/')}}{{ $regTratamiento->id_tratamiento }}'">
                                                                            <img style="height: 30px" width="30px"
                                                                                src="{{ $server }}/images/download.png">
                                                                            </img>
                                                                        </button>
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
                            @endif

                            @if (isset($RegistrosReporte))
                                <div class="table-responsive">
                                    <table class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr style="background-color:#39405a">
                                                <th>
                                                    <font color="white">
                                                        Registros encontrados (Reporte acciones corretivas y/o mejoras)
                                                    </font>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tr>
                                            <td>
                                                <table id="registros-table"
                                                    class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                    <thead>
                                                        <tr style="background-color: #F8F8F8">
                                                            <th style="text-align: center;">
                                                                Fecha
                                                            </th>
                                                            <th style="text-align: center;">
                                                                Proceso
                                                            </th>
                                                            {{-- <th style="text-align: center;">
                                                                Estado
                                                            </th> --}}
                                                            <th style="text-align: center">
                                                                Mostrar
                                                            </th>
                                                            <th style="text-align: center">
                                                                Descargar
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <div class="row"
                                                        style="display: flex; align-items: center; justify-content: space-around">
                                                        <form method="post"
                                                            action="{{ route('descargaReporteDbExcel') }}">
                                                            @csrf
                                                            <div class="col-md-3">

                                                                <label for="fecha_ini_repor" style="color: #34495e">
                                                                    <b>
                                                                        Desde la fecha:
                                                                    </b>
                                                                </label>

                                                                <input type="date" id="fecha_ini_repor" name="fecha_ini_repor"
                                                                    class="form-control" max="{{ date('Y-m-d') }}">
                                                            </div>

                                                            <div class="col-md-3">

                                                                <label for="fecha_final_repor" style="color: #34495e">
                                                                    <b>
                                                                        Hasta la fecha:
                                                                    </b>
                                                                </label>

                                                                <input type="date" id="fecha_final_repor" name="fecha_final_repor"
                                                                    class="form-control" max="{{ date('Y-m-d') }}"
                                                                    disabled>
                                                            </div>

                                                            <button id="btn_search_reporte"
                                                                style="margin-right: 120px;margin-top: 32px;"
                                                                class="btn btn-success mb-2">
                                                                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                                                Descargar Excel
                                                                </img>
                                                            </button>

                                                        </form>

                                                        <div
                                                            style="display:flex;justify-content: flex-end; align-items: baseline;">
                                                            <p style="padding-right: 16px;">Descargar Todo</p>
                                                            <form method="POST"
                                                                action="{{ route('downloadAllRepor') }}">
                                                                @csrf
                                                                <input type="hidden" name="reportes"
                                                                    value="{{ $RegistrosReporte }}">
                                                                <button class="btn btn-secondary" type="submit">
                                                                    <img style="height: 30px" width="30px"
                                                                        src="{{ asset ('/images/download.png')}}">
                                                                    </img>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <tbody>
                                                        @foreach ($RegistrosReporte as $regReporte)
                                                            <tr>
                                                                <td style="text-align: center ">
                                                                    <font color="#2A2F43">
                                                                        <b>
                                                                            {{ \Carbon\Carbon::parse($regReporte->fecha_elaboracion)->format('d-m-Y') }}
                                                                        </b>
                                                                    </font>
                                                                </td>
                                                                <td style="text-align: center ">
                                                                    <font color="#2A2F43">
                                                                        <b>
                                                                            {{ $regReporte->proceso_no_conforme }}
                                                                        </b>
                                                                    </font>
                                                                </td>
                                                                {{-- <td style="text-align: center ">
                                                                    <font color="#2A2F43">
                                                                        <b>
                                                                            {{ $regReporte->estado_reporte }}
                                                                        </b>
                                                                    </font>
                                                                </td> --}}




                                                                {{-- <td style="text-align: left ">
                                                        <font color="#2A2F43">
                                                          <b>
                                                            {{$regTratamiento->descripcion_no_conformidad}}
                                                          </b>
                                                        </font>
                                                      </td>
                                                      <td style="text-align: left ">
                                                        <font color="#2A2F43">
                                                          <b>
                                                            {{$regTratamiento->inconformidad}}
                                                          </b>
                                                        </font>
                                                      </td>
                                                      <td style="text-align: left ">
                                                        <font color="#2A2F43">
                                                          <b>
                                                            {{$regTratamiento->tratamiento_producto}}
                                                          </b>
                                                        </font>
                                                      </td>
                                                      <td style="text-align: left ">
                                                        <font color="#2A2F43">
                                                          <b>
                                                            {{$regTratamiento->detectado_persona}}
                                                          </b>
                                                        </font>
                                                      </td> --}}
                                                                <td style="text-align: center ">
                                                                    <font color="#2A2F43">
                                                                        <button class="btn btn-secondary"
                                                                            onclick="window.location.href = '{{ asset ('/panel/noconformidades/ver/reporte/')}}{{ $regReporte->id_reporte_conform }}'">
                                                                            <img style="height: 30px" width="30px"
                                                                                src="{{ asset ('/images/mostrar-informe.png')}}">
                                                                            </img>
                                                                        </button>
                                                                    </font>
                                                                </td>
                                                                <td style="text-align: center ">
                                                                    <font color="#2A2F43">
                                                                        <button class="btn btn-secondary"
                                                                            onclick="window.location.href = '{{ asset ('/panel/noconformidades/excel/reporte/')}}{{ $regReporte->id_reporte_conform }}'">
                                                                            <img style="height: 30px" width="30px"
                                                                                src="{{ asset ('/images/download.png')}}">
                                                                            </img>
                                                                        </button>
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
                            @endif

                        </div>
                        <!-- -------------- /Column Center -------------- -->
                    </div>
                </section>
                <!-- -------------- /Content -------------- -->
            </section>
        </div>




        <!-- -------------- Scripts -------------- -->




        <!-- -------------- /Body Wrap  -------------- -->

        <!-- -------------- Scripts -------------- -->

        <!-- -------------- jQuery -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js')}}"></script>

        <!-- -------------- JvectorMap Plugin -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js')}}"></script>
        <script src="<{{ asset ('/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js')}}"></script>

        <!-- -------------- HighCharts Plugin -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/plugins/highcharts/highcharts.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/plugins/c3charts/d3.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.js')}}"></script>

        <!-- -------------- Theme Scripts -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/utility/utility.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/demo/demo.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/main.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/demo/widgets_sidebar.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/pages/dashboard2.js')}}"></script>

        <!-- -------------- Page JS -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/demo/charts/highcharts.js')}}"></script>

        <!-- -------------- DataTables -------------- -->
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>


        <!-- -------------- /Scripts -------------- -->

        <script>
            $(document).ready(function() {

                let datatable = $('#registros-table').DataTable({
                    ordering: true,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    }
                });

                $("#fecha_ini_trata").change(function() {
                    var fechaIni = $("#fecha_ini_trata").val();
                    $("#fecha_final_trata").attr("min",
                        fechaIni).removeAttr("disabled").val('');
                });

                $("#fecha_ini_repor").change(function() {
                    var fechaIni = $("#fecha_ini_repor").val();
                    $("#fecha_final_repor").attr("min",
                        fechaIni).removeAttr("disabled").val('');
                });

            })
        </script>

    </body>
@endforeach
