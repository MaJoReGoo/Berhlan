<?php
$server = '/Berhlan/public';

use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Requisiciones\PanelTpcontratos;
use App\Models\Requisiciones\PanelMotivos;
use App\Models\Requisiciones\PanelRequisiciones;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
            Intranet | Requisición de personal | Consulta
        </title>
        @include('includes-CDN/include-head')
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
                                <a href="javascript:history.back()"
                                    title="Requisiciones > Consulta solicitudes > Listado">
                                    <font color="#34495e">
                                        Requisiciones > Consulta solicitudes > Listado >
                                    </font>
                                    <font color="#b4c056">
                                        Más información
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="javascript:history.back()" class="btn btn-primary btn-sm ml10"
                            title="Requisiciones > Consulta solicitudes > Listado">
                            REGRESAR &nbsp;
                            <span class="fa fa-arrow-left"></span>
                        </a>
                    </div>
                </header>
                <!-- -------------- /Topbar -------------- -->

                <!-- -------------- Content -------------- -->
                <section id="content" class="table-layout animated fadeIn">
                    <div class="chute chute-center pt20">
                        <!-- -------------- Column Center -------------- -->
                        <div class="panel m3">
                            <!-- -------------- Message Body -------------- -->
                            <div class="nano-content">
                                <div class="table-responsive">
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr style="background-color:#39405a">
                                                <th>
                                                    Solicitud <?= $DatosSolicitud[0]->num_solicitud ?>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tr>
                                            <td>
                                                <table id="message-table"
                                                    class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Estado:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <font color="#d35400">
                                                                <?php
                                                                //   $estado = PanelRequisiciones::getEstadoSolicitud($DatosSolicitud[0]->estado);
                                                                //   echo $estado[0]->descripcion;

                                                                if ($DatosSolicitud[0]->estado == '5' || $DatosSolicitud[0]->estado == '3') {
                                                                    echo 'Activo';
                                                                }
                                                                if ($DatosSolicitud[0]->estado == '6') {
                                                                    echo 'Finalizado';
                                                                }
                                                                if ($DatosSolicitud[0]->estado == '9') {
                                                                    echo 'Aplazado';
                                                                }
                                                                if ($DatosSolicitud[0]->estado == '7' || $DatosSolicitud[0]->estado == '8') {
                                                                    echo 'Cancelado';
                                                                }

                                                                if ($DatosSolicitud[0]->estado == '1') {
                                                                    echo 'Pendiente';
                                                                }

                                                                if ($DatosSolicitud[0]->estado == '2' || $DatosSolicitud[0]->estado == '4') {
                                                                    echo 'Rechazada';
                                                                }
                                                                ?>
                                                            </font>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Cargo solicitado:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            $nombrec = PanelCargos::getCargo($DatosSolicitud[0]->cargo);
                                                            $Area = PanelAreas::getArea($nombrec[0]->area);
                                                            $Empresa = PanelEmpresas::getEmpresa($Area[0]->empresa);
                                                            echo $nombrec[0]->descripcion;
                                                            echo '<br>';
                                                            echo $Area[0]->descripcion . ' - ' . $Empresa[0]->nombre;
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Centro de operación:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            $centro = PanelCentrosOp::getCentroOp($DatosSolicitud[0]->centro_operacion);
                                                            echo $centro[0]->descripcion;
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Motivo:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            if ($DatosSolicitud[0]->motivo == 'RP') {
                                                                echo 'Reemplazo de personal';
                                                            } elseif ($DatosSolicitud[0]->motivo == 'CN') {
                                                                echo 'Cargo nuevo / Incremento de personal';
                                                            } elseif ($DatosSolicitud[0]->motivo == 'LM') {
                                                                echo 'Licencia de maternidad';
                                                            } elseif ($DatosSolicitud[0]->motivo == 'IP') {
                                                                echo 'Incapacidad permanente';
                                                            }
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Reemplaza a:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?= $DatosSolicitud[0]->reemplaza_a ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Número de vacantes:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?= $DatosSolicitud[0]->num_vacantes ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Observaciones:
                                                        </th>
                                                        <td style="text-align:justify;">
                                                            <?= $DatosSolicitud[0]->observaciones ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Aplicativos a los que deberá tener acceso:
                                                        </th>
                                                        <td style="text-align:justify;">
                                                            <?= $DatosSolicitud[0]->aplicativos ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Requiere:
                                                        </th>
                                                        <td style="text-align:justify;">
                                                            <?= $DatosSolicitud[0]->requiere ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Solicitado por:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            $Empleado = PanelEmpleados::getEmpleado($DatosSolicitud[0]->usr_solicita);
                                                            $Cargo = PanelCargos::getCargo($Empleado[0]->cargo);
                                                            $Area = PanelAreas::getArea($Cargo[0]->area);
                                                            echo $Empleado[0]->primer_nombre;
                                                            echo ' ';
                                                            echo $Empleado[0]->ot_nombre;
                                                            echo ' ';
                                                            echo $Empleado[0]->primer_apellido;
                                                            echo ' ';
                                                            echo $Empleado[0]->ot_apellido;
                                                            echo '<br>';
                                                            echo '(';
                                                            echo $Cargo[0]->descripcion;
                                                            echo ' - ';
                                                            echo $Area[0]->descripcion;
                                                            echo ')';
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Fecha de solicitud:
                                                        </th>
                                                        <td style="text-align:left" colspan="3">
                                                            <?= $DatosSolicitud[0]->fecha_solicita ?>
                                                        </td>
                                                    </tr>

                                                    <?php
                            //Si la solicitud ya fue revisada por nomina
                            if($DatosSolicitud[0]->usr_nomina > 0)
                             {
                              ?>
                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Revisado en nómina por:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            $Empleado = PanelEmpleados::getEmpleado($DatosSolicitud[0]->usr_nomina);
                                                            $Cargo = PanelCargos::getCargo($Empleado[0]->cargo);
                                                            $Area = PanelAreas::getArea($Cargo[0]->area);
                                                            echo $Empleado[0]->primer_nombre;
                                                            echo ' ';
                                                            echo $Empleado[0]->ot_nombre;
                                                            echo ' ';
                                                            echo $Empleado[0]->primer_apellido;
                                                            echo ' ';
                                                            echo $Empleado[0]->ot_apellido;
                                                            echo '<br>';
                                                            echo '(';
                                                            echo $Cargo[0]->descripcion;
                                                            echo ' - ';
                                                            echo $Area[0]->descripcion;
                                                            echo ')';
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Fecha de revisión:
                                                        </th>
                                                        <td style="text-align:left" colspan="3">
                                                            <?= $DatosSolicitud[0]->fecha_nomina ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <?php
                                if($DatosSolicitud[0]->rechazo_nomina > 0)
                                 {
                                  ?>
                                                        <th style="text-align:left">
                                                            Motivo de rechazo:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <font color="red">
                                                                <?php
                                                                $motivo = PanelMotivos::where('id_motivo', $DatosSolicitud[0]->rechazo_nomina)->get();
                                                                echo $motivo[0]->descripcion;
                                                                ?>
                                                            </font>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Observaciones de rechazo:
                                                        </th>
                                                        <td style="text-align:justify;" colspan="3">
                                                            <?= $DatosSolicitud[0]->obs_rechazo ?>
                                                        </td>
                                                        <?php
                                 }
                                else
                                 {
                                  ?>
                                                        <th style="text-align:left">
                                                            Salario:
                                                        </th>
                                                        <td style="text-align:left">
                                                            $<?= number_format($DatosSolicitud[0]->salario, 0, '*', '.') ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Tipo de contrato:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            $Tpcontrato = PanelTpcontratos::where('id_tpcontrato', $DatosSolicitud[0]->tpcontrato)->get();
                                                            echo $Tpcontrato[0]->descripcion;
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Condiciones del contrato:
                                                        </th>
                                                        <td style="text-align:justify;">
                                                            <?= $DatosSolicitud[0]->condiciones ?>
                                                        </td>
                                                        <?php
                                 }
                                ?>
                                                    </tr>
                                                    <?php
                             }

                            //Si la solicitud fue revisada por gerencia
                            if($DatosSolicitud[0]->usr_gerencia > 0)
                             {
                              ?>
                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Revisado en gerencia
                                                            <br>
                                                            de personas por:
                                                        </th>
                                                        <?php
                                echo "<td style=\"text-align:left\">";
                                  $Empleado = PanelEmpleados::getEmpleado($DatosSolicitud[0]->usr_gerencia);
                                  $Cargo    = PanelCargos::getCargo($Empleado[0]->cargo);
                                  $Area     = PanelAreas::getArea($Cargo[0]->area);
                                  echo $Empleado[0]->primer_nombre;
                                  echo " ";
                                  echo $Empleado[0]->ot_nombre;
                                  echo " ";
                                  echo $Empleado[0]->primer_apellido;
                                  echo " ";
                                  echo $Empleado[0]->ot_apellido;
                                  echo "<br>";
                                  echo "(";
                                  echo $Cargo[0]->descripcion;
                                  echo " - ";
                                  echo $Area[0]->descripcion;
                                  echo ")";
                                  echo "<br>";
                                  echo $DatosSolicitud[0]->fecha_gerencia;
                                echo "</td>";

                                echo "<th style=\"text-align:left\">";
                                  echo "Observaciones";
                                  echo "<br>";
                                  echo "(por gerencia de personas):";
                                echo "</th>";
                                echo "<td style=\"text-align:justify;\">";
                                  echo $DatosSolicitud[0]->obs_gerencia;
                                echo "</td>";

                                if($DatosSolicitud[0]->rechazo_gerencia > 0)
                                 {
                                  echo "<th style=\"text-align:left\">";
                                    echo "Motivo de rechazo:";
                                  echo "</th>";
                                  echo "<td style=\"text-align:justify;\">";
                                    $motivog = PanelMotivos::getMotivo($DatosSolicitud[0]->rechazo_gerencia);
                                    echo $motivog[0]->descripcion;
                                  echo "</td>";
                                 }
                                else
                                 {
                                  echo "<td colspan=\"2\">";
                                  echo "</td>";
                                 }
                              echo "</tr>";
                             }

                            //Si la solicitud fue finalizada
                            if($DatosSolicitud[0]->usr_cierre > 0)
                             {
                              ?>
                                                    <tr style="background-color:#F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Proceso de cierre por:
                                                        </th>
                                                        <?php
                                echo "<td style=\"text-align:left\">";
                                  $Empleado = PanelEmpleados::getEmpleado($DatosSolicitud[0]->usr_cierre);
                                  $Cargo    = PanelCargos::getCargo($Empleado[0]->cargo);
                                  $Area     = PanelAreas::getArea($Cargo[0]->area);
                                  echo $Empleado[0]->primer_nombre;
                                  echo " ";
                                  echo $Empleado[0]->ot_nombre;
                                  echo " ";
                                  echo $Empleado[0]->primer_apellido;
                                  echo " ";
                                  echo $Empleado[0]->ot_apellido;
                                  echo "<br>";
                                  echo "(";
                                  echo $Cargo[0]->descripcion;
                                  echo " - ";
                                  echo $Area[0]->descripcion;
                                  echo ")";
                                  echo "<br>";
                                  echo $DatosSolicitud[0]->fecha_cierre;
                                echo "</td>";

                                echo "<th style=\"text-align:left\">";
                                  echo "Observaciones de cierre:";
                                echo "</th>";
                                echo "<td style=\"text-align:justify;\">";
                                  echo $DatosSolicitud[0]->obs_cierre;
                                echo "</td>";

                                if($DatosSolicitud[0]->motivo_rechazo > 0)
                                 {
                                  echo "<th style=\"text-align:left\">";
                                    echo "Motivo de rechazo:";
                                  echo "</th>";
                                  echo "<td style=\"text-align:justify;\">";
                                    $motivog = PanelMotivos::getMotivo($DatosSolicitud[0]->motivo_rechazo);
                                    echo $motivog[0]->descripcion;
                                  echo "</td>";
                                 }
                                else
                                 {
                                  echo "<td colspan=\"2\">";
                                  echo "</td>";
                                 }
                              echo "</tr>";
                             }
                            ?>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
                <!-- -------------- /Content -------------- -->
            </section>
        </div>

        @include('includes-CDN/include-script')

    </body>

    </html>
@endforeach
