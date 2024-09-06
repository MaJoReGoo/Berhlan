<?php
$server = '/Berhlan/public';
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Procesos disciplinarios | Reporte de gestión
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
                  <a href="<?=$server?>/panel/menu/45" title="Procesos disciplinarios">
                    <font color="#34495e">
                      Procesos disciplinarios >
                    </font>
                    <font color="#b4c056">
                      Reporte de gestión
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/menu/45" class="btn btn-primary btn-sm ml10" title="Procesos disciplinarios">
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
                        <tr>
                          <th style="background-color:#67d3e0; color:#34495e; text-align:left;">
                            Reporte de gestión
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>
                            <div class="allcp-form">
                              {!! Form::open(array('action' => 'Disciplinarios\ConsultasDisciplinariosPanelController@ReportegDetalle', 'class' => 'form', 'id'=>'form-wizard')) !!}
                                <div class="row">
                                  <div class="col-md-2">
                                    <label style="color:#34495e;">
                                      <b>
                                        Fecha desde
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::date('desde', null, array('', 'id'=>'desde', 'class'=>'gui-input', 'maxlength'=>'10')) !!}
                                    </label>
                                  </div>

                                  <div class="col-md-2">
                                    <label style="color:#34495e;">
                                      <b>
                                        Fecha hasta
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::date('hasta', null, array('', 'id'=>'hasta', 'class'=>'gui-input', 'maxlength'=>'10')) !!}
                                    </label>
                                  </div>

                                  <div class="col-md-6">
                                    <label style="color:#34495e;">
                                      <b>
                                        Estado
                                      </b>
                                    </label>
                                    <br>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">

                                      <label class="btn btn-secondary btn-lg active" onclick="COLOR('P')">
                                        <input type="radio" name="estado" value="1" autocomplete="off" checked>
                                        <i class="fa fa-unlock-alt fa-lg" style="color:#67d3e0;"></i>
                                        <label style="color:green; font-weight: bold; cursor:pointer;" id="LBP">
                                          &nbsp;&nbsp;
                                          En proceso
                                        </label>
                                      </label>

                                      <label class="btn btn-secondary" onclick="COLOR('A')">
                                        <input type="radio" name="estado" value="0" autocomplete="off">
                                        <i class="fa fa-lock fa-lg" style="color:#67d3e0;"></i>
                                        <label style="color:#34495e; cursor:pointer;" id="LBA">
                                          &nbsp;&nbsp;
                                          Atendidos
                                        </label>
                                      </label>
                                    </div>
                                  </div>
                                </div>

                                <div class="row">
                                  <br>
                                  <div class="col-md-6">
                                    {!! Form::submit('Consultar', array('class'=>'button')) !!}
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
              <script language="javascript" type="text/javascript">
              function COLOR(id)
               {
                icono1 = document.getElementById('LBA');
                icono2 = document.getElementById('LBP');

                if(id == "A")
                 {
                  icono1.style.color      = 'green';
                  icono1.style.fontWeight = 'bold';
                  icono2.style.color      = '#34495e';
                  icono2.style.fontWeight = '';
                 }
                else if(id == "P")
                 {
                  icono1.style.color      = '#34495e';
                  icono1.style.fontWeight = '';
                  icono2.style.color      = 'green';
                  icono2.style.fontWeight = 'bold';
                 }
               }
              </script>
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