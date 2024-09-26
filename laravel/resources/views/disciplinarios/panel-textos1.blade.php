<?php
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Disciplinarios\PanelTipofaltas;
use App\Models\Disciplinarios\PanelSolicitudes;

$DatosTipofalta = PanelTipofaltas::Tipofalta($DatosSolicitud[0]->tipo_falta);
$citacion = $DatosTipofalta[0]->citacion;
$descargos = $DatosTipofalta[0]->descargos;
$decision = $DatosTipofalta[0]->decisiones;

$desfalta = $DatosTipofalta[0]->descripcion;
$fechaactual = date('Y-m-d');
$sol = $DatosSolicitud[0]->id_solicitud;
$DatosEmpleado = PanelEmpleados::getEmpleado($DatosSolicitud[0]->colaborador);
$empleado = $DatosEmpleado[0]->primer_nombre . ' ' . $DatosEmpleado[0]->ot_nombre . ' ' . $DatosEmpleado[0]->primer_apellido . ' ' . $DatosEmpleado[0]->ot_apellido;
$nombre = "Proceso disciplinario $sol - $empleado - $desfalta - $fechaactual";

//Nombre del empleado que cometió la falta
$citacion = str_replace('-nombreempleado-', $empleado, $citacion);
$descargos = str_replace('-nombreempleado-', $empleado, $descargos);
$decision = str_replace('-nombreempleado-', $empleado, $decision);

//Identificación del empleado
$citacion = str_replace('-identificacionempleado-', $DatosEmpleado[0]->identificacion, $citacion);
$descargos = str_replace('-identificacionempleado-', $DatosEmpleado[0]->identificacion, $descargos);
$decision = str_replace('-identificacionempleado-', $DatosEmpleado[0]->identificacion, $decision);

//Número telefónico del empleado
$citacion = str_replace('-telefonoempleado-', $DatosEmpleado[0]->numtel, $citacion);
$descargos = str_replace('-telefonoempleado-', $DatosEmpleado[0]->numtel, $descargos);
$decision = str_replace('-telefonoempleado-', $DatosEmpleado[0]->numtel, $decision);

//Email del empleado
$citacion = str_replace('-correoempleado-', $DatosEmpleado[0]->correo, $citacion);
$descargos = str_replace('-correoempleado-', $DatosEmpleado[0]->correo, $descargos);
$decision = str_replace('-correoempleado-', $DatosEmpleado[0]->correo, $decision);

//Cargo del empleado
$DatCargo = PanelCargos::getCargo($DatosEmpleado[0]->cargo);
$citacion = str_replace('-cargoempleado-', $DatCargo[0]->descripcion, $citacion);
$descargos = str_replace('-cargoempleado-', $DatCargo[0]->descripcion, $descargos);
$decision = str_replace('-cargoempleado-', $DatCargo[0]->descripcion, $decision);

//Fecha reportada del suceso
$citacion = str_replace('-fechasuceso-', $DatosSolicitud[0]->fecha_falta, $citacion);
$descargos = str_replace('-fechasuceso-', $DatosSolicitud[0]->fecha_falta, $descargos);
$decision = str_replace('-fechasuceso-', $DatosSolicitud[0]->fecha_falta, $decision);

//Usuario que realizó la solicitud
$DatosSolicitante = PanelEmpleados::getEmpleado($DatosSolicitud[0]->usr_solicita);
$nombresol = $DatosSolicitante[0]->primer_nombre . ' ' . $DatosSolicitante[0]->ot_nombre . ' ' . $DatosSolicitante[0]->primer_apellido . ' ' . $DatosSolicitante[0]->ot_apellido;
$citacion = str_replace('-nombresolicitante-', $nombresol, $citacion);
$descargos = str_replace('-nombresolicitante-', $nombresol, $descargos);
$decision = str_replace('-nombresolicitante-', $nombresol, $decision);

//Causa
$citacion = str_replace('-causa-', $DatosSolicitud[0]->causa, $citacion);
$descargos = str_replace('-causa-', $DatosSolicitud[0]->causa, $descargos);
$decision = str_replace('-causa-', $DatosSolicitud[0]->causa, $decision);

//fecha actual
$citacion = str_replace('-fechactual-', $fechaactual, $citacion);
$descargos = str_replace('-fechactual-', $fechaactual, $descargos);
$decision = str_replace('-fechactual-', $fechaactual, $decision);

$antecedentes = "<table border=\"1\" cellpadding=\"8\" cellspacing=\"0\"><tr><th colspan=\"4\">Otros procesos del colaborador</th></tr>";
$antecedentes = $antecedentes . '<tr><th>P.D.</th><th>Tipo de falta</th><th>Fecha de la falta</th><th>Causa</th></tr>';

$DatosSolUsuario = PanelSolicitudes::FaltasColaborador($DatosSolicitud[0]->colaborador, $DatosSolicitud[0]->id_solicitud);
?>
@foreach ($DatosSolUsuario as $DatSol)
    <?php
    $antecedentes = $antecedentes . "<tr><td>PD-$DatSol->id_solicitud</td>";
    $OtFalta = PanelTipofaltas::Tipofalta($DatSol->tipo_falta);
    $antecedentes = $antecedentes . '<td>' . $OtFalta[0]->descripcion . "</td><td>$DatSol->fecha_falta</td>";
    $antecedentes = $antecedentes . "<td>$DatSol->causa</td></tr>";
    ?>
@endforeach
<?php
$antecedentes = $antecedentes . '</table>';

//Antecedentes
$citacion = str_replace('-antecedentes-', $antecedentes, $citacion);
$descargos = str_replace('-antecedentes-', $antecedentes, $descargos);
$decision = str_replace('-antecedentes-', $antecedentes, $decision);

header('Content-type: application/vnd.ms-word');
header("Content-Disposition: attachment; Filename=$nombre.doc");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body style="font-family:Bookman Old Style;">
    <?php
    echo $citacion;

    echo '<br><br><br><br>';
    echo '<center>';
    echo "<hr width=\"90%\">";
    echo '</center>';
    echo '<br><br><br><br>';

    echo $descargos;

    echo '<br><br><br><br>';
    echo '<center>';
    echo "<hr width=\"90%\">";
    echo '</center>';
    echo '<br><br><br><br>';

    echo $decision;
    ?>
</body>

</html>
