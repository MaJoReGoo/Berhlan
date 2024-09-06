<?php
$server = '/Berhlan/public';

use App\Models\Bpack\PanelMuestras;
?>

@foreach($DatosUsuario as $DatLog)
<!DOCTYPE html>
<html>

<head>
  <!-- -------------- Meta and Title -------------- -->
  <meta charset="utf-8">
  <title>
    Intranet | Bcloud | Solicitudes pendientes de
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

  <!-- Editor -->
  <script type="text/javascript" src="<?= $server ?>/panelfiles/ckeditor/ckeditor.js"></script>
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
              <a href="<?= $server ?>/panel/menu/3" title="Bcloud">
                <font color="#34495e">
                  Bcloud >
                </font>
                <font color="#b4c056">
                  Solicitudes pendientes de
                </font>
              </a>
            </li>
          </ul>
        </div>

        <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
          <a href="<?= $server ?>/panel/menu/3" class="btn btn-primary btn-sm ml10" title="Bcloud">
            REGRESAR &nbsp;
            <span class="fa fa-arrow-left"></span>
          </a>
        </div>
      </header>
      <!-- -------------- /Topbar -------------- -->

      <!-- -------------- Content -------------- -->
      <br>

      <?php
      $ruta          = 0;
      $aprobasol     = 0;
      $prueba        = 0;
      $correccionpre = 0;
      $correccion    = 0;
      $aprobasherpa  = 0;
      $aprobaprueba  = 0;
      $total         = 0;
      $cantsolmf     = PanelMuestras::SolTMuestrasAbiertas();
      ?>
      @foreach($CanSolicitudes as $DatSol)
      <?php
      $estadosol = $DatSol->estado;

      if ($estadosol == 1)
        $ruta = $DatSol->cantidad;
      else if ($estadosol == 2)
        $aprobasol = $aprobasol + $DatSol->cantidad;
      else if ($estadosol == 3 || $estadosol == 10)
        $correccion = $DatSol->cantidad;
      else if ($estadosol == 4)
        $aprobasherpa = $DatSol->cantidad;
      else if ($estadosol == 5)
        $aprobasol = $aprobasol + $DatSol->cantidad;
      else if ($estadosol == 6)
        $prueba = $prueba + $DatSol->cantidad;
      else if ($estadosol == 7)
        $aprobaprueba = $DatSol->cantidad;
      /* else if ($estadosol == 10)
        $correccionpre = $DatSol->cantidad; */
      else if ($estadosol == 11)
        $prueba = $prueba + $DatSol->cantidad;

      $total = $total + $DatSol->cantidad;
      ?>
      @endforeach


      <div class="row">

        <!-- 1 -->
        <div class="col-sm-3 col-xl-4">
          <a href="<?= $server ?>/panel/bpack/penruta" title="Pendientes de ruta">
            <div class="col-xs-12 ph10 text-center  panel panel-body">
              <i class="fa fa-exclamation fa-3x" style="color:#FEDA00; text-shadow: 1px -1px 1px #000;"> <?= $ruta ?></i>
              <h6 class="text-muted" style="padding-top: 20px">
                <font color="#2a2f43">
                  Ruta
                </font>
              </h6>
              (Planeación)
            </div>
          </a>
        </div>
        <!-- 2 -->
        <div class="col-sm-3 col-xl-4">
          <a href="<?= $server ?>/panel/bpack/penaprueba" title="Pendientes de aprobación solicitud">
            <div class="col-xs-12 ph10 text-center  panel panel-body">
              <i class="fa fa-exclamation-circle fa-3x" style="color:#6CBCED; text-shadow: 1px -1px 1px #000;"> <?= $aprobasol ?></i>
              <h6 class="text-muted" style="padding-top: 20px">
                <font color="#2a2f43">
                  Aprobación solicitud
                </font>
              </h6>
              (Preprensa)
            </div>
          </a>
        </div>
        <!-- 3 -->
        <div class="col-sm-3 col-xl-4">
          <a href="<?= $server ?>/panel/bpack/pensherpa" title="Pendientes de aprobación sherpas digitales (pdf)">
            <div class="col-xs-12 ph10 text-center  panel panel-body">
              <i class="fa fa-exclamation-triangle fa-3x" style="color:#A8CB2A; text-shadow: 1px -1px 1px #000;"> <?= $aprobasherpa ?></i>
              <h6 class="text-muted" style="padding-top: 20px">
                <font color="#2a2f43">
                  Aprobación sherpas digitales (pdf)
                </font>
              </h6>
              (Publicidad)
            </div>
          </a>
        </div>
      </div>

      <div class="row">
        <!-- 4 -->
        <div class="col-sm-3 col-xl-4">
          <a href="<?= $server ?>/panel/bpack/pencontrato" title="Pendientes de prueba contrato física">
            <div class="col-xs-12 ph10 text-center  panel panel-body">
              <i class="fa fa-exclamation-circle fa-3x" style="color:#6CBCED; text-shadow: 1px -1px 1px #000;"> <?= $prueba ?></i>
              <h6 class="text-muted" style="padding-top: 20px">
                <font color="#2a2f43">
                  Prueba de contrato física
                </font>
              </h6>
              (Preprensa)
            </div>
          </a>
        </div>

        <!-- 5 -->
        <div class="col-sm-3 col-xl-4">
          <a href="<?= $server ?>/panel/bpack/penaprcontrato" title="Pendientes de aprobación prueba contrato física">
            <div class="col-xs-12 ph10 text-center  panel panel-body">
              <i class="fa fa-exclamation-triangle fa-3x" style="color:#A8CB2A; text-shadow: 1px -1px 1px #000;"> <?= $aprobaprueba ?></i>
              <h6 class="text-muted" style="padding-top: 20px">
                <font color="#2a2f43">
                  Aprobación prueba de contrato física
                </font>
              </h6>
              (Publicidad)
            </div>
          </a>
        </div>

        <!-- 6 -->
        <div class="col-sm-3 col-xl-4">
          <a href="<?= $server ?>/panel/bpack/correcaprueba/0" title="Pendientes de corrección solicitud por rechazo en ruta">
            <div class="col-xs-12 ph10 text-center  panel panel-body">
              <i class="fa fa-exclamation-triangle fa-3x" style="color:#A8CB2A; text-shadow: 1px -1px 1px #000;"> <?= $correccion ?></i>
              <h6 class="text-muted" style="padding-top: 20px">
                <font color="#2a2f43">
                  Correcciones
                </font>
              </h6>
              (Publicidad)
            </div>
          </a>
        </div>
        <!-- div class="col-sm-3 col-xl-4">
          <a href="< ?= $server ?>/panel/bpack/correcaprueba" title="Pendientes de corrección solicitud">
            <div class="col-xs-12 ph10 text-center  panel panel-body">
              <i class="fa fa-exclamation-triangle fa-3x" style="color:#A8CB2A; text-shadow: 1px -1px 1px #000;"> < ?= $correccion ?></i>
              <h6 class="text-muted" style="padding-top: 20px">
                <font color="#2a2f43">
                  Corrección de solicitud
                </font>
              </h6>
              (Publicidad)
            </div>
          </a>
        </div -->
      </div>

      <div class="row">
        <!-- 7 -->
        <div class="col-sm-3 col-xl-4">
          <a href="<?= $server ?>/panel/bpack/muestras/pendientes/0" title="Pendientes de impresión muestras físicas">
            <div class="col-xs-12 ph10 text-center  panel panel-body">
              <i class="fa fa-exclamation-circle fa-3x" style="color:#6CBCED; text-shadow: 1px -1px 1px #000;"> <?= $cantsolmf ?></i>
              <h6 class="text-muted" style="padding-top: 20px">
                <font color="#2a2f43">
                  Impresión de muestras físicas
                </font>
              </h6>
              (Preprensa)
            </div>
          </a>
        </div>

        <!-- 8 -->
        <div class="col-sm-3 col-xl-4">
          <div class="col-xs-12 ph10 text-center  panel panel-body">
            <i class="fa fa-info-circle fa-3x" style="color:#23469D; text-shadow: 1px -1px 1px #000;"> <?= ($total + $cantsolmf) ?></i>
            <h6 class="text-muted" style="padding-top: 20px">
              <font color="#2a2f43">
                TOTAL DE SOLICITUDES ABIERTAS
              </font>
            </h6>
            <br>
          </div>
        </div>

      </div>
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

  <!-- -------------- /Scripts -------------- -->
</body>

</html>
@endforeach
