<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Bpack;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PanelMuestras extends Model
{
  public static function insertarMuestra($datos)
  {
    $sql = DB::table('bpac_muestras')->insert($datos);
    return $sql;
  }

  public static function UltimaSolicitud()
  {
    $sql = DB::table('bpac_muestras')->select("id_solicitud")->orderby('id_solicitud', 'DESC')->first();
    return $sql;
  }

  public static function actualizarMuestra($id, $datos)
  {
    $sql = DB::table('bpac_muestras')->where('id_solicitud', $id)->update($datos);
    return $sql;
  }

  public static function SolTMuestrasAbiertas()
  {
    $sql = DB::table('bpac_muestras')->where('usr_cierre', '')->where('cancelada', 0)->count();
    return $sql;
  }

  public static function SolMuestrasAbiertas()
  {
    $sql = DB::table('bpac_muestras')->where('usr_cierre', '')->where('cancelada', 0)->get();
    return $sql;
  }

  public static function Muestra($id)
  {
    $sql = DB::table('bpac_muestras')->where('id_solicitud', $id)->get();
    return $sql;
  }

  public static function UsrSolMuestras()
  {
    $sql = DB::table('bpac_muestras')->select('usr_crea');
    $sql = $sql->join('param_empleados', 'usr_crea', '=', 'id_empleado')->groupby('usr_crea')->orderby('primer_nombre', 'ASC')->orderby('ot_nombre', 'ASC');
    $sql = $sql->orderby('primer_apellido', 'ASC')->orderby('ot_apellido', 'ASC')->get();
    return $sql;
  }

  public static function UsrCierraMuestras()
  {
    $sql = DB::table('bpac_muestras')->select('usr_cierre');
    $sql = $sql->join('param_empleados', 'usr_cierre', '=', 'id_empleado')->groupby('usr_cierre')->orderby('primer_nombre', 'ASC')->orderby('ot_nombre', 'ASC');
    $sql = $sql->orderby('primer_apellido', 'ASC')->orderby('ot_apellido', 'ASC')->get();
    return $sql;
  }

  public static function MuestrasSql($id)
  {
    $sql = DB::select($id);
    return $sql;
  }

  // Nuevas Funciones
  public static function SolMuestrasEstadoCant($estado)
  {
    $sql = DB::table('bpac_muestras')->where('cancelada', $estado)->count();
    return $sql;
  }

  public static function SolMuestrasEstado($estado)
  {
    $sql = DB::table('bpac_muestras')->where('cancelada', $estado)->get();
    return $sql;
  }

  public static function SolMuestrasCerradasCant()
  {
    $sql = DB::table('bpac_muestras')->where('usr_cierre', '!=', '')->where('usr_cierre', '!=', 0)->count();
    return $sql;
  }

  public static function SolMuestrasCerradas()
  {
    $sql = DB::table('bpac_muestras')->where('usr_cierre', '!=', '')->where('usr_cierre', '!=', 0)->get();
    return $sql;
  }
}
