<?php
$nombre = $_POST['nombre'] ?? 'por defecto 0';
$contenido = $_POST['contenido'] ?? 'por defecto 0';

if ($nombre && $contenido) {
    setcookie($nombre, $contenido, 0, './');
    echo "Cookie creada con éxito.";
} else {
    echo "Todos los campos son obligatorios.";
}
?>