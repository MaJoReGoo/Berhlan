<?php

use App\Models\Requerimientos\PanelGrupos;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelCentrosOp;
?>

@foreach($DatosUsuario as $DatLog)
  @foreach($DatosGrupo as $DatGru)
    <!DOCTYPE html>
    <html>
      <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
          Intranet | Modificar grupo
        </title>

        <meta name="keywords" content="panel, cms, usuarios, servicio"/>
        <meta name="description" content="Intranet para grupo Berhlan">
        <meta name="author" content="USUARIO" >
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- -------------- Fonts -------------- -->
        <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
        <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

        <!-- -------------- CSS - theme -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/skin/default_skin/css/theme.css')}}">

        <!-- -------------- CSS - allcp forms -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/allcp/forms/css/forms.css')}}">

        <!-- -------------- Plugins -------------- -->
        <link rel="stylesheet" type="text/css" href="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.css')}}">

        <!-- -------------- Favicon -------------- -->
        <link rel="shortcut icon" href="{{ asset ('/panelfiles/assets/img/favicon.ico')}}">

        <!-- Editor -->
        <script type="text/javascript" src="{{ asset ('/panelfiles/ckeditor/ckeditor.js')}}"></script>
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
                    <a href="{{ asset ('/panel/requerimientos/grupos')}}" title="Requerimientos > Grupos">
                      <font color="#34495e">
                        Requerimientos > Grupos >
                      </font>
                      <font color="#b4c056">
                        Modificar
                      </font>
                    </a>
                  </li>
                </ul>
              </div>

              <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                <a href="{{ asset ('/panel/requerimientos/grupos')}}" class="btn btn-primary btn-sm ml10" title="Requerimientos > Grupos">
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
                              Actualice la información del grupo que atiende requerimientos
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr>
                            <td>
                              <div class="allcp-form">
                                {!! Form::open(array('action' => 'Requerimientos\GruposRequerimientosPanelController@GruposModificarDB', 'class' => 'form', 'id'=>'form-wizard')) !!}
                                  {!! Form::hidden('login', $DatLog->login) !!}
                                  {!! Form::hidden('id_grupo', $DatGru->id_grupo) !!}

                                  <div class="row">
                                    <div class="col-md-4">
                                      <label style="color:#34495e;">
                                        <b>
                                          Grupo
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::text('descripcion', $DatGru->descripcion, array('required', 'id'=>'descripcion', 'class'=>'gui-input', 'placeholder'=>'* Descripción')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-file"></i>
                                        </label>
                                      </label>
                                    </div>

                                    <div class="col-md-4">
                                      <label style="color:#34495e;">
                                        <b>
                                          Estado
                                        </b>
                                      </label>
                                      <label class="field select">
                                        <select name="estado" id="estado" required>
                                          <option value="1" style="color:green;"
                                          <?php
                                          if($DatGru->estado == 1)
                                            echo " selected ";
                                          ?>
                                          >Activo</option>

                                          <option value="0" style="color:red;"
                                          <?php
                                          if($DatGru->estado == 0)
                                            echo " selected ";
                                          ?>
                                          >Inactivo</option>
                                        </select>
                                        <i class="arrow"></i>
                                      </label>
                                    </div>
                                  </div>

                                  <br>

                                  <div class="row">
                                    <div class="col-md-4">
                                      <label style="color:#34495e;">
                                        <b>
                                          Controla reintegro
                                        </b>
                                      </label>
                                      <label class="field select">
                                        <select name="reintegro" id="reintegro" required>
                                          <option value="1" style="color:green;"
                                          <?php
                                          if($DatGru->reintegro == 1)
                                            echo " selected ";
                                          ?>
                                          >Sí</option>

                                          <option value="0" style="color:red;"
                                          <?php
                                          if($DatGru->reintegro == 0)
                                            echo " selected ";
                                          ?>
                                          >No</option>
                                        </select>
                                        <i class="arrow"></i>
                                      </label>
                                    </div>

                                    <div class="col-md-4">
                                      <br><br>
                                      {!! Form::submit('Modificar grupo', array('class'=>'button btn-primary')) !!}
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
                              Usuarios asociados al grupo
                            </th>

                            <td align="right">
                              <button type="button" class="btn btn-default light" onclick="window.location.href='{{ asset ('/panel/requerimientos/empleados/asociar/')}}<?=$DatGru->id_grupo?>'" title="Asociar empleado">
                                <span class="fa fa-plus pr5" style="color:#AEBF25;"></span>
                                <span class="fa fa-user pr5" style="color:#AEBF25;"></span>
                              </button>
                            </td>
                          </tr>
                        </thead>

                        <tbody id="tbempleados" style="display:none;">
                          <tr>
                            <td colspan="2">
                              <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                <thead>
                                  <tr style="background-color: #F8F8F8; color:#000000">
                                    <th style="text-align: left">
                                      #
                                    </th>
                                    <th style="text-align:left">
                                      Empleado
                                    </th>
                                    <th style="text-align:left">
                                      Cargo
                                    </th>
                                    <th style="text-align:left">
                                      Centro de operación
                                    </th>
                                    <th style="text-align: center">
                                      Retirar
                                    </th>
                                  </tr>
                                </thead>

                                <tbody>
                                  <?php
                                  $u = 1;
                                  $DatosEmpleados = PanelGrupos::getGrupoEmpleados($DatGru->id_grupo);
                                  ?>

                                  @foreach($DatosEmpleados as $DatEmp)
                                    <tr class="message-unread">
                                      <td style="text-align:left;">
                                        <font color="#2A2F43">
                                          <?php
                                          print $u;
                                          $u++;
                                          ?>
                                        </font>
                                      </td>

                                      <td style="text-align:left;">
                                        <i class="fa fa-user fa-lg" style="color:#6CBCED;"></i>
                                        &nbsp;
                                        <font color="#2A2F43">
                                          <b>
                                            <?=$DatEmp->primer_nombre?>
                                            <?=$DatEmp->ot_nombre?>
                                            <?=$DatEmp->primer_apellido?>
                                            <?=$DatEmp->ot_apellido?>
                                          </b>
                                        </font>
                                      </td>

                                      <?php
                                      $Cargo = PanelCargos::getCargo($DatEmp->cargo);
                                      ?>
                                      <td style="text-align:left;">
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
                                      $Centro = PanelCentrosOp::getCentroOp($DatEmp->centro_op);
                                      ?>
                                      <td style="text-align:left;">
                                        @foreach($Centro as $DatCentro)
                                          <font color="#2A2F43">
                                            <?=$DatCentro->descripcion?>
                                          </font>
                                        @endforeach
                                      </td>

                                      <td style="text-align:center">
                                        <button type="button" class="btn btn-default light" onclick="BORRAR('<?=$DatEmp->id_empleado?>', '<?=$DatEmp->primer_nombre?>', '<?=$DatEmp->ot_nombre?>')" title="Retirar empleado">
                                          <i class="fa fa-trash fa-lg" style="color:#F6565A;"></i>
                                        </button>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                              </table>

                              {!! Form::open(array('action' => 'Requerimientos\GruposRequerimientosPanelController@EmpleadosGruposDesasociarDB', 'class' => 'form', 'id'=>'form-wizard', 'name' => 'frmenvio')) !!}
                                {!! Form::hidden('login', $DatLog->login) !!}
                                {!! Form::hidden('grupo', $DatGru->id_grupo) !!}
                                {!! Form::hidden('empleado', '') !!}
                              {!! Form::close() !!}

                              <script language="javascript" type="text/javascript">
                                function MASINFO()
                                 {
                                  tbody = document.getElementById('tbempleados');
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

                                function BORRAR(empleado, nom1, nom2)
                                 {
                                  var id1 = empleado;
                                  var id2 = nom1;
                                  var id3 = nom2;

                                  if(!(confirm("Confirme el retiro del empleado ("+id2+" "+id3+") asociado al grupo.")))
                                    return false;

                                  frm = document.forms["frmenvio"];
                                  frm.empleado.value = id1;
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
        <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js')}}"></script>

        <!-- -------------- JvectorMap Plugin -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js')}}"></script>

        <!-- -------------- HighCharts Plugin -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/plugins/highcharts/highcharts.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/plugins/c3charts/d3.min.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/plugins/c3charts/c3.min.js')}}"></script>

        <!-- -------------- Theme Scripts -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/utility/utility.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/demo/demo.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/main.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/demo/widgets_sidebar.js')}}"></script>
        <script src="{{ asset ('/panelfiles/assets/js/pages/dashboard2.js')}}"></script>

        <!-- -------------- Page JS -------------- -->
        <script src="{{ asset ('/panelfiles/assets/js/demo/charts/highcharts.js')}}"></script>

        <!-- -------------- /Scripts -------------- -->
      </body>
    </html>
  @endforeach
@endforeach
