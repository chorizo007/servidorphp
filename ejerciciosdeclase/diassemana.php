<?php

    $fecha = "01/09/2004";
    $mysql = paramysql($fecha);
    function paramysql($fecha){
        $fechaphp = new DateTime("$fecha");
        $res = $fechaphp -> format("Y-m-d");
        return $res;
    }
    echo $mysql;
?> 