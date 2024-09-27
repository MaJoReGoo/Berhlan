<!doctype html>

<html lang="en">

<head>

<body class="bg-theme bg-theme3">
    <?php
    //Mensajes de error al almacenar
    if ($ErrorValidacion != '') {
        echo '<script>';
        echo "alert('$ErrorValidacion');";
        echo '</script>';
    }
    ?>
</body>
<script language="javascript" type="text/javascript">
    setTimeout("document.location.href='/Berhlan/public'", 0);
</script>

</html>
