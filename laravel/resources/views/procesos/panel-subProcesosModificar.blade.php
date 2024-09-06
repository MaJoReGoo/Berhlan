<?php
$server = '/Berhlan/public';

use App\Models\Procesos\PanelMacroProcesos;
use App\Models\Procesos\PanelProcesos;
?>

@foreach($DatosUsuario as $DatLog)
  @foreach($DatosSubProceso as $DatSub)
    <!DOCTYPE html>
    <html>
      <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
          Intranet | Modificar subproceso
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
                    <?php
                    $DatosProceso = PanelProcesos::getProceso($DatSub->proceso);
                    $fondo1       = $DatosProceso[0]->fondo;
                    $DatosMacro   = PanelMacroProcesos::getMacroProceso($DatosProceso[0]->macroproceso);
                    $fondo        = $DatosMacro[0]->fondo;
                    ?>

                    <a href="<?=$server?>/panel/procesos/procesos/modificar/<?=$DatosProceso[0]->id_proceso?>" title="Procesos internos > Procesos > Modificar">
                      <font color="#34495e">
                        Procesos internos > Procesos > Subprocesos >
                      </font>
                      <font color="#b4c056">
                        Modificar
                      </font>
                    </a>
                  </li>
                </ul>
              </div>

              <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                <a href="<?=$server?>/panel/procesos/procesos/modificar/<?=$DatosProceso[0]->id_proceso?>" class="btn btn-primary btn-sm ml10" title="Procesos internos > Procesos > Modificar">
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
                            <button type="button" style="background:#<?=$fondo?>; cursor:default;" class="btn btn-default light">
                              <b>
                                <font color="white">
                                  <?=$DatosMacro[0]->descripcion?>
                                </font>
                              </b>
                            </button>
                            &nbsp;
                            <button type="button" style="background:#<?=$fondo1?>; cursor:default;" class="btn btn-default light">
                              <b>
                                <font color="#000000">
                                  <?=$DatosProceso[0]->descripcion?>
                                </font>
                              </b>
                            </button>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>

                <br>

                <div class="panel m4">
                  <!-- -------------- Message Body -------------- -->
                  <div class="nano-content">
                    <div class="table-responsive">
                      <table id="message-table" class="table allcp-form theme-warning br-t">
                        <thead>
                          <tr style="background-color:#67d3e0">
                            <th style="color:black; text-align:left;">
                              Actualice los datos del subproceso
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr>
                            <td>
                              <div class="allcp-form">
                                {!! Form::open(array('action' => 'Procesos\SubProcesosPanelController@SubProcesosModificarDB', 'class' => 'form', 'id'=>'form-wizard')) !!}
                                  {!! Form::hidden('login', $DatLog->login) !!}
                                  {!! Form::hidden('id_subproceso', $DatSub->id_subproceso) !!}
                                  {!! Form::hidden('proceso', $DatSub->proceso) !!}
                                  <div class="row">
                                    <div class="col-md-4">
                                      <label style="color: #34495e">
                                        <b>
                                          Subproceso
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::text('descripcion', $DatSub->descripcion, array('required', 'id'=>'descripcion', 'class'=>'gui-input', 'placeholder'=>'* Nombre')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-file"></i>
                                        </label>
                                      </label>
                                    </div>

                                    <div class="col-md-4">
                                      <label style="color: #34495e">
                                        <b>
                                          Posición
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::number('numero', $DatSub->numero, array('required', 'id'=>'numero', 'class'=>'gui-input', 'placeholder'=>'* Posición', 'max'=>99)) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-exchange"></i>
                                        </label>
                                      </label>
                                    </div>

                                    <div class="col-md-4">
                                      <br><br>
                                      {!! Form::submit('Modificar subproceso', array('class'=>'button')) !!}
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

        <!-- -------------- CanvasBG JS -------------- -->
        <script src="<?=$server?>/panelfiles/assets/js/plugins/canvasbg/canvasbg.js"></script>

        <!-- -------------- MonthPicker JS -------------- -->
        <script src="<?=$server?>/panelfiles/assets/allcp/forms/js/jquery-ui-monthpicker.min.js"></script>
        <script src="<?=$server?>/panelfiles/assets/allcp/forms/js/jquery-ui-datepicker.min.js"></script>
        <script src="<?=$server?>/panelfiles/assets/allcp/forms/js/jquery.spectrum.min.js"></script>
        <script src="<?=$server?>panelfiles/assets/allcp/forms/js/jquery.stepper.min.js"></script>

        <!-- -------------- Theme Scripts -------------- -->
        <script src="<?=$server?>/panelfiles/assets/js/utility/utility.js"></script>
        <script src="<?=$server?>/panelfiles/assets/js/demo/demo.js"></script>
        <script src="<?=$server?>/panelfiles/assets/js/main.js"></script>
        <script src="<?=$server?>/panelfiles/assets/js/pages/allcp_forms-elements.js"></script>
        <script src="<?=$server?>/panelfiles/assets/js/demo/widgets_sidebar.js"></script>
        <script src="<?=$server?>/panelfiles/assets/js/pages/forms-widgets.js"></script> <!-- Lugar para poner varios calendarios (Datepicker1) -->
        <script src="<?=$server?>/panelfiles/assets/js/pages/tables-basic.js"></script>
        <!-- -------------- Page JS -------------- -->
      </body>
    </html>
  @endforeach
@endforeach