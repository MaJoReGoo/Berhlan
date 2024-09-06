<?php
$server = '/Berhlan/public';

use App\Models\Requerimientos\PanelGrupos;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelCentrosOp;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Requerimientos | Crear caso
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
                  <a href="<?=$server?>/panel/requerimientos/crearcaso" title="Requerimientos > Crear caso">
                    <font color="#34495e">
                      Requerimientos >
                      <?php
                      $nomgrupo = PanelGrupos::getGrupo($Grupo);
                      ?>
                      Grupo <?=$nomgrupo[0]->descripcion?> >
                      <font color="#b4c056">
                        Crear caso
                      </font>
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/requerimientos/crearcaso" class="btn btn-primary btn-sm ml10" title="Requerimientos > Crear caso">
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
                            Crear un caso a nombre de otro colaborador
                          </th>
                        </tr>
                      </thead>
                    </table>

                    <div style="padding-left: 10px">
                      <br>
                      {!! Form::open(array('action' => 'Requerimientos\CrearRequerimientosPanelController@CrearCasoSeleccionar', 'class' => 'form', 'id'=>'form-wizard')) !!}
                        {!! Form::hidden('Grupo', $Grupo) !!}
                        <label class="field prepend-icon">
                          {!! Form::text('busqueda', null, array('', 'id'=>'busqueda', 'class'=>'gui-input', 'placeholder'=>'Identificación ó nombre')) !!}
                        </label>
                        <label for="username" class="field-icon">
                          {{ Form::button('<i class="fa fa-search" style="color:#67d3e0"></i>', ['class' => 'button', 'type' => 'submit', 'style' => 'background-color:white; border:0']) }}

                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <?php
                          if($bq != "")
                           {
                            echo "Parámetro de búsqueda: ";
                            echo "<font color=\"#b4c056\">";
                              echo $bq;
                            echo "</font>";
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                           }
                          ?>
                        </label>
                      {!! Form::close() !!}
                      <br>
                    </div>

                    <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                      <thead>
                        <tr style="background-color: #F8F8F8; color:#000000">
                          <th style="text-align: center;">
                            #
                          </th>
                          <th style="text-align: center">
                            Seleccionar
                          </th>
                          <th style="text-align: left">
                            Identificación
                          </th>
                          <th style="text-align: left">
                            Nombres y Apellidos
                          </th>
                          <th style="text-align:center;">
                            Cargo
                          </th>
                          <th style="text-align: left">
                            Centro de operación
                          </th>
                          <th style="text-align: left">
                            Teléfono
                          </th>
                          <th style="text-align: center">
                            Seleccionar
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php $u = 1;?>
                        @foreach($DatosEmpleados as $DatEmpleados)
                          <tr class="message-unread">
                            <td style="text-align: right">
                              <font color="#2A2F43">
                                <?php
                                print $u;
                                $u++;
                                ?>
                              </font>
                            </td>

                            <td style="text-align: center">
                              <button type="button" class="btn btn-default light" onclick="ENVIAR('<?=$DatEmpleados->id_empleado?>')" title="Nueva solicitud">
                                <i class="fa fa-user fa-lg" style="color:#AEBF25;"></i>
                              </button>
                            </td>

                            <td style="text-align: left ">
                              <font color="#2A2F43">
                                <b>
                                  <?=$DatEmpleados->identificacion?>
                                </b>
                              </font>
                            </td>

                            <td style="text-align: left ">
                              <font color="#2A2F43">
                                <?php
                                echo $DatEmpleados->primer_nombre;
                                echo " ";
                                echo $DatEmpleados->ot_nombre;
                                echo " ";
                                echo $DatEmpleados->primer_apellido;
                                echo " ";
                                echo $DatEmpleados->ot_apellido;
                                ?>
                              </font>
                            </td>

                            <?php
                            $Cargo = PanelCargos::getCargo($DatEmpleados->cargo);
                            ?>
                            <td style="text-align:center;">
                              @foreach($Cargo as $DatCargo)
                                <font color="#2A2F43">
                                  <?=$DatCargo->descripcion?>
                                  <br>
                                  <?php
                                  $Area = PanelAreas::getArea($DatCargo->area);
                                  ?>
                                  @foreach($Area as $DatArea)
                                    <?php
                                    echo $DatArea->descripcion." - ";
                                    $Empresa = PanelEmpresas::getEmpresa($DatArea->empresa);
                                    ?>
                                    @foreach($Empresa as $DatEmpresa)
                                      <?=$DatEmpresa->nombre?>
                                    @endforeach
                                  @endforeach
                                </font>
                              @endforeach
                            </td>

                            <?php
                            $Centro = PanelCentrosOp::getCentroOp($DatEmpleados->centro_op);
                            ?>
                            <td style="text-align: left">
                              @foreach($Centro as $DatCentro)
                                <font color="#2A2F43">
                                  <?=$DatCentro->descripcion?>
                                </font>
                              @endforeach
                            </td>

                            <td style="text-align: left">
                              <font color="#2A2F43">
                                <?=$DatEmpleados->numtel?>
                              </font>
                            </td>

                            <td style="text-align: center">
                              <button type="button" class="btn btn-default light" onclick="ENVIAR('<?=$DatEmpleados->id_empleado?>')" title="Nueva solicitud">
                                <i class="fa fa-user fa-lg" style="color:#AEBF25;"></i>
                              </button>
                            </td>
                          </tr>
                        @endforeach
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

      {!! Form::open(array('action' => 'Requerimientos\CrearRequerimientosPanelController@CrearCasoAgregar', 'class' => 'form', 'id'=>'form-wizard', 'name' => 'frmenvio')) !!}
        {!! Form::hidden('Grupo', $Grupo) !!}
        {!! Form::hidden('Empleado', '') !!}
      {!! Form::close() !!}

      <script language="javascript" type="text/javascript">
      function ENVIAR(id)
       {
        frm = document.forms["frmenvio"];
        frm.Empleado.value = id;
        document.frmenvio.submit();
       }
      </script>

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