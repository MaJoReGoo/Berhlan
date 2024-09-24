<?php
{{ asset = '/Berhlan/public' }};

use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\TicActivos\PanelTipos;
use App\Models\TicActivos\PanelMarcas;
use App\Models\TicActivos\PanelLicencias;
use App\Models\TicActivos\PanelSoftware;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>
            Intranet | Activos TIC | Ingresar activo
        </title>
        <meta name="description" content="Intranet para grupo Berhlan">
        <meta name="author" content="USUARIO">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- -------------- Fonts -------------- -->
        <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
        <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic'
            rel='stylesheet' type='text/css'>

        <!-- -------------- CSS - theme -------------- -->
        <link rel="stylesheet" type="text/css" href="<{{ asset ('/panelfiles/assets/skin/default_skin/css/theme.css')}}">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="<{{ asset ('/panelfiles/assets/allcp/forms/css/forms.min.css')}}">
        <link rel="stylesheet" type="text/css" href="<{{ asset ('/panelfiles/assets/allcp/forms/css/forms.css')}}">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="<{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css')}}">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="<{{ asset ('/panelfiles/assets/img/favicon.ico')}}">

        <!-- Editor -->
        <script type="text/javascript" src="<{{ asset ('/panelfiles/ckeditor/ckeditor.js')}}"></script>

        {{-- Importar styles y funcionamiento del Select2 --}}
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">


        <script type="text/javascript" src="<{{ asset ('/panelfiles/select2/dist/js/select2.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="<{{ asset ('/panelfiles/select2/dist/css/select2.min.css')}}">

        <!-- SweetAlert2 -->

        <script src="<{{ asset ('/panelfiles/sweetalert/dist/sweetalert.min.js')}}"></script>
        <link rel="stylesheet" href="<{{ asset ('/panelfiles/sweetalert/dist/sweetalert.css')}}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


        <script src="https://www.jsdelivr.com/package/npm/pdfjs-dist"></script>
        <script src="https://cdnjs.com/libraries/pdf.js"></script>
        <script src="https://unpkg.com/pdfjs-dist/"></script>

        <!-- -------------- DataTables -------------- -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">

        <script>
            jQuery(document).ready(function($) {
                $("#empleado").select2({
                    closeOnSelect: true,
                    width: '100%'
                });
            });
            jQuery(document).ready(function($) {
                $("#tipo").select2({
                    closeOnSelect: true,
                    width: '100%'
                });
            });
        </script>.
        @include('activos-fijos.modales.modal-tipoActivoFijo')
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
                                <a href="<{{ asset ('/panel/menu/104" title="Activos TIC')}}">
                                    <font color="#34495e">
                                        Activos Fijos >
                                    </font>
                                    <font color="#b4c056">
                                        Agregar
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <button type="button" id="cargarEmpleadoBtn" class="btn btn-secondary mb-2" data-toggle="modal"
                            data-target="#creacionTipoActi">
                            <img src="{{ asset ('/images/agregar-boton.png')}}">
                            Crear Tipo Activo Fijo
                            </img>
                        </button>
                        <a href="<{{ asset ('/panel/menu/104" class="btn btn-primary btn-sm ml10')}}" title="Activos TIC">
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
                                                    Ingrese la información del nuevo activo
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="allcp-form">
                                                        <form id="ingresarActivosFijos"
                                                            action="{{ route('insert.activosfijos') }}" method="post"
                                                            enctype="multipart/form-data">
                                                            @csrf

                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Tipo de Activo Fijo
                                                                        </b>
                                                                    </label>
                                                                    <label class="field select">
                                                                        <select name="tipo" id="tipo" required>
                                                                            <option value="">
                                                                                * Tipo de activo fijo
                                                                            </option>
                                                                            <?php
                                                                            $Tipos = PanelTipos::getTiposActivos();
                                                                            ?>
                                                                            @foreach ($Tipos as $DatTip)
                                                                                <option
                                                                                    value="<?= $DatTip->id_tipoactivo ?>">
                                                                                    <?= $DatTip->descripcion ?>
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </label>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Colaborador
                                                                        </b>
                                                                    </label>
                                                                    <label class="field select">
                                                                        <select name="empleado" id="empleado" required>
                                                                            <option value="">
                                                                                * Empleado
                                                                            </option>
                                                                            <?php
                                                                            $Empleado = PanelEmpleados::EmpleadosActivos();
                                                                            ?>
                                                                            @foreach ($Empleado as $DatEmp)
                                                                                <?php
                                                                                $Cargo = PanelCargos::getCargo($DatEmp->cargo);
                                                                                $Area = PanelAreas::getArea($Cargo[0]->area);
                                                                                ?>
                                                                                <option
                                                                                    value="{{ $DatEmp->id_empleado }}">

                                                                                    {{ $DatEmp->primer_nombre }}
                                                                                    {{ $DatEmp->ot_nombre }}
                                                                                    {{ $DatEmp->primer_apellido }}
                                                                                    {{ $DatEmp->ot_apellido }}
                                                                                    -
                                                                                    {{ $Cargo[0]->descripcion }}
                                                                                    -
                                                                                    {{ $Area[0]->descripcion }}

                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Compañía
                                                                        </b>
                                                                    </label>
                                                                    <label class="field select">
                                                                        <select name="empresa" id="empresa" required>
                                                                            <option value="">
                                                                                * Compañía
                                                                            </option>
                                                                            <?php
                                                                            $Empresas = PanelEmpresas::getEmpresasActivas();
                                                                            ?>
                                                                            @foreach ($Empresas as $DatEmp)
                                                                                <option
                                                                                    value="<?= $DatEmp->id_empresa ?>">
                                                                                    <?= $DatEmp->nombre ?>
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <i class="arrow"></i>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <br>
                                                                <div class="col-md-4">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Color
                                                                        </b>
                                                                    </label>
                                                                    <label class="field select">
                                                                        <input type="text" name="color"
                                                                            id="color" placeholder="* Color"
                                                                            style="width: 100%">

                                                                    </label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Activo Fijo
                                                                        </b>
                                                                    </label>
                                                                    <label class="field select">
                                                                        <input type="text" name="activo_fijo"
                                                                            id="activo_fijo"
                                                                            placeholder="* Activo fijo"
                                                                            style="width: 100%">

                                                                    </label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Codigo Interno
                                                                        </b>
                                                                    </label>
                                                                    <label class="field select">
                                                                        <input type="text" name="codigo_interno"
                                                                            id="codigo_interno"
                                                                            placeholder="* Codigo interno"
                                                                            style="width: 100%">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <br>
                                                                <div class="col-md-4">
                                                                    <label style="color:#34495e;">
                                                                        <b>
                                                                            Aplica control de mantenimiento
                                                                        </b>
                                                                    </label>
                                                                    <label class="option block">
                                                                        <div class="btn-group btn-group-toggle"
                                                                            data-toggle="buttons">
                                                                            <label class="btn btn-secondary"
                                                                                onclick="COLOR('S')">
                                                                                <i class="fa fa-wrench fa-1x"
                                                                                    id="mantenimientos"
                                                                                    style="color:grey;">
                                                                                    Sí</i>
                                                                                <input type="radio"
                                                                                    name="mantenimiento"
                                                                                    value="S" autocomplete="off">
                                                                            </label>
                                                                            <label class="btn btn-secondary active"
                                                                                onclick="COLOR('N')">
                                                                                <i class="fa fa-times-circle fa-1x"
                                                                                    id="mantenimienton"
                                                                                    style="color:red;">
                                                                                    No</i>
                                                                                <input type="radio"
                                                                                    name="mantenimiento"
                                                                                    value="N" autocomplete="off"
                                                                                    checked>
                                                                            </label>
                                                                        </div>
                                                                    </label>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label style="color:#34495e;">
                                                                        <b>
                                                                            Meses entre mantenimientos
                                                                        </b>
                                                                    </label>
                                                                    <label class="field select">
                                                                        <select name="meses" id="meses"
                                                                            disabled>
                                                                            <option value="">
                                                                                Meses
                                                                            </option>
                                                                            <?php
                                                                            for ($u = 1; $u < 73; $u++) {
                                                                                echo "<option value=\"$u\">";
                                                                                echo $u;
                                                                                echo '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                        <i class="arrow"></i>
                                                                    </label>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label style="color:#34495e;">
                                                                        <b>
                                                                            Fecha inicial
                                                                        </b>
                                                                    </label>
                                                                    <label class="field prepend-icon">
                                                                        {!! Form::date('fechainicial', '', [
                                                                            'required',
                                                                            'disabled',
                                                                            'id' => 'fechainicial',
                                                                            'class' => 'gui-input',
                                                                            'maxlength' => '10',
                                                                        ]) !!}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <br>
                                                                <div class="col-md-4">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Foto Estado Actual
                                                                        </b>
                                                                    </label>
                                                                    <label
                                                                        class="field prepend-icon append-button file">
                                                                        <span class="button">
                                                                            JPG
                                                                        </span>
                                                                        {!! Form::file('foto_actual', [
                                                                            '',
                                                                            'id' => 'foto_actual',
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
                                                                <div class="col-md-8">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Observaciones
                                                                        </b>
                                                                    </label>

                                                                    <textarea name="observaciones" id="observaciones" style="width: 100%; border-radius: 4px;border-color: #e3e3e3"></textarea>

                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div
                                                                    style="display: flex; justify-content: flex-end; align-items: center; margin: 20px;">

                                                                    <button id="btn_adjuntar" type="submit"
                                                                        class="btn btn-primary mb-2">
                                                                        <img
                                                                            src="{{ $server }}/images/agregar-boton.png">
                                                                        Ingresar Activo Fijo
                                                                        </img>
                                                                    </button>
                                                                </div>
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
                        <!-- -------------- /Column Center -------------- -->
                    </div>
                </section>
                <!-- -------------- /Content -------------- -->
            </section>
        </div>
        <!-- -------------- /Body Wrap  -------------- -->

        <!-- -------------- Scripts -------------- -->

        <!-- -------------- jQuery -------------- -->
        <script src="<{{ asset ('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js')}}"></script>
        <script src="<{{ asset ('/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js')}}"></script>

        <!-- -------------- JvectorMap Plugin -------------- -->
        <script src="<{{ asset ('/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js')}}"></script>
        <script src="<{{ asset ('/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js')}}"></script>

        <!-- -------------- HighCharts Plugin -------------- -->
        <script src="<{{ asset ('/panelfiles/assets/js/plugins/highcharts/highcharts.js')}}"></script>
        <script src="<{{ asset ('/panelfiles/assets/js/plugins/c3charts/d3.min.js')}}"></script>
        <script src="<{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.js')}}"></script>

        <!-- -------------- Theme Scripts -------------- -->
        <script src="<{{ asset ('/panelfiles/assets/js/utility/utility.js')}}"></script>
        <script src="<{{ asset ('/panelfiles/assets/js/demo/demo.js')}}"></script>
        <script src="<{{ asset ('/panelfiles/assets/js/main.js')}}"></script>
        <script src="<{{ asset ('/panelfiles/assets/js/pages/allcp_forms-elements.js')}}"></script>
        <script src="<{{ asset ('/panelfiles/assets/js/demo/widgets_sidebar.js')}}"></script>

        <!-- -------------- Page JS -------------- -->
        <script src="<{{ asset ('/panelfiles/assets/js/demo/charts/highcharts.js')}}"></script>

         <!-- -------------- DataTables -------------- -->
         <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
         <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
         <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
         <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>
        <!-- -------------- /Scripts -------------- -->
        <script language="javascript" type="text/javascript">
            document.getElementById('ingresarActivosFijos').addEventListener('submit', function(event) {
                // Evitar que el formulario se envíe de forma predeterminada
                event.preventDefault();
                // Realizar la petición AJAX para enviar el formulario
                fetch(this.action, {
                        method: this.method,
                        body: new FormData(this),
                    })
                    .then(response => {
                        // Si la respuesta es exitosa, recargar la página
                        if (response.ok) {
                            Swal.fire({
                                icon: "success",
                                title: "Activo guardado Correctamente!",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error al enviar el formulario:', error);
                    });
            });


            function COLOR(id1) {
                icono1 = document.getElementById('mantenimientos');
                icono2 = document.getElementById('mantenimienton');
                meses = document.getElementById('meses');
                fecha = document.getElementById('fechainicial');

                if (id1 == "S") {
                    icono1.style.color = 'green';
                    icono2.style.color = 'grey';
                    meses.disabled = '';
                    fecha.disabled = '';
                } else {
                    icono1.style.color = 'grey';
                    icono2.style.color = 'red';
                    meses.disabled = 'disabled';
                    fecha.disabled = 'disabled';
                    meses.value = '';
                    fecha.value = '';
                }
            }

            function COLOR1(id1) {
                icono1 = document.getElementById('licencias');
                icono2 = document.getElementById('licencian');

                if (id1 == "S") {
                    icono1.style.color = 'green';
                    icono2.style.color = 'grey';
                } else {
                    icono1.style.color = 'grey';
                    icono2.style.color = 'red';
                }
            }
        </script>
    </body>

    </html>
@endforeach
