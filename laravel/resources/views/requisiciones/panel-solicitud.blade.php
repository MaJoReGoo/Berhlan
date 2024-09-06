<?php
$server = '/Berhlan/public';

use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Requisiciones\PanelRequisiciones;
?>

@foreach ($DatosUsuario as $DatLog)
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <title>
            Intranet | Requisición de personal | Solicitud
        </title>
        @include('includes-CDN/include-head')
        <link rel="stylesheet" href="{{ asset('css/requisiciones/panel-solicitud.css') }}">
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
                                <a href="<?= $server ?>/panel/menu/32" title="Requisición de personal">
                                    <font color="#34495e">
                                        Requisición de personal >
                                    </font>
                                    <font color="#b4c056">
                                        Solicitud
                                    </font>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                        <a href="<?= $server ?>/panel/menu/32" class="btn btn-primary btn-sm ml10"
                            title="Requisición de personal">
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
                                            <tr>
                                                <th style="background-color:#34495e; color:white; text-align:left;">
                                                    Nueva requisición de personal
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="allcp-form">
                                                        <form class="form" id="form-solicitud"
                                                            action="{{ route('agregarSolicitud') }}" method="POST">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label style="color:#34495e;">
                                                                        <b>
                                                                            Cargo
                                                                        </b>
                                                                    </label>
                                                                    <label class="field select">
                                                                        <select name="cargo" id="cargo" required>
                                                                            <option value="">
                                                                                * Cargo
                                                                            </option>
                                                                            <?php
                                                                            $Cargos = PanelCargos::getCargos();
                                                                            ?>
                                                                            @foreach ($Cargos as $DatCrg)
                                                                                <?php
                                                                                $Area = PanelAreas::getArea($DatCrg->area);
                                                                                foreach ($Area as $DatArea) {
                                                                                    $Empresa = PanelEmpresas::getEmpresa($DatArea->empresa);
                                                                                    $NombreArea = $DatArea->descripcion;
                                                                                    foreach ($Empresa as $DatEmpresa) {
                                                                                        $NombreEmpresa = $DatEmpresa->nombre;
                                                                                    }
                                                                                }
                                                                                ?>
                                                                                <option
                                                                                    value="<?= $DatCrg->id_cargo ?>">
                                                                                    <?= $DatCrg->descripcion . ' - ' . $NombreArea . ' - ' . $NombreEmpresa ?>
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                    </label>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label style="color:#34495e;">
                                                                        <b>
                                                                            Centro de operación
                                                                        </b>
                                                                    </label>
                                                                    <label class="field select">
                                                                        <select name="centro_op" id="centro_op"
                                                                            required>
                                                                            <option value="">
                                                                                * Centro de operación
                                                                            </option>
                                                                            <?php
                                                                            $Centros = PanelCentrosOp::getCentrosOpActivos();
                                                                            ?>
                                                                            @foreach ($Centros as $DatCnts)
                                                                                <option
                                                                                    value="<?= $DatCnts->id_centro ?>">
                                                                                    <?= $DatCnts->descripcion ?>
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                    </label>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label style="color:#34495e;">
                                                                        <b>
                                                                            Motivo de la solicitud
                                                                        </b>
                                                                    </label>
                                                                    <label class="field select">
                                                                        <select name="motivo" id="motivo" required>
                                                                            <option value="">* Motivo de la
                                                                                solicitud
                                                                            </option>
                                                                            <option value="RP">Reemplazo de personal
                                                                            </option>
                                                                            <option value="CN">Cargo nuevo /
                                                                                Incremento
                                                                                de personal</option>
                                                                            <option value="LM">Licencia de
                                                                                maternidad
                                                                            </option>
                                                                            <option value="IP">Incapacidad
                                                                                permanente
                                                                            </option>
                                                                        </select>

                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <br>
                                                                <div class="col-md-4">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Número de vacantes
                                                                        </b>
                                                                    </label>
                                                                    <label class="field prepend-icon">
                                                                        <input type="number" name="numvacantes"
                                                                            required id="numvacantes" class="gui-input"
                                                                            placeholder="* Número de vacantes"
                                                                            max="50" min="1">
                                                                        <label for="username" class="field-icon">
                                                                            <i class="fa fa-users"></i>
                                                                        </label>
                                                                    </label>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Nombre de a quien reemplaza
                                                                        </b>
                                                                    </label>
                                                                    <label class="field prepend-icon">

                                                                        <textarea name="nombre" required id="nombre" class="gui-input" style="height: 60px; resize: vertical;"
                                                                            placeholder="* Reemplaza a ... Para 'Cargo nuevo / Incremento de personal' escriba NO APLICA"></textarea>
                                                                        <label for="username" class="field-icon">
                                                                            <i class="fa fa-reorder"></i>
                                                                        </label>
                                                                    </label>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Observaciones
                                                                        </b>
                                                                    </label>
                                                                    <label class="field prepend-icon">
                                                                        <textarea name="observaciones" id="observaciones" class="gui-input" style="height: 60px; resize: vertical;"
                                                                            placeholder="Observaciones."></textarea>

                                                                        <label for="username" class="field-icon">
                                                                            <i class="fa fa-reorder"></i>
                                                                        </label>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <br>
                                                                <div class="col-md-4">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Aplicativos a los que deberá tener acceso
                                                                        </b>
                                                                    </label>
                                                                    <label class="field prepend-icon">
                                                                        <textarea name="aplicativos" id="aplicativos" class="gui-input" style="height: 120px; resize: vertical;"
                                                                            placeholder="Siesa facturación, creación de terceros, Intranet requisición de personal, Programador de turnos, CRM y ZOHO"></textarea>
                                                                        <label for="username" class="field-icon">
                                                                            <i class="fa fa-reorder"></i>
                                                                        </label>
                                                                    </label>
                                                                </div>


                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Requiere activo:
                                                                    </b>
                                                                </label>
                                                                <div class="col-md-8 d-flex"
                                                                    style="gap: 10px; flex-wrap: wrap;">
                                                                    @foreach ($herramientas as $herramienta)
                                                                        <div
                                                                            class="checkbox-wrapper-19 d-flex align-items-center">
                                                                            <input
                                                                                id="{{ $herramienta->id_herramienta }}"
                                                                                type="checkbox"
                                                                                value="{{ $herramienta->id_herramienta }}"
                                                                                name="requiere[]">
                                                                            <label style="min-height: 0px"
                                                                                class="check-box"
                                                                                for="{{ $herramienta->id_herramienta }}"></label>
                                                                            &nbsp;&nbsp;&nbsp;
                                                                            <p class="text-dark" style="margin: 0px">
                                                                                {{ $herramienta->nombre_herramienta }}
                                                                            </p>
                                                                        </div>
                                                                    @endforeach

                                                                </div>

                                                                <div class="col-md-6">

                                                                    <br>
                                                                    <br>
                                                                    <label
                                                                        style="color: #34495e; display:flex; justify-content:center">
                                                                        <b>Requiere dotacion:</b>
                                                                    </label>

                                                                    <div class="d-flex justify-content-center"
                                                                        style="gap: 10px">
                                                                        <div class="checkbox-wrapper-19 d-flex align-items-center"
                                                                            style="gap:14px">
                                                                            <p class="text-dark" style="margin: 0px">
                                                                                Si</p>
                                                                            <input id="si" type="radio"
                                                                                value="Si"
                                                                                name="requiere_dotacion">
                                                                            <label style="min-height: 0px"
                                                                                class="check-box"
                                                                                for="si"></label>
                                                                        </div>
                                                                        <div class="checkbox-wrapper-19 d-flex align-items-center"
                                                                            style="gap:14px">
                                                                            <p class="text-dark" style="margin: 0px">
                                                                                No
                                                                            </p>
                                                                            <input id="no" type="radio"
                                                                                value="No"
                                                                                name="requiere_dotacion">
                                                                            <label style="min-height: 0px"
                                                                                class="check-box"
                                                                                for="no"></label> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <br>
                                                                <div
                                                                    class="col-md-12 d-flex align-items-center justify-content-center">

                                                                    <button type="submit"
                                                                        class="btn btn-primary">Realizar
                                                                        Solicitud</button>
                                                                </div>

                                                            </div>
                                                            <br>
                                                            <br>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
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
                                            <tr style="background-color:#39405a">
                                                <th>
                                                    Mis solicitudes
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <font size="1">
                                                        (En proceso &nbsp;&nbsp;-&nbsp;&nbsp; Cerrados en los últimos 20
                                                        días)
                                                    </font>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tr>
                                            <td colspan="2">
                                                <table id="table-mis-solicitudes"
                                                    class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                    <thead>
                                                        <tr style="background-color: #F8F8F8; color:#000000">
                                                            <th style="text-align:left">
                                                                #
                                                            </th>
                                                            <th style="text-align:right">
                                                                Sol.
                                                            </th>
                                                            <th style="text-align: center">
                                                                Cargo
                                                            <th style="text-align: center">
                                                                Centro de operación
                                                            </th>
                                                            <th style="text-align: center">
                                                                Motivo
                                                            </th>
                                                            <th style="text-align: center">
                                                                Num. vacantes
                                                            </th>
                                                            <th style="text-align: center">
                                                                Fecha de solicitud
                                                            </th>
                                                            <th style="text-align: center">
                                                                Estado
                                                            </th>
                                                            <th style="text-align: center">
                                                                Más info.
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                        $u = 1;
                                                        $fechaanterior = date('Y-m-d', strtotime('-20 days')); // 20 días antes
                                                        $DatosSol = PanelRequisiciones::getSolicitudes20dias($DatLog->empleado, $fechaanterior);
                                                        ?>
                                                        @foreach ($DatosSol as $DatSol)
                                                            <tr class="message-unread">
                                                                <td style="text-align:left">
                                                                    <font color="#2A2F43">
                                                                        (<?php
                                                                        print $u;
                                                                        $u++;
                                                                        ?>)
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:right">
                                                                    <font color="#2A2F43">
                                                                        <b>
                                                                            {{ $DatSol->num_solicitud }}
                                                                        </b>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:left">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        $nombrec = PanelCargos::getCargo($DatSol->cargo);
                                                                        $Area = PanelAreas::getArea($nombrec[0]->area);
                                                                        $Empresa = PanelEmpresas::getEmpresa($Area[0]->empresa);
                                                                        echo $nombrec[0]->descripcion;
                                                                        echo '<br>';
                                                                        echo $Area[0]->descripcion . ' - ' . $Empresa[0]->nombre;
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:left">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        $nombcen = PanelCentrosOp::getCentroOp($DatSol->centro_operacion);
                                                                        echo $nombcen[0]->descripcion;
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:left">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        if ($DatSol->motivo == 'RP') {
                                                                            echo 'Reemplazo de personal';
                                                                        } elseif ($DatSol->motivo == 'CN') {
                                                                            echo 'Cargo nuevo / Incremento de personal';
                                                                        } elseif ($DatSol->motivo == 'LM') {
                                                                            echo 'Licencia de maternidad';
                                                                        } elseif ($DatSol->motivo == 'IP') {
                                                                            echo 'Incapacidad permanente';
                                                                        }
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?= $DatSol->num_vacantes ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center">
                                                                    <font color="#2A2F43">
                                                                        <?= $DatSol->fecha_solicita ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:left">
                                                                    <?php
                                                                    if ($DatSol->estado == 2 || $DatSol->estado == 4 || $DatSol->estado == 7 || $DatSol->estado == 8) {
                                                                        $color = 'red';
                                                                    } elseif ($DatSol->estado == 6) {
                                                                        $color = 'green';
                                                                    } else {
                                                                        $color = '#2A2F43';
                                                                    }

                                                                    echo '<font color=' . $color . '>';
                                                                    if ($DatSol->estado == '5' || $DatSol->estado == '3') {
                                                                        echo 'Activo';
                                                                    }
                                                                    if ($DatSol->estado == '1') {
                                                                        echo 'Pendiente';
                                                                    }
                                                                    if ($DatSol->estado == '2' || $DatSol->estado == '4') {
                                                                        echo 'Rechazada';
                                                                    }
                                                                    if ($DatSol->estado == '6') {
                                                                        echo 'Cerrado';
                                                                    }
                                                                    if ($DatSol->estado == '9') {
                                                                        echo 'Aplazado';
                                                                    }
                                                                    if ($DatSol->estado == '7' || $DatSol->estado == '8') {
                                                                        echo 'Cancelado';
                                                                    }
                                                                    if ($DatSol->estado == '10') {
                                                                        echo 'Finalizado';
                                                                    }
                                                                    echo '</font>';
                                                                    ?>
                                                                </td>

                                                                <td style="text-align: center">
                                                                    <button type="button"
                                                                        class="btn btn-default light"
                                                                        onclick="window.location.href='<?= $server ?>/panel/requisiciones/solicitud/masinfo/<?= $DatSol->num_solicitud ?>'"
                                                                        title="Más información">
                                                                        <i class="fa fa-exclamation-circle fa-lg"
                                                                            style="color:#AEBF25;"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- -------------- /Column Center -------------- -->
                    </div>
                </section>


                <!-- Button trigger modal -->

                <!-- -------------- /Content -------------- -->
            </section>
        </div>
        @include('includes-CDN/include-script')
        <script type="module" src="{{ asset('js/requisiciones/panel-solicitud.js') }}"></script>
    </body>

    </html>
@endforeach
