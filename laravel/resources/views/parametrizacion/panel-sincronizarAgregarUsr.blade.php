<?php
$server = '/Berhlan/public';

use App\Models\Parametrizacion\PanelEmpleados;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Sincronizar usuarios Siesa | Agregar usuario
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
                  <a href="<?=$server?>/panel/parametrizacion/usuarios" title="Parametrización > Usuarios">
                    <font color="#34495e">
                      Parametrización > Sincronizar usuarios Siesa > Usuario >
                    </font>
                    <font color="#b4c056">
                      Agregar
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/parametrizacion/usuarios" class="btn btn-primary btn-sm ml10" title="Parametrización > Usuarios">
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
              <div class="panel m4">
                <!-- -------------- Message Body -------------- -->
                <div class="nano-content">
                  <div class="table-responsive">
                    <table id="message-table" class="table allcp-form theme-warning br-t">
                      <thead>
                        <tr style="background-color:#39405a">
                          <th>
                            Complete el formulario si desea que el empleado tenga acceso a la Intranet
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>
                            <div class="allcp-form">
                              {!! Form::open(array('action' => 'Parametrizacion\SincronizarPanelController@UsuariosNvAgregarDB', 'class' => 'form', 'id'=>'form-wizard')) !!}
                                {!! Form::hidden('empleado', $DatosEmpleado[0]->id_empleado) !!}
                                {!! Form::hidden('identempleado', $DatosEmpleado[0]->identificacion) !!}
                                <div class="section">
                                  <div class="col-md-4">
                                    <label style="color: #4ECCDB">
                                      Empleado
                                    </label>
                                    <label class="field select">
                                      <br>
                                      <?php
                                      echo $DatosEmpleado[0]->identificacion;
                                      echo " - ";
                                      echo $DatosEmpleado[0]->primer_nombre;
                                      echo " ";
                                      echo $DatosEmpleado[0]->ot_nombre;
                                      echo " ";
                                      echo $DatosEmpleado[0]->primer_apellido;
                                      echo " ";
                                      echo $DatosEmpleado[0]->ot_apellido;
                                      ?>
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <label style="color: #4ECCDB">
                                      Login
                                    </label>
                                    <label class="field prepend-icon">
                                      <?php
                                      $logpro = $DatosEmpleado[0]->primer_nombre.".".$DatosEmpleado[0]->primer_apellido;
                                      ?>
                                      {!! Form::text('login', $logpro, array('required', 'id'=>'login', 'class'=>'gui-input', 'placeholder'=>'* primer_nombre.primer_apellido')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-file"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <label style="color: #4ECCDB">
                                      Tipo Master
                                    </label>

                                    <label class="option block">
                                      <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary" onclick="COLOR('1')">
                                          <i class="fa fa-check fa-lg" id="MASTER1" style="color:grey;"> &nbsp;Sí</i>
                                          <input type="radio" name="master" value="1" autocomplete="off">
                                        </label>

                                        <label class="btn btn-secondary btn-lg active" onclick="COLOR('0')">
                                          <i class="fa fa-times fa-lg" id="MASTER0" style="color:red;"> &nbsp;No</i>
                                          <input type="radio" name="master" value="0" autocomplete="off" checked>
                                        </label>
                                      </div>
                                    </label>
                                  </div>
                                </div>

                                <div class="section">
                                  <div class="col-md-4">
                                    <br>
                                    {!! Form::submit('Crear usuario', array('class'=>'button')) !!}
                                  </div>

                                  <div class="col-md-8" style="text-align: right;">
                                    <br><br>
                                    <label style="color:#2A2F43">
                                      (La contraseña inicial, será el número de identificación.)
                                    </label>
                                  </div>
                                </div>
                              {!! Form::close() !!}
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>

                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='<?=$server?>/panel/parametrizacion/sincronizar/'">
                      <i class="fa fa-reply fa-lg" style="color:#AEBF25;"></i>
                      <i class="fa fa-users fa-lg" style="color:#AEBF25;"></i>
                      &nbsp;&nbsp;
                      <font color="black">
                        Regresar a sincronizar usuarios Siesa
                      </font>
                    </button>
                    <br><br>
                  </div>
                </div>
              </div>

              <script language="javascript" type="text/javascript">
              function COLOR(id1)
               {
                icono0 = document.getElementById('MASTER0');
                icono1 = document.getElementById('MASTER1');

                if(id1 == "1")
                 {
                  icono1.style.color = 'green';
                  icono0.style.color = 'grey';
                 }
                else
                 {
                  icono1.style.color = 'grey';
                  icono0.style.color = 'red';
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