<?php
/*
Controlador de la tabla param_cargos
Usa SQl Eloquent del archivo app\Models\Parametrizacion\PanelCargos.php
*/

namespace App\Http\Controllers\Parametrizacion;
use App\Http\Controllers\Controller;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use DB;


class CargosPanelController extends Controller
 {
  public function showCargos()
   {
    if(Session::has('user'))
     {
      $user            = Session::get('user');
      $DatosUsuario    = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "parametrizacion/cargos";
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

      $DatosCargos     = PanelCargos::getCargos();
      $CargosActivos   = PanelCargos::getCantidadCargosActivos();
      $CargosInactivos = PanelCargos::getCantidadCargosInactivos();
      return view('parametrizacion.panel-cargos')->with('DatosUsuario',$DatosUsuario)->with('DatosCargos',$DatosCargos)->with('CargosActivos',$CargosActivos)->with('CargosInactivos',$CargosInactivos);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }

  public function CargosAgregar()
   {
    if(Session::has('user'))
     {
      $ErrorValidacion = "";  //Variable que retorna el error en caso de que no pase la validación
      $user            = Session::get('user');
      $DatosUsuario    = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "parametrizacion/cargos";
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

      return view('parametrizacion.panel-cargosAgregar')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function CargosAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $descripcion = trim($formData['descripcion']);
      $area        = $formData['area'];

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $CargoDuplicado  = PanelCargos::getCargoUnico($descripcion, $area);

      if($CargoDuplicado != 0)
        $Mensaje = "Ya se encuentra un cargo con esa descripción, en el área seleccionada.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar el nombre del cargo.";
      else if($area == "")
        $Mensaje = "Debe seleccionar el área.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/parametrizacion/cargos/agregar";
       }
      else
       {
        $datos['descripcion'] = $descripcion;
        $datos['area']        = $area;
        $datos['estado']      = 1; //Activo

        PanelCargos::insertarCargo($datos);
        $Mensaje = "Cargo creado.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $idcargo            = PanelCargos::UltimoCargo();
        $datos1             = array();
        $datos1['modulo']   = 9;     //Cargos
        $datos1['tipo']     = "INS"; //Inserta
        $datos1['registro'] = "Id: ".$idcargo->id_cargo." |*| Descripción: $descripcion |*| Id área: $area";
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////

        $Redireccion = "/panel/parametrizacion/cargos";
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function CargosModificar($id)
   {
    if(Session::has('user'))
     {
      $idCargo      = $id;
      $DatosCargo   = PanelCargos::getCargo($idCargo);
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "parametrizacion/cargos";
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

      if($DatosCargo == true)
       {
        return view('parametrizacion.panel-cargosModificar')->with('DatosUsuario',$DatosUsuario)->with('DatosCargo',$DatosCargo);
       }
      else
       {
        $Mensaje     = "";
        $Redireccion = "/panel/parametrizacion/cargos";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function CargosModificarDB()
   {
    if(Session::has('user'))
     {
      $formData     = Request::all();
      $id_cargo     = $formData['id_cargo'];
      $descripcion  = trim($formData['descripcion']);
      $area         = trim($formData['area']);
      $estado       = trim($formData['estado']);

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $CargoDuplicado = PanelCargos::getCargoUnicoModificar($descripcion, $area, $id_cargo);

      if($CargoDuplicado != 0)
        $Mensaje = "Ya se encuentra un cargo creado con esa descripción, en el área seleccionada.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar el nombre del cargo.";
      else if($area == "")
        $Mensaje = "Debe seleccionar el área.";
      else if($estado == "")
        $Mensaje = "Debe seleccionar el estado.";

      if($Mensaje == "")
       {
        $datos['descripcion'] = $descripcion;
        $datos['area']        = $area;
        $datos['estado']      = $estado;

        PanelCargos::actualizarCargo($id_cargo, $datos);
        $Mensaje = "Cargo editado.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $datos1             = array();
        $datos1['modulo']   = 9;     //Cargos
        $datos1['tipo']     = "UPD"; //Actualiza
        $datos1['registro'] = "Id: ".$id_cargo." |*| Descripción: $descripcion |*| Id área: $area |*| Estado: $estado";
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////
       }

      $Redireccion = "/panel/parametrizacion/cargos/modificar/".$id_cargo;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }

   public function CargosCreate()
    {

        $siesaCargos = PanelCargos::getCargoNombreSiesa();
        $CargosActualesC = PanelCargos::getCargos();

        // Obtén las identificaciones de las dos colecciones
        $CargosSiesa = $siesaCargos->pluck('Cargo')->toArray();
        $CargosActuales = $CargosActualesC->pluck('descripcion')->toArray();

        // Encuentra las identificaciones que están en $DatosConsultaSiesa pero no en $EmpleadosActuales
        $result = array_diff($CargosSiesa, $CargosActuales);

        PanelCargos::quitarTildes();
        // Obtener la información de Siesa
        foreach ($result as $cargo) {

            $infoAdicional = $siesaCargos->Where('Cargo', $cargo);
            //dd($infoAdicional);
            // Si el cargo no existe, crearlo en param_cargos
            if ($infoAdicional->isNotEmpty()) {

                foreach ($infoAdicional as $info) {

                    $areaId = PanelAreas::getAreasNombre($info->Area);


               $cargoExistente = DB::table('param_cargos')
                ->where('descripcion', $info->Cargo)
                ->where('area', $areaId)
                ->exists();

            if (!$cargoExistente) {
                    // Si se encuentra el área, insertar el nuevo cargo en param_cargos
                    DB::table('param_cargos')->insert([
                        'descripcion' => $info->Cargo,
                        'area' => $areaId,
                        'estado' => 1, // Puedes ajustar el estado según tus necesidades
                    ]);
                } else {
                    // Manejar el caso en el que el área no existe en param_areas
                    // Puedes lanzar una excepción, registrar un log, o manejarlo de acuerdo a tus necesidades.
                    // En este ejemplo, simplemente se imprimirá un mensaje.
                    return redirect()->route('show.empleados');

                }
            }
            }
        }
        return redirect()->route('show.empleados');
        //dd($info->Cargo);
    }
 }
