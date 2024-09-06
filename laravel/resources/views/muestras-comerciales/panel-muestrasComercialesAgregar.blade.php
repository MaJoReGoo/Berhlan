<?php
$server = '/Berhlan/public';
$FechaHoy = date('Y-m-d');
?>

@foreach($DatosUsuario as $DatLog)
<!DOCTYPE html>
<html>

<head>
    <!-- -------------- Meta and Title -------------- -->
    <meta charset="utf-8">
    <title>
        Intranet | Agregar Muestras Comerciales
    </title>
    <meta name="keywords" content="panel, cms, usuarios, servicio" />
    <meta name="description" content="Intranet para grupo Berhlan">
    <meta name="author" content="USUARIO">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- -------------- CSS -------------- -->
    @include('includes-CDN/include-head')
    <!-- -------------- CSS -------------- -->

    <!-- Select 2 -->
    <style>
        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 42px !important;
            user-select: none;
            -webkit-user-select: none;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            visibility: hidden !important;
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
                            <a href="<?= $server ?>/noticias/noticias" title="Muestras Comerciales">
                                <font color="#34495e">
                                    Muestras Comerciales >
                                </font>
                                <font color="#b4c056">
                                    Agregar
                                </font>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                    <a href="javascript:history.back()" class="btn btn-primary btn-sm ml10" title="Procesos internos > Documentos">
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
                                                Ingrese la información de las Muestras Comerciales
                                            </th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="allcp-form">
                                                    {!! Form::open(array('action' => 'MuestrasComerciales\MuestrasComercialesPanelController@MuestrasComercialesAgregarDB', 'class' => 'form', 'id'=>'form-wizard', 'files' => true)) !!}
                                                    {!! Form::hidden('login', $DatLog->login) !!}
                                                    {!! Form::hidden('idEmpleado', $idEmpleado) !!}
                                                    {!! Form::hidden('marca', $marca) !!}

                                                    <!-- Fecha, Empleado -->
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label style="color: #4ECCDB">Fecha de Solicitud</label>
                                                            <label for="datepicker1" class="field prepend-icon">
                                                                <input type="date" id="fecha_solicitud" name="fecha_solicitud" value="<?= $FechaHoy ?>" required style="width: 100%">
                                                                <label class="field-icon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label style="color: #4ECCDB">Fecha Estimada Entrega</label>
                                                            <label for="datepicker1" class="field prepend-icon">
                                                                <input type="date" id="fecha_entrega" name="fecha_entrega" value="" required style="width: 100%">
                                                                <label class="field-icon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label style="color: #0BACBF">Asesor Comercial / Colaborador *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="empleado" value="<?= $NombreEmpleado ?>" type="text" readonly style="width: 100%">
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-user"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!-- Fecha, Empleado -->


                                                    <!-- Destinatario y Motivo -->
                                                    <div class="row">
                                                        <br />
                                                        <div class="col-md-4">
                                                            <label style="color: #0BACBF">Destinatario *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="destinatario" value="" type="text" required style="width: 100%">
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-user"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label style="color: #0BACBF">Cel. Destinatario *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="cel-destinatario" value="" type="text" required style="width: 100%">
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-phone-square"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label style="color: #0BACBF">Motivo *</label>
                                                            <label class="field select">
                                                                <select name="motivo" id="motivo" required>
                                                                    <option value="">Seleccione</option>
                                                                    <option value="1">Muestras Showroom</option>
                                                                    <option value="2">Obsequios</option>
                                                                    <option value="3">Eventos</option>
                                                                    <option value="4">Muestras Directas Cliente</option>
                                                                    <option value="5">Muestras Para Comercial</option>
                                                                    <option value="6">E-Commerce</option>
                                                                    <option value="7">Muestras Publicidad</option>
                                                                </select>
                                                                <i class="arrow"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!-- Destinatario y Motivo -->

                                                    <!-- Cliente, Nit y Dirección -->
                                                    <div class="row">
                                                        <br />
                                                        <div class="col-md-3">
                                                            <label style="color: #0BACBF">Razón Social Cliente </label>
                                                            <label class="field prepend-icon">
                                                                <input name="razon_social" value="" type="text" style="width: 100%">
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-file"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label style="color: #0BACBF">Nit. Cliente </label>
                                                            <label class="field prepend-icon">
                                                                <input name="nit" value="" type="text" style="width: 100%">
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-file"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label style="color: #0BACBF">Dirección Cliente *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="direccion" value="" type="text" required style="width: 100%">
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-map-marker"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label style="color: #0BACBF">Ciudad *</label>
                                                            <label class="field prepend-icon">
                                                                <input name="ciudad" value="" type="text" required style="width: 100%">
                                                                <label for="username" class="field-icon">
                                                                    <i class="fa fa-map-marker"></i>
                                                                </label>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--  Cliente, Nit y Dirección -->

                                                    <div class="section" style="padding-top: 30px">
                                                        <h4 class="col-md-12" style="background-color: #f4f4f4; font-size: 13px; padding-top: 10px; padding-bottom: 10px">DATOS ÍTEMS</h4>
                                                    </div>


                                                    <div id="items_siesa">
                                                        <div class="section cloned-row">
                                                            <div class="col-md-6">
                                                                <br /><br />
                                                                <label style="color: #4ECCDB">Item SIESA *</label>
                                                                <label class="field select">
                                                                    <label class="field select">
                                                                        <select name="items[]" id="items" required>
                                                                            <option value="">Seleccione</option>
                                                                            <?php $numrows = 0; ?>
                                                                            @foreach($newDataRTPItems as $DataRTPItems)
                                                                            <option value="<?= $newDataRTPItems[$numrows]['item'] . ';' . $newDataRTPItems[$numrows]['descripcion'] . ';' . $newDataRTPItems[$numrows]['maquila'] ?>"><?= $newDataRTPItems[$numrows]['item'] . ' | ' . $newDataRTPItems[$numrows]['descripcion'] . ' | ' . $newDataRTPItems[$numrows]['maquila'] ?></option>
                                                                            <?php $numrows++; ?>
                                                                            @endforeach
                                                                        </select>
                                                                        <i class="arrow"></i>
                                                                    </label>
                                                                    <i class="arrow"></i>
                                                                </label>
                                                                <br /><br />
                                                            </div>
                                                            <div class="col-md-3">
                                                                <br /><br />
                                                                <label style="color: #0BACBF">Cantidad (Unidades) *</label>
                                                                <label class="field prepend-icon">
                                                                    <input name="cantidad[]" value="" type="text" style="width: 100%">
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-file"></i>
                                                                    </label>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <br /><br />
                                                                <label style="color: #4ECCDB">Maquila *</label>
                                                                <label class="field select">
                                                                    <select name="maquila[]" id="maquila[]" required>
                                                                        <option value="">Seleccione</option>
                                                                        <option value="1">Si</option>
                                                                        <option value="2">No</option>
                                                                    </select>
                                                                    <i class="arrow"></i>
                                                                </label>
                                                                <br /><br />
                                                            </div>
                                                            <!-- Destinatario y Motivo -->
                                                            <br />
                                                            <div class="col-md-12">
                                                                <label style="color: #0BACBF">Observaciones</label>
                                                                <label class="field prepend-icon">
                                                                    <input name="observaciones[]" value="" type="text" style="width: 100%">
                                                                    <label for="username" class="field-icon">
                                                                        <i class="fa fa-file"></i>
                                                                    </label>
                                                                </label>
                                                                <br /> <br />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="section">
                                                        <br />
                                                        <div class="col-md-2 spawn-button-column">
                                                            <input type="button" class="form-control btn-info" value="Agregar +" id="clone">
                                                        </div>
                                                        <div class="col-md-2 spawn-button-column">
                                                            <input type="button" class="form-control btn-danger" value="Eliminar -" id="remove">
                                                        </div>
                                                        <div class="col-md-4">
                                                            {!! Form::submit('Agregar Pedido',
                                                            array('class'=>'btn btn-primary')) !!}
                                                        </div>
                                                    </div>

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
    <template id="my-template">
        <div class="section cloned-row">
            <div class="col-md-6">
                <br /><br />
                <label style="color: #4ECCDB">Item SIESA *</label>
                <label class="field select">
                    <label class="field select">
                        <select name="items[]"  required>
                            <option value="">Seleccione</option>
                            <?php $numrows = 0; ?>
                            @foreach($newDataRTPItems as $DataRTPItems)
                            <option value="<?= $newDataRTPItems[$numrows]['item'] . ';' . $newDataRTPItems[$numrows]['descripcion'] . ';' . $newDataRTPItems[$numrows]['maquila'] ?>"><?= $newDataRTPItems[$numrows]['item'] . ' | ' . $newDataRTPItems[$numrows]['descripcion'] . ' | ' . $newDataRTPItems[$numrows]['maquila'] ?></option>
                            <?php $numrows++; ?>
                            @endforeach
                        </select>
                        <i class="arrow"></i>
                    </label>
                    <i class="arrow"></i>
                </label>
                <br /><br />
            </div>
            <div class="col-md-3">
                <br /><br />
                <label style="color: #0BACBF">Cantidad (Unidades) *</label>
                <label class="field prepend-icon">
                    <input name="cantidad[]" value="" type="text" style="width: 100%">
                    <label for="username" class="field-icon">
                        <i class="fa fa-file"></i>
                    </label>
                </label>
            </div>
            <div class="col-md-3">
                <br /><br />
                <label style="color: #4ECCDB">Maquila *</label>
                <label class="field select">
                    <select name="maquila[]" id="maquila[]" required>
                        <option value="">Seleccione</option>
                        <option value="1">Si</option>
                        <option value="2">No</option>
                    </select>
                    <i class="arrow"></i>
                </label>
                <br /><br />
            </div>
            <!-- Destinatario y Motivo -->
            <br />
            <div class="col-md-12">
                <label style="color: #0BACBF">Observaciones</label>
                <label class="field prepend-icon">
                    <input name="observaciones[]" value="" type="text" style="width: 100%">
                    <label for="username" class="field-icon">
                        <i class="fa fa-file"></i>
                    </label>
                </label>
            </div>
            <br />
        </div>
    </template>
    <!-- -------------- Scripts -------------- -->
    @include('includes-CDN/include-script')
    <!-- -------------- /Scripts -------------- -->

    <script type="module">
        import {
            configureSelect2
        } from '<?= $server ?>/js/select2.js';

        configureSelect2();

        $("#remove").click(function() {
            $(".cloned-row:last").remove(".cloned-row:last");
        });

        $("#clone").click(function() {
            let $template = $('#my-template').get(0);
            let templateContent = $template.content;
            let $clone = $(document.importNode(templateContent, true));

            $("#items_siesa").append($clone);
            console.log($clone)
            configureSelect2();
        });
    </script>

</body>

</html>
@endforeach
