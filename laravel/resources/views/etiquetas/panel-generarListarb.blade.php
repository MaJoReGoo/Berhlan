<?php


require dirname( __DIR__ ) . '/../../vendorberh/vendor/autoload.php';

use App\Models\Etiquetas\PanelItemEtiquetasBarras;
?>

@foreach($DatosUsuario as $DatLog)
  <!DOCTYPE html>
  <html>
    <head>
      <!-- -------------- Meta and Title -------------- -->
      <meta charset="utf-8">
      <title>
        Intranet | Códigos de barras | Generar
      </title>

      <meta name="keywords" content="panel, cms, usuarios, servicio"/>
      <meta name="description" content="Intranet para grupo Berhlan">
      <meta name="author" content="USUARIO" >
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!-- -------------- Fonts -------------- -->
      <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
      <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

      <!-- -------------- CSS - theme -------------- -->
      <link rel="stylesheet" type="text/css" href="{{ asset('/panelfiles/assets/skin/default_skin/css/theme.css')}}">

      <!-- -------------- CSS - allcp forms -------------- -->
      <link rel="stylesheet" type="text/css" href="{{ asset('/panelfiles/assets/allcp/forms/css/forms.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('/panelfiles/assets/allcp/forms/css/forms.css')}}">

      <!-- -------------- Plugins -------------- -->
      <link rel="stylesheet" type="text/css" href="{{ asset('/panelfiles/assets/js/plugins/c3charts/c3.min.css')}}">

      <!-- -------------- Favicon -------------- -->
      <link rel="shortcut icon" href="{{ asset('/panelfiles/assets/img/favicon.ico')}}">

      <!-- Editor -->
      <script type="text/javascript" src="{{ asset('/panelfiles/ckeditor/ckeditor.js')}}"></script>
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
                  <a href="{{ asset('/panel/etiquetas/generar')}}" title="Etiquetas > Seleccionar ítem ">
                    <font color="#34495e">
                      Códigos de barras > Seleccionar ítem >
                    </font>
                    <font color="#b4c056">
                      Generar etiqueta
                    </font>
                  </a>
                </li>
              </ul>
            </div>

            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
              <a href="{{ asset('/panel/etiquetas/generar')}}" class="btn btn-primary btn-sm ml10" title="Etiquetas > Seleccionar ítem ">
                REGRESAR  
                <span class="fa fa-arrow-left"></span>
              </a>
            </div>
          </header>
          <!-- -------------- /Topbar -------------- -->

          <!-- -------------- Content -------------- -->
          <section id="content" class="table-layout animated fadeIn">
            <div class="chute chute-center pt0">
              Lote: <input type="text" id="lote" style="width:350;" maxlength="30" placeholder="123456" onblur="LOTE('')">
                
              OC:   <input type="text" id="oc"   style="width:350;" maxlength="30" placeholder="123456" onblur="OC('')">

              <!-- -------------- Column Center -------------- -->
              <!-- -------------- Message Body -------------- -->
              <?php
              $e=0;
              ?>
              @foreach($DatosItem as $DatIte)
                <?php $e++; ?>
                <div id="imprime_<?=$e?>">
                  <table border="0" align="center" style="width:370px; background-color:white; border-spacing:0; color:#000000;" cellpadding="3" cellspacing="0">
                    <tr>
                      <td style="text-align:left; line-height:22px; vertical-align:baseline;" colspan="3">
                        <?php
                        if(strpos($DatIte->f120_notas, "/"))
                         {
                          $desc = explode("/", $DatIte->f120_notas, 2);
                          $nombre = trim($desc[1]);
                         }
                        else
                         {
                          $nombre = trim($DatIte->f120_notas);
                         }

                        $ancho = strlen($nombre);
                        if($ancho <= 22)
                         {
                          $tam = "38";
                         }
                        else if(($ancho > 22) && ($ancho < 28))
                         {
                          $tam = "30";
                         }
                        else if(($ancho >= 28) && ($ancho < 32))
                         {
                          $tam = "28";
                         }
                        else if(($ancho >= 32) && ($ancho < 40))
                         {
                          $tam = "26";
                         }
                        else if(($ancho >= 40) && ($ancho < 50))
                         {
                          $tam = "20";
                         }
                        else if(($ancho >= 50) && ($ancho < 60))
                         {
                          $tam = "20";
                         }
                        else if(($ancho >= 60) && ($ancho < 70))
                         {
                          $tam = "18";
                         }
                        else if($ancho >= 70)
                         {
                          $tam = "14";
                         }
                        ?>

                        <b>
                          <font style="font-size:<?=$tam?>px; letter-spacing:0px; font-family:Arial Black, helvetica, verdana, arial;">
                            <?=$nombre?>
                          </font>
                          <font style="font-size:15px; letter-spacing:0px; font-family:verdana, arial;">
                            <label id="lotetex_<?=$e?>"></label> <label id="octex_<?=$e?>"></label>
                          </font>
                        </b>
                      </td>

                      <td align="center">
                         
                      </td>
                    </tr>

                    <tr>
                      <td align="center" style="width:82px;">
                        <?php
                        $Maquila = PanelItemEtiquetasBarras::InfoMaquila($DatIte->f120_id);
                        $ruta  = substr(public_path(), 0, -14)."public/archivos/Maquilas/".$Maquila[0]->IDMAQUILA.".png";
                        if(file_exists($ruta)) //Si existe la imagen
                         {
                          $size  = GetImageSize($ruta);
                          $ancho = $size[0]; //sacamos el ancho
                          $largo = $size[1]; //sacamos el largo
                          if($ancho >= $largo)
                            $tam = "width: 80px;";
                          else
                            $tam = "height:30px;";
                          ?>
                          <img src="/Berhlan/public/archivos/Maquilas/<?=$Maquila[0]->IDMAQUILA?>.png?<?=date('i:s')?>" style="<?=$tam?> border-radius:2px;" onerror="this.src='jeronimo.png'">
                          <?php
                         }
                        else
                         {
                          echo "<font style=\"line-height:8px; font-size:18px; letter-spacing:0px; font-family:verdana, arial;\">";
                            echo "<b>";
                              echo str_replace("MAQUILA ", "", $Maquila[0]->MAQUILA);
                            echo "</b>";
                          echo "</font>";
                         }
                        ?>
                      </td>

                      <td align="center">
                        <b>
                          <font style="font-size:14px; letter-spacing:0px; font-family:Impact, verdana, arial;">
                            <?php
                            $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                            if(strlen(trim($DatIte->codigo)) == 14)
                             {
                              echo "<b>Código GTIN 14</b>";
                              echo $generator->getBarcode($DatIte->codigo, $generator::TYPE_CODE_128, 2, 67);
                             }
                            else if(strlen(trim($DatIte->codigo)) == 13)
                             {
                              echo "Código interno";
                              echo $generator->getBarcode($DatIte->codigo, $generator::TYPE_EAN_13, 2, 67);
                             }
                            else
                             {
                              echo "Código interno";
                              echo $generator->getBarcode($DatIte->codigo, $generator::TYPE_CODE_128, 2, 67);
                             }
                            echo $DatIte->codigo;
                            ?>
                          </font>
                        </b>
                      </td>

                      <td align="center" style="">
                        <b>
                          <font style="line-height:40px; font-size:36px; letter-spacing:0px; font-family:Impact, verdana, arial;">
                            <?=$DatIte->f120_id?>
                          </font>
                          <br>
                          <font style="line-height:18px; font-size:18px; letter-spacing:0px; font-family:Impact, helvetica, verdana, arial;">
                            ÍTEM
                          </font>
                          <br>
                          <font style="font-size:13px; letter-spacing:0px; font-family:Impact, verdana, arial;">
                            <?php
                            $medida = trim($DatIte->undmed);
                            if($medida == "CJ04")
                              echo "CAJA X 4 UND";
                            else if($medida == "CJ06")
                              echo "CAJA X 6 UND";
                            else if($medida == "CJ12")
                              echo "CAJA X 12 UND";
                            else if($medida == "CJ24")
                              echo "CAJA X 24 UND";
                            else
                              echo $medida;
                            ?>
                          </font>
                        </b>
                      </td>

                      <td align="center">
                         
                      </td>
                    </tr>
                  </table>
                </div>

                <br>

                <div style="text-align: center;">
                  <button class="btn btn-primary light" onclick="imprime('imprime_<?=$e?>')" style="background-color:#2b3980;">
                    Imprimir
                  </button>
                </div>
                <br><br><br>
              @endforeach

              <script language="javascript" type="text/javascript">
              function LOTE()
               {
                lote = document.getElementById('lote');
                if(lote.value != '')
                 {
                  lotetex = document.getElementById('lotetex_1');
                  lotetex.innerText = "Lote "+lote.value;
                  lotetex = document.getElementById('lotetex_2');
                  lotetex.innerText = "Lote "+lote.value;
                  lotetex = document.getElementById('lotetex_3');
                  lotetex.innerText = "Lote "+lote.value;
                 }
                else
                 {
                  lotetex = document.getElementById('lotetex_1');
                  lotetex.innerText = "";
                  lotetex = document.getElementById('lotetex_2');
                  lotetex.innerText = "";
                  lotetex = document.getElementById('lotetex_3');
                  lotetex.innerText = "";
                 }
               }

              function OC()
               {
                oc = document.getElementById('oc');
                if(oc.value != '')
                 {
                  octex = document.getElementById('octex_1');
                  octex.innerText = "O.C. "+oc.value;
                  octex = document.getElementById('octex_2');
                  octex.innerText = "O.C. "+oc.value;
                  octex = document.getElementById('octex_3');
                  octex.innerText = "O.C. "+oc.value;
                 }
                else
                 {
                  octex = document.getElementById('octex_1');
                  octex.innerText = "";
                  octex = document.getElementById('octex_2');
                  octex.innerText = "";
                  octex = document.getElementById('octex_3');
                  octex.innerText = "";
                 }
               }

              function imprime(imprime)
               {
                var ficha = document.getElementById(imprime);
                var ventimp = window.open(' ','popimpr');
                ventimp.document.write(ficha.innerHTML);
                ventimp.document.close();
                ventimp.print();
                ventimp.close();
               }
              </script>
              <!-- -------------- /Column Center -------------- -->
            </div>
          </section>
          <!-- -------------- /Content -------------- -->
        </section>
      </div>
      <!-- -------------- /Body Wrap  -------------- -->

      <!-- -------------- Scripts -------------- -->

      <!-- -------------- jQuery -------------- -->
      <script src="{{ asset('/panelfiles/assets/js/jquery/jquery-1.11.3.min.js')}}"></script>
      <script src="{{ asset('/panelfiles/assets/js/jquery/jquery_ui/jquery-ui.min.js')}}"></script>

      <!-- -------------- JvectorMap Plugin -------------- -->
      <script src="{{ asset('/panelfiles/assets/js/plugins/jvectormap/jquery.jvectormap.min.js')}}"></script>
      <script src="{{ asset('/panelfiles/assets/js/plugins/jvectormap/assets/jquery-jvectormap-world-mill-en.js')}}"></script>

      <!-- -------------- HighCharts Plugin -------------- -->
      <script src="{{ asset('/panelfiles/assets/js/plugins/highcharts/highcharts.js')}}"></script>
      <script src="{{ asset('/panelfiles/assets/js/plugins/c3charts/d3.min.js')}}"></script>
      <script src="{{ asset('/panelfiles/assets/js/plugins/c3charts/c3.min.js')}}"></script>

      <!-- -------------- Theme Scripts -------------- -->
      <script src="{{ asset('/panelfiles/assets/js/utility/utility.js')}}"></script>
      <script src="{{ asset('/panelfiles/assets/js/demo/demo.js')}}"></script>
      <script src="{{ asset('/panelfiles/assets/js/main.js')}}"></script>
      <script src="{{ asset('/panelfiles/assets/js/pages/allcp_forms-elements.js')}}"></script>
      <script src="{{ asset('/panelfiles/assets/js/demo/widgets_sidebar.js')}}"></script>

      <!-- -------------- Page JS -------------- -->
      <script src="{{ asset('/panelfiles/assets/js/demo/charts/highcharts.js')}}"></script>

      <!-- -------------- /Scripts -------------- -->
    </body>
  </html>
@endforeach
