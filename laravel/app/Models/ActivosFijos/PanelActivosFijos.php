<?php

namespace App\Models\ActivosFijos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelActivosFijos extends Model
{
    public static function InsertActivosFijos($datos)
    {
        $sql = \DB::table('acti2_activo')->insert($datos);
        return $sql;
    }
    public static function getUltimoActivo()
    {
        $sql = \DB::table('acti2_activo')->latest("id_activo")->first();
        return $sql;
    }
    public static function updateActivosFijos($id,$datos)
    {
        $sql = \DB::table('acti2_activo')->where('id_activo', $id)->update($datos);
        return $sql;
    }

    public static function getActivo($id)
    {
        $sql = \DB::table('acti2_activo')->where('id_activo', $id)->get();
        return $sql;
    }

    public static function insertarCambio($datos)
    {
        $sql = \DB::table('acti2_cambios')->insert($datos);
        return $sql;
    }

    public static function Cambios($id)
    {
        $sql = \DB::table('acti2_cambios')->where('activo', $id)->orderby('fecha', 'DESC')->get();
        return $sql;
    }
    public static function insertarActividad($datos)
    {
        $sql = \DB::table('acti2_actividades')->insert($datos);
        return $sql;
    }
    public static function Actividades($id)
    {
        $sql = \DB::table('acti2_actividades')->where('activo', $id)->orderby('fecha', 'DESC')->get();
        return $sql;
    }

}
