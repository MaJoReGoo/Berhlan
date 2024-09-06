<?php
use App\Models\Procesos\PanelMacroProcesos;
use App\Models\Procesos\PanelProcesos;
use App\Models\Procesos\PanelSubProcesos;
use App\Models\Procesos\PanelDocumentos;
use App\Models\Procesos\PanelTiposDocumentos;
use App\Models\Procesos\PanelPerfiles;


$fechaactual = date('d-m-Y');
$nombre      = "Área de procesos - Cadena de valor - Mapa de sitio Intranet - $fechaactual";


header("Content-type: application/xls");
header("Content-Disposition: attachment; Filename=$nombre.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  </head>

  <body style="font-family:Calibri;">
    <table cellpadding="2" cellspacing="2" border="1">
      <tr>
        <th colspan="9">
          Área de procesos - Cadena de valor - Mapa de sitio Intranet -
          <?=$fechaactual?>
        </th>
      </tr>

      <tr>
        <th colspan="9">
        </th>
        <th>
          Perfiles
        </th>
      </tr>

      <tr>
        <th style="text-align:left;">
          Id
        </th>
        <th style="text-align:left;">
          Macroproceso
        </th>
        <th style="text-align:left;">
          Id
        </th>
        <th style="text-align:left;">
          Proceso
        </th>
        <th style="text-align:left;">
          Id
        </th>
        <th style="text-align:left;">
          Subproceso
        </th>
        <th style="text-align:left;">
          Id
        </th>
        <th style="text-align:left;">
          Documento
        </th>
        <th style="text-align:left;">
          Grupo del documento
        </th>

        <?php
        $DatosPerfiles = PanelPerfiles::getPerfiles();
        ?>
        @foreach($DatosPerfiles as $DatPer)
          <th style="text-align:left;">
            <?=$DatPer->descripcion?>
          </th>
        @endforeach

        <th style="text-align:left;">
          Libre acceso
        </th>
      </tr>

      <?php
      $DatosMacro = PanelMacroProcesos::getMacroProcesos();
      ?>
      @foreach($DatosMacro as $DatMac)
        <?php
        $Datosprocesos = PanelProcesos::getProcesosMacro($DatMac->id_macroproceso);
        ?>
        @foreach($Datosprocesos as $DatPro)
          <?php
          $DatosSubprocesos = PanelSubProcesos::getSubProcesos($DatPro->id_proceso);
          ?>
          @foreach($DatosSubprocesos as $DatSub)
            <?php
            $Documentos = PanelDocumentos::getDocumentosSubProceso($DatSub->id_subproceso);
            $a = 0;
            ?>
            @foreach($Documentos as $DatDoc)
              <?php
              $a++;
              ?>
              <tr>
                <td>
                  <?=$DatMac->id_macroproceso?>
                </td>

                <td>
                  <?=$DatMac->descripcion?>
                </td>

                <td>
                  <?=$DatPro->id_proceso?>
                </td>

                <td>
                  <?=$DatPro->descripcion?>
                </td>

                <td>
                  <?=$DatSub->id_subproceso?>
                </td>

                <td>
                  <?=$DatSub->descripcion?>
                </td>

                <td>
                  <?=$DatDoc->id_documento?>
                </td>

                <td>
                  <?=$DatDoc->descripcion?>
                </td>

                <td>
                  <?php
                  $tipo = PanelTiposDocumentos::getTipo($DatDoc->tipo);
                  echo $tipo[0]->descripcion;
                  ?>
                </td>

                <?php
                $y = 0;
                ?>
                @foreach($DatosPerfiles as $DatPer)
                  <td>
                    <?php
                    $aplica = PanelPerfiles::getDocPerUnico($DatDoc->id_documento, $DatPer->id_perfil);
                    if($aplica == 0)
                     {
                      echo "N";
                     }
                    else
                     {
                      echo "S";
                      $y = 1;
                     }
                    ?>
                  </td>
                @endforeach

                <td>
                  <?php
                  if($y == 0)
                    echo "S";
                  else
                    echo "N";
                  ?>
                </td>
              </tr>
            @endforeach

            <?php
            if($a == 0)
             {
              ?>
              <tr>
                <td style="text-align:right">
                  <?=$DatMac->id_macroproceso?>
                </td>

                <td>
                  <?=$DatMac->descripcion?>
                </td>

                <td>
                  <?=$DatPro->id_proceso?>
                </td>

                <td>
                  <?=$DatPro->descripcion?>
                </td>

                <td>
                  <?=$DatSub->id_subproceso?>
                </td>

                <td>
                  <?=$DatSub->descripcion?>
                </td>

                <td colspan="4">
                </td>
              </tr>
              <?php
             }
            ?>
          @endforeach
        @endforeach
      @endforeach
    </table>
  </body>
</html>