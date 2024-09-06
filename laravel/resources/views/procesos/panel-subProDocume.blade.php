<?php
$server ='/Berhlan/public';

use App\Models\Procesos\PanelProcesos;
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
        Intranet | Procesos internos
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
                  <a href="<?=$server?>/panel/menu/6" title="Procesos internos">
                    <font color="#34495e">
                      Procesos internos > Subprocesos - Documentos
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="<?=$server?>/panel/menu/6" class="btn btn-primary btn-sm ml10" title="Procesos internos">
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
                  <table id="message-table" class="table tc-checkbox-1 allcp-form theme-warning br-t table-striped">
                    <thead>
                      <div style="padding-left: 10px">
                        <?php
                        $col = "";
                        $macro = 0;
                        ?>
                        @foreach($DatosMacroProcesos as $DatMacroP)
                          <?php
                          $fondo = $DatMacroP->fondo;
                          ?>
                          <tr>
                            <td align="left">
                              <button type="button" style="background:#<?=$fondo?>; cursor:default;" class="btn btn-default light">
                                <b>
                                  <font color="white">
                                    <?php
                                    $macro++;
                                    echo $macro;
                                    ?>
                                  </font>
                                </b>
                              </button>
                              &nbsp;&nbsp;
                              <b>
                                <?=$DatMacroP->descripcion?>
                              </b>
                            </td>

                            <td align="right" style="vertical-align:top;">
                              <button type="button" class="btn btn-default light" onclick="MASINFO1('<?=$macro?>')">
                                <?php
                                echo "<i id=\"btnmasinfo1_$macro\" class=\"fa fa-plus fa-lg\" style=\"color:#AEBF25\" title=\"Más información\"></i>";
                                ?>
                              </button>
                            </td>
                          </tr>

                          <!-- Procesos -->
                          <?php
                          $Procesos = PanelProcesos::getProcesosMacro($DatMacroP->id_macroproceso);
                          $proce    = 0;
                          ?>
                          @foreach($Procesos as $DatProcesos)
                            <?php
                            $fondo1 = $DatProcesos->fondo;
                            $proce++;
                            ?>

                            <tr id="trproceso_<?=$macro?>_<?=$proce?>" style="display:none;">
                              <td align="left">
                                <button type="button" style="background-color:white; cursor:default;" class="btn btn-default light">
                                </button>
                                <button type="button" style="background:#<?=$fondo1?>; cursor:default;" class="btn btn-default light">
                                  <b>
                                    <font color="#001137">
                                      <?php
                                      echo $macro.".".$proce;
                                      ?>
                                    </font>
                                  </b>
                                </button>

                                <button type="button"  style="background:white;" class="btn btn-default light" onclick="window.location.href='<?=$server?>/archivos/Procesos/<?=$DatProcesos->ruta1?>'" title="<?=$DatProcesos->ruta1?>">
                                  <i class="fa fa-file-excel-o fa-lg" style="color:#28B463;"></i>
                                </button>
                                <b>
                                  <?=$DatProcesos->descripcion?>
                                </b>
                              </td>

                              <td align="right" style="vertical-align: top;">
                                <button type="button" class="btn btn-default light" onclick="MASINFO2('<?=$macro?>','<?=$proce?>')">
                                  <i id="btnmasinfo2_<?=$macro?>_<?=$proce?>" class="fa fa-plus fa-lg" style="color:#AEBF25;" title="Más información"></i>
                                </button>
                                <button type="button" style="background-color:white; cursor:default;" class="btn btn-default light">
                                  &nbsp;&nbsp;&nbsp;
                                </button>
                              </td>
                            </tr>

                            <!-- Subprocesos -->
                            <?php
                            $SubProcesos = PanelSubProcesos::getSubProcesos($DatProcesos->id_proceso);
                            $subp        = 0;
                            ?>
                            @foreach($SubProcesos as $DatSub)
                              <?php
                              $subp++;
                              ?>

                              <tr id="trproceso_<?=$macro?>_<?=$proce?>_<?=$subp?>" style="display:none;">
                                <td align="left">
                                  <button type="button"  style="background:white; cursor:default;" class="btn btn-default light">
                                  </button>
                                  <button type="button"  style="background:white; cursor:default;" class="btn btn-default light">
                                  </button>
                                  <button type="button"  style="background:white; cursor:default;" class="btn btn-default light">
                                  </button>
                                  <button type="button"  style="background:white; cursor:default;" class="btn btn-default light">
                                    <b>
                                      <font color="#001137">
                                        <?php
                                        echo $macro.".".$proce.".".$subp;
                                        ?>
                                      </font>
                                    </b>
                                  </button>
                                  <?=$DatSub->descripcion?>
                                </td>

                                <td align="right" style="vertical-align: top;">
                                  <button type="button" class="btn btn-primary light" onclick="window.location.href='<?=$server?>/panel/procesos/subprodocume/asociar/<?=$DatSub->id_subproceso?>'" title="Asociar documento">
                                    <i class="fa fa-plus pr4"></i>
                                    <i class="fa fa-file pr4"></i>
                                  </button>
                                  &nbsp;&nbsp;&nbsp;&nbsp;
                                  <button type="button" class="btn btn-default light" onclick="MASINFO3('<?=$macro?>','<?=$proce?>','<?=$subp?>')">
                                    <i id="btnmasinfo3_<?=$macro?>_<?=$proce?>_<?=$subp?>" class="fa fa-plus fa-lg" style="color:#AEBF25;" title="Más información"></i>
                                  </button>
                                  <button type="button" style="background-color:white; cursor:default;" class="btn btn-default light">
                                    &nbsp;&nbsp;&nbsp;
                                  </button>
                                  <button type="button" style="background-color:white; cursor:default;" class="btn btn-default light">
                                    &nbsp;&nbsp;&nbsp;
                                  </button>
                                </td>
                              </tr>

                              <!-- Documentos -->
                              <?php
                              $Documentos = PanelDocumentos::getDocumentosSubProceso($DatSub->id_subproceso);
                              $docu       = 0;
                              ?>
                              @foreach($Documentos as $DatDoc)
                                <?php
                                if($docu%2 == 0)
                                  $fondoc = "#ebf5fb";
                                else
                                  $fondoc = "white";
                                $docu++;
                                ?>

                                <tr id="trproceso_<?=$macro?>_<?=$proce?>_<?=$subp?>_<?=$docu?>" style="display:none; background-color: <?=$fondoc?>">
                                  <td align="left">
                                    <button type="button"  style="background:<?=$fondoc?>; cursor:default;" class="btn btn-default light">
                                    </button>
                                    <button type="button"  style="background:<?=$fondoc?>; cursor:default;" class="btn btn-default light">
                                    </button>
                                    <button type="button"  style="background:<?=$fondoc?>; cursor:default;" class="btn btn-default light">
                                    </button>
                                    <button type="button"  style="background:<?=$fondoc?>; cursor:default;" class="btn btn-default light">
                                    </button>
                                    <button type="button"  style="background:<?=$fondoc?>; cursor:default;" class="btn btn-default light">
                                      <b>
                                        <font color="#001137">
                                          <?php
                                          echo $macro.".".$proce.".".$subp.".".$docu;
                                          ?>
                                        </font>
                                      </b>
                                    </button>

                                    <?php
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
                                    ?>
                                    <button type="button" style="background:<?=$fondoc?>;" class="btn btn-default light" onclick="window.location.href='<?=$server?>/archivos/Procesos/Documentos/<?=$DatDoc->ruta1?>'" title="<?=$DatDoc->ruta1?>">
                                      <i class="fa <?=$icono?> fa-lg" style="color:#<?=$fonicono?>;"></i>
                                    </button>
                                    &nbsp;
                                    <?=$DatDoc->descripcion?>
                                    &nbsp;
                                    <b>
                                      (
                                       <?php
                                       $Tipo = PanelTiposDocumentos::getTipo($DatDoc->tipo);
                                       echo $Tipo[0]->descripcion;
                                       ?>
                                      )
                                    </b>

                                    (<?php
                                    echo $DatDoc->fecha1;
                                    ?>)
                                  </td>

                                  <td style="text-align: right;">
                                    <button type="button" class="btn btn-default light" onclick="RETIRAR('<?=$DatSub->id_subproceso?>', '<?=$DatDoc->id_documento?>', '<?=$DatDoc->descripcion?>')" title="Desasociar el documento">
                                      <i class="fa fa-trash fa-lg" style="color:#F6565A;"></i>
                                    </button>
                                    <button type="button" style="background-color:<?=$fondoc?>; cursor:default;" class="btn btn-default light">
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </button>
                                  </td>
                                </tr>
                              @endforeach

                              <tr id="trfinal_<?=$macro?>_<?=$proce?>_<?=$subp?>" style="display:none; background-color:#F8F8F8?>">
                                <td colspan="4">
                                  &nbsp;
                                </td>
                              </tr>
                            @endforeach
                          @endforeach
                        @endforeach
                      </div>
                    </thead>
                  </table>

                  {!! Form::open(array('action' => 'Procesos\SubDocProcesosPanelController@SubProDocumeDesasociarDB', 'class' => 'form', 'id'=>'form-wizard', 'name' => 'frmenvio')) !!}
                    {!! Form::hidden('login', $DatLog->login) !!}
                    {!! Form::hidden('ruta', 'subprodocume') !!}
                    {!! Form::hidden('subproceso', '') !!}
                    {!! Form::hidden('documento', '') !!}
                  {!! Form::close() !!}

                  <script language="javascript" type="text/javascript">
                    function RETIRAR(sub, doc, nom)
                     {
                      var id1 = sub;
                      var id2 = doc;
                      var id3 = nom;

                      if(!(confirm("Confirme el retiro del documento ("+id3+").")))
                        return false;

                      frm = document.forms["frmenvio"];
                      frm.subproceso.value = id1;
                      frm.documento.value  = id2;
                      document.frmenvio.submit();
                     }

                    function MASINFO1(pos)
                     {
                      var id = pos;
                      bt = document.getElementById('btnmasinfo1_'+id);

                      if(bt.className == "fa fa-minus fa-lg")
                       {
                        for(a=1;a<50;a++)
                         {
                          tr = !!document.getElementById('trproceso_'+id+'_'+a);
                          if(tr == true)
                           {
                            tr = document.getElementById('trproceso_'+id+'_'+a);
                            tr.style.display = 'none';

                            //Oculto los subprocesos
                            for(b=1;b<50;b++)
                             {
                              tr1 = !!document.getElementById('trproceso_'+id+'_'+a+'_'+b);
                              if(tr1 == true)
                               {
                                tr1 = document.getElementById('trproceso_'+id+'_'+a+'_'+b);
                                tr1.style.display = 'none';

                                //Oculto los documentos
                                for(c=1;c<10000;c++)
                                 {
                                  tr2 = !!document.getElementById('trproceso_'+id+'_'+a+'_'+b+'_'+c);
                                  if(tr2 == true)
                                   {
                                    tr2 = document.getElementById('trproceso_'+id+'_'+a+'_'+b+'_'+c);
                                    tr2.style.display = 'none';
                                   }
                                  else
                                   {
                                    c = 10001;
                                   }
                                 }
                                bt3 = document.getElementById('btnmasinfo3_'+id+'_'+a+'_'+b);
                                bt3.className   = 'fa fa-plus fa-lg';
                                bt3.title       = "Más información";
                                bt3.style.color = '#AEBF25';
                                //Oculto el separador
                                tr3 = !!document.getElementById('trfinal_'+id+'_'+a+'_'+b);
                                if(tr3 == true)
                                 {
                                  tr3 = document.getElementById('trfinal_'+id+'_'+a+'_'+b);
                                  tr3.style.display = 'none';
                                 }

                               }
                              else
                               {
                                b = 51;
                               }
                             }

                            bt2 = document.getElementById('btnmasinfo2_'+id+'_'+a);
                            bt2.className   = 'fa fa-plus fa-lg';
                            bt2.title       = "Más información";
                            bt2.style.color = '#AEBF25';

                           }
                          else
                           {
                            a = 51;
                           }
                         }
                        bt.className   = 'fa fa-plus fa-lg';
                        bt.title       = "Más información";
                        bt.style.color = '#AEBF25';
                       }
                      else
                       {
                        for(a=1;a<50;a++)
                         {
                          tr = !!document.getElementById('trproceso_'+id+'_'+a);
                          if(tr == true)
                           {
                            tr = document.getElementById('trproceso_'+id+'_'+a);
                            tr.style.display = '';
                           }
                          else
                           {
                            a = 51;
                           }
                         }
                        bt.className   = 'fa fa-minus fa-lg';
                        bt.title       = "Menos información";
                        bt.style.color = '#5d6d7e';
                       }
                     }

                    function MASINFO2(pos1, pos2)
                     {
                      var id1 = pos1;
                      var id2 = pos2;

                      bt = document.getElementById('btnmasinfo2_'+id1+'_'+id2);

                      if(bt.className == "fa fa-minus fa-lg")
                       {
                        for(a=1;a<50;a++)
                         {
                          tr = !!document.getElementById('trproceso_'+id1+'_'+id2+'_'+a);
                          if(tr == true)
                           {
                            tr = document.getElementById('trproceso_'+id1+'_'+id2+'_'+a);
                            tr.style.display = 'none';

                            //Oculto los documentos
                            for(b=1;b<10000;b++)
                             {
                              tr2 = !!document.getElementById('trproceso_'+id1+'_'+id2+'_'+a+'_'+b);
                              if(tr2 == true)
                               {
                                tr2 = document.getElementById('trproceso_'+id1+'_'+id2+'_'+a+'_'+b);
                                tr2.style.display = 'none';
                               }
                              else
                               {
                                c = 10001;
                               }
                             }
                            bt3 = document.getElementById('btnmasinfo3_'+id1+'_'+id2+'_'+a);
                            bt3.className   = 'fa fa-plus fa-lg';
                            bt3.title       = "Más información";
                            bt3.style.color = '#AEBF25';
                            //Oculto el separador
                            tr3 = !!document.getElementById('trfinal_'+id1+'_'+id2+'_'+a);
                            if(tr3 == true)
                             {
                              tr3 = document.getElementById('trfinal_'+id1+'_'+id2+'_'+a);
                              tr3.style.display = 'none';
                             }

                           }
                          else
                           {
                            a = 51;
                           }
                         }
                        bt.className   = 'fa fa-plus fa-lg';
                        bt.title       = "Más información";
                        bt.style.color = '#AEBF25';
                       }
                      else
                       {
                        for(a=1;a<50;a++)
                         {
                          tr = !!document.getElementById('trproceso_'+id1+'_'+id2+'_'+a);
                          if(tr == true)
                           {
                            tr = document.getElementById('trproceso_'+id1+'_'+id2+'_'+a);
                            tr.style.display = '';
                           }
                          else
                           {
                            a = 51;
                           }
                         }
                        bt.className   = 'fa fa-minus fa-lg';
                        bt.title       = "Menos información";
                        bt.style.color = '#5d6d7e';
                       }
                     }

                    function MASINFO3(pos1, pos2, pos3)
                     {
                      var id1 = pos1;
                      var id2 = pos2;
                      var id3 = pos3;

                      bt = document.getElementById('btnmasinfo3_'+id1+'_'+id2+'_'+id3);

                      if(bt.className == "fa fa-minus fa-lg")
                       {
                        for(a=1;a<10000;a++)
                         {
                          tr = !!document.getElementById('trproceso_'+id1+'_'+id2+'_'+id3+'_'+a);
                          if(tr == true)
                           {
                            tr = document.getElementById('trproceso_'+id1+'_'+id2+'_'+id3+'_'+a);
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

                        tr1 = document.getElementById('trfinal_'+id1+'_'+id2+'_'+id3);
                        tr1.style.display = 'none';
                       }
                      else
                       {
                        for(a=1;a<10000;a++)
                         {
                          tr = !!document.getElementById('trproceso_'+id1+'_'+id2+'_'+id3+'_'+a);
                          if(tr == true)
                           {
                            tr = document.getElementById('trproceso_'+id1+'_'+id2+'_'+id3+'_'+a);
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

                        tr1 = document.getElementById('trfinal_'+id1+'_'+id2+'_'+id3);
                        tr1.style.display = '';
                       }
                     }
                  </script>
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