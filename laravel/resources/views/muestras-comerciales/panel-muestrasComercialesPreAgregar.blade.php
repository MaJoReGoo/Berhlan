<?php
$server = '/Berhlan/public';
$FechaHoy = date('Y-m-d');
?>

@foreach($DatosUsuario as $DatLog)
<!DOCTYPE html>
<html>

<head>
    <!-- -------------- Meta and Title -------------- -->
    <meta charset="utf-8">
    <title>
        Intranet | Agregar Muestras Comerciales
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
                            <a href="<?= $server ?>/noticias/noticias" title="Muestras Comerciales">
                                <font color="#34495e">
                                    Muestras Comerciales >
                                </font>
                                <font color="#b4c056">
                                    Agregar
                                </font>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                    <a href="javascript:history.back()" class="btn btn-primary btn-sm ml10" title="Procesos internos > Documentos">
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
                            <div class="table-responsive">
                                <table id="message-table" class="table allcp-form theme-warning br-t">
                                    <thead>
                                        <tr style="background-color:#67d3e0">
                                            <th style="color:black; text-align:left;">
                                                Ingrese la Marca para solicitar las Muestras Comerciales
                                            </th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="allcp-form">
                                                    {!! Form::open(array('action' => 'MuestrasComerciales\MuestrasComercialesPanelController@showMuestrasComercialesAgregar', 'class' => 'form', 'id'=>'form-wizard', 'files' => true)) !!}
                                                    {!! Form::hidden('login', $DatLog->login) !!}

                                                    <div class="section">
                                                        <div class="col-md-4 form-group">
                                                            <label style="color: #0BACBF">Seleccione la Marca de la Solicitud</label>
                                                            <label class="field select">
                                                                <select name="marca" id="marca" required>
                                                                    <option value="">Seleccione</option>
                                                                    <option value="BERHLAN">BERHLAN</option>
                                                                    <option value="AMATIC">AMATIC</option>
                                                                    <option value="BONDI">BONDI</option>
                                                                    <option value="SUPER B">SUPER B</option>
                                                                    <option value="MAQUILA">MAQUILA</option>
                                                                </select>
                                                                <i class="arrow"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <br /><br />
                                                        {!! Form::submit('Seleccionar Marca', array('class'=>'btn btn-primary')) !!}
                                                    </div>
                                                </div>

                                                {!! Form::close() !!}
                            </div>
                            </td>
                            </tr>
                            </tbody>
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

    <!-- -------------- /Scripts -------------- -->

    <script type="text/javascript">
        $("#clone").click(function() {
            $(".cloned-row:first").clone().insertAfter(".cloned-row:last");
        });

        $("#remove").click(function() {
            $(".cloned-row:last").remove(".cloned-row:last");
        });
    </script>
</body>

</html>
@endforeach