<?php
/*
Controlador de la tabla disc_solicitud
Usa SQl Eloquent del archivo app\Models\Disciplinarios\PanelSolicitudes.php
*/

namespace App\Http\Controllers\Disciplinarios;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Disciplinarios\PanelSolicitudes;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class ConsultasDisciplinariosPanelController extends Controller
 {
  public function ConsultaUsuario()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/consultausr";
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

      return view('disciplinarios.panel-consultaUsr')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ConsultaUsrListado()
   {
    if(Session::has('user'))
     {
      $formData       = Request::all();
      $solicitud      = $formData['solicitud'];
      $identificacion = $formData['identificacion'];
      $usr_falta      = $formData['usr_falta'];
      $estado         = $formData['estado'];
      $soldesde       = $formData['soldesde'];
      $solhasta       = $formData['solhasta'];
      $tpfalta        = $formData['tpfalta'];
      $causa          = trim($formData['causa']);
      $motivo         = $formData['motivo'];
      $user           = Session::get('user');
      $DatosUsuario   = PanelLogin::getUsuario($user);
      $empleado       = $DatosUsuario[0]->empleado;

      $Mensaje = "";
      $sql = "SELECT * FROM disc_solicitud WHERE usr_solicita = '$empleado' ";

      if($solicitud != '')  //Si ingreso la solicitud
       {
        if(!ctype_digit($solicitud))  //La solicitud debe ser un numero
          $Mensaje = "La solicitud debe ser numérica.";
        else
          $sql = $sql." AND id_solicitud = '$solicitud' ";
       }
      else
       {
        if($identificacion != "")
         {
          $Usrfalta = PanelEmpleados::getEmpleadoIdent($identificacion);
          $e = 0;
          foreach($Usrfalta as $DatSol)
            $e++;
          if($e > 0)
            $sql = $sql." AND colaborador = '".$Usrfalta[0]->id_empleado."' ";
          else
            $sql = $sql." AND colaborador < '0' ";
         }

        if($usr_falta != "")
          $sql = $sql." AND colaborador = '$usr_falta' ";

        if($estado != "")
          $sql = $sql." AND estado = '$estado' ";

        if($tpfalta != "")
          $sql = $sql." AND tipo_falta = '$tpfalta' ";

        if($causa != "")
          $sql = $sql." AND causa like '%$causa%' ";

        if($motivo != "")
          $sql = $sql." AND motivo_cierre = '$motivo' ";

        $Redireccion1 = "/panel/disciplinarios/consultausr";

        if($soldesde != "")
         {
          $Mensaje = ConsultasDisciplinariosPanelController::valida_fecha($soldesde);
          if($Mensaje != "")
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion1);
          else
            $sql = $sql." AND fecha_solicita >= '$soldesde 00:00:00' ";
         }

        if($solhasta != "")
         {
          $Mensaje = ConsultasDisciplinariosPanelController::valida_fecha($solhasta);
          if($Mensaje != "")
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion1);
          else
            $sql = $sql." AND fecha_solicita <= '$solhasta 23:59:59' ";
         }
       }

      $sql = $sql." ORDER BY fecha_solicita ";
      $DatosSolicitudes = PanelSolicitudes::SolicitudesSql($sql);
      $sol = "";
      foreach($DatosSolicitudes as $DatSol)
       {
        $sol = 1;
       }

      //No se encontró ningún registro
      if($sol == "")
        $Mensaje = "No se encuentran solicitudes realizadas por usted, con los parámetros ingresados.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/disciplinarios/consultausr";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
      else
       {
        return view('disciplinarios.panel-consultaUsrListado')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitudes',$DatosSolicitudes);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ConsultaUsrMasinfo($id)
   {
    if(Session::has('user'))
     {
      $Solicitud      = $id;
      $DatosSolicitud = PanelSolicitudes::Solicitud($Solicitud);

      $e = 0;
      foreach($DatosSolicitud as $DatSol)
        $e++;

      if($e == 0)
       {
        $Mensaje = "Solicitud no existe.";
        $Redireccion = "/panel/disciplinarios/consultausr";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/consultausr";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if($DatosMenu[0]->libre_acceso == 0)  // Si el modulo no es de libre acceso
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
            $ErrorValidacion = "Usted no esta tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
           }
         }
       }
      //Termina validación


      if($DatosSolicitud[0]->usr_solicita != $DatosUsuario[0]->empleado)
       {
        $ErrorValidacion = "Usted no tiene acceso la solicitud seleccionada.";
        return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
       }

      return view('disciplinarios.panel-consultaUsrMasinfo')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitud',$DatosSolicitud);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ConsultaAdm()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/consultaadm";
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

      return view('disciplinarios.panel-consultaAdm')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ConsultaAdmListado()
   {
    if(Session::has('user'))
     {
      $formData       = Request::all();
      $empleado       = $formData['empleado'];
      $solicitud      = $formData['solicitud'];
      $estado         = $formData['estado'];
      $usr_solicita   = $formData['usr_solicita'];
      $soldesde       = $formData['soldesde'];
      $solhasta       = $formData['solhasta'];
      $faltadesde     = $formData['faltadesde'];
      $faltahasta     = $formData['faltahasta'];
      $tpfalta        = $formData['tpfalta'];
      $causa          = trim($formData['causa']);
      $motivo         = $formData['motivo'];
      $descargosdesde = $formData['descargosdesde'];
      $descargoshasta = $formData['descargoshasta'];
      $usr_cierre     = $formData['usr_cierre'];
      $cierredesde    = $formData['cierredesde'];
      $cierrehasta    = $formData['cierrehasta'];
      $user           = Session::get('user');
      $DatosUsuario   = PanelLogin::getUsuario($user);

      $Mensaje = "";
      $sql = "SELECT * FROM disc_solicitud WHERE true ";

      if($solicitud != '')  //Si ingreso la solicitud
       {
        if(!ctype_digit($solicitud))  //La solicitud debe ser un numero
          $Mensaje = "La solicitud debe ser numérica.";
        else
          $sql = $sql." AND id_solicitud = '$solicitud' ";
       }
      else
       {
        if($empleado != "")
         {
          $Empleados = PanelEmpleados::EmpleadosBusqueda('%'.$empleado.'%');

          $e = 0;
          if($Empleados->count() > 0)
           {
            foreach($Empleados as $DatEmp)
             {
              if($e == 0)
               {
                $e++;
                $idempleado = $DatEmp->id_empleado;
               }
              else
               {
                $idempleado = $idempleado.", ".$DatEmp->id_empleado;
               }
             }
            $sql = $sql." AND colaborador IN ($idempleado) ";
           }
          else
           {
            $sql = $sql." AND colaborador < '0' ";
           }
         }

        if($estado != "")
          $sql = $sql." AND estado = '$estado' ";

        if($usr_solicita != "")
          $sql = $sql." AND usr_solicita = '$usr_solicita' ";

        if($tpfalta != "")
          $sql = $sql." AND tipo_falta = '$tpfalta' ";

        if($causa != "")
          $sql = $sql." AND causa like '%$causa%' ";

        if($motivo != "")
          $sql = $sql." AND motivo_cierre = '$motivo' ";

        if($usr_cierre != "")
          $sql = $sql." AND usr_cierre = '$usr_cierre' ";

        $Redireccion1 = "/panel/disciplinarios/consultaadm";

        if($soldesde != "")
         {
          $Mensaje = ConsultasDisciplinariosPanelController::valida_fecha($soldesde);
          if($Mensaje != "")
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion1);
          else
            $sql = $sql." AND fecha_solicita >= '$soldesde 00:00:00' ";
         }

        if($solhasta != "")
         {
          $Mensaje = ConsultasDisciplinariosPanelController::valida_fecha($solhasta);
          if($Mensaje != "")
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion1);
          else
            $sql = $sql." AND fecha_solicita <= '$solhasta 23:59:59' ";
         }

        if($faltadesde != "")
         {
          $Mensaje = ConsultasDisciplinariosPanelController::valida_fecha($faltadesde);
          if($Mensaje != "")
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion1);
          else
            $sql = $sql." AND fecha_falta >= '$faltadesde 00:00:00' ";
         }

        if($faltahasta != "")
         {
          $Mensaje = ConsultasDisciplinariosPanelController::valida_fecha($faltahasta);
          if($Mensaje != "")
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion1);
          else
            $sql = $sql." AND fecha_falta <= '$faltahasta 23:59:59' ";
         }

        if($descargosdesde != "")
         {
          $Mensaje = ConsultasDisciplinariosPanelController::valida_fecha($descargosdesde);
          if($Mensaje != "")
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion1);
          else
            $sql = $sql." AND fecha_descargos >= '$descargosdesde 00:00:00' ";
         }

        if($descargoshasta != "")
         {
          $Mensaje = ConsultasDisciplinariosPanelController::valida_fecha($descargoshasta);
          if($Mensaje != "")
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion1);
          else
            $sql = $sql." AND fecha_descargos <= '$descargoshasta 23:59:59' ";
         }

        if($cierredesde != "")
         {
          $Mensaje = ConsultasDisciplinariosPanelController::valida_fecha($cierredesde);
          if($Mensaje != "")
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion1);
          else
            $sql = $sql." AND fecha_cierre >= '$cierredesde 00:00:00' ";
         }

        if($cierrehasta != "")
         {
          $Mensaje = ConsultasDisciplinariosPanelController::valida_fecha($cierrehasta);
          if($Mensaje != "")
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion1);
          else
            $sql = $sql." AND fecha_cierre <= '$cierrehasta 23:59:59' ";
         }
       }

      $sql = $sql." ORDER BY fecha_solicita ";
      $DatosSolicitudes = PanelSolicitudes::SolicitudesSql($sql);
      $sol = "";
      foreach($DatosSolicitudes as $DatSol)
       {
        $sol = 1;
       }

      //No se encontró ningún registro
      if($sol == "")
        $Mensaje = "No se encuentran solicitudes realizadas con los parámetros ingresados.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/disciplinarios/consultaadm";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
      else
       {
        return view('disciplinarios.panel-consultaAdmListado')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitudes',$DatosSolicitudes);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ConsultaAdmMasinfo($id)
   {
    if(Session::has('user'))
     {
      $Solicitud      = $id;
      $DatosSolicitud = PanelSolicitudes::Solicitud($Solicitud);

      $e = 0;
      foreach($DatosSolicitud as $DatSol)
        $e++;

      if($e == 0)
       {
        $Mensaje = "Solicitud no existe.";
        $Redireccion = "/panel/disciplinarios/consultaadm";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/consultaadm";
        $DatosMenu = PanelLogin::getMenuRuta($ruta);
        if($DatosMenu[0]->libre_acceso == 0)  // Si el modulo no es de libre acceso
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
            $ErrorValidacion = "Usted no esta tiene acceso al módulo.";
            return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
           }
         }
       }
      //Termina validación

      return view('disciplinarios.panel-consultaAdmMasinfo')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitud',$DatosSolicitud);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function Informe()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/informe";
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

      return view('disciplinarios.panel-informe')->with('DatosUsuario',$DatosUsuario);
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
      $Desde    = trim($formData['desde']);
      $Hasta    = trim($formData['hasta']);
      $user     = Session::get('user');

      $DatosUsuario = PanelLogin::getUsuario($user);

      $Mensaje = "";

      if($Desde != "")
       {
        $Mensaje = ConsultasDisciplinariosPanelController::valida_fecha($Desde);
        if($Mensaje != "")
         {
          $Redireccion = "/panel/disciplinarios/informe";
          return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
         }
       }

      if($Hasta != "")
       {
        $Mensaje = ConsultasDisciplinariosPanelController::valida_fecha($Hasta);
        if($Mensaje != "")
         {
          $Redireccion = "/panel/disciplinarios/informe";
          return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
         }
       }

      return view('disciplinarios.panel-informeDetalle')->with('DatosUsuario',$DatosUsuario)->with('Desde',$Desde)->with('Hasta',$Hasta);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function Reporteg()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/reporteg";
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

      return view('disciplinarios.panel-reporteg')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ReportegDetalle()
   {
    if(Session::has('user'))
     {
      $formData = Request::all();
      $Desde    = trim($formData['desde']);
      $Hasta    = trim($formData['hasta']);
      $Estado   = trim($formData['estado']);
      $user     = Session::get('user');

      $DatosUsuario = PanelLogin::getUsuario($user);

      $Mensaje = "";

      if($Desde != "")
       {
        $Mensaje = ConsultasDisciplinariosPanelController::valida_fecha($Desde);
        if($Mensaje != "")
         {
          $Redireccion = "/panel/disciplinarios/reporteg";
          return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
         }
       }

      if($Hasta != "")
       {
        $Mensaje = ConsultasDisciplinariosPanelController::valida_fecha($Hasta);
        if($Mensaje != "")
         {
          $Redireccion = "/panel/disciplinarios/reporteg";
          return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
         }
       }

      $DatosSolicitudes = PanelSolicitudes::SolicitudesFechas($Desde, $Hasta, $Estado);

      return view('disciplinarios.panel-reportegDetalle')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitudes',$DatosSolicitudes)->with('Desde',$Desde)->with('Hasta',$Hasta);
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