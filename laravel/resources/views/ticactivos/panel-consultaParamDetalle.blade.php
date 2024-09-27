<?php

use App\Models\TicActivos\PanelTipos;
use App\Models\TicActivos\PanelTareas;
use App\Models\TicActivos\PanelMarcas;
use App\Models\TicActivos\PanelLicencias;
use App\Models\TicActivos\PanelTpOffice;
use App\Models\TicActivos\PanelActivos;
use App\Models\TicActivos\PanelConsultas;
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
                                <a href="{{ asset ('/panel/ticactivos/consultasparam')}}"
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
                        <a href="{{ asset ('/panel/ticactivos/consultasparam')}}" class="btn btn-primary btn-sm ml10"
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
                                                            /* $Empres = PanelEmpresas::getEmpresa($Area[0]->empresa);
 echo $Empres[0]->nombre; */
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Marca y modelo:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            $Marca = PanelMarcas::getMarca($DatosActivo[0]->marca);
                                                            echo $Marca[0]->descripcion;
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Serial:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?= $DatosActivo[0]->serial ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Código interno:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?= $DatosActivo[0]->cod_interno ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Activo fijo:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?= $DatosActivo[0]->activofijo ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Fecha de adquisición:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?= $DatosActivo[0]->fechaadq ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Valor compra:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            if ($DatosActivo[0]->valor_compra > 0) {
                                                                echo $DatosActivo[0]->valor_compra;
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Usuario y contraseña:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?= $DatosActivo[0]->usrclave ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Garantía hasta:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?= $DatosActivo[0]->garantia ?>
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
                                                                onclick="window.open('{{ asset ('/archivos/Activostic/Fotos/')}}<?= $DatosActivo[0]->foto ?>','_blank')"
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
                                                            Factura:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                if($DatosActivo[0]->factura != '')
                                 {
                                  ?>
                                                            <button type="button" style="background:#f7f9f9;"
                                                                class="btn btn-default light"
                                                                onclick="window.open('{{ asset ('/archivos/Activostic/Facturas/')}}<?= $DatosActivo[0]->factura ?>','_blank')"
                                                                title="<?= $DatosActivo[0]->factura ?>">
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
                                                            Acta firmada:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                if($DatosActivo[0]->actafirmada != '')
                                 {
                                  ?>
                                                            <button type="button" style="background:#f7f9f9;"
                                                                class="btn btn-default light"
                                                                onclick="window.open('{{ asset ('/archivos/Activostic/Actas_firmadas/')}}<?= $DatosActivo[0]->actafirmada ?>','_blank')"
                                                                title="<?= $DatosActivo[0]->actafirmada ?>">
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
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
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

                                                        <th style="text-align:left">
                                                            Fecha inicial para mantenimiento:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?php
                                                            if ($DatosActivo[0]->mantenimiento == 'N') {
                                                                echo 'No aplica';
                                                            } else {
                                                                echo $DatosActivo[0]->fechamtto;
                                                            }
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Dirección MAC 1:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?= $DatosActivo[0]->mac1 ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Dirección IP 1:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <?= $DatosActivo[0]->ip1 ?>
                                                        </td>


                                                        <th style="text-align:left">
                                                            Observaciones:
                                                        </th>
                                                        <td style="text-align:justify;">
                                                            <?= $DatosActivo[0]->observaciones ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Estado:
                                                        </th>
                                                        <td>
                                                            <?php
                                                            if ($DatosActivo[0]->estado == '1') {
                                                                echo 'Activo';
                                                            } else {
                                                                echo 'Inactivo';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <?php
                            if($Tipo[0]->campos_pc == "S")
                             {
                              ?>
                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Tamaño del DD:
                                                        </th>
                                                        <td>
                                                            <?= $DatosActivo[0]->tamano_dd ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Tipo de DD:
                                                        </th>
                                                        <td>
                                                            <?= $DatosActivo[0]->tipo_dd ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Tamaño de RAM:
                                                        </th>
                                                        <td>
                                                            <?= $DatosActivo[0]->tamano_ram ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Tipo de RAM:
                                                        </th>
                                                        <td>
                                                            <?= $DatosActivo[0]->tipo_ram ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Procesador:
                                                        </th>
                                                        <td>
                                                            <?= $DatosActivo[0]->procesador ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Licencia de office:
                                                        </th>
                                                        <td>
                                                            <?php
                                                            if ($DatosActivo[0]->office != 0) {
                                                                $Licencia = PanelLicencias::getLicencia($DatosActivo[0]->office);
                                                                $Tpoffice = PanelTpOffice::getTpOffice($Licencia[0]->tipo);
                                                                echo $Tpoffice[0]->descripcion;
                                                                echo '<br>';
                                                                echo $Licencia[0]->descripcion;
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Dirección MAC 2:
                                                        </th>
                                                        <td>
                                                            <?= $DatosActivo[0]->mac2 ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Dirección IP 2:
                                                        </th>
                                                        <td>
                                                            <?= $DatosActivo[0]->ip2 ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            Control remoto:
                                                        </th>
                                                        <td>
                                                            <?= $DatosActivo[0]->controlremoto ?>
                                                        </td>
                                                    </tr>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Licencia de Windows:
                                                        </th>
                                                        <td style="text-align:left;" colspan="5">
                                                            <?php
                                                            if ($DatosActivo[0]->lic_windows == 'S') {
                                                                echo 'Sí';
                                                            } else {
                                                                echo 'No';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <?php
                              $Programas = PanelActivos::Programasinstalados($DatosActivo[0]->id_activo);
                              if($Programas->count() > 0)
                               {
                                ?>
                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            Software instalado:
                                                        </th>

                                                        <td align="left" colspan="5">
                                                            @foreach ($Programas as $DatPro)
                                                                <?= $DatPro->descripcion ?> -
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    <?php
                               }
                             }
                            if(($Tipo[0]->campo1 != "") || ($Tipo[0]->campo2 != "") || ($Tipo[0]->campo3 != ""))
                             {
                              ?>
                                                    <tr style="background-color: #F8F8F8; color:#000000">
                                                        <th style="text-align:left">
                                                            <?php
                                                            if ($Tipo[0]->campo1 != '') {
                                                                echo $Tipo[0]->campo1 . ':';
                                                            }
                                                            ?>
                                                        </th>
                                                        <td style="text-align:left;">
                                                            <?php
                                                            if ($Tipo[0]->campo1 != '') {
                                                                echo $DatosActivo[0]->campo1;
                                                            }
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            <?php
                                                            if ($Tipo[0]->campo2 != '') {
                                                                echo $Tipo[0]->campo2 . ':';
                                                            }
                                                            ?>
                                                        </th>
                                                        <td style="text-align:left;">
                                                            <?php
                                                            if ($Tipo[0]->campo2 != '') {
                                                                echo $DatosActivo[0]->campo2;
                                                            }
                                                            ?>
                                                        </td>

                                                        <th style="text-align:left">
                                                            <?php
                                                            if ($Tipo[0]->campo3 != '') {
                                                                echo $Tipo[0]->campo3 . ':';
                                                            }
                                                            ?>
                                                        </th>
                                                        <td style="text-align:left;">
                                                            <?php
                                                            if ($Tipo[0]->campo3 != '') {
                                                                echo $DatosActivo[0]->campo3;
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                             }
                            ?>

                                                    <tr style="background-color: #F8F8F8; color:#000000">
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

                                                        <th style="text-align:left">
                                                            Acta:
                                                        </th>
                                                        <td style="text-align:left">
                                                            <button type="button" class="btn btn-default light"
                                                                onclick="actas()"
                                                                title="Acta">
                                                                <i class="fa fa-file-pdf-o fa-lg"
                                                                    style="color:red;"></i>
                                                            </button>
                                                        </td>

                                                        <td>
                                                            <button type="button" class="btn btn-default light"
                                                                onclick="window.location.href='{{ asset ('/panel/ticactivos/modificaract/<?= $DatosActivo[0]->id_activo ?>'"
                                                                title="Modificar">
                                                                <i class="fa fa-pencil-square-o fa-lg"
                                                                    style="color:blue;"> Editar</i>
                                                            </button>
                                                            </th>

                                                        <td style="text-align:left">
                                                            <?php
                                                            if ($DatosActivo[0]->mantenimiento == 'S') {
                                                                echo 'Fecha esperada próximo mantenimiento: ';
                                                                echo "<font color=\"green\">";
                                                                //Consulto la ultima actividad
                                                                $UltFecha = PanelConsultas::FechaUltActividad($DatosActivo[0]->id_activo);

                                                                echo date('Y-m-d', strtotime($UltFecha[0]->fecha . '+' . $DatosActivo[0]->mes_mtto . ' month'));
                                                                echo '</font>';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </table>
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
                                                        {!! Form::open([
                                                            'action' => 'TicActivos\ActivosTicActivosPanelController@IngresarActividadDB',
                                                            'class' => 'form',
                                                            'id' => 'form-wizard',
                                                            'files' => true,
                                                        ]) !!}
                                                        {!! Form::hidden('activo', $DatosActivo[0]->id_activo) !!}
                                                        {!! Form::hidden('mttosn', $DatosActivo[0]->mantenimiento) !!}

                                                        <?php
                                if($DatosActivo[0]->mantenimiento == 'S')
                                 {
                                  ?>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Mantenimiento
                                                                    </b>
                                                                </label>
                                                                <label class="option block">
                                                                    <div class="btn-group btn-group-toggle"
                                                                        data-toggle="buttons">
                                                                        <label class="btn btn-secondary"
                                                                            onclick="COLOR('P')">
                                                                            <i class="fa fa-1x" id="mantenimientop"
                                                                                style="color:grey;"> Preventivo</i>
                                                                            <input type="radio" name="mantenimiento"
                                                                                value="P" autocomplete="off">
                                                                        </label>
                                                                        <label class="btn btn-secondary"
                                                                            onclick="COLOR('C')">
                                                                            <i class="fa fa-1x" id="mantenimientoc"
                                                                                style="color:grey;"> Correctivo</i>
                                                                            <input type="radio" name="mantenimiento"
                                                                                value="C" autocomplete="off">
                                                                        </label>
                                                                        <label class="btn btn-secondary active"
                                                                            onclick="COLOR('N')">
                                                                            <i class="fa fa-1x" id="mantenimienton"
                                                                                style="color:green;"> No aplica como
                                                                                mantenimiento</i>
                                                                            <input type="radio" name="mantenimiento"
                                                                                value="N" autocomplete="off"
                                                                                checked>
                                                                        </label>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-12">
                                                                <label style="color:#34495e;">
                                                                    <b>
                                                                        Actividades realizadas
                                                                    </b>
                                                                </label>
                                                                <?php
                                                                $Tareas = PanelTareas::getTareasActivas();
                                                                $e = 0;
                                                                ?>
                                                                <table id="message-table"
                                                                    class="table allcp-form theme-warning br-t">
                                                                    <tr>
                                                                        {!! Form::hidden('actividades[]', 300) !!}
                                                                        @foreach ($Tareas as $DatTar)
                                                                            <td>
                                                                                <label class="option block"
                                                                                    style="color:#34495e;">
                                                                                    <?php
                                                                                    $e++;
                                                                                    ?>
                                                                                    {!! Form::checkbox('actividades[]', $DatTar->id_tarea) !!}
                                                                                    <span
                                                                                        class="checkbox"></span><b><?= $DatTar->descripcion ?></b>
                                                                                </label>
                                                                            </td>
                                                                            <?php
                                                                            if ($e % 4 == 0) {
                                                                                echo '</tr><tr>';
                                                                            }
                                                                            ?>
                                                                        @endforeach
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <?php
                                 }
                                ?>

                                                        <div class="row">
                                                            <br>
                                                            <div class="col-md-4">
                                                                <label style="color: #34495e">
                                                                    <b>
                                                                        Observaciones
                                                                    </b>
                                                                </label>
                                                                <label class="field prepend-icon">
                                                                    {!! Form::textarea('observaciones', '', [
                                                                        '',
                                                                        'id' => 'observaciones',
                                                                        'class' => 'gui-input',
                                                                        'style' => 'height: 50px;',
                                                                        'placeholder' => 'Observaciones',
                                                                    ]) !!}
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
                                                        {!! Form::close() !!}
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <script language="javascript" type="text/javascript">
                                        function COLOR(id1) {
                                            icono1 = document.getElementById('mantenimientop');
                                            icono2 = document.getElementById('mantenimientoc');
                                            icono3 = document.getElementById('mantenimienton');

                                            if (id1 == "P") {
                                                icono1.style.color = 'green';
                                                icono2.style.color = 'grey';
                                                icono3.style.color = 'grey';
                                            } else if (id1 == "C") {
                                                icono1.style.color = 'grey';
                                                icono2.style.color = 'green';
                                                icono3.style.color = 'grey';
                                            } else {
                                                icono1.style.color = 'grey';
                                                icono2.style.color = 'grey';
                                                icono3.style.color = 'green';
                                            }
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>

                        <?php
              $DatosActividades = PanelActivos::Actividades($DatosActivo[0]->id_activo);
              $u = 1;
              if($DatosActividades->count() > 0)
               {
                ?>
                        <br>

                        <div class="panel m3">
                            <!-- -------------- Message Body -------------- -->
                            <div class="nano-content">
                                <div class="table-responsive">
                                    <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <thead>
                                            <tr style="background-color:#39405a">
                                                <th>
                                                    Actividades realizadas
                                                </th>
                                            </tr>
                                        </thead>

                                        <tr>
                                            <td>
                                                <table id="message-table"
                                                    class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                    <thead>
                                                        <tr style="background-color: #F8F8F8; color:#000000">
                                                            <th style="text-align:left">
                                                                #
                                                            </th>
                                                            <?php
                                  if($DatosActivo[0]->mantenimiento == 'S')
                                   {
                                    ?>
                                                            <th style="text-align:center;">
                                                                MTTO
                                                            </th>
                                                            <th style="text-align:center;">
                                                                Actividades
                                                            </th>
                                                            <?php
                                   }
                                  ?>
                                                            <th style="text-align:center;">
                                                                Observaciones
                                                            </th>
                                                            <th style="text-align:center;">
                                                                Usuario y Fecha
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
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

                                                                <?php
                                    if($DatosActivo[0]->mantenimiento == 'S')
                                     {
                                      ?>
                                                                <td style="text-align:justify;">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        if ($DatAct->mantenimiento == 'C') {
                                                                            echo 'Correctivo';
                                                                        } elseif ($DatAct->mantenimiento == 'P') {
                                                                            echo 'Preventivo';
                                                                        } else {
                                                                            echo 'No aplica';
                                                                        }
                                                                        ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:justify;">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                          $Tareas = PanelActivos::TareasActividades($DatAct->id_actividad);
                                          if($Tareas->count() > 0)
                                           {
                                            ?>
                                                                        @foreach ($Tareas as $DatTaA)
                                                                            <?= $DatTaA->descripcion ?> -
                                                                        @endforeach
                                                                        <?php
                                           }
                                          ?>
                                                                    </font>
                                                                </td>
                                                                <?php
                                     }
                                    ?>

                                                                <td style="text-align:justify;">
                                                                    <font color="#2A2F43">
                                                                        <?= $DatAct->observaciones ?>
                                                                    </font>
                                                                </td>

                                                                <td style="text-align:center;">
                                                                    <font color="#2A2F43">
                                                                        <?php
                                                                        $empleado = PanelEmpleados::getEmpleado($DatAct->usuario);
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
                                                                        echo '<br>';
                                                                        echo $DatAct->fecha;
                                                                        ?>
                                                                    </font>
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
                        <?php
               }
              ?>
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
                                                <th style="display: flex; justify-content: flex-end;">
                                                    <form method="GET" action="{{ route('usuario.activo') }}" enctype="multipart/form-data"
                      class="form-inline">
                      @csrf
                                                    <button type="submit" name="activo_act" id="activo_act" value="{{$DatosActivo[0]->id_activo}}" class="btn btn-secondary"
                                                        style="align-items: flex-end" >
                                                        <img src="{{ asset ('/images/folder')}} (1).png"
                                                            alt="">
                                                    </button>
                                                </form>
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
                                                    $DatosCambios = PanelActivos::Cambios($DatosActivo[0]->id_activo);
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
        <script>
            function actas() {
                setTimeout(() => {
                    window.open('{{ asset ('/archivos/ANEXO_DOCUMENTO_ACTIVO.pdf')}}', '_blank');
                    window.open('{{ asset ('/archivos/AUTORIZACION_DE_DESCUENTO.pdf')}}', '_blank');
                }, 0);
                window.location.href = '{{ asset ('/panel/ticactivos/acta/')}}<?= $DatosActivo[0]->id_activo ?>';
            }
        </script>
    </body>

    </html>
@endforeach
