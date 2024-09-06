<?php

namespace App\Models\ArchivoDigital;

use Illuminate\Database\Eloquent\Model;

class PanelHistorias extends Model
{

    public static function getHistoriasEmpleado($empleado)
    {
        $sql = \DB::table('arch_historiaslabor')->where('empleado', $empleado)->get();
        return $sql;
    }

    public static function getCountHistoriasEmpleado($empleado)
    {
        $sql = \DB::table('arch_historiaslabor')->where('empleado', $empleado)->count();
        return $sql;
    }

    public static function getHistoriasDocEmpleado($empleado)
    {
        $sql = \DB::table('arch_historiaslabor AS ah')
            ->select('ah.modulo', 'ah.estrepano', 'ah.ncaja', 'ah.id_historia as id', 'ati.descripcion AS tipodoc', 'ah.archivo AS documento', \DB::raw("COALESCE(ah.fecha_creacion,'') as fechacrea"),
                \DB::raw("COALESCE(ah.fecha_actualizacion,'') as fechactu"), 'ah.usuario_update as usuarioup', 'ah.usuario_crear as usuarioc'
                , \DB::raw("COALESCE(CONCAT(pe.primer_nombre,' ',pe.ot_nombre,' ',pe.primer_apellido,' ',pe.ot_apellido),'') AS nombre")
                , \DB::raw("COALESCE(CONCAT(pe2.primer_nombre,' ',pe2.ot_nombre,' ',pe2.primer_apellido,' ',pe2.ot_apellido),'') AS nombre2"))
            ->join('arch_tipodocument AS ati', 'ah.tipo_documento', '=', 'ati.id_tipodocumento')
            ->leftjoin('param_usuarios AS pu', 'ah.usuario_crear', '=', 'pu.id_usuario')
            ->leftjoin('param_usuarios AS pu2', 'ah.usuario_update', '=', 'pu2.id_usuario')
            ->leftjoin('param_empleados AS pe', 'pu.empleado', '=', 'pe.id_empleado')
            ->leftjoin('param_empleados AS pe2', 'pu2.empleado', '=', 'pe2.id_empleado')
            ->where('ah.empleado', $empleado)->get();
        return $sql;
    }

    public static function InserttHistoriasEmpleado($datos)
    {
        $sql = \DB::table('arch_historiaslabor')->insert($datos);
        return $sql;
    }

    public static function actualizarDocumentoHistoria($id, $datos)
    {
        $sql = \DB::table('arch_historiaslabor')->where('id_historia', $id)->update($datos);
        return $sql;
    }

    public static function getDocumentosEmpleado($id)
    {
        //SELECT archivo FROM arch_historiaslabor WHERE empleado = 1991;
        $sql = \DB::table('arch_historiaslabor')
            ->select('archivo')
            ->where('empleado', $id)->get();
        return $sql;
    }

    public static function getDocumentoshistoria($id)
    {
        $sql = \DB::table('arch_historiaslabor')->where('id_historia', $id)->get();
        return $sql;
    }

    public static function getTipoDocumentoshistoriaPendiente($empleado)
    {

        /* $id = "SELECT id_tipodocumento AS ID,descripcion AS D FROM arch_tipodocument WHERE estado = 1
        EXCEPT
        SELECT ati.id_tipodocumento AS ID,ati.descripcion AS D FROM arch_historiaslabor AS ah
        JOIN arch_tipodocument AS ati ON ah.tipo_documento=ati.id_tipodocumento WHERE ah.empleado = '$empleado'"; */
        $id = "SELECT td.id_tipodocumento AS ID, td.descripcion AS D
        FROM arch_tipodocument AS td
        LEFT JOIN arch_historiaslabor AS ah ON td.id_tipodocumento = ah.tipo_documento AND ah.empleado = '$empleado'
        WHERE ah.tipo_documento IS NULL OR ah.empleado IS NULL";
        $sql = \DB::connection('mysql')->select($id);

        return $sql;
    }

}
