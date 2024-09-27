<?php

?>

<!doctype html>

<html lang="en">

<head>
    <!-- Sweetalert -->
    <!-- -------------- Fonts -------------- -->
    <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet'
        type='text/css'>

    <script src="https://{{ asset('/panelfiles/sweetalert/dist/sweetalert.min.js') }}"></script>
    <link rel="stylesheet" href="https://{{ asset('/panelfiles/sweetalert/dist/sweetalert.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script language="JavaScript">
        //<!--
        function infoSolicitud(texto) {
            Swal.fire({
                icon: 'info',
                title: "<i>Información Importante</i>",
                html: texto,
                confirmButtonText: "Cerrar!",
            });
        }
        //-->
    </script>
</head>

<body class="bg-theme bg-theme3" onload="infoSolicitud('<?= $Mensaje ?>')">
    <!-- php
  if ($Mensaje != "") {
    echo "<script>
        ";
        echo "alert('$Mensaje');";
        echo "
    </script>";
  }
  ?
  <script>
      Swal.fire({
          icon: 'info',
          title: "<i>Información Importante</i>",
          html: $Mensaje,
          confirmButtonText: "Cerrar!",
      }); <
      /script --> <
      /body> <
      script language = "javascript"
      type = "text/javascript" >
          setTimeout("document.location.href='<?= $server . $Redireccion ?>'", 4000);
  </script>

</html>
