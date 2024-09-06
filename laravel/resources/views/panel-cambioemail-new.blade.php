<?php

$server = '/Berhlan/public';

?>



@foreach($DatosUsuario as $DatLog)

<!DOCTYPE html>

<html>



<head>

    <!-- -------------- Meta and Title -------------- -->

    <meta charset="utf-8">

    <title>

        Intranet | Cambio de Email

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

                                    Cambio de Correo

                                </font>

                            </a>

                        </li>

                    </ul>

                </div>



                <div class="topbar-right hidden-xs hidden-sm mt5 mr35">

                    <!-- a href="< ?= $server ?>/panel/noticias/noticias" class="btn btn-primary btn-sm ml10" title="Inicio">

                        REGRESAR &nbsp;

                        <span class="fa fa-arrow-left"></span>

                    </a -->

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

                                                ACTUALIZACÓN DE CORREO CORPORATIVO

                                            </th>

                                        </tr>

                                    </thead>



                                    <tbody>

                                        <tr>

                                            <td>

                                                <span style="color: #000000; font-size: 16px">Debido a nuestra nueva politica de información empresarial, requerimos una actualización, ingrese su <span style="color: #bf616a"><strong>correo @berhlan.com</span> o <span style="color: #bf616a">@bpack.com.co</span></span>

                                                <br />

                                                <div class="allcp-form">

                                                    {!! Form::open(array('action' => 'HomePanelController@EmailModificarDB', 'class' => 'form', 'id'=>'form-wizard', 'name' => 'frmenvio')) !!}

                                                    {!! Form::hidden('pwd1', $pwd1) !!}

                                                    {!! Form::hidden('id_empleado', $DatLog->empleado) !!}

                                                    {!! Form::hidden('email_empresa', 0) !!}

                                                    <div class="section">

                                                        <div class="col-md-4">

                                                            <label style="color: #4ECCDB">

                                                                Nuevo Correo

                                                            </label>

                                                            <label class="field prepend-icon">

                                                                <input type="email" class="form-control border-end-0" id="pwd2" name="pwd2" placeholder="* Nuevo Correo">

                                                                <label for="username" class="field-icon">

                                                                    <i class="fa fa-key"></i>

                                                                </label>

                                                            </label>

                                                        </div>



                                                        <div class="col-md-4">

                                                            <label style="color: #4ECCDB">

                                                                Confirma Nuevo Correo

                                                            </label>

                                                            <label class="field prepend-icon">

                                                                <input type="email" class="form-control border-end-0" id="pwd3" name="pwd3" placeholder="* Confirme su Correo">

                                                                <label for="username" class="field-icon">

                                                                    <i class="fa fa-key"></i>

                                                                </label>

                                                            </label>

                                                        </div>



                                                        <div class="col-md-3">

                                                            <br><br>

                                                            {!! Form::button('Actualizar', array('class'=>'button btn-primary', 'onclick' => 'VALIDAR()')) !!}

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

                                        var id2 = frm.pwd2.value;
                                        var id3 = frm.pwd3.value;

                                        id2 = id2.toLowerCase();
                                        id3 = id3.toLowerCase();

                                        var id4 = frm.email_empresa.value;



                                        if (id4 == 1) {

                                            document.frmenvio.submit();

                                        } else {



                                            if (id2 == '' || id3 == '') {

                                                alert("Los emails no pueden ser vacíos.");

                                                frm.pwd2.focus();

                                                return false;

                                            } else {



                                                if (id2 == id3) {

                                                    var email1 = id2.split('@');

                                                    if (email1[1] == 'berhlan.com' || email1[1] == 'bpack.com.co') {

                                                        document.frmenvio.submit();

                                                    } else {

                                                        alert("Los emails ingresados deben ser de la organización.");

                                                        frm.pwd2.focus();

                                                        return false;

                                                    }

                                                } else {

                                                    alert("Los emails ingresados no coinciden.");

                                                    frm.pwd2.focus();

                                                    return false;

                                                }

                                            }

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