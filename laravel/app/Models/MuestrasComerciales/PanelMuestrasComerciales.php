<?php

namespace App\Models\MuestrasComerciales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PanelMuestrasComerciales extends Model
{

    public static function getMuestrasComerciales()
    {
        $sql = DB::table('muestras_comerciales')->get();
        return $sql;
    }

    public static function getUltimoMuestrasComerciales()
    {
        $sql = DB::table('muestras_comerciales')->orderby('id', 'DESC')->take(1)->get();
        return $sql;
    }

    public static function getCantMuestrasComerciales()
    {
        $sql = DB::table('muestras_comerciales')->count();
        return $sql;
    }

    public static function insertMuestraComercial($datos)
    {
        $sql = DB::table('muestras_comerciales')->insert($datos);
        return $sql;
    }

    public static function insertItemsMuestraComercial($datos)
    {
        $sql = DB::table('muestras_comerciales_items')->insert($datos);
        return $sql;
    }

    public static function getMuestraComercial($id)
    {
        $sql = DB::table('muestras_comerciales')->where('id', $id)->get();
        return $sql;
    }

    public static function getItemsMuestrasComerciales($id)
    {
        $sql = DB::table('muestras_comerciales_items')->where('id_muestra_comercial', $id)->get();
        return $sql;
    }

    public static function updateMuestraComercial($id, $datos)
    {
        $sql = DB::table('muestras_comerciales')->where('id', $id)->update($datos);
        return $sql;
    }

    public static function deleteItemMuestraComercial($id)
    {
        $sql = DB::table('muestras_comerciales_items')->where('id', $id)->delete();
        return $sql;
    }

    public static function getItemMuestraComercial($id)
    {
        $sql = DB::table('muestras_comerciales_items')->where('id', $id)->get();
        return $sql;
    }

    public static function updateItemMuestraComercial($id, $datos)
    {
        $sql = DB::table('muestras_comerciales_items')->where('id', $id)->update($datos);
        return $sql;
    }

    /* LOGS */
    public static function insertLogsMuestraComercial($datos)
    {
        $sql = DB::table('muestras_comerciales_logs')->insert($datos);
        return $sql;
    }

    public static function getUltimoLogMuestraComercial($idmc)
    {
        $sql = DB::table('muestras_comerciales_logs')->where('idmc', $idmc)->orderby('id', 'DESC')->take(1)->get();
        return $sql;
    }

    /* LOGS */
}
