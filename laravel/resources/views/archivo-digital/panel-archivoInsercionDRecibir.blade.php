<?php

use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\ArchivoDigital\PanelHistorias;
use App\Models\ArchivoDigital\PanelTipoDocumento;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>
            Intranet | Archivo Digital
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

        {{-- Importar styles y funcionamiento del Select2 --}}
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">


        <script type="text/javascript" src="{{ asset ('/panelfiles/select2/dist/js/select2.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/select2/dist/css/select2.min.css')}}">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.css')}}">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css')}}">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="{{ asset ('/panelfiles/assets/img/favicon.ico')}}">
        <!-- -------------- DataTables -------------- -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
        <!-- Editor -->
        <script type="text/javascript" src="{{ asset ('/panelfiles/ckeditor/ckeditor.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <!-- SweetAlert2 -->

        <script src="{{ asset ('/panelfiles/sweetalert/dist/sweetalert.min.js')}}"></script>
        <link rel="stylesheet" href="{{ asset ('/panelfiles/sweetalert/dist/sweetalert.css')}}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


        <script src="https://www.jsdelivr.com/package/npm/pdfjs-dist"></script>
        <script src="https://cdnjs.com/libraries/pdf.js"></script>
        <script src="https://unpkg.com/pdfjs-dist/"></script>

        <link rel="stylesheet" type="text/css" href="{{ asset('/public/css/archivo-digital/panel-archivoInsercionDRecibir.blade.css') }}">

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
                                <a href="{{ asset ('/panel/menu/108')}}" title="Inicio">
                                    <font color="#34495e">
                                        Archivo digital >
                                    </font>

                                    <font color="#b4c056">
                                        Insercion Documental
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset ('/panel/menu/108')}}" class="btn btn-primary btn-sm ml10" title="Inicio">
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
                        <div class="panel m4">
                            <!-- -------------- Message Body -------------- -->
                            <div class="nano-content">
                                <div class="card-title">
                                    <div class="row titulo title-background"><span>Insercion
                                            Documental</span></div>
                                </div>
                                <form action="{{ route('recibir.solicitudinsercion') }}" id="recibirTransferenciaD"
                                    method="post">
                                    @csrf
                                    <div class="card card-spacing">
                                        <div class="row" name="lista_articulos_sst" id="lista_articulos_sst">
                                            <div class="d-flex justify-content-center">
                                                <input type="hidden" name="id_solicitud"
                                                    value="{{ $DatosSolIns[0]->id_solicitud }}"
                                                    {{ $disabled ? 'disabled' : '' }}>
                                                <table id="tabla_registros" class="table" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 10px">#</th>
                                                            <th style="text-align: center; width: 200px">Descripcion
                                                                nombre del documento o expediente</th>
                                                            <th style="text-align: center ; width: 20px">N° Folios </th>
                                                            <th style="text-align: center;width: 180px;">Observaciones
                                                            </th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $u = 1;
                                                        @endphp
                                                        @foreach ($DatosSolIns as $DatF)
                                                            <tr>
                                                                <input type="hidden" name="id_insercion[]"
                                                                    value="{{ $DatF->id_insercion }}"
                                                                    {{ $disabled ? 'disabled' : '' }}>
                                                                <td>
                                                                    @php
                                                                        print $u;
                                                                        $u++;
                                                                    @endphp
                                                                </td>
                                                                <td><input type="text" name="descripcion[]"
                                                                        id="descripcion" class='form-control'
                                                                        value="{{ $DatF->descripcion }}"
                                                                        {{ $disabled ? 'disabled' : '' }}>
                                                                </td>
                                                                <td><input type="text" name="folios[]"
                                                                        id="folios" value="{{ $DatF->nro_folios }}"
                                                                        class='form-control'
                                                                        {{ $disabled ? 'disabled' : '' }}>
                                                                </td>
                                                                <td>
                                                                    <textarea type="text" name="observaciones[]" id="observaciones" value="{{ $DatF->observaciones }}"
                                                                        class='form-control' {{ $disabled ? 'disabled' : '' }}>{{ $DatF->observaciones }}</textarea>

                                                                </td>

                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                        <div class="row" name="lista_articulos_sst" id="lista_articulos_sst">
                                            <div class="col-md-12">
                                                <label for="observacion_general">Observaciones:</label>
                                                <textarea class="form-control" rows="5" id="observacion_general" name="observacion_general"
                                                    {{ $disabled ? 'disabled' : '' }}>{{ $DatosSolIns[0]->observacion_general }}</textarea>
                                            </div>
                                        </div>
                                </form>
                                <div
                                    style="display: flex; justify-content: flex-end; align-items: center; margin: 20px;">
                                    @if ($DatosSolIns[0]->estado == 1)
                                        <button id="btn_adjuntar" type="submit" class="btn btn-secondary mb-2"
                                            {{ $disabled ? 'disabled' : '' }}>
                                            <img src="{{ asset ('/images/aceptar2.png')}}">
                                            Recibir Insercion
                                            </img>
                                        </button>
                                    @elseif($DatosSolIns[0]->estado == 2 || $DatosSolIns[0]->estado == 3)
                                        <button id="btn_adjuntar" type="submit" class="btn btn-secondary mb-2"
                                            {{ $disabled ? 'disabled' : '' }}>
                                            <img src="{{ asset ('/images/edit-file.png')}}">
                                            Editar Insercion
                                            </img>
                                        </button>
                                    @endif


                                </div>
                            </div>
                        </div>
                        {{-- <input type="hidden" id="empleado_transfer" name="empleado_hidden" value="{{$DatLog->empleado}}"> --}}
                    </div>
        </div>
        <!-- -------------- /Column Center -------------- -->
        </div>
        </section>
        <!-- -------------- /Content -------------- -->
        </section>
        </div>

        <!-- -------------- /Body Wrap  -------------- -->

        <!-- -------------- Scripts -------------- -->

        <!-- -------------- jQuery -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js')}}"></script>

        <!-- -------------- JvectorMap Plugin -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js')}}"></script>

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



        <script>
            $('#tabla_registros').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                scrollX: true,
                searching: false,
                paging: false
            });

            document.getElementById('recibirTransferenciaD').addEventListener('submit', function(event) {
                // Evitar que el formulario se envíe de forma predeterminada
                event.preventDefault();
                // Realizar la petición AJAX para enviar el formulario
                fetch(this.action, {
                        method: this.method,
                        body: new FormData(this),
                    })
                    .then(response => {
                        // Si la respuesta es exitosa, recargar la página
                        if (response.ok) {
                            Swal.fire({

                                icon: "success",
                                title: "Insercion recibida correctamente!",
                                showConfirmButton: false,
                                timer: 1500
                            });

                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error al enviar el formulario:', error);
                    });
            });
        </script>

        <!-- -------------- /Scripts -------------- -->

    </body>

    </html>
@endforeach
