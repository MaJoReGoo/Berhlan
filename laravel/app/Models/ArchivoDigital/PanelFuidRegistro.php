<?php

namespace App\Models\ArchivoDigital;

use Illuminate\Database\Eloquent\Model;

class PanelFuidRegistro extends Model
{
    public static function InsertFuidRegistro($datos)
    {
        $sql = \DB::table('arch_registros_fuid')->insert($datos);
        return $sql;
    }
    public static function getFuidRegistro($id)
    {
        $sql = \DB::table('arch_registros_fuid as arf')
            ->select('arf.id_registros_fuid','af.id_fuid', \DB::raw("CONCAT(af.entidad_productora, ' | ',af.dependencia_productora) as remitente"),
                'af.entregado_por', 'af.fecha_entrega', 'af.recibido_por', 'af.fecha_recibido',
                'af.estado', 'af.observacion_general', \DB::raw("COUNT(af.id_fuid) as cantidad_archivos"))
            ->join('arch_fuid AS af', 'arf.fuid', '=', 'af.id_fuid')
            ->join('arch_registros AS ar', 'arf.registros', '=', 'ar.id_registro')
            ->where('af.entregado_por', $id)
            ->groupby('af.id_fuid')->get();
        return $sql;
    }

    public static function getFuidRegistros()
    {
        $sql = \DB::table('arch_registros_fuid as arf')
            ->select('arf.id_registros_fuid','af.id_fuid', \DB::raw("CONCAT(af.entidad_productora, ' | ',af.dependencia_productora) as remitente"),
                'af.entregado_por', 'af.fecha_entrega', 'af.recibido_por', 'af.fecha_recibido',
                'af.estado', 'af.observacion_general', \DB::raw("COUNT(af.id_fuid) as cantidad_archivos"))
            ->join('arch_fuid AS af', 'arf.fuid', '=', 'af.id_fuid')
            ->join('arch_registros AS ar', 'arf.registros', '=', 'ar.id_registro')
            ->groupby('af.id_fuid')->get();
        return $sql;
    }

    public static function getFuidRegistroRecibir($id)
    {
        $sql = \DB::table('arch_registros_fuid as arf')
            ->join('arch_fuid AS af', 'arf.fuid', '=', 'af.id_fuid')
            ->join('arch_registros AS ar', 'arf.registros', '=', 'ar.id_registro')
            ->where('af.id_fuid', $id)->get();
        return $sql;
    }
    public static function getRegistrosEscaneoFuid($id)
    {

        $sql = \DB::table('arch_registros_fuid as arf')
            ->select('ar.id_registro','ar.dependencia','ar.codigo_caja','ar.titulo_unidad_documental')
            ->join('arch_fuid AS af', 'arf.fuid', '=', 'af.id_fuid')
            ->join('arch_registros AS ar', 'arf.registros', '=', 'ar.id_registro')
            ->where('af.id_fuid', $id)->get();
        return $sql;
    }
    public static function getRegistrosEscaneoFuidNotNull()
    {

        $sql = \DB::table('arch_registros_fuid as arf')
            ->select('ar.id_registro','ar.dependencia','ar.codigo_caja','ar.titulo_unidad_documental')
            ->join('arch_fuid AS af', 'arf.fuid', '=', 'af.id_fuid')
            ->join('arch_registros AS ar', 'arf.registros', '=', 'ar.id_registro')
            ->whereNotNull('ar.dependencia')
            ->whereNotNull('ar.codigo_caja')->get();
        return $sql;
    }

}
