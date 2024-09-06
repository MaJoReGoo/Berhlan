<?php
$server = '/Berhlan/public';

use App\Models\Parametrizacion\PanelUsuarios;
use App\Models\Procesos\PanelDocumentos;
use App\Models\Procesos\PanelPerfiles;
use App\Models\Procesos\PanelTiposDocumentos;
use App\Models\Procesos\PanelSubProceDocu;
use App\Models\Parametrizacion\PanelEmpleados;
?>

@foreach ($DatosUsuario as $DatLog)
    @foreach ($DatosDocumento as $DatDoc)
        <!DOCTYPE html>
        <html>

        <head>
            <!-- -------------- Meta and Title -------------- -->
            <meta charset="utf-8">
            <title>
                Intranet | Modificar documento
            </title>

            <meta name="keywords" content="panel, cms, usuarios, servicio" />
            <meta name="description" content="Intranet para grupo Berhlan">
            <meta name="author" content="USUARIO">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <!-- -------------- Fonts -------------- -->
            <link rel='stylesheet' type='text/css'
                href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
            <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic'
                rel='stylesheet' type='text/css'>

            <!-- -------------- CSS - theme -------------- -->
            <link rel="stylesheet" type="text/css"
                href="<?= $server ?>/panelfiles/assets/skin/default_skin/css/theme.css">

            <!-- -------------- CSS - allcp forms -------------- -->
            <link rel="stylesheet" type="text/css"
                href="<?= $server ?>/panelfiles/assets/allcp/forms/css/forms.min.css">
            <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/allcp/forms/css/forms.css">

            <!-- -------------- Plugins -------------- -->
            <link rel="stylesheet" type="text/css"
                href="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

            <!-- -------------- Favicon -------------- -->
            <link rel="shortcut icon" href="<?= $server ?>/panelfiles/assets/img/favicon.ico">

            <!-- Editor -->
            <script type="text/javascript" src="<?= $server ?>/panelfiles/ckeditor/ckeditor.js"></script>
            <style>
                .cl-checkbox {
                    position: relative;
                    display: inline-block;
                }

                /* Input */
                .cl-checkbox>input {
                    appearance: none;
                    -moz-appearance: none;
                    -webkit-appearance: none;
                    z-index: -1;
                    position: absolute;
                    left: -10px;
                    top: -8px;
                    display: block;
                    margin: 0;
                    border-radius: 50%;
                    width: 40px;
                    height: 40px;
                    background-color: rgba(0, 0, 0, 0.6);
                    box-shadow: none;
                    outline: none;
                    opacity: 0;
                    transform: scale(1);
                    pointer-events: none;
                    transition: opacity 0.3s, transform 0.2s;
                }

                /* Span */
                .cl-checkbox>span {
                    display: inline-block;
                    width: 100%;
                    cursor: pointer;
                }

                /* Box */
                .cl-checkbox>span::before {
                    content: "";
                    display: inline-block;
                    box-sizing: border-box;
                    margin: 3px 11px 3px 1px;
                    border: solid 2px;
                    /* Safari */
                    border-color: rgba(0, 0, 0, 0.6);
                    border-radius: 2px;
                    width: 18px;
                    height: 18px;
                    vertical-align: top;
                    transition: border-color 0.2s, background-color 0.2s;
                }

                /* Checkmark */
                .cl-checkbox>span::after {
                    content: "";
                    display: block;
                    position: absolute;
                    top: 3px;
                    left: 1px;
                    width: 10px;
                    height: 5px;
                    border: solid 2px transparent;
                    border-right: none;
                    border-top: none;
                    transform: translate(3px, 4px) rotate(-45deg);
                }

                /* Checked, Indeterminate */
                .cl-checkbox>input:checked,
                .cl-checkbox>input:indeterminate {
                    background-color: #018786;
                }

                .cl-checkbox>input:checked+span::before,
                .cl-checkbox>input:indeterminate+span::before {
                    border-color: #018786;
                    background-color: #018786;
                }

                .cl-checkbox>input:checked+span::after,
                .cl-checkbox>input:indeterminate+span::after {
                    border-color: #fff;
                }

                .cl-checkbox>input:indeterminate+span::after {
                    border-left: none;
                    transform: translate(4px, 3px);
                }

                /* Hover, Focus */
                .cl-checkbox:hover>input {
                    opacity: 0.04;
                }

                .cl-checkbox>input:focus {
                    opacity: 0.12;
                }

                .cl-checkbox:hover>input:focus {
                    opacity: 0.16;
                }

                /* Active */
                .cl-checkbox>input:active {
                    opacity: 1;
                    transform: scale(0);
                    transition: transform 0s, opacity 0s;
                }

                .cl-checkbox>input:active+span::before {
                    border-color: #85b8b7;
                }

                .cl-checkbox>input:checked:active+span::before {
                    border-color: transparent;
                    background-color: rgba(0, 0, 0, 0.6);
                }

                /* Disabled */
                .cl-checkbox>input:disabled {
                    opacity: 0;
                }

                .cl-checkbox>input:disabled+span {
                    color: rgba(0, 0, 0, 0.38);
                    cursor: initial;
                }

                .cl-checkbox>input:disabled+span::before {
                    border-color: currentColor;
                }

                .cl-checkbox>input:checked:disabled+span::before,
                .cl-checkbox>input:indeterminate:disabled+span::before {
                    border-color: transparent;
                    background-color: currentColor;
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
                                    <a href="<?= $server ?>/panel/procesos/documentos"
                                        title="Procesos internos > Documentos">
                                        <font color="#34495e">
                                            Procesos internos > Documentos >
                                        </font>
                                        <font color="#b4c056">
                                            Modificar
                                        </font>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                            <a href="<?= $server ?>/panel/procesos/documentos" class="btn btn-primary btn-sm ml10"
                                title="Procesos internos > Documentos">
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
                                            <tr>
                                                <td>
                                                    <b>
                                                        <font color="#000000">
                                                            <?= $DatDoc->descripcion ?>
                                                        </font>
                                                    </b>
                                                </td>

                                                <td align="right">
                                                    <?php
                                                    $nombrearc = $DatDoc->ruta1;
                                                    $ext = explode('.', $nombrearc);
                                                    $ext1 = end($ext);

                                                    if ($ext1 == 'xlsx' || $ext1 == 'xls' || $ext1 == 'XLSX' || $ext1 == 'XLS' || $ext1 == 'xlsm' || $ext1 == 'XLSM') {
                                                        $fonicono = '28B463';
                                                        $icono = 'fa-file-excel-o';
                                                    } elseif ($ext1 == 'docx' || $ext1 == 'doc' || $ext1 == 'DOCX' || $ext1 == 'DOC') {
                                                        $fonicono = '226dbd';
                                                        $icono = 'fa-file-word-o';
                                                    } elseif ($ext1 == 'pdf' || $ext1 == 'PDF') {
                                                        $fonicono = 'b90202';
                                                        $icono = 'fa-file-pdf-o';
                                                    } elseif ($ext1 == 'pptx' || $ext1 == 'ppt' || $ext1 == 'PPTX' || $ext1 == 'PPT') {
                                                        $fonicono = 'ff4e22';
                                                        $icono = 'fa-file-powerpoint-o';
                                                    } elseif ($ext1 == 'jpg' || $ext1 == 'png' || $ext1 == 'gif' || $ext1 == 'JPG' || $ext1 == 'PNG' || $ext1 == 'GIF') {
                                                        $fonicono = 'f4d03f';
                                                        $icono = 'fa-file-image-o';
                                                    } else {
                                                        $fonicono = '000000';
                                                        $icono = 'fa-file-archive-o';
                                                    }
                                                    ?>

                                                    <button type="button" style="background:#f7f9f9;"
                                                        class="btn btn-default light"
                                                        onclick="window.open('<?= $server ?>/archivos/Procesos/Documentos/<?= $DatDoc->ruta1 . '?' . date('i:s') ?>','_blank')"
                                                        title="<?= $DatDoc->ruta1 ?>">
                                                        <i class="fa <?= $icono ?> fa-lg"
                                                            style="color:#<?= $fonicono ?>;"></i>
                                                    </button>
                                                </td>

                                                <td>
                                                    <b>
                                                        <font size="1" color="#000000">
                                                            <?= $DatDoc->ruta1 ?>
                                                            <br>
                                                            <?= $DatDoc->fecha1 ?>
                                                        </font>
                                                    </b>
                                                </td>

                                                <td align="right" style="vertical-align: top;">
                                                    <button type="button" class="btn btn-default light"
                                                        onclick="MASINFO()">
                                                        <i id="btnmasinfo" class="fa fa-sort-amount-desc fa-lg"
                                                            style="color:#AEBF25;" title="Más información"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            <tr id="masinfo" style="display:none;">
                                                <td align="center">
                                                    <?php
                                                    $DatosLogs = PanelDocumentos::getDocumentoLogs($DatDoc->id_documento);
                                                    $e = 1;
                                                    if (sizeof($DatosLogs) == 0) {
                                                        $largo = '45px';
                                                    } else {
                                                        $largo = '280px';
                                                    }
                                                    ?>

                                                    <div style="height:<?= $largo ?>; width:100%; overflow:auto;">
                                                        <table id="message-table"
                                                            class="table allcp-form theme-warning br-t">
                                                            <tr>
                                                                <td colspan="3">
                                                                    <font size="3" color="#000000">
                                                                        <b>
                                                                            Detalle de modificaciones
                                                                        </b>
                                                                    </font>
                                                                </td>
                                                            </tr>

                                                            @foreach ($DatosLogs as $DatLogs)
                                                                <tr>
                                                                    <td>
                                                                        <font size="1" color="#000000">
                                                                            <?php
                                                                            echo $e++;
                                                                            ?>
                                                                        </font>
                                                                    </td>

                                                                    <td>
                                                                        <div style="text-align: justify">
                                                                            <font color="#000000">
                                                                                <?= $DatLogs->observaciones ?>
                                                                            </font>
                                                                        </div>
                                                                    </td>

                                                                    <td align="center" nowrap="">
                                                                        <font size="1" color="#000000">
                                                                            <?php
                                                                            $Login = PanelUsuarios::getUsuario($DatLogs->usuario);
                                                                            echo $Login[0]->login;
                                                                            ?>
                                                                            <br>
                                                                            <?= $DatLogs->fecha ?>
                                                                        </font>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </td>

                                                <td style="vertical-align: top;" align="right">
                                                    <?php
                            if($DatDoc->ruta2 != '')
                             {
                              $nombrearc2 = $DatDoc->ruta2;
                              $ext        = explode('.', $nombrearc2);
                              $ext1       = end($ext);

                              if(($ext1 == 'xlsx') || ($ext1 == 'xls') || ($ext1 == 'XLSX') || ($ext1 == 'XLS') || ($ext1 == 'xlsm') || ($ext1 == 'XLSM'))
                               {
                                $fonicono = "28B463";
                                $icono    = "fa-file-excel-o";
                               }
                              else if(($ext1 == 'docx') || ($ext1 == 'doc') || ($ext1 == 'DOCX') || ($ext1 == 'DOC'))
                               {
                                $fonicono = "226dbd";
                                $icono    = "fa-file-word-o";
                               }
                              else if(($ext1 == 'pdf') || ($ext1 == 'PDF'))
                               {
                                $fonicono = "b90202";
                                $icono    = "fa-file-pdf-o";
                               }
                              else if(($ext1 == 'pptx') || ($ext1 == 'ppt') || ($ext1 == 'PPTX') || ($ext1 == 'PPT'))
                               {
                                $fonicono = "ff4e22";
                                $icono    = "fa-file-powerpoint-o";
                               }
                              else if(($ext1 == 'jpg') || ($ext1 == 'png') || ($ext1 == 'gif') || ($ext1 == 'JPG') || ($ext1 == 'PNG') || ($ext1 == 'GIF'))
                               {
                                $fonicono = "f4d03f";
                                $icono    = "fa-file-image-o";
                               }
                              else
                               {
                                $fonicono = "000000";
                                $icono    = "fa-file-archive-o";
                               }
                              ?>

                                                    <button type="button" style="background:#f7f9f9;"
                                                        class="btn btn-default light"
                                                        onclick="window.open('<?= $server ?>/archivos/Procesos/Documentos/<?= $DatDoc->ruta2 . '?' . date('i:s') ?>','_blank')"
                                                        title="<?= $DatDoc->ruta2 ?>">
                                                        <i class="fa <?= $icono ?> fa-lg"
                                                            style="color:#<?= $fonicono ?>;"></i>
                                                    </button>
                                                    <?php
                             }
                            ?>
                                                </td>

                                                <th style="vertical-align: top;" nowrap="">
                                                    <b>
                                                        <font size="2" color="#000000">
                                                            Versión anterior
                                                        </font>
                                                        <font size="1" color="#000000">
                                                            <br>
                                                            <?= $DatDoc->ruta2 ?>
                                                            <br>
                                                            <?= $DatDoc->fecha2 ?>
                                                        </font>
                                                    </b>
                                                    </td>
                                            </tr>
                                        </table>

                                        <script language="javascript" type="text/javascript">
                                            function MASINFO() {
                                                tr = document.getElementById('masinfo');
                                                id = document.getElementById('btnmasinfo');
                                                if (tr.style.display == '') {
                                                    tr.style.display = 'none';
                                                    id.className = 'fa fa-sort-amount-desc fa-lg';
                                                    id.title = "Más información";
                                                } else {
                                                    tr.style.display = '';
                                                    id.className = 'fa fa-sort-up fa-lg';
                                                    id.title = "Menos información";
                                                }
                                            }
                                        </script>
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
                                                        Actualice la información del documento
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="allcp-form">
                                                            {!! Form::open([
                                                                'action' => 'Procesos\DocProcesosPanelController@DocumentosModificarDB',
                                                                'class' => 'form',
                                                                'id' => 'form-wizard',
                                                                'files' => true,
                                                            ]) !!}
                                                            {!! Form::hidden('login', $DatLog->login) !!}
                                                            {!! Form::hidden('id_documento', $DatDoc->id_documento) !!}

                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label style="color:#34495e">
                                                                        <b>
                                                                            Descripción
                                                                        </b>
                                                                    </label>
                                                                    <label class="field prepend-icon">
                                                                        {!! Form::text('descripcion', $DatDoc->descripcion, [
                                                                            'required',
                                                                            'id' => 'descripcion',
                                                                            'class' => 'gui-input',
                                                                            'placeholder' => '* Descripción',
                                                                        ]) !!}
                                                                        <label for="username" class="field-icon">
                                                                            <i class="fa fa-file"></i>
                                                                        </label>
                                                                    </label>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label style="color: #34495e">
                                                                        <b>
                                                                            Grupo
                                                                        </b>
                                                                    </label>
                                                                    <label class="field select">
                                                                        <select name="tipo" id="tipo"
                                                                            required>
                                                                            <option value="<?= $DatDoc->tipo ?>">
                                                                                <?php
                                                                                $Tipo = PanelTiposDocumentos::getTipo($DatDoc->tipo);
                                                                                echo $Tipo[0]->descripcion;
                                                                                ?>
                                                                            </option>
                                                                            <?php
                                                                            $Tipos = PanelTiposDocumentos::getTiposDocumentos();
                                                                            ?>
                                                                            @foreach ($Tipos as $DatTip)
                                                                                <option
                                                                                    value="<?= $DatTip->id_tipo ?>">
                                                                                    <?= $DatTip->descripcion ?>
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <i class="arrow"></i>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <br>
                                                                <div class="col-md-3">
                                                                    <label style="color:#34495e">
                                                                        <b>
                                                                            Archivo
                                                                        </b>
                                                                        (Adjunte únicamente si desea actualizar el
                                                                        archivo)
                                                                    </label>
                                                                    <label
                                                                        class="field prepend-icon append-button file">
                                                                        <span class="button">
                                                                            Archivo
                                                                        </span>
                                                                        {!! Form::file('file1', [
                                                                            'id' => 'file1',
                                                                            'class' => 'gui-file',
                                                                            'onChange' => "document.getElementById('uploader1').value = this.value;",
                                                                        ]) !!}
                                                                        {!! Form::text('uploader1', null, [
                                                                            'id' => 'uploader1',
                                                                            'class' => 'gui-input',
                                                                            'placeholder' => 'Seleccione el archivo',
                                                                        ]) !!}
                                                                        <label class="field-icon">
                                                                            <i class="fa fa-cloud-upload"></i>
                                                                        </label>
                                                                    </label>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label style="color:#34495e">
                                                                        <b>
                                                                            Observaciones del cambio
                                                                        </b>
                                                                    </label>
                                                                    <label class="field prepend-icon">
                                                                        {!! Form::textarea('observaciones', '', [
                                                                            'cols' => 6,
                                                                            'required',
                                                                            'id' => 'observaciones',
                                                                            'class' => 'gui-input',
                                                                            'style' => 'height: 55px;',
                                                                            'placeholder' => '* Explique el cambio realizado',
                                                                        ]) !!}
                                                                        <label for="username" class="field-icon">
                                                                            <i class="fa fa-reorder"></i>
                                                                        </label>
                                                                    </label>
                                                                </div>
                                                                <div class="col-sm-3 col-md-3">
                                                                    <br>
                                                                    <br>
                                                                    <label class="cl-checkbox">
                                                                        {!! Form::checkbox('actual', 1, false) !!}
                                                                       {{-- <input id="actual" name="actual" value="1"  type="checkbox"> --}}
                                                                        <span><b>Version actual</b></span>
                                                                      </label>

                                                                </div>

                                                                <div class="col-sm-3 col-md-3">
                                                                    <br>
                                                                    <br>
                                                                    <label class="cl-checkbox">
                                                                        {!! Form::checkbox('anterior', 1, false) !!}


                                                                        {{-- <input id="anterior" name="anterior" value="1"  type="checkbox"> --}}
                                                                        <span><b>Version anterior</b></span>
                                                                      </label>

                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                                <br>
                                                                <div class="col-md-4" align="left">
                                                                    {!! Form::submit('Modificar documento', ['class' => 'button']) !!}
                                                                    <br><br>
                                                                </div>

                                                            </div>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td align="justify">
                                                        <font size="3" color="#000000">
                                                            <b>
                                                                Subprocesos asociados:
                                                            </b>
                                                            <?php
                                                            $SubProcesos = PanelSubProceDocu::getSubProDocumen($DatDoc->id_documento);
                                                            ?>
                                                            @foreach ($SubProcesos as $DatSub)
                                                                <?= $DatSub->descripcion ?>
                                                                &nbsp;||&nbsp;
                                                            @endforeach
                                                        </font>
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
                                                        <button type="button" class="btn btn-default light"
                                                            onclick="MASINFO1()">
                                                            <i id="btnmasinfo1" class="fa fa-sort-amount-desc fa-lg"
                                                                style="color:#AEBF25;" title="Más información"></i>
                                                        </button>
                                                        &nbsp;
                                                        Perfiles asociados
                                                    </th>

                                                 {{--    <td align="right">
                                                        <button type="button" class="btn btn-default light"
                                                            onclick="window.location.href='<?= $server ?>/panel/procesos/documeperfil/agregar/<?= $DatDoc->id_documento ?>'"
                                                            title="Asociar perfil">
                                                            <span class="fa fa-plus pr5"
                                                                style="color:#AEBF25;"></span>
                                                            <span class="fa fa-credit-card pr5"
                                                                style="color:#AEBF25;"></span>
                                                        </button>
                                                    </td> --}}
                                                </tr>
                                            </thead>

                                            <tbody id="tbperfil" style="display:none;">
                                                <tr>
                                                    <td colspan="2">
                                                        <table id="message-table"
                                                            class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                                            <thead>
                                                                <tr style="background-color: #F8F8F8; color:#000000">
                                                                    <th style="text-align: left">
                                                                        #
                                                                    </th>
                                                                    <th style="text-align: left">
                                                                        Perfil
                                                                    </th>
                                                                    <th style="text-align: center">
                                                                        Desasociar
                                                                    </th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <?php
                                                                $u = 1;
                                                                $DatosPerfiles = PanelPerfiles::getDocumentosPerfil($DatDoc->id_documento);
                                                                $DatosUsuario = PanelPerfiles::getDocumentosUsuario($DatDoc->id_documento);
                                                                ?>

                                                                @foreach ($DatosPerfiles as $DatPer)
                                                                    <tr class="message-unread">
                                                                        <td style="text-align:left">
                                                                            <font color="#2A2F43">
                                                                                <?php
                                                                                print $u;
                                                                                $u++;
                                                                                ?>
                                                                            </font>
                                                                        </td>

                                                                        <td style="text-align: left ">
                                                                            <font color="#2A2F43">
                                                                                <b>
                                                                                    <?= $DatPer->descripcion ?>
                                                                                </b>
                                                                            </font>
                                                                        </td>

                                                                        <td style="text-align: center">
                                                                            <button type="button"
                                                                                class="btn btn-default light"
                                                                                onclick="BORRAR('<?= $DatPer->id_perfil ?>', '<?= $DatPer->descripcion ?>')"
                                                                                title="Desasociar perfil">
                                                                                <i class="fa fa-trash fa-lg"
                                                                                    style="color:#F6565A;"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                @foreach ($DatosUsuario as $DatUsr)
                                                                    <tr class="message-unread">
                                                                        <td style="text-align:left">
                                                                            <font color="#2A2F43">
                                                                                <?php
                                                                                print $u;
                                                                                $u++;
                                                                                ?>
                                                                            </font>
                                                                        </td>

                                                                        <td style="text-align: left ">
                                                                            <font color="#2A2F43">
                                                                                <b>
                                                                                    @php
                                                                                        $Empleado = PanelEmpleados::getEmpleado($DatUsr->empleado);
                                                                                    @endphp

                                                                                    <?= $Empleado[0]->primer_nombre . ' ' . $Empleado[0]->primer_apellido ?>
                                                                                </b>
                                                                            </font>
                                                                        </td>

                                                                        <td style="text-align: center">
                                                                            <button type="button"
                                                                                class="btn btn-default light"
                                                                                onclick="BORRAR('<?= $DatUsr->id_usuario ?>', '<?= $Empleado[0]->primer_nombre . ' ' . $Empleado[0]->primer_apellido ?>')"
                                                                                title="Desasociar perfil">
                                                                                <i class="fa fa-trash fa-lg"
                                                                                    style="color:#F6565A;"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                <?php
                                  if($u == 1)
                                   {
                                    ?>
                                                                <tr class="message-unread">
                                                                    <td colspan="3" style="text-align:left">
                                                                        <font color="#2A2F43">
                                                                            <b>
                                                                                Nota:
                                                                            </b>
                                                                            No se encuentra ningún perfil asociado al
                                                                            documento, por lo tanto, el archivo no tiene
                                                                            restricción de descarga.
                                                                        </font>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                   }
                                  ?>
                                                            </tbody>
                                                        </table>

                                                        {!! Form::open([
                                                            'action' => 'Procesos\DocPerProcesosPanelController@DocumePerfilEliminarDB',
                                                            'class' => 'form',
                                                            'id' => 'form-wizard',
                                                            'name' => 'frmenvio',
                                                        ]) !!}
                                                        {!! Form::hidden('login', $DatLog->login) !!}
                                                        {!! Form::hidden('id_documento', $DatDoc->id_documento) !!}
                                                        {!! Form::hidden('id_perfil', '') !!}
                                                        {!! Form::hidden('id_usuario', '') !!}
                                                        {!! Form::close() !!}

                                                        <script language="javascript" type="text/javascript">
                                                            function MASINFO1() {
                                                                tbody = document.getElementById('tbperfil');
                                                                id = document.getElementById('btnmasinfo1');
                                                                if (tbody.style.display == '') {
                                                                    tbody.style.display = 'none';
                                                                    id.className = 'fa fa-sort-amount-desc fa-lg';
                                                                    id.title = "Más información";
                                                                } else {
                                                                    tbody.style.display = '';
                                                                    id.className = 'fa fa-sort-up fa-lg';
                                                                    id.title = "Menos información";
                                                                }
                                                            }

                                                            function BORRAR(sub, nom) {
                                                                var id = sub;
                                                                var id1 = nom;

                                                                if (!(confirm("Confirme el retiro del perfil (" + id1 + ").")))
                                                                    return false;

                                                                frm = document.forms["frmenvio"];
                                                                frm.id_perfil.value = id;
                                                                frm.id_usuario.value = id;
                                                                document.frmenvio.submit();
                                                            }
                                                        </script>
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
            <script src="<?= $server ?>/panelfiles/assets/js/pages/allcp_forms-elements.js"></script>
            <script src="<?= $server ?>/panelfiles/assets/js/demo/widgets_sidebar.js"></script>

            <!-- -------------- Page JS -------------- -->
            <script src="<?= $server ?>/panelfiles/assets/js/demo/charts/highcharts.js"></script>

            <!-- -------------- /Scripts -------------- -->
        </body>

        </html>
    @endforeach
@endforeach
