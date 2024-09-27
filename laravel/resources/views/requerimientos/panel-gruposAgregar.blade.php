<?php

?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Agregar grupo
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
        <link rel="stylesheet" type="text/css"
            href="{{ asset('/panelfiles/assets/skin/default_skin/css/theme.css') }}">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/panelfiles/assets/allcp/forms/css/forms.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/panelfiles/assets/allcp/forms/css/forms.css') }}">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/panelfiles/assets/js/plugins/c3charts/c3.min.css') }}">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="{{ asset('/panelfiles/assets/img/favicon.ico') }}">

        <!-- Editor -->
        <script type="text/javascript" src="{{ asset('/panelfiles/ckeditor/ckeditor.js') }}"></script>
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
                                <a href="{{ asset('/panel/requerimientos/grupos') }}" title="Requerimientos > Grupos">
                                    <font color="#34495e">
                                        Requerimientos > Grupos >
                                    </font>
                                    <font color="#b4c056">
                                        Agregar
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset('/panel/requerimientos/grupos') }}" class="btn btn-primary btn-sm ml10"
                            title="Requerimientos > Grupos">
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
                                            <tr>
                                                <th style="background-color:#67d3e0; color:#34495e; text-align:left;">
                                                    Ingrese la información del nuevo grupo que atenderá requerimientos
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="allcp-form">
                                                        {!! Form::open([
                                                            'action' => 'Requerimientos\GruposRequerimientosPanelController@GruposAgregarDB',
                                                            'class' => 'form',
                                                            'id' => 'form-wizard',
                                                        ]) !!}
                                                        {!! Form::hidden('login', $DatLog->login) !!}
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Nombre del grupo
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::text('descripcion', null, [
                                                                        'required',
                                                                        'id' => 'descripcion',
                                                                        'class' => 'gui-input',
                                                                        'placeholder' => '* Descripción',
                                                                    ]) !!}
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-file"></i>
                                                                    </label>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Controla reintegro
                                                                    </b>
                                                                </label>
                                                                <label class="field select">
                                                                    <select name="reintegro" id="reintegro" required>
                                                                        <option value="0" style="color:red;">No
                                                                        </option>
                                                                        <option value="1" style="color:green;">Sí
                                                                        </option>
                                                                    </select>
                                                                    <i class="arrow"></i>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <br><br>
                                                                {!! Form::submit('Ingresar grupo', ['class' => 'button btn-primary']) !!}
                                                                <br><br>
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
        <script src="{{ asset('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js') }}"></script>

        <!-- -------------- JvectorMap Plugin -------------- -->
        <script src="{{ asset('/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js') }}">
        </script>

        <!-- -------------- HighCharts Plugin -------------- -->
        <script src="{{ asset('/panelfiles/assets/js/plugins/highcharts/highcharts.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/plugins/c3charts/d3.min.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/plugins/c3charts/c3.min.js') }}"></script>

        <!-- -------------- Theme Scripts -------------- -->
        <script src="{{ asset('/panelfiles/assets/js/utility/utility.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/demo/demo.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/main.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/demo/widgets_sidebar.js') }}"></script>
        <script src="{{ asset('/panelfiles/assets/js/pages/dashboard2.js') }}"></script>

        <!-- -------------- Page JS -------------- -->
        <script src="{{ asset('/panelfiles/assets/js/demo/charts/highcharts.js') }}"></script>
        <!-- -------------- /Scripts -------------- -->
    </body>

    </html>
@endforeach
