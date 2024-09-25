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
        <link rel="stylesheet" type="text/css" href="<{{ asset ('/panelfiles/assets/skin/default_skin/css/theme.css')}}">

        {{-- Importar styles y funcionamiento del Select2 --}}
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">


        <script type="text/javascript" src="<{{ asset ('/panelfiles/select2/dist/js/select2.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="<{{ asset ('/panelfiles/select2/dist/css/select2.min.css')}}">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="<{{ asset ('/panelfiles/assets/allcp/forms/css/forms.min.css')}}">
        <link rel="stylesheet" type="text/css" href="<{{ asset ('/panelfiles/assets/allcp/forms/css/forms.css')}}">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="<{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css')}}">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="<{{ asset ('/panelfiles/assets/img/favicon.ico')}}">
        <!-- -------------- DataTables -------------- -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
        <!-- Editor -->
        <script type="text/javascript" src="<{{ asset ('/panelfiles/ckeditor/ckeditor.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <!-- SweetAlert2 -->

        <script src="<{{ asset ('/panelfiles/sweetalert/dist/sweetalert.min.js')}}"></script>
        <link rel="stylesheet" href="<{{ asset ('/panelfiles/sweetalert/dist/sweetalert.css')}}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


        <script src="https://www.jsdelivr.com/package/npm/pdfjs-dist"></script>
        <script src="https://cdnjs.com/libraries/pdf.js"></script>
        <script src="https://unpkg.com/pdfjs-dist/"></script>

        <link rel="stylesheet" type="text/css" href="{{ asset('css/archivo-digital/panel-archivoHistoriasConsulta.blade.css') }}">


        <script>
            jQuery(document).ready(function($) {
                $("#empleado_historia").select2({
                    closeOnSelect: true,
                    width: '250px'
                });
            });
            jQuery(document).ready(function($) {
                $(".form-select").select2({
                    closeOnSelect: true,
                    width: '180px'
                });
            });
        </script>
        @include('archivo-digital.modales.modal-editArchivoHistoria')
        @include('archivo-digital.modales.modal-archivoHistorias')
        @include('archivo-digital.modales.modal-archivoTipoDocumentos')

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
                                <a href="<{{ asset ('/panel/menu/108" title="Inicio')}}">
                                    <font color="#34495e">
                                        Archivo digital >
                                    </font>

                                    <font color="#b4c056">
                                        Historias Laborales
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="<{{ asset ('/panel/menu/108" class="btn btn-primary btn-sm ml10')}}" title="Inicio">
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
                                    <div class="row titulo title-background"><span>Historias laborares</span></div>
                                </div>
                                <div class="card card-spacing">
                                    <div class="card-body rqs shadow bg-body rounded">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <form action="3" class="form-inline">

                                                    <div class="form-group mx-sm-3 mb-2">
                                                        <select name="empleado_historia" id="empleado_historia"
                                                            required>
                                                            <option>
                                                                <font style="color: black">Seleccione ----</font>
                                                            </option>
                                                            @foreach ($DatosEmpleados as $DatEmpl)
                                                                <option value="{{ $DatEmpl->id_empleado }}">
                                                                    <font style="color: black">
                                                                        {{ $DatEmpl->identificacion . ' - ' . $DatEmpl->primer_nombre . ' ' . $DatEmpl->ot_nombre . ' ' . $DatEmpl->primer_apellido . ' ' . $DatEmpl->ot_apellido }}
                                                                    </font>
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" id="cargarEmpleadoBtn"
                                                            class="btn btn-primary mb-2">
                                                            <img src="{{ $server }}/images/slect.png">
                                                            Selecione
                                                            Empleado
                                                            </img>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" id="cargarEmpleadoBtn"
                                                    class="btn btn-secondary mb-2" data-toggle="modal" data-target="#creacionTipoDoc">
                                                    <img src="{{ $server }}/images/type_documents.png">
                                                    Crear Tipo Documento
                                                    </img>
                                                </button>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="nano-content" style="display: none" id="card-info">
                                <div class="card card-spacing">
                                    <div class="card-body rqs shadow bg-body rounded">
                                        <div class="row">
                                            <div class="col-md-6" id="infoEmpleado">

                                            </div>
                                            <div class="col-md-6 " style="align-self: flex-end">

                                                <button id="btn_descargar" class="btn btn-primary mb-2"
                                                    style="display: none;" onclick="obtenerid()">
                                                    <img src="{{ $server }}/images/dow-folder.png">
                                                    Descargar Historia
                                                </button>

                                                <button id="btn_adjuntar" type="button" class="btn btn-primary mb-2"
                                                    data-toggle="modal" data-target="#adjuntarArchivos"
                                                    onclick="copiarEmpleado()">
                                                    <img src="{{ $server }}/images/add-task.png">
                                                    Adjuntar Archivos
                                                    </img>
                                                </button>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="card-body rqs shadow bg-body rounded">
                                        <table id="message-table"
                                            class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                            <thead style="color: #1e5799">
                                                <tr style="background-color: #b2b2db">
                                                    <th style="text-align:center;">
                                                        #
                                                    </th>
                                                    <th style="text-align:center;">
                                                        Tipo Documento
                                                    </th>
                                                    <th style="text-align:center;">
                                                        Ubicacion Fisica
                                                    </th>
                                                    <th style="text-align:center;">
                                                        Usuario y Fecha Creacion
                                                    </th>
                                                    <th style="text-align:center;">
                                                        Usuario y Fecha Actualizacion
                                                    </th>
                                                    <th style="text-align:center;">
                                                        Acciones
                                                    </th>

                                                </tr>
                                            </thead>

                                            <tbody id="tablaDocumentos">

                                            </tbody>
                                        </table>
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
        <script src="<{{ asset ('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js"></script>
        <script src="<{{ asset ('/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js"></script>

        <!-- -------------- JvectorMap Plugin -------------- -->
        <script src="<{{ asset ('/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js')}}"></script>
        <script src="<{{ asset ('/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js')}}"></script>

        <!-- -------------- HighCharts Plugin -------------- -->
        <script src="<{{ asset ('/panelfiles/assets/js/plugins/highcharts/highcharts.js')}}"></script>
        <script src="<{{ asset ('/panelfiles/assets/js/plugins/c3charts/d3.min.js')}}"></script>
        <script src="<{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.js')}}"></script>

        <!-- -------------- Theme Scripts -------------- -->
        <script src="<{{ asset ('/panelfiles/assets/js/utility/utility.js')}}"></script>
        <script src="<{{ asset ('/panelfiles/assets/js/demo/demo.js')}}"></script>
        <script src="<{{ asset ('/panelfiles/assets/js/main.js')}}"></script>
        <script src="<{{ asset ('/panelfiles/assets/js/demo/widgets_sidebar.js')}}"></script>
        <script src="<{{ asset ('/panelfiles/assets/js/pages/dashboard2.js')}}"></script>

        <!-- -------------- Page JS -------------- -->
        <script src="<{{ asset ('/panelfiles/assets/js/demo/charts/highcharts.js')}}"></script>

        <!-- -------------- DataTables -------------- -->
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

        <script>
            $('#message-table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });


        </script>

        <!-- -------------- /Scripts -------------- -->
        <script>
            function obtenerid() {
                var empleadoSeleccionado = document.getElementById('empleado_historia').value;

                fetch(`{{ env('API_BASE_URL') }}/Berhlan/public/panel/archivo/historias/${empleadoSeleccionado}`)
                    .then(response => response.json())
                    .then(data => {
                        // Actualizar el contenido del div con los datos del empleado
                        fetch(
                                `{{ env('API_BASE_URL') }}/Berhlan/public/panel/archivo/historias/documentos/${empleadoSeleccionado}`
                            )

                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.blob(); // Obtener el archivo como un blob
                            })
                            .then(blob => {
                                console.log(data);
                                // Crear un objeto URL para el blob
                                var url = window.URL.createObjectURL(blob);

                                // Crear un enlace <a> para descargar el archivo
                                var a = document.createElement('a');
                                a.href = url;
                                a.download = data.empleado[0].identificacion + '.zip'; // Nombre del archivo ZIP
                                document.body.appendChild(a);
                                a.click(); // Simular clic en el enlace para descargar el archivo
                                window.URL.revokeObjectURL(url); // Liberar el objeto URL
                            })
                            .catch(error => console.error('Error:', error));
                    })
                    .catch(error => console.error('Error:', error));


            }

            function copiarEmpleado() {
                var empleadoSeleccionado = document.getElementById('empleado_historia').value;
                document.getElementById('empleado_hidden').value = empleadoSeleccionado;

            }

            function copiarEmpleado2() {
                var empleadoSeleccionado = document.getElementById('empleado_historia').value;
                document.getElementById('empleado_hidden2').value = empleadoSeleccionado;

            }

            function setDocumentoId(id) {
                document.getElementById('documento_id').value = id;

            }

            function descargarArchivo(url) {
                // Crear un elemento <a> invisible
                var a = document.createElement('a');
                a.style.display = 'none';
                document.body.appendChild(a);

                // Establecer la URL del archivo y simular el clic en el elemento <a>
                a.href = url;
                a.download = url.split('/').pop(); // Nombre de archivo para la descarga
                a.click();

                // Eliminar el elemento <a> después de la descarga
                document.body.removeChild(a);
            }
            document.addEventListener('DOMContentLoaded', function() {
                var empleadoSeleccionado = localStorage.getItem('empleadoSeleccionado');
                if (empleadoSeleccionado) {
                    // Coloca el ID del empleado seleccionado en el campo de entrada o realiza cualquier otra acción necesaria para cargar los datos del empleado
                    document.getElementById('empleado_historia').value = empleadoSeleccionado;
                    // Simula el clic en el botón para cargar los datos del empleado
                    document.getElementById('cargarEmpleadoBtn').click();
                    // Elimina el ID del empleado seleccionado del almacenamiento local para evitar que se cargue automáticamente en futuras visitas a la página
                    localStorage.removeItem('empleadoSeleccionado');
                }
            });
            document.getElementById('cargarEmpleadoBtn').addEventListener('click', function() {
                var empleadoId = document.getElementById('empleado_historia')
                    .value;
                // Para mostrar el enlace después de actualizar el href

                // Obtener el ID del empleado seleccionado
                if (empleadoId !== '') {


                    document.getElementById('card-info').style.display = 'initial';
                    // Enviar una solicitud al servidor para obtener los datos del empleado seleccionado
                    fetch(`{{ env('API_BASE_URL') }}/Berhlan/public/panel/archivo/historias/${empleadoId}`)
                        .then(response => response.json())
                        .then(data => {
                           /*  // Actualizar el contenido del div con los datos del empleado
                            if (data.DatosCountTipoDoc == data.countDoc) {
                                document.getElementById('btn_adjuntar').disabled = true;
                            } */

                            if (data.countDoc > 0) {
                                document.getElementById('btn_descargar').style.display = 'initial';
                            }

                            document.getElementById('infoEmpleado').innerHTML = `
                                CC. ${data.empleado[0].identificacion} | ${data.empleado[0].nombre}<br>
                                ${data.empleado[0].area} | ${data.empleado[0].cargo} | ${data.empleado[0].centro}
                            `;
                            // Actualizar la tabla de documentos
                            fetch(
                                    `{{ env('API_BASE_URL') }}/Berhlan/public/panel/archivo/historias/docs/${empleadoId}`
                                )
                                .then(response => response.json())
                                .then(documentos => {
                                    var tablaDocumentos = document.getElementById('tablaDocumentos');
                                    tablaDocumentos.innerHTML =
                                        '';
                                    var i = 1; // Limpiar la tabla antes de agregar nuevos datos
                                    documentos.forEach(doc => {
                                        console.log(doc);
                                        tablaDocumentos.innerHTML += `
                                    <tr class="message-unread">
                                        <td style="text-align:right;">
                                            <font color="#2A2F43">${i}</font>
                                        </td>
                                        <td style="text-align:center;">
                                            <font color="#2A2F43"><b>${doc.tipodoc}</b></font>
                                        </td>
                                        <td style="text-align:center;">
                                            <font color="#2A2F43"><b>Modulo:${doc.modulo}\n <br>Estrepaño:${doc.estrepano}\n N°Caja:${doc.ncaja}</b></font>
                                        </td>
                                        <td style="text-align:center;">
                                            <font color="#2A2F43">${doc.nombre}</font>
                                            <br>
                                            <font color="#2A2F43">${doc.fechacrea}</font>
                                        </td>
                                        <td style="text-align:center;">
                                            <font color="#2A2F43">${doc.nombre2}</font>
                                            <br>
                                            <font color="#2A2F43">${doc.fechactu}</font>
                                        </td>
                                        <td style="text-align:center;width: 186px ">
                                            <button type="button" class="btn btn-secondary" data-id="${doc.id}"  id="documento" data-toggle="modal" data-target="#EditArchivo" onclick="setDocumentoId(${doc.id});copiarEmpleado2();"
                                            title="Editar">
                                                <img src="{{ $server }}/images/edit-file.png" >
                                                </img>
                                            </button>
                                            <button type="button" class="btn btn-secondary"  data-id="${doc.id}"
                                            onclick="descargarArchivo('{{ $server }}/archivos/ArchivoDigital/Historias/${data.empleado[0].identificacion}/${doc.documento}')"

                                                                    title="Descargar">
                                                <img src="{{ $server }}/images/dow-file.png">
                                                </img>
                                            </button>
                                            <button type="button" class="btn btn-secondary"  data-id="${doc.id}"
                                            onclick="window.open('{{ $server }}/archivos/ArchivoDigital/Historias/${data.empleado[0].identificacion}/${doc.documento}','_blank')"

                                                                    title="Ver">
                                                <img src="{{ $server }}/images/view-file.png">
                                                </img>
                                            </button>
                                        </td>
                                    </tr>
                                `;
                                        i++;
                                    });
                                })
                                .catch(error => console.error('Error:', error));
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        </script>
    </body>

    </html>
@endforeach
