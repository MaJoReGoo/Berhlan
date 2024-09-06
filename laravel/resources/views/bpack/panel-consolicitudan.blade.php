<?php
$server = '/Berhlan/public';

use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Bpack\PanelSolicitudesAN;
use App\Models\Bpack\PanelItemEtiquetas;
use App\Models\Bpack\PanelMotivos;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Bpack | Consulta solicitudes
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

      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

      <style>
          .select2-container .select2-selection--single {
              height: 40px;
              /* Cambia la altura según lo necesites */
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
                  <a href="<?=$server?>/panel/menu/3" title="Bcloud">
                    <font color="#34495e">
                      Bcloud >
                    </font>
                    <font color="#b4c056">
                      Consulta solicitudes
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/menu/3" class="btn btn-primary btn-sm ml10" title="Bcloud">
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
                              {!! Form::open(array('action' => 'Bpack\ConsultasSolicitudesPanelController@ConsultaListado', 'class' => 'form', 'id'=>'form-wizard')) !!}
                                <div class="row">
                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Número de solicitud
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::number('solicitud', null, array('', 'id'=>'solicitud', 'class'=>'gui-input', 'placeholder'=>'Número de solicitud', 'min'=>'1')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-sort-numeric-asc"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Número SBA
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::number('sba', null, array('', 'id'=>'sba', 'class'=>'gui-input', 'placeholder'=>'Número', 'min'=>'1')) !!}
                                      <label for="username" class="field-icon">
                                        <i>SBA</i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Número SBM
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::number('sbm', null, array('', 'id'=>'sbm', 'class'=>'gui-input', 'placeholder'=>'Número', 'min'=>'1')) !!}
                                      <label for="username" class="field-icon">
                                        <i>SBM</i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Que el cliente contenga
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('cliente', null, array('', 'id'=>'cliente', 'class'=>'gui-input', 'placeholder'=>'Palabra clave')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-user"></i>
                                      </label>
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <br>
                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Tipo
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="actualizacionpara" id="actualizacionpara">
                                        <option value="">
                                          Tipo
                                        </option>
                                        <option value="AA">
                                          Actualización para abastecimiento
                                        </option>
                                        <option value="AR">
                                          Actualización para reimpresiones
                                        </option>
                                        <option value="NV">
                                          Nuevo desarrollo
                                        </option>
                                      </select>

                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Estado de la solicitud
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="estado" id="estado">
                                        <option value="">
                                          Estado
                                        </option>
                                        <?php
                                        $Estados = PanelSolicitudesAN::SolEstados();
                                        ?>
                                        @foreach($Estados as $DatEst)
                                          <option value="<?=$DatEst->id_estado?>">
                                            <?=$DatEst->descripcion?>
                                          </option>
                                        @endforeach
                                      </select>

                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Usuario que solicita
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="usr_solicita" id="usr_solicita">
                                        <option value="">
                                          Solicitado por
                                        </option>
                                        <?php
                                        $UsrSolicita = PanelSolicitudesAN::UsrSolicitaSolicitudes();
                                        ?>
                                        @foreach($UsrSolicita as $DatUrs)
                                          <?php
                                          $Empleado = PanelEmpleados::getEmpleado($DatUrs->usr_crea);
                                          $Cargo    = PanelCargos::getCargo($Empleado[0]->cargo);
                                          $Area     = PanelAreas::getArea($Cargo[0]->area);
                                          ?>
                                          <option value="<?=$DatUrs->usr_crea?>">
                                            <?php
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
                                          </option>
                                        @endforeach
                                      </select>

                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color:#34495e;">
                                      <b>
                                        Fecha de solicitud desde
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::date('soldesde', null, array('', 'id'=>'soldesde', 'class'=>'gui-input', 'maxlength'=>'10')) !!}
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <br>
                                  <div class="col-md-3">
                                    <label style="color:#34495e;">
                                      <b>
                                        Fecha de solicitud hasta
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::date('solhasta', null, array('', 'id'=>'solhasta', 'class'=>'gui-input', 'maxlength'=>'10')) !!}
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <?php
                                    $DatosItem = PanelItemEtiquetas::Items();
                                    ?>
                                    <label style="color: #34495e">
                                      <b>
                                        Ítem
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="item" id="item">
                                        <option value="">
                                          Ítem
                                        </option>
                                        @foreach($DatosItem as $DatIte)
                                          <option value="<?=$DatIte->f120_id?>">
                                            <?=$DatIte->f120_id.' - '.$DatIte->f120_notas?>
                                          </option>
                                        @endforeach
                                      </select>

                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Que la referencia contenga
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('referencia', null, array('', 'id'=>'referencia', 'class'=>'gui-input', 'placeholder'=>'Palabra clave')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-navicon"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Versión
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="version" id="version">
                                        <option value="">
                                          Versión
                                        </option>
                                        <?php
                                        for($u = 1; $u < 51; $u++)
                                         {
                                          echo "<option value=\"$u\">";
                                            echo $u;
                                          echo "</option>";
                                         }
                                        ?>
                                      </select>

                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <br>
                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Ruta
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="ruta" id="ruta">
                                        <option value="">
                                          Ruta
                                        </option>
                                        <option value="D">
                                          Digital
                                        </option>
                                        <option value="F">
                                          Flexografía
                                        </option>
                                      </select>

                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Prueba física existente
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="pf" id="pf">
                                        <option value="">
                                          Prueba física existente
                                        </option>
                                        <option value="S">
                                          Sí
                                        </option>
                                        <option value="N">
                                          No
                                        </option>
                                      </select>

                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #34495e">
                                      <b>
                                        Remisión
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('remision', null, array('', 'id'=>'remision', 'class'=>'gui-input', 'placeholder'=>'Remisión')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-sort-numeric-asc"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color:#34495e;">
                                      <b>
                                        Motivo de rechazo
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="motivo" id="motivo">
                                        <option value="">
                                          Motivo de rechazo
                                        </option>
                                        <?php
                                        $Motivos = PanelMotivos::getMotivosActivos();
                                        ?>
                                        @foreach($Motivos as $DatMov)
                                          <option value="<?=$DatMov->id_motivo?>">
                                            <?=$DatMov->descripcion?>
                                          </option>
                                        @endforeach
                                      </select>

                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-3">
                                    <br>
                                    <label style="color:#34495e">
                                      <b>
                                        Fecha de cierre desde
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::date('cierredesde', null, array('', 'id'=>'cierredesde', 'class'=>'gui-input', 'maxlength'=>'10')) !!}
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <br>
                                    <label style="color:#34495e">
                                      <b>
                                        Fecha de cierre hasta
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::date('cierrehasta', null, array('', 'id'=>'cierrehasta', 'class'=>'gui-input', 'maxlength'=>'10')) !!}
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <br><br><br>
                                    {!! Form::submit('Consultar', array('class'=>'button')) !!}
                                    <br><br>
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

      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script src="<?= $server ?>/js/select2.js"></script>

    </body>
  </html>
@endforeach
