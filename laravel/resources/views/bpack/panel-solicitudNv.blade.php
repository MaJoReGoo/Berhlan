<?php

?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Bcloud | Solicitud actualizaciones y nuevos desarrollos
      </title>
      <meta name="keywords" content="panel, cms, usuarios, servicio"/>
      <meta name="description" content="Intranet para grupo Berhlan">
      <meta name="author" content="USUARIO" >
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!-- -------------- Fonts -------------- -->
      <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
      <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

      <!-- -------------- CSS - theme -------------- -->
      <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/skin/default_skin/css/theme.css')}}">

      <!-- -------------- CSS - allcp forms -------------- -->
      <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.css')}}">

      <!-- -------------- Plugins -------------- -->
      <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css')}}">

      <!-- -------------- Favicon -------------- -->
      <link rel="shortcut icon" href="{{ asset ('/panelfiles/assets/img/favicon.ico')}}">

      <!-- Editor -->
      <script type="text/javascript" src="{{ asset ('/panelfiles/ckeditor/ckeditor.js')}}"></script>
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
                  <a href="{{ asset ('/panel/bpack/solicitudan')}}" title="Bcloud > Solicitud actualizaciones y nuevos desarrollos">
                    <font color="#34495e">
                      Bcloud > Solicitud actualizaciones y nuevos desarrollos >
                    </font>
                    <font color="#b4c056">
                      Nuevos desarrollos
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="{{ asset ('/panel/bpack/solicitudan')}}" class="btn btn-primary btn-sm ml10" title="Bcloud > Solicitud actualizaciones y nuevos desarrollos">
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
                            Solicitud nuevos desarrollos
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>
                            <div class="allcp-form">
                              {!! Form::open(array('action' => 'Bpack\SolicitudANPanelController@SolicitudANFormDB', 'class' => 'form', 'id'=>'form-wizard', 'files' => true, 'name' => 'frmenvio', 'onsubmit' => 'return VALIDAR()')) !!}
                                {!! Form::hidden('tipo', 'N') !!}
                                <div class="row">
                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Cliente
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('cliente', null, array('required', 'id'=>'cliente', 'class'=>'gui-input', 'placeholder'=>'* Cliente')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-user"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Artes
                                      </b>
                                    </label>
                                    <label class="field prepend-icon append-button file">
                                      <span class="button">
                                        Artes
                                      </span>
                                      {!! Form::file('file1',
                                          array('required', 'id'=>'file1',
                                          'class'=>'gui-file', 'accept'=>'.ai, .jpg, .jpeg, .gif, .png, .pdf, .psd, .rar, .zip',
                                          'onChange'=>"document.getElementById('uploader1').value = this.value;")) !!}
                                      {!! Form::text('uploader1', null,
                                          array('id'=>'uploader1',
                                          'class'=>'gui-input',
                                          'placeholder'=>'* Seleccione el archivo')) !!}
                                      <label class="field-icon">
                                        <i class="fa fa-cloud-upload"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Formato (proyecciones)
                                      </b>
                                    </label>
                                    <label class="field prepend-icon append-button file">
                                      <span class="button">
                                        Formato
                                      </span>
                                      {!! Form::file('file2',
                                          array('', 'id'=>'file2',
                                          'class'=>'gui-file', 'accept'=>'.ai, .jpg, .jpeg, .gif, .png, .pdf, .psd, .rar, .zip',
                                          'onChange'=>"document.getElementById('uploader2').value = this.value;")) !!}
                                      {!! Form::text('uploader2', null,
                                          array('id'=>'uploader2',
                                          'class'=>'gui-input',
                                          'placeholder'=>'Seleccione el archivo')) !!}
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
                                        Referencia
                                      </b>
                                    </label>
                                  </div>
                                  <div class="col-md-2">
                                    <label style="color: #34495e">
                                      <b>
                                        Versión
                                      </b>
                                    </label>
                                  </div>
                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Referencia
                                      </b>
                                    </label>
                                  </div>
                                  <div class="col-md-2">
                                    <label style="color: #34495e">
                                      <b>
                                        Versión
                                      </b>
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <?php
                                  for($a=1;$a<11;$a++)
                                   {
                                    ?>
                                     <div class="col-md-4">
                                       <label class="field prepend-icon">
                                         {!! Form::text('referencia[]', null, array('id'=>'referencia_'.$a, 'class'=>'gui-input', 'placeholder'=>'Referencia')) !!}
                                         <label for="username" class="field-icon">
                                           <i class="fa fa-navicon"></i>
                                         </label>
                                       </label>
                                     </div>

                                    <div class="col-md-2">
                                      <label class="field select">
                                        <select name="version_<?=$a?>" id="version_<?=$a?>">
                                          <option value="">
                                            Versión
                                          </option>
                                          <?php
                                          for($u = 1; $u < 51; $u++)
                                           {
                                            echo "<option value=\"$u\">";
                                              echo $u;
                                            echo "</option>";
                                           }
                                          ?>
                                        </select>
                                        <i class="arrow"></i>
                                      </label>
                                    </div>
                                    <?php
                                    if($a == 2 || $a == 4 || $a == 6|| $a == 8)
                                     {
                                      echo "</div>";
                                      echo "<br>";
                                      echo "<div class=\"row\">";
                                     }
                                   }
                                  ?>
                                </div>

                                <div class="row">
                                  <div class="col-md-6">
                                    <br>
                                    <label style="color: #34495e">
                                      <b>
                                        Observaciones
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::textarea('observaciones', '', array('', 'id'=>'observaciones', 'class'=>'gui-input', 'style'=>'height: 60px; resize: vertical;', 'placeholder'=>'Observaciones.')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-reorder"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-6">
                                    <br><br><br>
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

              <script language="javascript" type="text/javascript">
              function VALIDAR()
               {
                frm = document.forms["frmenvio"];
                e = 0;
                for(a=1;a<11;a++)
                 {
                  cad1 = eval(frm.name+".referencia_"+a+"");
                  if(cad1.value != "")
                   {
                    version = eval(frm.name+".version_"+a+"");
                    if(version.value == "")
                     {
                      alert("Debe seleccionar la versión para la referencia "+cad1.value);
                      version.focus();
                      return false;
                     }
                    e++;
                   }
                 }

                if(e == 0)
                 {
                  alert("Debe ingresar al menos 1 referencia");
                  frm.referencia_1.focus();
                  return false;
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
      <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js')}}"></script>
      <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js')}}"></script>

      <!-- -------------- JvectorMap Plugin -------------- -->
      <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js')}}"></script>
      <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js')}}"></script>

      <!-- -------------- HighCharts Plugin -------------- -->
      <script src="{{ asset ('/panelfiles/assets/js/plugins/highcharts/highcharts.js"></script>
      <script src="{{ asset ('/panelfiles/assets/js/plugins/c3charts/d3.min.js"></script>
      <script src="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.js"></script>

      <!-- -------------- Theme Scripts -------------- -->
      <script src="{{ asset ('/panelfiles/assets/js/utility/utility.js')}}"></script>
      <script src="{{ asset ('/panelfiles/assets/js/demo/demo.js')}}"></script>
      <script src="{{ asset ('/panelfiles/assets/js/main.js')}}"></script>
      <script src="{{ asset ('/panelfiles/assets/js/pages/allcp_forms-elements.js')}}"></script>
      <script src="{{ asset ('/panelfiles/assets/js/demo/widgets_sidebar.js')}}"></script>

      <!-- -------------- Page JS -------------- -->
      <script src="{{ asset ('/panelfiles/assets/js/demo/charts/highcharts.js')}}"></script>

      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach
