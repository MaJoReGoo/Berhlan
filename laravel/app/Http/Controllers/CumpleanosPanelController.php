<?php
/*
Controlador para la visualización de los cumpleaños
Usa SQl Eloquent del archivo app\Models\Parametrizacion\PanelEmpleados.php
*/

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelEmpleados;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class CumpleanosPanelController extends Controller
 {
  public function showCumpleanos($id)
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      $fecha = $id;
      if(($fecha == 0) || (strlen($fecha) != 6))
       {
        $mes = (date("m"))*1; //mes actual
        $ano = date("Y"); //año actual
       }
      else
       {
        $mes = $fecha[4].$fecha[5];
        $ano = $fecha[0].$fecha[1].$fecha[2].$fecha[3];
       }

      $DatosCumple = PanelEmpleados::getEmpleadosCumple($mes);
      return view('panel-cumple')->with('DatosUsuario',$DatosUsuario)->with('DatosCumple',$DatosCumple)->with('Mes',$mes)->with('Ano',$ano);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }