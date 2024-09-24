<?php
{{ asset = '/Berhlan/public' }};

use App\Models\TicActivos\PanelTipos;
use App\Models\TicActivos\PanelTareas;
use App\Models\TicActivos\PanelMarcas;
use App\Models\TicActivos\PanelLicencias;
use App\Models\TicActivos\PanelTpOffice;
use App\Models\TicActivos\PanelActivos;
use App\Models\TicActivos\PanelConsultas;
use App\Models\ActivosFijos\PanelActivosFijos;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Activos TIC | Consulta parametrizada
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

        <!-- SweetAlert2 -->

        <script src="<{{ asset ('/panelfiles/sweetalert/dist/sweetalert.min.js')}}"></script>
        <link rel="stylesheet" href="<{{ asset ('/panelfiles/sweetalert/dist/sweetalert.css')}}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


        <script src="https://www.jsdelivr.com/package/npm/pdfjs-dist"></script>
        <script src="https://cdnjs.com/libraries/pdf.js"></script>
        <script src="https://unpkg.com/pdfjs-dist/"></script>
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
                                <a href="<{{ asset ('/panel/activos/consulta/parametrizada"')}}
                                    title="Activos TIC > Consulta parametrizada > Resultado">
                                    <font color="#34495e">
                                        Activos TIC > Consulta parametrizada > Resultado >
                                    </font>
                                    <font color="#b4c056">
                                        Más información
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="{{ asset ('/panel/activos/consulta/parametrizada')}}"
                            class="btn btn-primary btn-sm ml10"
                            title="Activos TIC > Consulta parametrizada > Resultado">
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
                                                    Control de activos TIC AC<?= $DatosActivo[0]->id_activo ?>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tr>
                                            <td>
                                                <table id="message-table"
                                                    class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Tipo:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            $Tipo = PanelTipos::getTipo($DatosActivo[0]->tipo);
                                                            echo $Tipo[0]->descripcion;
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Compañía:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            $Empresa = PanelEmpresas::getEmpresa($DatosActivo[0]->empresa);
                                                            echo $Empresa[0]->nombre;
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Colaborador:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            $empleado = PanelEmpleados::getEmpleado($DatosActivo[0]->empleado);
                                                            echo $empleado[0]->primer_nombre;
                                                            echo ' ';
                                                            echo $empleado[0]->ot_nombre;
                                                            echo ' ';
                                                            echo $empleado[0]->primer_apellido;
                                                            echo ' ';
                                                            echo $empleado[0]->ot_apellido;
                                                            echo '<br>';
                                                            $cargo = PanelCargos::getCargo($empleado[0]->cargo);
                                                            echo $cargo[0]->descripcion;
                                                            echo ' - ';
                                                            $Area = PanelAreas::getArea($cargo[0]->area);
                                                            echo $Area[0]->descripcion;
                                                            echo '<br>';
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">

                                                        <th style="text-align:left">
                                                            Código interno:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?= $DatosActivo[0]->cod_interno ?>
                                                        </td>
                                                        <th style="text-align:left">
                                                            Activo fijo:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?= $DatosActivo[0]->activo_fijo ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Imagen:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            $ruta    = "/Berhlan/public/archivos/Activostic/Fotos/".$DatosActivo[0]->foto."?".date('i:s');
                                                            $sinfoto = "/Berhlan/public/archivos/Activostic/Fotos/sinimagen.jpg?".date('i:s');
                                                    if($DatosActivo[0]->foto != '')
                                                         {
                                                    ?>
                                                            <button type="button" style="background:#f7f9f9;"
                                                                class="btn btn-default light"
                                                                onclick="window.open('<{{ asset ('/archivos/Activostic/Fotos/')}}<?= $DatosActivo[0]->foto ?>','_blank')"
                                                                title="<?= $DatosActivo[0]->foto ?>">
                                                                <img src="<?= $ruta ?>" class="img-responsive mauto"
                                                                    style="width: 100px; border-radius:6px; border:1;"
                                                                    onerror="this.src='<?= $sinfoto ?>'" />
                                                            </button>
                                                            <?php
                                                         }
                                                     else
                                                         {
                                                            echo "No adjunta";
                                                         }
                                                     ?>
                                                        </td>
                                                    </tr>




                                                    <tr style="background-color: #F8F8F8; color:#000000">


                                                        <th style="text-align:left">
                                                            Acta firmada:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                if($DatosActivo[0]->acta_firmada != '')
                                 {
                                  ?>
                                                            <button type="button" style="background:#f7f9f9;"
                                                                class="btn btn-default light"
                                                                onclick="window.open('<{{ asset ('/archivos/Activostic/Actas_firmadas/')}}<?= $DatosActivo[0]->acta_firmada ?>','_blank')"
                                                                title="<?= $DatosActivo[0]->acta_firmada ?>">
                                                                <i class="fa fa-file-pdf-o fa-lg"
                                                                    style="color:red;"></i>
                                                            </button>
                                                            <?php
                                 }
                                else
                                 {
                                  echo "No adjunta";
                                 }
                                ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Aplica control de mantenimiento:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            if ($DatosActivo[0]->mantenimiento == 'S') {
                                                                echo 'Sí';
                                                            } else {
                                                                echo 'No';
                                                            }
                                                            ?>
                                                        </td>
                                                        <th style="text-align:left">
                                                            Meses entre mantenimientos:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            if ($DatosActivo[0]->mantenimiento == 'N') {
                                                                echo 'No aplica';
                                                            } else {
                                                                echo $DatosActivo[0]->mes_mtto;
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">


                                                        <th style="text-align:left">
                                                            Fecha inicial para mantenimiento:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            if ($DatosActivo[0]->mantenimiento == 'N') {
                                                                echo 'No aplica';
                                                            } else {
                                                                echo $DatosActivo[0]->fecha_mtto;
                                                            }
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Acta:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <button type="button" class="btn btn-default light"
                                                                onclick="window.location.href='<{{ asset ('/panel/activos/acta/')}}<?= $DatosActivo[0]->id_activo ?>'"
                                                                title="Acta">
                                                                <i class="fa fa-file-pdf-o fa-lg"
                                                                    style="color:red;"></i>
                                                            </button>
                                                        </td>
                                                        <th style="text-align:left">
                                                            Estado:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            if ($DatosActivo[0]->estado == 1) {
                                                                echo 'Activo';
                                                            } else {
                                                                echo 'Inactivo';
                                                            }
                                                            ?>
                                                        </td>

                                                    </tr>

                                                </table>
                                                <div
                                                    style="display: flex; justify-content: flex-end; align-items: center; margin: 10px;">
                                                    <button type="button" class="btn btn-primary mb-2"
                                                        onclick="window.location.href='<{{ asset ('/panel/activos/modificaract/')}}<?= $DatosActivo[0]->id_activo ?>'"
                                                        title="Modificar">
                                                        <img src="{{ asset ('/images/editar-codigo.png')}}">
                                                        Editar
                                                        </img>
                                                    </button>
                                                </div>

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
                                            <tr style="background-color:#67d3e0">
                                                <th style="color:black; text-align:left;">
                                                    Ingresar actividad
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="allcp-form">
                                                        <form id="ingresarActividad"
                                                            action="{{ route('insert.actividades') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="activo"
                                                                value="{{ $DatosActivo[0]->id_activo }}">


                                                            <div class="row">
                                                                <br>
                                                                <div class="col-md-6">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Observaciones
                                                                        </b>
                                                                    </label>
                                                                    <label class="field prepend-icon">
                                                                        <textarea name="observaciones" id="observaciones" style="width:  100%" placeholder="Observaciones"></textarea>

                                                                        <label for="username" class="field-icon">
                                                                            <i class="fa fa-reorder"></i>
                                                                        </label>
                                                                    </label>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <br><br>
                                                                    {!! Form::submit('Ingresar actividad', ['class' => 'button']) !!}
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div>
                                        <table id="message-table" class="table allcp-form theme-warning br-t"
                                            style="margin: 10px;padding-bottom: 10px; width: 97%">
                                            <thead>
                                                <tr style="background-color: #F8F8F8; color:#000000">
                                                    <th>
                                                        #
                                                    </th>
                                                    <th style="text-align:center;">
                                                        ACTIVIDAD
                                                    </th>
                                                    <th style="text-align:center;">
                                                        USUARIO
                                                    </th>
                                                    <th style="text-align:center;">FECHA</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @php
                                                    $DatosActividades = PanelActivosFijos::Actividades(
                                                        $DatosActivo[0]->id_activo,
                                                    );
                                                    $u = 1;
                                                @endphp
                                                @foreach ($DatosActividades as $DatAct)
                                                    <tr class="message-unread">
                                                        <td style="text-align:left">
                                                            <font color="#2A2F43">
                                                                <?php
                                                                print $u;
                                                                $u++;
                                                                ?>
                                                            </font>
                                                        </td>

                                                        <td style="text-align:justify;">
                                                            <font color="#2A2F43">
                                                                {{ $DatAct->observaciones }}
                                                            </font>
                                                        </td>

                                                        <td style="text-align:center;">
                                                            <font color="#2A2F43">
                                                                @php
                                                                    $empleado = PanelEmpleados::getEmpleado(
                                                                        $DatAct->usuario,
                                                                    );
                                                                @endphp
                                                                {{ $empleado[0]->primer_nombre . ' ' . $empleado[0]->ot_nombre . ' ' . $empleado[0]->primer_apellido . ' ' . $empleado[0]->ot_apellido }}

                                                            </font>
                                                        </td>

                                                        <td style="text-align:center;">
                                                            <font color="#2A2F43">
                                                                {{ $DatAct->fecha }}
                                                            </font>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>

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
                                            <tr style="background-color:#39405a">
                                                <th>
                                                    Registro de creación y cambios realizados

                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="table-responsive">
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        {{-- <thead>
                        <tr style="background-color:#39405a">
                          <th>
                            Registro de creación y cambios realizados

                          </th>
                          <th>

                              <button type="submit" class="btn btn-secondary" style="align-items: flex-end">
                                <img src="{{$server}}/images/folder (1).png" alt="">
                                </button>
                          </th>
                        </tr>
                      </thead> --}}


                                        <td>
                                            <table id="message-table"
                                                class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                <thead>
                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            #
                                                        </th>
                                                        <th style="text-align:center;">
                                                            Valores anteriores
                                                        </th>
                                                        <th style="text-align:center;">
                                                            Usuario
                                                        </th>
                                                        <th style="text-align:center;">
                                                            Fecha
                                                        </th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                    $DatosCambios = PanelActivosFijos::Cambios($DatosActivo[0]->id_activo);
                                                    $u = 1;
                                                    ?>
                                                    @foreach ($DatosCambios as $DatCam)
                                                        <tr class="message-unread">
                                                            <td style="text-align:left">
                                                                <font color="#2A2F43">
                                                                    <?php
                                                                    print $u;
                                                                    $u++;
                                                                    ?>
                                                                </font>
                                                            </td>

                                                            <td style="text-align:justify;">
                                                                <font color="#2A2F43">
                                                                    <?= $DatCam->cambio ?>
                                                                </font>
                                                            </td>

                                                            <td style="text-align:center;">
                                                                <font color="#2A2F43">
                                                                    <?php
                                                                    $empleado = PanelEmpleados::getEmpleado($DatCam->usuario);
                                                                    echo $empleado[0]->primer_nombre;
                                                                    echo ' ';
                                                                    echo $empleado[0]->ot_nombre;
                                                                    echo ' ';
                                                                    echo $empleado[0]->primer_apellido;
                                                                    echo ' ';
                                                                    echo $empleado[0]->ot_apellido;
                                                                    echo '<br>';
                                                                    $cargo = PanelCargos::getCargo($empleado[0]->cargo);
                                                                    echo $cargo[0]->descripcion;
                                                                    ?>
                                                                </font>
                                                            </td>

                                                            <td style="text-align:center;">
                                                                <font color="#2A2F43">
                                                                    <?= $DatCam->fecha ?>
                                                                </font>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>

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

        <!-- -------------- /Scripts -------------- -->
        <script>
            document.getElementById('ingresarActividad').addEventListener('submit', function(event) {
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
                                title: "Actividad registrada Correctamente!",
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
        </script>
    </body>

    </html>
@endforeach
