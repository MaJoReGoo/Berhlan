<?php
/*
Controlador de la tabla acti_activo
Usa SQl Eloquent de los archivos
app\Models\Bpack\PanelActivos.php
*/

namespace App\Http\Controllers\TicActivos;
use App\Http\Controllers\Controller;
use App\Models\TicActivos\PanelActivos;
use App\Models\TicActivos\PanelConsultas;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;



class ConsultasTicActivosPanelController extends Controller
 {
  public function Consultas()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/consultasact";
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

      return view('ticactivos.panel-consultas')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }

  public function Parametrizada()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/consultasact";
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

      return view('ticactivos.panel-consultaParam')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ParamListado()
   {
    if(Session::has('user'))
     {
      $formData      = Request::all();
      $activo        = $formData['activo'];
      $tipohd        = $formData['tipohd'];
      $empleado      = trim($formData['empleado']);
      $empresa       = $formData['empresa'];
      $centro        = $formData['centro'];
      $marca         = $formData['marca'];
      $serial        = trim($formData['serial']);
      $codigoint     = trim($formData['codigoint']);
      $activofijo    = trim($formData['activofijo']);
      $aplicamtto    = $formData['aplicamtto'];
      $adquisicionde = $formData['adquisicionde'];
      $adquisicionha = $formData['adquisicionha'];
      $mesesdesde    = $formData['mesesdesde'];
      $meseshasta    = $formData['meseshasta'];
      $tamanodd      = trim($formData['tamanodd']);
      $tipodd        = trim($formData['tipodd']);
      $tamanoram     = trim($formData['tamanoram']);
      $tiporam       = trim($formData['tiporam']);
      $procesador    = trim($formData['procesador']);
      $licoffice     = $formData['licoffice'];
      $mac1          = trim($formData['mac1']);
      $mac2          = trim($formData['mac2']);
      $ip1           = trim($formData['ip1']);
      $ip2           = trim($formData['ip2']);
      $windows       = $formData['windows'];
      $estado        = $formData['estado'];

      $user           = Session::get('user');
      $DatosUsuario   = PanelLogin::getUsuario($user);

      $Mensaje = "";

      $sql = "SELECT * FROM acti_activo ";

      if($centro != "")
       {
        $sql = $sql.", param_empleados, param_centros "
                   ."WHERE acti_activo.empleado = param_empleados.id_empleado "
                   ."AND param_empleados.centro_op = param_centros.id_centro ";
       }
      else
       {
        $sql = $sql."WHERE true ";
       }

      if($activo != '')  //Si ingreso la solicitud
       {
        if(!ctype_digit($activo))
          $Mensaje = "El activo debe ser numérico.";
        else
          $sql = $sql." AND id_activo = '$activo' ";
       }
      else
       {
        if($tipohd != "")
          $sql = $sql." AND tipo = '$tipohd' ";

        if($empleado != "")
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

            $sql = $sql." AND empleado IN ($idempleado) ";
           }
          else
           {
            $Mensaje = "No se encuentran activos, con los parámetros ingresados.";
           }
         }

        if($empresa != "")
          $sql = $sql." AND empresa = '$empresa' ";

        if($centro != "")
          $sql = $sql." AND param_centros.id_centro = '$centro' ";

        if($marca != "")
          $sql = $sql." AND marca = '$marca' ";

        if($serial != "")
          $sql = $sql." AND serial like '%$serial%' ";

        if($codigoint != "")
          $sql = $sql." AND cod_interno like '%$codigoint%' ";

        if($activofijo != "")
          $sql = $sql." AND activofijo like '%$activofijo%' ";

        if($aplicamtto != "")
          $sql = $sql." AND mantenimiento = '$aplicamtto' ";

        if($adquisicionde != "")
          $sql = $sql." AND fechaadq >= '$adquisicionde 00:00:00' ";

        if($adquisicionha != "")
          $sql = $sql." AND fechaadq <= '$adquisicionha 23:59:59' ";

        if($mesesdesde != "")
          $sql = $sql." AND mes_mtto >= '$mesesdesde' ";

        if($meseshasta != "")
          $sql = $sql." AND mes_mtto <= '$meseshasta' AND mes_mtto > 0 ";

        if($tamanodd != "")
          $sql = $sql." AND tamano_dd like '%$tamanodd%' ";

        if($tipodd != "")
          $sql = $sql." AND tipo_dd like '%$tipodd%' ";

        if($tamanoram != "")
          $sql = $sql." AND tamano_ram like '%$tamanoram%' ";

        if($tiporam != "")
          $sql = $sql." AND tipo_ram like '%$tiporam%' ";

        if($procesador != "")
          $sql = $sql." AND procesador like '%$procesador%' ";

        if($licoffice != "")
          $sql = $sql." AND office = '$licoffice' ";

        if($mac1 != "")
          $sql = $sql." AND mac1 like '%$mac1%' ";

        if($mac2 != "")
          $sql = $sql." AND mac2 like '%$mac2%' ";

        if($ip1 != "")
          $sql = $sql." AND ip1 like '%$ip1%' ";

        if($ip2 != "")
          $sql = $sql." AND ip2 like '%$ip2%' ";

        if($windows != "")
          $sql = $sql." AND lic_windows = '$windows' ";

        if($estado != "")
          $sql = $sql." AND acti_activo.estado = '$estado' ";
       }

      $sql = $sql." ORDER BY id_activo ";

      $DatosActivos = PanelActivos::ActivosSql($sql);

      $sol = "";
      foreach($DatosActivos as $DatAct)
       {
        $sol = 1;
       }

      //No se encontró ningún registro
      if($sol == "")
        $Mensaje = "No se encuentran activos, con los parámetros ingresados.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/ticactivos/consultasparam";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
      else
       {
        return view('ticactivos.panel-consultaParamListado')->with('DatosUsuario',$DatosUsuario)->with('DatosActivos',$DatosActivos);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ParamDetalle($id)
   {
    if(Session::has('user'))
     {
      $Activo       = $id;
      $DatosActivo  = PanelActivos::Activo($Activo);
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/consultasact";
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
      if($DatosActivo->count() == 0)
       {
        $Mensaje = "Solicitud no existe.";
        $Redireccion = "/panel/ticactivos/consultasparam";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      return view('ticactivos.panel-consultaParamDetalle')->with('DatosUsuario',$DatosUsuario)->with('DatosActivo',$DatosActivo);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function Cantidades()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/consultasact";
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

      return view('ticactivos.panel-consultaCantidades')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function Proyeccion()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/consultasact";
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

      return view('ticactivos.panel-consultaProye')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function ProyeccionListado()
   {
    if(Session::has('user'))
     {
      $formData     = Request::all();
      $empresa      = $formData['empresa'];
      $tipohd       = $formData['tipohd'];
      $centro       = $formData['centro'];
      $fecha        = $formData['fecha'];
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      $Mensaje = "";

      $sql = "SELECT acti_activo.id_activo, MAX(acti_actividades.fecha) AS ultfecha "
            ."FROM  acti_activo, acti_actividades, param_empleados, param_centros "
            ."WHERE acti_activo.id_activo           = acti_actividades.activo "
            ."AND   acti_activo.empleado            = param_empleados.id_empleado "
            ."AND   param_empleados.centro_op       = param_centros.id_centro "
            ."AND   acti_activo.estado              = '1' "
            ."AND   acti_activo.mantenimiento       = 'S' "
            ."AND   acti_actividades.mantenimiento != 'N' ";

      if($empresa != "")
        $sql = $sql." AND acti_activo.empresa = '$empresa' ";

      if($tipohd != "")
        $sql = $sql." AND acti_activo.tipo = '$tipohd' ";

      if($centro != "")
        $sql = $sql." AND param_centros.id_centro = '$centro' ";

      $sql = $sql."GROUP BY acti_activo.id_activo ORDER BY acti_activo.id_activo";

      $DatosActivos = PanelConsultas::ProyeccionSql($sql);

      $sol = "";
      foreach($DatosActivos as $DatAct)
       {
        $sol = 1;
       }

      //No se encontró ningún registro
      if($sol == "")
       {
        $Mensaje = "No se encuentra información, con los parámetros ingresados.";
        $Redireccion = "/panel/ticactivos/consultasproye";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      return view('ticactivos.panel-consultaProyeListado')->with('DatosUsuario',$DatosUsuario)->with('DatosActivos',$DatosActivos)->with('fechacorte',$fecha);

     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


   public function Exempleados()
   {
       if (Session::has('user')) {
           $user = Session::get('user');
           $DatosUsuario = PanelLogin::getUsuario($user);

           //Valido que el usuario tenga acceso
           if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
           {
               $ruta = "ticactivos/consultasact";
               $DatosMenu = PanelLogin::getMenuRuta($ruta);
               if ($DatosMenu[0]->libre_acceso == 0) // Si el modulo no es de libre acceso
               {
                   $idmenu = $DatosMenu[0]->id_menu;

                   $ModUser = explode(',', $DatosUsuario[0]->modulos);
                   $NumModUser = count($ModUser);
                   $acceso = 0;
                   for ($i = 0; $i < $NumModUser; $i++) {
                       if ($idmenu == $ModUser[$i]) {
                           $acceso = 1;
                           break;
                       }
                   }

                   if ($acceso == 0) //El usuario no tiene acceso al modulo
                   {
                       $ErrorValidacion = "Usted no esta tiene acceso al módulo.";
                       return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
                   }
               }
           }
           //Termina validación
           $DatosExempleados = PanelConsultas::ExmpleadosGroup();

           return view('ticactivos.panel-consultaExempleados')->with('DatosUsuario', $DatosUsuario)->with('DatosExempleados', $DatosExempleados);
       } else {
           $ErrorValidacion = "Error de conexión, intente de nuevo.";
           return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
       }
   }


  public function Edades()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/consultasact";
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

      return view('ticactivos.panel-consultaEdades')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function Mantenimientos()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/consultasact";
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

      return view('ticactivos.panel-consultaMtto')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function MantenimientosListado()
   {
    if(Session::has('user'))
     {
      $formData     = Request::all();
      $empresa      = $formData['empresa'];
      $tipohd       = $formData['tipohd'];
      $fechadesde   = $formData['fechadesde'];
      $fechahasta   = $formData['fechahasta'];
      $empleado     = $formData['empleado'];
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      $Mensaje = "";

      $sql = "SELECT id_activo, acti_actividades.fecha AS fechaac, usuario, cod_interno, "
            ."acti_tipoactivo.descripcion AS destipo, marca,  id_actividad, activofijo, "
            ."empresa, empleado "
            ."FROM  acti_activo, acti_tipoactivo, acti_actividades, param_empleados "
            ."WHERE acti_activo.id_activo    = acti_actividades.activo "
            ."AND   acti_activo.tipo         = acti_tipoactivo.id_tipoactivo "
            ."AND   acti_actividades.usuario = param_empleados.id_empleado "
            ."AND   acti_actividades.mantenimiento IN ('P', 'C') ";

      if($empresa != "")
        $sql = $sql." AND acti_activo.empresa = '$empresa' ";

      if($tipohd != "")
        $sql = $sql." AND acti_activo.tipo = '$tipohd' ";

      if($fechadesde != "")
        $sql = $sql." AND acti_actividades.fecha >= '$fechadesde' ";

      if($fechahasta != "")
        $sql = $sql." AND acti_actividades.fecha <= '$fechahasta' ";

      if($empleado != "")
        $sql = $sql." AND acti_actividades.usuario = '$empleado' ";

      $sql = $sql." ORDER BY acti_actividades.fecha, acti_tipoactivo.descripcion ";

      $DatosActivos = PanelConsultas::ProyeccionSql($sql);

      $sol = "";
      foreach($DatosActivos as $DatAct)
       {
        $sol = 1;
       }

      //No se encontró ningún registro
      if($sol == "")
       {
        $Mensaje = "No se encuentra información, con los parámetros ingresados.";
        $Redireccion = "/panel/ticactivos/consultasmtto";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      return view('ticactivos.panel-consultaMttoListado')->with('DatosUsuario',$DatosUsuario)->with('DatosActivos',$DatosActivos);

     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function Tareas()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/consultasact";
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

      return view('ticactivos.panel-consultaTareas')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function TareasListado()
   {
    if(Session::has('user'))
     {
      $formData     = Request::all();
      $empresa      = $formData['empresa'];
      $empleado     = $formData['empleado'];
      $fechadesde   = $formData['fechadesde'];
      $fechahasta   = $formData['fechahasta'];
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      $Mensaje = "";

      $sql = "SELECT acti_tareas.id_tarea, COUNT(acti_tareas.id_tarea) AS cantidad "
            ."FROM acti_tareas, acti_actv_tareas, acti_actividades, acti_activo "
            ."WHERE acti_tareas.id_tarea       = acti_actv_tareas.tarea "
            ."AND   acti_actv_tareas.actividad = acti_actividades.id_actividad "
            ."AND   acti_actividades.activo    = acti_activo.id_activo ";

      $param = array();

      if($empresa != "")
       {
        $sql = $sql." AND acti_activo.empresa = '$empresa' ";
        $param['empresa'] = $empresa;
       }
      else
       {
        $param['empresa'] = "";
       }

      if($empleado != "")
       {
        $sql = $sql." AND acti_actividades.usuario = '$empleado' ";
        $param['empleado'] = $empleado;
       }
      else
       {
        $param['empleado'] = "";
       }

      if($fechadesde != "")
       {
        $sql = $sql." AND acti_actividades.fecha >= '$fechadesde' ";
        $param['fechadesde'] = $fechadesde;
       }
      else
       {
        $param['fechadesde'] = "";
       }

      if($fechahasta != "")
       {
        $sql = $sql." AND acti_actividades.fecha <= '$fechahasta' ";
        $param['fechahasta'] = $fechahasta;
       }
      else
       {
        $param['fechahasta'] = "";
       }

      $sql = $sql." GROUP BY id_tarea ORDER BY acti_tareas.descripcion ";

      $DatosTareas = PanelConsultas::ProyeccionSql($sql);

      $sol = "";
      foreach($DatosTareas as $DatTar)
       {
        $sol = 1;
       }

      //No se encontró ningún registro
      if($sol == "")
       {
        $Mensaje = "No se encuentra información, con los parámetros ingresados.";
        $Redireccion = "/panel/ticactivos/consultastareas";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      return view('ticactivos.panel-consultaTareasListado')->with('DatosUsuario',$DatosUsuario)->with('DatosTareas',$DatosTareas)->with('DatosParam',$param);

     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function Esperados()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "ticactivos/consultasact";
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

      return view('ticactivos.panel-consultaEsperados')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function EsperadosListado()
   {
    if(Session::has('user'))
     {
      $formData     = Request::all();
      $empresa      = $formData['empresa'];
      $centro       = $formData['centro'];
      $mes          = $formData['mes'];
      $anio         = $formData['anio'];
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      $Mensaje = "";
      $cortehasta  = $anio."-".$mes."-31 23:59:59";
      $cortedesde  = $anio."-".$mes."-01 00:00:00";

      $sql = "SELECT acti_activo.id_activo, "
            ."       (SELECT MAX(acti_actividades.fecha) FROM acti_actividades "
            ."        WHERE acti_activo.id_activo = acti_actividades.activo "
            ."        AND   acti_actividades.mantenimiento != 'N' "
            ."        AND   acti_actividades.fecha <= '$cortehasta' ) AS ultfecha "
            ."FROM  acti_activo, param_empleados, param_centros "
            ."WHERE acti_activo.empleado            = param_empleados.id_empleado "
            ."AND   param_empleados.centro_op       = param_centros.id_centro "
            ."AND   acti_activo.estado              = '1' "
            ."AND   acti_activo.mantenimiento       = 'S' ";

      if($empresa != "")
        $sql = $sql." AND acti_activo.empresa = '$empresa' ";

      if($centro != "")
        $sql = $sql." AND param_centros.id_centro = '$centro' ";

      $sql = $sql." ORDER BY acti_activo.id_activo";


      $DatosActivos = PanelConsultas::ProyeccionSql($sql);

      $sol = "";
      foreach($DatosActivos as $DatAct)
       {
        $sol = 1;
       }

      //No se encontró ningún registro
      if($sol == "")
       {
        $Mensaje     = "No se encuentra información, con los parámetros ingresados.";
        $Redireccion = "/panel/ticactivos/consultasesperados";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }

      return view('ticactivos.panel-consultaEsperadosListado')->with('DatosUsuario',$DatosUsuario)->with('DatosActivos',$DatosActivos)->with('cortedesde',$cortedesde)->with('cortehasta',$cortehasta);

     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }

   public function obtenerDatosEmpleado($id)
    {
        // Realiza la lógica para obtener los datos del empleado con el ID proporcionado
        $activos = PanelActivos::ActivoxEmpleado($id); // Ejemplo de cómo obtener un empleado por ID

        // Devuelve la vista parcial con los datos del empleado
        return $activos;
    }

    public function activosActualesXHistorico()
    {

        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "ticactivos/consultasact";
                $DatosMenu = PanelLogin::getMenuRuta($ruta);
                if ($DatosMenu[0]->libre_acceso == 0) // Si el modulo no es de libre acceso
                {
                    $idmenu = $DatosMenu[0]->id_menu;

                    $ModUser = explode(',', $DatosUsuario[0]->modulos);
                    $NumModUser = count($ModUser);
                    $acceso = 0;
                    for ($i = 0; $i < $NumModUser; $i++) {
                        if ($idmenu == $ModUser[$i]) {
                            $acceso = 1;
                            break;
                        }
                    }

                    if ($acceso == 0) //El usuario no tiene acceso al modulo
                    {
                        $ErrorValidacion = "Usted no esta tiene acceso al módulo.";
                        return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
                    }
                }
            }
            //Termina validación
            $formData = Request::all();
            $id_empleado = $formData['empleado_act'];

            $datos = PanelEmpleados::getEmpleado($id_empleado)->first();

            $identificacion = $datos->identificacion;
            $usuario = $datos->primer_nombre . '.' . $datos->primer_apellido;
            $nombres = $datos->primer_nombre . ' ' . $datos->primer_apellido;

            //Termina validación
            $DatosActivosAsignados = PanelActivos::ActivosActAsignados($identificacion, $usuario, $nombres);

            return view('ticactivos.panel-consultaActivosHistoricos')->with('DatosUsuario', $DatosUsuario)->with('DatosActivosAsignados', $DatosActivosAsignados);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }

    public function UsuarioXactivoAsignado()
    {
        if (Session::has('user')) {
            $user = Session::get('user');
            $DatosUsuario = PanelLogin::getUsuario($user);

            //Valido que el usuario tenga acceso
            if ($DatosUsuario[0]->master == 0) //Si no es un usuario tipo máster
            {
                $ruta = "ticactivos/consultasact";
                $DatosMenu = PanelLogin::getMenuRuta($ruta);
                if ($DatosMenu[0]->libre_acceso == 0) // Si el modulo no es de libre acceso
                {
                    $idmenu = $DatosMenu[0]->id_menu;

                    $ModUser = explode(',', $DatosUsuario[0]->modulos);
                    $NumModUser = count($ModUser);
                    $acceso = 0;
                    for ($i = 0; $i < $NumModUser; $i++) {
                        if ($idmenu == $ModUser[$i]) {
                            $acceso = 1;
                            break;
                        }
                    }

                    if ($acceso == 0) //El usuario no tiene acceso al modulo
                    {
                        $ErrorValidacion = "Usted no esta tiene acceso al módulo.";
                        return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
                    }
                }
            }

            //Termina validación
            $formData = Request::all();
            $activoI = $formData['activo_act'];
            // Realiza la lógica para obtener los datos del empleado con el ID proporcionado
            $activos = PanelActivos::UsuariosXactivo($activoI); // Suponiendo que $activos es un arreglo de objetos PanelActivos
            $activosFirst = PanelActivos::UsuariosXactivo($activoI)->first(); // Suponiendo que $activos es un arreglo de objetos PanelActivos
           // dd($activosFirst);



            $colaboradores = []; // Array para almacenar los nombres de los colaboradores

            $nombreRegex3 = '/Colaborador:\s+[0-9]+/';

            foreach ($activos as $activo) {
                // Asegúrate de acceder a la propiedad correcta del objeto $activo
                $textoActivo = $activo->cambio; // Suponiendo que 'texto' es la propiedad que contiene la información relevante
                $nombreRegex1 = '/Colaborador:\s+(\w+\.\w+)/';
                $nombreRegex2 = '/Colaborador:\s+(\w+\s\w+)/';

                $nombreRegex = $nombreRegex1; // Por defecto, utilizamos la primera expresión regular
                if (preg_match($nombreRegex1, $textoActivo, $matches)) {
                    // Si la primera expresión regular coincide, utilizamos esa
                    list($primerNombre, $primerApellido) = explode('.', $matches[1]);
                    $colaboradores[] = ["nombre" => $primerNombre, "apellido" => $primerApellido, "identificacion" => null,"fecha"=>$activo->fecha];
                } elseif (preg_match($nombreRegex2, $textoActivo, $matches)) {
                    // Si la primera expresión regular no coincide, intentamos con la segunda
                    list($primerNombre, $primerApellido) = explode(' ', $matches[1]);
                    $colaboradores[] = ["nombre" => $primerNombre, "apellido" => $primerApellido, "identificacion" => null,"fecha"=>$activo->fecha];

                }
                // Buscar por identificación
                $identificacionRegex = '/Colaborador:\s+(\d+)/';
                if (preg_match($identificacionRegex, $textoActivo, $matches)) {
                    $identificacion = $matches[1];
                    $colaboradores[] = ["nombre" => null, "apellido" => null, "identificacion" => $identificacion,"fecha"=>$activo->fecha];
                }
            }

            $Datosempleado = [];
            foreach ($colaboradores as $cola) {

                $primerNombre = $cola["nombre"];
                $primerApellido = $cola["apellido"];
                $Identificacion = $cola["identificacion"];
                $fecha = $cola["fecha"];
                $empleadosEncontrados = PanelActivos::EmpleadoDeUsuario($primerNombre, $primerApellido, $Identificacion);

                $Datosempleado[] = [$empleadosEncontrados,$fecha];


            }


        /* dd($Datosempleado); */
            return view('ticactivos.panel-consultaActivosUsuario')->with('DatosUsuario', $DatosUsuario)->with('Datosempleado', $Datosempleado)->with('activosFirst', $activosFirst)->with('activoI',$activoI);
        } else {
            $ErrorValidacion = "Error de conexión, intente de nuevo.";
            return view('panel-login')->with('ErrorValidacion', $ErrorValidacion);
        }
    }
 }
