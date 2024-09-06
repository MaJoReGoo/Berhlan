<?php
/*
Controlador de la tabla requ_grupos
Usa SQl Eloquent del archivo app\Models\Requerimientos\PanelPriorizaciones.php
*/

namespace App\Http\Controllers\Requerimientos;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Requerimientos\PanelPriorizaciones;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class PriorizacionRequerimientosPanelController extends Controller
 {
  public function PriorizacionListado()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/priorizacion";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if($DatosMenu[0]->libre_acceso == 0)  //Si el modulo no es de libre acceso
         {
          $idmenu    = $DatosMenu[0]->id_menu;

          $ModUser    = explode(',',$DatosUsuario[0]->modulos);
          $NumModUser = count($ModUser);
          $acceso     = 0;
          for($i=0; $i<$NumModUser; $i++)
           {
            if($idmenu == $ModUser[$i])
             {
              $acceso = 1;
              break;
             }
           }

          if($acceso == 0) //El usuario no tiene acceso al modulo
           {
            $ErrorValidacion = "Usted no tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
           }
         }
       }
      //Termina validación

      $DatosCriterios = PanelPriorizaciones::CriteriosIniciales();
      return view('requerimientos.panel-priorizacion')->with('DatosUsuario',$DatosUsuario)->with('DatosCriterios',$DatosCriterios);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function PriorizacionModificarDB()
   {
    if(Session::has('user'))
     {
      $formData  = Request::all();
      $grupo     = $formData['grupo'];
      $criterio1 = $formData['criterio1'];
      $criterio2 = $formData['criterio2'];
      $criterio3 = $formData['criterio3'];
      $criterio4 = $formData['criterio4'];
      $valor1    = trim($formData['valor1']);
      $valor2    = trim($formData['valor2']);
      $valor3    = trim($formData['valor3']);
      $valor4    = trim($formData['valor4']);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      if((!ctype_digit($valor1)) || (!ctype_digit($valor2)) || (!ctype_digit($valor3)) || (!ctype_digit($valor4)))
        $Mensaje = "No es posible ingresar la priorización. El día solo debe contener números.";

      if($Mensaje == "")
       {
        $datos['tiempo'] = $valor1;
        PanelPriorizaciones::actualizarPriorizacion($grupo, $criterio1, $datos);

        $datos['tiempo'] = $valor2;
        PanelPriorizaciones::actualizarPriorizacion($grupo, $criterio2, $datos);

        $datos['tiempo'] = $valor3;
        PanelPriorizaciones::actualizarPriorizacion($grupo, $criterio3, $datos);

        $datos['tiempo'] = $valor4;
        PanelPriorizaciones::actualizarPriorizacion($grupo, $criterio4, $datos);

        $Mensaje = "Priorización actualizada.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $datos1             = array();
        $datos1['modulo']   = 29;    //Grupos requerimientos
        $datos1['tipo']     = "UPD"; //Actualiza
        $datos1['registro'] = "Id grupo: $grupo |*| Criterio: $criterio1 tiempo: $valor1 |*| Criterio: $criterio2 tiempo: $valor2 |*| Criterio: $criterio3 tiempo: $valor3 |*| Criterio: $criterio4 tiempo: $valor4";
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////
       }

      $Redireccion = "/panel/requerimientos/priorizacion";
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }