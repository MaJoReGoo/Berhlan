<?php

use App\Models\Procesos\PanelTiposDocumentos;
?>

@foreach($DatosUsuario as $DatLog)
<!DOCTYPE html>
<html>

<head>
    <!-- -------------- Meta and Title -------------- -->
    <meta charset="utf-8">
    <title>
        Intranet | Duplicar Archivo Plano
    </title>
    <meta name="keywords" content="panel, cms, usuarios, servicio" />
    <meta name="description" content="Intranet para grupo Berhlan">
    <meta name="author" content="USUARIO">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- -------------- Fonts -------------- -->
    <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

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
                            <a href="{{ asset ('/panel/procesos/documentos')}}" title="Procesos internos > Documentos">
                                <font color="#34495e">
                                    Archivo Plano >
                                </font>
                                <font color="#b4c056">
                                    Agregar
                                </font>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                    <a href="{{ asset ('/panel/procesos/documentos')}}" class="btn btn-primary btn-sm ml10" title="Procesos internos > Documentos">
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
                                        <tr style="background-color:#67d3e0">
                                            <th style="color:black; text-align:left;">
                                                Ingrese la información del Archivo Plano
                                            </th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="allcp-form">
                                                    {!! Form::open(array('action' => 'ArchivoPlano\ArchivoPlanoPanelController@ArchivoPlanoAgregarDB', 'class' => 'form', 'id'=>'form-wizard', 'files' => true)) !!}
                                                    {!! Form::hidden('login', $DatLog->login) !!}
                                                    @foreach($DatosArchivo as $DataArchivo)
                                                    <!-- Fecha Cargue, Of. Origen Of. Destino, Cod. Concepto, Num. Expediente -->
                                                    <div class="row">
                                                        <div class="col-md-2 form-group">
                                                            <label style="color: #4ECCDB">Fecha de Cargue</label>
                                                            <label for="datepicker1" class="field prepend-icon">
                                                                <input type="date" id="fecha_cargue" name="fecha_cargue" value="<?= $DataArchivo->fecha_cargue ?>" required style="width: 100%">
                                                                <label class="field-icon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2 form-group">
                                                            <label style="color: #0BACBF">Oficina Origen *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="oficina_origen" type="text" maxlength="4" onkeydown="return (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 46 || event.keyCode === 91 || event.keyCode === 92" placeholder="Solo Números" value="<?= $DataArchivo->oficina_origen ?>" style="width: 100%" readonly>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-building"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2 form-group">
                                                            <label style="color: #0BACBF">Oficina Destino *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="oficina_destino" type="text" maxlength="4" onkeydown="return (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 46 || event.keyCode === 91 || event.keyCode === 92" placeholder="Solo Números" value="<?= $DataArchivo->oficina_destino ?>" style="width: 100%" required>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-building"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2 form-group">
                                                            <label style="color: #0BACBF">Código Concepto *</label>
                                                            <label class="field select">
                                                                <select name="codigo_concepto" id="codigo_concepto" required>
                                                                    <?php
                                                                    $codigo = $DataArchivo->codigo_concepto;
                                                                    switch ($codigo) {

                                                                        case 1:
                                                                            $titCodigo = 'Depósitos Judiciales';
                                                                            break;

                                                                        case 2:
                                                                            $titCodigo = 'Entes Coactivos';
                                                                            break;

                                                                        case 3:
                                                                            $titCodigo = 'Excarcelaciones';
                                                                            break;

                                                                        case 4:
                                                                            $titCodigo = 'Remates';
                                                                            break;

                                                                        case 5:
                                                                            $titCodigo = 'Prestaciones Sociales';
                                                                            break;

                                                                        case 6:
                                                                            $titCodigo = 'Cuotas Alimentarias';
                                                                            break;

                                                                        case 7:
                                                                            $titCodigo = 'Arancel Judicial';
                                                                            break;
                                                                    }
                                                                    ?>
                                                                    <option value="<?= $codigo ?>"><?= $titCodigo ?></option>
                                                                    <option value="1">Depósitos Judiciales</option>
                                                                    <option value="2">Entes Coactivos</option>
                                                                    <option value="3">Excarcelaciones</option>
                                                                    <option value="4">Remates</option>
                                                                    <option value="5">Prestaciones Sociales</option>
                                                                    <option value="6">Cuotas Alimentarias</option>
                                                                    <option value="7">Arancel Judicial</option>
                                                                </select>
                                                                <i class="arrow"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label style="color: #0BACBF">Número del Expediente *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="numero_expediente" type="text" maxlength="10" onkeydown="return (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 46 || event.keyCode === 91 || event.keyCode === 92" placeholder="Solo Números" value="<?= $DataArchivo->numero_expediente ?>" style="width: 100%" required>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-file"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!-- Fecha Cargue, Of. Origen Of. Destino, Cod. Concepto, Num. Expediente -->

                                                    <!--  Cuenta Judicial, Cuenta de Ahorros, Valor -->
                                                    <div class="row">
                                                        <div class="col-md-4 form-group">
                                                            <label style="color: #0BACBF">Cuenta Judicial *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="cuenta_judicial" value="<?= $DataArchivo->cuenta_judicial ?>" type="text" maxlength="12" onkeydown="return (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 46 || event.keyCode === 91 || event.keyCode === 92" placeholder="Solo Números" style="width: 100%" required>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-file"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label style="color: #0BACBF">Cuenta de Ahorros *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="cuenta_ahorros" value="<?= $DataArchivo->cuenta_ahorros ?>" type="text" maxlength="12" onkeydown="return (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 46 || event.keyCode === 91 || event.keyCode === 92" placeholder="Solo Números" style="width: 100%" required>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-file"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label style="color: #0BACBF">Valor *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="valor_deposito" value="<?= $DataArchivo->valor_deposito ?>" type="text" maxlength="12" onkeydown="return (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 46 || event.keyCode === 91 || event.keyCode === 92 || event.keyCode === 190" placeholder="Solo Números" style="width: 100%" required>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-usd"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--  Cuenta Judicial, Cuenta de Ahorros, Valor -->

                                                    <!--  Tipo id Demandante, id Demandante, Tipo id Demandado, id Demandado -->
                                                    <div class="row">
                                                        <div class="col-md-2 form-group">
                                                            <label style="color: #0BACBF">Tipo id Demandante *</label>
                                                            <label class="field select">
                                                                <select name="tipo_identificacion_demandante" id="tipo_identificacion_demandante" required>
                                                                    <?php if ($DataArchivo->tipo_identificacion_demandante == 1) { ?>
                                                                        <option value="1">CC</option>
                                                                        <option value="3">NIT</option>
                                                                    <?php } ?>

                                                                    <?php if ($DataArchivo->tipo_identificacion_demandante == 3) { ?>
                                                                        <option value="3">NIT</option>
                                                                        <option value="1">CC</option>
                                                                    <?php } ?>
                                                                </select>
                                                                <i class="arrow"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label style="color: #0BACBF">Identificación Demandante *</label>
                                                            <label class="field prepend-icon">
                                                                <input value="<?= $DataArchivo->identificacion_demandante; ?>" name="identificacion_demandante" type="text" maxlength="11" onkeydown="return (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) ||  event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 46 || event.keyCode === 91 || event.keyCode === 92" placeholder="Solo Números" style="width: 100%" required>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-file"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2 form-group">
                                                            <label style="color: #0BACBF">Tipo id Demandado *</label>
                                                            <label class="field select">
                                                                <select name="tipo_identificacion_demandado" id="tipo_identificacion_demandado" required>
                                                                    <?php if ($DataArchivo->tipo_identificacion_demandado == 1) { ?>
                                                                        <option value="1">CC</option>
                                                                        <option value="3">NIT</option>
                                                                    <?php } ?>

                                                                    <?php if ($DataArchivo->tipo_identificacion_demandado == 3) { ?>
                                                                        <option value="3">NIT</option>
                                                                        <option value="1">CC</option>
                                                                    <?php } ?>
                                                                </select>
                                                                <i class="arrow"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label style="color: #0BACBF">Identificación Demandado *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="identificacion_demandado" value="<?= $DataArchivo->identificacion_demandado; ?>" type="text" maxlength="11" onkeydown="return (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 46 || event.keyCode === 91 || event.keyCode === 92" placeholder="Solo Números" style="width: 100%" required>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-file"></i>
                                                                </label>
                                                            </label>
                                                        </div>

                                                    </div>
                                                    <!--  Tipo id Demandante, id Demandante, Tipo id Demandado, id Demandado -->


                                                    <!-- Nombres y Apellidos Demandante y Demandado -->
                                                    <div class="row">
                                                        <div class="col-md-3 form-group">
                                                            <label style="color: #0BACBF">Nombre Demandante *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="nombre_demandante" value="<?= $DataArchivo->nombre_demandante; ?>" type="text" maxlength="20" onkeydown="return (event.keyCode >= 65 && event.keyCode <= 92) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 32 || event.keyCode === 46" placeholder="Nombre" style="width: 100%" required>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-file"></i>
                                                                </label>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-3 form-group">
                                                            <label style="color: #0BACBF">Apellido Demandante *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="apellido_demandante" value="<?= $DataArchivo->apellido_demandante; ?>" type="text" maxlength="20" onkeydown="return (event.keyCode >= 65 && event.keyCode <= 92) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 32 || event.keyCode === 46" placeholder="Apellido" style="width: 100%" required>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-file"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label style="color: #0BACBF">Nombre Demandado *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="nombre_demandado" value="<?= $DataArchivo->nombre_demandado; ?>" type="text" maxlength="20" onkeydown="return (event.keyCode >= 65 && event.keyCode <= 92) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 32 || event.keyCode === 46" placeholder="Nombre" style="width: 100%" required>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-file"></i>
                                                                </label>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-3 form-group">
                                                            <label style="color: #0BACBF">Apellido Demandado *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="apellido_demandado" value="<?= $DataArchivo->apellido_demandado; ?>" type="text" maxlength="20" onkeydown="return (event.keyCode >= 65 && event.keyCode <= 92) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 32 || event.keyCode === 46" placeholder="Apellido" style="width: 100%" required>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-file"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!-- Nombres y Apellidos Demandante y Demandado -->

                                                    <div class="row">
                                                        <br>
                                                        <div class="col-md-5 form-group">
                                                            <label style="color: #0BACBF">Número del Proceso *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="numero_proceso" value="<?= $DataArchivo->numero_proceso; ?>" type="text" maxlength="23" onkeydown="return (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 46 || event.keyCode === 91 || event.keyCode === 92 || (event.ctrlKey && (event.key === 'v'
            || event.key === 'V'))" placeholder="Solo Números" style="width: 100%" required>
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-file"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2 form-group">
                                                            <label style="color: #0BACBF">Estado *</label>
                                                            <label class="field select">
                                                                <select name="estado" id="estado" required>
                                                                    <option value="2">Sin Exportar</option>
                                                                </select>
                                                                <i class="arrow"></i>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <br><br>
                                                            {!! Form::submit('Ingresar documento', array('class'=>'button')) !!}
                                                            <br><br>
                                                        </div>
                                                    </div>
                                                    @endforeach
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
