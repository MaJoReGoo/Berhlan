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
use App\Models\Disciplinarios\PanelTipofaltas;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class SolicitudDisciplinariosPanelController extends Controller
 {
  public function Solicitud()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/solicitud";
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

      $formData = Request::all();
      if(isset($formData['busqueda']))
       {
        $busqueda = trim($formData['busqueda']);
        $bq = $busqueda;
        $busqueda = "%".$busqueda."%";
       }
      else
       {
        $bq       = "";
        $busqueda = "XYZXYZXYZXYZXYZ";
       }

      $DatosEmpleados = PanelEmpleados::EmpleadosBusquedaActivos($busqueda);

      return view('disciplinarios.panel-solicitud')->with('DatosUsuario',$DatosUsuario)->with('DatosEmpleados',$DatosEmpleados)->with('bq',$bq);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function SolicitudFormulario($id)
   {
    if(Session::has('user'))
     {
      $Empleado      = $id;
      $DatosEmpleado = PanelEmpleados::getEmpleado($Empleado);
      $user          = Session::get('user');
      $DatosUsuario  = PanelLogin::getUsuario($user);

      $e = 0;
      foreach($DatosEmpleado as $DaEmp)
        $e++;

      if($e == 0)
       {
        $Mensaje     = "Este empleado no existe.";
        $Redireccion = "/panel/disciplinarios/solicitud";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/solicitud";
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

      if($DatosEmpleado == true)
       {
        return view('disciplinarios.panel-solicitudFormulario')->with('DatosUsuario',$DatosUsuario)->with('DatosEmpleado',$DatosEmpleado);
       }
      else
       {
        $Mensaje     = "";
        $Redireccion = "/panel/disciplinarios/solicitud";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function SolicitudAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData     = Request::all();
      $id_empleado  = $formData['empleado'];
      $falta        = $formData['falta'];
      $causa        = trim($formData['causa']);
      $fecha        = $formData['fecha'];
      $conocimiento = $formData['conocimiento'];
      $testigos     = trim($formData['testigos']);
      $pruebas      = trim($formData['pruebas']);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      if($falta == "")
        $Mensaje = "Debe seleccionar la falta cometida.";
      else if($causa == "")
        $Mensaje = "Debe ingresar la causa.";
      else if($fecha == "")
        $Mensaje = "Debe ingresar la fecha de la falta.";
      else if($conocimiento == "")
        $Mensaje = "Debe informar la fecha cuando conoció la falta.";

      if($Mensaje == "")
       {
        $user         = Session::get('user');
        $DatosUsuario = PanelLogin::getUsuario($user);

        $datos['colaborador']        = $id_empleado;
        $datos['tipo_falta']         = $falta;
        $datos['causa']              = $causa;
        $datos['fecha_falta']        = $fecha;
        $datos['fecha_conocimiento'] = $conocimiento;
        $datos['testigos']           = $testigos;
        $datos['pruebas']            = $pruebas;
        $datos['usr_solicita']       = $DatosUsuario[0]->empleado;
        $datos['fecha_solicita']     = NOW();
        $datos['estado']             = 1;  //Abierto - pendiente
        $datos['motivo_cierre']      = 0;
        $datos['suspension']         = 0;
        $datos['resultado']          = "";
        $datos['obs_cierre']         = "";
        $datos['usr_cierre']         = 0;

        PanelSolicitudes::insertarSolicitud($datos);
        $Mensaje   = "Solicitud creada";
       }

      $Redireccion = "/panel/disciplinarios/solicitud";
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function SolicitudMasinfo($id)
   {
    if(Session::has('user'))
     {
      $Solicitud      = $id;
      $DatosSolicitud = PanelSolicitudes::Solicitud($Solicitud);
      $user           = Session::get('user');
      $DatosUsuario   = PanelLogin::getUsuario($user);

      $e = 0;
      foreach($DatosSolicitud as $DatSol)
        $e++;

      if($e == 0)
       {
        $Mensaje     = "Solicitud no existe.";
        $Redireccion = "/panel/disciplinarios/solicitud";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/solicitud";
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

      return view('disciplinarios.panel-solicitudMasinfo')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitud',$DatosSolicitud);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function Borrar()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/borrar";
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

      return view('disciplinarios.panel-borrar')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function BorrarDetalle()
   {
    if(Session::has('user'))
     {
      $user           = Session::get('user');
      $DatosUsuario   = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/borrar";
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

      $formData  = Request::all();
      $Solicitud = $formData['numsolicitud'];
      $empleado  = $formData['empleado'];

      if($empleado == "" && $Solicitud == "")
       {
        $Mensaje     = "Debe ingresar un parámetro de búsqueda.";
        $Redireccion = "/panel/disciplinarios/borrar";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
      else if($empleado != "")
       {
        $Empleados = PanelEmpleados::EmpleadosBusquedaActivos('%'.$empleado.'%');

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

          $sql = "SELECT * FROM disc_solicitud WHERE colaborador IN ($idempleado) ORDER BY fecha_solicita DESC ";
          $DatosSolicitud = PanelSolicitudes::SolicitudesSql($sql);
          return view('disciplinarios.panel-borrarListado')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitud',$DatosSolicitud);
         }
        else
         {
          $Mensaje = "No se encuentran activos, con los parámetros ingresados.";
          $Redireccion = "/panel/disciplinarios/borrar";
          return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
         }
       }
      else
       {
        $DatosSolicitud = PanelSolicitudes::Solicitud($Solicitud);

        $e = 0;
        foreach($DatosSolicitud as $DatSol)
          $e++;

        if($e == 0)
         {
          $Mensaje     = "Esta solicitud (PD-$Solicitud) no existe.";
          $Redireccion = "/panel/disciplinarios/borrar";
          return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
         }

        return view('disciplinarios.panel-borrarDetalle')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitud',$DatosSolicitud);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function BorrarDetalleB($id)
   {
    if(Session::has('user'))
     {
      $user           = Session::get('user');
      $DatosUsuario   = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "disciplinarios/borrar";
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

      $Solicitud      = $id;
      $DatosSolicitud = PanelSolicitudes::Solicitud($Solicitud);

      $e = 0;

      foreach($DatosSolicitud as $DatSol)
        $e++;

      if($e == 0)
       {
        $Mensaje     = "Esta solicitud (PD-$Solicitud) no existe.";
        $Redireccion = "/panel/disciplinarios/borrar";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      return view('disciplinarios.panel-borrarDetalle')->with('DatosUsuario',$DatosUsuario)->with('DatosSolicitud',$DatosSolicitud);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function BorrarProcesarDB()
   {
    if(Session::has('user'))
     {
      $formData     = Request::all();
      $solicitud    = $formData['solicitud'];
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      $registro   = "PD: ".$solicitud;
      $DatosSol   = PanelSolicitudes::Solicitud($solicitud);
      $empleado   = PanelEmpleados::getEmpleado($DatosSol[0]->colaborador);
      $registro   = $registro." |*| Empleado que cometió falta: ".$empleado[0]->identificacion;
      $TpFalta    = PanelTipofaltas::Tipofalta($DatosSol[0]->tipo_falta);
      $registro   = $registro." |*| Falta cometida: ".$TpFalta[0]->descripcion;
      $registro   = $registro." |*| Causa: ".$DatosSol[0]->causa;
      $registro   = $registro." |*| Falta cometida el: ".$DatosSol[0]->fecha_falta;
      $solicitado = PanelEmpleados::getEmpleado($DatosSol[0]->usr_solicita);
      $registro   = $registro." |*| Empleado que solicito proceso: ".$solicitado[0]->identificacion;

      //Agrego el guardado al log
      $datos1             = array();
      $datos1['modulo']   = 45;    //Procesos disciplinarios
      $datos1['tipo']     = "DEL"; //Borra
      $datos1['registro'] = $registro;
      $datos1['usuario']  = $DatosUsuario[0]->empleado;
      $datos1['fecha']    = NOW();
      PanelLogin::insertarLog($datos1);
      ////////////////////////////////

      PanelSolicitudes::BorrarSolicitud($solicitud);
      $Mensaje     = "Solicitud borrada.";
      $Redireccion = "/panel/disciplinarios/borrar";
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
 }