<?php
$server = '/Berhlan/public';

use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
?>

@foreach($DatosUsuario as $DatLog)
<!DOCTYPE html>
<html>

<head>
  <!-- -------------- Meta and Title -------------- -->
  <meta charset="utf-8">
  <title>
    Intranet | Bcloud | Pendientes de impresión muestras físicas
  </title>
  <meta name="description" content="Intranet para grupo Berhlan">
  <meta name="author" content="USUARIO">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- -------------- Fonts -------------- -->
  <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
  <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

  <!-- -------------- CSS - theme -------------- -->
  <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/skin/default_skin/css/theme.css">

  <!-- -------------- CSS - allcp forms -------------- -->
  <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/allcp/forms/css/forms.min.css">

  <!-- -------------- Plugins -------------- -->
  <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

  <!-- -------------- Favicon -------------- -->
  <link rel="shortcut icon" href="<?= $server ?>/panelfiles/assets/img/favicon.ico">

  <!-- Alerts Personalizados -->
  <script src="<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.min.js"></script>

  <link rel="stylesheet" href="<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.css">

  <script language="JavaScript">
    //<!--
    function cancelarMuestra(id) {
      swal({
          title: "Cancelar Solicitud?",
          text: "¿Esta seguro de Cancelarla del Sistema?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Si, Cancelar!",
          closeOnConfirm: false
        },
        function() {
          swal("Cancelar!", "La Solicitud ha sido Cancelada.", "success");
          location = '<?= $server ?>/panel/bpack/muestras/cancelar/' + id;
        });
    }


    function cambiarArea() {
      var myElement = document.getElementById('area');
      var area = myElement.value;
      location = '<?= $server ?>/panel/bpack/muestras/pendientes/' + area;
    }
    //-->
  </script>

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
              <a href="<?= $server ?>/panel/bpack/solpendientes" title="Bcloud > Pendientes de">
                <font color="#34495e">
                  Bcloud > Pendientes de >
                </font>
                <font color="#b4c056">
                  Impresión muestras físicas
                </font>
              </a>
            </li>
          </ul>
        </div>

        <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
          <a href="<?= $server ?>/panel/bpack/solpendientes" class="btn btn-primary btn-sm ml10" title="Bcloud > Pendientes de">
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
          <div class="panel m10">
            <!-- -------------- Message Body -------------- -->
            <div class="table-responsive">

              <form name="noticias" method="get" class="panel-menu allcp-form  mtn d-flx">
                <div class="row">
                  <h5 class="col-md-2" style="padding-top: 20px">Listar por estado: &nbsp;</h5>
                  <div class="col-md-3">
                    <label class="field select">
                      <select name="area" id="area" onChange='cambiarArea()' class="empty">
                        <option value="0">Seleccione...</option>
                        <option value="0">Activas</option>
                        <option value="1">Cerradas</option>
                        <option value="2">Canceladas</option>
                      </select>
                      <i class="arrow"></i>
                    </label>
                  </div>
                </div>
              </form>

              <br />
              <div style="padding-left: 10px">
                Preprensa - Impresión de muestras físicas | Estado ( <span style="color: #F6565A"><?= $titEstado ?> )</span>
              </div>
              <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                <thead>
                  <tr style="background-color: #F8F8F8">
                    <th style="text-align: right;">
                      #
                    </th>
                    <th style="text-align: center">
                      Solicitud
                    </th>
                    <th style="text-align: left">
                      Descripción
                    </th>
                    <th style="text-align: left">
                      Tamaño
                    </th>
                    <th style="text-align: center">
                      Cantidad
                    </th>
                    <th style="text-align: center">
                      Solicitado por
                    </th>
                    <th style="text-align: center">
                      Fecha
                    </th>
                    <th style="text-align: center">
                      Atender
                    </th>
                    <th style="text-align: center">
                      Cancelar
                    </th>
                  </tr>
                </thead>

                <tbody>
                  <?php $u = 1; ?>
                  @foreach($MuestrasPendientes as $DatMue)
                  <tr class="message-unread">
                    <td style="text-align: right;">
                      <font color="#2A2F43">
                        <?php
                        print $u;
                        $u++;
                        ?>
                      </font>
                    </td>

                    <td style="text-align: center;">
                      <font color="#2A2F43">
                        <b>
                          SMF<?= $DatMue->id_solicitud ?>
                        </b>
                      </font>
                    </td>

                    <td style="text-align:justify;">
                      <font color="#2A2F43">
                        <?= $DatMue->descripcion ?>
                      </font>
                    </td>

                    <td style="text-align:justify;">
                      <font color="#2A2F43">
                        <?= $DatMue->tamano ?>
                      </font>
                    </td>

                    <td style="text-align:center;">
                      <font color="#2A2F43">
                        <?= $DatMue->cantidad ?>
                      </font>
                    </td>

                    <td style="text-align: left">
                      <font color="#2A2F43">
                        <?php
                        $empleado = PanelEmpleados::getEmpleado($DatMue->usr_crea);
                        echo $empleado[0]->primer_nombre;
                        echo " ";
                        echo $empleado[0]->ot_nombre;
                        echo " ";
                        echo $empleado[0]->primer_apellido;
                        echo " ";
                        echo $empleado[0]->ot_apellido;
                        echo "<br>";
                        $cargo = PanelCargos::getCargo($empleado[0]->cargo);
                        echo $cargo[0]->descripcion;
                        ?>
                      </font>
                    </td>

                    <td style="text-align:center;">
                      <font color="#2A2F43">
                        <?= $DatMue->fecha_crea ?>
                      </font>
                    </td>

                    <td style="text-align: center">
                      <button type="button" class="btn btn-default light" onclick="window.location.href='<?= $server ?>/panel/bpack/muestras/procesar/<?= $DatMue->id_solicitud ?>'">
                        <i class="fa fa-pencil fa-lg" style="color:#AEBF25;"></i>
                      </button>
                    </td>

                    <!-- Cancelar -->
                    <?php if ($DatMue->cancelada == 1) { ?>
                      <td style="text-align: center">
                        <button type="button" class="btn btn-default light" onClick="cancelarMuestra(<?= $DatMue->id_solicitud ?>)" disabled>
                          <i class="fa fa-trash fa-lg" style="color:#666666;"></i>
                        </button>
                      </td>
                    <?php } ?>

                    <?php if ($DatMue->cancelada == 0 && ($DatMue->usr_cierre != '' && $DatMue->usr_cierre != 0)) { ?>
                      <td style="text-align: center">
                        <button type="button" class="btn btn-default light" onClick="cancelarMuestra(<?= $DatMue->id_solicitud ?>)" disabled>
                          <i class="fa fa-trash fa-lg" style="color:#666666;"></i>
                        </button>
                      </td>
                    <?php } ?>

                    <?php if ($DatMue->cancelada == 0 && ($DatMue->usr_cierre == '' || $DatMue->usr_cierre == 0)) { ?>
                      <td style="text-align: center">
                        <button type="button" class="btn btn-default light" onClick="cancelarMuestra(<?= $DatMue->id_solicitud ?>)">
                          <i class="fa fa-trash fa-lg" style="color:#F6565A;"></i>
                        </button>
                      </td>
                    <?php } ?>
                  </tr>
                  @endforeach
                </tbody>
              </table>
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
  <script src="<?= $server ?>/panelfiles/assets/js/jquery/jquery-1.11.3.min.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js"></script>

  <!-- -------------- JvectorMap Plugin -------------- -->
  <script src="<?= $server ?>/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js"></script>

  <!-- -------------- HighCharts Plugin -------------- -->
  <script src="<?= $server ?>/panelfiles/assets/js/plugins/highcharts/highcharts.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/d3.min.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/c3.min.js"></script>

  <!-- -------------- Theme Scripts -------------- -->
  <script src="<?= $server ?>/panelfiles/assets/js/utility/utility.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/demo/demo.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/main.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/demo/widgets_sidebar.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/pages/dashboard2.js"></script>

  <!-- -------------- Page JS -------------- -->
  <script src="<?= $server ?>/panelfiles/assets/js/demo/charts/highcharts.js"></script>

  <!-- -------------- /Scripts -------------- -->
</body>

</html>
@endforeach
