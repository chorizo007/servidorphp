<?php
$nombre = 'miCookie2';
$contenido = 'por defecto 2';
    setcookie($nombre, $contenido, 0);
    echo "Cookie creada con éxito.";

echo "<br><a href='../../../index.html'>Volver al formulario</a>";
?>