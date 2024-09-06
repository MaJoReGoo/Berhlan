<?php
$server ='/Berhlan/public';

use App\Models\Procesos\PanelMacroProcesos;
use App\Models\Procesos\PanelProcesos;
use App\Models\Procesos\PanelSubProcesos;
use App\Models\Parametrizacion\PanelUsuarios;
?>

@foreach($DatosUsuario as $DatLog)
  @foreach($DatosProceso as $DatPro)
    <!DOCTYPE html>
    <html>
      <head>
        <!-- -------------- Meta and Title -------------- -->
        <meta charset="utf-8">
        <title>
          Intranet | Modificar proceso
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
                    <a href="<?=$server?>/panel/procesos/procesos" title="Procesos internos > Procesos">
                      <font color="#34495e">
                        Procesos internos > Procesos >
                      </font>
                      <font color="#b4c056">
                        Modificar
                      </font>
                    </a>
                  </li>
                </ul>
              </div>

              <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                <a href="<?=$server?>/panel/procesos/procesos" class="btn btn-primary btn-sm ml10" title="Procesos">
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
                        <?php
                        $DatosMacro = PanelMacroProcesos::getMacroProceso($DatPro->macroproceso);
                        $fondo      = $DatosMacro[0]->fondo;
                        ?>
                        <tr>
                          <td>
                            <button type="button" style="background:#<?=$fondo?>; cursor:default;" class="btn btn-default light">
                              <b>
                                <font color="white">
                                  <?=$DatosMacro[0]->descripcion?>
                                </font>
                              </b>
                            </button>
                            &nbsp;
                            <b>
                              <font color="#000000">
                                <?=$DatPro->descripcion?>
                              </font>
                            </b>
                          </td>

                          <td align="right">
                            <button type="button"  style="background:#28B463;" class="btn btn-default light" onclick="window.location.href='<?=$server?>/archivos/Procesos/<?=$DatPro->ruta1."?".date('i:s')?>'">
                              <i class="fa fa-file-excel-o fa-lg" style="color:white;"></i>
                            </button>
                          </td>

                          <td>
                            <b>
                              <font size="1" color="#000000">
                                <?=$DatPro->ruta1?>
                                <br>
                                <?=$DatPro->fecha1?>
                              </font>
                            </b>
                          </td>

                          <td align="right" style="vertical-align: top;">
                            <button type="button" class="btn btn-default light" onclick="MASINFO()">
                              <i id="btnmasinfo" class="fa fa-sort-amount-desc fa-lg" style="color:#AEBF25;" title="Más información"></i>
                            </button>
                          </td>
                        </tr>

                        <tr id="masinfo" style="display:none;">
                          <td align="center">
                            <?php
                            $DatosLogs = PanelProcesos::getProcesoLogs($DatPro->id_proceso);
                            $e = 1;
                            if(sizeof($DatosLogs) == 0)
                              $largo = "45px";
                            else
                              $largo = "280px";
                            ?>

                            <div style="height:<?=$largo?>; width:100%; overflow:auto;">
                              <table id="message-table" class="table allcp-form theme-warning br-t">
                                <tr>
                                  <td colspan="3">
                                    <font size="3" color="#000000">
                                      <b>
                                        Detalle de modificaciones
                                      </b>
                                    </font>
                                  </td>
                                </tr>

                                @foreach($DatosLogs as $DatLogs)
                                  <tr>
                                    <td>
                                      <font size="1" color="#000000">
                                        <?php
                                        echo $e++;
                                        ?>
                                      </font>
                                    </td>

                                    <td>
                                      <div style="text-align: justify">
                                        <font color="#000000">
                                          <?=$DatLogs->observaciones?>
                                        </font>
                                      </div>
                                    </td>

                                    <td align="center" nowrap="">
                                      <font size="1" color="#000000">
                                        <?php
                                        $Login = PanelUsuarios::getUsuario($DatLogs->usuario);
                                        echo $Login[0]->login;
                                        ?>
                                        <br>
                                        <?=$DatLogs->fecha?>
                                      </font>
                                    </td>
                                  </tr>
                                @endforeach
                              </table>
                            </div>
                          </td>

                          <td style="vertical-align: top;" align="right">
                            <?php
                            if($DatPro->ruta2 != '')
                             {
                              ?>
                              <button type="button"  style="background:#28B463;" class="btn btn-default light" onclick="window.location.href='<?=$server?>/archivos/Procesos/<?=$DatPro->ruta2?>'">
                                <i class="fa fa-file-excel-o fa-lg" style="color:white;"></i>
                              </button>
                              <?php
                             }
                            ?>
                          </td>

                          <th style="vertical-align: top;" nowrap="" colspan="2">
                            <b>
                              <font size="2" color="#000000">
                                Versión anterior
                              </font>
                              <font size="1" color="#000000">
                                <br>
                                <?=$DatPro->ruta2?>
                                <br>
                                <?=$DatPro->fecha2?>
                              </font>
                            </b>
                          </td>
                        </tr>

                      </table>
                      <script language="javascript" type="text/javascript">
                        function MASINFO()
                         {
                          tr = document.getElementById('masinfo');
                          id = document.getElementById('btnmasinfo');
                          if(tr.style.display == '')
                           {
                            tr.style.display = 'none';
                            id.className     = 'fa fa-sort-amount-desc fa-lg';
                            id.title         = "Más información";
                            }
                           else
                            {
                             tr.style.display = '';
                             id.className     = 'fa fa-sort-up fa-lg';
                             id.title         = "Menos información";
                           }
                         }
                      </script>
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
                          <tr style="background-color:#67d3e0">
                            <th style="color:black; text-align:left;">
                              Actualice la información del proceso
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr>
                            <td>
                              <div class="allcp-form">
                                {!! Form::open(array('action' => 'Procesos\ProcesosPanelController@ProcesosModificarDB', 'class' => 'form', 'id'=>'form-wizard', 'files' => true)) !!}
                                  {!! Form::hidden('login', $DatLog->login) !!}
                                  {!! Form::hidden('id_proceso', $DatPro->id_proceso) !!}

                                  <div class="row">
                                    <div class="col-md-5">
                                      <label style="color: #34495e">
                                        <b>
                                          Descripción
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::text('descripcion', $DatPro->descripcion, array('required', 'id'=>'descripcion', 'class'=>'gui-input', 'placeholder'=>'* Proceso')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-server"></i>
                                        </label>
                                      </label>
                                    </div>

                                    <div class="col-md-2">
                                      <label style="color: #34495e">
                                        <b>
                                          Color
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::text('fondo', $DatPro->fondo, array('required', 'id'=>'fondo', 'class'=>'gui-input', 'placeholder'=>'* Color', 'maxlength'=>6, 'minlength'=>6)) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-paint-brush"></i>
                                        </label>
                                      </label>
                                    </div>

                                    <div class="col-md-2">
                                      <label style="color: #34495e">
                                        <b>
                                          Posición
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::number('posicion', $DatPro->posicion, array('required', 'id'=>'posicion', 'class'=>'gui-input', 'placeholder'=>'* Posición', 'max'=>99)) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-exchange"></i>
                                        </label>
                                      </label>
                                    </div>

                                  <div class="row">
                                    <br>
                                    <div class="col-md-5">
                                      <label style="color: #34495e">
                                        <b>
                                          Observaciones del cambio
                                        </b>
                                      </label>
                                      <label class="field prepend-icon">
                                        {!! Form::textarea('observaciones', '', array('cols' => 6, 'required', 'id'=>'observaciones', 'class'=>'gui-input', 'style'=>'height: 55px;', 'placeholder'=>'* Explique el cambio realizado')) !!}
                                        <label for="username" class="field-icon">
                                          <i class="fa fa-reorder"></i>
                                        </label>
                                      </label>
                                    </div>

                                    <div class="col-md-4">
                                      <label style="color: #34495e">
                                        <b>
                                          Archivo
                                        </b>
                                      </label>
                                      <label class="field prepend-icon append-button file">
                                        <span class="button">
                                          Archivo
                                        </span>
                                        {!! Form::file('file1', array('id'=>'file1', 'class'=>'gui-file', 'onChange'=>"document.getElementById('uploader1').value = this.value;")) !!}
                                        {!! Form::text('uploader1', null, array('id'=>'uploader1', 'class'=>'gui-input', 'placeholder'=>'Seleccione el archivo')) !!}
                                        <label class="field-icon">
                                          <i class="fa fa-cloud-upload"></i>
                                        </label>
                                      </label>
                                    </div>
                                    
                                  </div>

                                  <div class="row">
                                    <div class="col-md-2" align="left">
                                      <br>
                                      {!! Form::submit('Modificar proceso', array('class'=>'button')) !!}
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
                              <button type="button" class="btn btn-default light" onclick="MASINFO1()">
                                <i id="btnmasinfo1" class="fa fa-sort-amount-desc fa-lg" style="color:#AEBF25;" title="Más información"></i>
                              </button>
                              &nbsp;
                              Subprocesos asociados
                            </th>

                            <td align="right">
                              <button type="button" class="btn btn-default light" onclick="window.location.href='<?=$server?>/panel/procesos/subprocesos/agregar/<?=$DatPro->id_proceso?>'" title="Nuevo subproceso">
                                <span class="fa fa-plus pr5" style="color:#AEBF25;"></span>
                                <span class="fa fa-credit-card pr5" style="color:#AEBF25;"></span>
                              </button>
                            </td>
                          </tr>
                        </thead>

                        <tbody id="tbsubproceso" style="display:none;">
                          <tr>
                            <td colspan="2">
                              <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                                <thead>
                                  <tr style="background-color: #F8F8F8; color:#000000">
                                    <th style="text-align: left">
                                      #
                                    </th>
                                    <th style="text-align: left">
                                      Subproceso
                                    </th>
                                    <th style="text-align: center">
                                      Posición
                                    </th>
                                    <th style="text-align: center">
                                      Modificar
                                    </th>
                                    <th style="text-align: center">
                                      Eliminar
                                    </th>
                                  </tr>
                                </thead>

                                <tbody>
                                  <?php
                                  $u = 1;
                                  $DatosSubprocesos = PanelSubProcesos::getSubProcesos($DatPro->id_proceso);
                                  ?>

                                  @foreach($DatosSubprocesos as $DatSub)
                                    <tr class="message-unread">
                                      <td style="text-align: left ">
                                        <font color="#2A2F43">
                                          <?php
                                          print $u;
                                          $u++;
                                          ?>
                                        </font>
                                      </td>

                                      <td style="text-align: left ">
                                        <i class="fa fa-minus fa-lg" style="color:#AEBF25"></i>
                                        &nbsp;
                                        <font color="#2A2F43">
                                          <b>
                                            <?=$DatSub->descripcion?>
                                          </b>
                                        </font>
                                      </td>

                                      <td style="text-align: center ">
                                        <font color="#2A2F43">
                                          <?=$DatSub->numero?>
                                        </font>
                                      </td>

                                      <td style="text-align: center">
                                        <button type="button" class="btn btn-default light" onclick="window.location.href='<?=$server?>/panel/procesos/subprocesos/modificar/<?=$DatSub->id_subproceso?>'" title="Modificar subproceso">
                                          <i class="fa fa-pencil fa-lg" style="color:#AEBF25;"></i>
                                        </button>
                                      </td>

                                      <td style="text-align: center">
                                        <button type="button" class="btn btn-default light" onclick="BORRAR('<?=$DatSub->id_subproceso?>', '<?=$DatSub->descripcion?>')" title="Eliminar subproceso">
                                          <i class="fa fa-trash fa-lg" style="color:#F6565A;"></i>
                                        </button>
                                      </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                              </table>

                              {!! Form::open(array('action' => 'Procesos\SubProcesosPanelController@SubProcesosEliminarDB', 'class' => 'form', 'id'=>'form-wizard', 'name' => 'frmenvio')) !!}
                                {!! Form::hidden('login', $DatLog->login) !!}
                                {!! Form::hidden('id_subproceso', '') !!}
                              {!! Form::close() !!}

                              <script language="javascript" type="text/javascript">
                                function MASINFO1()
                                 {
                                  tbody = document.getElementById('tbsubproceso');
                                  id    = document.getElementById('btnmasinfo1');
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

                                function BORRAR(sub, nom)
                                 {
                                  var id  = sub;
                                  var id1 = nom;

                                  if(!(confirm("Confirme el retiro del subproceso ("+id1+").")))
                                    return false;

                                  frm = document.forms["frmenvio"];
                                  frm.id_subproceso.value = id;
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

        </d
iv>
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
