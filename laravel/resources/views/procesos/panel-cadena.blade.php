<?php
$server ='/Berhlan/public';
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Cadena de valor
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

      <style type="text/css">
        [data-title]:hover:after
         {
          visibility: visible;
         }

        [data-title]:after
         {
          content:          attr(data-title);
          background-color: white;
          background:       -webkit-linear-gradient(left, #757e86, #abb2b9);
          color:            #FFFFFF;
          font-size:        125%;
          position:         absolute;
          visibility:       hidden;
          top:              3px;
          left:             550px;
          border:           #FFFFFF 6px solid;
          border-radius:    14px;
         }
      </style>

      <!-- -------------- Plugins -------------- -->
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

      <!-- -------------- Favicon -------------- -->
      <link rel="shortcut icon" href="<?=$server?>/panelfiles/assets/img/favicon.png">
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
                        Cadena de valor
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
          <!-- -------------- Column Center -------------- -->
          <div class="chute chute-center">
            <!-- Módulos -->
            <div class="row">
              <div class="col-md-1">
                &nbsp;&nbsp;
              </div>

              <div class="col-md-9 title" style="padding-top: 20px" nowrap>
                <img src="<?=$server?>/archivos/Cadena/cadena.jpg" alt="Berlan" usemap="#botones" style="border-color:black;" border="2">
                <map name="botones">
                  <?php
                  $ruta = $server."/panel/procesos/cadena/detalla/";
                  ?>

                  <area shape="rect" coords="32,68,111,88"  href="<?=$ruta?>1" data-title="&nbsp;Direccionamiento estratégico&nbsp;"       title="&nbsp;Direccionamiento estratégico&nbsp;">
                  <area shape="rect" coords="155,68,234,88" href="<?=$ruta?>2" data-title="&nbsp;Gestión del riesgo y continuidad&nbsp;"   title="&nbsp;Gestión del riesgo y continuidad&nbsp;">
                  <area shape="rect" coords="264,68,325,88" href="<?=$ruta?>3" data-title="&nbsp;Gestión de las capacidades&nbsp;"         title="&nbsp;Gestión de las capacidades&nbsp;">
                  <area shape="rect" coords="359,68,432,88" href="<?=$ruta?>4" data-title="&nbsp;Gestión de las comunicaciones&nbsp;"      title="&nbsp;Gestión de las comunicaciones&nbsp;">
                  <area shape="rect" coords="475,63,530,88" href="<?=$ruta?>5" data-title="&nbsp;Gestión del desarrollo responsable&nbsp;" title="&nbsp;Gestión del desarrollo responsable&nbsp;">
                  <area shape="rect" coords="582,68,632,88" href="<?=$ruta?>6" data-title="&nbsp;Control de gestión&nbsp;"                 title="&nbsp;Control de gestión&nbsp;">

                  <area shape="rect" coords="56,184,149,211" href="<?=$ruta?>7"  data-title="&nbsp;Conocimiento de mercados&nbsp;"                       title="&nbsp;Conocimiento de mercados&nbsp;">
                  <area shape="rect" coords="56,236,149,259" href="<?=$ruta?>8"  data-title="&nbsp;Proyección de demanda&nbsp;"                          title="&nbsp;Proyección de demanda&nbsp;">
                  <area shape="rect" coords="56,279,149,314" href="<?=$ruta?>9"  data-title="&nbsp;Gestión y posicionamiento de la marca&nbsp;"          title="&nbsp;Gestión y posicionamiento de la marca&nbsp;">
                  <area shape="rect" coords="56,327,149,365" href="<?=$ruta?>10" data-title="&nbsp;Gestión del portafolio de productos y servicio&nbsp;" title="&nbsp;Gestión del portafolio de productos y servicio&nbsp;">
                  <area shape="rect" coords="56,384,149,409" href="<?=$ruta?>11" data-title="&nbsp;Diseño de producto&nbsp;"                             title="&nbsp;Diseño de producto&nbsp;">

                  <area shape="rect" coords="239,180,317,200" href="<?=$ruta?>12" data-title="&nbsp;Planeación supply chain&nbsp;"                              title="&nbsp;Planeación supply chain&nbsp;">
                  <area shape="rect" coords="239,213,317,238" href="<?=$ruta?>13" data-title="&nbsp;Sourcing y negociación&nbsp;"                               title="&nbsp;Sourcing y negociación&nbsp;">
                  <area shape="rect" coords="239,257,317,285" href="<?=$ruta?>14" data-title="&nbsp;Compras y abastecimiento&nbsp;"                             title="&nbsp;Compras y abastecimiento&nbsp;">
                  <area shape="rect" coords="239,304,317,341" href="<?=$ruta?>15" data-title="&nbsp;Logística de entrada y de salida&nbsp;"                     title="&nbsp;Logística de entrada y de salida&nbsp;">
                  <area shape="rect" coords="239,353,317,378" href="<?=$ruta?>16" data-title="&nbsp;Gestión de inventarios&nbsp;"                               title="&nbsp;Gestión de inventarios&nbsp;">
                  <area shape="rect" coords="239,390,317,419" href="<?=$ruta?>17" data-title="&nbsp;Administración infraestructura de transporte&nbsp;"         title="&nbsp;Administración infraestructura de transporte&nbsp;">
                  <area shape="rect" coords="358,177,445,198" href="<?=$ruta?>18" data-title="&nbsp;Planeación de la producción&nbsp;"                          title="&nbsp;Planeación de la producción&nbsp;">
                  <area shape="rect" coords="358,213,445,235" href="<?=$ruta?>19" data-title="&nbsp;Gestión de la producción&nbsp;"                             title="&nbsp;Gestión de la producción&nbsp;">
                  <area shape="rect" coords="358,251,445,272" href="<?=$ruta?>20" data-title="&nbsp;Aseguramiento de la calidad&nbsp;"                          title="&nbsp;Aseguramiento de la calidad&nbsp;">
                  <area shape="rect" coords="358,286,445,308" href="<?=$ruta?>21" data-title="&nbsp;Gestión ambiental&nbsp;"                                    title="&nbsp;Gestión ambiental&nbsp;">
                  <area shape="rect" coords="358,321,445,332" href="<?=$ruta?>22" data-title="&nbsp;I + D + I&nbsp;"                                            title="&nbsp;I + D + I&nbsp;">
                  <area shape="rect" coords="358,353,445,375" href="<?=$ruta?>23" data-title="&nbsp;Gestión técnica e ingeniería&nbsp;"                         title="&nbsp;Gestión técnica e ingeniería&nbsp;">
                  <area shape="rect" coords="358,390,445,419" href="<?=$ruta?>24" data-title="&nbsp;Administración infraestructura industrial y locativa&nbsp;" title="&nbsp;Administración infraestructura industrial y locativa&nbsp;">

                  <area shape="rect" coords="530,177,604,211" href="<?=$ruta?>25" data-title="&nbsp;Planeación presupuesto y ventas&nbsp;"           title="&nbsp;Planeación presupuesto y ventas&nbsp;">
                  <area shape="rect" coords="530,223,604,246" href="<?=$ruta?>26" data-title="&nbsp;Diseño y gestión de la utilidad&nbsp;"           title="&nbsp;Diseño y gestión de la utilidad&nbsp;">
                  <area shape="rect" coords="530,260,604,292" href="<?=$ruta?>27" data-title="&nbsp;Gestión de modelos colaborativos&nbsp;"          title="&nbsp;Gestión de modelos colaborativos&nbsp;">
                  <area shape="rect" coords="530,302,604,333" href="<?=$ruta?>28" data-title="&nbsp;Planeación capacidades comerciales&nbsp;"        title="&nbsp;Planeación capacidades comerciales&nbsp;">
                  <area shape="rect" coords="530,343,604,376" href="<?=$ruta?>29" data-title="&nbsp;Comercialización clientes nacionales&nbsp;"      title="&nbsp;Comercialización clientes nacionales&nbsp;">
                  <area shape="rect" coords="530,385,604,419" href="<?=$ruta?>30" data-title="&nbsp;Comercialización clientes internacionales&nbsp;" title="&nbsp;Comercialización clientes internacionales&nbsp;">

                  <area shape="rect" coords="55,493,107,527"  href="<?=$ruta?>31" data-title="&nbsp;Gestión de personas&nbsp;"                 title="&nbsp;Gestión de personas&nbsp;">
                  <area shape="rect" coords="177,493,240,527" href="<?=$ruta?>32" data-title="&nbsp;Gestión de TIC&nbsp;"                      title="&nbsp;Gestión de TIC&nbsp;">
                  <area shape="rect" coords="307,493,379,527" href="<?=$ruta?>33" data-title="&nbsp;Gestión financiera y administrativa&nbsp;" title="&nbsp;Gestión financiera y administrativa&nbsp;">
                  <area shape="rect" coords="429,493,510,527" href="<?=$ruta?>34" data-title="&nbsp;Servicio al cliente&nbsp;"                 title="&nbsp;Servicio al cliente&nbsp;">
                  <area shape="rect" coords="571,493,653,527" href="<?=$ruta?>35" data-title="&nbsp;Sistema integrado de gestión&nbsp;"        title="&nbsp;Sistema integrado de gestión&nbsp;">
                </map>

                <br><br>
                <a href="<?=$server?>/panel/procesos/cadena/consulta" title="Consulta">
                  <img src="<?=$server?>/panelfiles/iconos/prconsultaprocesost.png" class="img-responsive mauto" alt="Consulta" style="width:80px;">
                </a>
              </div>
            </div>
          </div>
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
      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach