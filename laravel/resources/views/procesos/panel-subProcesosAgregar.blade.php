<?php
$server = '/Berhlan/public';

use App\Models\Procesos\PanelMacroProcesos;
use App\Models\Procesos\PanelSubProcesos;
?>

@foreach($DatosUsuario as $DatLog)
  @foreach($DatosProceso as $DatPro)
    <!DOCTYPE html>
    <html>
      <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
          Intranet | Agregar subproceso
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
                    <a href="<?=$server?>/panel/procesos/procesos/modificar/<?=$DatPro->id_proceso?>" title="Procesos internos > Procesos > Modificar">
                      <font color="#34495e">
                        Procesos internos > Procesos > Subprocesos >
                      </font>
                      <font color="#b4c056">
                        Agregar
                      </font>
                    </a>
                  </li>
                </ul>
              </div>

              <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                <a href="<?=$server?>/panel/procesos/procesos/modificar/<?=$DatPro->id_proceso?>" class="btn btn-primary btn-sm ml10" title="Procesos internos > Procesos > Modificar">
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
                        <?php
                        $DatosMacro = PanelMacroProcesos::getMacroProceso($DatPro->macroproceso);
                        $fondo      = $DatosMacro[0]->fondo;
                        ?>
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
                            <button type="button" style="background:#<?=$DatPro->fondo?>; cursor:default;" class="btn btn-default light">
                              <b>
                                <font color="#000000">
                                  <?=$DatPro->descripcion?>
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
                              Ingrese la información del nuevo subproceso
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr>
                            <td>
                              <div class="allcp-form">
                                {!! Form::open(array('action' => 'Procesos\SubProcesosPanelController@SubProcesosAgregarDB', 'class' => 'form', 'id'=>'form-wizard')) !!}
                                  {!! Form::hidden('login', $DatLog->login) !!}
                                  {!! Form::hidden('id_proceso', $DatPro->id_proceso) !!}

                                  <div class="row">
                                    <div class="col-md-4">
                                      <label style="color: #34495e">
                                        <b>
                                          Subproceso
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::text('descripcion', null, array('required', 'id'=>'descripcion', 'class'=>'gui-input', 'placeholder'=>'* Nombre')) !!}
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
                                        {!! Form::number('numero', null, array('required', 'id'=>'numero', 'class'=>'gui-input', 'placeholder'=>'* Posición', 'max'=>99)) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-exchange"></i>
                                        </label>
                                      </label>
                                    </div>

                                    <div class="col-md-4">
                                      <br><br>
                                      {!! Form::submit('Ingresar subproceso', array('class'=>'button')) !!}
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

                <div class="chute chute-center pt30">
                  <div class="panel m10">
                    <div class="table-responsive">
                      <table id="message-table" class="table allcp-form theme-warning br-t">
                        <thead>
                          <tr>
                            <th>
                              <font color="black">
                                Subprocesos asociados
                              </font>
                            </th>
                          </tr>
                        </thead>

                        <thead>
                          <tr style="background-color:#e5eaee; color: #626262">
                            <th style="text-align:left">
                              Subproceso
                            </th>
                            <th style="text-align:left">
                              Posición
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                          $u = 1;
                          $DatosSubprocesos = PanelSubProcesos::getSubProcesos($DatPro->id_proceso);
                          ?>

                          @foreach($DatosSubprocesos as $DatSub)
                            <tr class="message-unread">
                              <td style="text-align:left">
                                <font color="#2A2F43">
                                  <?php
                                  print $u;
                                  $u++;
                                  ?>
                                  &nbsp;&nbsp;
                                  <i class="fa fa-minus fa-lg" style="color:#AEBF25"></i>
                                  &nbsp;
                                  <b>
                                    <?=$DatSub->descripcion?>
                                  </b>
                                </font>
                              </td>

                              <td style="text-align:left">
                                <font color="#2A2F43">
                                  <?=$DatSub->numero?>
                                </font>
                              </td>
                            </tr>
                          @endforeach
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
@endforeach