<?php
$server = '/Berhlan/public';

use App\Models\Procesos\PanelPerfiles;
use App\Models\Procesos\PanelTiposDocumentos;
use App\Models\Procesos\PanelSubProceDocu;
use App\Models\Parametrizacion\PanelEmpleados;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Procesos | Documentos
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

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/allcp/forms/css/forms.min.css">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="<?= $server ?>/panelfiles/assets/img/favicon.ico">

        {{-- Importar styles y funcionamiento del Select2 --}}
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">


        <script type="text/javascript" src="<?= $server ?>/panelfiles/select2/dist/js/select2.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/select2/dist/css/select2.min.css">

        <!-- -------------- DataTables -------------- -->
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.0/css/fixedColumns.dataTables.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/select/2.0.0/css/select.dataTables.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">

        <script src="<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.min.js"></script>

        <link rel="stylesheet" href="<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.css">

        <style>
            tfoot input {
                width: 100%;
            }
        </style>
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
                                <a href="<?= $server ?>/panel/menu/6" title="Procesos internos">
                                    <font color="#34495e">
                                        Procesos internos > Documentos
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <button class="btn btn-primary btn-sm ml10" name="cotizacion2" data-toggle="modal"
                            data-target="#consultasxusuario">
                            <img src="{{ $server }}/images/compartir.png" alt="">
                            <span>Compartir</span>
                        </button>
                        <a href="<?= $server ?>/panel/procesos/documentos/agregar" class="btn btn-primary btn-sm ml10"
                            title="Nuevo documento">
                            <span class="fa fa-plus pr5"></span>
                            <span class="fa fa-credit-card pr5"></span>
                        </a>

                        <a href="<?= $server ?>/panel/menu/6" class="btn btn-primary btn-sm ml10"
                            title="Procesos internos">
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
                            <div class="table-responsive">
                                <table class="table allcp-form theme-warning br-t">
                                    <thead>
                                        <tr style="background-color:#39405a">
                                            <th>
                                                <font color="white">
                                                    Documentos
                                                </font>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tr>
                                        <td>
                                            <table id="message-table" class="table allcp-form theme-warning br-t "
                                                style="width:100%">
                                                <thead>
                                                    <tr style="background-color: #F8F8F8" data-id-documento="{{ json_encode($DatosDocumentos->pluck('id_documento')->toArray()) }}">
                                                        <th style="text-align: left">
                                                            #
                                                        </th>
                                                        <th style="text-align: center">
                                                            Archivo
                                                        </th>
                                                        <th style="text-align: left">
                                                            Nombre
                                                        </th>
                                                        <th style="text-align: center">
                                                            Grupo
                                                        </th>
                                                        <th style="text-align: center">
                                                            Fecha
                                                        </th>
                                                        <th style="text-align:center;">
                                                            Perfiles con acceso
                                                        </th>
                                                        <th style="text-align:center;">
                                                            Subprocesos asociados
                                                        </th>
                                                        <th style="text-align: center">
                                                            Modificar
                                                        </th>
                                                        <th style="text-align: center">
                                                            Eliminar
                                                        </th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php $u = 1; ?>
                                                    @foreach ($DatosDocumentos as $DatDoc)
                                                        <tr class="message-unread"
                                                            data-id-documento="{{ $DatDoc->id_documento }}">
                                                            <td style="text-align: left ">
                                                                <font color="#2A2F43">
                                                                    <?php
                                                                    print $u;
                                                                    $u++;
                                                                    ?>
                                                                </font>
                                                            </td>

                                                            <td align="center">
                                                                <?php
                                                                $nombrearc = $DatDoc->ruta1;
                                                                $ext = explode('.', $nombrearc);
                                                                $ext1 = end($ext);

                                                                if ($ext1 == 'xlsx' || $ext1 == 'xls' || $ext1 == 'XLSX' || $ext1 == 'XLS' || $ext1 == 'xlsm' || $ext1 == 'XLSM') {
                                                                    $fonicono = '1d7542';
                                                                    $icono = 'fa-file-excel-o';
                                                                } elseif ($ext1 == 'docx' || $ext1 == 'doc' || $ext1 == 'DOCX' || $ext1 == 'DOC') {
                                                                    $fonicono = '226dbd';
                                                                    $icono = 'fa-file-word-o';
                                                                } elseif ($ext1 == 'pdf' || $ext1 == 'PDF') {
                                                                    $fonicono = 'b90202';
                                                                    $icono = 'fa-file-pdf-o';
                                                                } elseif ($ext1 == 'pptx' || $ext1 == 'ppt' || $ext1 == 'PPTX' || $ext1 == 'PPT') {
                                                                    $fonicono = 'ff4e22';
                                                                    $icono = 'fa-file-powerpoint-o';
                                                                } elseif ($ext1 == 'jpg' || $ext1 == 'png' || $ext1 == 'gif' || $ext1 == 'JPG' || $ext1 == 'PNG' || $ext1 == 'GIF') {
                                                                    $fonicono = 'f4d03f';
                                                                    $icono = 'fa-file-image-o';
                                                                } else {
                                                                    $fonicono = '000000';
                                                                    $icono = 'fa-file-archive-o';
                                                                }
                                                                ?>

                                                                <button type="button" style="background:transparent;"
                                                                    class="btn btn-default light"
                                                                    onclick="window.open('<?= $server ?>/archivos/Procesos/Documentos/<?= $DatDoc->ruta1 . '?' . date('i:s') ?>','_blank')"
                                                                    title="<?= $DatDoc->ruta1 ?>">
                                                                    <i class="fa <?= $icono ?> fa-lg"
                                                                        style="color:#<?= $fonicono ?>;"></i>
                                                                </button>
                                                            </td>

                                                            <td>
                                                                <b>
                                                                    <?= $DatDoc->descripcion ?>
                                                                </b>
                                                            </td>

                                                            <td style="text-align:center">
                                                                <?php
                                                                $DatoTipo = PanelTiposDocumentos::getTipo($DatDoc->tipo);
                                                                ?>
                                                                <?= $DatoTipo[0]->descripcion ?>
                                                            </td>

                                                            <td style="text-align:center">
                                                                <font size="1">
                                                                    <?= $DatDoc->fecha1 ?>
                                                                </font>
                                                            </td>
                                                            <td>

                                                                @php
                                                                    $DatosPerfiles = PanelPerfiles::getDocumentosPerfil($DatDoc->id_documento);
                                                                @endphp

                                                                @foreach ($DatosPerfiles as $DatPer)
                                                                   <font color="blue">(<?= $DatPer->descripcion ?>)</font>
                                                                @endforeach
                                                                @php
                                                                    $DatosUsuario = PanelPerfiles::getDocumentosUsuario($DatDoc->id_documento);
                                                                @endphp

                                                                @foreach ($DatosUsuario as $DatUsr)
                                                                    @php
                                                                        $Empleado = PanelEmpleados::getEmpleado($DatUsr->empleado);
                                                                    @endphp

                                                                   <font color="red">(<?= $Empleado[0]->primer_nombre . ' ' . $Empleado[0]->primer_apellido ?>)</font>
                                                                @endforeach

                                                            </td>

                                                            <td style="text-align:justify">
                                                                <?php
                                                                $SubProcesos = PanelSubProceDocu::getSubProDocumen($DatDoc->id_documento);
                                                                ?>
                                                                @foreach ($SubProcesos as $DatSub)
                                                                    <?= $DatSub->descripcion ?>
                                                                    &nbsp;||&nbsp;
                                                                @endforeach
                                                            </td>

                                                            <td style="text-align: center">
                                                                <button type="button" style="background:transparent;"
                                                                    class="btn btn-default light"
                                                                    onclick="window.location.href='<?= $server ?>/panel/procesos/documentos/modificar/<?= $DatDoc->id_documento ?>'"
                                                                    title="Modificar documento">
                                                                    <i class="fa fa-pencil fa-lg"
                                                                        style="color:#AEBF25;"></i>
                                                                </button>
                                                            </td>

                                                            <td style="text-align: center">
                                                                <button type="button" style="background:transparent;"
                                                                    class="btn btn-default light"
                                                                    onclick="BORRAR('<?= $DatDoc->id_documento ?>', '<?= $DatDoc->descripcion ?>')"
                                                                    title="Eliminar documento">
                                                                    <i class="fa fa-trash fa-lg"
                                                                        style="color:#F6565A;"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </table>

                                {!! Form::open([
                                    'action' => 'Procesos\DocProcesosPanelController@DocumentosEliminarDB',
                                    'class' => 'form',
                                    'id' => 'form-wizard',
                                    'name' => 'frmenvio',
                                ]) !!}
                                {!! Form::hidden('login', $DatLog->login) !!}
                                {!! Form::hidden('id_documento', '') !!}
                                {!! Form::close() !!}

                                <script language="javascript" type="text/javascript">
                                    function BORRAR(doc, nom) {
                                        var id = doc;
                                        var id1 = nom;

                                        if (!(confirm("Confirme el borrado del documento (" + id1 + ").")))
                                            return false;

                                        frm = document.forms["frmenvio"];
                                        frm.id_documento.value = id;
                                        document.frmenvio.submit();
                                    }
                                </script>
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
        {{-- <script src="<?= $server ?>/panelfiles/assets/js/jquery/jquery-1.11.3.min.js"></script>
        <script src="<?= $server ?>/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js"></script> --}}

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

        <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/fixedcolumns/5.0.0/js/dataTables.fixedColumns.js"></script>
        <script src="https://cdn.datatables.net/fixedcolumns/5.0.0/js/fixedColumns.dataTables.js"></script>
        <script src="https://cdn.datatables.net/select/2.0.0/js/dataTables.select.js"></script>
        <script src="https://cdn.datatables.net/select/2.0.0/js/select.dataTables.js"></script>

        @include('procesos.modales.modal-asociarUsrPerfDocu')

        <script>
            var valoresCheck = [];
            var table = $("#message-table").DataTable({
                columnDefs: [{
                    orderable: false,
                    render: DataTable.render.select(),
                    targets: 0
                }],
                paging: true,
                //scrollCollapse: true,
                //scrollX: true,
               // scrollY: 800,
                /* select: {
                    style: 'multi',
                    //selector: 'td:first-child'
                } */
            });

            $('#message-table').on('change', 'input[type="checkbox"]', function() {
                var checkbox = $(this);
                var isChecked = checkbox.prop('checked');
                var row = checkbox.closest('tr');
                var idDocumento = row.data('id-documento');

                if (isChecked) {
                    if (Array.isArray(idDocumento)) {
                        valoresCheck.push(...idDocumento);
                    } else {
                        if (!valoresCheck.includes(idDocumento)) {
                            valoresCheck.push(idDocumento);
                        }
                    }
                } else {
                    if (Array.isArray(idDocumento)) {
                        valoresCheck = valoresCheck.filter(item => !idDocumento.includes(item));
                    } else {
                        let index = valoresCheck.indexOf(idDocumento);
                        if (index !== -1) {
                            valoresCheck.splice(index, 1);
                        }
                    }
                }

            });

            function Asociarperfilusuario() {
                console.log(valoresCheck);
                var perfiles = $('#perfil').val();
                var usuarios = $('#usuario').val();

                // Actualizar el valor del campo oculto de documentos
                $('#documentos').val(valoresCheck);

                // Enviar el formulario
                $('form').submit();
            }
        </script>

        <!-- -------------- /Scripts -------------- -->
    </body>
    </html>
@endforeach
