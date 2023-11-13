<?php
        if (!$archivoescribir = fopen('pablo.txt', 'a')) {
            die("FATAL ERROR 7");
        }
        echo fputs($archivoescribir,"hola1");
        echo "escrito";

        fclose($archivoescribir);
    
?>