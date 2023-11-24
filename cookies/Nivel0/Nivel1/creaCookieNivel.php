<?php
$nombre = 'miCookie1'; // Cambiado el nombre de la cookie
$contenido = 'por defecto 1';

setcookie($nombre, $contenido, 0);
echo "Cookie creada con éxito.";


echo "<br><a href='../../index.html'>Volver al formulario</a>";
?>
