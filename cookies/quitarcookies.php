<?php
foreach ($_COOKIE as $nombre => $valor) {
    // Establecemos la cookie de nuevo con un tiempo de expiración en el pasado (1 hora antes)
    setcookie($nombre, '', time() - 3600);
}

// También podrías limpiar el array $_COOKIE
$_COOKIE = array();

echo "Todas las cookies han sido eliminadas.";

?>