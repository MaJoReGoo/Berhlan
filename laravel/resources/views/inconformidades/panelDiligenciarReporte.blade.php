<?php
$server = '/Berhlan/public';
?>

@foreach ($DatosUsuario as $DatLog)

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Mejora continua | Diligenciar reporte
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
                justify-content: center;
                gap: 20px;
            }

            textarea {
                width: 300px;
                resize: none;
                overflow-y: hidden;
            }

            .flipswitch {
                position: relative;
                width: 100px;
            }

            .flipswitch input[type=checkbox] {
                display: none;
            }

            .flipswitch-label {
                display: block;
                overflow: hidden;
                cursor: pointer;
                border: 1px solid #999999;
                border-radius: 50px;
            }

            .flipswitch-inner {
                width: 200%;
                margin-left: -100%;
                transition: margin 0.3s ease-in 0s;
            }

            .flipswitch-inner:before,
            .flipswitch-inner:after {
                float: left;
                width: 50%;
                height: 32px;
                padding: 0;
                line-height: 30px;
                font-size: 20px;
                color: white;
                font-family: Trebuchet, Arial, sans-serif;
                font-weight: bold;
                box-sizing: border-box;
            }

            .flipswitch-inner:before {
                content: "No";
                padding-left: 18px;
                background-color: #FFFFFF;
                color: #437A99;
            }

            .flipswitch-inner:after {
                content: "Si";
                padding-right: 18px;
                background-color: #437A99;
                color: #FFFFFF;
                text-align: right;
            }

            .flipswitch-switch {
                width: 35px;
                margin: -2.5px;
                background: #FFFFFF;
                border: 1px solid #999999;
                border-radius: 50px;
                position: absolute;
                top: 0;
                bottom: 0;
                right: 67px;
                transition: all 0.3s ease-in 0s;
            }

            .flipswitch-cb:checked+.flipswitch-label .flipswitch-inner {
                margin-left: 0;
            }

            .flipswitch-cb:checked+.flipswitch-label .flipswitch-switch {
                right: 0;
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

            #eliminarFila-persona {
                position: relative;
                right: 2px;
                cursor: pointer;
                color: red;
                left: 730px;
                top: -20px;
            }


            @media only screen and (max-width: 1265px) {
                #eliminarFila-persona {
                    left: 530px;
                }
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
                                        Diligenciar Reporte
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

                            <h6 style="background-color:#67d3e0; text-align: center;">
                                INGRESE LA INFORMACION SOBRE EL REPORTE DE ACCIONES CORRECTIVAS Y/O MEJORAS
                            </h6>


                            <div class="allcp-form">
                                <form id="completarReporteNoConf" action="{{ route('completarReporteNoConf') }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <input type="text" name="id_reporte_conform"
                                            value="{{ $registro_reporte->id_reporte_conform }}" hidden>
                                        <div class="col-md-2">

                                            <label style="color: #34495e" for = "lugar_reporte">
                                                <b>
                                                    N° No Conformidad:
                                                </b>
                                            </label>

                                            <label class="field select">
                                                <input type="text"
                                                    value="{{ $registro_reporte->id_reporte_conform }}" readonly
                                                    disabled>
                                            </label>
                                        </div>
                                        <div class="col-md-4">

                                            <label style="color: #34495e" for = "sistema_gestion">
                                                <b>
                                                    Sistema de Gestión:
                                                </b>
                                            </label>



                                            <label class="field select">
                                                <select name="sistema_gestion" required disabled
                                                    style="color: black !important;">
                                                    <option value="Sistema de gestión ambiental"
                                                        {{ $registro_reporte->sistema_de_gestion === 'Sistema de gestión ambiental' ? 'selected' : '' }}>
                                                        Sistema de gestión ambiental
                                                    </option>
                                                    <option value="Sistema de gestión de calidad"
                                                        {{ $registro_reporte->sistema_de_gestion === 'Sistema de gestión de calidad' ? 'selected' : '' }}>
                                                        Sistema de gestión de calidad
                                                    </option>
                                                    <option value="Sistema de gestión de seguridad"
                                                        {{ $registro_reporte->sistema_de_gestion === 'Sistema de gestión de seguridad' ? 'selected' : '' }}>
                                                        Sistema de gestión de seguridad
                                                    </option>
                                                    <option value="Sistema de gestión salud en el trabajo"
                                                        {{ $registro_reporte->sistema_de_gestion === 'Sistema de gestión salud en el trabajo' ? 'selected' : '' }}>
                                                        Sistema de gestión salud en el trabajo
                                                    </option>
                                                </select>
                                            </label>

                                        </div>
                                        <div class="col-md-4">

                                            <label style="color: #34495e" for = "ciclo_auditoria">
                                                <b>
                                                    Ciclo Auditoría:
                                                </b>
                                            </label>



                                            <label class="field select">
                                                <select id="ciclo_auditoria" required disabled
                                                    style="color: black !important;">
                                                    <option value="Auditoria interna ciclo"
                                                        {{ $registro_reporte->ciclo_auditoria === 'Auditoria interna ciclo 1' ? 'selected' : '' }}>
                                                        Auditoria interna ciclo
                                                    </option>

                                                    <option value="Auditoria externa ciclo"
                                                        {{ $registro_reporte->ciclo_auditoria === 'Auditoria externa ciclo 1' ? 'selected' : '' }}>
                                                        Auditoria externa ciclo
                                                    </option>

                                                </select>
                                            </label>

                                        </div>





                                    </div>
                                    <br>
                                    <br>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <label for="fecha_elaboracion" style="color: #34495e">
                                                <b>
                                                    Fecha auditoría
                                                </b>
                                            </label>

                                            <input type="date" class="form-control"
                                                value="{{ \Carbon\Carbon::parse($registro_reporte->fecha_auditoria)->format('Y-m-d') }}"
                                                required disabled>
                                        </div>

                                        <div class="col-md-4">

                                            <label style="color: #34495e" for = "lugar_reporte">
                                                <b>
                                                    Lugar:
                                                </b>
                                            </label>



                                            <label class="field select">
                                                <select id="lugar_reporte" required disabled
                                                    style="color: black !important;">
                                                    <option value="tebaida"
                                                        {{ $registro_reporte->lugar === 'tebaida' ? 'selected' : '' }}>
                                                        Tebaida
                                                    </option>
                                                    <option value="galapa"
                                                        {{ $registro_reporte->lugar === 'galapa' ? 'selected' : '' }}>
                                                        Galapa
                                                    </option>
                                                    <option value="tocancipa"
                                                        {{ $registro_reporte->lugar === 'tocancipa' ? 'selected' : '' }}>
                                                        Tocancipá
                                                    </option>
                                                </select>
                                            </label>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="fecha_elaboracion" style="color: #34495e">
                                                <b>
                                                    Fecha elaboración correctiva y/o mejora
                                                </b>
                                            </label>

                                            <input type="date" class="form-control"
                                                value="{{ \Carbon\Carbon::parse($registro_reporte->fecha_elaboracion)->format('Y-m-d') }}"
                                                required disabled>

                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <h3 class="mb-4" style="text-align: center;";>
                                        DESCRIPCIÓN Y ANÁLISIS DE LA NO CONFORMIDAD </h3>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="fuente_razon"
                                                style="color: #34495e; display:flex; justify-content:center">
                                                <b>Fuente: (Marque una opción)</b>
                                            </label>
                                            <label class="field select">
                                                <div class="box">
                                                    <label class="radio-button">
                                                        <input type="radio" id="fuente_razon"
                                                            value="documentos normativos"
                                                            {{ $registro_reporte->fuente_no_conforme === 'documentos normativos' ? 'checked' : '' }}
                                                            disabled required>
                                                        <span class="radio"></span>
                                                        Documentos normativos
                                                    </label>
                                                    <label class="radio-button">
                                                        <input type="radio" id="fuente_razon" value="procesos"
                                                            {{ $registro_reporte->fuente_no_conforme === 'procesos' ? 'checked' : '' }}
                                                            disabled required>
                                                        <span class="radio"></span>
                                                        Procesos
                                                    </label>
                                                    <label class="radio-button">
                                                        <input type="radio" id="fuente_razon"
                                                            value="procedimientos"
                                                            {{ $registro_reporte->fuente_no_conforme === 'procedimientos' ? 'checked' : '' }}
                                                            disabled required>
                                                        <span class="radio"></span>
                                                        Procedimientos
                                                    </label>
                                                    <label class="radio-button">
                                                        <input type="radio" id="fuente_razon"
                                                            value="producto no conforme"
                                                            {{ $registro_reporte->fuente_no_conforme === 'producto no conforme' ? 'checked' : '' }}
                                                            disabled required>
                                                        <span class="radio"></span>
                                                        Producto No Conforme
                                                    </label>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="box">
                                                <label class="radio-button">
                                                    <input type="radio" id="fuente_razon" value="quejas y reclamos"
                                                        {{ $registro_reporte->fuente_no_conforme === 'quejas y reclamos' ? 'checked' : '' }}
                                                        disabled required required>
                                                    <span class="radio"></span>
                                                    Quejas y Reclamos
                                                </label>

                                                <label class="radio-button">
                                                    <input type="radio" id="fuente_razon" value="auditoria interna"
                                                        {{ $registro_reporte->fuente_no_conforme === 'auditoria interna' ? 'checked' : '' }}
                                                        disabled required>
                                                    <span class="radio"></span>
                                                    Auditoria interna
                                                </label>
                                                <label class="radio-button">
                                                    <input type="radio" id="fuente_razon" value="auditoria externa"
                                                        {{ $registro_reporte->fuente_no_conforme === 'auditoria externa' ? 'checked' : '' }}
                                                        disabled required>
                                                    <span class="radio"></span>
                                                    Auditoria externa
                                                </label>
                                                <label class="radio-button">
                                                    <input type="radio" id="fuente_razon" value = 'otro'
                                                        {{ !in_array($registro_reporte->fuente_no_conforme, ['documentos normativos', 'procesos', 'procedimientos', 'producto no conforme', 'quejas y reclamos', 'auditoria interna', 'auditoria externa']) ? 'checked' : '' }}
                                                        disabled required>
                                                    <span class="radio"></span>
                                                    Otro
                                                    <div id="cual"
                                                        style="display: flex; justify-content: center; align-items: center; gap:10px">
                                                        <b>
                                                            Cual?
                                                        </b>
                                                        <input type="text"
                                                            value="{{ $registro_reporte->fuente_no_conforme }}"
                                                            style="width: 100%" disabled required>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label style="color: #34495e" for = "proceso_no_conforme">
                                                <b>
                                                    Proceso No Conforme:
                                                </b>
                                            </label>


                                            <label class="field select">
                                                <select required disabled style="color: black !important;">
                                                    @foreach ($areas as $DatArea)
                                                        <option value="{{ $DatArea->id_area }}"
                                                            {{ $DatArea->id_area == $registro_reporte->proceso_no_conforme ? 'selected' : '' }}>
                                                            {{ $DatArea->descripcion }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </label>
                                        </div>
                                        <div class="col-md-4">

                                            <label style="color: #34495e" for = "nombre_proceso_reporta">
                                                <b>
                                                    Nombre del R de proceso que reporta la No
                                                    Conformidad (o del auditor líder):
                                                </b>
                                            </label>
                                            <label class="field select">

                                                <select required disabled style="color: black !important;">
                                                    <option value="">
                                                        *Persona
                                                    </option>
                                                    @foreach ($Empleados as $DatEmp)
                                                        <option value="{{ $DatEmp->id_empleado }}"
                                                            {{ $DatEmp->id_empleado == $registro_reporte->nombre_reporte_proceso ? 'selected' : '' }}>
                                                            {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </label>
                                        </div>

                                        <div class="col-md-4">

                                            <label style="color: #34495e; display:flex; justify-content:center">
                                                <b>
                                                    Tipo: (Marque una opción)
                                                </b>
                                            </label>

                                            <div class="box">
                                                <label class="radio-button">
                                                    <input type="radio" id="tipo_correctiva" value="correctiva"
                                                        {{ $registro_reporte->tipo_proceso_no_conforme === 'correctiva' ? 'checked' : '' }}
                                                        disabled required>
                                                    <span class="radio"></span>
                                                    Correctiva
                                                </label>
                                                <label class="radio-button">
                                                    <input type="radio" id="tipo_mejora" name="tipo_no_conformidad"
                                                        value="mejora"
                                                        {{ $registro_reporte->tipo_proceso_no_conforme === 'mejora' ? 'checked' : '' }}
                                                        disabled required>
                                                    <span class="radio"></span>
                                                    Mejora
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="row">

                                        <div class="col-md-5">
                                            <label for="descrip_no_corformidad" style="color: #34495e">
                                                <b>Descripción de la(s) No Conformidad (es) y/o
                                                    Observación:</b>
                                            </label>

                                            <textarea id="descrip_no_corformidad" style="width: 100%; border-radius: 4px;border-color: #e3e3e3" disabled>{{ $registro_reporte->descripcion_no_conformidad }}</textarea>
                                        </div>

                                        <div class="col-md-6">


                                            <label style="color: #34495e">
                                                <b>
                                                    Nombre / Cargo del Responsable de la No
                                                    Conformidad:
                                                </b>
                                            </label>


                                            <label class="field select">
                                                <select disabled style="color: black !important;">
                                                    @foreach ($Empleados as $DatEmp)
                                                        <option value="{{ $DatEmp->id_empleado }}"
                                                            {{ $DatEmp->id_empleado == $registro_reporte->responsable_no_conformidad ? 'selected' : '' }}>
                                                            {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </label>
                                        </div>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="row">
                                        <div class="box" style="display: flex; justify-content: center;">
                                            <div class="col-md-8">
                                                <table class="table table-bordered" id="form-table">
                                                    <thead style="background-color:#67d3e0;">
                                                        <tr>
                                                            <th scope="col"
                                                                style="text-align: center; color:#34495e; ">
                                                                Equipo de trabajo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="table-1">
                                                        <tr>
                                                            <th scope="col"
                                                                style="text-align: center; color:#34495e; ">
                                                                | Persona - Cargo |</th>
                                                        </tr>
                                                        <tr>
                                                            <td scope="row">
                                                                @if (count($registro_equipo_reporte) === 0)
                                                                    <label class="field select">
                                                                        <select name="persona_equipo[]"
                                                                            class="selector">
                                                                            <option style="text-align: center"
                                                                                value="">
                                                                                Persona
                                                                            </option>
                                                                            @foreach ($Empleados as $DatEmp)
                                                                                <option
                                                                                    value="{{ $DatEmp->id_empleado }}">
                                                                                    {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </label>
                                                                @else
                                                                    @foreach ($registro_equipo_reporte as $reg_equipo_reporte)
                                                                        <select class="selector" disabled>
                                                                            @foreach ($Empleados as $DatEmp)
                                                                                <option
                                                                                    value="{{ $DatEmp->id_empleado }}"
                                                                                    {{ $DatEmp->id_empleado == $reg_equipo_reporte->persona_equipo_trabajo ? 'selected' : '' }}>
                                                                                    {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <a id="addRow-1" class="btn btn-primary">
                                                    <img src="{{ $server }}/images/agregar-boton.png"
                                                        alt="Añadir campo">
                                                    Añadir campo
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="row" style="display:flex; justify-content:center;">

                                        <div class="col-md-7"
                                            style="display: flex;
                                                                        flex-direction: column;
                                                                        align-items: center; justify-content: center;">

                                            <label style="color: #34495e; ">
                                                <b style=>
                                                    Dimensionamiento de la No Conformidad
                                                </b>
                                            </label>
                                            <div class="col-md-11"
                                                style="display: flex;
                                                                        justify-content: space-between;
                                                                        align-items: center; flex-direction: column;">

                                                <label style="color: #34495e; display:flex; justify-content:center; ">
                                                    <b>
                                                        Impacto y Riesgo de la No
                                                        Conformidad: (Marque una opción)
                                                    </b>
                                                </label>
                                                <br>
                                                <div class="box">
                                                    <label class="radio-button">
                                                        <input type="radio" id="impacto_bajo" value="Bajo"
                                                            {{ $registro_reporte->impacto_no_conformidad === 'Bajo' ? 'checked' : '' }}
                                                            disabled required>
                                                        <span class="radio"></span>
                                                        Bajo
                                                    </label>
                                                    <label class="radio-button">
                                                        <input type="radio" id="impacto_medio" value="Medio"
                                                            {{ $registro_reporte->impacto_no_conformidad === 'Medio' ? 'checked' : '' }}
                                                            disabled required>
                                                        <span class="radio"></span>
                                                        Medio
                                                    </label>
                                                    <label class="radio-button">
                                                        <input type="radio" id="impacto_alto" value="Alto"
                                                            {{ $registro_reporte->impacto_no_conformidad === 'Alto' ? 'checked' : '' }}
                                                            disabled required>
                                                        <span class="radio"></span>
                                                        Alto
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <h3 class="mb-4" style="text-align: center;";>
                                        Análisis de Causas </h3>
                                    <div class="row">
                                        <div class="col-md-4">

                                            <div style="background-color:#67d3e0; color:#34495e; text-align: center;">
                                                Mano de Obra (personas: falta de capacitación,
                                                habilidades y destrezas, funciones no definidas
                                                etc.)
                                            </div>
                                            <textarea id="mano_de_obra" name="mano_de_obra"
                                                style="width: 100%; border-radius: 4px;border-color: #e3e3e3;margin-bottom: 18px;" required>{{ $registro_reporte->analisis_mano_de_obra }}</textarea>

                                        </div>


                                        <div class="col-md-4">

                                            <div style="background-color:#67d3e0; color:#34495e; text-align: center;">
                                                Maquinaria (Equipos: falta de
                                                mantenimiento preventivo,
                                                deficiencia en infraestructura,
                                                falta de inspecciones a equipos
                                                etc.)
                                            </div>

                                            <textarea name="maquinaria" id="maquinaria"
                                                style="width: 100%; border-radius: 4px;border-color: #e3e3e3;margin-bottom: 18px;" required>{{ $registro_reporte->analisis_maquinaria }}</textarea>

                                        </div>

                                        <div class="col-md-4">


                                            <div style="background-color:#67d3e0; color:#34495e; text-align: center;">
                                                Método (falta de definición en
                                                procesos y/o procedimientos,
                                                documentación no adecuada etc.)
                                            </div>

                                            <textarea name="metodo" id="metodo"
                                                style="width: 100%; border-radius: 4px;border-color: #e3e3e3;margin-bottom: 18px;" required>{{ $registro_reporte->analisis_metodo }}</textarea>

                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4">

                                            <div style="background-color:#67d3e0; color:#34495e; text-align: center;">
                                                Materiales (falta de definición
                                                especificaciones de materia prima,
                                                incumplimiento en verificación de
                                                especificaciones etc.)
                                            </div>

                                            <textarea name="materiales" id="materiales"
                                                style="width: 100%; border-radius: 4px;border-color: #e3e3e3;margin-bottom: 18px;" required>{{ $registro_reporte->analisis_materiales }}</textarea>
                                            </label>

                                        </div>
                                        <div class="col-md-4">
                                            <div style="background-color:#67d3e0; color:#34495e; text-align: center;">
                                                Medio Ambiente (Ambiente de trabajo:
                                                ruido, luz, condiciones de
                                                infraestructura etc.)
                                            </div>


                                            <textarea name="medio_ambiente" id="medio_ambiente"
                                                style="width: 100%; border-radius: 4px;border-color: #e3e3e3;margin-bottom: 18px;" required>{{ $registro_reporte->analisis_medio_ambiente }}</textarea>

                                        </div>
                                        <div class="col-md-4">
                                            <div style="background-color:#67d3e0; color:#34495e; text-align: center;">
                                                Otros Factores

                                            </div>

                                            <textarea name="otros_factores" id="otros_factores"
                                                style="width: 100%; border-radius: 4px;border-color: #e3e3e3; margin-bottom: 18px;" required>{{ $registro_reporte->analisis_otros_factores }}</textarea>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="box" style="display: flex">
                                            <div class="col-md-12" id="id_table_2" style="overflow-x: auto">

                                                <table class="table table-bordered">
                                                    <thead style="background-color: #67d3e0; color:#34495e">
                                                        <tr>
                                                            <th colspan="4" style="text-align: center;">
                                                                Plan de Acción (Si se
                                                                Requiere)
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Actividad/Tarea</th>
                                                            <th> Responsable </th>
                                                            <th>Fecha implementación<br>
                                                                de la
                                                                actividad/tarea</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id='table-2'>
                                                        @if (count($registro_plan_accion_reporte) === 0)
                                                            <tr>
                                                                <td>
                                                                    <input type="text" class="form-control number"
                                                                        name="plan_accion_n#[]" id = "plan_accion_n"
                                                                        required readonly>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="plan_accion_actividad[]" required>
                                                                </td>
                                                                <td>
                                                                    <select name="plan_accion_responsable[]" required>
                                                                        <option style="text-align: center"
                                                                            value="">
                                                                            Persona
                                                                        </option>
                                                                        @foreach ($Empleados as $DatEmp)
                                                                            <option
                                                                                value="{{ $DatEmp->id_empleado }} ">
                                                                                {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>

                                                                </td>
                                                                <td>
                                                                    <input type="date"
                                                                        name="plan_accion_fecha_tarea[]"
                                                                        class="form-control" required>
                                                                </td>
                                                            </tr>
                                                        @else
                                                            @foreach ($registro_plan_accion_reporte as $reg_plan_accion_reporte)
                                                                <tr>
                                                                    <td>
                                                                        <input type="text" style="width: 100px;"
                                                                            class="form-control number"
                                                                            id = "plan_accion_n"
                                                                            value="{{ $reg_plan_accion_reporte->plan_accion_numero }}"
                                                                            disabled required>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $reg_plan_accion_reporte->plan_accion_actividad }}"
                                                                            disabled required>
                                                                    </td>
                                                                    <td>
                                                                        <select disabled required>

                                                                            @foreach ($Empleados as $DatEmp)
                                                                                <option
                                                                                    value="{{ $DatEmp->id_empleado }}"
                                                                                    {{ $DatEmp->id_empleado == $reg_plan_accion_reporte->plan_accion_responsable ? 'selected' : '' }}>
                                                                                    {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                    </td>
                                                                    <td>
                                                                        <input type="date" class="form-control"
                                                                            value="{{ $reg_plan_accion_reporte->plan_accion_fecha_tarea }}"
                                                                            disabled required>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>

                                                </table>
                                                <a id="addRow-2" class="btn btn-primary">
                                                    <img src="{{ $server }}/images/agregar-boton.png"
                                                        alt="Añadir campo">
                                                    Añadir campo
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                    <br>
                                    <br>

                                    <div class="row">
                                        <div class="box" style="display: flex">
                                            <div class="col-md-12" style="overflow-x: auto">
                                                <table class="table table-bordered">
                                                    <thead style="background-color: #67d3e0; color:#34495e">
                                                        <tr>
                                                            <th colspan="7" style="text-align: center;">
                                                                Seguimiento al Plan de
                                                                Acción
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Fecha del Seguimiento
                                                            </th>
                                                            <th>No.</th>
                                                            <th>Actividad/Tareas
                                                                Ejecutadas
                                                            </th>
                                                            <th>Compromisos y/o
                                                                Pendientes
                                                            </th>
                                                            <th>Responsable del
                                                                Seguimiento
                                                            </th>
                                                            <th>Adjuntar</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id='table-3'>
                                                        @if (count($registro_seguimiento_reporte) === 0)
                                                            <tr>
                                                                <td><input type="date" class="form-control"
                                                                        name="seguimiento_plan_fecha[]" required>
                                                                </td>
                                                                <td>
                                                                    <label class="field select">
                                                                        <select name="seguimiento_plan_n#[]"
                                                                            style="width: 100px" required>
                                                                            <option style="text-align: center"
                                                                                value="">
                                                                                Seleccione un
                                                                                plan de accion
                                                                            </option>
                                                                        </select>
                                                                    </label>

                                                                </td>
                                                                <td>
                                                                    <textarea name="seguimiento_plan_descrip[]" id="seguimiento_plan_descrip"
                                                                        style="width: 250px; border-radius: 4px;border-color: #e3e3e3;" required></textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea name="seguimiento_plan_compromisos[]" id="seguimiento_plan_compromisos"
                                                                        style="width: 250px; border-radius: 4px;border-color: #e3e3e3;" required></textarea>
                                                                </td>
                                                                <td>

                                                                    <select name="seguimiento_plan_responsable[]"
                                                                        required>
                                                                        <option style="text-align: center"
                                                                            value="">
                                                                            Persona
                                                                        </option>
                                                                        @foreach ($Empleados as $DatEmp)
                                                                            <option
                                                                                value="{{ $DatEmp->id_empleado }}">
                                                                                {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <div class="image-upload">
                                                                        <label
                                                                            style="display: flex; align-items: center;justify-content: center;">
                                                                            <i class="fas fa-file-upload"
                                                                                style="font-size: 30px"></i>
                                                                        </label>

                                                                        <input type="file"
                                                                            name="segui_plan_archivos[]" />
                                                                    </div>


                                                                </td>
                                                            </tr>
                                                        @else
                                                            @foreach ($registro_seguimiento_reporte as $reg_seguimiento_reporte)
                                                                <tr>
                                                                    <td><input type="date" class="form-control"
                                                                            value="{{ $reg_seguimiento_reporte->seguimiento_plan_fecha }}"
                                                                            disabled required>
                                                                    </td>
                                                                    <td><input type="text" class="form-control"
                                                                            style="width: 110px"
                                                                            value="{{ $reg_seguimiento_reporte->seguimiento_numero }}"
                                                                            disabled required>
                                                                    </td>
                                                                    <td>
                                                                        <textarea id="seguimiento_plan_descrip" style="width: 250px; border-radius: 4px;border-color: #e3e3e3;" disabled
                                                                            required>{{ $reg_seguimiento_reporte->seguimiento_actividad_tarea }}</textarea>
                                                                    </td>
                                                                    <td>
                                                                        <textarea id="seguimiento_plan_compromisos" style="width: 250px; border-radius: 4px;border-color: #e3e3e3;" disabled
                                                                            required>{{ $reg_seguimiento_reporte->seguimiento_compromisos }} </textarea>
                                                                    </td>
                                                                    <td>

                                                                        <select required disabled>
                                                                            @foreach ($Empleados as $DatEmp)
                                                                                <option
                                                                                    value="{{ $DatEmp->id_empleado }}"
                                                                                    {{ $DatEmp->id_empleado == $reg_seguimiento_reporte->seguimiento_responsable ? 'selected' : '' }}>
                                                                                    {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <div class="image-upload">
                                                                            <label
                                                                                style="display: flex; align-items: center;justify-content: center;">
                                                                                <i class="fas fa-file-upload"
                                                                                    style="font-size: 30px"></i>
                                                                            </label>
                                                                            @if ($reg_seguimiento_reporte->segui_plan_archivos !== null)
                                                                                <p>{{ $reg_seguimiento_reporte->segui_plan_archivos }}
                                                                                </p>
                                                                            @else
                                                                                <input type="file" disabled />
                                                                            @endif

                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                                <a id="addRow-3" class="btn btn-primary">
                                                    <img src="{{ $server }}/images/agregar-boton.png"
                                                        alt="Añadir campo">
                                                    Añadir campo
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12" style="padding-right: 60px; overflow-x: auto;">
                                            <table class="table table-bordered">
                                                <thead style="background-color: #67d3e0; color:#34495e">
                                                    <tr>
                                                        <th colspan="4" style="text-align: center;">
                                                            Verificación de Implementación de
                                                            Correctivo(s), Acción(es)
                                                            Correctiva(s) y/o Mejora(s)
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>Fecha de Verificación
                                                        </th>
                                                        <th>Observaciones
                                                        </th>
                                                        <th>
                                                            Nombre del Responsable / Cargo de
                                                            Verificación
                                                        </th>
                                                        <th>Adjuntar</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='table'>
                                                    @foreach ($registro_verifi_imp_reporte as $reg_verifi_imp_reporte)
                                                        <tr>
                                                            <td style="width: 50px;"><input type="date"
                                                                    class="form-control"
                                                                    value="{{ $reg_verifi_imp_reporte->verifica_implementacion_fecha }}"
                                                                    disabled required>
                                                            </td>
                                                            <td id="table" style="width: 350px">

                                                                <textarea style="width: 100%; border-radius: 4px;border-color: #e3e3e3;" disabled required>{{ $reg_verifi_imp_reporte->verifica_implementacion_observa }}</textarea>

                                                            </td>
                                                            <td>

                                                                <select required disabled>

                                                                    @foreach ($Empleados as $DatEmp)
                                                                        <option value="{{ $DatEmp->id_empleado }}"
                                                                            {{ $DatEmp->id_empleado == $reg_verifi_imp_reporte->verifi_imple_respon ? 'selected' : '' }}>
                                                                            {{ $DatEmp->primer_nombre }}
                                                                            {{ $DatEmp->ot_nombre }}
                                                                            {{ $DatEmp->primer_apellido }}
                                                                            {{ $DatEmp->ot_apellido }}
                                                                            -
                                                                            {{ $DatEmp->descripcion }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                @if ($reg_verifi_imp_reporte->verifica_imple_archivos !== null)
                                                                    <div class="image-upload">
                                                                        <label
                                                                            style="display: flex; align-items: center;justify-content: center;">
                                                                            <i class="fas fa-file-upload"
                                                                                style="font-size: 30px"></i>
                                                                        </label>

                                                                        <p style="text-align: center">
                                                                            {{ $reg_verifi_imp_reporte->verifica_imple_archivos }}
                                                                        </p>
                                                                        <input type="file"
                                                                            name="verifica_imple_archivos[]"
                                                                            disabled />
                                                                    </div>
                                                                @else
                                                                    <div class="image-upload">
                                                                        <label
                                                                            style="display: flex; align-items: center;justify-content: center;">
                                                                            <i class="fas fa-file-upload"
                                                                                style="font-size: 30px"></i>
                                                                        </label>
                                                                        <input type="file"
                                                                            name="verifica_imple_archivos[]"
                                                                            disabled />
                                                                    </div>
                                                                @endif

                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered">
                                                <thead style="background-color: #67d3e0; color:#34495e">
                                                    <tr>
                                                        <th colspan="3" style="text-align: center;">
                                                            Cierre de la No Conformidad
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>Actividad</th>
                                                        <th>Fecha</th>
                                                        <th>Responsable</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        <td style="width: 200px;">Programada
                                                            para Cerrar en:</td>
                                                        <h6>{{ $registro_reporte->prog_cierre_cargo_responsable }}
                                                        </h6>
                                                        <td style="width: 50px;"><input type="date"
                                                                value="{{ \Carbon\Carbon::parse($registro_reporte->prog_cierre_fecha)->format('Y-m-d') }}"
                                                                class="form-control" disabled required>
                                                        </td>
                                                        <td>
                                                            <label class="field select">
                                                                <label class="field select">

                                                                    <select required disabled>
                                                                        @foreach ($Empleados as $DatEmp)
                                                                            <option value="{{ $DatEmp->id_empleado }}"
                                                                                {{ $DatEmp->id_empleado == $registro_reporte->prog_cierre_responsable ? 'selected' : '' }}>
                                                                                {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 200px;">Cerrada
                                                            Realmente en:</td>
                                                        <td style="width: 50px;"><input type="date"
                                                                class="form-control"
                                                                value="{{ \Carbon\Carbon::parse($registro_reporte->cierre_real_fecha)->format('Y-m-d') }}"
                                                                disabled required>
                                                        </td>
                                                        <td>
                                                            <label class="field select">

                                                                <select required disabled>

                                                                    @foreach ($Empleados as $DatEmp)
                                                                        <option value="{{ $DatEmp->id_empleado }}"
                                                                            {{ $DatEmp->id_empleado == $registro_reporte->cierre_real_responsable ? 'selected' : '' }}>
                                                                            {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </label>
                                                        </td>
                                                    </tr>

                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="box"
                                        id = 'btn_actualizar'style="display:flex;justify-content:flex-end;">
                                        <button id="btn_actualizar" type="submit" class="btn btn-primary mb-2">
                                            <img src="{{ $server }}/images/agregar-boton.png">
                                            Ingresar información
                                            </img>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        </div>

        <!-- -------------- Scripts -------------- -->

        <script>
            $(document).ready(function($) {
                let consecutivo = '<?= $registro_reporte->consecutivo ?>';
                let incrementable = '<?= $incrementable ?>';
                let arregloNumerico = [];

                if ($('#plan_accion_n').val() === "") {
                    $('#plan_accion_n').val(consecutivo + '-' + incrementable);
                    arregloNumerico.push(consecutivo + '-' + incrementable);
                } else {
                    $('#table-2 .form-control.number').each(function(index) {
                        let valor = $(this).val();
                        arregloNumerico.push(valor);

                    });

                }

                autosize($('textarea'));
                let input = $('#cual');
                input.hide();

                function valuesSelect() {
                    $('#table-3 select[name="seguimiento_plan_n#[]"]').each(function() {
                        var selectedValues = $(this).val();
                        $(this).empty();
                        var select = $(this);
                        select.append($('<option>', {
                            value: '',
                            text: 'Seleccione una opción'
                        }));
                        $.each(arregloNumerico, function(index, opcion) {
                            select.append($('<option>', {
                                value: opcion,
                                text: opcion
                            }));
                        });
                        if (selectedValues !== null && selectedValues !== undefined) {
                            $(this).val(selectedValues);
                        }
                    });
                }


                let rows = {
                    one: '<tr>' +
                        '<th  ><label class="field select" style="display: flex; align-items: center;"><select class = "selector" name="persona_equipo[]" required><option style="text-align: center" value="">Persona</option> @foreach ($Empleados as $DatEmp) <option value="{{ $DatEmp->id_empleado }}"> {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}</option> @endforeach </select>' +
                        '<a id ="eliminarFila-1" style = "color:red; margin-left:10px;cursor:pointer;"><i class="fa-regular fa-trash-can fa-xl"></i></a></label>' +
                        '</th>' +
                        '</tr>',
                    two: '<tr>' +
                        `<td><input type="text" class="form-control number" style="width: 100px;" name="plan_accion_n#[]" required readonly></td><td><input type="text" class="form-control" name="plan_accion_actividad[]" required></td><td ><label class="field select"><select name="plan_accion_responsable[]" required><option style="text-align: center" value="">Persona</option>@foreach ($Empleados as $DatEmp) <option value="{{ $DatEmp->id_empleado }}"> {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }} </option> @endforeach</select></label></td><td style = "display: flex; align-items: center;"><input type="date" name="plan_accion_fecha_tarea[]"class="form-control" required> ` +
                        '<td style="width:25px"> <a id ="eliminarFila-2" style = "color:red; cursor:pointer;"><i class="fa-regular fa-trash-can fa-xl"></i></a>' +
                        '</td>' +
                        '</tr>',
                    three: '<tr>' +
                        '<td><input type="date" class="form-control" name="seguimiento_plan_fecha[]" required> </td> <td><label class="field select"> <select name="seguimiento_plan_n#[]" style="width: 110px;"> <option style="text-align: center" value=""> Seleccione un plan de accion </option> </select> </label> </td> <td> <label class="field select" for="seguimiento_plan_descrip"> <textarea name="seguimiento_plan_descrip[]" style="width: 100%; border-radius: 4px;border-color: #e3e3e3;margin-bottom: 18px;"required></textarea> </label> </td> <td> <textarea name="seguimiento_plan_compromisos[]" style="width: 100%; border-radius: 4px;border-color: #e3e3e3; required"></textarea>  </td> <td> <label class="field select" for="seguimiento_plan_responsable"> <select name="seguimiento_plan_responsable[]" required> <option style="text-align: center" value=""> Persona </option> @foreach ($Empleados as $DatEmp) <option value="{{ $DatEmp->id_empleado }}"> {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }} </option> @endforeach </select> </label></td><td style="width: 75px;"> <div class="image-upload"> <label style="display: flex; align-items: center;justify-content: center;"> <i class="fas fa-file-upload" style="font-size: 30px"></i> </label> <input type="file" name="segui_plan_archivos[]" /> </div> ' +
                        '<td style="width:25px"><a id ="eliminarFila-3" style = "color:red; cursor:pointer;" ><i class="fa-regular fa-trash-can fa-xl"></i></a>' +
                        '</td>' +
                        '</tr>',
                }

                function addRows(number, row) {
                    $(`#addRow-${number}`).click(function() {
                        if (number === 2) {
                            incrementable++;
                            let newRow = $(row);
                            newRow.find('input[name="plan_accion_n#[]"]').val(consecutivo + '-' +
                                incrementable);
                            arregloNumerico.push(consecutivo + '-' + incrementable);
                            $(`#table-${number}`).append(newRow);
                            valuesSelect();
                        } else {
                            $(`#table-${number}`).append(row);
                        }
                        if (number === 3) {
                            valuesSelect();
                        }
                        $('select').select2({
                            theme: 'none',
                            matcher: function(params, data) {
                                // Si no se ha ingresado texto de búsqueda, mostrar todas las opciones
                                if ($.trim(params.term) === '') {
                                    return data;
                                }

                                // Dividir el término de búsqueda en palabras
                                var terms = params.term.split(" ");

                                // Recorrer todas las palabras del término de búsqueda
                                for (var i = 0; i < terms.length; i++) {
                                    var term = terms[i].toLowerCase();
                                    var found = false;

                                    // Comprobar si alguna parte del texto coincide con la palabra de búsqueda
                                    if (data.text.toLowerCase().indexOf(term) > -1) {
                                        found = true;
                                    }

                                    // Si no se encuentra la palabra de búsqueda en el texto actual, no es una coincidencia
                                    if (!found) {
                                        return null;
                                    }
                                }

                                // Si todas las palabras coinciden, mostrar la opción
                                return data;
                            }
                        });
                        autosize($('textarea'));
                    });

                    $(`#table-${number}`).on('click', `#eliminarFila-${number}`, function() {

                        if (number === 2) {
                            const posicion = arregloNumerico.indexOf($(this).closest('tr').find(
                                'input[name="plan_accion_n#[]"]').val());
                            console.log(posicion);
                            if (posicion !== -1) {
                                arregloNumerico.splice(posicion, 1);
                                $(this).closest('tr').remove();
                                incrementable--;
                                let tamañoArreglo = arregloNumerico.length;
                                arregloNumerico = [];
                                let value = 1;

                                let inputs = $('#table-2 .form-control.number');
                                inputs.each(function(index) {
                                    arregloNumerico.push(consecutivo + '-' + value);
                                    $(this).val(consecutivo + '-' + value);
                                    value++;
                                });

                                valuesSelect();
                            }


                        } else {
                            $(this).closest('tr').remove();
                        }
                    });
                }


                $('select').select2({
                    theme:'none',
                    matcher: function(params, data) {
                        // Si no se ha ingresado texto de búsqueda, mostrar todas las opciones
                        if ($.trim(params.term) === '') {
                            return data;
                        }

                        // Dividir el término de búsqueda en palabras
                        var terms = params.term.split(" ");

                        // Recorrer todas las palabras del término de búsqueda
                        for (var i = 0; i < terms.length; i++) {
                            var term = terms[i].toLowerCase();
                            var found = false;

                            // Comprobar si alguna parte del texto coincide con la palabra de búsqueda
                            if (data.text.toLowerCase().indexOf(term) > -1) {
                                found = true;
                            }

                            // Si no se encuentra la palabra de búsqueda en el texto actual, no es una coincidencia
                            if (!found) {
                                return null;
                            }
                        }

                        // Si todas las palabras coinciden, mostrar la opción
                        return data;
                    }
                });

                addRows(1, rows.one)
                addRows(2, rows.two)
                addRows(3, rows.three)
                valuesSelect();

                if ($('input[id="fuente_razon"]:checked').val() === 'otro') {
                    input.show();
                }


            });
        </script>




        <!-- -------------- jQuery -------------- -->
        <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>

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
        <script src="https://kit.fontawesome.com/6b7caabff8.js" crossorigin="anonymous"></script>

        <!-- -------------- /Scripts -------------- -->

        <!-- Importar style select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/autosize.js/4.0.2/autosize.min.js"></script>
@endforeach
