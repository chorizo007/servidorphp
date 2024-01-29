<?php

function prueba()
{
    $num_args = func_num_args();
    echo "numero de argumetos :" . $num_args;
    if ($num_args >= 2) {
        echo "el 2º argumento es " . $func_get_arg(1);
    }
    echo "array de todos los argumentos " . print_r($parametros);
}


prueba(1, 2, 3);

?>