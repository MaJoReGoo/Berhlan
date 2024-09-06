<?php
$server = '/Berhlan/public';

use App\Models\Requerimientos\PanelGrupos;
use App\Models\Requerimientos\PanelSolicitudes;
use App\Models\Requerimientos\PanelCategorias;
use App\Models\Requerimientos\PanelPriorizaciones;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Parametrizacion\PanelCargos;
?>

@foreach($DatosUsuario as $DatLog)
<!DOCTYPE html>
<html>

<head>
  <!-- -------------- Meta and Title -------------- -->
  <meta charset="utf-8">
  <title>
    Intranet | Muestras Comerciales
  </title>
  <meta name="keywords" content="panel, cms, usuarios, servicio" />
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
  <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/allcp/forms/css/forms.css">

  <!-- -------------- Plugins -------------- -->
  <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

  <!-- -------------- Favicon -------------- -->
  <link rel="shortcut icon" href="<?= $server ?>/panelfiles/assets/img/favicon.ico">

  <script src="https://<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://<?= $server ?>/panelfiles/sweetalert/dist/sweetalert.css">

  <style type="text/css">
    .alerta {
      text-align: center;
      font-size: 1.2em;
      color: #fff;
      letter-spacing: -7px;
      font-weight: 700;
      text-transform: uppercase;
      animation: blur .75s ease-out infinite;
      text-shadow: 0px 0px 5px #fff,
        0px 0px 7px #fff;
    }

    @keyframes blur {
      from {
        text-shadow: 0px 0px 8px #fff,
          0px 0px 10px #f1f412,
          0px 0px 25px #f1f412,
          0px 0px 25px #f1f412,
          0px 0px 25px #f1f412,
          0px 0px 25px #f1f412,
          0px 0px 25px #f1f412,
          0px 0px 25px #f1f412,
          0px 0px 50px #f1f412,
          0px 0px 50px #f1f412,
          0px 0px 50px #7B96B8;
      }
    }

    .my-button {
      padding: 10px 20px;
      background-color: #E47A2E;
      color: #ffffff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .my-button:hover {
      background-color: #c15f19;
      color: #ffffff;
    }

    .my-button:active {
      background-color: #E47A2E;
      color: #ffffff;
    }
  </style>
  <script language="JavaScript">
    //<!--

    function infoEmpleado(texto) {
      Swal.fire({
        icon: 'info',
        title: "<i>Información Empleado Asignado</i>",
        html: texto,
        confirmButtonText: "Cerrar!",
      });
    }

    function infoSolicitud(texto) {
      Swal.fire({
        icon: 'info',
        title: "<i>Información de Solicitud</i>",
        html: texto,
        confirmButtonText: "Cerrar!",
      });
    }

    function infoImagen(imagen) {
      Swal.fire({
        title: "Sweet!",
        text: "Modal with a custom image.",
        imageUrl: imagen,
        imageWidth: 800,
        imageHeight: 600,
        imageAlt: "Custom image"
      });
    }

    function eliminar_solicitud(id) {
      Swal.fire({
          title: "Eliminar Solicitud e Items?",
          text: "¿Esta seguro de Eliminarla del Sistema?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Si, Eliminar!",
          closeOnConfirm: false
        },
        function() {
          swal("Eliminado!", "La Solicitud ha Sido Eliminada.", "success");
          location = 'https://<?= $server ?>/panel/muestrascomerciales-eliminar/' + id;
        });
    }
    //-->
  </script>

  <!-- Ajax -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">

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
              <a href="<?= $server ?>/panel/menu/4" title="Requerimientos">
                <font color="#34495e">
                  Muestras Comerciales >
                </font>
                <font color="#b4c056">
                  Lista de Muestras Comerciales
                </font>
              </a>
            </li>
          </ul>
        </div>

        <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
          <a href="<?= $server ?>/panel/menu/4" class="btn btn-primary btn-sm ml10" title="Requerimientos">
            REGRESAR &nbsp;
            <span class="fa fa-arrow-left"></span>
          </a>
          <a class="btn btn-primary btn-sm ml10" name="cotizacion2" href="<?= $server ?>/panel/muestrascomerciales/preagregar" title="Muestras Comerciales">
            <span class="fa fa-plus pr5"></span>
            <span class="fa fa-file pr5"></span>
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
                <table class="table allcp-form theme-warning br-t">
                  <thead>
                    <tr style="background-color:#2B547E; color: #ffffff">
                      <th>
                        Muestras Comerciales
                        &nbsp;&nbsp;&nbsp;&nbsp;
                      </th>
                    </tr>
                  </thead>
                </table>

                <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                  <thead>
                    <tr style="background-color: #F8F8F8; color:#000000">
                      <th style="text-align:center">
                        Consecutivo
                      </th>
                      <th style="text-align:center">
                        Fecha Solicitud
                      </th>
                      <th style="text-align:center">
                        Estado
                      </th>
                      <th style="text-align:center">
                        Fecha Estimada Entrega
                      </th>
                      <th style="text-align: center">
                        Cliente
                      </th>
                      <th style="text-align: center">
                        Motivo
                      </th>
                      <th style="text-align: center">
                        Ver Items
                      </th>
                      <th style="text-align:center">
                        Modificar
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php $ModalId = 0; ?>
                    @foreach($DatosMuestrasComerciales as $DataMC)
                    <tr class="message-unread">
                      <td style="text-align:center">
                        <font color="#2A2F43">
                          MC-<?= $DataMC->consecutivo; ?>
                        </font>
                      </td>
                      <?php $FechaSolicitud = explode(' ', $DataMC->fecha_solicitud); ?>
                      <td style="text-align:center">
                        <font color="#2A2F43">
                          <?= $FechaSolicitud[0]; ?>
                        </font>
                      </td>
                      <?php
                      $Estado = $DataMC->estado;
                      $EstadoDespachado = $DataMC->estado_despachado;

                      if ($EstadoDespachado != 0) {
                        if ($EstadoDespachado == 1) {
                          $titEstado = 'Despachado';
                          $backColor = '#087f5b';
                          $fontColor = '#ffffff';
                        } else {
                          $titEstado = 'Sin Despachar';
                          $backColor = '#f08c00';
                          $fontColor = '#ffffff';
                        }
                      } else {
                        switch ($Estado) {

                          case 0:
                            $titEstado = 'Pendiente';
                            $backColor = '';
                            $fontColor = '#2A2F43';
                            break;
                          case 1:
                            $titEstado = 'Aprobado';
                            $backColor = '';
                            $fontColor = '#2A2F43';
                            break;
                          case 2:
                            $titEstado = 'Rechazado';
                            $backColor = '';
                            $fontColor = '#2A2F43';
                            break;
                          case 3:
                            $titEstado = 'Cancelado';
                            $backColor = '';
                            $fontColor = '#2A2F43';
                            break;
                        }
                      }
                      ?>
                      <td style="text-align:center; background-color: <?= $backColor ?>">
                        <font color="<?= $fontColor ?>">
                          <?= $titEstado; ?>
                        </font>
                      </td>
                      <?php $FechaEstimada = explode(' ', $DataMC->fecha_estimada_entrega); ?>
                      <td style="text-align:center">
                        <font color="#2A2F43">
                          <?= $FechaEstimada[0]; ?>
                        </font>
                      </td>
                      <td style="text-align:center">
                        <font color="#2A2F43">
                          <?= $DataMC->nombre_cliente; ?>
                        </font>
                      </td>
                      <?php
                      $Motivo = $DataMC->motivo;

                      switch ($Motivo) {

                        case 1:
                          $titMotivo = 'Muestras Showroom';
                          break;
                        case 2:
                          $titMotivo = 'Obsequios';
                          break;
                        case 3:
                          $titMotivo = 'Eventos';
                          break;
                        case 4:
                          $titMotivo = 'Muestras Directas Cliente';
                          break;
                        case 5:
                          $titMotivo = 'Muestras Para Comercial';
                          break;
                        case 6:
                          $titMotivo = 'E-Commerce';
                          break;
                        case 7:
                          $titMotivo = 'Muestras Publicidad';
                          break;
                      }
                      ?>
                      <td style="text-align:center">
                        <font color="#2A2F43">
                          <?= $titMotivo; ?>
                        </font>
                      </td>
                      <td style="text-align: center">
                        <button type="button" class="btn btn-default light" onclick="window.location.href='<?= $server ?>/panel/muestrascomerciales-modificar/<?= $DataMC->id ?>'" title="Modificar Solicitud">
                          <i class="fa fa-file fa-lg" style="color:#AEBF25;"></i>
                        </button>
                      </td>
                      <td style="text-align: center">
                        <button type="button" class="btn btn-default light" onclick="window.location.href='<?= $server ?>/panel/muestrascomerciales-modificar/<?= $DataMC->id ?>'" title="Editar Solicitud">
                          <i class="fa fa-pencil fa-lg" style="color:#AEBF25;"></i>
                        </button>
                      </td>
                    </tr>
                    <?php $ModalId++; ?>
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
  <script src="<?= $server ?>/panelfiles/assets/js/pages/allcp_forms-elements.js"></script>
  <script src="<?= $server ?>/panelfiles/assets/js/demo/widgets_sidebar.js"></script>

  <!-- -------------- Page JS -------------- -->
  <script src="<?= $server ?>/panelfiles/assets/js/demo/charts/highcharts.js"></script>

  <!-- -------------- DataTables -------------- -->
  <!--  <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

  <!-- -------------- /Scripts -------------- -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


  <!-- -------------- DataTables -------------- -->
  <!-- -------------- /Scripts -------------- -->
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.0/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.dataTables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.print.min.js"></script>

  <script type="module">
    import {
      datatablesLanguage
    } from "<?= $server ?>/js/lang/datatables-lang.js";

    $('#message-table').DataTable({
      paging: false,
      "order": [
        [0, "asc"],
        [1, "asc"],
        [3, "asc"],
      ],
      "language": datatablesLanguage,
      layout: {
        topStart: {
          buttons: ['excel']
        }
      }
    });

    window.setInterval("reFresh()", 900000);

    function reFresh() {
      location.reload(true);
    }
  </script>

  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css">

</body>

</html>
@endforeach