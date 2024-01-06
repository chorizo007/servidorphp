<?php
session_start();
include("estilos.php");
include("comprobar_user.php");
if(isset($_SESSION['nombre_usuario'])) {
    $es_user = $_SESSION['nombre_usuario'];
}
if (isset($_SESSION['admin'])) {
    $botonadmin = "<button><a href='admin.php'>ADMINISTRAR</a></button>";
}else{
    header('Location: cursosabi.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <button><a href="abrircuros.php">abrir/cerrar cursos</a></button>
    <button><a href="baremacion.php">asignar vacantes a solicitudes</a></button>
    <button><a href="listadocursostodos.php">listar todos los cursos</a></button>
    <button><a href="resultadobaremacion.php">mostrar el listado de adminitidos</a></button>
    <button><a href="logout.php">baremacion de los cursos</a></button>
</body>
</html>