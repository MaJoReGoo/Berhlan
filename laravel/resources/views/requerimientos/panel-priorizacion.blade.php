<?php
$server = '/Berhlan/public';

use App\Models\Requerimientos\PanelGrupos;
use App\Models\Requerimientos\PanelPriorizaciones;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Requerimientos | Priorización
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
                  <a href="<?=$server?>/panel/menu/4" title="Requerimientos">
                    <font color="#34495e">
                      Requerimientos > Priorización >
                    </font>
                    <font color="#b4c056">
                      Modificar
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/menu/4" class="btn btn-primary btn-sm ml10" title="Requerimientos">
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
                          <th colspan="6">
                            Tiempos de priorización según su criticidad
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>
                            <font color="black">
                              <b>
                                Grupo
                              </b>
                            </font>
                          </td>

                          @foreach($DatosCriterios as $DatCri)
                            <td style="text-align:center;">
                              <font color="black">
                                <b>
                                  <?=$DatCri->descripcion?>
                                </b>
                              </font>
                            </td>
                          @endforeach

                          <td style="text-align:center;">
                            <font color="black">
                              <b>
                                Modificar
                              </b>
                            </font>
                          </td>
                        </tr>

                        <?php
                        $Grupos = PanelGrupos::getGrupos();
                        $a = 1;
                        ?>
                        @foreach($Grupos as $DatGru)
                          <tr>
                            <td>
                              <font color="black">
                                <?=$DatGru->descripcion?>
                              </font>
                            </td>

                            <?php
                            $b = 1;
                            ?>
                            @foreach($DatosCriterios as $DatCri)
                              <?php
                              $Valor = PanelPriorizaciones::getTiempo($DatGru->id_grupo, $DatCri->id_criterio);
                              ?>
                              <td style="text-align:center;">
                                <input type="text"   id="txttiempo_<?=$a?>_<?=$b?>" size="4" maxlength="4" value="<?=$Valor[0]->tiempo?>" style="text-align:right;">
                                <input type="hidden" id="txtidcri_<?=$a?>_<?=$b?>" value="<?=$DatCri->id_criterio?>">
                                <button type="button" style="background-color:white ; cursor:default; outline:none;" tabindex="-1" class="btn btn-default light">
                                  <b>
                                    días&nbsp;&nbsp;
                                    <label for="username" class="field-icon">
                                    <i class="fa fa-exclamation-triangle fa-2x" style="color:<?=$DatCri->color?>; text-shadow: 1px 1px 1px #000;"></i>
                                  </label>
                                  </b>
                                </button>
                              </td>
                              <?php
                              $b++;
                              ?>
                            @endforeach

                            <td style="text-align:center;">
                              <button type="button" class="btn btn-default light" onclick="EDITAR('<?=$a?>','<?=$DatGru->id_grupo?>')" title="Modificar priorización del grupo <?=$DatGru->descripcion?>">
                                <i class="fa fa-pencil fa-lg" style="color:#AEBF25;"></i>
                              </button>
                            </td>
                          </tr>

                          <?php
                          $a++;
                          ?>
                        @endforeach
                      </thead>
                    </table>

                    {!! Form::open(array('action' => 'Requerimientos\PriorizacionRequerimientosPanelController@PriorizacionModificarDB', 'class' => 'form', 'id'=>'form-wizard', 'name' => 'frmenvio')) !!}
                      {!! Form::hidden('login', $DatLog->login) !!}
                      {!! Form::hidden('grupo', '') !!}
                      {!! Form::hidden('criterio1', '') !!}
                      {!! Form::hidden('criterio2', '') !!}
                      {!! Form::hidden('criterio3', '') !!}
                      {!! Form::hidden('criterio4', '') !!}
                      {!! Form::hidden('valor1', '') !!}
                      {!! Form::hidden('valor2', '') !!}
                      {!! Form::hidden('valor3', '') !!}
                      {!! Form::hidden('valor4', '') !!}
                    {!! Form::close() !!}

                    <script language="javascript" type="text/javascript">
                    function EDITAR(pos, grupo)
                     {
                      var gr = grupo;
                      var id = pos;
                      criter1 = document.getElementById('txtidcri_'+id+'_1');
                      criter2 = document.getElementById('txtidcri_'+id+'_2');
                      criter3 = document.getElementById('txtidcri_'+id+'_3');
                      criter4 = document.getElementById('txtidcri_'+id+'_4');
                      tiempo1 = document.getElementById('txttiempo_'+id+'_1');
                      tiempo2 = document.getElementById('txttiempo_'+id+'_2');
                      tiempo3 = document.getElementById('txttiempo_'+id+'_3');
                      tiempo4 = document.getElementById('txttiempo_'+id+'_4');

                      if((tiempo1.value == "") || (tiempo1.value.search("[^0-9]") >= 0))
                       {
                        alert("Debe ingresar la cantidad de días para el criterio y solo se aceptan números");
                        tiempo1.focus();
                        return false;
                       }

                      if((tiempo2.value == "") || (tiempo2.value.search("[^0-9]") >= 0))
                       {
                        alert("Debe ingresar la cantidad de días para el criterio y solo se aceptan números");
                        tiempo2.focus();
                        return false;
                       }

                      if((tiempo3.value == "") || (tiempo3.value.search("[^0-9]") >= 0))
                       {
                        alert("Debe ingresar la cantidad de días para el criterio y solo se aceptan números");
                        tiempo3.focus();
                        return false;
                       }

                      if((tiempo4.value == "") || (tiempo4.value.search("[^0-9]") >= 0))
                       {
                        alert("Debe ingresar la cantidad de días para el criterio y solo se aceptan números");
                        tiempo4.focus();
                        return false;
                       }

                      frm = document.forms["frmenvio"];
                      frm.grupo.value     = gr;
                      frm.criterio1.value = criter1.value;
                      frm.criterio2.value = criter2.value;
                      frm.criterio3.value = criter3.value;
                      frm.criterio4.value = criter4.value;
                      frm.valor1.value    = tiempo1.value;
                      frm.valor2.value    = tiempo2.value;
                      frm.valor3.value    = tiempo3.value;
                      frm.valor4.value    = tiempo4.value;
                      document.frmenvio.submit();
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
      <script src="<?=$server?>/panelfiles/assets/js/demo/widgets_sidebar.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/pages/dashboard2.js"></script>

      <!-- -------------- Page JS -------------- -->
      <script src="<?=$server?>/panelfiles/assets/js/demo/charts/highcharts.js"></script>

      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach