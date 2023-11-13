<?php
    //ahora voy a hacerlo con los ficheros
    if (!$hoja7 = fopen('hoja7.php', 'r')){
        die("FATAL ERROR en la hoja");
    }  
    if (!$texto = fopen('texto.txt', 'a+')){
        die("FATAL ERROR en el texto");
    }  
    while(!feof($hoja7)){
        fwrite($texto, fgets($hoja7));
    }

    fclose($hoja7);
    fclose($texto);
?>