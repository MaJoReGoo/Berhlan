<?php
$server = '/Berhlan/public';
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
        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/skin/default_skin/css/theme.css">

        {{-- Importar styles y funcionamiento del Select2 --}}
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">


        <script type="text/javascript" src="<?= $server ?>/panelfiles/select2/dist/js/select2.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/select2/dist/css/select2.min.css">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/allcp/forms/css/forms.min.css">
        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/allcp/forms/css/forms.css">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="<?= $server ?>/panelfiles/assets/img/favicon.ico">
        <!-- -------------- DataTables -------------- -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
        <!-- Editor -->
        <script type="text/javascript" src="<?= $server ?>/panelfiles/ckeditor/ckeditor.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <!-- SweetAlert2 -->

        <script src="<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.min.js"></script>
        <link rel="stylesheet" href="<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


        <script src="https://www.jsdelivr.com/package/npm/pdfjs-dist"></script>
        <script src="https://cdnjs.com/libraries/pdf.js"></script>
        <script src="https://unpkg.com/pdfjs-dist/"></script>


        <style>
            .remove-btn {
                background: #f3d6d6;
                border: 1px solid red;
                display: flex;
                align-items: end;
                border-radius: 5px;
            }

            .card-spacing {
                padding: 30px;

            }

            .titulo {
                width: 98%;
                background-color: #003f6d;
                padding: 0 10px;
                text-transform: uppercase;
                margin-top: 10px;
                margin-left: 10px;
                margin-bottom: 10px;
                padding-right: 15px;
            }

            .title-background {
                background: #1e5799;
                /* Old browsers */
                background: -moz-linear-gradient(45deg,
                        #003f6d 0%,
                        #003f6d 50%,
                        #003f6d 51%,
                        #ffffff 52%);
                /* FF3.6-15 */
                background: -webkit-linear-gradient(45deg,
                        #003f6d 0%,
                        #003f6d 50%,
                        #003f6d 51%,
                        #ffffff 52%);
                /* Chrome10-25,Safari5.1-6 */
                background: linear-gradient(45deg,
                        #003f6d 0%,
                        #003f6d 50%,
                        #003f6d 51%,
                        #ffffff 52%);
                /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#ffffff', GradientType=1);
                /* IE6-9 fallback on horizontal gradient */
                border-bottom-color: #003f6d;
                border-bottom-style: solid;
                color: #ffffff;
            }

            .rqs {
                margin-bottom: 20px;
            }
        </style>

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
                                <a href="<?= $server ?>/panel/menu/108" title="Inicio">
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
                        <a href="<?= $server ?>/panel/menu/108" class="btn btn-primary btn-sm ml10" title="Inicio">
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
                                <div class="card card-spacing">

                                    <br>
                                    <br>
                                    <div>
                                        <table id="tabla_dashboard_arf" class="table " style="width:100%">
                                            <thead>
                                                <tr>

                                                    <th>#</th>
                                                    <th>Entregado por</th>
                                                    <th>Fecha entrega</th>
                                                    <th>Recibido por</th>
                                                    <th>Fecha recibido</th>
                                                    <th>Cantidad archivos</th>
                                                    <th>Observacion general</th>
                                                    <th>Estado</th>
                                                    <th>Info</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $u = 1;
                                                @endphp
                                                @foreach ($DatosInserciones as $DatReFu)
                                                    @php
                                                        $empleadoE = PanelEmpleados::getEmpleado(
                                                            $DatReFu->nombre_entrega,
                                                        );
                                                        $empleadoR = PanelEmpleados::getEmpleado(
                                                            $DatReFu->recibido_por,
                                                        );
                                                        //dd($empleadoR, $empleadoE);
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            @php
                                                                print $u;
                                                                $u++;
                                                            @endphp
                                                        </td>
                                                        <td>
                                                            @if (!empty($empleadoE[0]))
                                                                {{ $empleadoE[0]->primer_nombre }}
                                                                {{ $empleadoE[0]->ot_nombre }}
                                                                {{ $empleadoE[0]->primer_apellido }}
                                                                {{ $empleadoE[0]->ot_apellido }}
                                                            @endif
                                                        </td>

                                                        <td>{{ $DatReFu->fecha_entrega }}</td>

                                                        <td>
                                                            @if (!empty($empleadoR[0]))
                                                                {{ $empleadoR[0]->primer_nombre }}
                                                                {{ $empleadoR[0]->ot_nombre }}
                                                                {{ $empleadoR[0]->primer_apellido }}
                                                                {{ $empleadoR[0]->ot_apellido }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $DatReFu->fecha_recibe }}</td>
                                                        <td style="text-align: center">
                                                            {{ $DatReFu->cantidad_archivos }}</td>
                                                        <td>{{ $DatReFu->observacion_general }}</td>

                                                        <td>
                                                            @if ($DatReFu->estado == 1)
                                                                <font style="color: #1e5799">Pendiente</font>
                                                            @elseif($DatReFu->estado == 2)
                                                                <font style="color: green">Recibido</font>
                                                            @elseif($DatReFu->estado == 3)
                                                                <font style="color: green">Recibido y Digitalizado
                                                                </font>
                                                            @endif

                                                        <td>
                                                            @if ($DatReFu->estado == 1)
                                                                <button id="btn_adjuntar" type="button"
                                                                    class="btn mb-2" style="background: none"
                                                                    onclick="window.location.href='<?= $server ?>/panel/archivo/inserciond/recibir/<?= $DatReFu->id_solicitud ?>'">
                                                                    <img
                                                                        src="{{ $server }}/images/comprobar.png"></img>
                                                                </button>
                                                            @elseif($DatReFu->estado == 2 || $DatReFu->estado == 3)
                                                                <button id="btn_adjuntar" type="button"
                                                                    class="btn mb-2" style="background: none"
                                                                    onclick="window.location.href='<?= $server ?>/panel/archivo/inserciond/recibir/<?= $DatReFu->id_solicitud ?>'">
                                                                    <img
                                                                        src="{{ $server }}/images/editar-codigo.png"></img>
                                                                </button>
                                                            @endif
                                                            @if ($DatReFu->estado == 2 || $DatReFu->estado == 3)
                                                                <button id="btn_adjuntar" type="button"
                                                                    class="btn mb-2" style="background: none"
                                                                    onclick="window.location.href='<?= $server ?>/panel/archivo/inserciond/escaner/<?= $DatReFu->id_solicitud ?>'">
                                                                    <img
                                                                        src="{{ $server }}/images/escanear.png"></img>
                                                                </button>
                                                            @else
                                                                <button id="btn_adjuntar" type="button"
                                                                    class="btn mb-2" style="background: none"
                                                                    onclick="window.location.href='<?= $server ?>/panel/archivo/inserciond/escaner/<?= $DatReFu->id_solicitud ?>'"
                                                                    disabled>
                                                                    <img
                                                                        src="{{ $server }}/images/escanear.png"></img>
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="nano-content" style="display: none" id="card-info">

                                <div class="card-body rqs shadow bg-body rounded">

                                </div>
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

        <!-- -------------- Scripts -------------- -->

        <!-- -------------- jQuery -------------- -->
        <script src="<?= $server ?>/panelfiles/assets/js/jquery/jquery-1.11.3.min.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js"></script>

        <!-- -------------- JvectorMap Plugin -------------- -->
        <script src="<?= $server ?>/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js"></script>

        <!-- -------------- HighCharts Plugin -------------- -->
        <script src="<?= $server ?>/panelfiles/assets/js/plugins/highcharts/highcharts.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/d3.min.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/c3.min.js"></script>

        <!-- -------------- Theme Scripts -------------- -->
        <script src="<?= $server ?>/panelfiles/assets/js/utility/utility.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/demo/demo.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/main.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/demo/widgets_sidebar.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/pages/dashboard2.js"></script>

        <!-- -------------- Page JS -------------- -->
        <script src="<?= $server ?>/panelfiles/assets/js/demo/charts/highcharts.js"></script>

        <!-- -------------- DataTables -------------- -->
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

        <script>
            $('#tabla_dashboard_arf').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });

            $('#message-table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });

            function setFuidId(id) {
                document.getElementById('id_solicitud_h').value = id;

            }
        </script>

        <!-- -------------- /Scripts -------------- -->

    </body>

    </html>
@endforeach
