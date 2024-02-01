<?php
session_start();
include("estilos.php");
include("comprobar_user.php");
if(isset($_SESSION['nombre_usuario'])) {
    $es_user = $_SESSION['nombre_usuario'];
}
if (isset($_SESSION['admin'])) {
}else{
    header('Location: cursosabi.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
</head>
<body>
    <br>
    <br>
    <br>
    
    <button><a href="añadirproductos.php">añadir / borrar productos</a></button>
    <button><a href="listadocursostodos.php">ver todos los pedidos</a></button>
</body>
</html>