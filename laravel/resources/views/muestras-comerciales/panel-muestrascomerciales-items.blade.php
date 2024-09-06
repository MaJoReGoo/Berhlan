<?php
$server = '/Berhlan/public';

use App\Models\Requerimientos\PanelGrupos;
use App\Models\Requerimientos\PanelSolicitudes;
use App\Models\Requerimientos\PanelCategorias;
use App\Models\Requerimientos\PanelPriorizaciones;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Parametrizacion\PanelCargos;
?>

@foreach($DatosUsuario as $DatLog)
<!DOCTYPE html>
@include("includes-panel/C_util")
<?php
$O_Util = new Util();
?>
<html>

<head>
    <!-- -------------- Meta and Title -------------- -->
    <meta charset="utf-8">
    <title>
        Intranet | Muestras Comerciales
    </title>
    <meta name="keywords" content="panel, cms, usuarios, servicio" />
    <meta name="description" content="Intranet para grupo Berhlan">
    <meta name="author" content="USUARIO">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- -------------- Fonts -------------- -->
    <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

    <!-- -------------- CSS - theme -------------- -->
    <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/skin/default_skin/css/theme.css">

    <!-- -------------- CSS - allcp forms -------------- -->
    <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/allcp/forms/css/forms.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/allcp/forms/css/forms.css">

    <!-- -------------- Plugins -------------- -->
    <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

    <!-- -------------- Favicon -------------- -->
    <link rel="shortcut icon" href="<?= $server ?>/panelfiles/assets/img/favicon.ico">

    <!-- Editor -->
    <script type="text/javascript" src="<?= $server ?>/panelfiles/ckeditor/ckeditor.js"></script>

    <style type="text/css">
        .alerta {
            text-align: center;
            font-size: 1.2em;
            color: #fff;
            letter-spacing: -7px;
            font-weight: 700;
            text-transform: uppercase;
            animation: blur .75s ease-out infinite;
            text-shadow: 0px 0px 5px #fff,
                0px 0px 7px #fff;
        }

        @keyframes blur {
            from {
                text-shadow: 0px 0px 8px #fff,
                    0px 0px 10px #f1f412,
                    0px 0px 25px #f1f412,
                    0px 0px 25px #f1f412,
                    0px 0px 25px #f1f412,
                    0px 0px 25px #f1f412,
                    0px 0px 25px #f1f412,
                    0px 0px 25px #f1f412,
                    0px 0px 50px #f1f412,
                    0px 0px 50px #f1f412,
                    0px 0px 50px #7B96B8;
            }
        }

        .my-button {
            padding: 10px 20px;
            background-color: #E47A2E;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .my-button:hover {
            background-color: #c15f19;
            color: #ffffff;
        }

        .my-button:active {
            background-color: #E47A2E;
            color: #ffffff;
        }
    </style>
    <script language="JavaScript">
        //<!--

        function infoEmpleado(texto) {
            Swal.fire({
                icon: 'info',
                title: "<i>Información Empleado Asignado</i>",
                html: texto,
                confirmButtonText: "Cerrar!",
            });
        }

        function infoSolicitud(texto) {
            Swal.fire({
                icon: 'info',
                title: "<i>Información de Solicitud</i>",
                html: texto,
                confirmButtonText: "Cerrar!",
            });
        }

        function infoImagen(imagen) {
            Swal.fire({
                title: "Sweet!",
                text: "Modal with a custom image.",
                imageUrl: imagen,
                imageWidth: 800,
                imageHeight: 600,
                imageAlt: "Custom image"
            });
        }
        //-->
    </script>

    <!-- Ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

    <script language="JavaScript">
        function MostrarDiv(valor) {
            if (valor.value != 0) {
                $('#notificaciones').html('<div class="col-md-6">' +
                    '<br>' +
                    '<label style="color: #34495e">' +
                    '<b>' +
                    'Información de Notificación' +
                    '</b>' +
                    '</label>' +
                    '<label class="field">' +
                    '<label style="color: #444444">' +
                    'Email' +
                    '</label>' +
                    '<label class="field prepend-icon">' +
                    '{!! Form::email("email_notificacion", null, array("required","id"=>"email_notificacion", "class"=>"gui-input","placeholder"=>" * Email")) !!}' +
                    '<label for="username" class="field-icon">' +
                    '<i class="fa fa-envelope"></i>' +
                    '</label>' +
                    '</label>' +
                    '</label>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<br><br><br>' +
                    '<label class="fieldt">' +
                    '<label style="color: #444444">' +
                    'Celular (WhatsApp)' +
                    '</label>' +
                    '<label class="field prepend-icon">' +
                    '{!! Form::text("cel_notificacion", null, array("required", "id"=>"cel_notificacion", "class"=>"gui-input", "placeholder"=>"* Celular (WhatsApp)")) !!}' +
                    '<label for="username" class="field-icon">' +
                    '<i class="fa fa-phone"></i>' +
                    '</label>' +
                    '</label>' +
                    '</label>' +
                    '</div>');
            } else {
                $('#notificaciones').html('{!! Form::hidden("email_notificacion", null, array("id"=>"email_notificacion", "class"=>"gui-input","placeholder"=>" * Email")) !!}' +
                    '{!! Form::hidden("cel_notificacion", null, array("id"=>"cel_notificacion", "class"=>"gui-input", "placeholder"=>"* Celular (WhatsApp)")) !!}');
            }

        }
    </script>
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
                            <a href="<?= $server ?>/panel/menu/4" title="Requerimientos">
                                <font color="#34495e">
                                    Muestras Comerciales >
                                </font>
                                <font color="#b4c056">
                                    Lista de Muestras Comerciales
                                </font>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                    <a href="<?= $server ?>/panel/menu/4" class="btn btn-primary btn-sm ml10" title="Requerimientos">
                        REGRESAR &nbsp;
                        <span class="fa fa-arrow-left"></span>
                    </a>
                    <a class="btn btn-primary btn-sm ml10" name="cotizacion2" href="<?= $server ?>/panel/muestrascomerciales/agregar" title="Muestras Comerciales">
                        <span class="fa fa-plus pr5"></span>
                        <span class="fa fa-file pr5"></span>
                    </a>
                </div>
            </header>
            <!-- -------------- /Topbar -------------- -->

            <!-- -------------- Content -------------- -->
            <section id="content" class="table-layout animated fadeIn">
                <div class="chute chute-center pt30">
                    <!-- -------------- Column Center -------------- -->
                    <div class="panel m3">
                        <!-- -------------- Message Body -------------- -->
                        <div class="nano-content">
                            <div class="table-responsive">
                                <table id="message-table" class="table allcp-form theme-warning br-t">
                                    <thead>
                                        <tr style="background-color:#2B547E; color: #ffffff">
                                            <th>
                                                Muestras Comerciales
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                            </th>
                                        </tr>
                                    </thead>

                                    <tr>
                                        <td colspan="2">
                                            <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                <thead>
                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Consecutivo
                                                        </th>
                                                        <th style="text-align:right">
                                                            Fecha
                                                        </th>
                                                        <th style="text-align: center">
                                                            Cliente
                                                        </th>
                                                        <th style="text-align: center">
                                                            Motivo
                                                        </th>
                                                        <th style="text-align: center">
                                                            Marca
                                                        </th>
                                                        <th style="text-align: center">
                                                            Maquila
                                                        </th>
                                                        <th style="text-align: center">
                                                            Descripción
                                                        </th>
                                                        <th style="text-align: center">
                                                            Ciudad
                                                        </th>
                                                        <th style="text-align:center">
                                                            Modificar
                                                        </th>
                                                        <th style="text-align:center">
                                                            Eliminar
                                                        </th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php $ModalId = 0; ?>
                                                    @foreach($DatosMuestrasComerciales as $DataMC)
                                                    <tr class="message-unread">
                                                        <td style="text-align:center">
                                                            <font color="#2A2F43">
                                                                <?= $DataMC->consecutivo; ?>
                                                            </font>
                                                        </td>
                                                        <td style="text-align:center">
                                                            <font color="#2A2F43">
                                                                <?= $DataMC->consecutivo; ?>
                                                            </font>
                                                        </td>
                                                        <td style="text-align:center">
                                                            <font color="#2A2F43">
                                                                <?= $DataMC->nombre_cliente; ?>
                                                            </font>
                                                        </td>
                                                        <td style="text-align:center">
                                                            <font color="#2A2F43">
                                                                <?= $DataMC->motivo; ?>
                                                            </font>
                                                        </td>
                                                        <td style="text-align:center">
                                                            <font color="#2A2F43">

                                                            </font>
                                                        </td>
                                                        <td style="text-align:center">
                                                            <font color="#2A2F43">

                                                            </font>
                                                        </td>
                                                        <td style="text-align:center;" width="100">
                                                            <div style="height:100px; width:100%; overflow:auto;">
                                                                <br />
                                                                <button type="button" class="btn btn-default light" data-toggle="modal" data-target="#myModal<?= $ModalId ?>"><i class="fa fa-edit fa-2x" style="color: #4682b4"></i>&nbsp;</button>
                                                                <br />
                                                                <font color="#2A2F43">Ver + </font>
                                                            </div>
                                                        </td>
                                                        <td style="text-align:center">
                                                            <font color="#2A2F43">

                                                            </font>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <button type="button" class="btn btn-default light" onclick="window.location.href='<?= $server ?>/panel/procesos/perfiles/modificar/<?= $DatPer->id_perfil ?>'" title="Modificar documento">
                                                                <i class="fa fa-pencil fa-lg" style="color:#AEBF25;"></i>
                                                            </button>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <button type="button" class="btn btn-default light" onclick="BORRAR('<?= $DatPer->id_perfil ?>', '<?= $DatPer->descripcion ?>')" title="Eliminar perfil">
                                                                <i class="fa fa-trash fa-lg" style="color:#F6565A;"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <?php $ModalId++; ?>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
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
    <script src="<?= $server ?>/panelfiles/assets/js/pages/allcp_forms-elements.js"></script>
    <script src="<?= $server ?>/panelfiles/assets/js/demo/widgets_sidebar.js"></script>

    <!-- -------------- Page JS -------------- -->
    <script src="<?= $server ?>/panelfiles/assets/js/demo/charts/highcharts.js"></script>

    <!-- -------------- DataTables -------------- -->
    <!--  <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

    <!-- -------------- /Scripts -------------- -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <?php $ModalId = 0; ?>
    @foreach($DatosMuestrasComerciales as $DataMC)
    <?php
    $Solicitud = $DataMC->observaciones;
    ?>
    <!-- Modal -->
    <div class="modal fade" id="myModal<?= $ModalId ?>" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Descripción</h4>
                </div>
                <div class="modal-body">
                    <p><?= $Solicitud ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar!!</button>
                </div>
            </div>

        </div>
    </div>
    <?php
    $ModalId++;
    ?>
    @endforeach
</body>

</html>
@endforeach