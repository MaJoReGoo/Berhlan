<?php

$server = '/Berhlan/public';

use App\Models\Parametrizacion\PanelEmpleados;

use App\Models\Parametrizacion\PanelCargos;

use App\Models\Bpack\PanelSolicitudesAN;
use App\Models\Bpack\PanelMotivos;

?>



@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>

    <html>



    <head>

        <!-- -------------- Meta and Title -------------- -->

        <meta charset="utf-8">

        <title>

            Intranet | Bcloud | Consulta documentos generados

        </title>

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



        <!-- -------------- Plugins -------------- -->

        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">



        <!-- -------------- Favicon -------------- -->

        <link rel="shortcut icon" href="<?= $server ?>/panelfiles/assets/img/favicon.ico">

        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">


        <!-- Alerts Personalizados -->

        <script src="<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.min.js"></script>



        <link rel="stylesheet" href="<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.css">



        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css">

        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css">

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

                                <a href="<?= $server ?>/panel/bpack/otconsultas" title="Bcloud > Otras consultas">

                                    <font color="#34495e">

                                        Bcloud > Otras consultas >

                                    </font>

                                    <font color="#b4c056">

                                        Consulta actualizaciones y nuevos desarrollos

                                    </font>

                                </a>

                            </li>

                        </ul>

                    </div>



                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">

                        <a href="<?= $server ?>/panel/bpack/otconsultas" class="btn btn-primary btn-sm ml10"
                            title="Bcloud > Otras consultas">

                            REGRESAR &nbsp;

                            <span class="fa fa-arrow-left"></span>

                        </a>

                    </div>

                </header>

                <!-- -------------- /Topbar -------------- -->



                <!-- -------------- Content -------------- -->

                <section id="content" class="table-layout animated fadeIn">



                    <!-- -------------- Column Center -------------- -->

                    <div class="panel m10">

                        <!-- -------------- Message Body -------------- -->

                        <div class="table-responsive">

                            <div style="padding-left: 10px">

                                Consulta documentos generados - Berhlan

                            </div>

                            <table id="message-table"
                                class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">

                                <thead>

                                    <tr style="background-color: #F8F8F8">

                                        <th style="text-align: right;">

                                            #

                                        </th>

                                        <th style="text-align: center">

                                            Solicitud

                                        </th>

                                        <th style="text-align: center;">

                                            Fecha solicitud

                                        </th>

                                        <th style="text-align: center;">

                                            Fecha envío sherpa digital

                                        </th>

                                        <th style="text-align: center;">

                                            Fecha aprobación digital

                                        </th>

                                        <th style="text-align: center;">

                                            Fecha envío sherpa física

                                        </th>

                                        <th style="text-align: center;">

                                            Fecha finalización

                                        </th>

                                        <th style="text-align: center;">

                                            Ítem

                                        </th>

                                        <th style="text-align: center;">

                                            Referencia

                                        </th>

                                        <th style="text-align: center;">

                                            Estado

                                        </th>

                                        <th style="text-align: center;">

                                            Ruta

                                        </th>

                                        <th style="text-align: center">

                                            Solicitado por

                                        </th>

                                        <th style="text-align: center">

                                            Cantidad Reprocesos x Ruta

                                        </th>

                                        <th style="text-align: center">

                                            Cantidad Reprocesos x Preprensa

                                        </th>

                                        <th style="text-align: center">

                                            Cantidad Reprocesos x Publicidad

                                        </th>

                                        <th style="text-align: center">

                                            Movimientos

                                        </th>

                                    </tr>

                                </thead>



                                <tbody>

                                    <?php $u = 1; ?>

                                    @foreach ($DatosSolicitudes as $DatSol)
                                        <?php

                                        if ($DatSol->id_nvdesarrollo != 0) {
                                            //Si es nuevo desarrollo

                                            $color = '#21618c';

                                            $inicio = 'SBM';
                                        } else {
                                            $inicio = 'SBA';

                                            if ($DatSol->tipo == 'AR') {
                                                $color = 'green';
                                            } else {
                                                $color = 'red';
                                            }
                                        }

                                        ?>



                                        <tr class="message-unread">

                                            <td style="text-align: right;">

                                                <font color="#2A2F43">

                                                    <?php

                                                    print $u;

                                                    $u++;

                                                    ?>

                                                </font>

                                            </td>

                                            <td style="text-align: center;">

                                                <i class="fa fa-dot-circle-o fa-lg" style="color:<?= $color ?>;"></i>

                                                <font color="#2A2F43">

                                                    <b>

                                                        <?php

                                                        echo $inicio;

                                                        if ($inicio == 'SBM') {
                                                            echo $DatSol->id_nvdesarrollo;
                                                        } else {
                                                            echo $DatSol->id_actualizacion;
                                                        }

                                                        ?>

                                                    </b>

                                                </font>

                                            </td>

                                            <td style="text-align: center">

                                                <font color="#2A2F43">

                                                    <?= $DatSol->fecha_crea ?>

                                                </font>

                                            </td>

                                            <!-- Fecha Envío Sherpa Digital -->

                                            <?php $FechESD = PanelSolicitudesAN::FechaEnvioSherpaDigital($DatSol->id_solicitud); ?>

                                            <td style="text-align: center">

                                                <font color="#2A2F43">

                                                    <?php

                                                    if (isset($FechESD[0]->fecha)) {
                                                        $fechaEnvSD = $FechESD[0]->fecha;
                                                    } else {
                                                        $fechaEnvSD = 'No Establecida';
                                                    }

                                                    print $fechaEnvSD;

                                                    ?>

                                                </font>

                                            </td>

                                            <!-- Fecha Envío Sherpa Digital -->



                                            <td style="text-align: center;">

                                                <font color="#2A2F43">


                                                    <?php

                                                    if ($DatSol->estado == '6' || $DatSol->estado == '7' || $DatSol->estado == '8' || $DatSol->estado == '11') {
                                                        $fechaapr = PanelSolicitudesAN::FechaAprobacionDigital($DatSol->id_solicitud);

                                                        if (isset($fechaapr[0]->fecha)) {
                                                            $fechaAD = $fechaapr[0]->fecha;
                                                        } else {
                                                            $fechaAD = 'No Establecida';
                                                        }
                                                        print $fechaAD;
                                                    }

                                                    ?>
                                                </font>

                                            </td>



                                            <!-- Fecha Envío Sherpa Física -->

                                            <?php $FechESF = PanelSolicitudesAN::FechaEnvioSherpaFisica($DatSol->id_solicitud); ?>

                                            <td style="text-align: center">

                                                <font color="#2A2F43">

                                                    <?php

                                                    if (isset($FechESF[0]->fecha)) {
                                                        $fechaEnvSF = $FechESF[0]->fecha;
                                                    } else {
                                                        $fechaEnvSF = 'No Establecida';
                                                    }

                                                    print $fechaEnvSF;

                                                    ?>

                                                </font>

                                            </td>

                                            <!-- Fecha Envío Sherpa Física -->



                                            <td style="text-align: center;">

                                                <font color="#2A2F43">

                                                    <?php

                                                    if ($DatSol->estado == '8' || $DatSol->estado == '9') {
                                                        $fechafin = PanelSolicitudesAN::fechafin($DatSol->id_solicitud);

                                                        if ($fechafin->count() > 0) {
                                                            echo $fechafin[0]->fecha;
                                                        }
                                                    }

                                                    ?>

                                                </font>

                                            </td>



                                            <td style="text-align: center">

                                                <font color="#2A2F43">

                                                    <?= $DatSol->item ?>

                                                </font>

                                            </td>



                                            <td style="text-align: justify;">

                                                <font color="#2A2F43">

                                                    <?= $DatSol->referencia ?>

                                                </font>

                                            </td>



                                            <td style="text-align: justify;">

                                                <font color="#2A2F43">

                                                    <?php

                                                    $estado = PanelSolicitudesAN::DesEstado($DatSol->estado);

                                                    echo $estado[0]->descripcion;

                                                    ?>

                                                </font>

                                            </td>



                                            <td style="text-align: justify;">

                                                <font color="#2A2F43">

                                                    <?php

                                                    if ($DatSol->ruta != '') {
                                                        if ($DatSol->ruta == 'F') {
                                                            echo 'Flexografía';
                                                        } elseif ($DatSol->ruta == 'D') {
                                                            echo 'Digital';
                                                        }

                                                        echo " ($DatSol->uso%)";
                                                    }

                                                    ?>

                                                </font>

                                            </td>



                                            <td style="text-align: center">

                                                <font color="#2A2F43">

                                                    <?php

                                                    $empleado = PanelEmpleados::getEmpleado($DatSol->usr_crea);

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

                                            <!-- Cantidad Reprocesos x Ruta -->

                                            <?php $CantRPXR = PanelSolicitudesAN::CantidadReprocesosRuta($DatSol->id_solicitud); ?>

                                            <td style="text-align: center">

                                                <font color="#2A2F43">

                                                    <?php

                                                    $CantRPR = '';

                                                    if ($CantRPXR[0]->cantrp - 1 < 0) {
                                                        $CantRPR = 0;
                                                    } else {
                                                        $CantRPR = $CantRPXR[0]->cantrp - 1;
                                                    }

                                                    print $CantRPR;

                                                    ?>

                                                </font>

                                            </td>

                                            <!-- Cantidad Reprocesos x Ruta -->



                                            <!-- Cantidad Reprocesos x Preprensa -->

                                            <?php $CantRPXP = PanelSolicitudesAN::CantidadReprocesosPreprensa($DatSol->id_solicitud); ?>

                                            <td style="text-align: center">

                                                <font color="#2A2F43">

                                                    <?php

                                                    $CantRPP = '';

                                                    if ($CantRPXP[0]->cantrp - 1 < 0) {
                                                        $CantRPP = 0;
                                                    } else {
                                                        $CantRPP = $CantRPXP[0]->cantrp - 1;
                                                    }

                                                    print $CantRPP;

                                                    ?>

                                                </font>

                                            </td>

                                            <!-- Cantidad Reprocesos x Preprensa -->



                                            <!-- Cantidad Reprocesos x Publicidad -->

                                            <?php $CantRPXPC = PanelSolicitudesAN::CantidadReprocesosPublicidad($DatSol->id_solicitud); ?>

                                            <td style="text-align: center">

                                                <font color="#2A2F43">

                                                    <?php

                                                    $CantRPC = '';

                                                    if ($CantRPXPC[0]->cantrp - 2 < 0) {
                                                        $CantRPC = 0;
                                                    } else {
                                                        $CantRPC = $CantRPXPC[0]->cantrp - 2;
                                                    }

                                                    print $CantRPC;

                                                    ?>

                                                </font>

                                            </td>

                                            <td style="text-align: center">
                                                <button type="button" class="btn btn-default light"
                                                    data-toggle="modal"
                                                    data-target="#exampleModal_<?= $DatSol->id_solicitud ?>">
                                                    <i class="fa fa-plus-circle fa-lg" style="color:#AEBF25;"></i>
                                                </button>

                                                <div class="modal fade" id="exampleModal_<?= $DatSol->id_solicitud ?>"
                                                    tabindex="-1" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog-xl">
                                                        <!-- modal-dialog-xl -->
                                                        <div class="modal-content"style="z-index: 1050">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    Movimientos</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div
                                                                    style="display: flex; justify-content: center; align-items: center ">
                                                                    <table id="table-movi"
                                                                        class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                                        <thead>
                                                                            <tr
                                                                                style="background-color: #F8F8F8; color:#000000">
                                                                                <th style="text-align:left">
                                                                                    #
                                                                                </th>
                                                                                <th style="text-align:center;">
                                                                                    Estado
                                                                                </th>
                                                                                <th style="text-align:center;">
                                                                                    Observaciones
                                                                                </th>
                                                                                <th style="text-align: center">
                                                                                    Fecha
                                                                                </th>
                                                                                <th style="text-align:center;">
                                                                                    Motivo de rechazo
                                                                                </th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                            <?php
                                                                            $u = 1;
                                                                            ?>
                                                                            @foreach ($DatSol->movimientos as $DatMov)
                                                                                <tr class="message-unread">
                                                                                    <td style="text-align:left">
                                                                                        <font color="#2A2F43">
                                                                                            <?php
                                                                                            print $u;
                                                                                            $u++;
                                                                                            ?>
                                                                                        </font>
                                                                                    </td>

                                                                                    <td style="text-align:center;"
                                                                                        nowrap>
                                                                                        <font color="#2A2F43">
                                                                                            <?php
                                                                                            $estadomov = PanelSolicitudesAN::DesEstado($DatMov->estado);
                                                                                            echo $estadomov[0]->descripcion;
                                                                                            ?>
                                                                                        </font>
                                                                                    </td>

                                                                                    <td style="text-align:justify;">
                                                                                        <font color="#2A2F43">
                                                                                            <?= $DatMov->observaciones ?>
                                                                                        </font>
                                                                                    </td>

                                                                                    <td style="text-align:center;"
                                                                                        nowrap>
                                                                                        <font color="#2A2F43">
                                                                                            <?php
                                                                                            echo $DatMov->fecha;
                                                                                            echo '<br>';
                                                                                            $empleado = PanelEmpleados::getEmpleado($DatMov->usuario);
                                                                                            echo $empleado[0]->primer_nombre;
                                                                                            echo ' ';
                                                                                            echo $empleado[0]->ot_nombre;
                                                                                            echo ' ';
                                                                                            echo $empleado[0]->primer_apellido;
                                                                                            echo ' ';
                                                                                            echo $empleado[0]->ot_apellido;
                                                                                            echo '<br>(';
                                                                                            echo $empleado[0]->identificacion;
                                                                                            echo ') ';
                                                                                            $cargo = PanelCargos::getCargo($empleado[0]->cargo);
                                                                                            echo $cargo[0]->descripcion;
                                                                                            ?>
                                                                                        </font>
                                                                                    </td>

                                                                                    <td style="text-align:center;"
                                                                                        nowrap>
                                                                                        <font color="#2A2F43">
                                                                                            <?php
                                                                                            if ($DatMov->motivo_rechazo != 0) {
                                                                                                $desmotivo = PanelMotivos::getMotivo($DatMov->motivo_rechazo);
                                                                                                echo $desmotivo[0]->descripcion;
                                                                                            }
                                                                                            ?>
                                                                                        </font>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>


                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>





                                        </tr>
                                    @endforeach



                                </tbody>



                            </table>

                        </div>

                    </div>

                    <!-- -------------- /Column Center -------------- -->



                </section>

                <!-- -------------- /Content -------------- -->

            </section>

        </div>



        <!-- -------------- /Body Wrap  -------------- -->



        <!-- -------------- Scripts -------------- -->



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

        <script src="<?= $server ?>/panelfiles/assets/js/demo/widgets_sidebar.js"></script>

        <script src="<?= $server ?>/panelfiles/assets/js/pages/dashboard2.js"></script>



        <!-- -------------- Page JS -------------- -->

        <script src="<?= $server ?>/panelfiles/assets/js/demo/charts/highcharts.js"></script>



        <!-- -------------- /Scripts -------------- -->



        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

        <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

        <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

        {{-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> --}}

        <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>

        <script src="https://cdn.datatables.net/buttons/3.0.0/js/dataTables.buttons.js"></script>

        <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.dataTables.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

        <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.html5.min.js"></script>

        <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.print.min.js"></script>



        <script>
            $('#message-table').DataTable({

                paging: true,
                language: {
                    "processing": "Procesando...",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "Ningún dato disponible en esta tabla",
                    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "search": "Buscar:",
                    "loadingRecords": "Cargando...",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                },
                "order": [

                    [1, "asc"],

                ],



                layout: {

                    topStart: {

                        buttons: ['excel']

                    }

                }

            });




            window.setInterval("reFresh()", 900000);



            function reFresh() {

                location.reload(true);

            }
        </script>

    </body>



    </html>
@endforeach
