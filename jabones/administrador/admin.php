<?php
session_start();
require('cabecera.php');

if(isset($_SESSION['email'])) {
    $es_user = $_SESSION['email'];
}
if (isset($_SESSION['admin'])) {
}else{
    header("Location: ../jabonescarlatty.php");
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
    <button><a href="pedidos.php">ver todos los pedidos</a></button>
</body>
</html>