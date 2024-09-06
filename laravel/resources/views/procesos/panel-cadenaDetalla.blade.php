<?php
$server ='/Berhlan/public';

use App\Models\Procesos\PanelMacroProcesos;
use App\Models\Procesos\PanelSubProcesos;
use App\Models\Procesos\PanelDocumentos;
use App\Models\Procesos\PanelTiposDocumentos;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Procesos | <?=$DatosProceso[0]->descripcion?>
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
                  <a href="<?=$server?>/panel/procesos/cadena" title="Procesos internos > Cadena de valor">
                    <font color="#34495e">
                      Procesos internos > Cadena de valor >
                    </font>
                    <font color="#b4c056">
                      Mas información
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/procesos/cadena" class="btn btn-primary btn-sm ml10" title="Procesos internos > Cadena de valor">
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
                      $DatosMacro = PanelMacroProcesos::getMacroProceso($DatosProceso[0]->macroproceso);
                      $fondo      = $DatosMacro[0]->fondo;
                      $fondo1     = $DatosProceso[0]->fondo;
                      ?>
                      <tr>
                        <td>
                          <button type="button" style="background:#<?=$fondo?>; cursor:default; color:white; text-shadow: 0 0 0.1em black, 0 0 0.1em black" class="btn btn-default light">
                            <b>
                              Macroproceso
                            </b>
                          </button>
                          &nbsp;&nbsp;&nbsp;&nbsp;
                          <b>
                            <?=$DatosMacro[0]->descripcion?>
                          </b>

                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                          <button type="button" style="background:#<?=$fondo1?>; cursor:default; color:white; text-shadow: 0 0 0.1em black, 0 0 0.1em black" class="btn btn-default light">
                            <b>
                              Proceso
                            </b>
                          </button>
                          &nbsp;&nbsp;&nbsp;&nbsp;
                          <b>
                            <?=$DatosProceso[0]->descripcion?>
                          </b>

                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                          <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="window.location.href='<?=$server?>/archivos/Procesos/<?=$DatosProceso[0]->ruta1."?".date('i:s')?>'" title="<?=$DatosProceso[0]->ruta1?>">
                            <i class="fa fa-file-excel-o fa-2x fa-lg" style="color:#28B463;"></i>
                          </button>
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
                        <tr style="background-color: #F1F1F1; color:#000000">
                          <th style="text-align:left">
                            <font size="2">
                              Subprocesos
                            </font>
                          </th>
                          <th style="text-align: center">
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        $u = 0;
                        $DatosSubprocesos = PanelSubProcesos::getSubProcesos($DatosProceso[0]->id_proceso);
                        ?>
                        @foreach($DatosSubprocesos as $DatSub) {{-- listar todos los subprocesos que tiene el proceso  --}}
                          <?php
                          $u++;
                          ?>
                          <tr class="message-unread">
                            <td style="text-align:left; background-color: white">
                              <font color="#2A2F43">
                                <b>
                                  <?=$DatSub->descripcion?>
                                </b>
                              </font>
                            </td>

                            <td style="text-align:right; background-color:white">
                              <button type="button" class="btn btn-default light" onclick="MASINFO('<?=$u?>')">
                                <i id="btnmasinfo_<?=$u?>" class="fa fa-plus fa-lg" style="color:#AEBF25;" title="Más información"></i>
                              </button>
                            </td>
                          </tr>

                          <?php
                          $Tipos = PanelTiposDocumentos::getTiposDocumentos();
                          $tip   = 0;
                          ?>

                          @foreach($Tipos as $DatTip){{-- LISTA LOS TIPOS DE DOCUMENTOS QUE TIENE EL SUBPROCESO --}}
                            <?php
                            $tip++;
                            $Documentos = PanelDocumentos::getDocumentosSubProcesoTipo($DatSub->id_subproceso, $DatTip->id_tipo);
                            $docu = 0;
                            $Ctdocu = 0;
                            ?>
                            @foreach($Documentos as $DatDoc) {{-- TRAE LA CANTIDA DE REGISTROS SEGUN LA CONSULTA PARA EL AUTOCREMNTAR DE CADA DOCUMENTO --}}
                              <?php
                              $Ctdocu++;
                              ?>
                            @endforeach

                            <tr id="trtipo_<?=$u?>_<?=$tip?>" style="display:none;">
                              <td style="text-align:left; background-color:white">
                                <button type="button" style="background:white; cursor:default;" class="btn btn-default light">
                                </button>
                                <font color="#001137">
                                  <?=$DatTip->descripcion?>
                                  <b>
                                    (<?=$Ctdocu?>)
                                  </b>
                                </font>
                              </td>

                              <td style="text-align:right; background-color:white">
                                <?php
                                if($Ctdocu > 0)
                                  $ampliar = "MASINFO1('".$u."','".$tip."')";
                                else
                                  $ampliar = "";
                                ?>
                                <button type="button" class="btn btn-default light" onclick="<?=$ampliar?>">
                                  <i id="btnmasinfo1_<?=$u?>_<?=$tip?>" class="fa fa-plus fa-lg" style="color:#AEBF25;" title="Más información"></i>
                                </button>

                                <button type="button" style="background:white; cursor:default;" class="btn btn-default light">
                                  &nbsp;&nbsp;&nbsp;
                                </button>
                              </td>
                            </tr>


                            @foreach($Documentos as $DatDoc) {{-- LISTA LOS DOCUMENTOS ASOCIADOS A ESE TIPO  --}}
                              <?php
                              $docu++;
                              ?>
                              <tr id="trdocumento_<?=$u?>_<?=$tip?>_<?=$docu?>" style="display:none;">
                                <td style="text-align:left; background-color:white" colspan="2">
                                  <button type="button" style="background:white; cursor:default;" class="btn btn-default light">
                                  </button>
                                  <button type="button" style="background:white; cursor:default;" class="btn btn-default light">
                                  </button>
                                  <b>
                                    <font color="#001137">
                                      <?php
                                      echo $docu;
                                      ?>
                                    </font>
                                  </b>

                                  <?php
                                  //Valido que el usuario tenga acceso al archivo
                                  $acceso = 1;  //1 acceso a descarga
                                  $CantDocPer = PanelDocumentos::getDocumentoPerfiles($DatDoc->id_documento);
                                  if($CantDocPer > 0)  //Si el documento esta asociado a un perfil (restringido)
                                   {
                                    $CantDocPerUsr = PanelDocumentos::getDocumentoPerfilesAcceso($DatDoc->id_documento, $DatLog->id_usuario);
                                    $CantDocUsr = PanelDocumentos::getDocumentosUsuarioAcceso($DatDoc->id_documento, $DatLog->id_usuario);
                                      if($CantDocPerUsr == 0 && $CantDocUsr == 0)
                                      $acceso = 0;  //0 acceso a descarga restringido
                                   }

                                  if($acceso == 1)
                                   {
                                    $nombrearc = $DatDoc->ruta1;
                                    $ext       = explode('.', $nombrearc);
                                    $ext1      = end($ext);

                                    if(($ext1 == 'xlsx') || ($ext1 == 'xls') || ($ext1 == 'XLSX') || ($ext1 == 'XLS') || ($ext1 == 'xlsm') || ($ext1 == 'XLSM'))
                                     {
                                      $fonicono = "28B463";
                                      $icono    = "fa-file-excel-o";
                                     }
                                    else if(($ext1 == 'docx') || ($ext1 == 'doc') || ($ext1 == 'DOCX') || ($ext1 == 'DOC'))
                                     {
                                      $fonicono = "226dbd";
                                      $icono    = "fa-file-word-o";
                                     }
                                    else if(($ext1 == 'pdf') || ($ext1 == 'PDF'))
                                     {
                                      $fonicono = "b90202";
                                      $icono    = "fa-file-pdf-o";
                                     }
                                    else if(($ext1 == 'pptx') || ($ext1 == 'ppt') || ($ext1 == 'PPTX') || ($ext1 == 'PPT'))
                                     {
                                      $fonicono = "ff4e22";
                                      $icono    = "fa-file-powerpoint-o";
                                     }
                                    else if(($ext1 == 'jpg') || ($ext1 == 'png') || ($ext1 == 'gif') || ($ext1 == 'JPG') || ($ext1 == 'PNG') || ($ext1 == 'GIF'))
                                     {
                                      $fonicono = "f4d03f";
                                      $icono    = "fa-file-image-o";
                                     }
                                    else
                                     {
                                      $fonicono = "000000";
                                      $icono    = "fa-file-archive-o";
                                     }

                                    $descarga = "window.open('".$server."/archivos/Procesos/Documentos/".$DatDoc->ruta1."?".date('i:s')."','_blank')";
                                    $titulo   = $DatDoc->ruta1;
                                   }
                                  else
                                   {
                                    $descarga = "";
                                    $titulo   = "No disponible para descarga";
                                    $fonicono = "f5b7b1";
                                    $icono    = "fa-eye-slash";
                                   }
                                  ?>

                                  <button type="button" style="background:#f7f9f9;" class="btn btn-default light" onclick="<?=$descarga?>" title="<?=$titulo?>">
                                    <i class="fa <?=$icono?> fa-2x fa-lg" style="color:#<?=$fonicono?>;"></i>
                                  </button>
                                  &nbsp;
                                  <?=$DatDoc->descripcion;?>
                                </td>
                              </tr>
                            @endforeach

                            <tr id="trfinal_<?=$u?>_<?=$tip?>" style="display:none; background-color:#F8F8F8?>">
                              <td colspan="2">
                                &nbsp;
                              </td>
                            </tr>
                          @endforeach
                        @endforeach
                      </tbody>
                    </table>

                    <script language="javascript" type="text/javascript">
                      function MASINFO(pos)
                       {
                        var id = pos;
                        bt = document.getElementById('btnmasinfo_'+id);

                        if(bt.className == "fa fa-minus fa-lg")
                         {
                          for(a=1;a<21;a++)
                           {
                            tr = !!document.getElementById('trtipo_'+id+'_'+a);
                            if(tr == true)
                             {
                              tr = document.getElementById('trtipo_'+id+'_'+a);
                              tr.style.display = 'none';

                              for(b=1;b<10000;b++)
                               {
                                tr2 = !!document.getElementById('trdocumento_'+id+'_'+a+'_'+b);
                                if(tr2 == true)
                                 {
                                  tr2 = document.getElementById('trdocumento_'+id+'_'+a+'_'+b);
                                  tr2.style.display = 'none';
                                 }
                                else
                                 {
                                  b = 10001;
                                 }
                               }
                              bt1 = document.getElementById('btnmasinfo1_'+id+'_'+a);
                              bt1.className   = 'fa fa-plus fa-lg';
                              bt1.title       = "Más información";
                              bt1.style.color = '#AEBF25';
                             }
                            else
                             {
                              a = 21;
                             }
                           }

                          bt.className   = 'fa fa-plus fa-lg';
                          bt.title       = "Más información";
                          bt.style.color = '#AEBF25';

                          for(a=1;a<21;a++)
                           {
                            tr1 = !!document.getElementById('trtipo_'+id+'_'+a);
                            if(tr1 == true)
                             {
                              tr1 = document.getElementById('trfinal_'+id+'_'+a);
                              tr1.style.display = 'none';
                             }
                           }
                         }
                        else
                         {
                          for(a=1;a<21;a++)
                           {
                            tr = !!document.getElementById('trtipo_'+id+'_'+a);
                            if(tr == true)
                             {
                              tr = document.getElementById('trtipo_'+id+'_'+a);
                              tr.style.display = '';
                             }
                            else
                             {
                              a = 21;
                             }
                           }

                          bt.className   = 'fa fa-minus fa-lg';
                          bt.title       = "Menos información";
                          bt.style.color = '#5d6d7e';
                         }
                       }

                      function MASINFO1(pos, pos1)
                       {
                        var id  = pos;
                        var id1 = pos1;

                        bt = document.getElementById('btnmasinfo1_'+id+'_'+id1);

                        if(bt.className == "fa fa-minus fa-lg")
                         {
                          for(a=1;a<10000;a++)
                           {
                            tr = !!document.getElementById('trdocumento_'+id+'_'+id1+'_'+a);
                            if(tr == true)
                             {
                              tr = document.getElementById('trdocumento_'+id+'_'+id1+'_'+a);
                              tr.style.display = 'none';
                             }
                            else
                             {
                              a = 10001;
                             }
                           }

                          bt.className   = 'fa fa-plus fa-lg';
                          bt.title       = "Más información";
                          bt.style.color = '#AEBF25';

                          tr1 = document.getElementById('trfinal_'+id+'_'+id1);
                          tr1.style.display = 'none';
                         }
                        else
                         {
                          for(a=1;a<10000;a++)
                           {
                            tr = !!document.getElementById('trdocumento_'+id+'_'+id1+'_'+a);
                            if(tr == true)
                             {
                              tr = document.getElementById('trdocumento_'+id+'_'+id1+'_'+a);
                              tr.style.display = '';
                             }
                            else
                             {
                              a = 10001;
                             }
                           }

                          bt.className   = 'fa fa-minus fa-lg';
                          bt.title       = "Menos información";
                          bt.style.color = '#5d6d7e';

                          tr1 = document.getElementById('trfinal_'+id+'_'+id1);
                          tr1.style.display = '';
                         }
                       }
                    </script>
                  </div>
                </div>
              </div>
            </div>
            <!-- -------------- /Content -------------- -->
          </section>
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
