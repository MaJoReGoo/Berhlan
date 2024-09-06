<?php
$server = '/Berhlan/public';

use App\Models\Parametrizacion\PanelEmpleados;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Agregar usuario
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

        <!-- Editor -->
        <script type="text/javascript" src="<?= $server ?>/panelfiles/ckeditor/ckeditor.js"></script>

        <script>
            jQuery(document).ready(function($) {
                $("#empleado").select2({
                    closeOnSelect: true,

                });
            });
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
                                <a href="<?= $server ?>/panel/parametrizacion/usuarios"
                                    title="Parametrización > Usuarios">
                                    <font color="#34495e">
                                        Parametrización > Usuarios >
                                    </font>
                                    <font color="#b4c056">
                                        Agregar
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="<?= $server ?>/panel/parametrizacion/usuarios" class="btn btn-primary btn-sm ml10"
                            title="Parametrización > Usuarios">
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
                                                    Ingrese la información del nuevo usuario
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="allcp-form">
                                                        {!! Form::open([
                                                            'action' => 'Parametrizacion\UsuariosPanelController@UsuariosAgregarDB',
                                                            'class' => 'form',
                                                            'id' => 'form-wizard',
                                                            'files' => true,
                                                        ]) !!}
                                                        {!! Form::hidden('loglogin', $DatLog->login) !!}

                                                        <div class="section">
                                                            <div class="col-md-4">
                                                                <label style="color: #4ECCDB">
                                                                    Empleado
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="empleado" id="empleado" required>
                                                                        <option value="">
                                                                            Seleccione un empleado
                                                                        </option>
                                                                        <?php
                                                                        $Empleados = PanelEmpleados::getEmpleadosActivosUsuarios();
                                                                        ?>
                                                                        @foreach ($Empleados as $DatEmp)
                                                                            <option value="<?= $DatEmp->id_empleado ?>">
                                                                                <?php
                                                                                echo $DatEmp->primer_nombre;
                                                                                echo ' ';
                                                                                echo $DatEmp->ot_nombre;
                                                                                echo ' ';
                                                                                echo $DatEmp->primer_apellido;
                                                                                echo ' ';
                                                                                echo $DatEmp->ot_apellido;
                                                                                echo ' - ';
                                                                                echo $DatEmp->identificacion;
                                                                                ?>
                                                                            </option>
                                                                        @endforeach
                                                                    </select>

                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color: #4ECCDB">
                                                                    Login
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::text('login', null, [
                                                                        'required',
                                                                        'id' => 'login',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => '* Nro Documento',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-file"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color: #4ECCDB">
                                                                    Tipo Master
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="master" id="master" required>
                                                                        <option value="">
                                                                            * Tipo Master
                                                                        </option>
                                                                        <option value="0">No</option>
                                                                        <option value="1">Sí</option>
                                                                    </select>
                                                                    <i class="arrow"></i>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="section">
                                                            <div class="col-md-4">
                                                                <br>
                                                                {!! Form::submit('Ingresar usuario', ['class' => 'button']) !!}
                                                            </div>

                                                            <div class="col-md-8" style="text-align: right;">
                                                                <br><br>
                                                                <label style="color:#2A2F43">
                                                                    (La contraseña inicial, será el número de
                                                                    identificación.)
                                                                </label>
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
    </body>

    </html>
@endforeach
