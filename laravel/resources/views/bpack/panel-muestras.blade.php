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
        Intranet | Bcloud | Solicitud muestras físicas
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
                  <a href="<?=$server?>/panel/menu/3" title="Bcloud">
                    <font color="#34495e">
                      Bcloud >
                    </font>
                    <font color="#b4c056">
                      Solicitud muestras físicas
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/menu/3" class="btn btn-primary btn-sm ml10" title="Bcloud">
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
                            Nueva solicitud
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>
                            <div class="allcp-form">
                              {!! Form::open(array('action' => 'Bpack\MuestrasPanelController@MuestrasAgregarDB', 'class' => 'form', 'id'=>'form-wizard', 'files' => true, 'name' => 'frmenvio')) !!}
                                <div class="row">
                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Descripción
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('descripcion', null, array('required', 'id'=>'descripcion', 'class'=>'gui-input', 'placeholder'=>'* Descripción')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-reorder"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Tamaño
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('tamano', null, array('required', 'id'=>'tamano', 'class'=>'gui-input', 'placeholder'=>'* Tamaño')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-reorder"></i>
                                      </label>
                                    </label>
                                  </div>
                                </div>

                                <br>

                                <div class="row">
                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Cantidad
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::number('cantidad', null, array('required', 'id'=>'cantidad', 'class'=>'gui-input', 'placeholder'=>'* Cantidad')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-sort-numeric-asc"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Archivo
                                      </b>
                                    </label>
                                    <label class="field prepend-icon append-button file">
                                      <span class="button">
                                        Archivo
                                      </span>
                                      {!! Form::file('file1', array('', 'id'=>'file1', 'class'=>'gui-file', 'accept'=>'.ai, .jpg, .jpeg, .gif, .png, .pdf, .psd, .rar, .zip',
                                          'onChange'=>"document.getElementById('uploader1').value = this.value;")) !!}
                                      {!! Form::text('uploader1', null, array('id'=>'uploader1', 'class'=>'gui-input', 'placeholder'=>'* Seleccione el archivo')) !!}
                                      <label class="field-icon">
                                        <i class="fa fa-cloud-upload"></i>
                                      </label>
                                    </label>
                                  </div>
                                </div>

                                <br>

                                <div class="row">
                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Observaciones
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::textarea('observaciones', '', array('', 'id'=>'observaciones', 'class'=>'gui-input', 'style'=>'height: 80px; resize: vertical;', 'placeholder'=>'Observaciones.')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-reorder"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-6">
                                    <br><br>
                                    {!! Form::submit('Realizar solicitud', array('class'=>'button')) !!}
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