<?php
$server = '/Berhlan/public';

use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\TicActivos\PanelTipos;
use App\Models\TicActivos\PanelMarcas;
use App\Models\TicActivos\PanelLicencias;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Activos TIC | Consulta parametrizada
      </title>
      <meta name="keywords" content="panel, cms, usuarios, servicio"/>
      <meta name="description" content="Intranet para grupo Berhlan">
      <meta name="author" content="USUARIO" >
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!-- -------------- Fonts -------------- -->
      <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
      <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

      <!-- -------------- CSS - theme -------------- -->
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/skin/default_skin/css/theme.css">

      <!-- -------------- CSS - allcp forms -------------- -->
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/allcp/forms/css/forms.min.css">
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/allcp/forms/css/forms.css">

      <!-- -------------- Plugins -------------- -->
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

      <!-- -------------- Favicon -------------- -->
      <link rel="shortcut icon" href="<?=$server?>/panelfiles/assets/img/favicon.ico">

      <!-- Editor -->
      <script type="text/javascript" src="<?=$server?>/panelfiles/ckeditor/ckeditor.js"></script>
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
                  <a href="<?=$server?>/panel/ticactivos/consultasact" title="Activos TIC">
                    <font color="#34495e">
                      Activos TIC >
                    </font>
                    <font color="#b4c056">
                      Consulta parametrizada
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/ticactivos/consultasact" class="btn btn-primary btn-sm ml10" title="Activos TIC">
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
                          <th style="background-color:#67d3e0; color:#34495e; text-align:left;">
                            Consulta parametrizada
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>
                            <div class="allcp-form">
                              {!! Form::open(array('action' => 'TicActivos\ConsultasTicActivosPanelController@ParamListado', 'class' => 'form', 'id'=>'form-wizard')) !!}
                                <div class="row">
                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        ID activo
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::number('activo', null, array('', 'id'=>'activo', 'class'=>'gui-input', 'placeholder'=>'Activo', 'min'=>'1')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-bars"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Tipo de hardware
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="tipohd" id="tipohd">
                                        <option value="">
                                          Tipo de hardware
                                        </option>
                                        <?php
                                        $Tipo = PanelTipos::getTiposActivos();
                                        ?>
                                        @foreach($Tipo as $DatTip)
                                          <option value="<?=$DatTip->id_tipoactivo?>">
                                            <?=$DatTip->descripcion?>
                                          </option>
                                        @endforeach
                                      </select>
                                      <i class="arrow"></i>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Colaborador
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('empleado', null, array('', 'id'=>'empleado', 'class'=>'gui-input', 'placeholder'=>'* Colaborador')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-user"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Compañía
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="empresa" id="empresa">
                                        <option value="">
                                          Compañía
                                        </option>
                                        <?php
                                        $Empresas = PanelEmpresas::getEmpresasActivas();
                                        ?>
                                        @foreach($Empresas as  $DatEmpresas)
                                          <option value="<?=$DatEmpresas->id_empresa?>">
                                            <?=$DatEmpresas->nombre?>
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
                                    <label style="color: #34495e">
                                      <b>
                                        Centro de operación
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="centro" id="centro">
                                        <option value="">
                                          Centro de operación
                                        </option>
                                        <?php
                                        $Centros = PanelCentrosOp::getCentrosOpActivos();
                                        ?>
                                        @foreach($Centros as $DatCen)
                                          <option value="<?=$DatCen->id_centro?>">
                                            <?=$DatCen->descripcion?>
                                          </option>
                                        @endforeach
                                      </select>
                                      <i class="arrow"></i>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Marca y modelo
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="marca" id="marca">
                                        <option value="">
                                          Marca y modelo
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

                                  <div class="col-md-3">
                                    <label style="color:#34495e;">
                                      <b>
                                        Serial
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('serial', null, array('', 'id'=>'serial', 'class'=>'gui-input', 'placeholder'=>'* Serial')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-barcode"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Código interno
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('codigoint', null, array('', 'id'=>'codigoint', 'class'=>'gui-input', 'placeholder'=>'* Código interno')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-barcode"></i>
                                      </label>
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <br>
                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Activo fijo
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('activofijo', null, array('', 'id'=>'activofijo', 'class'=>'gui-input', 'placeholder'=>'* Activo fijo')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-barcode"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color:#34495e;">
                                      <b>
                                        Aplica control de mantenimiento
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="aplicamtto" id="aplicamtto">
                                        <option value="">Controla mantenimiento</option>
                                        <option value="S">Sí</option>
                                        <option value="N">No</option>
                                      </select>
                                      <i class="arrow"></i>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color:#34495e;">
                                      <b>
                                        Fecha de adquisición desde
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::date('adquisicionde', null, array('', 'id'=>'adquisicionde', 'class'=>'gui-input', 'maxlength'=>'10')) !!}
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Fecha de adquisición hasta
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::date('adquisicionha', null, array('', 'id'=>'adquisicionha', 'class'=>'gui-input', 'maxlength'=>'10')) !!}
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <br>
                                  <div class="col-md-3">
                                    <label style="color:#34495e;">
                                      <b>
                                        Meses entre mantenimientos desde
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::number('mesesdesde', null, array('', 'id'=>'mesesdesde', 'class'=>'gui-input', 'placeholder'=>'Meses desde', 'min'=>'1', 'max'=>'72')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-bars"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Meses entre mantenimientos hasta
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::number('meseshasta', null, array('', 'id'=>'meseshasta', 'class'=>'gui-input', 'placeholder'=>'Meses hasta', 'min'=>'1', 'max'=>'72')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-bars"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color:#34495e">
                                      <b>
                                        Tamaño del DD
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('tamanodd', null, array('', 'id'=>'tamanodd', 'class'=>'gui-input', 'placeholder'=>'* Tamaño del DD')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-bars"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color:#34495e">
                                      <b>
                                        Tipo de DD
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('tipodd', null, array('', 'id'=>'tipodd', 'class'=>'gui-input', 'placeholder'=>'* Tipo de DD')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-bars"></i>
                                      </label>
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <br>
                                  <div class="col-md-3">
                                    <label style="color:#34495e">
                                      <b>
                                        Tamaño de RAM
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                     {!! Form::text('tamanoram', null, array('', 'id'=>'tamanoram', 'class'=>'gui-input', 'placeholder'=>'* Tamaño de RAM')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-bars"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color:#34495e">
                                      <b>
                                        Tipo de RAM
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('tiporam', null, array('', 'id'=>'tiporam', 'class'=>'gui-input', 'placeholder'=>'* Tipo de RAM')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-bars"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color:#34495e">
                                      <b>
                                        Procesador
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('procesador', null, array('', 'id'=>'procesador', 'class'=>'gui-input', 'placeholder'=>'* Procesador')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-gear"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color:#34495e">
                                      <b>
                                       Licencia de office
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="licoffice" id="licoffice">
                                        <option value="">
                                          Licencia de office
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
                                  <div class="col-md-3">
                                    <label style="color:#34495e">
                                      <b>
                                        Dirección MAC 1
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('mac1', null, array('', 'id'=>'mac1', 'class'=>'gui-input', 'placeholder'=>'* Dirección MAC 1')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-bars"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color:#34495e">
                                      <b>
                                        Dirección MAC 2
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('mac2', null, array('', 'id'=>'mac2', 'class'=>'gui-input', 'placeholder'=>'* Dirección MAC 2')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-bars"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color:#34495e">
                                      <b>
                                        Dirección IP 1
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('ip1', '', array('', 'id'=>'ip1', 'class'=>'gui-input', 'placeholder'=>'* Dirección IP 1')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-bars"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color:#34495e">
                                      <b>
                                       Dirección IP 2
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('ip2', '', array('', 'id'=>'ip2', 'class'=>'gui-input', 'placeholder'=>'* Dirección IP 2')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-bars"></i>
                                      </label>
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <br>
                                  <div class="col-md-3">
                                    <label style="color:#34495e">
                                      <b>
                                        Licencia de Windows
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="windows" id="windows">
                                        <option value="">Licencia de Windows</option>
                                        <option value="S">Sí</option>
                                        <option value="N">No</option>
                                      </select>
                                      <i class="arrow"></i>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color:#34495e">
                                      <b>
                                        Estado
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="estado" id="estado">
                                        <option value="">Estado</option>
                                        <option value="1" selected>Activo</option>
                                        <option value="0">Inactivo</option>
                                      </select>
                                      <i class="arrow"></i>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <br><br>
                                    {!! Form::submit('Consultar', array('class'=>'button')) !!}
                                    <br><br>
                                  </div>

                                  <div class="col-md-3">
                                    <br><br>
                                    <label style="color:#34495e">
                                      <b>
                                        * Que el resultado contenga
                                      </b>
                                    </label>
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

      <!-- -------------- Scripts -------------- -->

      <!-- -------------- jQuery -------------- -->
      <script src="<?=$server?>/panelfiles/assets/js/jquery/jquery-1.11.3.min.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js"></script>

      <!-- -------------- JvectorMap Plugin -------------- -->
      <script src="<?=$server?>/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js"></script>

      <!-- -------------- HighCharts Plugin -------------- -->
      <script src="<?=$server?>/panelfiles/assets/js/plugins/highcharts/highcharts.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/plugins/c3charts/d3.min.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/plugins/c3charts/c3.min.js"></script>

      <!-- -------------- Theme Scripts -------------- -->
      <script src="<?=$server?>/panelfiles/assets/js/utility/utility.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/demo/demo.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/main.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/pages/allcp_forms-elements.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/demo/widgets_sidebar.js"></script>

      <!-- -------------- Page JS -------------- -->
      <script src="<?=$server?>/panelfiles/assets/js/demo/charts/highcharts.js"></script>

      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach