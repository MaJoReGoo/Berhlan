<?php
/*
Controlador de la tabla requ_solicitud
Usa SQl Eloquent del archivo app\Models\Requerimientos\PanelSolicitudes.php
*/

namespace App\Http\Controllers\Requerimientos;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Requerimientos\PanelSolicitudes;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class InformeRequerimientosPanelController extends Controller
 {
  public function Informe()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/informe";
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

      return view('requerimientos.panel-informe')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function InformeDetalle()
   {
    if(Session::has('user'))
     {
      $formData = Request::all();
      $Grupo    = trim($formData['grupo']);
      $Desde    = trim($formData['desde']);
      $Hasta    = trim($formData['hasta']);
      $user     = Session::get('user');

      $DatosUsuario = PanelLogin::getUsuario($user);

      $Mensaje = "";

      if($Desde != "")
       {
        $Mensaje = InformeRequerimientosPanelController::valida_fecha($Desde);
        if($Mensaje != "")
         {
          $Redireccion = "/panel/requerimientos/informe";
          return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
         }
       }

      if($Hasta != "")
       {
        $Mensaje = InformeRequerimientosPanelController::valida_fecha($Hasta);
        if($Mensaje != "")
         {
          $Redireccion = "/panel/requerimientos/informe";
          return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
         }
       }

       return view('requerimientos.informeprueba')->with('DatosUsuario', $DatosUsuario)->with('Grupo', $Grupo)->with('Desde', $Desde)->with('Hasta', $Hasta);

       //return view('includes-panel.Pagina-Mantenimiento')->with('DatosUsuario',$DatosUsuario)->with('Grupo',$Grupo)->with('Desde',$Desde)->with('Hasta',$Hasta);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function InformeEncuesta()
   {
    if(Session::has('user'))
     {
      $formData = Request::all();
      $Grupo    = trim($formData['grupo']);
      $Desde    = trim($formData['desde']);
      $Hasta    = trim($formData['hasta']);
      $user     = Session::get('user');

      $DatosUsuario = PanelLogin::getUsuario($user);

      $Mensaje = "";

      if($Desde != "")
       {
        $Mensaje = InformeRequerimientosPanelController::valida_fecha($Desde);
        if($Mensaje != "")
         {
          $Redireccion = "/panel/requerimientos/informe";
          return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
         }
       }

      if($Hasta != "")
       {
        $Mensaje = InformeRequerimientosPanelController::valida_fecha($Hasta);
        if($Mensaje != "")
         {
          $Redireccion = "/panel/requerimientos/informe";
          return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
         }
       }

      return view('requerimientos.panel-informeEncuesta')->with('DatosUsuario',$DatosUsuario)->with('Grupo',$Grupo)->with('Desde',$Desde)->with('Hasta',$Hasta);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function InformeReintegro()
   {
    if(Session::has('user'))
     {
      $formData = Request::all();
      $Grupo    = trim($formData['grupo']);
      $Desde    = trim($formData['desde']);
      $Hasta    = trim($formData['hasta']);
      $user     = Session::get('user');

      $DatosUsuario     = PanelLogin::getUsuario($user);
      $DatosSolicitudes = PanelSolicitudes::ConReintegro($Grupo, $Desde, $Hasta);

      $Mensaje = "";

      return view('requerimientos.panel-informeReintegro')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitudes',$DatosSolicitudes)->with('Grupo',$Grupo)->with('Desde',$Desde)->with('Hasta',$Hasta);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function InformeTiempos()
   {
    if(Session::has('user'))
     {
      $formData = Request::all();
      $Grupo    = trim($formData['grupo']);
      $Desde    = trim($formData['desde']);
      $Hasta    = trim($formData['hasta']);
      $user     = Session::get('user');

      $DatosUsuario     = PanelLogin::getUsuario($user);
      $DatosSolicitudes = PanelSolicitudes::ConTiempos($Grupo, $Desde, $Hasta);

      $Mensaje = "";

      return view('requerimientos.panel-informeTiempos')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitudes',$DatosSolicitudes)->with('Grupo',$Grupo)->with('Desde',$Desde)->with('Hasta',$Hasta);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function InformeMeses()
   {
    if(Session::has('user'))
     {
      $formData = Request::all();
      $Grupo    = trim($formData['grupo']);
      $Meses    = trim($formData['meses']);
      $user     = Session::get('user');

      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/informe";
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

      return view('requerimientos.panel-informeMeses')->with('DatosUsuario',$DatosUsuario)->with('Grupo',$Grupo)->with('Meses',$Meses);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function valida_fecha($fecha)
   {
    $dia  = substr($fecha, 8, 2);
    $mes  = substr($fecha, 5, 2);
    $ano  = substr($fecha, 0, 4);
    $esl1 = substr($fecha, 4, 1);
    $esl2 = substr($fecha, 7, 1);

    $cadena = "";

    //Verifica si los guiones si fueron dados en su posición correcta
    if(($esl1 != '-') || ($esl2 != '-'))
     {
      $cadena = "La fecha esta mal dada AAAA-MM-DD";
     }
    else if((!ctype_digit($dia)) || (!ctype_digit($mes)) || (!ctype_digit($ano)))
     {
      $cadena = "La fecha esta mal dada AAAA-MM-DD";
     }
    else
     {
      //*********************VALIDA SI LA FECHA ES CORRECTA************
      $conterror = 0;

      // Verifica que el dia este entre 1 y 31
      if($dia > 31 || $dia < 1)
        $conterror = 1;

      //Verifica que el mes este entre 1 y 12
      if($mes > 12 || $mes < 1)
        $conterror = 1;

      //Verifica que el año este entre 1920 y 2100
      if($ano > 2100 || $ano < 1920)
        $conterror = 1;

      //verifica que el mes tenga el dia escogido
      if($mes == 4 || $mes == 6 || $mes == 9 || $mes == 11)
        if($dia == '31')
          $conterror = 1;

      if($mes == 2)
       {
        if($dia == 31 || $dia == 30)
          $conterror = 1;

        if($dia == 29)
          if($ano%4 != 0)
            $conterror = 1;
       }

      if($conterror == 1)
        $cadena = "La fecha no es valida ($fecha)";
     }

    return $cadena;
   }
 }
