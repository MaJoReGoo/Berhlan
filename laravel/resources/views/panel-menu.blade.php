<?php

use App\Models\PanelLogin;
?>

@foreach($DatosUsuario as $DatLog)
<!DOCTYPE html>
<html>

<head>
    <!-- -------------- Meta and Title -------------- -->
    <meta charset="utf-8">
    <title>
        Intranet | Menú
    </title>

    <meta name="description" content="Intranet para grupo Berhlan">
    <meta name="author" content="USUARIO">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- -------------- Fonts -------------- -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet'
        type='text/css'>

    <!-- -------------- CSS - theme -------------- -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/panelfiles/assets/skin/default_skin/css/theme.css') }}">

    <!-- -------------- CSS - allcp forms -------------- -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/panelfiles/assets/allcp/forms/css/forms.min.css') }}">

    <!-- -------------- Plugins -------------- -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/panelfiles/assets/js/plugins/c3charts/c3.min.css') }}">

    <!-- -------------- Favicon -------------- -->
    <link rel="shortcut icon" href="{{ asset('/panelfiles/assets/img/favicon.png') }}">


    <link rel="stylesheet" type="text/css" href="{{ asset('/public/css/ticactivos/panel-menu.blade.css') }}">

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
                            <a>
                                <font color="#34495e">
                                    @foreach ($Menu as $DatMenu)
                                        <?php
                                        echo $DatMenu->nombre;
                                        $idmenu = $DatMenu->id_menu;
                                        ?>
                                    @endforeach

                                </font>
                            </a>
                        </li>
                    </ul>
                </div>
            </header>

            <div class="chute chute-center pt15">
                <!-- Módulos -->
                <div class="row">
                    <?php
                    //Si tiene todos los permisos tipo Máster
                    if ($DatLog->master == 1) {
                        $Modulo = PanelLogin::getMenuT($idmenu);
                    } else {
                        $Modulo = PanelLogin::getMenu($DatLog->modulos, $idmenu);
                    }
                    ?>

                    @foreach ($Modulo as $DatMod)
                        @if (
                            ($DatMod->url === 'disciplinarios/atender' && $DatLog->empleado == 154) ||
                                ($DatMod->url === 'disciplinarios/atender' && $DatLog->empleado == 1944))
                        @else
                            <div class="col-sm-6 col-xl-3">
                                <a href="{{ asset('/panel/') }}<?= $DatMod->url ?>"
                                    class="col-xs-12 panel panel-body cards" title="<?= $DatMod->nombre ?>">
                                    <div class="col-xs-12 ph10 text-center">
                                        <img src="{{ asset('/panelfiles/iconos/') }}<?= $DatMod->imagen ?>.png"
                                            class="img-responsive mauto" alt="<?= $DatMod->nombre ?>"
                                            style="width: 128px; height:128px;" />
                                        <h6 class="text-muted" style="padding-top: 40px">
                                            <font color="#2a2f43">
                                                <?= $DatMod->nombre ?>
                                            </font>
                                            </h5>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
                <!-- Módulos -->
                <!-- -------------- /Column Center -------------- -->
            </div>
            <!-- -------------- /Content -------------- -->
        </section>
    </div>
    <!-- -------------- /Body Wrap  -------------- -->

    <!-- -------------- Scripts -------------- -->

    <!-- -------------- jQuery -------------- -->
    <script src="{{ asset('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery/jquery_ui/jquery-ui.min.js') }}"></script>

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
