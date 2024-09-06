<?php
//SQl Eloquent para conexión con la base de datos

namespace App\Models\Requerimientos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PanelCategorias extends Model
{
  public static function getCategoriasGrupo($grupo)
  {
    $sql = DB::table('requ_categorias')->where('grupo', $grupo)->orderby('estado', 'DESC')->orderby('descripcion', 'ASC')->get();
    return $sql;
  }

  public static function getCategoriaUnica($grupo, $des)
  {
    $sql = DB::table('requ_categorias')->where('grupo', $grupo)->where('descripcion', $des)->count();
    return $sql;
  }

  public static function insertarCategoria($datos)
  {
    $sql = DB::table('requ_categorias')->insert($datos);
    return $sql;
  }

  public static function getCategoria($cta)
  {
    $sql = DB::table('requ_categorias')->where('id_categoria', $cta)->get();
    return $sql;
  }

  public static function getCategoriaUnicaModificar($cta, $grupo, $des)
  {
    $sql = DB::table('requ_categorias')->where('grupo', $grupo)->where('descripcion', $des)->where('id_categoria', '!=', $cta)->count();
    return $sql;
  }

  public static function actualizarCategoria($id, $datos)
  {
    $sql = DB::table('requ_categorias')->where('id_categoria', $id)->update($datos);
    return $sql;
  }

  public static function NombreCategoria($id)
  {
    $sql = DB::table('requ_categorias')->select('descripcion')->where('id_categoria', $id)->get();
    return $sql;
  }

  //Consulta el ultimo registro insertado
  public static function UltimaCategoria()
  {
    $sql = DB::table('requ_categorias')->select("id_categoria")->orderby('id_categoria', 'DESC')->first();
    return $sql;
  }

  public static function getCategorias()
  {
    $sql = DB::table('requ_categorias')->orderby('estado', 'DESC')->orderby('descripcion', 'ASC')->get();
    return $sql;
  }
}
