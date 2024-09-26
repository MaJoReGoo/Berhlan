<?php

use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Disciplinarios\PanelTipofaltas;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Procesos disciplinarios | Solicitud
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
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/skin/default_skin/css/theme.css')}}">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.css')}}">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css')}}">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="{{ asset ('/panelfiles/assets/img/favicon.ico')}}">

        <!-- Editor -->
        <script type="text/javascript" src="{{ asset ('/panelfiles/ckeditor/ckeditor.js')}}"></script>
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
                                <a href="{{ asset ('/panel/disciplinarios/solicitud')}}"
                                    title="Procesos disciplinarios > Buscar colaborador">
                                    <font color="#34495e">
                                        Procesos disciplinarios >
                                    </font>
                                    <font color="#b4c056">
                                        Solicitud
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset ('/panel/disciplinarios/solicitud')}}" class="btn btn-primary btn-sm ml10"
                            title="Procesos disciplinarios > Buscar colaborador">
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
                        <div class="panel m3">
                            <!-- -------------- Message Body -------------- -->
                            <div class="nano-content">
                                <div class="table-responsive">
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr style="background-color:#39405a">
                                                <th>
                                                    Colaborador
                                                </th>
                                            </tr>
                                        </thead>

                                        <tr>
                                            <td colspan="2">
                                                <table id="message-table"
                                                    class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <th style="text-align:left">
                                                                <font color="#2A2F43">
                                                                    Identificación:
                                                                </font>
                                                            </th>

                                                            <td style="text-align:left">
                                                                <font color="#2A2F43">
                                                                    <?= $DatosEmpleado[0]->identificacion ?>
                                                                </font>
                                                            </td>

                                                            <th style="text-align:left">
                                                                <font color="#2A2F43">
                                                                    Nombre:
                                                                </font>
                                                            </th>

                                                            <td style="text-align:left">
                                                                <font color="#2A2F43">
                                                                    <?php
                                                                    echo $DatosEmpleado[0]->primer_nombre;
                                                                    echo ' ';
                                                                    echo $DatosEmpleado[0]->ot_nombre;
                                                                    echo ' ';
                                                                    echo $DatosEmpleado[0]->primer_apellido;
                                                                    echo ' ';
                                                                    echo $DatosEmpleado[0]->ot_apellido;
                                                                    ?>
                                                                </font>
                                                            </td>

                                                            <th style="text-align:left">
                                                                <font color="#2A2F43">
                                                                    Cargo:
                                                                </font>
                                                            </th>

                                                            <?php
                                                            $Cargo = PanelCargos::getCargo($DatosEmpleado[0]->cargo);
                                                            ?>

                                                            <td style="text-align:left">
                                                                <font color="#2A2F43">
                                                                    @foreach ($Cargo as $DatCargo)
                                                                        <?= $DatCargo->descripcion ?>
                                                                        <br>
                                                                        <?php
                                                                        $Area = PanelAreas::getArea($DatCargo->area);
                                                                        ?>
                                                                        @foreach ($Area as $DatArea)
                                                                            <?php
                                                                            echo $DatArea->descripcion . ' - ';
                                                                            $Empresa = PanelEmpresas::getEmpresa($DatArea->empresa);
                                                                            ?>
                                                                            @foreach ($Empresa as $DatEmpresa)
                                                                                <?= $DatEmpresa->nombre ?>
                                                                            @endforeach
                                                                        @endforeach
                                                                    @endforeach
                                                                </font>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th style="text-align:left">
                                                                <font color="#2A2F43">
                                                                    Centro de operación:
                                                                </font>
                                                            </th>

                                                            <?php
                                                            $Centro = PanelCentrosOp::getCentroOp($DatosEmpleado[0]->centro_op);
                                                            ?>
                                                            <td style="text-align: left">
                                                                @foreach ($Centro as $DatCentro)
                                                                    <font color="#2A2F43">
                                                                        <?= $DatCentro->descripcion ?>
                                                                    </font>
                                                                @endforeach
                                                            </td>

                                                            <th style="text-align:left">
                                                                <font color="#2A2F43">
                                                                    Correo electrónico:
                                                                </font>
                                                            </th>

                                                            <td style="text-align:left">
                                                                <font color="#2A2F43">
                                                                    <?= $DatosEmpleado[0]->correo ?>
                                                                </font>
                                                            </td>

                                                            <th style="text-align:left">
                                                                <font color="#2A2F43">
                                                                    Teléfono:
                                                                </font>
                                                            </th>

                                                            <td style="text-align:left">
                                                                <font color="#2A2F43">
                                                                    <?= $DatosEmpleado[0]->numtel ?>
                                                                </font>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="panel m3">
                            <!-- -------------- Message Body -------------- -->
                            <div class="nano-content">
                                <div class="table-responsive">
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr>
                                                <th style="background-color:#67d3e0; color:#34495e; text-align:left;">
                                                    Solicitud proceso disciplinario
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="allcp-form">
                                                        {!! Form::open([
                                                            'action' => 'Disciplinarios\SolicitudDisciplinariosPanelController@SolicitudAgregarDB',
                                                            'class' => 'form',
                                                            'id' => 'form-wizard',
                                                        ]) !!}
                                                        {!! Form::hidden('empleado', $DatosEmpleado[0]->id_empleado) !!}
                                                        <div class="section">
                                                            <div class="col-md-12">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Tipo de falta
                                                                    </b>
                                                                </label>

                                                                <?php
                                                                $Faltas = PanelTipofaltas::TipofaltasActivas();
                                                                $u = 0;
                                                                ?>

                                                                <label class="option block">
                                                                    <div class="btn-group btn-group-toggle"
                                                                        data-toggle="buttons">
                                                                        @foreach ($Faltas as $DatFal)
                                                                            <?php
                                          $u++;
                                          if($u == 1)
                                           {
                                            ?>
                                                                            <label class="btn btn-secondary active"
                                                                                onclick="COLOR('<?= $u ?>')">
                                                                                <i class="fa fa-check-square-o fa-lg"
                                                                                    id="rad<?= $u ?>"
                                                                                    style="color:green;"></i>
                                                                                <input type="radio" name="falta"
                                                                                    value="<?= $DatFal->id_tipofalta ?>"
                                                                                    autocomplete="off" checked>
                                                                            </label>
                                                                            <?php
                                           }
                                          else
                                           {
                                            ?>
                                                                            <label class="btn btn-secondary"
                                                                                onclick="COLOR('<?= $u ?>')">
                                                                                <i class="fa fa-square-o fa-lg"
                                                                                    id="rad<?= $u ?>"
                                                                                    style="color:green;"></i>
                                                                                <input type="radio" name="falta"
                                                                                    value="<?= $DatFal->id_tipofalta ?>"
                                                                                    autocomplete="off">
                                                                            </label>
                                                                            <?php
                                           }

                                          echo "&nbsp;&nbsp;&nbsp;";
                                          echo "<b>";
                                            echo $DatFal->descripcion;
                                          echo "</b>";
                                          echo "&nbsp;&nbsp;-&nbsp;&nbsp;";
                                          echo $DatFal->detalle;
                                          ?>
                                                                            <br><br><br><br>
                                                                        @endforeach
                                                                    </div>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-7">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Causa de la solicitud
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::textarea('causa', '', [
                                                                        'required',
                                                                        'id' => 'causa',
                                                                        'class' => 'gui-input',
                                                                        'style' => 'height: 80px; resize: vertical;',
                                                                        'placeholder' => '* Detalle los hechos por los cuales se realiza la solicitud.',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-reorder"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-5">
                                                                <br><br><br><br><br><br><br>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <br>
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Fecha en que se cometió la falta
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('fecha', null, ['required', 'id' => 'fecha', 'class' => 'gui-input', 'maxlength' => '10']) !!}
                                                                </label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <br>
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Fecha conocimiento de falta
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::date('conocimiento', null, [
                                                                        'required',
                                                                        'id' => 'conocimiento',
                                                                        'class' => 'gui-input',
                                                                        'maxlength' => '10',
                                                                    ]) !!}
                                                                </label>
                                                            </div>

                                                            <div class="col-md-7">
                                                                <br>
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Testigos
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::textarea('testigos', '', [
                                                                        '',
                                                                        'id' => 'testigos',
                                                                        'class' => 'gui-input',
                                                                        'style' => 'height: 80px; resize: vertical;',
                                                                        'placeholder' => 'Ingrese los nombres de los testigos, si se tienen.',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-reorder"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-7">
                                                                <br>
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Pruebas
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::text('pruebas', null, [
                                                                        '',
                                                                        'id' => 'pruebas',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' =>
                                                                            'En caso de tener pruebas, por favor súbalas a un servicio en la nube, copie y pegue el enlace, en este campo.',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-cloud"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <br>
                                                                {!! Form::submit('Realizar solicitud', ['class' => 'button']) !!}
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

                        <script language="javascript" type="text/javascript">
                            function COLOR(id) {
                                icono = document.getElementById('rad' + id);
                                icono.className = "fa fa-check-square-o fa-lg";

                                for (r = 1; r < 50; r++) {
                                    if (r != id) {
                                        icono = document.getElementById('rad' + r);
                                        icono.className = "fa fa-square-o fa-lg";
                                    }
                                }
                            }
                        </script>
                        <!-- -------------- /Column Center -------------- -->
                    </div>
                </section>
                <!-- -------------- /Content -------------- -->
            </section>
        </div>
        <!-- -------------- /Body Wrap  -------------- -->

        <!-- -------------- Scripts -------------- -->

        <!-- -------------- jQuery -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js')}}"></script>

        <!-- -------------- JvectorMap Plugin -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js')}}"></script>

        <!-- -------------- HighCharts Plugin -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/plugins/highcharts/highcharts.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/plugins/c3charts/d3.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.js')}}"></script>

        <!-- -------------- Theme Scripts -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/utility/utility.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/demo/demo.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/main.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/pages/allcp_forms-elements.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/demo/widgets_sidebar.js')}}"></script>

        <!-- -------------- Page JS -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/demo/charts/highcharts.js')}}"></script>

        <!-- -------------- /Scripts -------------- -->
    </body>

    </html>
@endforeach
