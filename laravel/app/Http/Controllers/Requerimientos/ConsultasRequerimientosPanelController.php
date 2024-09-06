<?php
/*
Controlador de la tabla requ_solicitud
Usa SQl Eloquent del archivo app\Models\Requerimientos\PanelSolicitudes.php
*/

namespace App\Http\Controllers\Requerimientos;
use App\Http\Controllers\Controller;
use App\Models\PanelLogin;
use App\Models\Requerimientos\PanelSolicitudes;
use App\Models\Requerimientos\PanelGrupos;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class ConsultasRequerimientosPanelController extends Controller
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
        $ruta      = "requerimientos/consultausr";
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

      return view('requerimientos.panel-consultaUsr')->with('DatosUsuario',$DatosUsuario);
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
      $formData      = Request::all();
      $requerimiento = trim($formData['requerimiento']);
      $grupo         = trim($formData['grupo']);
      $estado        = trim($formData['estado']);
      $soldesde      = trim($formData['soldesde']);
      $solhasta      = trim($formData['solhasta']);
      $descripcion   = trim($formData['descripcion']);
      $cierredesde   = trim($formData['cierredesde']);
      $cierrehasta   = trim($formData['cierrehasta']);
      $apreciacion   = trim($formData['apreciacion']);
      $aprdesde      = trim($formData['aprdesde']);
      $aprhasta      = trim($formData['aprhasta']);
      $user          = Session::get('user');

      $DatosUsuario = PanelLogin::getUsuario($user);
      $empleado     = $DatosUsuario[0]->empleado;

      $Mensaje = "";
      $sql = "SELECT * FROM requ_solicitud WHERE usr_solicita = '$empleado' ";

      if($requerimiento != '')  //Si ingreso el requerimiento
       {
        if(!ctype_digit($requerimiento))  //El requerimiento debe ser un numero
          $Mensaje = "El requerimiento debe ser numérico.";
        else
          $sql = $sql." AND num_solicitud = '$requerimiento' ";
       }
      else
       {
        if($grupo != "")
          $sql = $sql." AND grupo = '$grupo' ";

        if($estado != "")
          $sql = $sql." AND estado = '$estado' ";

        if($soldesde != "")
         {
          $Mensaje = ConsultasRequerimientosPanelController::valida_fecha($soldesde);
          if($Mensaje != "")
           {
            $Redireccion = "/panel/requerimientos/consultausr";
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
           }
          else
           {
            $sql = $sql." AND fecha_solicita >= '$soldesde 00:00:00' ";
           }
         }

        if($solhasta != "")
         {
          $Mensaje = ConsultasRequerimientosPanelController::valida_fecha($solhasta);
          if($Mensaje != "")
           {
            $Redireccion = "/panel/requerimientos/consultausr";
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
           }
          else
           {
            $sql = $sql." AND fecha_solicita <= '$solhasta 23:59:59' ";
           }
         }

        if($descripcion != "")
          $sql = $sql." AND descripcion like '%$descripcion%' ";

        if($cierredesde != "")
         {
          $Mensaje = ConsultasRequerimientosPanelController::valida_fecha($cierredesde);
          if($Mensaje != "")
           {
            $Redireccion = "/panel/requerimientos/consultausr";
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
           }
          else
           {
            $sql = $sql." AND fecha_cierre >= '$cierredesde 00:00:00' ";
           }
         }

        if($cierrehasta != "")
         {
          $Mensaje = ConsultasRequerimientosPanelController::valida_fecha($cierrehasta);
          if($Mensaje != "")
           {
            $Redireccion = "/panel/requerimientos/consultausr";
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
           }
          else
           {
            $sql = $sql." AND fecha_cierre <= '$cierrehasta 23:59:59' ";
           }
         }

        if($apreciacion != "")
          $sql = $sql." AND calificacion = '$apreciacion' ";

        if($aprdesde != "")
         {
          $Mensaje = ConsultasRequerimientosPanelController::valida_fecha($aprdesde);
          if($Mensaje != "")
           {
            $Redireccion = "/panel/requerimientos/consultausr";
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
           }
          else
           {
            $sql = $sql." AND fecha_calificacion >= '$aprdesde 00:00:00' ";
           }
         }

        if($aprhasta != "")
         {
          $Mensaje = ConsultasRequerimientosPanelController::valida_fecha($aprhasta);
          if($Mensaje != "")
           {
            $Redireccion = "/panel/requerimientos/consultausr";
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
           }
          else
           {
            $sql = $sql." AND fecha_calificacion <= '$aprhasta 23:59:59' ";
           }
         }
       }

      $Datosrequerimientos = PanelSolicitudes::getSolicitudSql($sql);
      $sol = "";
      foreach($Datosrequerimientos as $DatSol)
       {
        $sol = 1;
       }

      //No se encontró ningún registro
      if($sol == "")
        $Mensaje = "No se encuentran requerimientos realizados por usted, con los parámetros ingresados.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/requerimientos/consultausr";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
      else
       {
        return view('requerimientos.panel-consultaUsrListado')->with('DatosUsuario',$DatosUsuario)->with('Datosrequerimientos',$Datosrequerimientos);
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
      $DatosSolicitud = PanelSolicitudes::getSolicitud($Solicitud);
      $user           = Session::get('user');
      $DatosUsuario   = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/consultausr";
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

      //Valido que tenga acceso a las categorías del grupo seleccionado
      if($DatosSolicitud[0]->usr_solicita != $DatosUsuario[0]->empleado)
       {
        $ErrorValidacion = "Usted no tiene acceso al requerimiento seleccionado.";
        return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
       }

      return view('requerimientos.panel-consultaUsrMasinfo')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitud',$DatosSolicitud);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ConsultaUsrMasinfo1($id)
   {
    if(Session::has('user'))
     {
      $Solicitud      = $id;
      $DatosSolicitud = PanelSolicitudes::getSolicitud($Solicitud);
      $user           = Session::get('user');
      $DatosUsuario   = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/informe";
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

      return view('requerimientos.panel-consultaUsrMasinfo1')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitud',$DatosSolicitud);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ConsultaGrupo()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/consultagru";
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

      //Valido a categorías puede tener acceso
      if($DatosUsuario[0]->master == 1)
        $DatosGrupos = PanelGrupos::getGruposActivos();
      else
        $DatosGrupos = PanelGrupos::getGruposActivosEmpleado($DatosUsuario[0]->empleado);

      return view('requerimientos.panel-consultaGru')->with('DatosUsuario',$DatosUsuario)->with('DatosGrupos',$DatosGrupos);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ConsultaGruFormulario($id)
   {
    if(Session::has('user'))
     {
      $Grupo        = $id;
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/consultagru";
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

      //Valido que tenga acceso
      if($DatosUsuario[0]->master == 0)
       {
        $AccesoGrupo = PanelGrupos::getEmpleadoUnico($Grupo, $DatosUsuario[0]->empleado);
        if($AccesoGrupo == 0) //El usuario no tiene acceso al grupo
         {
          $ErrorValidacion = "Usted no tiene acceso al grupo seleccionado.";
          return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
         }
       }

      return view('requerimientos.panel-consultaGruFormulario')->with('DatosUsuario',$DatosUsuario)->with('Grupo',$Grupo);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ConsultaGruListado()
   {
    if(Session::has('user'))
     {
      $formData      = Request::all();
      $grupo         = trim($formData['grupo']);
      $requerimiento = trim($formData['requerimiento']);
      $estado        = trim($formData['estado']);
      $empleado      = trim($formData['empleado']);
      $centro_op     = trim($formData['centro_op']);
      $cargo         = trim($formData['cargo']);
      $soldesde      = trim($formData['soldesde']);
      $solhasta      = trim($formData['solhasta']);
      $descripcion   = trim($formData['descripcion']);
      $usrcrea       = trim($formData['usrcrea']);
      $atiende       = trim($formData['atiende']);
      $cierredesde   = trim($formData['cierredesde']);
      $cierrehasta   = trim($formData['cierrehasta']);
      $categoria     = trim($formData['categoria']);
      $criticidad    = trim($formData['criticidad']);
      $apreciacion   = trim($formData['apreciacion']);
      $aprdesde      = trim($formData['aprdesde']);
      $aprhasta      = trim($formData['aprhasta']);
      $reintegro     = trim($formData['reintegro']);
      $dependencia   = trim($formData['depende']);
      $user          = Session::get('user');
      $DatosUsuario  = PanelLogin::getUsuario($user);

      $Mensaje = "";

      $sql = "SELECT * FROM requ_solicitud ";

      if(($criticidad != "") && ($requerimiento == ''))
        $sql = $sql.", requ_categorias ";

      $sql = $sql."WHERE requ_solicitud.grupo = '$grupo' ";

      if(($criticidad != "") && ($requerimiento == ''))
        $sql = $sql." AND requ_solicitud.categoria = requ_categorias.id_categoria AND requ_categorias.criticidad = '$criticidad' ";

      $sininformacion = "/panel/requerimientos/consultagru/formulario/".$grupo;

      if($requerimiento != '')  //Si ingreso el requerimiento
       {
        if(!ctype_digit($requerimiento))  //El requerimiento debe ser un numero
          $Mensaje = "El requerimiento debe ser numérico.";
        else
          $sql = $sql." AND num_solicitud = '$requerimiento' ";
       }
      else
       {
        if($estado != "")
          $sql = $sql." AND estado = '$estado' ";

        if($empleado != "")
          $sql = $sql." AND usr_solicita = '$empleado' ";

        if($centro_op != "")
          $sql = $sql." AND centro_solicitud = '$centro_op' ";

        if($cargo != "")
          $sql = $sql." AND cargo_solicitud = '$cargo' ";

        if($soldesde != "")
         {
          $Mensaje = ConsultasRequerimientosPanelController::valida_fecha($soldesde);
          if($Mensaje != "")
           {
            $Redireccion = $sininformacion;
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
           }
          else
           {
            $sql = $sql." AND fecha_solicita >= '$soldesde 00:00:00' ";
           }
         }

        if($solhasta != "")
         {
          $Mensaje = ConsultasRequerimientosPanelController::valida_fecha($solhasta);
          if($Mensaje != "")
           {
            $Redireccion = $sininformacion;
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
           }
          else
           {
            $sql = $sql." AND fecha_solicita <= '$solhasta 23:59:59' ";
           }
         }

        if($descripcion != "")
          $sql = $sql." AND descripcion like '%$descripcion%' ";

        if($usrcrea != "")
          $sql = $sql." AND creado_por = '$usrcrea' ";

        if($atiende != "")
          $sql = $sql." AND usr_atiende = '$atiende' ";

        if($cierredesde != "")
         {
          $Mensaje = ConsultasRequerimientosPanelController::valida_fecha($cierredesde);
          if($Mensaje != "")
           {
            $Redireccion = $sininformacion;
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
           }
          else
           {
            $sql = $sql." AND fecha_cierre >= '$cierredesde 00:00:00' ";
           }
         }

        if($cierrehasta != "")
         {
          $Mensaje = ConsultasRequerimientosPanelController::valida_fecha($cierrehasta);
          if($Mensaje != "")
           {
            $Redireccion = $sininformacion;
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
           }
          else
           {
            $sql = $sql." AND fecha_cierre <= '$cierrehasta 23:59:59' ";
           }
         }

        if($categoria != "")
          $sql = $sql." AND categoria = '$categoria' ";

        if($apreciacion != "")
          $sql = $sql." AND calificacion = '$apreciacion' ";

        if($aprdesde != "")
         {
          $Mensaje = ConsultasRequerimientosPanelController::valida_fecha($aprdesde);
          if($Mensaje != "")
           {
            $Redireccion = $sininformacion;
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
           }
          else
           {
            $sql = $sql." AND fecha_calificacion >= '$aprdesde 00:00:00' ";
           }
         }

        if($aprhasta != "")
         {
          $Mensaje = ConsultasRequerimientosPanelController::valida_fecha($aprhasta);
          if($Mensaje != "")
           {
            $Redireccion = $sininformacion;
            return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
           }
          else
           {
            $sql = $sql." AND fecha_calificacion <= '$aprhasta 23:59:59' ";
           }
         }

        if($reintegro != "")
          $sql = $sql." AND reintegro IN ('1', '2') ";

        if($dependencia != "")
          $sql = $sql." AND depende_de = '$dependencia' ";

       }

      $Datosrequerimientos = PanelSolicitudes::getSolicitudSql($sql);
      $sol = "";
      foreach($Datosrequerimientos as $DatSol)
       {
        $sol = 1;
       }

      //No se encontró ningún registro
      if($sol == "")
        $Mensaje = "No se encuentran requerimientos, con los parámetros ingresados.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/requerimientos/consultagru/formulario/".$grupo;
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
      else
       {
        return view('requerimientos.panel-consultaGruListado')->with('DatosUsuario',$DatosUsuario)->with('Datosrequerimientos',$Datosrequerimientos)->with('Grupo',$grupo);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ConsultaGruMasinfo($id)
   {
    if(Session::has('user'))
     {
      $Solicitud      = $id;
      $DatosSolicitud = PanelSolicitudes::getSolicitud($Solicitud);
      $user           = Session::get('user');
      $DatosUsuario   = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "requerimientos/consultagru";
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

      if($DatosUsuario[0]->master == 0)
       {
        $AccesoGrupo = PanelGrupos::getEmpleadoUnico($DatosSolicitud[0]->grupo, $DatosUsuario[0]->empleado);
        if($AccesoGrupo == 0) //El usuario no tiene acceso al grupo
         {
          $ErrorValidacion = "Usted no tiene acceso al grupo seleccionado.";
          return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
         }
       }

      return view('requerimientos.panel-consultaGruMasinfo')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitud',$DatosSolicitud);
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
