<?php

$fecha_inicio = DateTime::createFromFormat('Y-m-d', trim($array_linea[2]));
$fecha_final = DateTime::createFromFormat('Y-m-d', trim($array_linea[3]));
$fecha_vehiculos = DateTime::createFromFormat('Y-m-d', $fecha);

// Verificar si la fecha está dentro del rango y la matrícula coincide
if ($fecha_vehiculos >= $fecha_inicio && $fecha_vehiculos <= $fecha_final) {
    fclose($file);
    return true;
} else {
    fclose($file);
    return false;
}

?>