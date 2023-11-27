<?php
session_start();

// Destruir la sesión actual
session_destroy();

echo "Sesión cerrada correctamente. <br>";

setcookie('usuario', '', time() - 3600);

// Mensaje indicando que la cookie ha sido eliminada
echo "Cookie eliminada correctamente. <br>";

echo '<a href="info.php">Volver al inicio</a>';
?>
