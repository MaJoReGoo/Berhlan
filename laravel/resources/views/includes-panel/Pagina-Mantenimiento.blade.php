<?php
$server = '/Berhlan/public';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foto de Fondo</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url(<?= $server ?>/images/pagina_mant.jpeg) no-repeat center center fixed;
            background-size: cover;
        }
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <button class="back-button" onclick="window.history.back()">Regresar</button>
</body>
</html>
