<?php
$server ='/Berhlan/public';

use App\Models\Procesos\PanelPerfiles;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
?>

@foreach($DatosUsuario as $DatLog)
  @foreach($DatosPerfil as $DatPer)
    <!DOCTYPE html>
    <html>
      <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
          Intranet | Procesos | Modificar perfil
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
                    <a href="<?=$server?>/panel/procesos/perfiles" title="Procesos internos > Perfiles">
                      <font color="#34495e">
                        Procesos internos > Perfiles >
                      </font>
                      <font color="#b4c056">
                        Modificar
                      </font>
                    </a>
                  </li>
                </ul>
              </div>

              <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                <a href="<?=$server?>/panel/procesos/perfiles" class="btn btn-primary btn-sm ml10" title="Procesos internos > Perfiles">
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
                          <tr style="background-color:#39405a">
                            <th>
                              Actualice la información del perfil
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr>
                            <td>
                              <div class="allcp-form">
                                {!! Form::open(array('action' => 'Procesos\PerfilesProcesosPanelController@PerfilesModificarDB', 'class' => 'form', 'id'=>'form-wizard')) !!}
                                  {!! Form::hidden('login', $DatLog->login) !!}
                                  {!! Form::hidden('id_perfil', $DatPer->id_perfil) !!}

                                  <div class="section">
                                    <div class="col-md-5">
                                      <label style="color: #4ECCDB">
                                        Descripción
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::text('descripcion', $DatPer->descripcion, array('required', 'id'=>'descripcion', 'class'=>'gui-input', 'placeholder'=>'* Descripción')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-file"></i>
                                        </label>
                                      </label>
                                    </div>

                                    <div class="col-md-1" align="center">
                                      <br><br>
                                      {!! Form::submit('Modificar perfil', array('class'=>'button')) !!}
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

                <div class="panel m3">
                  <!-- -------------- Message Body -------------- -->
                  <div class="nano-content">
                    <div class="table-responsive">
                      <table id="message-table" class="table allcp-form theme-warning br-t">
                        <thead>
                          <tr style="background-color:#39405a">
                            <th>
                              <button type="button" class="btn btn-default light" onclick="MASINFO()">
                                <i id="btnmasinfo" class="fa fa-sort-amount-desc fa-lg" style="color:#AEBF25;" title="Más información"></i>
                              </button>
                              &nbsp;
                              Usuarios asociados
                            </th>

                            <td align="right">
                              <button type="button" class="btn btn-default light" onclick="window.location.href='<?=$server?>/panel/procesos/perfiles/agregarusr/<?=$DatPer->id_perfil?>'" title="Asociar usuario">
                                <span class="fa fa-plus pr5" style="color:#AEBF25;"></span>
                                <span class="fa fa-user pr5" style="color:#AEBF25;"></span>
                              </button>
                            </td>
                          </tr>
                        </thead>

                        <tbody id="tbusuarios" style="display:none;">
                          <tr>
                            <td colspan="2">
                              <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                <thead>
                                  <tr style="background-color: #F8F8F8; color:#000000">
                                    <th style="text-align: left">
                                      #
                                    </th>
                                    <th style="text-align: left">
                                      Usuario
                                    </th>
                                    <th style="text-align: center">
                                      Retirar
                                    </th>
                                  </tr>
                                </thead>

                                <tbody>
                                  <?php
                                  $u = 1;
                                  $DatosUsuarios = PanelPerfiles::getUsuariosPerfil($DatPer->id_perfil);
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

                                      <td style="text-align: left ">
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

                                      <td style="text-align: center">
                                        <button type="button" class="btn btn-default light" onclick="BORRAR('<?=$DatUsr->id_usuario?>', '<?=$DatUsr->login?>')" title="Desasociar usuario">
                                          <i class="fa fa-trash fa-lg" style="color:#F6565A;"></i>
                                        </button>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                              </table>

                              {!! Form::open(array('action' => 'Procesos\PerfilesProcesosPanelController@PerfilesRetirarUsrDB', 'class' => 'form', 'id'=>'form-wizard', 'name' => 'frmenvio')) !!}
                                {!! Form::hidden('login', $DatLog->login) !!}
                                {!! Form::hidden('id_perfil', $DatPer->id_perfil) !!}
                                {!! Form::hidden('id_usuario', '') !!}
                              {!! Form::close() !!}

                              <script language="javascript" type="text/javascript">
                                function MASINFO()
                                 {
                                  tbody = document.getElementById('tbusuarios');
                                  id    = document.getElementById('btnmasinfo');
                                  if(tbody.style.display == '')
                                   {
                                    tbody.style.display = 'none';
                                    id.className        = 'fa fa-sort-amount-desc fa-lg';
                                    id.title            = "Más información";
                                   }
                                  else
                                  {
                                   tbody.style.display = '';
                                   id.className        = 'fa fa-sort-up fa-lg';
                                   id.title            = "Menos información";
                                  }
                                 }

                                function BORRAR(sub, nom)
                                 {
                                  var id  = sub;
                                  var id1 = nom;

                                  if(!(confirm("Confirme el retiro del usuario ("+id1+").")))
                                    return false;

                                  frm = document.forms["frmenvio"];
                                  frm.id_usuario.value = id;
                                  document.frmenvio.submit();
                                 }
                              </script>
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
@endforeach
