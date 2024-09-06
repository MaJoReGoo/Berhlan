<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Parametrizacion;

use Illuminate\Database\Eloquent\Model;

class PanelEmpleados extends Model
 {
  //Listado de empleados paginado
  public static function getEmpleados()
   {
    $sql = \DB::table('param_empleados')->orderby('estado','DESC')->orderby('primer_nombre','ASC')->orderby('ot_nombre','ASC')->orderby('primer_apellido','ASC')->orderby('ot_apellido','ASC')->paginate(8);
    return $sql;
   }

  //Listado de empleados
  public static function EmpleadosT()
   {
    $sql = \DB::table('param_empleados')->orderby('estado','DESC')->orderby('primer_nombre','ASC')->orderby('ot_nombre','ASC')->orderby('primer_apellido','ASC')->orderby('ot_apellido','ASC')->get();
    return $sql;
   }

  //Listado de empleados activos
  public static function EmpleadosActivos()
   {
    $sql = \DB::table('param_empleados')->where('estado', '1')->orderby('primer_nombre','ASC')->orderby('ot_nombre','ASC')->orderby('primer_apellido','ASC')->orderby('ot_apellido','ASC')->get();
    return $sql;
   }

  //Listado de empleados inactivos
  public static function EmpleadosInactivos()
   {
    $sql = \DB::table('param_empleados')->where('estado', '0')->orderby('primer_nombre','ASC')->orderby('ot_nombre','ASC')->orderby('primer_apellido','ASC')->orderby('ot_apellido','ASC')->get();
    return $sql;
   }

  //Listado de empleados
  public static function EmpleadosBusqueda($busqueda)
   {
    $sql = \DB::table('param_empleados')->where('identificacion', 'like', $busqueda)->orWhere('primer_nombre', 'like', $busqueda)->orWhere('ot_nombre', 'like', $busqueda)->orWhere('primer_apellido', 'like', $busqueda);
    $sql = $sql->orWhere('ot_apellido', 'like', $busqueda)->orderby('estado','DESC')->orderby('primer_nombre','ASC')->orderby('ot_nombre','ASC')->orderby('primer_apellido','ASC')->orderby('ot_apellido','ASC')->get();
    return $sql;
   }

  //Búsqueda de empleados activos
  public static function EmpleadosBusquedaActivos($busqueda)
   {
    $sql = \DB::table('param_empleados')->where('estado', '1')->where(function($q) use ($busqueda)
                                                                      {
                                                                       $q->where('identificacion', 'like', $busqueda)
                                                                       ->orWhere('primer_nombre', 'like', $busqueda)
                                                                       ->orWhere('ot_nombre', 'like', $busqueda)
                                                                       ->orWhere('primer_apellido', 'like', $busqueda)
                                                                       ->orWhere('ot_apellido', 'like', $busqueda);
                                                                      })->orderby('primer_nombre','ASC')->orderby('ot_nombre','ASC')->orderby('primer_apellido','ASC')->orderby('ot_apellido','ASC')->get();
    return $sql;
   }

  //Listado de empleados activos que no se encuentren en la tabla usuarios
  public static function getEmpleadosActivosUsuarios()
   {
    $sqla = \DB::table('param_usuarios')->select('empleado');
    $sql  = \DB::table('param_empleados')->where('param_empleados.estado','1')->wherenotin('id_empleado',$sqla)->orderby('param_empleados.primer_nombre','ASC')->orderby('param_empleados.ot_nombre','ASC')->orderby('param_empleados.primer_apellido','ASC')->orderby('param_empleados.ot_apellido','ASC')->get();
    return $sql;
   }

  //Cantidad de empleados activos
  public static function getCantidadEmpleadosActivos()
   {
    $sql = \DB::table('param_empleados')->where('estado','1')->count();
    return $sql;
   }

  public static function getCantidadEmpleadosActivosBusqueda($busqueda)
   {
    $sql = \DB::table('param_empleados')->where('estado','1')->where(function($q) use ($busqueda)
                                                                      {
                                                                       $q->where('identificacion', 'like', $busqueda)
                                                                       ->orWhere('primer_nombre', 'like', $busqueda)
                                                                       ->orWhere('ot_nombre', 'like', $busqueda)
                                                                       ->orWhere('primer_apellido', 'like', $busqueda)
                                                                       ->orWhere('ot_apellido', 'like', $busqueda);
                                                                      });
    $sql = $sql->orderby('estado','DESC')->orderby('primer_nombre','ASC')->orderby('ot_nombre','ASC')->orderby('primer_apellido','ASC')->orderby('ot_apellido','ASC')->count();
    return $sql;
   }

  //Cantidad de centros inactivos
  public static function getCantidadEmpleadosInactivos()
   {
    $sql = \DB::table('param_empleados')->where('estado','0')->count();
    return $sql;
   }

  public static function getCantidadEmpleadosInactivosBusqueda($busqueda)
   {
    $sql = \DB::table('param_empleados')->where('estado','0')->where(function($q) use ($busqueda)
                                                                      {
                                                                       $q->where('identificacion', 'like', $busqueda)
                                                                       ->orWhere('primer_nombre', 'like', $busqueda)
                                                                       ->orWhere('ot_nombre', 'like', $busqueda)
                                                                       ->orWhere('primer_apellido', 'like', $busqueda)
                                                                       ->orWhere('ot_apellido', 'like', $busqueda);
                                                                      });
    $sql = $sql->orderby('estado','DESC')->orderby('primer_nombre','ASC')->orderby('ot_nombre','ASC')->orderby('primer_apellido','ASC')->orderby('ot_apellido','ASC')->count();
    return $sql;
   }

  //Cuenta los empleados con el fin de validar si existe, teniendo en cuenta la identificación
  public static function getEmpleadoUnico($id)
   {
    $sql = \DB::table('param_empleados')->where('identificacion',$id)->count();
    return $sql;
   }

  //Retorna la información del empleado buscado
  public static function getEmpleado($id)
   {
    $sql = \DB::table('param_empleados')->where('id_empleado',$id)->get();
    return $sql;
   }

  //Retorna la información del empleado buscado solo activos
  public static function getEmpleadoActivo($id)
   {
    $sql = \DB::table('param_empleados')->where('id_empleado',$id)->where('estado',1)->get();
    return $sql;
   }

  //Retorna la información del empleado buscado por identificación
  public static function getEmpleadoIdent($id)
   {
    $sql = \DB::table('param_empleados')->where('identificacion',$id)->get();
    return $sql;
   }

  //Cuenta los empleados con el fin de validar si existe, teniendo en cuenta la identificación y un empleado diferente al que se esta modificando
  public static function getEmpleadoUnicoModificar($id, $id1)
   {
    $sql = \DB::table('param_empleados')->where('identificacion',$id)->where('id_empleado','!=',$id1)->count();
    return $sql;
   }

  //Ingresa un nuevo empleado
  public static function insertarEmpleado($datos)
   {
    $sql = \DB::table('param_empleados')->insert($datos);
    return $sql;
   }
//Ingresa un nuevo empleado
  public static function insertarEmpleadoGetId($datos)
  {
   $sql = \DB::table('param_empleados')->insertGetId($datos);
   return $sql;
  }

  public static function actualizarEmpleado($id,$datos)
   {
    $sql = \DB::table('param_empleados')->where('id_empleado', $id)->update($datos);
    return $sql;
   }

  //Realiza la búsqueda de los empleados que cumplen años
  public static function getEmpleadosCumple($mes)
   {
    $sql = \DB::table('param_empleados')->whereMonth('fecha_nacimiento',$mes)->where('estado',1)->orderby('primer_nombre','ASC')->orderby('ot_nombre','ASC')->orderby('primer_apellido','ASC')->orderby('ot_apellido','ASC')->get();
    return $sql;
   }

  //Consulta el ultimo registro insertado
  public static function UltimoEmpleado()
   {
    $sql = \DB::table('param_empleados')->select("id_empleado")->orderby('id_empleado', 'DESC')->first();
    return $sql;
   }

   public static function EmpleadoArea($empleado){
    $sql = \DB::table('param_empleados AS pe')
    ->select('pa.descripcion')
    ->join('param_cargos AS pc','pe.cargo','=','pc.id_cargo')
    ->join('param_areas AS pa', 'pc.area','=','pa.id_area')
    ->where('pe.id_empleado',$empleado)->get();

    return $sql;
   }
   public static function getEmpleadoInfo($empleado)
   {
       /* SELECT CONCAT(pe.primer_nombre,' ',pe.ot_nombre,' ',pe.primer_apellido,' ',pe.ot_apellido) AS 'nombre'
       , pca.descripcion, pa.descripcion, pc.descripcion  */
       $sql = \DB::table('param_empleados AS pe')

           ->select(\DB::raw("CONCAT(pe.primer_nombre,' ',pe.ot_nombre,' ',pe.primer_apellido,' ',pe.ot_apellido) AS nombre"), 'pca.descripcion as cargo', 'pa.descripcion as area', 'pc.descripcion as centro', 'pe.identificacion as identificacion')
           ->join('param_centros as pc', 'pe.centro_op', '=', 'pc.id_centro')
           ->join('param_cargos AS pca', 'pe.cargo', '=', 'pca.id_cargo')
           ->join('param_areas AS pa', 'pca.area', '=', 'pa.id_area')
           ->where('pe.id_empleado', $empleado)->get();
       return $sql;

   }

   public static function EmpleadoIdArea($empleado)
    {
        $sql = \DB::table('param_empleados AS pe')
            ->select('pa.*')
            ->join('param_cargos AS pc', 'pe.cargo', '=', 'pc.id_cargo')
            ->join('param_areas AS pa', 'pc.area', '=', 'pa.id_area')
            ->where('pe.id_empleado', $empleado)->get();

        return $sql;
    }

   public static function getJefeCalidadPorCentro($lugar) {
    $sql = \DB::table('param_empleados AS pe')
->join('param_cargos as car', 'pe.cargo', '=', 'car.id_cargo')
->join('param_centros as pc', 'pc.id_centro', '=', 'pe.centro_op')
->where('car.descripcion', 'LIKE', '%JEFE CONTROL DE CALIDAD%')
->where('pc.descripcion', 'LIKE', '%' . $lugar . '%')
->get();
return $sql;
}

public static function EmpleadosWithCargoActivos()
{
    $sql = \DB::table('param_empleados')->join('param_cargos', 'param_empleados.cargo', '=', 'param_cargos.id_cargo')->select('param_empleados.*', 'param_cargos.descripcion')->where('param_empleados.estado', '1')->orderby('primer_nombre', 'ASC')->orderby('ot_nombre', 'ASC')->orderby('primer_apellido', 'ASC')->orderby('ot_apellido', 'ASC')->get();
    return $sql;
}
 }
