<?php

?>

@foreach ($DatosUsuario as $DatLog)

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>
            Intranet | Inconformidades | Ver tratamiento no conformidad
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

        {{-- Importar styles y funcionamiento del Select2 --}}
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

        <script type="text/javascript" src="{{ asset ('/panelfiles/select2/dist/js/select2.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/select2/dist/css/select2.min.css')}}">

        <!-- Importar style select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<link rel="stylesheet" type="text/css" href="{{ asset ('/public/css/inconformidades/panelVerTratamientoNoConformidad.blade.css')}}">

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
                                <a href="{{ asset ('/panel/menu/118')}}" title="Inconformidades">
                                    <font color="#34495e">
                                        Mejora continua >
                                    </font>
                                    <font color="#b4c056">
                                        Consultar informes no conformidad >
                                    </font>
                                    <font color="#b4c056">
                                        Visualizar tratamiento no conformidad
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset ('/panel/menu/118')}}" class="btn btn-primary btn-sm ml10"
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
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="allcp-form">
                                                        <form id="updateTratamientoNoConf"
                                                            action="{{ route('updateTratamientoNoConf') }}"
                                                            method="post" enctype="multipart/form-data">
                                                            @csrf

                                                            <br>
                                                            <input type="text" name="id_tratamiento"
                                                                value="{{ $registro_tratamiento->id_tratamiento }}"
                                                                hidden>
                                                            <div class="row"
                                                                style = "display:flex;justify-content: flex-end;
                                                                    align-items: baseline; ">
                                                                    @if (Str::contains($empleado[0]->cargo, 'CALIDAD'))
                                                                    <a id="btn_editar" style="margin-right: 40px;"
                                                                    class="btn btn-primary mb-2">
                                                                    <img style="height: 35px" width="35px"
                                                                        src="{{ $server }}/images/editar-info.png">
                                                                    </img>
                                                                </a>
                                                                    @endif

                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-2">

                                                                    <label for="fecha_inconformidad"
                                                                        style="color: #34495e">
                                                                        <b>
                                                                            Fecha diligenciamiento
                                                                        </b>
                                                                    </label>

                                                                    <input type="date" name="fecha_diligencia_trata"
                                                                        class="form-control" max="{{ date('Y-m-d') }}"
                                                                        value="{{ \Carbon\Carbon::parse($registro_tratamiento->fecha_diligencia_trata)->format('Y-m-d') }}"
                                                                        required disabled>
                                                                </div>

                                                                <div class="col-md-4">

                                                                    <label style="color: #34495e" for = "lugar_trata">
                                                                        <b>
                                                                            Planta:
                                                                        </b>
                                                                    </label>

                                                                    <label class="field select">
                                                                        <select name="lugar_trata" id="lugar_trata"
                                                                            required disabled>
                                                                            <option value="">
                                                                                *Opcion
                                                                            </option>
                                                                            <option value="tebaida"
                                                                                {{ $registro_tratamiento->lugar_trata === 'tebaida' ? 'selected' : '' }}>
                                                                                Tebaida
                                                                            </option>
                                                                            <option value="galapa"
                                                                                {{ $registro_tratamiento->lugar_trata === 'galapa' ? 'selected' : '' }}>
                                                                                Galapa
                                                                            </option>
                                                                            <option value="tocancipa"
                                                                                {{ $registro_tratamiento->lugar_trata === 'tocancipa' ? 'selected' : '' }}>
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
                                                                            id="proceso_rela_trata" required disabled>
                                                                            <option value="">
                                                                                *Area
                                                                            </option>
                                                                            @foreach ($areas as $DatArea)
                                                                                <option value="{{ $DatArea->id_area }}"
                                                                                    {{ $DatArea->id_area === $registro_tratamiento->proceso_rela_trata ? 'selected' : '' }}>
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
                                                                                {{ $registro_tratamiento->inconfor_trata === 'producto' ? 'checked' : '' }}
                                                                                required disabled>
                                                                            <span class="radio"></span>
                                                                            Producto
                                                                        </label>
                                                                        <label class="radio-button">
                                                                            <input type="radio" id="inconfor_trata"
                                                                                name="inconfor_trata"
                                                                                value="proceso relacionado"
                                                                                {{ $registro_tratamiento->inconfor_trata === 'proceso relacionado' ? 'checked' : '' }}
                                                                                required disabled>
                                                                            <span class="radio"></span>
                                                                            Proceso relacionado
                                                                        </label>
                                                                        <label class="radio-button">
                                                                            <input type="radio" id="inconfor_trata"
                                                                                name="inconfor_trata" value="otro"
                                                                                {{ $registro_tratamiento->inconfor_trata === 'otro' ? 'checked' : '' }}
                                                                                required disabled>
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
                                                                        style="width: 100%; border-radius: 4px;border-color: #e3e3e3" required disabled> {{ $registro_tratamiento->descripcion_trata }} </textarea>

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
                                                                            class="select_dinamico" required disabled>
                                                                            <option value="">
                                                                                Persona responsable
                                                                            </option>
                                                                            @foreach ($Empleados as $DatEmp)
                                                                                <option
                                                                                    value="{{ $DatEmp->id_empleado }}"
                                                                                    {{ $DatEmp->id_empleado == $registro_tratamiento->detectado_persona ? 'selected' : '' }}>
                                                                                    {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}
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
                                                                        value="{{ \Carbon\Carbon::parse($registro_tratamiento->fecha_evento_trata)->format('Y-m-d') }}"
                                                                        class="form-control"
                                                                        max="{{ date('Y-m-d') }}" required disabled>
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

                                                                    @foreach ($registro_tratamiento_persons as $persona)
                                                                        <div class="responsables"
                                                                            style="display: flex; flex-direction: column; gap:10px;">
                                                                            <div class="div" style="display: flex">
                                                                                <label class="field select">

                                                                                    <select
                                                                                        name="responsable_trata[]"
                                                                                        required
                                                                                        class="select_dinamico"
                                                                                        disabled required
                                                                                        style="color: black !important;">
                                                                                        @foreach ($Empleados as $DatEmp)
                                                                                            <option
                                                                                                value="{{ $DatEmp->id_empleado }}"
                                                                                                {{ $DatEmp->id_empleado === $persona->responsable_trata ? 'selected' : '' }}>
                                                                                                {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>

                                                                                </label>

                                                                            </div>
                                                                        </div>
                                                                    @endforeach

                                                                </div>

                                                                <div class="col-md-2">

                                                                    <label for="fecha_responsable"
                                                                        style="color: #34495e">
                                                                        <b>
                                                                            Fecha estimada del tratamiento
                                                                        </b>
                                                                    </label>

                                                                    <input type="date" name="fecha_esti_trata"
                                                                        value="{{ \Carbon\Carbon::parse($registro_tratamiento->fecha_esti_trata)->format('Y-m-d') }}"
                                                                        class="form-control" required disabled>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <div class="tratamientos">
                                                                @foreach ($registro_tratamiento_inme as $item => $value)
                                                                    <div class="row">
                                                                        <div class="col-md-5">
                                                                            <label style="color: #34495e">
                                                                                <b>
                                                                                    2. TRATAMIENTO AL PRODUCTO O
                                                                                    SERVICIO NO
                                                                                    CONFORME:
                                                                                </b>
                                                                            </label>

                                                                            <div class="box"
                                                                                style="display: flex; justify-content: center;">

                                                                                <label class="radio-button">
                                                                                    <input type="radio"
                                                                                        name="tratamiento{{ $item }}"
                                                                                        value="Reproceso"
                                                                                        {{ $value->tratamiento === 'Reproceso' ? 'checked' : '' }}
                                                                                        required disabled>
                                                                                    <span class="radio"></span>
                                                                                    Reproceso
                                                                                </label>
                                                                                <label class="radio-button">
                                                                                    <input type="radio"
                                                                                        name="tratamiento{{ $item }}"
                                                                                        value="Reclasificacion"
                                                                                        {{ $value->tratamiento === 'Reclasificacion' ? 'checked' : '' }}
                                                                                        required disabled>
                                                                                    <span class="radio"></span>
                                                                                    Reclasificación
                                                                                </label>
                                                                                <label class="radio-button">
                                                                                    <input type="radio"
                                                                                        name="tratamiento{{ $item }}"
                                                                                        value="Rechazo"
                                                                                        {{ $value->tratamiento === 'Rechazo' ? 'checked' : '' }}
                                                                                        required disabled>
                                                                                    <span class="radio"></span>
                                                                                    Rechazo
                                                                                </label>

                                                                            </div>
                                                                            <div class="box"
                                                                                style="display: flex; justify-content: center;">
                                                                                <label class="radio-button">
                                                                                    <input type="radio"
                                                                                        name="tratamiento{{ $item }}"
                                                                                        value="Derogacion"
                                                                                        {{ $value->tratamiento === 'Derogacion' ? 'checked' : '' }}
                                                                                        required disabled>
                                                                                    <span class="radio"></span>
                                                                                    Derogación
                                                                                </label>
                                                                                <label class="radio-button">
                                                                                    <input type="radio"
                                                                                        name="tratamiento{{ $item }}"
                                                                                        value="{{ $value->tratamiento !== 'Reproceso' && $value->tratamiento !== 'Reclasificacion' && $value->tratamiento !== 'Rechazo' && $value->tratamiento !== 'Derogacion' ? $value->tratamiento : '' }}"
                                                                                        {{ $value->tratamiento !== 'Reproceso' && $value->tratamiento !== 'Reclasificacion' && $value->tratamiento !== 'Rechazo' && $value->tratamiento !== 'Derogacion' ? 'checked' : '' }}
                                                                                        required disabled>
                                                                                    <span class="radio"></span>
                                                                                    Otro

                                                                                </label>
                                                                                <div id="{{ $item }}" hidden>

                                                                                    <label>
                                                                                        <b>
                                                                                            Cual?
                                                                                        </b>
                                                                                    </label>

                                                                                    <input type="text"
                                                                                        name="otrotratamiento{{ $item }}"
                                                                                        value="{{ $value->tratamiento !== 'Reproceso' && $value->tratamiento !== 'Reclasificacion' && $value->tratamiento !== 'Rechazo' && $value->tratamiento !== 'Derogacion' ? $value->tratamiento : '' }}"
                                                                                        style="width: 100%" disabled>

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
                                                                                style="width: 100%; border-radius: 4px;border-color: #e3e3e3" required disabled>{{ $value->descripcion_inme_trata }}</textarea>

                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <br>
                                                                            <label style="color: #34495e">
                                                                                <b>
                                                                                    Responsable:
                                                                                </b>
                                                                            </label>

                                                                            <label class="field select">

                                                                                <select name="persona_trata[]"
                                                                                    class="select_dinamico" required
                                                                                    disabled>
                                                                                    <option value="">
                                                                                        Persona responsable
                                                                                    </option>
                                                                                    @foreach ($Empleados as $DatEmp)
                                                                                        <option
                                                                                            value="{{ $DatEmp->id_empleado }}"
                                                                                            {{ $DatEmp->id_empleado == $value->persona_trata ? 'selected' : '' }}>
                                                                                            {{ $DatEmp->primer_nombre . ' ' . $DatEmp->ot_nombre . ' ' . $DatEmp->primer_apellido . ' ' . $DatEmp->ot_apellido . ' - ' . $DatEmp->descripcion }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </label>
                                                                        </div>

                                                                    </div>
                                                                @endforeach
                                                            </div>


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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'DESCONOCIMIENTO DE PROTOCOLOS POR ENTRENAMIENTO O INDUCCION EN CURSO.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'AREAS Y EQUIPOS NO IDENTIFICADOS.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'INCUMPLIMIENTO BPM DURANTE PROCESOS OPERATIVOS. (PERSONAL, AREAS, EQUIPOS,HERRAMIENTAS, UTENSILIOS,INSTALACIONES FISICAS).' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'USO DE MATERIAS PRIMAS VENCIDAS Y/O INSUMOS SIN HOMOLOGACION. SIN IDENTIFICACION.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'INCUMPLIMIENTO DE NORMAS POR REALIZAR ACTIVIDADES AJENAS A SU PROCESO.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'IMPLEMENTOS DE ASEO INSUFICIENTES, MAL UBICADOS, SUCIOS Y EN MAL ESTADO.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'INCUMPLIMIENTO DE ORDEN Y LIMPIEZA DE ACUERDO CON ESTANDARES Y PROCEDIMIENTOS.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'NOTIFICACIONES SANITARIAS, PERMISOS O REGISTROS VENCIDOS O ERRONEOS.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->nivel_conformidad === 'otro_bajo' ? 'checked' : '' }}
                                                                                            value="otro" required
                                                                                            disabled>
                                                                                        <span class="radio"></span>
                                                                                        Otro
                                                                                        <textarea style="width: 200px;" id="otro_bajo" name="caracte_no_conformidad" disabled>{{ $registro_tratamiento->nivel_conformidad === 'otro_bajo' ? $registro_tratamiento->caracte_no_conformidad : '' }}</textarea>
                                                                                    </label>
                                                                                </td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="INCUMPLIMIENTO NORMAS DE HIGIENE PERSONAL: LAVADO DE MANOS Y PRESENTACION PERSONAL."
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'INCUMPLIMIENTO NORMAS DE HIGIENE PERSONAL: LAVADO DE MANOS Y PRESENTACION PERSONAL.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'INCUMPLIMIENTO EN LIMPIEZA Y DESINFECCION DE EQUIPOS SEGÚN FRECUENCIAS ESTABLECIDAS.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'EL BATCH RECORD NO SE EJECUTA EN TIEMPO REAL Y NO SE VERIFICAN TODAS LAS ETAPAS DE PROCESO.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'NO EJECUCION DE LOS REGISTROS DE LIMPIEZA Y DESINFECCION EN TIEMPO REAL.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'MAL MANEJO DE SOBRANTES, PRODUCTO NO CONFORME: RECIPIENTES SIN IDENTIFICAR DE ACUERDO CON ESTANDAR.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'INCUMPLIMIENTO A DIGRAMAS DE FLUJO Y REGISTRO DE PCC.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'ESTIBAS Y ESTANTERIAS SUCIAS, EN MAL ESTADO.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'PERDIDA DE TRAZABILIDAD.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'INCUMPLIMIENTO AL DESPEJE DE AREA, LINEA Y ETAPA DE PROCESO.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'ESTADOS DE CONTROL DE PROCESO SIN ACTUALIZAR.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'EQUIPOS CON CARACTERISTICAS DE DETERIORO, DAÑO O CONDICIONES SANITARIAS DEFICIENTES.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'NO CUMPLIMIENTO DE ESPECIFICACIONES EN FICHA TECNICA (PARAMETROS DE DISEÑO)' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'SERVICIOS INDUSTRIALES INEFICIENTES (AIRE ACONDICINADO, EXTRACTORES,PRESION DE AGUA, ETC).' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'EQUIPOS DE MEDICION SIN VERIFICACION O CALIBRACION.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'DOCUMENTACION OBSOLETA, PROCESOS SIN DOCUMENTAR.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->nivel_conformidad === 'otro_medio' ? 'checked' : '' }}
                                                                                            value="otro" required
                                                                                            disabled>
                                                                                        <span class="radio"></span>
                                                                                        Otro
                                                                                        <textarea style="width: 200px;" id="otro_medio" name="caracte_no_conformidad" disabled> {{ $registro_tratamiento->nivel_conformidad === 'otro_medio' ? $registro_tratamiento->caracte_no_conformidad : '' }}</textarea>
                                                                                    </label>
                                                                                </td>
                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="caracte_no_conformidad"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="PERSONAL NO IDONEO PARA EL PROCESO: SIN ENTRENAMIENTO /FORMACION."
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'PERSONAL NO IDONEO PARA EL PROCESO: SIN ENTRENAMIENTO /FORMACION.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'NO CUMPLIMIENTO NORMATIVIDAD VIGENTE (DECS. 721 - 833)' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'INCUMPLIMIENTO POR PQRS.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->caracte_no_conformidad === 'CONTAMINACION CRUZADA.' ? 'checked' : '' }}
                                                                                            required disabled>
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
                                                                                            {{ $registro_tratamiento->nivel_conformidad === 'otro_alto' ? 'checked' : '' }}
                                                                                            value="otro" required
                                                                                            disabled>
                                                                                        <span class="radio"></span>
                                                                                        Otro
                                                                                        <textarea name="caracte_no_conformidad" id="otro_alto" style="width: 200px;" disabled>{{ $registro_tratamiento->nivel_conformidad === 'otro_alto' ? $registro_tratamiento->caracte_no_conformidad : '' }}</textarea>
                                                                                    </label>
                                                                                </td>

                                                                                <td>
                                                                                    <label class="radio-button">
                                                                                        <input type="radio"
                                                                                            id="otro_muyalto"
                                                                                            name="caracte_no_conformidad"
                                                                                            value="otro"
                                                                                            {{ $registro_tratamiento->nivel_conformidad === 'otro_muyalto' ? 'checked' : '' }}
                                                                                            required disabled>
                                                                                        <span class="radio"></span>
                                                                                        Otro
                                                                                        <textarea name="caracte_no_conformidad" id="otro_muyalto" style="width: 200px;" disabled>{{ $registro_tratamiento->nivel_conformidad === 'otro_muyalto' ? $registro_tratamiento->caracte_no_conformidad : '' }}</textarea>
                                                                                    </label>
                                                                                </td>

                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <input type="text" name="nivel_conformidad"
                                                                        id = "nivel_conformidad"
                                                                        value="{{ $registro_tratamiento->nivel_conformidad }}"
                                                                        hidden>
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
                                                                        value = "{{ \Carbon\Carbon::parse($registro_tratamiento->fecha_veri_cierre)->format('Y-m-d') }}"
                                                                        class="form-control" required disabled>
                                                                </div>



                                                                <div class="col-md-6">

                                                                    <br>
                                                                    <br>
                                                                    <br>

                                                                    <label class="field select"
                                                                        for="veri_cierre_responsable"><b>
                                                                            Realizado por:
                                                                        </b>
                                                                        <select name="veri_cierre_responsable"
                                                                            id="veri_cierre_responsable"
                                                                            class="select_dinamico" required disabled>
                                                                            <option value="">
                                                                                *Persona
                                                                            </option>
                                                                            @foreach ($Empleados as $DatEmp)
                                                                                <option
                                                                                    value="{{ $DatEmp->id_empleado }}"
                                                                                    {{ $DatEmp->id_empleado === $registro_tratamiento->veri_cierre_responsable ? 'selected' : '' }}>
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
                                                                                {{ $registro_tratamiento->eficaz_tratamiento === 'si' ? 'checked' : '' }}
                                                                                value="si" required disabled>
                                                                            <span class="radio"></span>
                                                                            Sí
                                                                        </label>
                                                                        <label class="radio-button">
                                                                            <input type="radio"
                                                                                id="no_opciones_tratamiento"
                                                                                name="eficaz_tratamiento"
                                                                                {{ $registro_tratamiento->eficaz_tratamiento === 'no' ? 'checked' : '' }}
                                                                                value="no" required disabled>
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
                                                                        required disabled> {{ $registro_tratamiento->conclusion_final }}</textarea>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            EVIDENCIA SI APLICA:
                                                                        </b>
                                                                        <a style="cursor: pointer" data-toggle="modal"
                                                                            data-target="#exampleModal">
                                                                            <img src='{{ $server }}/archivos/Inconformidades/tratamiento_no_conformidad/{{ $registro_tratamiento->id_tratamiento }}.jpg'
                                                                                alt=""
                                                                                style="height: 250px; width: 250px">
                                                                        </a>


                                                                    </label>
                                                                    <br>
                                                                    <br>
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
                                                                            'disabled' => 'disabled',
                                                                        ]) !!}
                                                                        {!! Form::text('uploader', null, ['id' => 'uploader', 'class' => 'gui-input', 'placeholder' => 'Foto']) !!}
                                                                        <label class="field-icon">
                                                                            <i class="fa fa-cloud-upload"></i>
                                                                        </label>
                                                                    </label>
                                                                </div>


                                                                <!-- Modal -->
                                                                <div class="modal fade" id="exampleModal"
                                                                    tabindex="-1" aria-labelledby="exampleModalLabel"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg">
                                                                        <!-- modal-dialog-xl -->
                                                                        <div
                                                                            class="modal-content"style="z-index: 1050">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="exampleModalLabel">EVIDENCIA SI
                                                                                    APLICA</h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                    <span
                                                                                        aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div
                                                                                    style="display: flex; justify-content: center; align-items: center; overflow:hidden;">
                                                                                    <img src='{{ asset ('/archivos/Inconformidades/tratamiento_no_conformidad/')}}{{ $registro_tratamiento->id_tratamiento }}.jpg'
                                                                                        alt=""
                                                                                        style="height: 75%; width: 75%;">
                                                                                </div>

                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>

                                                            <br>
                                                            <br>
                                                            <br>

                                                            <div class="box"
                                                                id = 'btn_actualizar'style="display:flex; justify-content:flex-end;">
                                                                <button id="btn_actualizar" type="submit"
                                                                    class="btn btn-primary mb-2">
                                                                    <img
                                                                        src="{{ asset ('/images/agregar-boton.png')}}">
                                                                    Actualizar tratamiento de no conformidad
                                                                    </img>
                                                                </button>
                                                            </div>


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
            $(document).ready(function() {

                $("#btn_actualizar").hide();
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
                autosize(document.querySelectorAll('textarea'));
                $("#btn_actualizar").css("display", "none");
                $("#btn_editar").click(function() {
                    $("#updateTratamientoNoConf input").prop("disabled", false);
                    $("#updateTratamientoNoConf select").prop("disabled", false);
                    $("#updateTratamientoNoConf textarea:not([name='caracte_no_conformidad'])").prop("disabled",
                        false);
                    $("#btn_actualizar").show();
                    $(`textarea[id='<?= $registro_tratamiento->nivel_conformidad ?>']`).prop('disabled', false);
                });

                $('#niveles input[value="otro"]').on('click', function() {
                    $('#niveles textarea').prop('disabled', true).val("");;
                    $(`textarea[id='${$(this).attr('id')}']`).prop('disabled', false)
                    $('#nivel_conformidad').val($(this).attr('id'));
                });


                $('#niveles input[id="caracte_no_conformidad"]').on('click', function() {
                    $('#niveles textarea').prop('disabled', true);
                    $('#nivel_conformidad').val("");
                });

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



                //let $tratamientos = $('[name^="tratamiento"]');
                let $otroTratamientos = $('[name^="otrotratamiento"]');

                for (let i = 0; i <= <?php echo count($registro_tratamiento_inme); ?>; i++) {
                    let labelText = $(`label.radio-button:has(input[name="tratamiento${i}"]:checked)`).text().trim();
                    let input = $(`#${i}`);

                    if (labelText === 'Otro') {
                        input.show();
                        $otroTratamientos.filter(`[name="otrotratamiento${i}"]`).prop('required', true);
                    } else {
                        input.hide();
                        $otroTratamientos.filter(`[name="otrotratamiento${i}"]`).prop('required', false).val('');
                    }

                    $(`input[name="otrotratamiento${i}"]`).on('input', function() {
                        $(`input[name="tratamiento${i}"]`).val(($(this).val()));
                    });
                }

                for (let i = 1; i <= <?php echo count($registro_tratamiento_inme); ?>; i++) {
                    $(`input[name='tratamiento${i}']`).off('change').on('change', function() {
                        let labelText = $(`label.radio-button:has(input[name="tratamiento${i}"]:checked)`)
                            .text().trim();
                        let input = $(`#${i}`);
                        if (labelText === 'Otro') {
                            input.show();
                            $(`input[name="otrotratamiento${i}"]`).prop('required', true);
                        } else {
                            input.hide();
                            $(`input[name="otrotratamiento${i}"]`).prop('required', false).val('');
                        }
                    });

                    $(`input[name="otrotratamiento${i}"]`).on('input', function() {
                        $(`input[name="tratamiento${i}"]`).val(($(this).val()));
                    });
                }
            });
        </script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/autosize.js/4.0.2/autosize.min.js"></script>
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

        <!-- Importar script select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/autosize.js/4.0.2/autosize.min.js"></script>

        <script src="https://kit.fontawesome.com/6b7caabff8.js" crossorigin="anonymous"></script>

    </body>
@endforeach
