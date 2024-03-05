<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: inicio.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreres = $_POST['nombreres'];
    $_SESSION['restaurante'] = $nombreres; 
    header("Location: buscarresta.php");
    exit();
}

require('funciones.php');

$restaurante = $_SESSION['restaurante'];
$capacidad = $_SESSION['capacidad'];
$fechareserva = $_SESSION['fechareserva'];
$hora = $_SESSION['hora'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $restaurante = $_POST['restaurante'];
    $_SESSION['restaurante'] = $restaurante;
    header("Location: buscarresta.php");
    exit();
}



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>restaurante</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h2 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            margin-top: 10px;
            color: #3498db;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <h2>busqueda de un restaurante libre</h2>

    <form action="buscadorfreeres.php" method="post">

        <?php
        selectrestaurantes($conn , $fechareserva , $hora);
        ?>

        <input type="submit" value="buscar">
        <input type="reset" name="borrar" value="Limpiar datos">
    </form>
    <a href="logout.php">logout</a>


</body>

</html>