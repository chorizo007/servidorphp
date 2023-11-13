<?php

/* Realiza una página llamada lectura.php en la que lea el contenido de una de las páginas web hechas
hasta ahora, lo guarde a un fchero local llamado fch_salida.txt y escriba el número total de bytes
escritos.
*/

if (!$archivo = fopen('anival.txt', 'a+')){
    die("FATAL ERROR");
}

$añadir = file_get_contents('hoja12.html');
$añadir = $añadir. file_get_contents('practica6.html');
$añadir = $añadir. file_get_contents('practica7.html');

fclose($archivo);

echo "el tamaño del archivo es :".filesize('anival.txt');
echo "<br>";


/*
2. Realizar un contador de visitas en PHP.
 Crearemos un fchero de tetto “visitas.txt” y escribiremos en él un 0.
 Crearemos un fchero contador.php e implementaremos en él las siguientes instrucciones:
1. Abrir el fchero en modo lectura / escritura.
2. Leer del fchero 8 bytes (ó la cantdad deseada) y guardarlos en una variable que
llamaremos $contador
3. Escribir en pantalla: “Esta es la visita numero: $contador”
4. Incrementar el contador en una unidad
5. Colocar el puntero al principio del fchero
6. Escribir el nuevo valor del contador en el fchero
7. Cerrar el fchero
*/
$archivo_visitas = 'visitas.txt';

if (!$archivovis = fopen($archivo_visitas, 'r+')) {
    die("FATAL ERROR");
}

$contador = (int)fread($archivovis, filesize($archivo_visitas));

echo "Esta es la visita número: $contador";
$contador++;

rewind($archivovis);
fwrite($archivovis, $contador);
fclose($archivovis);


?>