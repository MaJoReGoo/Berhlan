<?php
$server = '/Berhlan/public';

use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Disciplinarios\PanelTipofaltas;
use App\Models\Disciplinarios\PanelMotivos;
use App\Models\Disciplinarios\PanelSolicitudes;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Procesos disciplinarios | Atender procesos
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
                  <a href="<?=$server?>/panel/disciplinarios/atender" title="Procesos disciplinarios > Atender procesos">
                    <font color="#34495e">
                      Procesos disciplinarios > Atender procesos >
                    </font>
                    <font color="#b4c056">
                      Solicitud <?=$DatosSolicitud[0]->id_solicitud?>
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/disciplinarios/atender" class="btn btn-primary btn-sm ml10" title="Procesos disciplinarios > Atender procesos">
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
                            Solicitud PD-<?=$DatosSolicitud[0]->id_solicitud?>
                          </th>
                        </tr>
                      </thead>

                      <tr>
                        <td>
                          <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Fecha de solicitud:
                              </th>
                              <td style="text-align:left">
                                <?=$DatosSolicitud[0]->fecha_solicita?>
                              </td>

                              <th style="text-align:left">
                                Solicitado por:
                              </th>
                              <td style="text-align:left">
                                <?php
                                $empleadosol = PanelEmpleados::getEmpleado($DatosSolicitud[0]->usr_solicita);
                                echo $empleadosol[0]->primer_nombre;
                                echo " ";
                                echo $empleadosol[0]->ot_nombre;
                                echo " ";
                                echo $empleadosol[0]->primer_apellido;
                                echo " ";
                                echo $empleadosol[0]->ot_apellido;
                                ?>
                              </td>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Centro de operación:
                              </th>
                              <td style="text-align:left">
                                <?php
                                $empleadofal = PanelEmpleados::getEmpleado($DatosSolicitud[0]->colaborador);
                                $centro      = PanelCentrosOp::getCentroOp($empleadofal[0]->centro_op);
                                echo $centro[0]->descripcion;
                                ?>
                              </td>

                              <th style="text-align:left">
                                Colaborador que cometió la falta:
                              </th>
                              <td style="text-align:left">
                                <?php
                                echo "<font color=\"red\">";
                                  echo $empleadofal[0]->identificacion;
                                  echo " - ";
                                  echo $empleadofal[0]->primer_nombre;
                                  echo " ";
                                  echo $empleadofal[0]->ot_nombre;
                                  echo " ";
                                  echo $empleadofal[0]->primer_apellido;
                                  echo " ";
                                  echo $empleadofal[0]->ot_apellido;
                                echo "</font>";
                                echo "<br>";
                                $cargo = PanelCargos::getCargo($empleadofal[0]->cargo);
                                echo $cargo[0]->descripcion;
                                echo "<br>";
                                $Area = PanelAreas::getArea($cargo[0]->area);
                                echo $Area[0]->descripcion." - ";
                                $Empresa = PanelEmpresas::getEmpresa($Area[0]->empresa);
                                echo $Empresa[0]->nombre;
                                ?>
                              </td>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Tipo de falta:
                              </th>
                              <td style="text-align:left">
                                <?php
                                $Faltas = PanelTipofaltas::Tipofalta($DatosSolicitud[0]->tipo_falta);
                                echo $Faltas[0]->descripcion;
                                ?>
                              </td>

                              <th style="text-align:left">
                                Fecha en que se cometió la falta:
                              </th>
                              <td style="text-align:left">
                                <?=$DatosSolicitud[0]->fecha_falta?>
                              </td>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Fecha conocimiento de falta:
                              </th>
                              <td style="text-align:left">
                                <?=$DatosSolicitud[0]->fecha_conocimiento?>
                              </td>

                              <th style="text-align:left">
                                Causa de la solicitud:
                              </th>
                              <td style="text-align:justify;">
                                <?=$DatosSolicitud[0]->causa?>
                              </td>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Testigos:
                              </th>
                              <td style="text-align:justify;">
                                <?=$DatosSolicitud[0]->testigos?>
                              </td>

                              <th style="text-align:left">
                                Pruebas (url):
                              </th>
                              <td style="text-align:left;">
                                <?php
                                $ruta = $DatosSolicitud[0]->pruebas;
                                if($ruta != "")
                                 {
                                  echo "<a href=\"$ruta\" title=\"Enlace a pruebas\" target=\"_blank\">";
                                    echo $ruta;
                                  echo "</a>";
                                 }
                                else
                                 {
                                  echo "Sin enlace";
                                 }
                                ?>
                              </td>
                            </tr>

                            <tr style="background-color: #F8F8F8; color:#000000">
                              <th style="text-align:left">
                                Textos:
                              </th>
                              <td style="text-align:left;" colspan="3">
                                <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.open('<?=$server?>/panel/disciplinarios/textos/<?=$DatosSolicitud[0]->id_solicitud?>','_blank')" title="Citación - Acta - Decisión">
                                  <i class="fa fa-file-word-o fa-lg" style="color:#226dbd;"></i>
                                </button>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
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
                        <tr>
                          <th style="background-color:#67d3e0; color:#34495e; text-align:left;">
                            Reclasificar solicitud PD-<?=$DatosSolicitud[0]->id_solicitud?>
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>
                            <div class="allcp-form">
                              {!! Form::open(array('action' => 'Disciplinarios\AtenderDisciplinariosPanelController@ReclasificarDB', 'class' => 'form', 'id'=>'form-wizard')) !!}
                                {!! Form::hidden('solicitud', $DatosSolicitud[0]->id_solicitud) !!}
                                <div class="row">
                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Tipo de falta
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="falta" id="falta" required>
                                        <?php
                                        $Falta = PanelTipofaltas::Tipofalta($DatosSolicitud[0]->tipo_falta);
                                        $idfalta = $Falta[0]->id_tipofalta;
                                        echo "<option value=\"$idfalta\">";
                                          echo $Falta[0]->descripcion;
                                        echo "</option>";

                                        $Faltas = PanelTipofaltas::TipofaltasActivas();
                                        ?>
                                        @foreach($Faltas as $DatFal)
                                          <option value="<?=$DatFal->id_tipofalta?>">
                                            <?=$DatFal->descripcion?>
                                          </option>
                                        @endforeach
                                      </select>
                                      <i class="arrow"></i>
                                    </label>
                                  </div>

                                  <div class="col-md-2">
                                    <br><br>
                                    {!! Form::submit('Reclasificar', array('class'=>'button')) !!}
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
                        <tr>
                          <th style="background-color:#67d3e0; color:#34495e; text-align:left;">
                            Atender solicitud PD-<?=$DatosSolicitud[0]->id_solicitud?>
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>
                            <div class="allcp-form">
                              {!! Form::open(array('action' => 'Disciplinarios\AtenderDisciplinariosPanelController@AtenderProcesarDB', 'class' => 'form', 'id'=>'form-wizard')) !!}
                                {!! Form::hidden('solicitud', $DatosSolicitud[0]->id_solicitud) !!}
                                <div class="row">
                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Motivo para cierre
                                      </b>
                                    </label>
                                    <label class="field select">
                                      <select name="motivo" id="motivo" required onblur="DIAS('')">
                                        <option value="">
                                          * Motivo para cierre
                                        </option>
                                        <?php
                                        $Motivos = PanelMotivos::MotivosActivos();
                                        ?>
                                        @foreach($Motivos as $DatMot)
                                          <option value="<?=$DatMot->id_motivocierre?>">
                                            <?=$DatMot->descripcion?>
                                          </option>
                                        @endforeach
                                      </select>
                                      <i class="arrow"></i>
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <label style="color: #34495e">
                                      <b>
                                        Días de suspensión
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::number('dias', null, array('required', 'id'=>'dias', 'class'=>'gui-input', 'placeholder'=>'* Días de suspensión', 'max'=>'999', 'min'=>'1', 'disabled')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-calendar"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-4">
                                    <label style="color:#34495e;">
                                      <b>
                                        Fecha (llamado a descargos / medida correctiva)
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::date('fecha', null, array('required', 'id'=>'fecha', 'class'=>'gui-input', 'maxlength'=>'10')) !!}
                                    </label>
                                  </div>
                                </div>

                                <div class="row">
                                  <br>
                                  <div class="col-md-6">
                                    <label style="color: #34495e">
                                      <b>
                                        Resultado
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::textarea('resultado', '', array('required', 'id'=>'resultado', 'class'=>'gui-input', 'style'=>'height: 80px; resize: vertical;',
                                         'placeholder'=>'* Resultado del proceso')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-reorder"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-6">
                                    <label style="color: #34495e">
                                      <b>
                                        Observaciones
                                      </b>
                                    </label>
                                    <label class="field prepend-icon">
                                      {!! Form::textarea('observaciones', '', array('', 'id'=>'observaciones', 'class'=>'gui-input', 'style'=>'height: 80px; resize: vertical;',
                                         'placeholder'=>'Observaciones pertinentes')) !!}
                                      <label for="username" class="field-icon">
                                        <i class="fa fa-reorder"></i>
                                      </label>
                                    </label>
                                  </div>

                                  <div class="col-md-12">
                                    <br>
                                    {!! Form::submit('Cerrar proceso', array('class'=>'button')) !!}
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

              <script language="javascript" type="text/javascript">
              function DIAS()
               {
                motivo = document.getElementById('motivo');
                dias   = document.getElementById('dias');
                if(motivo.value == 1)
                 {
                  dias.disabled = '';
                 }
                else
                 {
                  dias.disabled = 'disabled';
                 }
               }
              </script>

              <?php
              $DatosSolUsuario = PanelSolicitudes::FaltasColaborador($DatosSolicitud[0]->colaborador, $DatosSolicitud[0]->id_solicitud);
              $a = 0;
              $u = 1;
              ?>
              @foreach($DatosSolUsuario as $DatSol)
                <?php
                $a++;
                ?>
              @endforeach

              <?php
              if($a > 0)
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
                            <th>
                              Otros procesos del colaborador
                            </th>
                          </tr>
                        </thead>

                        <tr>
                          <td colspan="2">
                            <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                              <thead>
                                <tr style="background-color: #F8F8F8; color:#000000">
                                  <th style="text-align:left">
                                    #
                                  </th>
                                  <th style="text-align:center;">
                                    P.D.
                                  </th>
                                  <th style="text-align:center;">
                                    Tipo de falta
                                  </th>
                                  <th style="text-align: center">
                                    Fecha de la falta
                                  </th>
                                  <th style="text-align:center;">
                                    Solicitado por
                                  </th>
                                  <th style="text-align: center">
                                    Fecha solicitud
                                  </th>
                                  <th style="text-align: center">
                                    Estado
                                  </th>
                                  <th style="text-align: center">
                                    Causa
                                  </th>
                                  <th style="text-align: center">
                                    Motivo de cierre
                                  </th>
                                  <th style="text-align: center">
                                    Más info.
                                  </th>
                                </tr>
                              </thead>

                              <tbody>
                                @foreach($DatosSolUsuario as $DatSol)
                                  <tr class="message-unread">
                                    <td style="text-align:left">
                                      <font color="#2A2F43">
                                        <?php
                                        print $u;
                                        $u++;
                                        ?>
                                      </font>
                                    </td>

                                    <td style="text-align:center;" nowrap>
                                      <font color="#2A2F43">
                                        <b>
                                          PD-<?=$DatSol->id_solicitud?>
                                        </b>
                                      </font>
                                    </td>

                                    <?php
                                    $Faltas = PanelTipofaltas::Tipofalta($DatSol->tipo_falta);
                                    ?>
                                    <td style="text-align:center">
                                      <font color="#2A2F43">
                                        <?=$Faltas[0]->descripcion?>
                                      </font>
                                    </td>

                                    <td style="text-align:center">
                                      <font color="#2A2F43">
                                        <?=$DatSol->fecha_falta?>
                                      </font>
                                    </td>

                                    <td style="text-align:center;">
                                      <font color="#2A2F43">
                                        <?php
                                        $empleado1 = PanelEmpleados::getEmpleado($DatSol->usr_solicita);
                                        echo $empleado1[0]->primer_nombre;
                                        echo " ";
                                        echo $empleado1[0]->ot_nombre;
                                        echo " ";
                                        echo $empleado1[0]->primer_apellido;
                                        echo " ";
                                        echo $empleado1[0]->ot_apellido;
                                        ?>
                                      </font>
                                    </td>

                                    <td style="text-align:center">
                                      <font color="#2A2F43">
                                        <?=$DatSol->fecha_solicita?>
                                      </font>
                                    </td>

                                    <td style="text-align:center">
                                      <font color="#2A2F43">
                                        <?php
                                        $estado = $DatSol->estado;
                                        if($estado == 1)
                                         {
                                          echo "<font color=\"red\">";
                                            echo "En proceso";
                                          echo "</font>";
                                         }
                                        else if($estado == 0)
                                         {
                                          echo "Atendida, finalizada";
                                         }
                                        ?>
                                      </font>
                                    </td>

                                    <td style="text-align:justify;">
                                      <font color="#2A2F43">
                                        <?=$DatSol->causa?>
                                      </font>
                                    </td>

                                    <td style="text-align:center;">
                                      <font color="#2A2F43">
                                        <?php
                                        if($DatSol->motivo_cierre > 0)
                                         {
                                          $motivo = PanelMotivos::getMotivo($DatSol->motivo_cierre);
                                          echo $motivo[0]->descripcion;
                                         }
                                        else
                                         {
                                          echo "Pendiente";
                                         }
                                        ?>
                                      </font>
                                    </td>

                                    <td style="text-align: center">
                                      <button type="button" class="btn btn-default light" onclick="window.location.href='<?=$server?>/panel/disciplinarios/consultaadm/masinfo/<?=$DatSol->id_solicitud?>'" title="Más información">
                                        <i class="fa fa-exclamation-circle fa-lg" style="color:#AEBF25;"></i>
                                      </button>
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </table>
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