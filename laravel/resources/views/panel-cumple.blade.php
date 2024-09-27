<?php


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
        Intranet | Cumpleaños
      </title>
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

      <!-- -------------- Plugins -------------- -->
      <link rel="stylesheet" type="text/css" href="<?=$server?>/panelfiles/assets/js/plugins/c3charts/c3.min.css">

      <!-- -------------- Favicon -------------- -->
      <link rel="shortcut icon" href="<?=$server?>/panelfiles/assets/img/favicon.ico">

      <!-- Alerts Personalizados -->

      <!-- This is what you need -->

       <script src="<?=$server?>/panelfiles/sweetalert/dist/sweetalert.min.js"></script>

       <link rel="stylesheet" href="<?=$server?>/panelfiles/sweetalert/dist/sweetalert.css">

      <!-- Alerts Personalizados -->


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
                  <a>
                    <font color="#34495e">
                      Cumpleaños
                    </font>
                  </a>
                </li>
              </ul>
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
                  <div style="padding-left: 10px; text-align: center;">
                    <?php
                    $mesanterior = $Mes - 1;
                    if($mesanterior == 0)
                     {
                      $mesanterior = 12;
                      $anoanterior = $Ano - 1;
                     }
                    else
                     {
                      $anoanterior = $Ano;
                     }

                    if($mesanterior < 10)
                      $mesanterior = "0".$mesanterior;

                    $fechaanterior = $anoanterior.$mesanterior;

                    $mesposterior = $Mes + 1;
                    if($mesposterior == 13)
                     {
                      $mesposterior = 1;
                      $anoposterior = $Ano + 1;
                     }
                    else
                     {
                      $anoposterior = $Ano;
                     }

                    if($mesposterior < 10)
                      $mesposterior = "0".$mesposterior;

                    $fechaposterior = $anoposterior.$mesposterior;
                    ?>

                    <button type="button" style="background:white;" class="btn btn-default light" onclick="window.location.href='<?=$server?>/panel/cumple/<?=$fechaanterior?>'" title="Mes anterior">
                      <i class="fa fa-chevron-circle-left fa-lg" style="color:#AEBF25;"></i>
                    </button>
                    &nbsp;&nbsp;
                    <font size="4">
                      Cumpleaños mes de
                      <?php
                      echo "<b>";
                        if($Mes == 1)
                          echo "Enero";
                        else if($Mes == 2)
                          echo "Febrero";
                        else if($Mes == 3)
                          echo "Marzo";
                        else if($Mes == 4)
                          echo "Abril";
                        else if($Mes == 5)
                          echo "Mayo";
                        else if($Mes == 6)
                          echo "Junio";
                        else if($Mes == 7)
                          echo "Julio";
                        else if($Mes == 8)
                          echo "Agosto";
                        else if($Mes == 9)
                          echo "Septiembre";
                        else if($Mes == 10)
                          echo "Octubre";
                        else if($Mes == 11)
                          echo "Noviembre";
                        else if($Mes == 12)
                          echo "Diciembre";
                      echo "</b>";

                      echo " del ".$Ano;
                      ?>
                    </font>
                    &nbsp;&nbsp;
                    <button type="button" style="background:white;" class="btn btn-default light" onclick="window.location.href='<?=$server?>/panel/cumple/<?=$fechaposterior?>'" title="Siguiente mes">
                      <i class="fa fa-chevron-circle-right fa-lg" style="color:#AEBF25;"></i>
                    </button>
                  </div>

                  <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                    <thead>
                      <tr style="background-color: #F8F8F8">
                        <th style="text-align: center">
                          Foto
                        </th>
                        <th style="text-align: left">
                          Día
                        </th>
                        <th style="text-align: left">
                          Colaborador
                        </th>
                        <th style="text-align: left">
                          Centro de operación
                        </th>
                        <th style="text-align: left">
                          Cargo
                        </th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      $u = 0;
                      ?>
                      <!-- Vectorizo para ordenar por el campo día -->
                      @foreach($DatosCumple as $DatCum)
                        <?php
                        $identifi[$u] = $DatCum->identificacion;
                        $primerno[$u] = $DatCum->primer_nombre;
                        $otnombre[$u] = $DatCum->ot_nombre;
                        $primerap[$u] = $DatCum->primer_apellido;
                        $otapelli[$u] = $DatCum->ot_apellido;
                        $cargo[$u]    = $DatCum->cargo;
                        $centroop[$u] = $DatCum->centro_op;

                        $dia = $DatCum->fecha_nacimiento;
                        $dianacim[$u] = ($dia[8].$dia[9])*1;
                        $u++;
                        ?>
                      @endforeach

                      <?php
                      $n = 0;
                      //Si existen colaboradores se ordenan los vectores
                      if($u > 0)
                        array_multisort($dianacim, $primerno, $otnombre, $primerap, $otapelli, $identifi, $cargo, $centroop);

                      for($a=0;$a<$u;$a++)
                       {
                        if(($dianacim[$a] == date('d')) && ($Mes == (date('m')*1)) && ($Ano == date('Y')) && ($n == 0))
                         {
                          $n++;
                          echo "<tr><td colspan=\"5\" id=\"p\"></td></tr>";
                          echo "<script language=\"javascript\" type=\"text/javascript\">";
                          echo "setTimeout(\"document.location.href='#p'\", 0);";
                          echo "</script>";
                         }
                        ?>

                        <tr class="message-unread">
                          <td style="text-align: right">
                             <?php
                            $ruta    = "/Berhlan/public/archivos/Empleados/".$identifi[$a].".jpg?".date('i:s');
                            $sinfoto = "/Berhlan/public/archivos/Empleados/sinimagen.jpg?".date('i:s');
                            ?>
                            <img src="/Berhlan/public/archivos/Empleados/sinimagen.jpg?" class="img-responsive mauto" style="width:50px; border-radius:6px; border:1;" />
                          </td>

                          <td style="text-align: left">
                            <font color="#2A2F43">
                              <?php
                              $dia    = $dianacim[$a];
                              $fec    = $Ano."-".$Mes."-".$dia;
                              $numdia = strftime("%w", strtotime($fec));

                              if($numdia == 0)
                                echo "Domingo";
                              else if ($numdia == 1)
                                echo "Lunes";
                              else if ($numdia == 2)
                                echo "Martes";
                              else if ($numdia == 3)
                                echo "Mi&eacute;rcoles";
                              else if ($numdia == 4)
                                echo "Jueves";
                              else if ($numdia == 5)
                                echo "Viernes";
                              else if ($numdia == 6)
                                echo "S&aacute;bado";
                              echo " ".$dia;
                              ?>
                            </font>
                          </td>

                          <td style="text-align: left ">
                            <font color="#2A2F43">
                              <?=$primerno[$a]." ".$otnombre[$a]." ".$primerap[$a]." ".$otapelli[$a]?>
                            </font>
                          </td>

                          <?php
                          $Centro = PanelCentrosOp::getCentroOp($centroop[$a]);
                          ?>
                          <td style="text-align: left">
                            @foreach($Centro as $DatCentro)
                              <font color="#2A2F43">
                                <?=$DatCentro->descripcion?>
                              </font>
                            @endforeach
                          </td>

                          <?php
                          $Cargo = PanelCargos::getCargo($cargo[$a]);
                          ?>
                          <td style="text-align: left">
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
                        </tr>
                        <?php
                       }
                      ?>
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
