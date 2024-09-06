<?php
/*
Controlador de la tabla param_areas
Usa SQl Eloquent del archivo app\Models\Parametrizacion\PanelAreas.php
*/

namespace App\Http\Controllers\Parametrizacion;
use App\Http\Controllers\Controller;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\PanelLogin;
use Illuminate\Support\Facades\Session;
use Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use DB;


class AreasPanelController extends Controller
 {
  public function showAreas()
   {
    if(Session::has('user'))
     {
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "parametrizacion/areas";
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

      $DatosAreas     = PanelAreas::getAreas();
      $AreasActivas   = PanelAreas::getCantidadAreasActivas();
      $AreasInactivas = PanelAreas::getCantidadAreasInactivas();
      return view('parametrizacion.panel-areas')->with('DatosUsuario',$DatosUsuario)->with('DatosAreas',$DatosAreas)->with('AreasActivas',$AreasActivas)->with('AreasInactivas',$AreasInactivas);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function AreasAgregar()
   {
    if(Session::has('user'))
     {
      $ErrorValidacion = "";  //Variable que retorna el error en caso de que no pase la validación
      $user            = Session::get('user');
      $DatosUsuario    = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "parametrizacion/areas";
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

      return view('parametrizacion.panel-areasAgregar')->with('DatosUsuario',$DatosUsuario);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function AreasAgregarDB()
   {
    if(Session::has('user'))
     {
      $formData    = Request::all();
      $descripcion = trim($formData['descripcion']);
      $empresa     = $formData['empresa'];

      $datos = array();

      //Realizo las validaciones
      $Mensaje = "";

      $AreaDuplicada = PanelAreas::getAreaUnica($descripcion, $empresa);

      if($AreaDuplicada != 0)
        $Mensaje = "Ya se encuentra creada un área con esa descripción, en la empresa seleccionada.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar el nombre del área.";
      else if($empresa == "")
        $Mensaje = "Debe seleccionar la empresa.";

      if($Mensaje != "")
       {
        $Redireccion = "/panel/parametrizacion/areas/agregar";
       }
      else
       {
        $datos['descripcion'] = $descripcion;
        $datos['empresa']     = $empresa;
        $datos['estado']      = 1; //Activo
        $datos['id_siesa']    = 0; //Para sincronización con siesa

        PanelAreas::insertarArea($datos);
        $Mensaje = "Área creada.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $idarea             = PanelAreas::UltimaArea();
        $datos1             = array();
        $datos1['modulo']   = 8;     //Áreas
        $datos1['tipo']     = "INS"; //Inserta
        $datos1['registro'] = "Id: ".$idarea->id_area." |*| Descripción: $descripcion |*| Id empresa: $empresa";
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////

        $Redireccion = "/panel/parametrizacion/areas";
       }

      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function AreasModificar($id)
   {
    if(Session::has('user'))
     {
      $idArea       = $id;
      $DatosArea    = PanelAreas::getArea($idArea);
      $user         = Session::get('user');
      $DatosUsuario = PanelLogin::getUsuario($user);

      //Valido que el usuario tenga acceso
      if($DatosUsuario[0]->master == 0)  //Si no es un usuario tipo máster
       {
        $ruta      = "parametrizacion/areas";
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

      if($DatosArea == true)
       {
        return view('parametrizacion.panel-areasModificar')->with('DatosUsuario',$DatosUsuario)->with('DatosArea',$DatosArea);
       }
      else
       {
        $Mensaje     = "";
        $Redireccion = "/panel/parametrizacion/areas";
        return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
       }
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }


  public function AreasModificarDB()
   {
    if(Session::has('user'))
     {
      $formData     = Request::all();
      $id_area      = $formData['id_area'];
      $descripcion  = trim($formData['descripcion']);
      $empresa      = $formData['empresa'];
      $estado       = $formData['estado'];

      $datos    = array();

      //Realizo las validaciones
      $Mensaje = "";

      $AreaDuplicada = PanelAreas::getAreaUnicaModificar($descripcion, $empresa, $id_area);

      if($AreaDuplicada != 0)
        $Mensaje = "Ya se encuentra creada un área con esa descripción, en la empresa seleccionada.";
      else if($descripcion == "")
        $Mensaje = "Debe ingresar el nombre del área.";
      else if($empresa == "")
        $Mensaje = "Debe seleccionar la empresa.";
      else if($estado == "")
        $Mensaje = "Debe seleccionar el estado.";

      if($Mensaje == "")
       {
        $datos['descripcion'] = $descripcion;
        $datos['empresa']     = $empresa;
        $datos['estado']      = $estado;

        PanelAreas::actualizarArea($id_area, $datos);
        $Mensaje = "Área modificada.";

        //Agrego el guardado al log
        $user               = Session::get('user');
        $DatosUsuario       = PanelLogin::getUsuario($user);
        $datos1             = array();
        $datos1['modulo']   = 8;     //Áreas
        $datos1['tipo']     = "UPD"; //Actualiza
        $datos1['registro'] = "Id: ".$id_area." |*| Descripción: $descripcion |*| Id empresa: $empresa |*| Estado: $estado";
        $datos1['usuario']  = $DatosUsuario[0]->empleado;
        $datos1['fecha']    = NOW();
        PanelLogin::insertarLog($datos1);
        ////////////////////////////////
       }

      $Redireccion = "/panel/parametrizacion/areas/modificar/".$id_area;
      return view('panel-mensaje')->with('Mensaje',$Mensaje)->with('Redireccion',$Redireccion);
     }
    else
     {
      $ErrorValidacion = "Error de conexión, intente de nuevo.";
      return view('panel-login')->with('ErrorValidacion',$ErrorValidacion);
     }
   }
   public function AreasCreate()
    {

        $SiesaAreas = PanelAreas::getAreaNombreSiesa();
        $AreasActuales = PanelAreas::getAreas();

        // Obtén las descripciones de las dos colecciones
        $AreasSiesa = $SiesaAreas->pluck('Area')->toArray();
        $AreasActuales = $AreasActuales->pluck('descripcion')->toArray();

        // Encuentra las areas que están en $SiesaAreas pero no en $AreasActuales
        $result = array_diff($AreasSiesa, $AreasActuales);
        PanelAreas::quitarTildes();
        foreach ($result as $area) {

            $infoAdicional = $SiesaAreas->Where('Area', $area);
            // Si el area no existe, crearlo en param_areas
            if ($infoAdicional->isNotEmpty()) {
                // Encuentra las descripciones que están en $DatosConsultaSiesa pero no en $CargosActuales
                foreach ($infoAdicional as $info) {

                    $empresaId = PanelEmpresas::getEmpresasNombre($info->Empresa);

                    $areaExistente = DB::table('param_areas')
                        ->where('descripcion', $info->Area)
                        ->where('empresa', $empresaId)
                        ->exists();

                    if (!$areaExistente) {
                        // Si se encuentra el área, insertar el nuevo cargo en param_cargos
                        DB::table('param_areas')->insert([
                            'descripcion' => $info->Area,
                            'empresa' => $empresaId,
                            'estado' => 1,
                            'id_siesa' => $info->id_siesa,
                        ]);
                    } else {
                        // Manejar el caso en el que el área no existe en param_areas

                        return redirect()->route('show.empleados');
                    }
                }
            }
        }
        return redirect()->route('show.empleados');

    }

 }
