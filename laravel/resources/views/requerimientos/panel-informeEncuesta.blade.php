<?php
$server = '/Berhlan/public';

use App\Models\Requerimientos\PanelGrupos;
use App\Models\Requerimientos\PanelSolicitudes;
use App\Models\Requerimientos\PanelCategorias;
use App\Models\Requerimientos\PanelPriorizaciones;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelAreas;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Requerimientos | Informe encuestas
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

      <!-- -------------- CSS - Para circulo -------------- -->
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/allcp/forms/css/circulo.css">

      <!-- -------------- Plugins -------------- -->
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

      <!-- -------------- Favicon -------------- -->
      <link rel="shortcut icon" href="<?=$server?>/panelfiles/assets/img/favicon.ico">

      <!-- Editor -->
      <script type="text/javascript" src="<?=$server?>/panelfiles/ckeditor/ckeditor.js"></script>

      <!-- -------------- DataTables -------------- -->
      <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
    </head>


    <?php
    if($Desde != '')
      $Desdehora = $Desde." 00:00:01";
    else
      $Desdehora = "";

    if($Hasta != '')
      $Desdehasta = $Hasta." 23:59:59";
    else
      $Desdehasta = "";

    $EncuestaRq = PanelSolicitudes::ConEncuestaRequerimientos($Grupo, $Desdehora, $Desdehasta);
    $t = 0;
    $muy = $pmuy = $sas = $psas = $ins = $pins = 0;
    ?>
    @foreach($EncuestaRq as $DatEnc)
      <?php
      $t = $t + $DatEnc->cant;
      ?>
    @endforeach

    @foreach($EncuestaRq as $DatEnc)
      <?php
      $val  = $DatEnc->cant;
      $prog = round((($val*100)/$t), 1);

      if($DatEnc->calificacion == 'M')
       {
        $muy  = $DatEnc->cant;
        $pmuy = $prog;
       }
      else if($DatEnc->calificacion == 'S')
       {
        $sas  = $DatEnc->cant;
        $psas = $prog;
       }
      else if($DatEnc->calificacion == 'I')
       {
        $ins  = $DatEnc->cant;
        $pins = $prog;
       }
      ?>
    @endforeach

    <body onload="CIRCULO(<?=$muy?>, <?=$pmuy?>, <?=$sas?>, <?=$psas?>, <?=$ins?>, <?=$pins?>);">
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
        <section id="content_wrapper" >
          <!-- -------------- Topbar -------------- -->
          <header id="topbar" class="ph10">
            <div class="topbar-left">
              <ul class="nav nav-list nav-list-topbar pull-left">
                <li class="active">
                  <?php
                  $nomgrupo = PanelGrupos::getGrupo($Grupo);
                  ?>
                  <a href="<?=$server?>/panel/requerimientos/informe" title="Requerimientos > Informe">
                    <font color="#34495e">
                      Requerimientos > Informe resultados de encuestas >
                    </font>
                    <font color="#b4c056">
                      Grupo <?=$nomgrupo[0]->descripcion?>
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/requerimientos/informe" class="btn btn-primary btn-sm ml10" title="Requerimientos > Informe">
                REGRESAR &nbsp;
                <span class="fa fa-arrow-left"></span>
              </a>
            </div>
          </header>

          <!-- -------------- /Topbar -------------- -->
          <br>

          <!-- -------------- Imagen circular -------------- -->
          <div class="row">
            <div class="col-sm-9 col-xl-6">
              <div class="col-xs-12 ph10 text-center panel panel-body">
                <canvas id="circulo" width="100%" height="15"></canvas>
              </div>
            </div>
          </div>

          <script type="text/javascript">
          function CIRCULO(val1, por1, val2, por2, val3, por3)
           {
            var ctx = document.getElementById("circulo");
            var myPieChart = new Chart(ctx,
             {
              type: 'doughnut',
              data:
               {
                labels: ["Muy satisfecho: "+por1+"%", "Satisfecho: "+por2+"%", "Insatisfecho: "+por3+"%"],
                datasets: [
                 {
                  data: [val1, val2, val3],
                  backgroundColor: ['#FEDA00', '#FF8C19', 'red'],
                  borderColor: "#232F76",
                  borderWidth: 1
                 }],
               },
              options:
               {
                legend:
                 {
                  display: true,
                  labels:
                   {
                    fontSize: 16
                   },
                  position: 'right'
                 }
               }
             });
           }
          </script>
          <!-- -------------- /Imagen circular -------------- -->

          <div class="col-sm-3 col-xl-2">
            <div class="col-xs-12 ph10 text-center  panel panel-body">
              <i class="fa fa-3x" style="color:#FEDA00; text-shadow: 1px -1px 1px #000;">
                <img src="/Berhlan/public/images/requerimientos/feliz.jpg" class="img-responsive mauto" style="width: 70px; border-radius:6px; border:1;" />
                <?=$muy?>
              </i>
              <h6 class="text-muted" style="padding-top: 20px">
                <font color="#2a2f43">
                  Muy satisfecho
                </font>
              </h6>
            </div>
          </div>

          <div class="col-sm-3 col-xl-2">
            <div class="col-xs-12 ph10 text-center  panel panel-body">
              <i class="fa fa-3x" style="color:#FF8C19; text-shadow: 1px -1px 1px #000;">
                <img src="/Berhlan/public/images/requerimientos/normal.jpg" class="img-responsive mauto" style="width: 70px; border-radius:6px; border:1;" />
                <?=$sas?>
              </i>
              <h6 class="text-muted" style="padding-top: 20px">
                <font color="#2a2f43">
                  Satisfecho
                </font>
              </h6>
            </div>
          </div>

          <div class="col-sm-3 col-xl-2">
            <div class="col-xs-12 ph10 text-center  panel panel-body">
              <i class="fa fa-3x" style="color:red; text-shadow: 1px -1px 1px #000;">
                <img src="/Berhlan/public/images/requerimientos/triste.jpg" class="img-responsive mauto" style="width: 70px; border-radius:6px; border:1;" />
                <?=$ins?>
              </i>
              <h6 class="text-muted" style="padding-top: 20px">
                <font color="#2a2f43">
                  Insatisfecho
                </font>
              </h6>
            </div>
          </div>

          <!-- -------------- Content -------------- -->
          <section id="content" class="table-layout animated fadeIn">
            <div class="chute chute-center pt5">
              <!-- -------------- Column Center -------------- -->
              <div class="panel m3">
                <!-- -------------- Message Body -------------- -->
                <div class="nano-content">
                  <div class="table-responsive">
                    <table id="message-table1" class="table theme-warning br-t">
                      <thead>
                        <tr style="background-color:#39405a">
                          <th style="color:white;" colspan="6">
                            Informe resultados de encuestas para el grupo <?=$nomgrupo[0]->descripcion?>
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <th width="250">
                            Cantidad de requerimientos:
                          </th>
                          <th>
                            <font size="4">
                              <?php
                              echo $t;
                               $Cantidad = PanelSolicitudes::TRequerimientosGrupo($Grupo, $Desdehora, $Desdehasta);
                              ?>
                            </font>
                          </th>
                        </tr>

                        <tr>
                          <th width="250">
                            Fecha desde:
                          </th>
                          <td>
                            <?php
                            if($Desde == '')
                              echo "No ingresada";
                            else
                              echo $Desde;
                            ?>
                          </td>
                        </tr>

                        <tr>
                          <th width="250">
                            Fecha hasta:
                          </th>
                          <td>
                            <?php
                            if($Hasta == '')
                              echo "No ingresada";
                            else
                              echo $Hasta;
                            ?>
                          </td>
                        </tr>

                        <tr>
                          <td style="vertical-align: top;" colspan="6">
                            <table id="tabla" class="table theme-warning br-t">
                              <thead>
                                <tr style="background-color:#67d3e0; color:#34495e;">
                                  <th nowrap>
                                    Sol.
                                  </th>
                                  <th style="text-align:justify;">
                                    Solicitud
                                  </th>
                                  <th style="text-align:justify;">
                                    Observaciones al responder la encuesta
                                  </th>
                                  <th style="text-align:center">
                                    Percepción
                                  </th>
                                  <th style="text-align:center" width="100">
                                    Fecha solicitud
                                  </th>
                                  <th style="text-align:center" width="100">
                                    Fecha cierre
                                  </th>
                                  <th style="text-align:center" width="100">
                                    Fecha encuesta
                                  </th>
                                  <th style="text-align:center">
                                    Atendido por
                                  </th>
                                </tr>
                              </thead>

                              <?php
                              $EncuestaLis = PanelSolicitudes::ConEncuestaRequerimientosLis($Grupo, $Desdehora, $Desdehasta);
                              ?>
                              @foreach($EncuestaLis as $DatEnc)
                                <tr>
                                  <td align="right">
                                    <button type="button" class="btn btn-default light" onclick="window.open('<?=$server?>/panel/requerimientos/consultausr/masinfo1/<?=$DatEnc->num_solicitud?>','_blank','status=no','directories=no','menubar=no','toolbar=no','scrollbars=no','location=no','resizable=no','titlebar=no')" title="Más información">
                                      <font color="#34495e" size="3">
                                        <?=$DatEnc->num_solicitud;?>
                                      </font>
                                    </button>
                                  </td>

                                  <td style="text-align:justify;">
                                    <div style="height:100px; width:100%; overflow-x:auto; overflow-x:hidden;">
                                      <?=$DatEnc->descripcion?>
                                    </div>
                                  </td>

                                  <td style="text-align:justify;">
                                    <div style="height:100px; width:100%; overflow-x:auto;">
                                      <?=$DatEnc->des_calificacion?>
                                    </div>
                                  </td>

                                  <td style="text-align:center;">
                                    <?php
                                    if($DatEnc->calificacion == 'M')
                                     {
                                      echo "<font style=\"color:#FEDA00; text-shadow: 0px 0px 1px #000;\">";
                                        echo "Muy satisfecho";
                                     }
                                    else if($DatEnc->calificacion == 'S')
                                     {
                                      echo "<font style=\"color:#FF8C19; text-shadow: 0px 0px 1px #000;\">";
                                        echo "Satisfecho";
                                     }
                                    else if($DatEnc->calificacion == 'I')
                                     {
                                      echo "<font style=\"color:red; text-shadow: 0px 0px 1px #000;\">";
                                        echo "Insatisfecho";
                                     }
                                    ?>
                                      </font>
                                  </td>

                                  <td style="text-align:center;">
                                    <?=$DatEnc->fecha_solicita?>
                                  </td>

                                  <td style="text-align:center;">
                                    <?=$DatEnc->fecha_cierre?>
                                  </td>

                                  <td style="text-align:center;">
                                    <?=$DatEnc->fecha_calificacion?>
                                  </td>

                                  <td style="text-align:center;">
                                    <?php
                                    $atendido = PanelEmpleados::getEmpleado($DatEnc->usr_cierre);
                                    echo $atendido[0]->primer_nombre;
                                    echo " ";
                                    echo $atendido[0]->ot_nombre;
                                    echo " ";
                                    echo $atendido[0]->primer_apellido;
                                    echo " ";
                                    echo $atendido[0]->ot_apellido;
                                    ?>
                                  </td>
                                </tr>
                              @endforeach
                            </table>
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

      <!-- -------------- Para los graficos -------------- -->
      <script src="<?=$server?>/panelfiles/assets/js/Chart.min.js"></script>

      <!-- -------------- DataTables -------------- -->
      <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
      <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
      <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

      <script>
      $('#tabla').DataTable(
       {
        "pageLength": 25,
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 3, "asc" ], [ 7, "asc" ]],
        "language":
                   {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                   }
       }
       );
      </script>
      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach