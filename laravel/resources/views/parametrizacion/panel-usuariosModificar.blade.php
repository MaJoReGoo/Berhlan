<?php
$server ='/Berhlan/public';
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelUsuarios;
?>

@foreach($DatosUsuario as $DatLog)
  @foreach($DatosUsr as $DatUsr)
    <!DOCTYPE html>
    <html>
      <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
          Intranet | Modificar usuario
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
                    <a href="<?=$server?>/panel/parametrizacion/usuarios" title="Parametrización > Usuarios">
                      <font color="#34495e">
                        Parametrización > Usuarios >
                      </font>
                      <font color="#b4c056">
                        Modificar
                      </font>
                    </a>
                  </li>
                </ul>
              </div>

              <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                <a href="<?=$server?>/panel/parametrizacion/usuarios" class="btn btn-primary btn-sm ml10" title="Parametrización > Usuarios">
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
                              Actualice los datos del usuario
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr>
                            <td>
                              <div class="allcp-form">
                                {!! Form::open(array('action' => 'Parametrizacion\UsuariosPanelController@UsuariosModificarDB', 'class' => 'form', 'id'=>'form-wizard', 'files' => true)) !!}
                                  {!! Form::hidden('loglogin', $DatLog->login) !!}
                                  {!! Form::hidden('id_usuario', $DatUsr->id_usuario) !!}

                                  <div class="section">
                                    <?php
                                    $Empleado = PanelEmpleados::getEmpleado($DatUsr->empleado);
                                    ?>
                                    <div class="col-md-5">
                                      <label style="color: #4ECCDB">
                                        Empleado
                                      </label>
                                      <label class="field prepend-icon" style="color: #2A2F43">
                                        <br>
                                        @foreach($Empleado as $DatEmpleado)
                                          <?php
                                          echo $DatEmpleado->identificacion;
                                          echo " - ";
                                          echo $DatEmpleado->primer_nombre;
                                          echo " ";
                                          echo $DatEmpleado->ot_nombre;
                                          echo " ";
                                          echo $DatEmpleado->primer_apellido;
                                          echo " ";
                                          echo $DatEmpleado->ot_apellido;
                                          ?>
                                        @endforeach
                                      </label>
                                    </div>

                                    <div class="col-md-5">
                                      <label style="color: #4ECCDB">
                                        Login
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::text('login', $DatUsr->login, array('required', 'id'=>'login', 'class'=>'gui-input', 'placeholder'=>'* Login')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-tag"></i>
                                        </label>
                                      </label>
                                    </div>
                                  </div>

                                  <div class="section">
                                    <div class="col-md-5">
                                      <br>
                                      <label style="color: #4ECCDB">
                                        Master
                                      </label>
                                      <label class="field select">
                                        <select name="master" id="master" required>
                                          <option value="1" style="color:green;"
                                          <?php
                                          if($DatUsr->master == 1)
                                            echo " selected ";
                                          ?>
                                          >Sí</option>

                                          <option value="0" style="color:red;"
                                          <?php
                                          if($DatUsr->master == 0)
                                            echo " selected ";
                                          ?>
                                          >No</option>
                                        </select>
                                        <i class="arrow"></i>
                                      </label>
                                    </div>

                                    <div class="col-md-5">
                                      <br>
                                      <label style="color: #4ECCDB">
                                        Estado
                                      </label>
                                      <label class="field select">
                                        <select name="estado" id="estado" required>
                                          <?php
                                          if($Empleado[0]->estado == 1)
                                           {
                                            echo "<option value=\"1\" style=\"color:green;\" ";
                                            if($DatUsr->estado == 1)
                                              echo " selected ";
                                            echo ">Activo</option>";
                                           }

                                          echo "<option value=\"0\" style=\"color:red;\" ";
                                          if($DatUsr->estado == 0)
                                            echo " selected ";
                                          echo ">Inactivo</option>";
                                          ?>
                                        </select>
                                        <i class="arrow"></i>
                                      </label>
                                    </div>

                                    <div class="col-md-5">
                                      <br>
                                      {!! Form::submit('Modificar usuario', array('class'=>'button')) !!}
                                    </div>
                                  </div>
                                {!! Form::close() !!}

                                {!! Form::open(array('action' => 'Parametrizacion\UsuariosPanelController@UsuariosModificarPassDB', 'class' => 'form', 'id'=>'form-wizard', 'files' => true)) !!}
                                  {!! Form::hidden('loglogin', $DatLog->login) !!}
                                  {!! Form::hidden('id_usuario', $DatUsr->id_usuario) !!}
                                  {!! Form::hidden('empleado', $DatEmpleado->identificacion) !!}

                                  <div class="section">
                                    <div class="col-md-5">
                                      <br>
                                      {!! Form::submit('Reestablecer contraseña', array('class'=>'button')) !!}
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

                <?php
                //Si el usuario no es tipo master y esta activo
                if(($DatUsr->estado == 1) && ($DatUsr->master == 0) && ($DatLog->master == 1))
                 {
                  ?>
                  <br>

                  <div class="panel m3">
                    <!-- -------------- Message Body -------------- -->
                    <div class="nano-content">
                      <div class="table-responsive">
                        <table id="message-table" class="table allcp-form theme-warning br-t">
                          <thead>
                            <tr style="background-color:#39405a">
                              <th colspan="3">
                                Accesos en la INTRANET
                              </th>
                            </tr>
                          </thead>

                          <tbody>
                            {!! Form::open(array('action' => 'Parametrizacion\UsuariosPanelController@UsuariosModificarAccesosDB', 'class' => 'form', 'id'=>'form-wizard', 'files' => true)) !!}
                              {!! Form::hidden('id_usuario', $DatUsr->id_usuario) !!}
                              <?php
                              $Accesos = PanelUsuarios::getAccesos('0');
                              $a = 0;
                              $z = 0;
                              ?>
                              @foreach($Accesos as $DatAcc)
                                <tr>
                                  <td style="color:black; text-align:right" width="10">
                                    <?php
                                    $a++;
                                    echo $a;
                                    ?>
                                  </td>

                                  <td style="color:black; text-align:left;" colspan="2">
                                    <?php
                                    if($DatAcc->libre_acceso == 1)
                                     {
                                      ?>
                                      <label class="option block">
                                        {!! Form::checkbox('modulos[]', $DatAcc->id_menu, 'checked', array('disabled'=>true))!!}
                                        <span class="checkbox"></span><b><?=$DatAcc->nombre?></b>
                                      </label>
                                      <?php
                                     }
                                    else
                                     {
                                      $check = '';
                                      $ModUser = explode(',',$DatUsr->modulos);
                                      $NumModUser = count($ModUser);
                                      for($i=0; $i<$NumModUser; $i++)
                                       {
                                        if($ModUser[$i] == $DatAcc->id_menu)
                                         {
                                          $check = 'checked';
                                          $i = $NumModUser + 1;
                                         }
                                       }

                                      $funci = "VALIDA1(".$a.")";
                                      $nomid = "menu_".$a;
                                      ?>
                                      <label class="option block" style="color:#2133c6">
                                        {!! Form::checkbox('modulos[]', $DatAcc->id_menu, $check, array('id'=>$nomid, 'onclick' => $funci)) !!}
                                        <span class="checkbox"></span><b><?=$DatAcc->nombre?></b>
                                      </label>
                                      <?php
                                     }
                                    ?>
                                  </td>
                                </tr>

                                <?php
                                $AccesosHijo = PanelUsuarios::getAccesos($DatAcc->id_menu);
                                $b = 0;
                                ?>
                                @foreach($AccesosHijo as $DatAcH)
                                  <tr>
                                    <td>
                                    </td>

                                    <td style="color:black; text-align:left" width="10">
                                      <?php
                                      $b++;
                                      echo $a.".".$b;
                                      ?>
                                    </td>

                                    <td style="color:black; text-align:left">
                                      <?php
                                      if($DatAcH->libre_acceso == 1)
                                       {
                                        ?>
                                        <label class="option block">
                                          {!! Form::checkbox('modulos[]', $DatAcH->id_menu, 'checked', array('disabled'=>true))!!}
                                          <span class="checkbox"></span><?=$DatAcH->nombre?>
                                        </label>
                                        <?php
                                       }
                                      else
                                       {
                                        $check = '';
                                        $ModUser = explode(',',$DatUsr->modulos);
                                        $NumModUser = count($ModUser);
                                        for($i=0; $i<$NumModUser; $i++)
                                         {
                                          if($ModUser[$i] == $DatAcH->id_menu)
                                           {
                                            $check = 'checked';
                                            $i = $NumModUser + 1;
                                           }
                                         }

                                        $funci = "VALIDA2(".$a.",".$b.")";
                                        $nomid = "menu_".$a."_".$b;
                                        ?>
                                        <label class="option block" style="color:#2133c6">
                                          {!! Form::checkbox('modulos[]', $DatAcH->id_menu, $check, array('id'=>$nomid, 'onclick' => $funci)) !!}
                                          <span class="checkbox"></span><?=$DatAcH->nombre?>
                                        </label>
                                        <?php
                                       }
                                      ?>
                                    </td>
                                  </tr>
                                @endforeach
                              @endforeach

                              <tr>
                                <td colspan="3" style="text-align:center">
                                  {!! Form::submit('Actualizar permisos', array('class'=>'button')) !!}
                                </td>
                              </tr>
                            {!! Form::hidden('modulos[]', 1) !!}
                            {!! Form::close() !!}
                          </tbody>
                        </table>

                        <script language="javascript" type="text/javascript">
                          function VAL1(rr)
                           {
                            var id = rr;
                            alert("uno"+id);
                           }

                          function VAL2(rr, m)
                           {
                            var id = rr;
                            var id1 = m;
                            alert("uno"+id+id1);
                           }

                          function VALIDA1(idmenu)
                           {
                            var id = idmenu;
                            ch = document.getElementById('menu_'+id);
                            if(ch.checked == false)
                             {
                              for(a=1;a<100;a++)
                               {
                                ch1 = !!document.getElementById('menu_'+id+'_'+a);
                                if(ch1 == true)
                                 {
                                  ch1 = document.getElementById('menu_'+id+'_'+a);
                                  ch1.checked = false;
                                 }
                                else
                                 {
                                  a = 100;
                                 }
                               }
                             }
                           }

                          function VALIDA2(idmenu, idhijo)
                           {
                            var id1 = idmenu;
                            var id2 = idhijo;

                            ch1 = document.getElementById('menu_'+id1+'_'+id2);
                            if(ch1.checked == true)
                             {
                              ch = document.getElementById('menu_'+id1);
                              ch.checked = true;
                             }
                            else
                             {
                              var b = 0;
                              for(a=1;a<100;a++)
                               {
                                ch1 = !!document.getElementById('menu_'+id1+'_'+a);
                                if(ch1 == true)
                                 {
                                  ch1 = document.getElementById('menu_'+id1+'_'+a);
                                  if(ch1.checked == true)
                                   {
                                    b = 1;
                                    a = 100;
                                   }
                                 }
                                else
                                 {
                                  a = 100;
                                 }
                               }
                              if(b == 0)
                               {
                                ch = document.getElementById('menu_'+id1);
                                ch.checked = false;
                               }
                             }
                           }
                        </script>
                      </div>
                    </div>
                  </div>
                  <?php
                 }
                ?>
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