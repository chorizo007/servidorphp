<?php
    $nombre = $_POST['nombre'];
    $comentario = $_POST['comentario'];
    if (!$archivodatos = fopen('datos.txt', 'a+')) {
        die("FATAL ERROR");
    }
    fwrite($archivodatos,"--------------------------------\r\n");
    fwrite($archivodatos,"$nombre\r\n");
    fwrite($archivodatos,"$comentario\r\n");
    fclose($archivodatos);
?>