<?php

class Util
{
  private $url;
  private $fecha;
  private $fechaH;

  /* Funcion Para Redireccionamiento */
  function redirect($direccion, $message = "", $delay = 0)
  {
    $this->url = $direccion;
    echo "<meta http-equiv='Refresh' content='$delay; url=" . $this->url . "'>";
    if (!empty($message)) echo "<div style='font-family: Arial, Sans-serif; font-size: 12pt;' align=center>$message</div>";
    die;
  }
  /* Funcion Para Redireccionamiento */


  /* Funciones Para el Manejo de Fechas */
  function mes_texto($mes)
  {
    switch ($mes) {
      case 1:
        $cad = "Enero";
        break;

      case 2:
        $cad = "Febrero";
        break;

      case 3:
        $cad = "Marzo";
        break;

      case 4:
        $cad = "Abril";
        break;

      case 5:
        $cad = "Mayo";
        break;

      case 6:
        $cad = "Junio";
        break;

      case 7:
        $cad = "Julio";
        break;

      case 8:
        $cad = "Agosto";
        break;

      case 9:
        $cad = "Septiembre";
        break;

      case 10:
        $cad = "Octubre";
        break;

      case 11:
        $cad = "Noviembre";
        break;

      case 12:
        $cad = "Diciembre";
        break;
      default:
        exit();
    }
    return $cad;
  }

  function mes_numero($mescad)
  {
    switch ($mescad) {
      case "Enero":
        $num = 1;
        break;

      case "Febrero":
        $num = 2;
        break;

      case "Marzo":
        $num = 3;
        break;

      case "Abril":
        $num = 4;
        break;

      case "Mayo":
        $num = 5;
        break;

      case "Junio":
        $num = 6;
        break;

      case "Julio":
        $num = 7;
        break;

      case "Agosto":
        $num = 8;
        break;

      case "Septiembre":
        $num = 9;
        break;

      case "Octubre":
        $num = 10;
        break;

      case "Noviembre":
        $num = 11;
        break;

      case "Diciembre":
        $num = 12;
        break;

      default:
        exit();
    }
    return $num;
  }

  function mes_numero_eng($mescad)
  {
    switch ($mescad) {
      case "Jan":
        $num = '01';
        break;

      case "Feb":
        $num = '02';
        break;

      case "Mar":
        $num = '03';
        break;

      case "Apr":
        $num = '04';
        break;

      case "May":
        $num = '05';
        break;

      case "Jun":
        $num = '06';
        break;

      case "Jul":
        $num = '07';
        break;

      case "Aug":
        $num = '08';
        break;

      case "Sep":
        $num = '09';
        break;

      case "Oct":
        $num = '10';
        break;

      case "Nov":
        $num = '11';
        break;

      case "Dec":
        $num = '12';
        break;

      default:
        exit();
    }

    return $num;
  }

  function fecha_texto($fecr)
  {
    $this->fecha = explode("-", $fecr);
    $mes  = (int)$this->fecha[1];
    $dia  = $this->fecha[2];
    $anio = $this->fecha[0];

    if ($dia == "01" || $dia == "02" || $dia == "03" || $dia == "04" || $dia == "05" || $dia == "06" || $dia == "07" || $dia == "08" || $dia == "09") {
      $dia = substr($dia, 1, 1);
    } else {
      $dia = $dia;
    }

    return $dia . " de " . $this->mes_texto($mes) . " de " . $anio;
  }

  function menu_anio($anioini, $aniofin)
  {
    for ($i = $anioini; $i <= $aniofin; $i++)
      echo "<option value='$i'>$i</option>";
  }

  function fecha_texto_hora($fecr)
  {
    $this->fechaH = explode(" ", $fecr);
    $this->fecha = explode("-", $this->fechaH[0]);
    $mes  = (int)$this->fecha[1];
    $dia  = $this->fecha[2];
    $anio = $this->fecha[0];

    if ($dia == "01" || $dia == "02" || $dia == "03" || $dia == "04" || $dia == "05" || $dia == "06" || $dia == "07" || $dia == "08" || $dia == "09") {
      $dia = substr($dia, 1, 1);
    } else {
      $dia = $dia;
    }

    return $dia . " de " . $this->mes_texto($mes) . " de " . $anio . " <br/> Hora: " . $this->fechaH[1] . "  ";
  }

  function acortarurl($url)
  {
    $longitud = strlen($url);
    if ($longitud > 45) {
      $longitud = $longitud - 30;
      $parte_inicial = substr($url, 0, -$longitud);
      $parte_final = substr($url, -15);
      $nueva_url = $parte_inicial . "[ ... ]" . $parte_final;
      return $nueva_url;
    } else {
      return $url;
    }
  }

  /* Funciones Para el Manejo de Fechas */
}
