<?php
$server ='/Berhlan/public';
use App\Models\Procesos\PanelProcesos;
use App\Models\Procesos\PanelMacroProcesos;
use App\Models\Procesos\PanelSubProcesos;
use App\Models\Procesos\PanelSubProceDocu;
use App\Models\Procesos\PanelTiposDocumentos;
?>

@foreach($DatosUsuario as $DatLog)
  @foreach($DatosDocumento as $DatDoc)
    <!DOCTYPE html>
    <html>
      <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
          Intranet | Procesos | Asociar subproceso
        </title>

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
                    <a href="<?=$server?>/panel/procesos/documesubpro" title="Procesos internos > Documentos - Subprocesos">
                      <font color="#34495e">
                        Procesos internos > Documentos - Subprocesos >
                      </font>
                      <font color="#b4c056">
                        Asociar
                      </font>
                    </a>
                  </li>
                </ul>
              </div>

              <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                <a href="<?=$server?>/panel/procesos/documesubpro" class="btn btn-primary btn-sm ml10" title="Procesos internos > Documentos - Subprocesos">
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
                          <tr style="background-color:#67d3e0">
                            <th style="color:black; text-align:left;">
                              Asocie el subproceso al documento
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr>
                            <td>
                              <div class="allcp-form">
                                {!! Form::open(array('action' => 'Procesos\DocSubProcesosPanelController@DocumeSubProAsociarDB', 'class' => 'form', 'id'=>'form-wizard')) !!}
                                  {!! Form::hidden('login', $DatLog->login) !!}
                                  {!! Form::hidden('id_documento', $DatDoc->id_documento) !!}

                                  <div class="row">
                                    <div class="col-md-12">
                                      <label style="color:#34495e">
                                        <b>
                                          Documento
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        <b>
                                          <?=$DatDoc->descripcion?>
                                          &nbsp;
                                          (
                                           <?php
                                           $Tipo = PanelTiposDocumentos::getTipo($DatDoc->tipo);
                                           echo $Tipo[0]->descripcion;
                                           ?>
                                          )
                                        </b>
                                      </label>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col-md-6">
                                      <label style="color:#34495e">
                                        <b>
                                          Subproceso
                                        </b>
                                      </label>
                                      <label class="field select">
                                        <select name="subproceso" id="subproceso" style="width:400" required>
                                          <option value="">
                                            * Subproceso
                                          </option>
                                          <?php
                                          $Macroprocesos = PanelMacroProcesos::getMacroprocesos();
                                          ?>
                                          @foreach($Macroprocesos as $DatMac)
                                            <?php
                                            $Procesos = PanelProcesos::getProcesosMacro($DatMac->id_macroproceso);
                                            ?>
                                            @foreach($Procesos as $DatPro)
                                              <?php
                                              $Subprocesos = PanelSubProcesos::getSubprocesos($DatPro->id_proceso);
                                              ?>
                                              @foreach($Subprocesos as $DatSub)
                                                <option value="<?=$DatSub->id_subproceso?>">
                                                  <?php
                                                  echo $DatMac->descripcion;
                                                  echo " | ";
                                                  echo $DatPro->descripcion;
                                                  echo " | ";
                                                  echo $DatSub->descripcion;
                                                  ?>
                                                </option>
                                              @endforeach
                                            @endforeach
                                          @endforeach
                                        </select>
                                        <i class="arrow"></i>
                                      </label>
                                    </div>

                                    <div class="col-md-6">
                                      <br><br>
                                      {!! Form::submit('Asociar subproceso', array('class'=>'button')) !!}
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
                          <?php
                          $SubProcesos = PanelSubProceDocu::getSubProDocumen($DatDoc->id_documento);
                          $subp        = 0;
                          ?>
                          @foreach($SubProcesos as $DatSub)
                            <?php
                            $subp++;
                            ?>
                            <tr>
                              <td align="left">
                                <button type="button" style="cursor:default;" class="btn btn-default light">
                                  <b>
                                    <?php
                                    echo $subp;
                                    ?>
                                  </b>
                                </button>
                                &nbsp;
                                <font color="#001137">
                                  <?php
                                  $Proceso = PanelProcesos::getProceso($DatSub->proceso);
                                  $Macro   = PanelMacroProcesos::getMacroProceso($Proceso[0]->macroproceso);
                                  echo $Proceso[0]->descripcion;
                                  echo " | ";
                                  echo $Macro[0]->descripcion;
                                  echo " | ";
                                  echo "<b>";
                                    echo $DatSub->descripcion;
                                  echo "</b>";
                                  ?>
                                </font>
                              </td>
                            </tr>
                          @endforeach
                        </thead>
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