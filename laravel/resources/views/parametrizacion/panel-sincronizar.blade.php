<?php
$server ='/Berhlan/public';
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelUsuariosSiesa;
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
        Intranet | Sincronizar usuarios SIESA
      </title>
      <meta name="keywords" content="panel, cms, usuarios, servicio"/>
      <meta name="description" content="Intranet para grupo Berhlan">
      <meta name="author" content="USUARIO" >
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!-- -------------- Fonts -------------- -->
      <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
      <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

      <!-- -------------- CSS - theme -------------- -->
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/skin/default_skin/css/theme.css">

      <!-- -------------- CSS - allcp forms -------------- -->
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/allcp/forms/css/forms.min.css">

      <!-- -------------- Plugins -------------- -->
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

      <!-- -------------- Favicon -------------- -->
      <link rel="shortcut icon" href="<?=$server?>/panelfiles/assets/img/favicon.ico">
      <!-- Alerts Personalizados -->

      <!-- This is what you need -->

      <script src="<?=$server?>/panelfiles/sweetalert/dist/sweetalert.min.js"></script>

      <link rel="stylesheet" href="<?=$server?>/panelfiles/sweetalert/dist/sweetalert.css">
    </head>

    <body class="sales-stats-page">
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
                  <a href="<?=$server?>/panel/menu/7" title="Parametrizacion">
                    <font color="#34495e">
                      Parametrización >
                    </font>
                    <font color="#b4c056">
                      Sincronizar usuarios Siesa
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/menu/7" class="btn btn-primary btn-sm ml10" title="Parametrización">
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
              <div class="panel m10">
                <!-- -------------- Message Body -------------- -->
                <div class="table-responsive">
                  <div style="padding-left: 10px">
                    Usuarios que se encuentran en <b>SIESA</b> y no han sido creados en la <b>Intranet</b>
                  </div>

                  <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                    <thead>
                      <tr style="background-color: #F8F8F8">
                        <th style="text-align:center;">
                          #
                        </th>
                        <th style="text-align:center;">
                          Identificación
                        </th>
                        <th style="text-align:center;">
                          Nombre
                        </th>
                        <th style="text-align:center;">
                          Área
                        </th>
                        <th style="text-align:center;">
                          Cargo
                        </th>
                        <th style="text-align:center;">
                          Centro de operación
                        </th>
                        <th style="text-align:center;">
                          Teléfono
                        </th>
                        <th style="text-align:center;">
                          Adicionar
                        </th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      $i = 1;
                      $DatosUsr = PanelUsuariosSiesa::Usuariosactivos();
                      ?>
                      @foreach($DatosUsr as $DatUsr)
                        <?php
                        $idsiesa = trim($DatUsr->f200_nit);
                        $Existe  = PanelEmpleados::getEmpleadoUnico($idsiesa);
                        if($Existe == 0)
                         {
                          echo "<tr class=\"message-unread\">";
                            echo "<td style=\"text-align:right\">";
                              echo $i;
                              $i++;
                            echo "</td>";

                            echo "<td style=\"text-align:right;\">";
                              echo $idsiesa;
                            echo "</td>";

                            echo "<td style=\"text-align:left;\">";
                              echo trim($DatUsr->f200_nombres);
                              echo " ";
                              echo trim($DatUsr->f200_apellido1);
                              echo " ";
                              echo trim($DatUsr->f200_apellido2);
                            echo "</td>";

                            echo "<td style=\"text-align:left;\">";
                              echo $DatUsr->Area;
                            echo "</td>";

                            echo "<td style=\"text-align:left;\">";
                              echo $DatUsr->Cargo;
                            echo "</td>";

                            echo "<td style=\"text-align:left;\">";
                              echo $DatUsr->CentroDes;
                              echo "<br>";
                              echo $DatUsr->Empresa;
                            echo "</td>";

                            echo "<td style=\"text-align:right;\">";
                              echo $DatUsr->Tel;
                            echo "</td>";

                            echo "<td style=\"text-align:center;\">";
                              echo "<button type=\"button\" class=\"btn btn-default light\" onclick=\"window.location.href='$server/panel/parametrizacion/sincronizar/agregar/$idsiesa'\">";
                                echo "<i class=\"fa fa-plus fa-1x\" style=\"color:#AEBF25;\"></i>";
                                echo " ";
                                echo "<i class=\"fa fa-user fa-1x\" style=\"color:#AEBF25;\"></i>";
                              echo "</button>";
                            echo "</td>";
                          echo "</tr>";
                         }
                        ?>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>

              <br>

              <div class="panel m10">
                <!-- -------------- Message Body -------------- -->
                <div class="table-responsive">
                  <div style="padding-left: 10px">
                    Empleados que se encuentran en la <b>Intranet</b> y no se encuentran activos en <b>SIESA</b>
                  </div>

                  <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                    <thead>
                      <tr style="background-color: #F8F8F8">
                        <th style="text-align:center;">
                          #
                        </th>
                        <th style="text-align:center;">
                          Sel.
                        </th>
                        <th style="text-align:center;">
                          Identificación
                        </th>
                        <th style="text-align:center;">
                          Nombre
                        </th>
                        <th style="text-align:center;">
                          Área
                        </th>
                        <th style="text-align:center;">
                          Cargo
                        </th>
                        <th style="text-align:center;">
                          Centro de operación
                        </th>
                      </tr>
                    </thead>

                    <tbody>
                      {!! Form::open(array('action' => 'Parametrizacion\SincronizarPanelController@UsuariosInactivarDB', 'class' => 'form', 'id'=>'form-wizard', 'onsubmit' => 'return confirm("¡Confirme la inactivación!")')) !!}
                        <?php
                        $i = 1;
                        $Activos = PanelEmpleados::EmpleadosActivos();
                        ?>
                        @foreach($Activos as $DatAct)
                          <?php
                          $Existe  = PanelUsuariosSiesa::EmpleadoUnico($DatAct->identificacion);
                          if($Existe[0]->cantidad == 0)
                           {
                            echo "<tr class=\"message-unread\">";
                              echo "<td style=\"text-align:right\">";
                                echo $i;
                                $i++;
                              echo "</td>";

                              echo "<td style=\"text-align:right; color:red\">";
                                ?>
                                {!! Form::checkbox('empleados[]', $DatAct->id_empleado, 'checked') !!}
                                <?php
                              echo "</td>";

                              echo "<td style=\"text-align:right;\">";
                                echo $DatAct->identificacion;
                              echo "</td>";

                              echo "<td style=\"text-align:left;\">";
                                echo $DatAct->primer_nombre;
                                echo " ";
                                echo $DatAct->ot_nombre;
                                echo " ";
                                echo $DatAct->primer_apellido;
                                echo " ";
                                echo $DatAct->ot_apellido;
                              echo "</td>";

                              $Cargo   = PanelCargos::getCargo($DatAct->cargo);
                              $Area    = PanelAreas::getArea($Cargo[0]->area);
                              $Empresa = PanelEmpresas::getEmpresa($Area[0]->empresa);
                              $Centro  = PanelCentrosOp::getCentroOp($DatAct->centro_op);

                              echo "<td style=\"text-align:left;\">";
                                echo $Area[0]->descripcion;
                              echo "</td>";

                              echo "<td style=\"text-align:left;\">";
                                echo $Cargo[0]->descripcion;
                              echo "</td>";

                              echo "<td style=\"text-align:left;\">";
                                echo $Centro[0]->descripcion;
                                echo "<br>";
                                echo $Empresa[0]->nombre;
                              echo "</td>";
                            echo "</tr>";
                           }
                          ?>
                        @endforeach

                        <tr>
                          <td align="center" colspan="7">
                            {!! Form::submit('Inactivar empleados seleccionados', array('class'=>'button btn-default', 'style'=>'background-color:#2b3980; color:white')) !!}
                          </td>
                        </tr>
                      {!! Form::close() !!}
                    </tbody>
                  </table>
                </div>
              </div>

              <br>

              <div class="panel m10">
                <!-- -------------- Message Body -------------- -->
                <div class="table-responsive">
                  <div style="padding-left: 10px">
                    Empleados que se encuentran <b>inactivos</b> en la <b>Intranet</b> y se encuentran activos en <b>SIESA</b>
                  </div>

                  <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                    <thead>
                      <tr style="background-color: #F8F8F8">
                        <th style="text-align:center;">
                          #
                        </th>
                        <th style="text-align:center;">
                          Sel.
                        </th>
                        <th style="text-align:center;">
                          Identificación
                        </th>
                        <th style="text-align:center;">
                          Nombre
                        </th>
                        <th style="text-align:center;">
                          Área
                        </th>
                        <th style="text-align:center;">
                          Cargo
                        </th>
                        <th style="text-align:center;">
                          Centro de operación
                        </th>
                      </tr>
                    </thead>

                    <tbody>
                      {!! Form::open(array('action' => 'Parametrizacion\SincronizarPanelController@UsuariosActivarDB', 'class' => 'form', 'id'=>'form-wizard', 'onsubmit' => 'return confirm("¡Confirme la activación!")')) !!}
                        <?php
                        $i = 1;
                        $Activos = PanelEmpleados::EmpleadosInactivos();
                        ?>
                        @foreach($Activos as $DatAct)
                          <?php
                          $Existe  = PanelUsuariosSiesa::EmpleadoUnico($DatAct->identificacion);
                          if($Existe[0]->cantidad > 0)
                           {
                            $Actual = PanelUsuariosSiesa::Empleado($DatAct->identificacion);
                            echo "<tr class=\"message-unread\">";
                              echo "<td style=\"text-align:right\">";
                                echo $i;
                                $i++;
                              echo "</td>";

                              echo "<td style=\"text-align:right; color:red\">";
                                ?>
                                {!! Form::checkbox('empleados[]', $DatAct->id_empleado, 'checked') !!}
                                <?php
                              echo "</td>";

                              echo "<td style=\"text-align:right;\">";
                                echo $DatAct->identificacion;
                              echo "</td>";

                              echo "<td style=\"text-align:left;\">";
                                echo $DatAct->primer_nombre;
                                echo " ";
                                echo $DatAct->ot_nombre;
                                echo " ";
                                echo $DatAct->primer_apellido;
                                echo " ";
                                echo $DatAct->ot_apellido;
                              echo "</td>";

                              $Cargo   = PanelCargos::getCargo($DatAct->cargo);
                              $Area    = PanelAreas::getArea($Cargo[0]->area);
                              $Empresa = PanelEmpresas::getEmpresa($Area[0]->empresa);
                              $Centro  = PanelCentrosOp::getCentroOp($DatAct->centro_op);

                              echo "<td style=\"text-align:left;\">";
                                echo "<b>En la Intranet:</b> ";
                                echo $Area[0]->descripcion;
                                echo "<br>";
                                echo "<b>En SIESA</b>: ".$Actual[0]->Area;
                              echo "</td>";

                              echo "<td style=\"text-align:left;\">";
                                echo "<b>En la Intranet:</b> ";
                                echo $Cargo[0]->descripcion;
                                echo "<br>";
                                echo "<b>En SIESA</b>: ".$Actual[0]->Cargo;
                              echo "</td>";

                              echo "<td style=\"text-align:left;\">";
                                echo "<b>En la Intranet:</b> ";
                                echo $Centro[0]->descripcion;
                                echo "<br>";
                                echo $Empresa[0]->nombre;
                                echo "<br>";
                                echo "<b>En SIESA</b>: ".$Actual[0]->CentroDes;
                                echo "<br>";
                                echo $Actual[0]->Empresa;
                              echo "</td>";
                            echo "</tr>";
                           }
                          ?>
                        @endforeach

                        <tr>
                          <td align="center" colspan="7">
                            {!! Form::submit('Activar empleados seleccionados', array('class'=>'button btn-default', 'style'=>'background-color:#2b3980; color:white')) !!}
                          </td>
                        </tr>
                      {!! Form::close() !!}
                    </tbody>
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
      <script src="<?=$server?>/panelfiles/assets/js/demo/widgets_sidebar.js"></script>
      <script src="<?=$server?>/panelfiles/assets/js/pages/dashboard2.js"></script>

      <!-- -------------- Page JS -------------- -->
      <script src="<?=$server?>/panelfiles/assets/js/demo/charts/highcharts.js"></script>

      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach