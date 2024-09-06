<?php
$server = '/Berhlan/public';
?>

@foreach ($DatosUsuario as $DatLog)

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>
            Intranet | Mejora continua | Consultar informes no conformidad
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

        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

        <script type="text/javascript" src="<?= $server ?>/panelfiles/select2/dist/js/select2.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/select2/dist/css/select2.min.css">

        <!-- Importar style select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



        <style>
            .radio-button {
                display: flex;
                gap: 10px;
                justify-content: center;
                margin: 10px;
                position: relative;
                align-items: center;
                color: white;
            }

            .radio-button input[type="radio"] {
                position: absolute;
                opacity: 0;
            }

            .radio {
                position: relative;
                display: inline-block;
                width: 24px;
                height: 24px;
                border-radius: 50%;
                border: 2px solid #ccc;
                box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
                transform: translateZ(-25px);
                transition: all 0.3s ease-in-out;
            }

            .radio::before {
                position: absolute;
                content: '';
                width: 10px;
                height: 10px;
                top: 5px;
                left: 5px;
                border-radius: 50%;
                background-color: #fff;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
                opacity: 0;
                transition: all 0.3s ease-in-out;
            }

            .radio-button input[type="radio"]:checked+.radio {
                border-color: #34495e;
                transform: translateZ(0px);
                background-color: #fff;
            }

            .radio-button input[type="radio"]:checked+.radio::before {
                opacity: 1;
                position: relative;
                top: 0px;
                left: 0px;
                background-color: #34495e;
            }

            .box {
                display: flex;
                gap: 20px;
            }

            textarea {
                width: 300px;
                resize: none;
                overflow-y: hidden;
            }

            .select2-selection {
                border: 1px #ccc solid;
                height: 100%;
                border-radius: 5px;
            }

            .select2-container .select2-selection--single {
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center
            }
        </style>

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
                                <a href="<?= $server ?>/panel/menu/118" title="Inconformidades">
                                    <font color="#34495e">
                                        Mejora continua >
                                    </font>
                                    <font color="#b4c056">
                                        Consultar informes no conformidad
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="<?= $server ?>/panel/menu/118" class="btn btn-primary btn-sm ml10"
                            title="Inconformidades">
                            REGRESAR &nbsp;
                            <span class="fa fa-arrow-left"></span>
                        </a>
                    </div>
                </header>
                <!-- -------------- /Topbar -------------- -->

                <section id="content" class="table-layout animated fadeIn">

                    <div class="chute chute-center pt30">
                        <!-- -------------- Column Center -------------- -->
                        <div class="panel m4">
                            <!-- -------------- Message Body -------------- -->
                            <div class="nano-content">
                                <div class="table-responsive">
                                    <br>
                                    <div class="box" style="display: flex; justify-content: center">
                                        <button id="btn_trata" type="submit" style="margin-right: 40px;"
                                            class="btn btn-success mb-2">
                                            <img src="{{ $server }}/images/informacion.png">
                                            Consultar tratamiento no conformidad
                                            </img>
                                        </button>

                                        <button id="btn_reporte" type="submit" style="margin-right: 40px;"
                                            class="btn btn-danger mb-2">
                                            <img src="{{ $server }}/images/informacion.png">
                                            Consultar reporte acción o mejora
                                            </img>
                                        </button>
                                    </div>


                                    <tr>

                                        <td>
                                            <div class="allcp-form">
                                                <form id="consultarTratamientoNoConf"
                                                    action="{{ route('searchTrataNoConf') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <br>
                                                    <br>
                                                    <div id="trata">
                                                        <div class="row">

                                                            <div class="col-md-5">
                                                                <label for="descripcion_trata" style="color: #34495e">
                                                                    <b>
                                                                        Descripción de la no conformidad
                                                                    </b>
                                                                </label>

                                                                <textarea name="descripcion_trata" id="descripcion_trata" style="width: 100%; border-radius: 4px;border-color: #e3e3e3"></textarea>
                                                            </div>

                                                            <div class="col-md-3">

                                                                <label for="fecha_ini" style="color: #34495e">
                                                                    <b>
                                                                        Desde la fecha:
                                                                    </b>
                                                                </label>

                                                                <input type="date" name="fecha_ini_trata"
                                                                    id="fecha_ini_trata" class="form-control"
                                                                    max="{{ date('Y-m-d') }}">
                                                            </div>

                                                            <div class="col-md-3">

                                                                <label for="fecha_final" style="color: #34495e">
                                                                    <b>
                                                                        Hasta la fecha:
                                                                    </b>
                                                                </label>

                                                                <input type="date" name="fecha_final_trata"
                                                                    id="fecha_final_trata" class="form-control"
                                                                    max="{{ date('Y-m-d') }}" disabled>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <label style="color: #34495e" for="inconfor_trata">
                                                                    <b>
                                                                        Tipo:
                                                                    </b>
                                                                </label>
                                                                <label class="field select">

                                                                    <select name="inconfor_trata" id="inconfor_trata"
                                                                        class="select_dinamico">
                                                                        <option value="">
                                                                            Opción
                                                                        </option>
                                                                        <option value="producto">
                                                                            Producto
                                                                        </option>
                                                                        <option value="proceso relacionado">
                                                                            Proceso relacionado
                                                                        </option>
                                                                        <option value="otro">
                                                                            Otro
                                                                        </option>
                                                                    </select>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label style="color: #34495e"
                                                                    for="proceso_rela_trata">
                                                                    <b>
                                                                        Proceso Relacionado:
                                                                    </b>
                                                                </label>


                                                                <label class="field select">
                                                                    <select name="proceso_rela_trata">
                                                                        <option value="">
                                                                            *Area
                                                                        </option>
                                                                        @foreach ($areas as $DatArea)
                                                                            <option value="{{ $DatArea->id_area }}">
                                                                                {{ $DatArea->descripcion }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </label>
                                                            </div>

                                                            <br>
                                                            <div class="col-md-4">
                                                                <br>
                                                                <button id="btn_reporte" type="submit"
                                                                    style="margin-right: 40px;"
                                                                    class="btn btn-primary mb-2">
                                                                    <img
                                                                        src="{{ $server }}/images/informacion.png">
                                                                    Consultar
                                                                    </img>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="allcp-form">
                                                <form id="consultarReporteNoConf"
                                                    action="{{ route('searchReporteNoConf') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div id="reporte">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="col-md-4">

                                                                    <label for="fecha_ini_repor"
                                                                        style="color: #34495e">
                                                                        <b>
                                                                            Desde la fecha:
                                                                        </b>
                                                                    </label>

                                                                    <input type="date" name="fecha_ini_repor"
                                                                        id="fecha_ini_repor" class="form-control"
                                                                        max="{{ date('Y-m-d') }}">
                                                                </div>

                                                                <div class="col-md-4">

                                                                    <label for="fecha_final_repor"
                                                                        style="color: #34495e">
                                                                        <b>
                                                                            Hasta la fecha:
                                                                        </b>
                                                                    </label>

                                                                    <input type="date" name="fecha_final_repor"
                                                                        class="form-control" id="fecha_final_repor"
                                                                        max="{{ date('Y-m-d') }}" disabled>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Proceso:
                                                                        </b>
                                                                    </label>


                                                                    <label class="field select">
                                                                        <select name="proceso_no_conforme">
                                                                            <option value="">
                                                                                *Area
                                                                            </option>
                                                                            @foreach ($areas as $DatArea)
                                                                                <option
                                                                                    value="{{ $DatArea->id_area }}">
                                                                                    {{ $DatArea->descripcion }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="row"
                                                                style="display: flex; justify-content: flex-end;">

                                                                <div class="col-md-2">
                                                                    <br>
                                                                    <br>
                                                                    <br>
                                                                    <button id="btn_reporte" type="submit"
                                                                        class="btn btn-primary mb-2">
                                                                        <img
                                                                            src="{{ $server }}/images/informacion.png">
                                                                        Consultar
                                                                        </img>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <br>

                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                </div>
                            </div>
                        </div>
                    </div>


                </section>
            </section>

        </div>

        <!-- -------------- Scripts -------------- -->

        <script type="module">
            import {
                    configureSelect2
                } from '<?= $server ?>/js/select2.js';
            $(document).ready(function() {



                configureSelect2();

                if (localStorage.getItem("search") === "repor") {
                    $("#reporte").show();
                    $("#trata").hide();
                    $("#btn_reporte").removeClass('btn-danger').addClass('btn-success');
                    $("#btn_trata").removeClass('btn-success').addClass('btn-danger');
                } else {
                    $("#trata").show();
                    $("#reporte").hide();

                }


                $("#btn_trata").click(function() {
                    $("#reporte").hide();
                    $("#trata").show();
                    $(this).removeClass("btn-danger");
                    $(this).addClass("btn-success");
                    $("#btn_reporte").addClass("btn-danger");
                    localStorage.setItem("search", "trata");
                });


                $("#btn_reporte").click(function() {
                    $("#trata").hide();
                    $("#reporte").show();
                    $(this).removeClass("btn-danger");
                    $(this).addClass("btn-success");
                    $("#btn_trata").addClass("btn-danger");
                    localStorage.setItem("search", "repor");
                });

                $("#fecha_ini_trata").change(function() {
                    var fechaIni = $("#fecha_ini_trata").val();
                    $("#fecha_final_trata").attr("min",
                        fechaIni).removeAttr("disabled").val('');
                });

                $("#fecha_ini_repor").change(function() {
                    var fechaIni = $("#fecha_ini_repor").val();
                    $("#fecha_final_repor").attr("min",
                        fechaIni).removeAttr("disabled").val('');
                });
                autosize(document.querySelectorAll('textarea'));

            });
        </script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/autosize.js/4.0.2/autosize.min.js"></script>
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

        <!-- Importar script select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/autosize.js/4.0.2/autosize.min.js"></script>

        <script src="https://kit.fontawesome.com/6b7caabff8.js" crossorigin="anonymous"></script>

    </body>
@endforeach
