<?php
$server = '/Berhlan/public';

use App\Models\Procesos\PanelPerfiles;
?>

@foreach($DatosUsuario as $DatLog)
  @foreach($DatosDocumento as $DatDoc)
    <!DOCTYPE html>
    <html>
      <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
          Intranet | Documentos | Agregar perfil
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
                    <a href="<?=$server?>/panel/procesos/documentos/modificar/<?=$DatDoc->id_documento?>" title="Procesos internos > Documentos > Modificar">
                      <font color="#34495e">
                        Procesos internos > Documentos > Perfiles >
                      </font>
                      <font color="#b4c056">
                        Agregar
                      </font>
                    </a>
                  </li>
                </ul>
              </div>

              <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                <a href="<?=$server?>/panel/procesos/documentos/modificar/<?=$DatDoc->id_documento?>" class="btn btn-primary btn-sm ml10" title="Procesos internos > Documentos > Modificar">
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
                              Seleccione el perfil que desea asociar
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr>
                            <td>
                              <div class="allcp-form">
                                {!! Form::open(array('action' => 'Procesos\DocPerProcesosPanelController@DocumePerfilAgregarDB', 'class' => 'form', 'id'=>'form-wizard')) !!}
                                  {!! Form::hidden('login', $DatLog->login) !!}
                                  {!! Form::hidden('id_documento', $DatDoc->id_documento) !!}

                                  <div class="section">
                                    <div class="col-md-12">
                                      <label style="color: #4ECCDB">
                                        Documento
                                      </label>
                                      <label class="field prepend-icon">
                                        <?=$DatDoc->descripcion?>
                                      </label>
                                    </div>

                                    <div class="col-md-4">
                                      <label style="color: #4ECCDB">
                                        Perfil
                                      </label>
                                      <label class="field select">
                                        <select name="perfil" id="perfil" required>
                                          <option value="">
                                            * Perfil
                                          </option>
                                          <?php
                                          $Perfiles = PanelPerfiles::getPerfiles();
                                          ?>
                                          @foreach($Perfiles as $DatPer)
                                            <option value="<?=$DatPer->id_perfil?>">
                                              <?=$DatPer->descripcion;?>
                                            </option>
                                          @endforeach
                                        </select>
                                        <i class="arrow"></i>
                                      </label>
                                    </div>
                                  </div>

                                  <div class="section">
                                    <div class="col-md-2">
                                      <br><br>
                                      {!! Form::submit('Asociar perfil', array('class'=>'button')) !!}
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
                              Perfiles asociados al documento:
                              <?=$DatDoc->descripcion?>
                            </font>
                          </th>
                        </tr>
                      </thead>

                      <thead>
                        <?php
                        $u = 1;
                        $DatosPerfiles = PanelPerfiles::getDocumentosPerfil($DatDoc->id_documento);
                        ?>
                        @foreach($DatosPerfiles as $DatPer)
                          <tr class="message-unread">
                            <td style="text-align:left">
                              <font color="#2A2F43">
                                <?php
                                print $u;
                                $u++;
                                ?>
                                &nbsp;&nbsp;
                                <b>
                                <?=$DatPer->descripcion?>
                              </b>
                              </font>
                            </td>
                          </tr>
                        @endforeach
                      </thead>
                    </table>
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