<?php
$server ='/Berhlan/public';

use App\Models\TicActivos\PanelTpOffice;
?>

@foreach($DatosUsuario as $DatLog)
  @foreach($DatosLicencia as $DatLic)
    <!DOCTYPE html>
    <html>
      <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
          Intranet | Activos TIC | Licencias de office
        </title>

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
                    <a href="<?=$server?>/panel/ticactivos/licencias" title="Activos TIC > Licencias de office">
                      <font color="#34495e">
                        Activos TIC > Licencias de office >
                      </font>
                      <font color="#b4c056">
                        Modificar
                      </font>
                    </a>
                  </li>
                </ul>
              </div>

              <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                <a href="<?=$server?>/panel/ticactivos/licencias" class="btn btn-primary btn-sm ml10" title="Activos TIC > Licencias de office">
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
                              Actualice los datos de la licencia de office
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr>
                            <td>
                              <div class="allcp-form">
                                {!! Form::open(array('action' => 'TicActivos\LicenciasTicActivosPanelController@LicenciasModificarDB', 'class' => 'form', 'id'=>'form-wizard')) !!}
                                  {!! Form::hidden('id_licencia', $DatLic->id_licencia) !!}
                                  <div class="row">
                                    <div class="col-md-4">
                                      <label style="color: #34495e">
                                        <b>
                                          Tipo de office
                                        </b>
                                      </label>
                                      <label class="field select">
                                        <select name="tipo" id="tipo">
                                          <?php
                                          $Tip = PanelTpOffice::getTpOffice($DatLic->tipo);
                                          echo "<option value=\"$DatLic->tipo\">";
                                            echo $Tip[0]->descripcion;
                                          echo "</option>";

                                          $Tipos = PanelTpOffice::getTpOfficeActivos();
                                          ?>

                                          @foreach($Tipos as $DatTip)
                                            <?php
                                            echo "<option value=\"$DatTip->id_tipo\">";
                                              echo $DatTip->descripcion;
                                            echo "</option>";
                                            ?>
                                          @endforeach
                                        </select>
                                        <i class="arrow"></i>
                                      </label>
                                    </div>

                                    <div class="col-md-4">
                                      <label style="color: #34495e">
                                        <b>
                                          Licencia
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::text('licencia', $DatLic->descripcion, array('required', 'id'=>'licencia', 'class'=>'gui-input', 'placeholder'=>'* Licencia')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-tag"></i>
                                        </label>
                                      </label>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <br>
                                    <div class="col-md-4">
                                      <label style="color: #34495e">
                                        <b>
                                          Código interno
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::text('codigo', $DatLic->codigoint, array('required', 'id'=>'codigo', 'class'=>'gui-input', 'placeholder'=>'* Código interno')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-tag"></i>
                                        </label>
                                      </label>
                                    </div>

                                    <div class="col-md-4">
                                      <label style="color: #34495e">
                                        <b>
                                          Medio
                                        </b>
                                      </label>
                                      <?php
                                      if($DatLic->medio == 'F') //Si es físico
                                       {
                                        $clas1  = "active";
                                        $clas2  = "";
                                        $inpu1  = "checked";
                                        $inpu2  = "";
                                        $color1 = "green";
                                        $color2 = "grey";
                                       }
                                      else  //Si es virtual
                                       {
                                        $clas1  = "";
                                        $clas2  = "active";
                                        $inpu1  = "";
                                        $inpu2  = "checked";
                                        $color1 = "grey";
                                        $color2 = "green";
                                       }
                                      ?>
                                      <label class="option block">
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                          <label class="btn btn-secondary <?=$clas1?>" onclick="COLOR('F')">
                                            <i class="fa fa-archive fa-1x" id="mediof" style="color:<?=$color1?>;"> Físico</i>
                                            <input type="radio" name="medio" value="F" autocomplete="off" <?=$inpu1?>>
                                          </label>
                                          <label class="btn btn-secondary <?=$clas2?>" onclick="COLOR('V')">
                                            <i class="fa fa-at fa-1x" id="mediov" style="color:<?=$color2?>;"> Virtual</i>
                                            <input type="radio" name="medio" value="V" autocomplete="off" <?=$inpu2?>>
                                          </label>
                                        </div>
                                      </label>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <br>
                                    <div class="col-md-4">
                                      <label style="color: #34495e">
                                        <b>
                                          Usuario
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::text('usuario', $DatLic->usuario, array('', 'id'=>'usuario', 'class'=>'gui-input', 'placeholder'=>'Usuario')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-user"></i>
                                        </label>
                                      </label>
                                    </div>

                                    <div class="col-md-4">
                                      <label style="color: #34495e">
                                        <b>
                                          Contraseña
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::text('password', $DatLic->clave, array('', 'id'=>'password', 'class'=>'gui-input', 'placeholder'=>'Contraseña')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-key"></i>
                                        </label>
                                      </label>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <br>
                                    <div class="col-md-4">
                                      <label style="color: #34495e">
                                        <b>
                                          Estado
                                        </b>
                                      </label>
                                      <label class="field select">
                                        <select name="estado" id="estado" required>
                                          <option value="1" style="color:green;"
                                          <?php
                                          if($DatLic->estado == 1)
                                            echo " selected ";
                                          ?>
                                          >Activa</option>

                                          <option value="0" style="color:red;"
                                          <?php
                                          if($DatLic->estado == 0)
                                            echo " selected ";
                                          ?>
                                          >Inactiva</option>
                                        </select>
                                        <i class="arrow"></i>
                                      </label>
                                    </div>

                                    <div class="col-md-4">
                                      <br><br>
                                      {!! Form::submit('Modificar licencia', array('class'=>'button')) !!}
                                      <br><br>
                                    </div>
                                  </div>
                                {!! Form::close() !!}
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>

                      <script language="javascript" type="text/javascript">
                      function COLOR(id1)
                       {
                        icono1 = document.getElementById('mediof');
                        icono2 = document.getElementById('mediov');

                        if(id1 == "F")
                         {
                          icono1.style.color = 'green';
                          icono2.style.color = 'grey';
                         }
                        else
                         {
                          icono1.style.color = 'grey';
                          icono2.style.color = 'green';
                         }
                       }
                      </script>
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
@endforeach