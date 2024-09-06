<?php
$server = '/Berhlan/public';
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelUsuarios;
use App\Models\Procesos\PanelPerfiles;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Procesos | Agregar usuario a perfil
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


        {{-- Importar styles y funcionamiento del Select2 --}}
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">


        <script type="text/javascript" src="<?= $server ?>/panelfiles/select2/dist/js/select2.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?= $server ?>/panelfiles/select2/dist/css/select2.min.css">

      <!-- -------------- Favicon -------------- -->
      <link rel="shortcut icon" href="<?=$server?>/panelfiles/assets/img/favicon.ico">

      <!-- Editor -->
      <script type="text/javascript" src="<?=$server?>/panelfiles/ckeditor/ckeditor.js"></script>

      <script>
        jQuery(document).ready(function($) {
            $("#empleado").select2({
                closeOnSelect: true,
                width: '250px'
            });
        });

    </script>
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
                  <a href="<?=$server?>/panel/procesos/perfiles/modificar/<?=$DatosPerfil[0]->id_perfil?>" title="Procesos internos > Perfiles > Modificar">
                    <font color="#34495e">
                      Procesos internos > Perfiles > Usuarios >
                    </font>
                    <font color="#b4c056">
                      Agregar
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/procesos/perfiles/modificar/<?=$DatosPerfil[0]->id_perfil?>" class="btn btn-primary btn-sm ml10" title="Procesos internos > Perfiles > Modificar">
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
                        <tr>
                          <th style="background-color:#67d3e0; color:#34495e; text-align:left;">
                            Asocie el usuario al perfil
                          </th>
                        </tr>
                      </thead>
                      <thead>

                      <tbody>
                        <tr>
                          <td>
                            <div class="allcp-form">
                              {!! Form::open(array('action' => 'Procesos\PerfilesProcesosPanelController@PerfilesAgregarUsrDB', 'class' => 'form', 'id'=>'form-wizard')) !!}
                                {!! Form::hidden('login', $DatLog->login) !!}
                                {!! Form::hidden('id_perfil', $DatosPerfil[0]->id_perfil) !!}
                                <div class="row">
                                  <div class="col-md-12">
                                    <label style="color:black;">
                                      <b>
                                        Perfil
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      <?=$DatosPerfil[0]->descripcion?>
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-4">
                                    <label style="color:black;">
                                      <b>
                                        Usuario
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="empleado[]" id="empleado" multiple="multiple" required>
                                        <option value="">
                                          * Empleado
                                        </option>
                                        <?php
                                        $Usuarios = PanelUsuarios::getUsuariosActivos();
                                        ?>
                                        @foreach($Usuarios as $DatUsr)
                                          <?php
                                          $Empleado = PanelEmpleados::getEmpleado($DatUsr->empleado);
                                          $Cargo    = PanelCargos::getCargo($Empleado[0]->cargo);
                                          $Area     = PanelAreas::getArea($Cargo[0]->area);

                                          ?>
                                          <option value="<?=$DatUsr->id_usuario?>">
                                            <?php

                                            echo $Empleado[0]->primer_nombre .' '. $Empleado[0]->primer_apellido;
                                            echo " - ";
                                            echo $Cargo[0]->descripcion;
                                            echo " - ";
                                            echo $Area[0]->descripcion;
                                            ?>
                                          </option>
                                        @endforeach
                                      </select>

                                    </label>
                                  </div>


                                  <div class="col-md-4">
                                    <br><br>
                                    {!! Form::submit('Asociar usuario', array('class'=>'button')) !!}
                                    <br><br>
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

              <br>

              <div class="panel m10">
                <div class="table-responsive">
                  <table id="message-table" class="table allcp-form theme-warning br-t">
                    <thead>
                      <tr>
                        <th colspan="2">
                          <font color="black">
                            Usuarios asociados al perfil:
                            <?=$DatosPerfil[0]->descripcion?>
                          </font>
                        </th>
                      </tr>
                    </thead>

                    <thead>
                      <?php
                      $u = 1;
                      $DatosUsuarios = PanelPerfiles::getUsuariosPerfil($DatosPerfil[0]->id_perfil);
                      ?>
                      @foreach($DatosUsuarios as $DatUsr)
                        <tr class="message-unread">
                          <td style="text-align: left ">
                            <font color="#2A2F43">
                              <?php
                              print $u;
                              $u++;
                              ?>
                            </font>
                          </td>

                          <td style="text-align:left">
                            <i class="fa fa-user fa-lg" style="color:#AEBF25"></i>
                            &nbsp;
                            <font color="#2A2F43">
                              <b>
                                <?php
                                $Empleado = PanelEmpleados::getEmpleado($DatUsr->empleado);
                                $Cargo    = PanelCargos::getCargo($Empleado[0]->cargo);
                                $Area     = PanelAreas::getArea($Cargo[0]->area);
                                echo $DatUsr->primer_nombre. ' '. $DatUsr->primer_apellido;
                                echo " (";
                                echo $Cargo[0]->descripcion;
                                echo " - ";
                                echo $Area[0]->descripcion;
                                echo ")";
                                ?>
                              </b>
                            </font>
                          </td>
                        </tr>
                      @endforeach
                    </thead>
                  </table>
                </div>
              </div>
            </div>
            <!-- -------------- /Column Center -------------- -->
          </section>
          <!-- -------------- /Content -------------- -->
        </section>
      </div>
      <!-- -------------- /Body Wrap  -------------- -->

      <!-- -------------- Scripts -------------- -->

      <!-- -------------- jQuery -------------- -->
      <script src="<?=$server?>/panelfiles/assets/js/jquery/jquery-1.11.3.min.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js"></script>

      <!-- -------------- CanvasBG JS -------------- -->
      <script src="<?=$server?>/panelfiles/assets/js/plugins/canvasbg/canvasbg.js"></script>

      <!-- -------------- MonthPicker JS -------------- -->
      <script src="<?=$server?>/panelfiles/assets/allcp/forms/js/jquery-ui-monthpicker.min.js"></script>
      <script src="<?=$server?>/panelfiles/assets/allcp/forms/js/jquery-ui-datepicker.min.js"></script>
      <script src="<?=$server?>/panelfiles/assets/allcp/forms/js/jquery.spectrum.min.js"></script>
      <script src="<?=$server?>panelfiles/assets/allcp/forms/js/jquery.stepper.min.js"></script>

      <!-- -------------- Theme Scripts -------------- -->
      <script src="<?=$server?>/panelfiles/assets/js/utility/utility.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/demo/demo.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/main.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/pages/allcp_forms-elements.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/demo/widgets_sidebar.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/pages/forms-widgets.js"></script> <!-- Lugar para poner varios calendarios (Datepicker1) -->
      <script src="<?=$server?>/panelfiles/assets/js/pages/tables-basic.js"></script>
      <!-- -------------- Page JS -------------- -->

    </body>
  </html>
@endforeach
