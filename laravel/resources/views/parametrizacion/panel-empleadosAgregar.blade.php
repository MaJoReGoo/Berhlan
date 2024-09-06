<?php
$server = '/Berhlan/public';

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
        Intranet | Agregar empleado
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
                  <a href="<?=$server?>/panel/parametrizacion/empleados" title="Parametrización > Empleados">
                    <font color="#34495e">
                      Parametrización > Empleados >
                    </font>
                    <font color="#b4c056">
                      Agregar
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/parametrizacion/empleados" class="btn btn-primary btn-sm ml10" title="Parametrización > Empleados">
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
                            Ingrese la información del nuevo empleado
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>
                            <div class="allcp-form">
                              {!! Form::open(array('action' => 'Parametrizacion\EmpleadosPanelController@EmpleadosAgregarDB', 'class' => 'form', 'id'=>'form-wizard', 'files' => true)) !!}
                                {!! Form::hidden('login', $DatLog->login) !!}

                                <div class="row">
                                  <div class="col-md-2">
                                    <label style="color: #4ECCDB">
                                      Primer nombre
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('primer_nombre', null, array('required', 'id'=>'primer_nombre', 'class'=>'gui-input', 'placeholder'=>'* Primer nombre')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-file"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-2">
                                    <label style="color: #4ECCDB">
                                      Segundo nombre
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('ot_nombre', null, array('id'=>'ot_nombre', 'class'=>'gui-input', 'placeholder'=>'Segundo nombre')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-file"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-2">
                                    <label style="color: #4ECCDB">
                                      Primer apellido
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('primer_apellido', null, array('required', 'id'=>'primer_apellido', 'class'=>'gui-input', 'placeholder'=>'* Primer apellido')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-files-o"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-2">
                                    <label style="color: #4ECCDB">
                                      Segundo apellido
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('ot_apellido', null, array('id'=>'ot_apellido', 'class'=>'gui-input', 'placeholder'=>'Segundo apellido')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-files-o"></i>
                                      </label>
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-2">
                                    <br>
                                    <label style="color: #4ECCDB">
                                      Identificación
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('identificacion', null, array('required', 'id'=>'identificacion', 'class'=>'gui-input', 'placeholder'=>'* Identificación')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-tag"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-2">
                                    <br>
                                    <label style="color: #4ECCDB">
                                      Teléfono
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::number('numtel', null, array('required', 'id'=>'numtel', 'class'=>'gui-input', 'placeholder'=>'* Teléfono')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-phone-square"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <br>
                                    <label style="color: #4ECCDB">
                                      Email
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::email('correo', null, array('required', 'id'=>'correo', 'class'=>'gui-input', 'placeholder'=>'* Email')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-envelope"></i>
                                      </label>
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-8">
                                    <br>
                                    <label style="color: #4ECCDB">
                                      Cargo
                                    </label>
                                    <label class="field select">
                                      <select name="cargo" id="cargo" required>
                                        <option value="">
                                          * Cargo
                                        </option>
                                        <?php
                                        $Cargos = PanelCargos::getCargos();
                                        ?>
                                        @foreach($Cargos as $DatCrg)
                                          <?php
                                          $Area = PanelAreas::getArea($DatCrg->area);
                                          foreach($Area as  $DatArea)
                                           {
                                            $Empresa = PanelEmpresas::getEmpresa($DatArea->empresa);
                                            $NombreArea = $DatArea->descripcion;
                                            foreach($Empresa as  $DatEmpresa)
                                             {
                                              $NombreEmpresa = $DatEmpresa->nombre;
                                             }
                                           }
                                          ?>
                                          <option value="<?=$DatCrg->id_cargo?>">
                                            <?=$DatCrg->descripcion.' - '.$NombreArea.' - '.$NombreEmpresa?>
                                          </option>
                                        @endforeach
                                      </select>
                                      <i class="arrow"></i>
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-4">
                                    <br>
                                    <label style="color: #4ECCDB">
                                      Centro de operación
                                    </label>
                                    <label class="field select">
                                      <select name="centro_op" id="centro_op" required>
                                        <option value="">
                                          * Centro de operación
                                        </option>
                                        <?php
                                        $Centros = PanelCentrosOp::getCentrosOpActivos();
                                        ?>
                                        @foreach($Centros as $DatCnts)
                                          <option value="<?=$DatCnts->id_centro?>">
                                            <?=$DatCnts->descripcion?>
                                          </option>
                                        @endforeach
                                      </select>
                                      <i class="arrow"></i>
                                    </label>
                                  </div>

                                  <div class="col-md-2">
                                    <br>
                                    <label style="color: #4ECCDB">
                                      Fecha de nacimiento
                                    </label>
                                    <label class="field select">
                                      <select name="dia" id="dia" required>
                                        <option value="">* Día</option>
                                        <?php
                                        $i = 1;
                                        while($i<=31)
                                         {
                                          echo "<option value=\"$i\">$i</option>";
                                          $i++;
                                         }
                                        ?>
                                      </select>
                                      <i class="arrow"></i>
                                    </label>
                                  </div>

                                  <div class="col-md-1">
                                    <br>
                                    <label style="color: #4ECCDB">
                                      &nbsp;
                                    </label>
                                    <label class="field select">
                                      <select name="mes" id="mes" required>
                                        <option value="">* Mes</option>
                                        <option value="01">Enero</option>
                                        <option value="02">Febrero</option>
                                        <option value="03">Marzo</option>
                                        <option value="04">Abril</option>
                                        <option value="05">Mayo</option>
                                        <option value="06">Junio</option>
                                        <option value="07">Julio</option>
                                        <option value="08">Agosto</option>
                                        <option value="09">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Noviembre</option>
                                        <option value="12">Diciembre</option>
                                      </select>
                                      <i class="arrow"></i>
                                    </label>
                                  </div>

                                  <div class="col-md-1">
                                    <br>
                                    <label style="color: #4ECCDB">
                                      &nbsp;
                                    </label>
                                    <label class="field select">
                                      <select name="anio" id="anio" required>
                                        <option value="">* Año</option>
                                        <?php
                                        $a = date('Y')-15; //15 años antes de la fecha actual
                                        $fechahasta = date('Y') - 70;  //Hasta 70 años de la fecha actual
                                        while($fechahasta <= $a)
                                         {
                                          echo "<option value=\"$a\">$a</option>";
                                          $a--;
                                         }
                                        ?>
                                      </select>
                                      <i class="arrow"></i>
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-6">
                                    <br>
                                    <label style="color: #4ECCDB">
                                      Imagen
                                    </label>
                                    <label class="field prepend-icon append-button file">
                                      <span class="button">
                                        Imagen
                                      </span>
                                      {!! Form::file('file1',
                                          array('id'=>'file1',
                                          'class'=>'gui-file', 'accept'=>'.jpg, .jpeg, .png, .gif, .avi',
                                          'onChange'=>"document.getElementById('uploader1').value = this.value;")) !!}
                                      {!! Form::text('uploader1', null,
                                          array('id'=>'uploader1',
                                          'class'=>'gui-input',
                                          'placeholder'=>'Seleccione la imagen')) !!}
                                      <label class="field-icon">
                                        <i class="fa fa-cloud-upload"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-2">
                                    <br><br><br>
                                    {!! Form::submit('Ingresar empleado', array('class'=>'button')) !!}
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
