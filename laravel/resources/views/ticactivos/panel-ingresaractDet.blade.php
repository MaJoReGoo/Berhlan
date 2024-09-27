<?php


use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\TicActivos\PanelTipos;
use App\Models\TicActivos\PanelMarcas;
use App\Models\TicActivos\PanelLicencias;
use App\Models\TicActivos\PanelSoftware;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Activos TIC | Ingresar activo
      </title>
      <meta name="description" content="Intranet para grupo Berhlan">
      <meta name="author" content="USUARIO" >
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!-- -------------- Fonts -------------- -->
      <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
      <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

      <!-- -------------- CSS - theme -------------- -->
      <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/skin/default_skin/css/theme.css')}}">

      <!-- -------------- CSS - allcp forms -------------- -->
      <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.css">

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
                  <a href="{{ asset ('/panel/ticactivos/ingresaract')}}" title="Activos TIC > Agregar">
                    <font color="#34495e">
                      Activos TIC > Agregar >
                    </font>
                    <font color="#b4c056">
                      Agregar detalle
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="{{ asset ('/panel/ticactivos/ingresaract')}}" class="btn btn-primary btn-sm ml10" title="Activos TIC > Agregar">
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
                              {!! Form::open(array('action' => 'TicActivos\ActivosTicActivosPanelController@IngresarDB', 'class' => 'form', 'id'=>'form-wizard', 'files' => true)) !!}
                                {!! Form::hidden('tipo', $DatosActivo['tipo']) !!}
                                {!! Form::hidden('empleado', $DatosActivo['empleado']) !!}

                                <div class="row">
                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Tipo de hardware
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      <?php
                                      $tipact = $DatosActivo['tipo'];
                                      $Tipo = PanelTipos::getTipo($tipact);
                                      echo $Tipo[0]->descripcion;
                                      ?>
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Colaborador
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      <?php
                                      $emple    = $DatosActivo['empleado'];
                                      $Empleado = PanelEmpleados::getEmpleado($emple);
                                      $Cargo    = PanelCargos::getCargo($Empleado[0]->cargo);
                                      $Area     = PanelAreas::getArea($Cargo[0]->area);
                                      echo $Empleado[0]->primer_nombre;
                                      echo " ";
                                      echo $Empleado[0]->ot_nombre;
                                      echo " ";
                                      echo $Empleado[0]->primer_apellido;
                                      echo " ";
                                      echo $Empleado[0]->ot_apellido;
                                      echo " &nbsp;&nbsp;-&nbsp;&nbsp; ";
                                      echo $Cargo[0]->descripcion;
                                      echo " - ";
                                      echo $Area[0]->descripcion;
                                      ?>
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <br>
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
                                        @foreach($Empresas as $DatEmp)
                                          <option value="<?=$DatEmp->id_empresa?>">
                                            <?=$DatEmp->nombre?>
                                          </option>
                                        @endforeach
                                      </select>
                                      <i class="arrow"></i>
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Marca y modelo
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="marca" id="marca" required>
                                        <option value="">
                                          * Marca y modelo
                                        </option>
                                        <?php
                                        $Marcas = PanelMarcas::getMarcasActivas();
                                        ?>
                                        @foreach($Marcas as $DatMar)
                                          <option value="<?=$DatMar->id_marca?>">
                                            <?=$DatMar->descripcion?>
                                          </option>
                                        @endforeach
                                      </select>
                                      <i class="arrow"></i>
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Serial
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('serial', null, array('', 'id'=>'serial', 'class'=>'gui-input', 'placeholder'=>'Serial')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-barcode"></i>
                                      </label>
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <br>
                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Código interno
                                      </b>
                                      (Últ. cons.&nbsp;
                                      @foreach($DatosUltCon as $DatCon)
                                        <?=$DatCon->segundo?>
                                      @endforeach
                                      )
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('codigoint', null, array('', 'id'=>'codigoint', 'class'=>'gui-input', 'placeholder'=>'Código interno')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-barcode"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Activo fijo
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('activofijo', null, array('', 'id'=>'activofijo', 'class'=>'gui-input', 'placeholder'=>'Activo fijo')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-barcode"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Usuario y contraseña
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('usrclave', null, array('', 'id'=>'usrclave', 'class'=>'gui-input', 'placeholder'=>'Usuario y contraseña(usuario=admin   contraseña=123456)')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-key"></i>
                                      </label>
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <br>
                                  <div class="col-md-4">
                                    <label style="color:#34495e;">
                                      <b>
                                        Garantía hasta
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::date('garantia', null, array('', 'id'=>'garantia', 'class'=>'gui-input', 'maxlength'=>'10')) !!}
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        PDF con factura
                                      </b>
                                    </label>
                                    <label class="field prepend-icon append-button file">
                                      <span class="button">
                                        PDF
                                      </span>
                                      {!! Form::file('file1', array('', 'id'=>'file1', 'accept'=>'.pdf', 'class'=>'gui-file', 'onChange'=>"document.getElementById('uploader1').value = this.value;")) !!}
                                      {!! Form::text('uploader1', null, array('id'=>'uploader1', 'class'=>'gui-input', 'placeholder'=>'Factura')) !!}
                                      <label class="field-icon">
                                        <i class="fa fa-cloud-upload"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Foto
                                      </b>
                                    </label>
                                    <label class="field prepend-icon append-button file">
                                      <span class="button">
                                        JPG
                                      </span>
                                      {!! Form::file('file2', array('', 'id'=>'file2', 'accept'=>'.jpg', 'class'=>'gui-file', 'onChange'=>"document.getElementById('uploader2').value = this.value;")) !!}
                                      {!! Form::text('uploader2', null, array('id'=>'uploader2', 'class'=>'gui-input', 'placeholder'=>'Foto')) !!}
                                      <label class="field-icon">
                                        <i class="fa fa-cloud-upload"></i>
                                      </label>
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <br>
                                  <div class="col-md-4">
                                    <label style="color:#34495e;">
                                      <b>
                                        Fecha de adquisición
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::date('adquisicion', date('Y-m-d'), array('', 'id'=>'adquisicion', 'class'=>'gui-input', 'maxlength'=>'10')) !!}
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Valor compra
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::number('valcompra', null, array('', 'id'=>'valcompra', 'class'=>'gui-input', 'placeholder'=>'Valor compra', 'min'=>'0')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-dollar"></i>
                                      </label>
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
                                      <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary" onclick="COLOR('S')">
                                          <i class="fa fa-wrench fa-1x" id="mantenimientos" style="color:grey;"> Sí</i>
                                          <input type="radio" name="mantenimiento" value="S" autocomplete="off">
                                        </label>
                                        <label class="btn btn-secondary active" onclick="COLOR('N')">
                                          <i class="fa fa-times-circle fa-1x" id="mantenimienton" style="color:red;"> No</i>
                                          <input type="radio" name="mantenimiento" value="N" autocomplete="off" checked>
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
                                      <select name="meses" id="meses" disabled>
                                        <option value="">
                                          Meses
                                        </option>
                                        <?php
                                        for($u = 1; $u < 73; $u++)
                                         {
                                          echo "<option value=\"$u\">";
                                            echo $u;
                                          echo "</option>";
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
                                      {!! Form::date('fechainicial', '', array('required', 'disabled', 'id'=>'fechainicial', 'class'=>'gui-input', 'maxlength'=>'10')) !!}
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <br>
                                  <div class="col-md-4">
                                    <label style="color:#34495e;">
                                      <b>
                                        Dirección MAC
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('mac1', null, array('', 'id'=>'mac1', 'class'=>'gui-input', 'placeholder'=>'Dirección MAC (A1-B2-C3-D4-E5-F6)')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-bars"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Dirección IP
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::textarea('ip1', '', array('', 'id'=>'ip1', 'class'=>'gui-input', 'style'=>'height: 58px;',
                                         'placeholder'=>'123.123.123.123 / 255.255.255.0 / 123.123.123.1')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-reorder"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <label style="color:#34495e;">
                                      <b>
                                        Observaciones
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::textarea('observaciones', '', array('', 'id'=>'observaciones', 'class'=>'gui-input', 'style'=>'height: 58px;',
                                         'placeholder'=>'Observaciones')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-reorder"></i>
                                      </label>
                                    </label>
                                  </div>
                                </div>

                                <?php
                                if($Tipo[0]->campos_pc == "S")
                                 {
                                  ?>
                                  <div class="row">
                                    <br>
                                    <div class="col-md-4">
                                      <label style="color:#34495e;">
                                        <b>
                                          Tamaño del DD
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::text('tamanodd', null, array('', 'id'=>'tamanodd', 'class'=>'gui-input', 'placeholder'=>'256GB - 512GB')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-bars"></i>
                                        </label>
                                      </label>
                                    </div>

                                    <div class="col-md-4">
                                      <label style="color:#34495e;">
                                        <b>
                                          Tipo de DD
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::text('tipodd', null, array('', 'id'=>'tipodd', 'class'=>'gui-input', 'placeholder'=>'HDD - SSD')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-bars"></i>
                                        </label>
                                      </label>
                                    </div>

                                    <div class="col-md-4">
                                      <label style="color:#34495e;">
                                        <b>
                                          Tamaño de RAM
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::text('tamanoram', null, array('', 'id'=>'tamanoram', 'class'=>'gui-input', 'placeholder'=>'6GB - 8GB - 16GB')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-bars"></i>
                                        </label>
                                      </label>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <br>
                                    <div class="col-md-4">
                                      <label style="color:#34495e;">
                                        <b>
                                          Tipo de RAM
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::text('tiporam', null, array('', 'id'=>'tiporam', 'class'=>'gui-input', 'placeholder'=>'DDR3 - DDR4')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-bars"></i>
                                        </label>
                                      </label>
                                    </div>

                                    <div class="col-md-4">
                                      <label style="color:#34495e;">
                                        <b>
                                          Procesador
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::text('procesador', null, array('', 'id'=>'procesador', 'class'=>'gui-input', 'placeholder'=>'CORE i3 i6 i9 # # GHz')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-gear"></i>
                                        </label>
                                      </label>
                                    </div>

                                    <div class="col-md-4">
                                      <label style="color:#34495e;">
                                        <b>
                                          Licencia de office
                                        </b>
                                      </label>
                                      <label class="field select">
                                        <select name="licoffice" id="licoffice">
                                          <option value="0">
                                            Sin licencia
                                          </option>
                                          <?php
                                          $Licencias = PanelLicencias::getLicenciasTpActivas();
                                          ?>
                                          @foreach($Licencias as $DatLic)
                                            <option value="<?=$DatLic->id_licencia?>">
                                              <?php
                                              echo $DatLic->tpdes." - ".$DatLic->lice;
                                              ?>
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
                                      <label style="color:#34495e;">
                                        <b>
                                          Dirección MAC 2
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::text('mac2', null, array('', 'id'=>'mac2', 'class'=>'gui-input', 'placeholder'=>'A1-B2-C3-D4-E5-F6')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-bars"></i>
                                        </label>
                                      </label>
                                    </div>

                                    <div class="col-md-4">
                                      <label style="color:#34495e;">
                                        <b>
                                          Dirección IP 2
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::textarea('ip2', '', array('', 'id'=>'ip2', 'class'=>'gui-input', 'style'=>'height: 58px;',
                                           'placeholder'=>'123.123.123.123 / 255.255.255.0 / 123.123.123.1')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-bars"></i>
                                        </label>
                                      </label>
                                    </div>

                                    <div class="col-md-4">
                                      <label style="color:#34495e;">
                                        <b>
                                          Control remoto
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::text('remoto', null, array('', 'id'=>'remoto', 'class'=>'gui-input', 'placeholder'=>'Anydesk 123456789')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-bars"></i>
                                        </label>
                                      </label>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <br>
                                    <div class="col-md-4">
                                      <label style="color:#34495e;">
                                        <b>
                                          Licencia de Windows
                                        </b>
                                      </label>
                                      <label class="option block">
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                          <label class="btn btn-secondary active" onclick="COLOR1('S')">
                                            <i class="fa fa-1x" id="licencias" style="color:green"> Sí</i>
                                            <input type="radio" name="licencia" value="S" autocomplete="off" checked>
                                          </label>
                                          <label class="btn btn-secondary" onclick="COLOR1('N')">
                                            <i class="fa fa-1x" id="licencian" style="color:grey;"> No</i>
                                            <input type="radio" name="licencia" value="N" autocomplete="off">
                                          </label>
                                        </div>
                                      </label>
                                    </div>

                                    <div class="col-md-8">
                                      <label style="color:#34495e;">
                                        <b>
                                         Software instalado
                                        </b>
                                      </label>
                                      <?php
                                      $Software = PanelSoftware::getSoftwareActivos();
                                      $e = 0;
                                      ?>
                                      <table id="message-table" class="table allcp-form theme-warning br-t">
                                        <tr>
                                          {!! Form::hidden('programas[]', 300) !!}
                                          @foreach($Software as $DatSof)
                                            <td>
                                              <label class="option block" style="color:#34495e;">
                                                <?php
                                                $e++;
                                                ?>
                                                {!! Form::checkbox('programas[]', $DatSof->id_software) !!}
                                                <span class="checkbox"></span><b><?=$DatSof->descripcion?></b>
                                              </label>
                                            </td>
                                            <?php
                                            if($e%4==0)
                                              echo "</tr><tr>";
                                            ?>
                                          @endforeach
                                        </tr>
                                      </table>
                                    </div>
                                  </div>
                                  <?php
                                 }

                                if(($Tipo[0]->campo1 != "") || ($Tipo[0]->campo2 != "") || ($Tipo[0]->campo3 != ""))
                                 {
                                  ?>
                                  <div class="row">
                                    <br>
                                  <?php
                                 }

                                if($Tipo[0]->campo1 != "")
                                 {
                                  ?>
                                  <div class="col-md-4">
                                    <label style="color:#34495e;">
                                      <b>
                                        <?=$Tipo[0]->campo1?>
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::textarea('campo1', null, array('', 'id'=>'campo1', 'class'=>'gui-input', 'style'=>'height: 58px;', 'placeholder'=>$Tipo[0]->campo1)) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-bars"></i>
                                      </label>
                                    </label>
                                  </div>
                                  <?php
                                 }

                                if($Tipo[0]->campo2 != "")
                                 {
                                  ?>
                                  <div class="col-md-4">
                                    <label style="color:#34495e;">
                                      <b>
                                        <?=$Tipo[0]->campo2?>
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::textarea('campo2', null, array('', 'id'=>'campo2', 'class'=>'gui-input', 'style'=>'height: 58px;', 'placeholder'=>$Tipo[0]->campo2)) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-bars"></i>
                                      </label>
                                    </label>
                                  </div>
                                  <?php
                                 }

                                if($Tipo[0]->campo3 != "")
                                 {
                                  ?>
                                  <div class="col-md-4">
                                    <label style="color:#34495e;">
                                      <b>
                                        <?=$Tipo[0]->campo3?>
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::textarea('campo3', null, array('', 'id'=>'campo3', 'class'=>'gui-input', 'style'=>'height: 58px;', 'placeholder'=>$Tipo[0]->campo3)) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-bars"></i>
                                      </label>
                                    </label>
                                  </div>
                                  <?php
                                 }

                                if(($Tipo[0]->campo1 != "") || ($Tipo[0]->campo2 != "") || ($Tipo[0]->campo3 != ""))
                                  echo "</div>";
                                ?>

                                <div class="row">
                                  <br>
                                  <div class="col-md-4">
                                    {!! Form::submit('Guardar activo', array('class'=>'button')) !!}
                                    <br><br>
                                  </div>
                                </div>
                              {!! Form::close() !!}
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>

                    <script language="javascript" type="text/javascript">
                    function COLOR(id1)
                     {
                      icono1 = document.getElementById('mantenimientos');
                      icono2 = document.getElementById('mantenimienton');
                      meses  = document.getElementById('meses');
                      fecha  = document.getElementById('fechainicial');

                      if(id1 == "S")
                       {
                        icono1.style.color = 'green';
                        icono2.style.color = 'grey';
                        meses.disabled     = '';
                        fecha.disabled     = '';
                       }
                      else
                       {
                        icono1.style.color = 'grey';
                        icono2.style.color = 'red';
                        meses.disabled     = 'disabled';
                        fecha.disabled     = 'disabled';
                        meses.value        = '';
                        fecha.value        = '';
                       }
                     }

                    function COLOR1(id1)
                     {
                      icono1 = document.getElementById('licencias');
                      icono2 = document.getElementById('licencian');

                      if(id1 == "S")
                       {
                        icono1.style.color = 'green';
                        icono2.style.color = 'grey';
                       }
                      else
                       {
                        icono1.style.color = 'grey';
                        icono2.style.color = 'red';
                       }
                     }
                    </script>
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
