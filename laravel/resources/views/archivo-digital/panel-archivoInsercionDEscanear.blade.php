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

        <script>
            $(document).ready(function($) {
                $('.select2-init').each(function() {
                    $(this).select2(); // Inicializa el select2 para cada selector
                });
            });
        </script>


        <style>
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

            /**********File Inputs**********/
            .container-input {
                text-align: center;
                background: #282828;
                border-top: 5px solid #c39f77;
                padding: 50px 0;
                border-radius: 6px;
                width: 50%;
                margin: 0 auto;
                margin-bottom: 20px;
            }

            .inputfile {
                width: 0.1px;
                height: 0.1px;
                opacity: 0;
                overflow: hidden;
                position: absolute;
                z-index: -1;
            }

            .inputfile+label {
                max-width: 80%;
                font-size: 1.25rem;
                font-weight: 700;
                text-overflow: ellipsis;
                white-space: nowrap;
                cursor: pointer;
                display: inline-block;
                overflow: hidden;
                padding: 0.625rem 1.25rem;
            }

            .inputfile+label svg {
                width: 1em;
                height: 1em;
                vertical-align: middle;
                fill: currentColor;
                margin-top: -0.25em;
                margin-right: 0.25em;
            }

            .iborrainputfile {
                font-size: 16px;
                font-weight: normal;
                font-family: 'Lato';
            }


            /* style 3 */

            .inputfile-3+label {
                color: #000000;
            }

            .inputfile-3:focus+label,
            .inputfile-3.has-focus+label,
            .inputfile-3+label:hover {
                color: #c39f77;
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
                                        <form id="escaneoInsercionForm" method="POST"
                                            action="{{ route('escanear.insercion') }}" enctype="multipart/form-data">
                                            @csrf
                                            <table id="tabla_dashboard_isa" class="table " style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th style="">Dependencia</th>
                                                        <th style="text-align: center; ">Codigo Caja</th>
                                                        <th style="text-align: center ; ">Asunto o titulo de la unidad
                                                            documental</th>
                                                        <th style="text-align: center;">Descripcion</th>
                                                        <th style="text-align: center;">Accion</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $u = 1;
                                                    @endphp

                                                    @foreach ($DatosSolIns as $index => $DatReFu)
                                                        <tr class="message-unread">
                                                            <td>
                                                                <input type="hidden" id="id_solicitud"
                                                                    name="id_solicitud"
                                                                    value="{{ $DatReFu->id_solicitud }}" />
                                                                <input type="hidden" id="id_insercion"
                                                                    name="id_insercion[]"
                                                                    value="{{ $DatReFu->id_insercion }}" />
                                                                <font color="#2A2F43" size="2">
                                                                    <?php
                                                                    print $u;
                                                                    $u++;
                                                                    ?>
                                                                </font>
                                                            </td>
                                                            <td>

                                                                <select class="form-select select2-init"
                                                                    id="dependencia_{{ $index }}"
                                                                    name="dependencia[]"
                                                                    style="width: 180px; border: 1px solid #ced4da;padding:0.375rem 0.75rem;font-size: 1.5rem;line-height: 1.5;border-radius: 0.25rem;height: 30px; border: 1px solid black;" required>
                                                                    <option value="">
                                                                        * Selecione la dependencia...
                                                                    </option>
                                                                    @foreach ($Datosfuids as $DatFuid)
                                                                        <option> {{ $DatFuid->dependencia }}</option>
                                                                    @endforeach
                                                                </select>

                                                            </td>
                                                            <td>
                                                                <select class="form-select select2-init"
                                                                    id="codigo_caja_{{ $index }}"
                                                                    name="codigo_caja[]"
                                                                    style="width: 180px; border: 1px solid #ced4da;padding:0.375rem 0.75rem;font-size: 1.5rem;line-height: 1.5;border-radius: 0.25rem;height: 30px; border: 1px solid black;" required>
                                                                    <option value="">
                                                                        * Selecione codigo de caja...
                                                                    </option>
                                                                    @foreach ($Datosfuids as $DatFuid)
                                                                        <option> {{ $DatFuid->codigo_caja }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-select select2-init"
                                                                    id="asunto_{{ $index }}" name="asunto[]"
                                                                    style="width: 180px; border: 1px solid #ced4da;padding:0.375rem 0.75rem;font-size: 1.5rem;line-height: 1.5;border-radius: 0.25rem;height: 30px; border: 1px solid black;" required>
                                                                    <option value="">
                                                                        * Selecione el titulo...
                                                                    </option>
                                                                    @foreach ($Datosfuids as $DatFuid)
                                                                        <option>
                                                                            {{ $DatFuid->titulo_unidad_documental }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" id="descripcion"
                                                                    name="descripcion[]"
                                                                    value="{{ $DatReFu->descripcion }}" />
                                                                <font color="#2A2F43" size="2">
                                                                    {{ $DatReFu->descripcion }}
                                                                </font>
                                                            </td>
                                                            <td>
                                                                <input type="file" name="file-3[]"
                                                                    id="file-{{ $index }}"
                                                                    class="inputfile inputfile-3" accept=".jpg, .png, .pdf" required />
                                                                <label for="file-{{ $index }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="iborrainputfile" width="20"
                                                                        height="17" viewBox="0 0 20 17">
                                                                        <path
                                                                            d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z">
                                                                        </path>
                                                                    </svg>
                                                                    <span class="iborrainputfile">Seleccionar
                                                                        archivo</span>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>

                                            </table>
                                            <br>
                                            <div>
                                                <button type="submit" style="display: flex; justify-content: flex-end" class="btn btn-success"
                                                    id="btnEnviar">Confirmar</button>
                                            </div>
                                        </form>
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
            $('#tabla_dashboard_isa').DataTable({

            });
            document.getElementById('escaneoInsercionForm').addEventListener('submit', function(event) {
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
                                title: "Insercion registrada correctamente!",
                                showConfirmButton: false,
                                timer: 1500
                            });

                            window.location.href = '<?= $server ?>/panel/archivo/inserciond';
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
