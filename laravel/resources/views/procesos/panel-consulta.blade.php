<?php
$server ='/Berhlan/public';

use App\Models\Procesos\PanelMacroProcesos;
use App\Models\Procesos\PanelProcesos;
use App\Models\Procesos\PanelSubProcesos;
use App\Models\Procesos\PanelDocumentos;
use App\Models\Procesos\PanelTiposDocumentos;
use App\Models\Procesos\PanelPerfiles;
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
                    <a href="<?=$server?>/panel/menu/6" title="Procesos internos">
                      <font color="#34495e">
                        Procesos internos >
                      </font>
                      <font color="#b4c056">
                        Consulta general
                      </font>
                    </a>
                  </li>
                </ul>
              </div>

              <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                <a href="<?=$server?>/panel/menu/6" class="btn btn-primary btn-sm ml10" title="Procesos internos">
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
              Exportar
              <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.location.href='<?=$server?>/panel/procesos/consulta/detalle'" title="Exportar">
                <i class="fa fa-file-excel-o fa-2x" style="color:#28B463;"></i>
              </button>
              <br>

              <div class="panel m3">
                <!-- -------------- Message Body -------------- -->
                <div class="nano-content">
                  <div class="table-responsive">
                    <table id="message-table" class="table allcp-form theme-warning br-t">
                      <thead>
                        <tr style="background-color: #F8F8F8">
                          <th style="text-align:right">
                            Id
                          </th>
                          <th style="text-align:left">
                            Macroproceso
                          </th>
                          <th style="text-align:right">
                            Id
                          </th>
                          <th style="text-align:left">
                            Proceso
                          </th>
                          <th style="text-align:right">
                            Id
                          </th>
                          <th style="text-align:left">
                            Subproceso
                          </th>
                          <th style="text-align:right">
                            Id
                          </th>
                          <th style="text-align:left">
                            Documento
                          </th>
                          <th style="text-align:center">
                            Grupo
                          </th>
                          <th style="text-align:center;">
                            Perfiles con acceso
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
                                ?>
                                <tr>
                                  <td style="text-align:right">
                                    <?=$DatMac->id_macroproceso?>
                                  </td>

                                  <td style="text-align:left">
                                    <?=$DatMac->descripcion?>
                                  </td>

                                  <td style="text-align:right">
                                    <?=$DatPro->id_proceso?>
                                  </td>

                                  <td style="text-align:left">
                                    <?=$DatPro->descripcion?>
                                  </td>

                                  <td style="text-align:right">
                                    <?=$DatSub->id_subproceso?>
                                  </td>

                                  <td style="text-align:left">
                                    <?=$DatSub->descripcion?>
                                  </td>

                                  <td style="text-align:right">
                                    <?=$DatDoc->id_documento?>
                                  </td>

                                  <td style="text-align:left">
                                    <?=$DatDoc->descripcion?>
                                  </td>

                                  <td style="text-align:center">
                                    <?php
                                    $tipo = PanelTiposDocumentos::getTipo($DatDoc->tipo);
                                    echo $tipo[0]->descripcion;
                                    ?>
                                  </td>

                                  <td style="text-align:justify">
                                    <?php
                                    $DatosPerfiles = PanelPerfiles::getDocumentosPerfil($DatDoc->id_documento);
                                    $t = 0;
                                    ?>
                                    @foreach($DatosPerfiles as $DatPer)
                                      <?php
                                      echo $DatPer->descripcion;
                                      if($t == 0)
                                        $t++;
                                      else
                                        echo " || ";
                                      ?>
                                    @endforeach
                                    <?php
                                    if($t == 0)
                                      echo "Libre acceso";
                                    ?>
                                  </td>
                                </tr>
                              @endforeach

                              <?php
                              if($a == 0)
                               {
                                ?>
                                <tr>
                                  <td style="text-align:right">
                                    <?=$DatMac->id_macroproceso?>
                                  </td>

                                  <td style="text-align:left">
                                    <?=$DatMac->descripcion?>
                                  </td>

                                  <td style="text-align:right">
                                    <?=$DatPro->id_proceso?>
                                  </td>

                                  <td style="text-align:left">
                                    <?=$DatPro->descripcion?>
                                  </td>

                                  <td style="text-align:right">
                                    <?=$DatSub->id_subproceso?>
                                  </td>

                                  <td style="text-align:left">
                                    <?=$DatSub->descripcion?>
                                  </td>

                                  <td style="text-align:left">
                                  </td>

                                  <td style="text-align:left">

                                  </td>
                                  <td style="text-align:left">
                                  </td>
                                  <td style="text-align:left">

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

      !-- -------------- DataTables -------------- -->
      <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
      <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
      <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

      <script>
        $(document).ready(function() {

            let datatable = $('#message-table').DataTable({
                ordering: true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
        })
    </script>
    </body>
  </html>
@endforeach
