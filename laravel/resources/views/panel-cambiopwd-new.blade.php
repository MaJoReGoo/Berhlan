<?php
$server = '/Berhlan/public';
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Cambio de contraseña
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
                    @include('includes-panel/menuModulosEscritorio-panel-pwd')
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
                                <a href="<?= $server ?>/panel/noticias/noticias" title="Inicio">
                                    <font color="#34495e">
                                        Cambio de contraseña
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="<?= $server ?>/panel/noticias/noticias" class="btn btn-primary btn-sm ml10"
                            title="Inicio">
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
                                            <tr style="background-color:#39405a">
                                                <th>
                                                    Ingrese la información para el cambio de contraseña
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span style="color: #000000">Debido a nuestra nueva politica de
                                                        seguridad, su contraseña <span style="color: #bf616a"><strong>no
                                                                debe ser igual a su número de
                                                                identificación</strong></span>, por favor elegir una
                                                        contraseña diferente.</span>
                                                    <br><br>
                                                    <span style="color: #000000"><strong> Recuerde:</strong> </span> <br><span style="color: #bf616a"><strong> * Su usuario
                                                            para ingresar a la intranet será su cédula.
                                                        </strong></span>
                                                    <br>
                                                    <span style="color: #bf616a"><strong>* La nueva contraseña debe ser mayor a 6
                                                            digitos.</strong></span>

                                                    <br />
                                                    <div class="allcp-form">
                                                        {!! Form::open([
                                                            'action' => 'HomePanelController@PwdModificarDB',
                                                            'class' => 'form',
                                                            'id' => 'form-wizard',
                                                            'name' => 'frmenvio',
                                                        ]) !!}
                                                        {!! Form::hidden('pwd1', $pwd1) !!}
                                                        <div class="section">
                                                            <div class="col-md-4">
                                                                <label style="color: #4ECCDB">
                                                                    Nueva contraseña
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    <input type="password"
                                                                        class="form-control border-end-0" id="pwd2"
                                                                        name="pwd2" placeholder="* Nueva contraseña"
                                                                        required>
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-key"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color: #4ECCDB">
                                                                    Repite nueva contraseña
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    <input type="password"
                                                                        class="form-control border-end-0" id="pwd3"
                                                                        name="pwd3"
                                                                        placeholder="* Repite nueva contraseña"
                                                                        required>
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-key"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <br><br>
                                                                {!! Form::button('Cambiar contraseña', ['class' => 'button btn-primary', 'onclick' => 'VALIDAR()']) !!}
                                                                <br><br>
                                                            </div>
                                                        </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <script language="javascript" type="text/javascript">
                                        function VALIDAR() {
                                            frm = document.forms["frmenvio"];
                                            var pass = {{ $pwd1 }};
                                            var id2 = frm.pwd2.value;
                                            var id3 = frm.pwd3.value;

                                            if (id2.length < 6) {
                                                alert("La nueva contraseña debe tener mínimo 6 caracteres.");
                                                frm.pwd2.focus();
                                                return false;
                                            }

                                            if (id2 != id3) {
                                                alert("La nueva contraseña no coincide.");
                                                frm.pwd3.focus();
                                                return false;
                                            }

                                            if ((id2 == pass) || (id3 == pass)) {
                                                alert("La nueva contraseña no puede ser el número de identificación!");
                                                return false;
                                            }

                                            if ((id2.length > 6) && (id2 == id3) && (id2 != pass) && (id3 != pass)) {
                                                document.frmenvio.submit();
                                            }
                                        }
                                    </script>

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
