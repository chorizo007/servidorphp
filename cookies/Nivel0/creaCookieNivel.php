<?php
$nombre = 'miCookie0'; // Cambiado el nombre de la cookie
$contenido = 'por defecto 0';

setcookie($nombre, $contenido, 0);
echo "Cookie creada con éxito.";

echo "<br><a href='../index.html'>Volver al formulario</a>";
?>
