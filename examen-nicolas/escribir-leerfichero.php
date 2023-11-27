<?php
    if ($fichero = fopen("datos.txt", 'w+')){
        fwrite($fichero,"cadena");
        while(!feof($fichero)){
            echo fgets($fichero) . '<br>';
        }
    }else{
        die("ERROR: no se ha podido abrir el fichero de datos");
    }
    fclose($fichero);
?>