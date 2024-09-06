<?php
$server = '/Berhlan/public';
$server_api = env('APP_URL_API');
$url = explode('/', $_SERVER['REQUEST_URI']);
$tamUrl = sizeof($url);
$estado = $url[$tamUrl - 1];

use App\Models\ArchivoPlano\PanelArchivoPlano;
?>

@foreach ($DatosUsuario as $DatLog)
<!DOCTYPE html>
<html>

<head>
    <!-- -------------- Meta and Title -------------- -->
    <meta charset="utf-8">
    <title>
        Intranet | Archivo Plano
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


    <script language="JavaScript">
        $(document).ready(function() {
            $(document).on('click keyup', '.mis-checkboxes,.mis-adicionales', function() {
                calcular();
            });
        });

        function calcular() {
            var tot = $('#total');
            tot.val(0);
            $('.mis-checkboxes,.mis-adicionales').each(function() {
                if ($(this).hasClass('mis-checkboxes')) {
                    tot.val(($(this).is(':checked') ? parseFloat($(this).attr('tu-attr-precio')) : 0) + parseFloat(tot.val()));
                } else {
                    tot.val(parseFloat(tot.val()) + (isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val())));
                }
            });
            var totalParts = parseFloat(tot.val()).toFixed(2).split('.');
            tot.val(' $' + totalParts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".") + '.' + (totalParts.length > 1 ? totalParts[1] : '00'));
        }

        function cambiar_archivos() {
            var myElement = document.getElementById('estado');
            var tipoArc = myElement.value;
            location = 'https://192.168.1.210<?= $server ?>/panel/archivo-plano/lista/' + tipoArc;
        }

        function toggle(source) {
            checkboxes = document.getElementsByName('idexparc[]');

            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
            calcular();
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

                </div>

                <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                    <a href="javascript:history.back()" class="btn btn-primary btn-sm ml10" title="Inicio">
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
                            <form name="noticias" method="get" class="panel-menu allcp-form  mtn d-flx">
                                <div class="row">
                                    <h5 class="col-md-2" style="padding-top: 20px">Listar Por Estado: &nbsp;</h5>
                                    <div class="col-md-3">
                                        <label class="field select">
                                            <select name="estado" id="estado" onChange='cambiar_archivos()' class="empty">
                                                <option value="">Select...</option>
                                                <option value="1">Exportados</option>
                                                <option value="2">Sin Exportar</option>
                                                <option value="0">Todos</option>

                                            </select>
                                            <i class="arrow"></i>
                                        </label>
                                    </div>
                                </div>
                            </form>
                            <br />
                            <div class="table-responsive">
                                <table id="message-table" class="table allcp-form theme-warning br-t">
                                    <thead>
                                        <tr style="background-color:#39405a">
                                            <th>
                                                Lista Documentos Archivos Planos
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <button class="btn btn-primary" type="button" onclick="window.location.href='<?= $server ?>/panel/archivo-plano/agregar'">Agregar Archivo</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>


                                <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                    <thead>
                                        <tr style="background-color: #F8F8F8">
                                            <th style="text-align: center"><i class="fa fa-file fa-lg" style="color: #39405a;"></i></th>
                                            <th style="text-align: center;">
                                                <font color="#444444"> Consecutivo </font>
                                            </th>
                                            <th style="text-align: left">
                                                <font color="#444444"> Fecha</font>
                                            </th>
                                            <th style="text-align: left">
                                                <font color="#444444"> Of. Origen</font>
                                            </th>
                                            <th style="text-align: left">
                                                <font color="#444444"> Of. Destino</font>
                                            </th>
                                            <th style="text-align: left">
                                                <font color="#444444">Demandado</font>
                                            </th>
                                            <th style="text-align: left">
                                                <font color="#444444"> No. Proceso</font>
                                            </th>
                                            <th style="text-align: left">
                                                <font color="#444444"> Valor Depósito</font>
                                            </th>
                                            <th style="text-align: left">
                                                <font color="#444444"> Duplicar</font>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($DatosArchivos as $dataArchivos)
                                        <?php
                                        if ($dataArchivos->estado == 1) {
                                            $Disabled = 'disabled';
                                            $Checked = 'checked';
                                            $class = '';
                                            $tuattrprecio = "tu-attr-precio=''";
                                        } else {
                                            $Disabled = '';
                                            $Checked = '';
                                            $class = 'class="mis-checkboxes"';
                                            $tuattrprecio = "tu-attr-precio='$dataArchivos->valor_deposito'";
                                        }
                                        ?>
                                        {!! Form::open(array('action' => 'ArchivoPlano\ArchivoPlanoPanelController@GenerarArchivo', 'class' => 'form', 'id'=>'form-wizard')) !!}
                                        <tr>
                                            <td style="text-align: left">
                                                <label class="option block">
                                                    <input name="idexparc[]" type="checkbox" value="<?= $dataArchivos->id ?>" <?= $Disabled ?> <?= $Checked ?> <?= $class ?> <?= $tuattrprecio ?>>
                                                    <span class="checkbox"></span>
                                                </label>
                                            </td>
                                            <td style="text-align: center;">
                                                <font color="#444444"> {{ $dataArchivos->consecutivo }}</font>
                                            </td>
                                            <td style="text-align: left;">
                                                <font color="#444444"> {{ $dataArchivos->fecha_cargue }}</font>
                                            </td>
                                            <td style="text-align: left;">
                                                <font color="#444444"> {{ $dataArchivos->oficina_origen }}</font>
                                            </td>
                                            <td style="text-align: left;">
                                                <font color="#444444"> {{ $dataArchivos->oficina_destino }}</font>
                                            </td>

                                            <td style="text-align: left;">
                                                <font color="#444444"> {{ $dataArchivos->nombre_demandado.' '.$dataArchivos->apellido_demandado }}</font>
                                            </td>

                                            <td style="text-align: left;">
                                                <font color="#444444"> {{ $dataArchivos->numero_proceso }}</font>
                                            </td>
                                            <td style="text-align: left;">
                                                <font color="#444444"> {{ $dataArchivos->valor_deposito}}</font>
                                            </td>
                                            <td style="text-align: left;">
                                                <?php if ($estado != 2) { ?>
                                                    <a class="btn btn-primary" href="<?= $server ?>/panel/archivo-plano/duplicar/<?= $dataArchivos->id ?>" title="Duplicar información">Duplicar</a>
                                                <?php } else { ?>
                                                    <a class="btn btn-primary" title="Duplicar información" style="background-color: #444444;">Duplicar</a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br />
                                <table>
                                    <?php if ($estado == 2) { ?>
                                        <tr>
                                            <td>
                                                <label class="option block">
                                                    &nbsp;&nbsp;&nbsp;<input type="checkbox" onClick="toggle(this)" style="padding-left: 15px;" /> Seleccionar/Deseleccionar todos<br /><br />
                                                </label>
                                            </td>
                                            <td colspan="7"></td>
                                        </tr>
                                    <?php } ?>

                                    <tr>
                                        <?php
                                        $CantArchExp = PanelArchivoPlano::getCantArchivoPlanoExp();

                                        if ($CantArchExp != 0 && $estado != 1) { ?>
                                            <td style="padding: 10px 10px 10px 10px;">{!! Form::submit('Exportar Archivo', array('class'=>'btn btn-primary')) !!}</td>
                                            <td colspan="7"></td>
                                        <?php } else { ?>
                                            <td style="padding: 10px 10px 10px 10px;">{!! Form::submit('Exportar Archivo', array('class'=>'btn btn-primary', 'disabled'=>'disabled')) !!}</td>
                                            <td colspan="7"></td>
                                        <?php } ?>
                                    </tr>
                                </table>
                                <br />
                                {!! Form::close() !!}

                                <label><strong>Total Calculado: </strong><label>
                                        <div>
                                            <input id="total" type="text" placeholder="0.00" />
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

    <!-- -------------- /Scripts -------------- -->
</body>

</html>
@endforeach