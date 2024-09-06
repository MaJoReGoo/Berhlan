<?php
$server = '/Berhlan/public';
?>

@foreach ($DatosUsuario as $DatLog)

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Mejora continua | Crear reporte de no conformidad, accion correctiva
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

        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        
        <!-- Editor -->
        <script type="text/javascript" src="<?= $server ?>/panelfiles/ckeditor/ckeditor.js"></script>



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

            #eliminarFila-notificar {
                cursor: pointer;
                color: red;
            }

            .image-upload i {
                cursor: pointer;
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
                                        Crear reporte de acciones correctivas y/o mejoras.
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


                                <h6 style="background-color:#67d3e0; text-align: center;">
                                    INGRESE LA INFORMACION SOBRE EL REPORTE DE ACCIONES CORRECTIVAS Y/O MEJORAS -
                                    CONSECUTIVO - {{ $consecutivo }}
                                </h6>



                                <div class="allcp-form">
                                    <form id="insertarReporteNoConf" action="{{ route('insertarReporteNoConf') }}"
                                        method="post" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            <input type="text" hidden value="{{ $consecutivo }}"
                                                name = "consecutivo">
                                            <div class="col-md-4">

                                                <label style="color: #34495e" for = "sistema_gestion">
                                                    <b>
                                                        Sistema de Gestión:
                                                    </b>
                                                </label>
                                                <label class="field select">
                                                    <select name="sistema_gestion" id="sistema_gestion" required>
                                                        <option value="">
                                                            *Opcion
                                                        </option>
                                                        <option value="Sistema de gestión ambiental">
                                                            Sistema de gestión ambiental
                                                        </option>
                                                        <option value="Sistema de gestión de calidad">
                                                            Sistema de gestión de calidad
                                                        </option>
                                                        <option value="Sistema de gestión salud en el trabajo">
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
                                                    <select name="ciclo_auditoria" id="ciclo_auditoria" required>
                                                        <option value="">
                                                            *Opcion
                                                        </option>
                                                        <option value="Auditoria interna">
                                                            Auditoria interna
                                                        </option>
                                                        <option value="Auditoria externa">
                                                            Auditoria externa
                                                    </select>
                                                </label>

                                            </div>

                                            <div class="col-md-4">
                                                <label for="fecha_elaboracion" style="color: #34495e">
                                                    <b>
                                                        Fecha auditoría
                                                    </b>
                                                </label>

                                                <input type="date" name="fecha_auditoria" class="form-control"
                                                    max="{{ date('Y-m-d') }}" required>
                                            </div>


                                        </div>
                                        <br>
                                        <br>



                                        <div class="row">

                                            <div class="col-md-4">

                                                <label style="color: #34495e" for = "lugar_reporte">
                                                    <b>
                                                        Lugar:
                                                    </b>
                                                </label>

                                                <label class="field select">
                                                    <select name="lugar_reporte" id="lugar_reporte" required>
                                                        <option value="">
                                                            *Opcion
                                                        </option>
                                                        <option value="tebaida">
                                                            Tebaida
                                                        </option>
                                                        <option value="galapa">
                                                            Galapa
                                                        </option>
                                                        <option value="tocancipa">
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

                                                <input type="date" name="fecha_elaboracion" class="form-control"
                                                    max="{{ date('Y-m-d') }}" required>
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
                                                                name="fuente_razon" value="documentos normativos"
                                                                required>
                                                            <span class="radio"></span>
                                                            Documentos normativos
                                                        </label>
                                                        <label class="radio-button">
                                                            <input type="radio" id="fuente_razon"
                                                                name="fuente_razon" value="procesos" required>
                                                            <span class="radio"></span>
                                                            Procesos
                                                        </label>
                                                        <label class="radio-button">
                                                            <input type="radio" id="fuente_razon"
                                                                name="fuente_razon" value="procedimientos" required>
                                                            <span class="radio"></span>
                                                            Procedimientos
                                                        </label>
                                                        <label class="radio-button">
                                                            <input type="radio" id="fuente_razon"
                                                                name="fuente_razon" value="producto no conforme"
                                                                required>
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
                                                        <input type="radio" id="fuente_razon" name="fuente_razon"
                                                            value="quejas y reclamos" required>
                                                        <span class="radio"></span>
                                                        Quejas y Reclamos
                                                    </label>

                                                    <label class="radio-button">
                                                        <input type="radio" id="fuente_razon" name="fuente_razon"
                                                            value="auditoria interna" required>
                                                        <span class="radio"></span>
                                                        Auditoria interna
                                                    </label>
                                                    <label class="radio-button">
                                                        <input type="radio" id="fuente_razon" name="fuente_razon"
                                                            value="auditoria externa" required>
                                                        <span class="radio"></span>
                                                        Auditoria externa
                                                    </label>
                                                    <label class="radio-button">
                                                        <input type="radio" name="fuente_razon" value = 'otro'
                                                            required>
                                                        <span class="radio"></span>
                                                        Otro
                                                        <div id="cual"
                                                            style="display: flex; justify-content: center; align-items: center; gap:10px">
                                                            <b>
                                                                Cual?
                                                            </b>
                                                            <input type="text" name="fuente_otro"
                                                                style="width: 100%">
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


                                                <label style="color: #34495e">
                                                    <b>
                                                        Proceso No Conforme:
                                                    </b>
                                                </label>


                                                <label class="field select">
                                                    <select name="proceso_no_conforme" required>
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
                                            <div class="col-md-4">

                                                <label style="color: #34495e" for = "nombre_proceso_reporta">
                                                    <b>
                                                        Nombre del R de proceso que reporta la No
                                                        Conformidad (o del auditor líder):
                                                    </b>
                                                </label>
                                                <label class="field select">

                                                    <select name="nombre_proceso_reporta" required>
                                                        <option value="">
                                                            *Persona
                                                        </option>
                                                        @foreach ($Empleados as $DatEmp)
                                                            <option value="{{ $DatEmp->id_empleado }}">
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
                                                        <input type="radio" id="tipo_correctiva"
                                                            name="tipo_no_conformidad" value="correctiva">
                                                        <span class="radio" required></span>
                                                        Correctiva
                                                    </label>
                                                    <label class="radio-button">
                                                        <input type="radio" id="tipo_mejora"
                                                            name="tipo_no_conformidad" value="mejora" required>
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

                                                <textarea name="descrip_no_corformidad" id="descrip_no_corformidad"
                                                    style="width: 100%; border-radius: 4px;border-color: #e3e3e3" required></textarea>
                                            </div>

                                            <div class="col-md-6">
                                                <label style="color: #34495e">
                                                    <b>
                                                        Nombre / Cargo del Responsable de la No
                                                        Conformidad:
                                                    </b>
                                                </label>


                                                <label class="field select">
                                                    <select name="responsable_no_conformidad" required
                                                        style="width: 495px;">
                                                        <option value="">
                                                            *Persona
                                                        </option>
                                                        @foreach ($Empleados as $DatEmp)
                                                            <option value="{{ $DatEmp->id_empleado }}">
                                                                {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </label>



                                            </div>



                                        </div>
                                        <br>
                                        <br>


                                        <br>
                                        <br>

                                        <div class="row">

                                            <div class="box" style="display: flex;">
                                                <div class="col-md-10">
                                                    <table class="table table-bordered" id="form-table">
                                                        <thead style="background-color:#67d3e0;">
                                                            <tr>
                                                                <th scope="col"
                                                                    style="text-align: center; color:#34495e; ">
                                                                    Equipo de trabajo</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="table-2">
                                                            <tr>
                                                                <th scope="col"
                                                                    style="text-align: center; color:#34495e; ">
                                                                    | Persona - Cargo |</th>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">
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
                                                                </td>
                                                            </tr>
                                                        </tbody>

                                                    </table>
                                                    <a id="addRow-2" class="btn btn-primary">
                                                        <img src="{{ $server }}/images/agregar-boton.png"
                                                            alt="Añadir campo">
                                                        Añadir campo
                                                    </a>
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

                                                        <label
                                                            style="color: #34495e; display:flex; justify-content:center; ">
                                                            <b>
                                                                Impacto y Riesgo de la No
                                                                Conformidad: (Marque una opción)
                                                            </b>
                                                        </label>
                                                        <br>
                                                        <div class="box">
                                                            <label class="radio-button">
                                                                <input type="radio" id="impacto_bajo"
                                                                    name="impacto_no_conformidad" value="Bajo"
                                                                    required>
                                                                <span class="radio"></span>
                                                                Bajo
                                                            </label>
                                                            <label class="radio-button">
                                                                <input type="radio" id="impacto_medio"
                                                                    name="impacto_no_conformidad" value="Medio"
                                                                    required>
                                                                <span class="radio"></span>
                                                                Medio
                                                            </label>
                                                            <label class="radio-button">
                                                                <input type="radio" id="impacto_alto"
                                                                    name="impacto_no_conformidad" value="Alto"
                                                                    required>
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

                                                    <div
                                                        style="background-color:#67d3e0; color:#34495e; text-align: center;">
                                                        Mano de Obra (personas: falta de
                                                        capacitación,
                                                        habilidades y destrezas, funciones no
                                                        definidas
                                                        etc.)
                                                    </div>
                                                    <textarea name="mano_de_obra" id="mano_de_obra"
                                                        style="width: 100%; border-radius: 4px;border-color: #e3e3e3;margin-bottom: 18px;"></textarea>

                                                </div>


                                                <div class="col-md-4">

                                                    <div
                                                        style="background-color:#67d3e0; color:#34495e; text-align: center;">
                                                        Maquinaria (Equipos: falta de
                                                        mantenimiento preventivo,
                                                        deficiencia en infraestructura,
                                                        falta de inspecciones a equipos
                                                        etc.)
                                                    </div>

                                                    <textarea name="maquinaria" id="maquinaria"
                                                        style="width: 100%; border-radius: 4px;border-color: #e3e3e3;margin-bottom: 18px;"></textarea>

                                                </div>

                                                <div class="col-md-4">


                                                    <div
                                                        style="background-color:#67d3e0; color:#34495e; text-align: center;">
                                                        Método (falta de definición en
                                                        procesos y/o procedimientos,
                                                        documentación no adecuada etc.)
                                                    </div>

                                                    <textarea name="metodo" id="metodo"
                                                        style="width: 100%; border-radius: 4px;border-color: #e3e3e3;margin-bottom: 18px;"></textarea>

                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-4">

                                                    <div
                                                        style="background-color:#67d3e0; color:#34495e; text-align: center;">
                                                        Materiales (falta de definición
                                                        especificaciones de materia prima,
                                                        incumplimiento en verificación de
                                                        especificaciones etc.)
                                                    </div>

                                                    <textarea name="materiales" id="materiales"
                                                        style="width: 100%; border-radius: 4px;border-color: #e3e3e3;margin-bottom: 18px;"></textarea>
                                                    </label>

                                                </div>
                                                <div class="col-md-4">
                                                    <div
                                                        style="background-color:#67d3e0; color:#34495e; text-align: center;">
                                                        Medio Ambiente (Ambiente de trabajo:
                                                        ruido, luz, condiciones de
                                                        infraestructura etc.)
                                                    </div>


                                                    <textarea name="medio_ambiente" id="medio_ambiente"
                                                        style="width: 100%; border-radius: 4px;border-color: #e3e3e3;margin-bottom: 18px;"></textarea>

                                                </div>
                                                <div class="col-md-4">
                                                    <div
                                                        style="background-color:#67d3e0; color:#34495e; text-align: center;">
                                                        Otros Factores

                                                    </div>

                                                    <textarea name="otros_factores" id="otros_factores"
                                                        style="width: 100%; border-radius: 4px;border-color: #e3e3e3; margin-bottom: 18px;"></textarea>

                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <br>
                                            <div class="row">
                                                <div class="box" style="display: flex">
                                                    <div class="col-md-10" id="id_table_2"
                                                        style= "padding-right: 60px;">

                                                        <table class="table table-bordered">
                                                            <thead style="background-color: #67d3e0; color:#34495e">
                                                                <tr>
                                                                    <th colspan="5" style="text-align: center;">
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
                                                                    <th></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody id='table-3'>

                                                                <tr>
                                                                    <td style=" width: 120px;">
                                                                        <input type="text" class="form-control"
                                                                            id="plan_accion_n" name="plan_accion_n#[]"
                                                                            readonly>
                                                                    </td>
                                                                    <td style=" width: 250px;">
                                                                        <input type="text" class="form-control"
                                                                            name="plan_accion_actividad[]">
                                                                    </td>
                                                                    <td>
                                                                        <label class="field select">
                                                                            <select name="plan_accion_responsable[]">
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
                                                                    </td>
                                                                    <td style="width: 50px;">
                                                                        <input type="date"
                                                                            name="plan_accion_fecha_tarea[]"
                                                                            class="form-control">
                                                                    </td>


                                                                    <td style="width:25px"></td>

                                                                </tr>
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
                                                <div class="col-md-12" style="overflow-x: auto;">
                                                    <table class="table table-bordered">
                                                        <thead style="background-color: #67d3e0; color:#34495e">
                                                            <tr>
                                                                <th colspan="7" style="text-align: center;">
                                                                    Seguimiento al Plan de
                                                                    Acción
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th>Fecha del Seguimiento</th>
                                                                <th>No.</th>
                                                                <th>Actividad/Tareas
                                                                    Ejecutadas
                                                                </th>
                                                                <th>Compromisos y/o Pendientes</th>
                                                                <th>Responsable del
                                                                    Seguimiento
                                                                </th>
                                                                <th>Adjuntar</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id='table-4'>
                                                            <tr>
                                                                <td><input type="date" class="form-control"
                                                                        name="seguimiento_plan_fecha[]">
                                                                </td>
                                                                <td>
                                                                    <label class="field select">
                                                                        <select name="seguimiento_plan_n#[]"
                                                                            style="width:120px">
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
                                                                        style="width: 250px; border-radius: 4px;border-color: #e3e3e3;"></textarea>

                                                                </td>
                                                                <td>

                                                                    <textarea name="seguimiento_plan_compromisos[]" id="seguimiento_plan_compromisos"
                                                                        style="width: 250px; border-radius: 4px;border-color: #e3e3e3;"></textarea>

                                                                </td>
                                                                <td>
                                                                    <label class="field select"
                                                                        for="seguimiento_plan_responsable"
                                                                        style="width: 250px;">
                                                                        <select name="seguimiento_plan_responsable[]">
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
                                                                </td>
                                                                <td style="width: 75px;">
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

                                                                <td style="width:25px"></td>
                                                            </tr>

                                                        </tbody>

                                                    </table>
                                                    <a id="addRow-4" class="btn btn-primary">
                                                        <img src="{{ $server }}/images/agregar-boton.png"
                                                            alt="Añadir campo">
                                                        Añadir campo
                                                    </a>
                                                </div>

                                            </div>

                                            <br>
                                            <br>

                                            <div class="row">
                                                <div class="col-md-12" style="padding-right: 60px; ">
                                                    <table class="table table-bordered">
                                                        <thead style="background-color: #67d3e0; color:#34495e">
                                                            <tr>
                                                                <th colspan="7" style="text-align: center;">
                                                                    Verificación de Implementación
                                                                    de
                                                                    Acción(es)
                                                                    Correctiva(s) y/o Mejora(s)
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th>Fecha de Verificación
                                                                </th>
                                                                <th>Observaciones
                                                                </th>
                                                                <th>
                                                                    Nombre del Responsable / Cargo
                                                                    de
                                                                    Verificación
                                                                </th>
                                                                <th>Adjuntar</th>

                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id='table-5'>

                                                            <tr>
                                                                <td style="width: 50px;"><input type="date"
                                                                        name="verifica_implementacion_fecha[]"
                                                                        class="form-control" required>
                                                                </td>
                                                                <td id="table" style="width: 350px">

                                                                    <textarea name="verifica_implementacion_observa[]" style="width: 100%; border-radius: 4px;border-color: #e3e3e3;"
                                                                        required></textarea>

                                                                </td>
                                                                <td>
                                                                    <label class="field select">
                                                                        <select
                                                                            name="verifica_implementacion_responsable[]"
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
                                                                    </label>
                                                                </td>
                                                                <td style="width: 75px;">
                                                                    <div class="image-upload">
                                                                        <label
                                                                            style="display: flex; align-items: center;justify-content: center;">
                                                                            <i class="fas fa-file-upload"
                                                                                style="font-size: 30px"></i>
                                                                        </label>

                                                                        <input type="file"
                                                                            name="verifica_imple_archivos[]" />
                                                                    </div>
                                                                </td>

                                                                <td style="width:25px"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <a id="addRow-5" class="btn btn-primary">
                                                        <img src="{{ $server }}/images/agregar-boton.png"
                                                            alt="Añadir campo">
                                                        Añadir campo
                                                    </a>
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
                                                                <td style="width: 200px;">
                                                                    Programada
                                                                    para Cerrar en:</td>

                                                                <td style="width: 50px;"><input type="date"
                                                                        name="prog_cierre_fecha" class="form-control"
                                                                        required>
                                                                </td>
                                                                <td>
                                                                    <label class="field select">
                                                                        <select name="prog_cierre_responsable"
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
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 200px;">Cerrada
                                                                    Realmente en:</td>
                                                                <td style="width: 50px;"><input type="date"
                                                                        name="cierre_real_fecha" class="form-control"
                                                                        required>
                                                                </td>
                                                                <td>
                                                                    <label class="field select">
                                                                        <select name="cierre_real_responsable"
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
                                                                    </label>
                                                                </td>
                                                            </tr>


                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label style="color: #34495e">
                                                        <b>
                                                            Notificar a:
                                                        </b>
                                                    </label>

                                                    <div class="notificar"
                                                        style="display: flex; flex-direction: column; gap:10px;">
                                                        <div class="div">
                                                            <label class="field select">
                                                                <select name="notificar[]" required
                                                                    style="width: 495px;">
                                                                    <option value="">
                                                                        *Persona
                                                                    </option>
                                                                    @foreach ($Empleados as $DatEmp)
                                                                        <option value="{{ $DatEmp->id_empleado }}">
                                                                            {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <a id="addRow-notificar" class="btn btn-primary">
                                                        <img src="{{ $server }}/images/agregar-boton.png"
                                                            alt="Añadir campo">
                                                        Añadir campo
                                                    </a>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <br>
                                            <div class="box" style="justify-content:flex-end">
                                                <button id="btn_adjuntar" type="submit"
                                                    class="btn btn-primary mb-2">
                                                    <img src="{{ $server }}/images/agregar-boton.png">
                                                    Ingresar reporte de no conformidad
                                                    </img>
                                                </button>
                                            </div>
                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>
                </section>
            </section>
        </div>

        <!-- -------------- Scripts -------------- -->

        <script>
            $(document).ready(function($) {
                let consecutivo = '<?= $consecutivo ?>';
                let incrementable = 1;

                $('#plan_accion_n').val(consecutivo + '-' + incrementable);
                let arregloNumerico = [];
                arregloNumerico.push(consecutivo + '-' + incrementable);
                autosize($('textarea'));
                let input = $('#cual');
                input.hide();

                function valuesSelect() {
                    $('#table-4 select[name="seguimiento_plan_n#[]"]').each(function() {
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
                    one: '<div class="div"> <label class="field select" style="display: flex; align-items: center;"> <select name="notificar[]" required> <option value=""> *Persona </option> @foreach ($Empleados as $DatEmp) <option value="{{ $DatEmp->id_empleado }}"> {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}</option> @endforeach </select> <a id ="eliminarFila-notificar" style=" cursor:pointer; margin-left: 10px;"><i class="fa-regular fa-trash-can fa-xl"></i></a> </label> </div>',
                    two: '<tr>' +
                        '<th  ><label class="field select" style="display: flex; align-items: center;"><select class = "selector" name="persona_equipo[]" required><option style="text-align: center" value="">Persona</option> @foreach ($Empleados as $DatEmp) <option value="{{ $DatEmp->id_empleado }}"> {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}</option> @endforeach </select>' +
                        '<a id ="eliminarFila-2" style = "color:red; margin-left:10px;cursor:pointer;"><i class="fa-regular fa-trash-can fa-xl"></i></a></label>' +
                        '</th>' +
                        '</tr>',
                    three: '<tr>' +
                        `<td><input type="text" class="form-control" id "plan_accion_n" name="plan_accion_n#[]" required readonly></td><td><input type="text" class="form-control" name="plan_accion_actividad[]" required></td><td ><label class="field select"><select name="plan_accion_responsable[]" required><option style="text-align: center" value="">Persona</option>@foreach ($Empleados as $DatEmp) <option value="{{ $DatEmp->id_empleado }}"> {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }} </option> @endforeach</select></label></td><td style = "display: flex; align-items: center;"><input type="date" name="plan_accion_fecha_tarea[]"class="form-control" required> ` +
                        '<td style="width:25px"> <a id ="eliminarFila-3" style = "color:red; cursor:pointer;"><i class="fa-regular fa-trash-can fa-xl"></i></a>' +
                        '</td>' +
                        '</tr>',
                    four: '<tr>' +
                        '<td><input type="date" class="form-control" name="seguimiento_plan_fecha[]" required> </td> <td><label class="field select"> <select name="seguimiento_plan_n#[]"> <option style="text-align: center" value=""> Seleccione un plan de accion </option> </select> </label> </td> <td> <label class="field select" for="seguimiento_plan_descrip"> <textarea name="seguimiento_plan_descrip[]" style="width: 100%; border-radius: 4px;border-color: #e3e3e3;margin-bottom: 18px;"required></textarea> </label> </td> <td> <textarea name="seguimiento_plan_compromisos[]" style="width: 100%; border-radius: 4px;border-color: #e3e3e3; required"></textarea>  </td> <td> <label class="field select" for="seguimiento_plan_responsable"> <select name="seguimiento_plan_responsable[]" required> <option style="text-align: center" value=""> Persona </option> @foreach ($Empleados as $DatEmp) <option value="{{ $DatEmp->id_empleado }}"> {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }} </option> @endforeach </select> </label></td><td style="width: 75px;"> <div class="image-upload"> <label style="display: flex; align-items: center;justify-content: center;"> <i class="fas fa-file-upload" style="font-size: 30px"></i> </label> <input type="file" name="segui_plan_archivos[]" /> </div> ' +
                        '<td style="width:25px"><a id ="eliminarFila-4" style = "color:red; cursor:pointer;" ><i class="fa-regular fa-trash-can fa-xl"></i></a>' +
                        '</td>' +
                        '</tr>',
                    five: '<tr>' +
                        '<td style="width: 50px;"><input type="date" name="verifica_implementacion_fecha[]" class="form-control" required > </td> <td> <textarea name="verifica_implementacion_observa[]" id="corretiv_descrip" style="width: 100%; border-radius: 4px;border-color: #e3e3e3;" required></textarea>  </td> <td> <label class="field select"> <select name="verifica_implementacion_responsable[]" required> <option style="text-align: center" value=""> Persona </option> @foreach ($Empleados as $DatEmp) <option value="{{ $DatEmp->id_empleado }}"> {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}</option> @endforeach </select> </label></td> <td style="width: 75px;"> <div class="image-upload"> <label  style="display: flex; align-items: center;justify-content: center;"> <i class="fas fa-file-upload" style="font-size: 30px"></i> </label> <input type="file" name="verifica_imple_archivos[]" /> </div>   ' +
                        '<td><a id ="eliminarFila-5" style = "color:red; cursor:pointer;" ><i class="fa-regular fa-trash-can fa-xl"></i></a></td>' +
                        '</td>' +
                        '</tr>',
                }

                function addRows(number, row) {
                    $(`#addRow-${number}`).click(function() {
                        console.log('hola');
                        if (number === 3) {
                            incrementable++;
                            let newRow = $(row);
                            newRow.find('input[name="plan_accion_n#[]"]').val(consecutivo + '-' +
                                incrementable);
                            arregloNumerico.push(consecutivo + '-' + incrementable);
                            $(`#table-${number}`).append(newRow);
                            valuesSelect();
                        } else {
                            console.log($(`tbody #table-${number}`));
                            $(`#table-${number}`).append(row);
                        }
                        if (number === 4) {
                            valuesSelect();
                        }
                        $('select').select2({
                            closeOnSelect: true,
                            width: '100%',
                            theme: 'none'
                        });
                        autosize($('textarea'));
                    });

                    $(`#table-${number}`).on('click', `#eliminarFila-${number}`, function() {
                        if (number === 3) {
                            const posicion = arregloNumerico.indexOf($(this).closest('tr').find(
                                'input[name="plan_accion_n#[]"]').val());
                            if (posicion !== -1) {
                                arregloNumerico.splice(posicion, 1);
                                $(this).closest('tr').remove();
                                incrementable--;
                                let tamañoArreglo = arregloNumerico.length;
                                arregloNumerico = [];
                                let value = 1;
                                let inputs = $('#table-3 input[name="plan_accion_n#[]"]');
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


                function addNotificar() {
                    $('#addRow-notificar').click(function() {
                        $('.notificar').append(rows.one);
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
                    });

                    $('.notificar').on('click', '#eliminarFila-notificar', function() {
                        $(this).closest('.div').remove();
                    });
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


                addRows(2, rows.two)
                addRows(3, rows.three)
                addRows(4, rows.four)
                addRows(5, rows.five)
                addNotificar();
                valuesSelect();

                $('input[type="radio"]').on('change', function() {
                    let input = $('#cual');
                    console.log($(this).val());
                    if ($(this).val() === 'otro') {
                        input.show();
                    } else {
                        input.hide();
                    }
                });

            });
        </script>




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
