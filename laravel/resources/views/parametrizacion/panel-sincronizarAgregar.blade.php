<?php
$server ='/Berhlan/public';

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
        Intranet | Ingresar empleado
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
                  <a href="<?=$server?>/panel/parametrizacion/sincronizar" title="Parametrización > Sincronizar usuarios Siesa">
                    <font color="#34495e">
                      Parametrización > Sincronizar usuarios Siesa >
                    </font>
                    <font color="#b4c056">
                      Ident. <?=$DatosEmpleado[0]->f200_nit?>
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/parametrizacion/sincronizar" class="btn btn-primary btn-sm ml10" title="Parametrización > Sincronizar usuarios Siesa">
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
                            Ingrese la información del nuevo empleado
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>
                            <?php
                            $nombres  = explode(" ", $DatosEmpleado[0]->f200_nombres);
                            $otnombre = "";
                            $l = 0;
                            foreach ($nombres as $DatNom)
                             {
                              if($l > 0)
                                $otnombre = $otnombre." ".$DatNom;
                              else
                                $l++;
                             }
                            $otnombre        = trim($otnombre);
                            $fechanacimiento = substr($DatosEmpleado[0]->f200_fecha_nacimiento, 0, 10);
                            ?>

                            <div class="allcp-form">
                              {!! Form::open(array('action' => 'Parametrizacion\SincronizarPanelController@UsuariosAgregarDB', 'class' => 'form', 'id'=>'form-wizard', 'files' => true)) !!}
                                <div class="section">
                                  <div class="col-md-3">
                                    <label style="color: #4ECCDB">
                                      Primer nombre
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('primer_nombre', $nombres[0], array('required', 'id'=>'primer_nombre', 'class'=>'gui-input', 'placeholder'=>'* Primer nombre')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-file"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #4ECCDB">
                                      Segundo nombre
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('ot_nombre', $otnombre, array('id'=>'ot_nombre', 'class'=>'gui-input', 'placeholder'=>'Segundo nombre')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-file"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #4ECCDB">
                                      Primer apellido
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('primer_apellido', $DatosEmpleado[0]->f200_apellido1, array('required', 'id'=>'primer_apellido', 'class'=>'gui-input', 'placeholder'=>'* Primer apellido')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-files-o"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <label style="color: #4ECCDB">
                                      Segundo apellido
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('ot_apellido', $DatosEmpleado[0]->f200_apellido2, array('id'=>'ot_apellido', 'class'=>'gui-input', 'placeholder'=>'Segundo apellido')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-files-o"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <br>
                                    <label style="color: #4ECCDB">
                                      Identificación
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::text('identificacion', $DatosEmpleado[0]->f200_nit, array('required', 'id'=>'identificacion', 'class'=>'gui-input', 'placeholder'=>'* Identificación')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-tag"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <br>
                                    <label style="color: #4ECCDB">
                                      Teléfono
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::number('numtel', $DatosEmpleado[0]->Tel, array('required', 'id'=>'numtel', 'class'=>'gui-input', 'placeholder'=>'* Teléfono')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-phone-square"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <br>
                                    <label style="color: #4ECCDB">
                                      Email
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::email('correo', $DatosEmpleado[0]->Correo, array('required', 'id'=>'correo', 'class'=>'gui-input', 'placeholder'=>'* Email')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-envelope"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-3">
                                    <br>
                                    <label style="color: #4ECCDB">
                                      Fecha de nacimiento
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::date('nacimiento', $fechanacimiento, array('required', 'id'=>'nacimiento', 'class'=>'gui-input', 'maxlength'=>'10')) !!}
                                    </label>
                                  </div>

                                  <div class="col-md-8">
                                    <br>
                                    <label style="color: #4ECCDB">
                                      Cargo &nbsp;&nbsp;(
                                      <font color="green">
                                        <?php
                                        echo $cargosiesa = $DatosEmpleado[0]->Cargo." - ".$DatosEmpleado[0]->Area." - ".$DatosEmpleado[0]->Empresa;
                                        ?>
                                      </font>
                                      )
                                    </label>
                                    <label class="field select">
                                      <select name="cargo" id="cargo" required>
                                        <?php
                                        //Este código es para comparar los textos de los cargos que trae siesa contra los cargos que tiene la intranet y seleccionar el mas similar
                                        $Cargos     = PanelCargos::getCargos();
                                        $porcentaje = 0;
                                        $idcargo    = "";
                                        $descargo   = "";
                                        ?>
                                        @foreach($Cargos as $DatCar)
                                          <?php
                                          $DatosCargo = PanelCargos::getCargo($DatCar->id_cargo);
                                          $Area       = PanelAreas::getArea($DatosCargo[0]->area);
                                          $Empresa    = PanelEmpresas::getEmpresa($Area[0]->empresa);
                                          $cargointra = $DatosCargo[0]->descripcion.' - '.$Area[0]->descripcion.' - '.$Empresa[0]->nombre;
                                          similar_text($cargosiesa, $cargointra, $percent);
                                          if($percent > $porcentaje)
                                           {
                                            $idcargo    = $DatCar->id_cargo;
                                            $porcentaje = $percent;
                                            $descargo   = $cargointra;
                                           }
                                          ?>
                                        @endforeach

                                        <?php
                                        if($porcentaje < 70)
                                         {
                                          echo "<option value=\"\">";
                                            echo "* Cargo";
                                          echo "</option>";
                                         }
                                        else
                                         {
                                          echo "<option value=\"$idcargo\">";
                                            echo $descargo;
                                          echo "</option>";
                                         }

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

                                  <div class="col-md-4">
                                    <br>
                                    <label style="color: #4ECCDB">
                                      Centro de operación &nbsp;&nbsp;(
                                      <font color="green">
                                        <?=$DatosEmpleado[0]->CentroDes?>
                                      </font>
                                      )
                                    </label>
                                    <label class="field select">
                                      <select name="centro_op" id="centro_op" required>
                                        <option value="">
                                          * Centro de operación
                                        </option>
                                        <?php
                                        $Centros = PanelCentrosOp::getCentrosOp();
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

                                  <div class="col-md-4">
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

                                  <div class="col-md-4">
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