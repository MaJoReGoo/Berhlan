<?php
$server = '/Berhlan/public';
?>

@foreach ($DatosUsuario as $DatLog)

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>
            Intranet | Mejora continua | Crear de tratamiento no conformidades
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

        {{-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" /> --}}


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

            #content.table-layout>div,
            #content.table-layout>section {
                padding: 0px;
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
                                        Crear tratamiento no conformidades
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
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr>
                                                <th style="background-color:#67d3e0; color:#34495e; text-align:left;">
                                                    Ingrese la información sobre el tratamiento de no conformidades - consecutivo {{$nuevoId}}
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="allcp-form">
                                                        <form id="insertarTratamientoNoConf"
                                                            action="{{ route('insertarTratamientoNoConf') }}"
                                                            method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <!--  -->

                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <input type="number"  value="{{$nuevoId}}" name="nuevoId" hidden>
                                                                    <label for="fecha_inconformidad"
                                                                        style="color: #34495e">
                                                                        <b>
                                                                            Fecha diligenciamiento
                                                                        </b>
                                                                    </label>

                                                                    <input type="date" name="fecha_diligencia_trata"
                                                                        class="form-control" max="{{ date('Y-m-d') }}"
                                                                        required>
                                                                </div>

                                                                <div class="col-md-4">

                                                                    <label style="color: #34495e" for = "lugar_trata">
                                                                        <b>
                                                                            Planta:
                                                                        </b>
                                                                    </label>

                                                                    <label class="field select">
                                                                        <select name="lugar_trata" id="lugar_trata"
                                                                            required>
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



                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Proceso Relacionado:
                                                                        </b>
                                                                    </label>


                                                                    <label class="field select">
                                                                        <select name="proceso_rela_trata"
                                                                            id="proceso_relacionado" required>
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
                                                            <br>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <br>
                                                                    <br>
                                                                    <div class="box"
                                                                        style="display: flex; justify-content: center;">

                                                                        <label class="radio-button">
                                                                            <input type="radio" id="inconfor_trata"
                                                                                name="inconfor_trata" value="producto"
                                                                                required>
                                                                            <span class="radio"></span>
                                                                            Producto
                                                                        </label>
                                                                        <label class="radio-button">
                                                                            <input type="radio" id="inconfor_trata"
                                                                                name="inconfor_trata"
                                                                                value="proceso relacionado" required>
                                                                            <span class="radio"></span>
                                                                            Proceso relacionado
                                                                        </label>
                                                                        <label class="radio-button">
                                                                            <input type="radio" id="inconfor_trata"
                                                                                name="inconfor_trata" value="otro"
                                                                                required>
                                                                            <span class="radio"></span>
                                                                            Otro
                                                                        </label>

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-5">
                                                                    <label for="descripcion_trata"
                                                                        style="color: #34495e">
                                                                        <b>
                                                                            1. Descripción de la no conformidad
                                                                        </b>
                                                                    </label>

                                                                    <textarea name="descripcion_trata" id="descripcion_trata"
                                                                        style="width: 100%; border-radius: 4px;border-color: #e3e3e3" required></textarea>

                                                                </div>
                                                            </div>
                                                            <br>
                                                            <br>

                                                            <div class="row">

                                                                <div class="col-md-5">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Detectado Por:
                                                                        </b>
                                                                    </label>

                                                                    <label class="field select">

                                                                        <select name="detectado_persona"
                                                                            class="select_dinamico" required>
                                                                            <option value="">
                                                                                Persona responsable
                                                                            </option>
                                                                            @foreach ($Empleados as $DatEmp)
                                                                                <option
                                                                                    value="{{ $DatEmp->id_empleado }}">
                                                                                    {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido }}{{ $DatEmp->descripcion }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </label>
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <label for="fecha_detectada"
                                                                        style="color: #34495e">
                                                                        <b>
                                                                            Fecha del evento
                                                                        </b>
                                                                    </label>

                                                                    <input type="date" name="fecha_evento_trata"
                                                                        class="form-control" max="{{ date('Y-m-d') }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Responsable de dar tratamiento:
                                                                        </b>
                                                                    </label>

                                                                    <div class="responsables"
                                                                        style="display: flex; flex-direction: column; gap:10px;">
                                                                        <div class="div" style="display: flex">
                                                                            <label class="field select">
                                                                                <select name="responsable_trata[]"
                                                                                    required class="select_dinamico"
                                                                                    style="width: 95%;">
                                                                                    <option value="">
                                                                                        Persona responsable
                                                                                    </option>
                                                                                    @foreach ($Empleados as $DatEmp)
                                                                                        <option
                                                                                            value="{{ $DatEmp->id_empleado }}">
                                                                                            {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <a id="addRow-persona" class="btn btn-primary">
                                                                        <img src="{{ $server }}/images/agregar-boton.png"
                                                                            alt="Añadir campo">
                                                                        Añadir campo
                                                                    </a>

                                                                </div>

                                                                <div class="col-md-2">

                                                                    <label for="fecha_responsable"
                                                                        style="color: #34495e">
                                                                        <b>
                                                                            Fecha estimada del tratamiento
                                                                        </b>
                                                                    </label>

                                                                    <input type="date" name="fecha_esti_trata"
                                                                        class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <div class="tratamientos">
                                                                <div class="row">
                                                                    <div class="col-md-5">
                                                                        <label style="color: #34495e">
                                                                            <b>
                                                                                2. TRATAMIENTO AL PRODUCTO O SERVICIO NO
                                                                                CONFORME:
                                                                            </b>
                                                                        </label>

                                                                        <div class="box"
                                                                            style="display: flex; justify-content: center;">

                                                                            <label class="radio-button">
                                                                                <input type="radio"
                                                                                    name="tratamiento0"
                                                                                    value="Reproceso" required>
                                                                                <span class="radio"></span>
                                                                                Reproceso
                                                                            </label>
                                                                            <label class="radio-button">
                                                                                <input type="radio"
                                                                                    name="tratamiento0"
                                                                                    value="Reclasificacion" required>
                                                                                <span class="radio"></span>
                                                                                Reclasificación
                                                                            </label>
                                                                            <label class="radio-button">
                                                                                <input type="radio"
                                                                                    name="tratamiento0"
                                                                                    value="Rechazo" required>
                                                                                <span class="radio"></span>
                                                                                Rechazo
                                                                            </label>

                                                                        </div>
                                                                        <div class="box"
                                                                            style="display: flex; justify-content: center;">
                                                                            <label class="radio-button">
                                                                                <input type="radio"
                                                                                    name="tratamiento0"
                                                                                    value="Derogacion" required>
                                                                                <span class="radio"></span>
                                                                                Derogación
                                                                            </label>
                                                                            <label class="radio-button">
                                                                                <input type="radio"
                                                                                    name="tratamiento0" value="otro"
                                                                                    required>
                                                                                <span class="radio"></span>
                                                                                Otro

                                                                            </label>
                                                                            <div id="0" hidden>

                                                                                <label>
                                                                                    <b>
                                                                                        Cual?
                                                                                    </b>
                                                                                </label>

                                                                                <input type="text"
                                                                                    name="otrotratamiento0"
                                                                                    style="width: 100%">
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-md-3">
                                                                        <br>
                                                                        <label for="descripcion_inme_trata"
                                                                            style="color: #34495e">
                                                                            <b>Descripción del tratamiento inmediato
                                                                                dado</b>
                                                                        </label>

                                                                        <textarea name="descripcion_inme_trata[]" id="descripcion_tratamiento"
                                                                            style="width: 100%; border-radius: 4px;border-color: #e3e3e3"></textarea>

                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <br>
                                                                        <label style="color: #34495e">
                                                                            <b>
                                                                                Responsable:
                                                                            </b>
                                                                        </label>

                                                                        <label class="field select">

                                                                            <select name="persona_trata[]"
                                                                                class="select_dinamico">
                                                                                <option value="">
                                                                                    Persona responsable
                                                                                </option>
                                                                                @foreach ($Empleados as $DatEmp)
                                                                                    <option
                                                                                        value="{{ $DatEmp->id_empleado }}">
                                                                                        {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </label>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <a id="addRow-tratamiento" style="margin-left: 11px;"
                                                                class="btn btn-primary">
                                                                <img src="{{ $server }}/images/agregar-boton.png"
                                                                    alt="Añadir campo">
                                                                Añadir campo
                                                            </a>

                                                            <br>
                                                            <br>
                                                            <br>

                                                            <div class="container mt-4">
                                                                <h4 class="mb-4"style="text-align: center">
                                                                    CARACTERIZACION DE LA NO CONFORMIDAD
                                                                    (CRITERIO DE ACUERDO CON EL RIESGO)
                                                                    INDICADOR DEL PROCESO RELACIONADO EN EL
                                                                    INCUMPLIMIENTO DE REQUISITO.

                                                                </h4>
                                                                <br>
                                                                <div
                                                                    class="table-responsive"style="overflow-y: hidden;">
                                                                    <table class="table table-bordered"
                                                                        id="niveles">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>
                                                                                    <label class="radio-button">

                                                                                        Bajo
                                                                                    </label>
                                                                                </th>
                                                                                <th>
                                                                                    <label class="radio-button">
                                                                                        Medio
                                                                                    </label>

                                                                                </th>
                                                                                <th><label class="radio-button">
                                                                                        Alto
                                                                                    </label>
                                                                                </th>
                                                                                <th>
                                                                                    <label class="radio-button">

                                                                                        Muy alto
                                                                                    </label>
                                                                                </th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="DESCONOCIMIENTO DE PROTOCOLOS POR ENTRENAMIENTO O INDUCCION EN CURSO."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 45px;"></span>
                                                                                        DESCONOCIMIENTO DE PROTOCOLOS
                                                                                        POR
                                                                                        ENTRENAMIENTO O INDUCCION EN
                                                                                        CURSO.
                                                                                    </label>

                                                                                </td>

                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="AREAS Y EQUIPOS NO IDENTIFICADOS."
                                                                                            required>
                                                                                        <span class="radio"></span>
                                                                                        AREAS Y EQUIPOS NO
                                                                                        IDENTIFICADOS.

                                                                                    </label>

                                                                                </td>

                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="INCUMPLIMIENTO BPM DURANTE PROCESOS OPERATIVOS. (PERSONAL, AREAS, EQUIPOS,HERRAMIENTAS, UTENSILIOS,INSTALACIONES FISICAS)."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 68px;"></span>
                                                                                        INCUMPLIMIENTO BPM DURANTE
                                                                                        PROCESOS
                                                                                        OPERATIVOS.
                                                                                        (PERSONAL, AREAS, EQUIPOS,
                                                                                        HERRAMIENTAS, UTENSILIOS,
                                                                                        INSTALACIONES FISICAS).
                                                                                    </label>
                                                                                </td>


                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="USO DE MATERIAS PRIMAS VENCIDAS Y/O INSUMOS SIN HOMOLOGACION. SIN IDENTIFICACION."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 47px;"></span>
                                                                                        USO DE MATERIAS PRIMAS VENCIDAS
                                                                                        Y/O
                                                                                        INSUMOS SIN HOMOLOGACION.
                                                                                        SIN IDENTIFICACION.
                                                                                    </label>

                                                                                </td>
                                                                            </tr>

                                                                            <tr>

                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="INCUMPLIMIENTO DE NORMAS POR REALIZAR ACTIVIDADES AJENAS A SU PROCESO."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 45px;"></span>
                                                                                        INCUMPLIMIENTO DE NORMAS POR
                                                                                        REALIZAR ACTIVIDADES AJENAS A SU
                                                                                        PROCESO.
                                                                                    </label>
                                                                                </td>
                                                                                <td>

                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="IMPLEMENTOS DE ASEO INSUFICIENTES, MAL UBICADOS, SUCIOS Y EN MAL ESTADO."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 45px;"></span>
                                                                                        IMPLEMENTOS DE ASEO
                                                                                        INSUFICIENTES,
                                                                                        MAL UBICADOS, SUCIOS Y EN MAL
                                                                                        ESTADO.
                                                                                    </label>


                                                                                </td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="INCUMPLIMIENTO DE ORDEN Y LIMPIEZA DE ACUERDO CON ESTANDARES Y PROCEDIMIENTOS."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 45px;"></span>
                                                                                        INCUMPLIMIENTO DE ORDEN Y
                                                                                        LIMPIEZA
                                                                                        DE ACUERDO CON ESTANDARES Y
                                                                                        PROCEDIMIENTOS.
                                                                                    </label>

                                                                                </td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="NOTIFICACIONES SANITARIAS, PERMISOS O REGISTROS VENCIDOS O ERRONEOS."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 42px;"></span>
                                                                                        NOTIFICACIONES SANITARIAS,
                                                                                        PERMISOS
                                                                                        O REGISTROS VENCIDOS O ERRONEOS.

                                                                                    </label>

                                                                                </td>

                                                                            </tr>

                                                                            <tr>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="otro_bajo"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="otro" required>
                                                                                        <span class="radio"></span>
                                                                                        Otro
                                                                                        <textarea style="width: 200px;" id="otro_bajo" name="caracte_no_conformidad" disabled></textarea>
                                                                                    </label>
                                                                                </td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="INCUMPLIMIENTO NORMAS DE HIGIENE PERSONAL: LAVADO DE MANOS Y PRESENTACION PERSONAL."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 45px;"></span>
                                                                                        INCUMPLIMIENTO NORMAS DE HIGIENE
                                                                                        PERSONAL: LAVADO DE MANOS Y
                                                                                        PRESENTACION PERSONAL.
                                                                                    </label>

                                                                                </td>
                                                                                <td>

                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="INCUMPLIMIENTO EN LIMPIEZA Y DESINFECCION DE EQUIPOS SEGÚN FRECUENCIAS ESTABLECIDAS."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 45px;"></span>
                                                                                        INCUMPLIMIENTO EN LIMPIEZA Y
                                                                                        DESINFECCION DE EQUIPOS SEGÚN
                                                                                        FRECUENCIAS ESTABLECIDAS.
                                                                                    </label>
                                                                                </td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="EL BATCH RECORD NO SE EJECUTA EN TIEMPO REAL Y NO SE VERIFICAN TODAS LAS ETAPAS DE PROCESO."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 45px;"></span>
                                                                                        EL BATCH RECORD NO SE EJECUTA EN
                                                                                        TIEMPO REAL Y NO SE VERIFICAN
                                                                                        TODAS
                                                                                        LAS ETAPAS DE PROCESO.
                                                                                    </label>

                                                                                </td>


                                                                            </tr>

                                                                            <tr>
                                                                                <td>-----</td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="NO EJECUCION DE LOS REGISTROS DE LIMPIEZA Y DESINFECCION EN TIEMPO REAL."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 45px;"></span>
                                                                                        NO EJECUCION DE LOS REGISTROS DE
                                                                                        LIMPIEZA Y DESINFECCION EN
                                                                                        TIEMPO
                                                                                        REAL.
                                                                                    </label>
                                                                                </td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="MAL MANEJO DE SOBRANTES, PRODUCTO NO CONFORME: RECIPIENTES SIN IDENTIFICAR DE ACUERDO CON ESTANDAR."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 60px;"></span>
                                                                                        MAL MANEJO DE SOBRANTES,
                                                                                        PRODUCTO NO
                                                                                        CONFORME: RECIPIENTES SIN
                                                                                        IDENTIFICAR DE ACUERDO CON
                                                                                        ESTANDAR.
                                                                                    </label>

                                                                                </td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="INCUMPLIMIENTO A DIGRAMAS DE FLUJO Y REGISTRO DE PCC."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 35px;"></span>
                                                                                        INCUMPLIMIENTO A DIGRAMAS DE
                                                                                        FLUJO Y
                                                                                        REGISTRO DE PCC.
                                                                                    </label>

                                                                                </td>

                                                                            </tr>

                                                                            <tr>
                                                                                <td>-----</td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="ESTIBAS Y ESTANTERIAS SUCIAS, EN MAL ESTADO."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 28px;"></span>
                                                                                        ESTIBAS Y ESTANTERIAS SUCIAS, EN
                                                                                        MAL
                                                                                        ESTADO.
                                                                                    </label>
                                                                                </td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="PERDIDA DE TRAZABILIDAD."
                                                                                            required>
                                                                                        <span class="radio"></span>
                                                                                        PERDIDA DE TRAZABILIDAD.
                                                                                    </label>
                                                                                </td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="INCUMPLIMIENTO AL DESPEJE DE AREA, LINEA Y ETAPA DE PROCESO."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 40px;"></span>
                                                                                        INCUMPLIMIENTO AL DESPEJE DE
                                                                                        AREA,
                                                                                        LINEA Y ETAPA DE PROCESO.
                                                                                    </label>
                                                                                </td>


                                                                            </tr>

                                                                            <tr>
                                                                                <td>-----</td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="ESTADOS DE CONTROL DE PROCESO SIN ACTUALIZAR."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 28px;"></span>
                                                                                        ESTADOS DE CONTROL DE PROCESO
                                                                                        SIN
                                                                                        ACTUALIZAR.
                                                                                    </label>
                                                                                </td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="EQUIPOS CON CARACTERISTICAS DE DETERIORO, DAÑO O CONDICIONES SANITARIAS DEFICIENTES."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 45px;"></span>
                                                                                        EQUIPOS CON CARACTERISTICAS DE
                                                                                        DETERIORO, DAÑO O CONDICIONES
                                                                                        SANITARIAS DEFICIENTES.
                                                                                    </label>
                                                                                </td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="NO CUMPLIMIENTO DE ESPECIFICACIONES EN FICHA TECNICA (PARAMETROS DE DISEÑO)"
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 45px;"></span>
                                                                                        NO CUMPLIMIENTO DE
                                                                                        ESPECIFICACIONES
                                                                                        EN FICHA TECNICA (PARAMETROS DE
                                                                                        DISEÑO)
                                                                                    </label>
                                                                                </td>

                                                                            </tr>

                                                                            <tr>

                                                                                <td>-----</td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="SERVICIOS INDUSTRIALES INEFICIENTES (AIRE ACONDICINADO, EXTRACTORES,PRESION DE AGUA, ETC)."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 48px;"></span>
                                                                                        SERVICIOS INDUSTRIALES
                                                                                        INEFICIENTES
                                                                                        (AIRE ACONDICINADO, EXTRACTORES,
                                                                                        PRESION DE AGUA, ETC).
                                                                                    </label>
                                                                                </td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="EQUIPOS DE MEDICION SIN VERIFICACION O CALIBRACION."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 35px;"></span>
                                                                                        EQUIPOS DE MEDICION SIN
                                                                                        VERIFICACION
                                                                                        O CALIBRACION.
                                                                                    </label>
                                                                                </td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="DOCUMENTACION OBSOLETA, PROCESOS SIN DOCUMENTAR."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 35px;"></span>
                                                                                        DOCUMENTACION OBSOLETA, PROCESOS
                                                                                        SIN
                                                                                        DOCUMENTAR.
                                                                                    </label>

                                                                                </td>


                                                                            </tr>
                                                                            <tr>

                                                                                <td>-----</td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="otro_medio"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="otro" required>
                                                                                        <span class="radio"></span>
                                                                                        Otro
                                                                                        <textarea style="width: 200px;" id="otro_medio" name="caracte_no_conformidad" disabled></textarea>
                                                                                    </label>
                                                                                </td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="PERSONAL NO IDONEO PARA EL PROCESO: SIN ENTRENAMIENTO /FORMACION."
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 40px;"></span>
                                                                                        PERSONAL NO IDONEO PARA EL
                                                                                        PROCESO:
                                                                                        SIN ENTRENAMIENTO /FORMACION

                                                                                    </label>
                                                                                </td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="NO CUMPLIMIENTO NORMATIVIDAD VIGENTE (DECS. 721 - 833)"
                                                                                            required>
                                                                                        <span class="radio"
                                                                                            style="width: 34px;"></span>
                                                                                        NO CUMPLIMIENTO NORMATIVIDAD
                                                                                        VIGENTE
                                                                                        (DECS. 721 - 833)
                                                                                    </label>

                                                                                </td>


                                                                            </tr>
                                                                            <tr>
                                                                                <td>-----</td>
                                                                                <td>-----</td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="INCUMPLIMIENTO POR PQRS."
                                                                                            required>
                                                                                        <span class="radio"></span>
                                                                                        INCUMPLIMIENTO POR PQRS.
                                                                                    </label>
                                                                                </td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="CONTAMINACION CRUZADA."
                                                                                            required>
                                                                                        <span class="radio"></span>
                                                                                        CONTAMINACION CRUZADA.
                                                                                    </label>
                                                                                </td>

                                                                            </tr>
                                                                            <tr>
                                                                                <td>-----</td>
                                                                                <td>-----</td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="otro_alto"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="otro" required>
                                                                                        <span class="radio"></span>
                                                                                        Otro
                                                                                        <textarea name="caracte_no_conformidad" id="otro_alto" style="width: 200px;" disabled></textarea>
                                                                                    </label>
                                                                                </td>

                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="otro_muyalto"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="otro" required>
                                                                                        <span class="radio"></span>
                                                                                        Otro
                                                                                        <textarea name="caracte_no_conformidad" id="otro_muyalto" style="width: 200px;" disabled></textarea>
                                                                                    </label>
                                                                                </td>

                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <input type="text" name="nivel_conformidad" id = "nivel_conformidad" hidden >
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <br>


                                                            <div class="row">

                                                                <div class="col-md-3">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            4. Verificación Y cierre
                                                                        </b>
                                                                    </label> <br>

                                                                    <label for="fecha_veri_cierre"
                                                                        style="color: #34495e">
                                                                        <b>
                                                                            Fecha de seguimiento y cierre :
                                                                        </b>
                                                                    </label>

                                                                    <input type="date" name="fecha_veri_cierre"
                                                                        class="form-control" required>
                                                                </div>



                                                                <div class="col-md-6">

                                                                    <br>
                                                                    <br>
                                                                    <br>

                                                                    <label class="field select"
                                                                        for="seg_realizado_responsable"><b>
                                                                            Realizado por:
                                                                        </b>
                                                                        <select name="veri_cierre_responsable"
                                                                            id="veri_cierre_responsable"
                                                                            class="select_dinamico" required>
                                                                            <option value="">
                                                                                *Persona
                                                                            </option>
                                                                            @foreach ($Empleados as $DatEmp)
                                                                                <option
                                                                                    value="{{ $DatEmp->id_empleado }}">
                                                                                    {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}
                                                                                </option>
                                                                            @endforeach

                                                                        </select>
                                                                    </label>

                                                                </div>



                                                                <div class="col-md-3">
                                                                    <br>
                                                                    <br>

                                                                    <label style="color: #34495e" for="opciones">
                                                                        <b>
                                                                            ¿El tratamiento fue eficaz?
                                                                        </b>
                                                                    </label>

                                                                    <div class="box">
                                                                        <label class="radio-button"
                                                                            for="si_opciones_tratamiento">
                                                                            <input type="radio"
                                                                                id="si_opciones_tratamiento"
                                                                                name="eficaz_tratamiento"
                                                                                value="si" required>
                                                                            <span class="radio"></span>
                                                                            Sí
                                                                        </label>
                                                                        <label class="radio-button">
                                                                            <input type="radio"
                                                                                id="no_opciones_tratamiento"
                                                                                name="eficaz_tratamiento"
                                                                                value="no" required>
                                                                            <span class="radio"></span>
                                                                            No
                                                                        </label>
                                                                    </div>

                                                                </div>



                                                            </div>
                                                            <br>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <br>
                                                                    <label for="conclusion_final"
                                                                        style="color: #34495e">
                                                                        <b>CONCLUSION FINAL:</b>
                                                                    </label>

                                                                    <textarea name="conclusion_final" id="conclusion_final" style="width: 100%; border-radius: 4px;border-color: #e3e3e3"
                                                                        required></textarea>

                                                                </div>

                                                                <div class="col-md-4">
                                                                    <br>
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            EVIDENCIA SI APLICA:
                                                                        </b>
                                                                    </label>
                                                                     <label
                                                                        class="field prepend-icon append-button file">
                                                                        <span class="button">
                                                                            JPG
                                                                        </span>

                                                                        {!! Form::file('evidencia_aplica', [
                                                                            '',
                                                                            'id' => 'evidencia_aplica',
                                                                            'accept' => '.jpg',
                                                                            'class' => 'gui-file',
                                                                            'onChange' => "document.getElementById('uploader').value = this.value;",
                                                                        ]) !!}
                                                                        {!! Form::text('uploader', null, ['id' => 'uploader', 'class' => 'gui-input', 'placeholder' => 'Foto']) !!}
                                                                        <label class="field-icon">
                                                                            <i class="fa fa-cloud-upload"></i>
                                                                        </label>
                                                                    </label>
                                                                </div>

                                                            </div>
                                                            <br>
                                                            <br>
                                                            <br>

                                                            <div class="box" style="justify-content:flex-end">
                                                                <button id="btn_ingresar" type="submit"
                                                                    class="btn btn-primary mb-2">
                                                                    <img
                                                                        src="{{ $server }}/images/agregar-boton.png">
                                                                    Ingresar tratamiento de no conformidad
                                                                    </img>
                                                                </button>
                                                            </div>
                                                            <!--  -->
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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

                $('input[name="tratamiento0"]').on('change', function() {
                    let input = $('#0');
                    let labelText = $('label.radio-button:has(input[name="tratamiento0"]:checked)').text()
                        .trim();
                    if (labelText === 'Otro') {
                        input.show();
                        $('input[name="otrotratamiento0"]').prop('required', true);
                    } else {
                        input.hide();
                        $('input[name="otrotratamiento0"]').prop('required', false).val('');
                    }
                });

                $('input[name="otrotratamiento0"]').on('input', function() {
                    $('input[name="tratamiento0"]').val(($(this).val()));
                });



                function initializePlugins() {
                    $('select').select2({
                        closeOnSelect: true,
                        width: '100%',
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
                    autosize(document.querySelectorAll('textarea'));
                }
                let count = 0;


                function formatHtmlResponsable() {
                    let html = `<div class="div" style="display: flex; align-items: center;">
                   <label class="field select">
                       <select name="responsable_trata[]" required class="select_dinamico">
                           <option value="">Persona responsable</option>`;

                    html += `<!-- Agrega las opciones de empleados -->`;
                    html += `@foreach ($Empleados as $DatEmp)`;
                    html +=
                        `<option value="{{ $DatEmp->id_empleado }}">{{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}</option>`;
                    html += `@endforeach`;
                    html += `</select>
           </label>
           <a class="eliminarFila-persona" style="margin-left: 10px;">
               <i style = "color:red; cursor:pointer;" class="fa-regular fa-trash-can fa-xl"></i>
           </a>
       </div>`;
                    return html;
                }

                function formatHtmlTratamiento(count) {
                    let html = `
    <div class="row">
        <br>
        <div class="col-md-5">
            <label style="color: #34495e">
                <b>2. TRATAMIENTO AL PRODUCTO O SERVICIO NO CONFORME:</b>
            </label>
            <div class="box" style="display: flex; justify-content: center;">
                <label class="radio-button">
                    <input type="radio" name="tratamiento${count}" value="Reproceso" required>
                    <span class="radio"></span> Reproceso
                </label>
                <label class="radio-button">
                    <input type="radio" name="tratamiento${count}" value="Reclasificacion" required>
                    <span class="radio"></span> Reclasificación
                </label>
                <label class="radio-button">
                    <input type="radio"  name="tratamiento${count}" value="Rechazo" required>
                    <span class="radio"></span> Rechazo
                </label>
            </div>
            <div class="box" style="display: flex; justify-content: center;">
                <label class="radio-button">
                    <input type="radio" name="tratamiento${count}" value="Derogacion" required>
                    <span class="radio"></span> Derogación
                </label>
                <label class="radio-button">
                    <input type="radio"  name="tratamiento${count}" value="otro" required>
                    <span class="radio"></span> Otro


                </label>
                <div id="${count}" hidden>
                        <div>
                            <label>
                                <b> Cual? </b>
                                </label>

                        <input type="text" name="otrotratamiento${count}" style="width: 100%">
                        </div>
                    </div>
            </div>
        </div>
        <div class="col-md-3">
            <br>
            <label for="descripcion_inme_trata[]" style="color: #34495e">
                <b>Descripción del tratamiento inmediato dado</b>
            </label>
            <textarea name="descripcion_inme_trata[]" id="descripcion_tratamiento" style="width: 100%; border-radius: 4px; border-color: #e3e3e3"></textarea>
        </div>
        <div class="col-md-3">
            <br>
            <label style="color: #34495e">
                <b>Responsable:</b>
            </label>
            <label class="field select">
                <select name="persona_trata[]" class="select_dinamico">
                    <option value="">Persona responsable</option>`;

                    @foreach ($Empleados as $DatEmp)
                        html +=
                            `<option value="{{ $DatEmp->id_empleado }}">{{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}</option>`;
                    @endforeach

                    html += `</select></label>
        </div>
        <br><br>
        <div class="col-md-1" style="padding-top: 20px;">
            <a class="eliminarFila-tratamiento" style="margin-left: 10px;">
                <i style="color:red; cursor:pointer;" class="fa-regular fa-trash-can fa-xl"></i>
            </a>
        </div>
    </div>`;
                    return html;
                }



                function addResponsable() {
                    $('#addRow-persona').click(function() {
                        if ($('.responsables label').length === 3) {
                            $(this).hide();
                        }
                        const html = formatHtmlResponsable();
                        $('.responsables').append(html);
                        initializePlugins();
                    });

                    $('.responsables').on('click', '.eliminarFila-persona', function() {
                        $(this).closest('.div').remove();
                        if ($('.responsables label').length <= 3) {
                            $('#addRow-persona').show();
                        }
                    });
                }

                $('#niveles input[value="otro"]').on('click', function() {
                    $('#niveles textarea').prop('disabled', true);
                    $(`textarea[id='${$(this).attr('id')}']`).prop('disabled', false);
                    $('#nivel_conformidad').val($(this).attr('id'));
                });


                $('#niveles input[id="caracte_no_conformidad"]').on('click', function() {
                    $('#niveles textarea').prop('disabled', true);
                    $('#nivel_conformidad').val("");
                });



                function addTratamiento() {
                    $('#addRow-tratamiento').click(function() {
                        count++;
                        const html = formatHtmlTratamiento(count);
                        $('.tratamientos').append(html);
                        initializePlugins(); // Inicializa Select2 y autosize para el nuevo elemento

                        //Configurar evento de cambio para el nuevo tratamiento
                        for (let i = 1; i <= count; i++) {
                            $(`input[name='tratamiento${i}']`).off('change').on('change', function() {
                                let labelText = $(
                                        `label.radio-button:has(input[name="tratamiento${i}"]:checked)`)
                                    .text().trim();
                                let input = $(`#${i}`);
                                if (labelText === 'Otro') {
                                    input.show();
                                    $(`input[name="otrotratamiento${i}"]`).prop('required', true);
                                } else {
                                    input.hide();
                                    $(`input[name="otrotratamiento${i}"]`).prop('required', false).val(
                                        '');
                                }
                            });

                            $(`input[name="otrotratamiento${i}"]`).on('input', function() {
                                $(`input[name="tratamiento${i}"]`).val(($(this).val()));
                            });
                        }
                    });
                    // Delegación de eventos para eliminar un responsable
                    $('.tratamientos').on('click', '.eliminarFila-tratamiento', function() {
                        $(this).closest('.row').remove();
                    });
                }

                // Inicializa Select2 y autosize al cargar la página
                initializePlugins();
                // Agrega funcionalidad de agregar y eliminar responsables
                addResponsable();
                addTratamiento();
            });
        </script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/autosize.js/4.0.2/autosize.min.js"></script>

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
