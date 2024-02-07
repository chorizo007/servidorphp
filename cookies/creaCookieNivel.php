<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$nombre = $_POST['nombre'];
$contenido = $_POST['contenido'];
$tipo = $_POST['nivel'];
$rutaCookie = "/cookies/";
if ($nombre && $contenido) {
    if($tipo == 'Nivel0'){
        setcookie($nombre, $contenido, 0, '/cookies/');
        echo "Cookie creada con éxito. 0 ";
    }
    if($tipo == 'Nivel1'){
        setcookie($nombre, $contenido, 0,"/cookies/Nivel0/Nivel1/");
        echo "Cookie creada con éxito. 1";
    }
    if($tipo == 'Nivel2'){
        setcookie($nombre, $contenido, 0,"/cookies/Nivel0/Nivel1/Nivel2");
        echo "Cookie creada con éxito. 2";
    }
} else {
    echo "Todos los campos son obligatorios.";
}
echo "<br><a href='index.html'>Volver al formulario</a>";
?>
