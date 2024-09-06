<?php
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Disciplinarios\PanelTipofaltas;
use App\Models\Disciplinarios\PanelMotivos;


$fechaactual = date('d-m-Y');
$nombre      = "Reporte de gestión - Procesos disciplinarios - $fechaactual";

header("Content-type: application/vnd.ms-excel; base64");
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
        <th>
          Informe reporte de gestión
        </th>
        <th>
          Desde:
        </th>
        <th>
          <?php
          if($Desde == '')
            echo "No ingresada";
          else
            echo date('d-m-Y', strtotime($Desde));
          ?>
        </th>
        <th>
          Hasta:
        </th>
        <th>
          <?php
          if($Hasta == '')
            echo "No ingresada";
          else
            echo date('d-m-Y', strtotime($Hasta));
          ?>
        </th>

        <th>
          Estado:
        </th>
        <th>
          <?php
          if($DatosSolicitudes[0]->estado == 0)
            echo "Atendidas";
          else
            echo "En proceso";
          ?>
        </th>
      </tr>

      <tr><td></td></tr>

      <tr>
        <th>
          Centro de operación
        </th>
        <th>
          Área
        </th>
        <th>
          Id. Colaborador
        </th>
        <th>
          Nombre colaborador
        </th>
        <th>
          Cargo
        </th>

        <?php
        if($DatosSolicitudes[0]->estado == 1)
         {
          ?>
          <th>
            Causa
          </th>
          <th>
            Tipo de falta
          </th>
          <?php
         }
        else
         {
          ?>
          <th>
            Tipo de falta
          </th>
          <th>
            Causa
          </th>
          <th>
            Fecha solicitud
          </th>
          <th>
            Mes
          </th>
          <th>
            Solicitado por
          </th>
          <th>
            Cargo solicitante
          </th>
          <th>
            Fecha de proceso
          </th>
          <th>
            Promesa de servicio
          </th>
          <th>
            Estado del proceso
          </th>
          <th>
            Resultado
          </th>
          <th>
            Observaciones de cierre
          </th>
          <th>
            Detalle de resultado
          </th>
          <th>
            Fecha proceso 2
          </th>
          <th>
            Fecha medida correctiva
          </th>
          <th>
            Tiempo resultado
          </th>
          <?php
         }
        ?>
      </tr>

      @foreach($DatosSolicitudes as $DatSol)
        <tr>
          <?php
          $empleado = PanelEmpleados::getEmpleado($DatSol->colaborador);
          $centro   = PanelCentrosOp::getCentroOp($empleado[0]->centro_op);
          $cargo    = PanelCargos::getCargo($empleado[0]->cargo);
          $Area     = PanelAreas::getArea($cargo[0]->area);
          $Faltas   = PanelTipofaltas::Tipofalta($DatSol->tipo_falta);

          echo "<td>";
            if($empleado[0]->centro_op == 1)
              echo "Principal";
            else if($empleado[0]->centro_op == 2)
              echo "Barranquilla";
            else if($empleado[0]->centro_op == 3)
              echo "Tocancipá";
            else
              echo $centro[0]->descripcion;
          echo "</td>";

          echo "<td>";
            echo $Area[0]->descripcion;
          echo "</td>";

          echo "<td>";
            echo $empleado[0]->identificacion;
          echo "</td>";

          echo "<td>";
            echo $empleado[0]->primer_nombre;
            echo " ";
            echo $empleado[0]->ot_nombre;
            echo " ";
            echo $empleado[0]->primer_apellido;
            echo " ";
            echo $empleado[0]->ot_apellido;
          echo "</td>";

          echo "<td>";
            echo $cargo[0]->descripcion;
          echo "</td>";

          if($DatosSolicitudes[0]->estado == 1)
           {
            echo "<td>";
              echo $DatSol->causa;
            echo "</td>";

            echo "<td>";
              echo $Faltas[0]->descripcion;
            echo "</td>";
           }
          else
           {
            echo "<td>";
              echo $Faltas[0]->descripcion;
            echo "</td>";

            echo "<td>";
              echo $DatSol->causa;
            echo "</td>";

            echo "<td>";
              echo date('d-m-Y', strtotime($DatSol->fecha_solicita));
            echo "</td>";

            echo "<td>";
              $fecha = $DatSol->fecha_solicita;
              $fecha = $fecha[5].$fecha[6];
              if($fecha == 1)
                echo "Enero";
              else if($fecha == 2)
                echo "Febrero";
              else if($fecha == 3)
                echo "Marzo";
              else if($fecha == 4)
                echo "Abril";
              else if($fecha == 5)
                echo "Mayo";
              else if($fecha == 6)
                echo "Junio";
              else if($fecha == 7)
                echo "Julio";
              else if($fecha == 8)
                echo "Agosto";
              else if($fecha == 9)
                echo "Septiembre";
              else if($fecha == 10)
                echo "Octubre";
              else if($fecha == 11)
                echo "Noviembre";
              else if($fecha == 12)
                echo "Diciembre";
            echo "</td>";

            echo "<td>";
              $empleado1 = PanelEmpleados::getEmpleado($DatSol->usr_solicita);
              echo $empleado1[0]->primer_nombre;
              echo " ";
              echo $empleado1[0]->ot_nombre;
              echo " ";
              echo $empleado1[0]->primer_apellido;
              echo " ";
              echo $empleado1[0]->ot_apellido;
            echo "</td>";

            $cargo1 = PanelCargos::getCargo($empleado1[0]->cargo);
            echo "<td>";
              echo $cargo1[0]->descripcion;
            echo "</td>";

            echo "<td>";
              echo date('d-m-Y', strtotime($DatSol->fecha_cierre));
            echo "</td>";

            echo "<td>";
              //Calculo la diferencia en días
              $fechaini = $DatSol->fecha_solicita;
              $fechafin = $DatSol->fecha_cierre;

              $dateDifference = abs(strtotime($fechafin) - strtotime($fechaini));

              $dias = floor($dateDifference / (60 * 60 * 24));
              $diaf = $dias;

              for($e=1;$e<=$dias;$e++)
               {
                $nvfecha = date('Y-m-d', strtotime($fechaini."+ ".$e." days"));
                $numdia  = strftime("%w", strtotime($nvfecha));
                if(($numdia == 0) || ($numdia == 6))
                  $diaf--;
               }

              $fecha1 = new DateTime($DatSol->fecha_solicita);
              $fecha2 = new DateTime($DatSol->fecha_cierre);
              $diff  = $fecha1->diff($fecha2);
              $horas = $diff->h;

              $hora = $horas * (1/24);

              echo $diaf.",".substr($hora, 2);
            echo "</td>";

            echo "<td>";
              echo "Descargos";
            echo "</td>";

            echo "<td>";
              if($DatSol->motivo_cierre > 0)
               {
                $motivo = PanelMotivos::getMotivo($DatSol->motivo_cierre);
                echo $motivo[0]->descripcion;
               }
            echo "</td>";

            echo "<td>";
              echo $DatSol->obs_cierre;
            echo "</td>";

            echo "<td>";
              echo $DatSol->resultado;
            echo "</td>";

            echo "<td>";
              echo date('d-m-Y', strtotime($DatSol->fecha_descargos));
            echo "</td>";

            echo "<td>";
              echo date('d-m-Y', strtotime($DatSol->fecha_descargos));
            echo "</td>";

            echo "<td>";
              echo "0";
            echo "</td>";
           }
          ?>
        </tr>
      @endforeach
    </table>
  </body>
</html>