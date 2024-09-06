<?php
//require_once dirname( __DIR__ ) . '/../../vendor/PhpOffice/PhpWord/Autoloader.php';
require_once dirname( __DIR__ ) . '/../../vendor/phpoffice/PHPWord-master/src/PhpWord/Autoloader.php';


//require_once dirname( __DIR__ ) . '/../../vendor/PhpOffice/phpword/src/PhpWord/Autoloader.php';

\PhpOffice\PhpWord\Autoloader::register();
use PhpOffice\PhpWord\TemplateProcessor;

use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Disciplinarios\PanelTipofaltas;
use App\Models\Disciplinarios\PanelSolicitudes;

$nombrearchivo = $DatosSolicitud[0]->tipo_falta;
$templateWord  = new TemplateProcessor(dirname( __DIR__ ) .'/../../../public/archivos/Disciplinarios/'.$nombrearchivo.'.docx');

$DatosTipofalta   = PanelTipofaltas::Tipofalta($DatosSolicitud[0]->tipo_falta);
$desfalta         = $DatosTipofalta[0]->descripcion;
$fechaactual      = date('d-m-Y');
$sol              = $DatosSolicitud[0]->id_solicitud;
$DatosEmpleado    = PanelEmpleados::getEmpleado($DatosSolicitud[0]->colaborador);
$empleado         = $DatosEmpleado[0]->primer_nombre." ".$DatosEmpleado[0]->ot_nombre." ".$DatosEmpleado[0]->primer_apellido." ".$DatosEmpleado[0]->ot_apellido;
$nombre           = "Proceso disciplinario $sol - $empleado - $desfalta - $fechaactual";
$DatCargo         = PanelCargos::getCargo($DatosEmpleado[0]->cargo);
$DatosSolicitante = PanelEmpleados::getEmpleado($DatosSolicitud[0]->usr_solicita);
$nombresol        = $DatosSolicitante[0]->primer_nombre." ".$DatosSolicitante[0]->ot_nombre." ".$DatosSolicitante[0]->primer_apellido." ".$DatosSolicitante[0]->ot_apellido;

$fechamenosdia = date('d-m-Y', strtotime("-1 days")); // 1 día antes
$numdia = strftime("%w", strtotime($fechamenosdia));
if($numdia == 0) //Si es domingo
  $fechamenosdia = date('d-m-Y', strtotime("-3 days")); // 3 días antes
if($numdia == 6) //Si es sabado
  $fechamenosdia = date('d-m-Y', strtotime("-2 days")); // 2 días antes

$fechasuceso = date('d-m-Y', strtotime($DatosSolicitud[0]->fecha_falta));

$templateWord->setValue('nombreempleado',         $empleado);
$templateWord->setValue('identificacionempleado', $DatosEmpleado[0]->identificacion);
$templateWord->setValue('telefonoempleado',       $DatosEmpleado[0]->numtel);
$templateWord->setValue('correoempleado',         $DatosEmpleado[0]->correo);
$templateWord->setValue('cargoempleado',          $DatCargo[0]->descripcion);
$templateWord->setValue('fechasuceso',            $fechasuceso);
$templateWord->setValue('nombresolicitante',      $nombresol);
$templateWord->setValue('causa',                  $DatosSolicitud[0]->causa);
$templateWord->setValue('fechactual',             $fechaactual);
$templateWord->setValue('fechactualmenosuno',     $fechamenosdia);

$DatosSolUsuario   = PanelSolicitudes::FaltasColaboradorSinExoneracion($DatosSolicitud[0]->colaborador, $DatosSolicitud[0]->id_solicitud);
$listaAntecedentes = array();
$e = 0;

?>
@foreach($DatosSolUsuario as $DatSol)
  <?php
  $OtFalta = PanelTipofaltas::Tipofalta($DatSol->tipo_falta);

  $fechafalta = date('d-m-Y', strtotime($DatSol->fecha_falta));

  $listaAntecedentes[$e]['pd']                = "PD-".$DatSol->id_solicitud;
  $listaAntecedentes[$e]['Antfechasolicitud'] = $fechafalta;
  $listaAntecedentes[$e]['Anttipofalta']      = $OtFalta[0]->descripcion;
  $listaAntecedentes[$e]['Antcausa']          = $DatSol->causa;
  $e++;
  ?>
@endforeach
<?php

$templateWord->cloneRowAndSetValues('pd', $listaAntecedentes);
$templateWord->saveAs($nombre.'.docx');

header("Content-Disposition:attachment; filename=$nombre.docx; charset=utf-8");
echo file_get_contents("$nombre.docx");
?>

