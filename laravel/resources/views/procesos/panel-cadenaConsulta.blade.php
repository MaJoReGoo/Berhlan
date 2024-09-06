<?php
$server ='/Berhlan/public';

use App\Models\Procesos\PanelMacroProcesos;
use App\Models\Procesos\PanelProcesos;
use App\Models\Procesos\PanelSubProcesos;
use App\Models\Procesos\PanelDocumentos;
use App\Models\Procesos\PanelTiposDocumentos;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Cadena de valor | Consulta
      </title>

      <meta name="description" content="Intranet para grupo Berhlan">
      <meta name="author" content="USUARIO" >
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!-- -------------- Fonts -------------- -->
      <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
      <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

      <!-- -------------- CSS - theme -------------- -->
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/skin/default_skin/css/theme.css">

      <!-- -------------- CSS - allcp forms -------------- -->
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/allcp/forms/css/forms.min.css">

      <!-- -------------- Plugins -------------- -->
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

      <!-- -------------- Favicon -------------- -->
      <link rel="shortcut icon" href="<?=$server?>/panelfiles/assets/img/favicon.png">

      <!-- -------------- DataTables -------------- -->
      <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
    </head>

    <body class="sales-stats-page">
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
                    <a href="<?=$server?>/panel/procesos/cadena" title="Procesos internos > Cadena de valor">
                      <font color="#34495e">
                        Procesos internos > Cadena de valor >
                      </font>
                      <font color="#b4c056">
                        Consulta general
                      </font>
                    </a>
                  </li>
                </ul>
              </div>

              <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                <a href="<?=$server?>/panel/procesos/cadena" class="btn btn-primary btn-sm ml10" title="Procesos internos > Cadena de valor">
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
                        <tr style="background-color: #F8F8F8">
                          <th style="text-align:center; width:2px;">
                            C
                          </th>
                          <th style="text-align:left">
                            Macroproceso
                          </th>
                          <th style="text-align:left">
                            Proceso
                          </th>
                          <th style="text-align:left">
                            Subproceso
                          </th>
                          <th style="text-align:left">
                            Documento
                          </th>
                          <th style="text-align:left">
                            Archivo
                          </th>
                          <th style="text-align:center">
                            Grupo
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        $DatosMacro = PanelMacroProcesos::getMacroProcesos();
                        ?>
                        @foreach($DatosMacro as $DatMac)
                          <?php
                          $Datosprocesos = PanelProcesos::getProcesosMacro($DatMac->id_macroproceso);
                          ?>
                          @foreach($Datosprocesos as $DatPro)
                            <?php
                            $DatosSubprocesos = PanelSubProcesos::getSubProcesos($DatPro->id_proceso);
                            ?>
                            @foreach($DatosSubprocesos as $DatSub)
                              <?php
                              $Documentos = PanelDocumentos::getDocumentosSubProceso($DatSub->id_subproceso);
                              $a = 0;
                              ?>
                              @foreach($Documentos as $DatDoc)
                                <?php
                                $a++;
                                $fondo  = $DatMac->fondo;
                                ?>
                                <tr>
                                  <td>
                                    <i class="fa fa-square fa-2x fa-lg" style="color:#<?=$fondo?>;"></i>
                                  </td>

                                  <td style="text-align:left">
                                    <?=$DatMac->descripcion?>
                                  </td>

                                  <td style="text-align:left">
                                    <?=$DatPro->descripcion?>
                                  </td>

                                  <td style="text-align:left">
                                    <?=$DatSub->descripcion?>
                                  </td>

                                  <td style="text-align:left">
                                    <?=$DatDoc->descripcion?>
                                  </td>

                                  <td style="text-align:center">
                                    <?php
                                    //Valido que el usuario tenga acceso al archivo
                                    $acceso = 1;  //1 acceso a descarga
                                    $CantDocPer = PanelDocumentos::getDocumentoPerfiles($DatDoc->id_documento);
                                    if($CantDocPer > 0)  //Si el documento esta asociado a un perfil (restringido)
                                     {

                                      $CantDocPerUsr = PanelDocumentos::getDocumentoPerfilesAcceso($DatDoc->id_documento, $DatLog->id_usuario);
                                      $CantDocUsr = PanelDocumentos::getDocumentosUsuarioAcceso($DatDoc->id_documento, $DatLog->id_usuario);
                                      if($CantDocPerUsr == 0 && $CantDocUsr == 0)
                                      $acceso = 0;
                                    //0 acceso a descarga restringido
                                     }

                                    if($acceso == 1)
                                     {
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

                                      $descarga = "window.open('".$server."/archivos/Procesos/Documentos/".$DatDoc->ruta1."?".date('i:s')."','_blank')";
                                      $titulo   = $DatDoc->ruta1;
                                     }
                                    else
                                     {
                                      $descarga = "";
                                      $titulo   = "No disponible para descarga";
                                      $fonicono = "f5b7b1";
                                      $icono    = "fa-eye-slash";
                                     }
                                    ?>
                                    <button type="button" style="background:transparent;" class="btn btn-default light" onclick="<?=$descarga?>" title="<?=$titulo?>">
                                      <i class="fa <?=$icono?> fa-2x fa-lg" style="color:#<?=$fonicono?>;"></i>
                                    </button>
                                  </td>

                                  <td style="text-align:center">
                                    <?php
                                    $tipo = PanelTiposDocumentos::getTipo($DatDoc->tipo);
                                    echo $tipo[0]->descripcion;
                                    ?>
                                  </td>
                                </tr>
                              @endforeach

                              <?php
                              if($a == 0)
                               {
                                ?>
                                <tr>
                                  <td>
                                    <i class="fa fa-square fa-2x fa-lg" style="color:#<?=$fondo?>;"></i>
                                  </td>

                                  <td style="text-align:left">
                                    <?=$DatMac->descripcion?>
                                  </td>

                                  <td style="text-align:left">
                                    <?=$DatPro->descripcion?>
                                  </td>

                                  <td style="text-align:left">
                                    <?=$DatSub->descripcion?>
                                  </td>

                                  <td>
                                  </td>
                                  <td>
                                  </td>
                                  <td>
                                  </td>
                                </tr>
                                <?php
                               }
                              ?>
                            @endforeach
                          @endforeach
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- -------------- Column Center -------------- -->
          <!-- -------------- /Column Center -------------- -->
        </section>
        <!-- -------------- /Content -------------- -->
      </div>
      <!-- -------------- /Body Wrap  -------------- -->
      <!-- -------------- Scripts -------------- -->
      <!-- -------------- jQuery -------------- -->
      <script src="<?=$server?>/panelfiles/assets/js/jquery/jquery-1.11.3.min.js"></script>
      <script src="<?=$server?>/assets/js/jquery/jquery_ui/jquery-ui.min.js"></script>

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
      <script src="<?=$server?>/panelfiles/assets/js/demo/widgets_sidebar.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/pages/dashboard2.js"></script>

      <!-- -------------- Page JS -------------- -->
      <script src="<?=$server?>/panelfiles/assets/js/demo/charts/highcharts.js"></script>

      <!-- -------------- DataTables -------------- -->
      <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
      <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
      <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

      <script>
      $('#message-table').DataTable(
       {
        "language":
                   {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                   }
       }
       );

      window.setInterval("reFresh()",600000);
      function reFresh()
       {
        location.reload(true);
       }
      </script>
      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach
