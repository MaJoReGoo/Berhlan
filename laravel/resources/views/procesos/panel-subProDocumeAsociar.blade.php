<?php
$server ='/Berhlan/public';
use App\Models\Procesos\PanelProcesos;
use App\Models\Procesos\PanelMacroProcesos;
use App\Models\Procesos\PanelDocumentos;
use App\Models\Procesos\PanelTiposDocumentos;
?>

@foreach($DatosUsuario as $DatLog)
  @foreach($DatosSubProceso as $DatSub)
    <!DOCTYPE html>
    <html>
      <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
          Intranet | Procesos | Asociar documento
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
                    <a href="<?=$server?>/panel/procesos/subprodocume" title="Procesos internos > Subprocesos - Documentos">
                      <font color="#34495e">
                        Procesos internos > Subprocesos - Documentos >
                      </font>
                      <font color="#b4c056">
                        Asociar
                      </font>
                    </a>
                  </li>
                </ul>
              </div>

              <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                <a href="<?=$server?>/panel/procesos/subprodocume" class="btn btn-primary btn-sm ml10" title="Procesos internos > Subprocesos - Documentos">
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
                              Asocie el documento al subproceso
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr>
                            <td>
                              <div class="allcp-form">
                                {!! Form::open(array('action' => 'Procesos\SubDocProcesosPanelController@SubProDocumeAsociarDB', 'class' => 'form', 'id'=>'form-wizard')) !!}
                                  {!! Form::hidden('login', $DatLog->login) !!}
                                  {!! Form::hidden('id_subproceso', $DatSub->id_subproceso) !!}

                                  <?php
                                  $Proceso = PanelProcesos::getProceso($DatSub->proceso);
                                  $Macro   = PanelMacroProcesos::getMacroProceso($Proceso[0]->macroproceso);
                                  ?>
                                  <div class="section">
                                    <div class="col-md-2">
                                      <label style="color: #4ECCDB">
                                        Macroproceso
                                      </label>
                                      <label class="field prepend-icon">
                                        <b>
                                          <?=$Macro[0]->descripcion?>
                                        </b>
                                      </label>
                                    </div>

                                    <div class="col-md-3">
                                      <label style="color: #4ECCDB">
                                        Proceso
                                      </label>
                                      <label class="field prepend-icon">
                                        <b>
                                          <?=$Proceso[0]->descripcion?>
                                        </b>
                                      </label>
                                    </div>

                                    <div class="col-md-2">
                                      <label style="color:#4ECCDB">
                                        Subproceso
                                      </label>
                                      <label class="field prepend-icon">
                                        <b>
                                          <?=$DatSub->descripcion?>
                                        </b>
                                      </label>
                                    </div>
                                  </div>

                                  <div class="section">
                                    <div class="col-md-7">
                                      <br>
                                      <label style="color:#4ECCDB">
                                        Documento
                                      </label>
                                      <label class="field select">
                                        <select name="documento" id="documento" required>
                                          <option value="">
                                            * Documento
                                          </option>
                                          <?php
                                          $Documentos = PanelDocumentos::getDocumentos();
                                          ?>
                                          @foreach($Documentos as $DatDoc)
                                            <option value="<?=$DatDoc->id_documento?>">
                                              <?php
                                              echo $DatDoc->descripcion;
                                              $Tipo = PanelTiposDocumentos::getTipo($DatDoc->tipo);
                                              echo " (".$Tipo[0]->descripcion.")";
                                              ?>
                                            </option>
                                          @endforeach
                                        </select>
                                        <i class="arrow"></i>
                                      </label>
                                    </div>
                                  </div>

                                  <div class="section">
                                    <div class="col-md-7">
                                      <br><br>
                                      {!! Form::submit('Asociar documento', array('class'=>'button')) !!}
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
                                Documentos asociados
                              </font>
                            </th>
                          </tr>
                        </thead>

                        <thead>
                          <tr style="background-color:#e5eaee; color: #626262">
                            <th style="text-align: left">
                              #
                            </th>
                            <th style="text-align: left">
                              Nombre
                            </th>
                            <th style="text-align: center">
                              Archivo
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                          $DatDocumentos = PanelDocumentos::getDocumentosSubProceso($DatSub->id_subproceso);
                          $u = 1;
                          ?>
                          @foreach($DatDocumentos as $DatDoc)
                            <tr class="message-unread">
                              <td style="text-align: left ">
                                <font color="#2A2F43">
                                  <?php
                                  print $u;
                                  $u++;
                                  ?>
                                </font>
                              </td>

                              <td>
                                <b>
                                  <font color="#2A2F43">
                                    <?=$DatDoc->descripcion?>
                                    &nbsp;
                                    (
                                     <?php
                                     $Tipo = PanelTiposDocumentos::getTipo($DatDoc->tipo);
                                     echo $Tipo[0]->descripcion;
                                     ?>
                                    )
                                  </font>
                                </b>
                              </td>

                              <td align="center">
                                <?php
                                $nombrearc = $DatDoc->ruta1;
                                $ext       = explode('.', $nombrearc);
                                $ext1      = end($ext);

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

                                <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.location.href='<?=$server?>/archivos/Procesos/Documentos/<?=$DatDoc->ruta1?>'" title="<?=$DatDoc->ruta1?>">
                                  <i class="fa <?=$icono?> fa-lg" style="color:#<?=$fonicono?>;"></i>
                                </button>
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