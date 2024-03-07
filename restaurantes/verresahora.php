<?php
session_start();
require('funciones.php');
require('cabecera.php');
//admin
if (isset($_SESSION['admin'])) {
    $titulo = "<h1>Administrar un restaurante</h1>";
} else if (isset($_SESSION['email'])) {
} else {
    header("Location: inicio.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $restaurante = $_POST['restaurante'];
    $esperar = $_POST['esperar'];
    $capacidad = 8;
    $fechaactual = new DateTime('now');
    $minutos = 'PT' . $esperar . 'M';
    $fechaactual->add(new DateInterval($minutos));
    $hora = $fechaactual->format('h:i');
    $fechareserva = $fechaactual->format('Y-m-d');

    $_SESSION['restaurante'] = $restaurante;
    $_SESSION['fechareserva'] = $fechareserva;
    $_SESSION['hora'] = $hora;
    $_SESSION['capacidad'] = $capacidad;

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
    <?php echo $titulo ?>

    <h2>busqueda</h2>

    <form action="formres.php" method="post">

        <label for="correo">seleciona el restaurante</label>

        <?php
        crearselect($conn, 'restaurante', '');
        ?>

        <label for="correo">Cuanto tiempo quieres esperar ? </label>

        <select name="esperar">
            <option value="1">1 minuto</option>
            <option value="10">10 minuto</option>
            <option value="60">1 hora</option>
        </select>

        <input type="submit" value="buscar">
        <input type="reset" name="borrar" value="Limpiar datos">
    </form>


    <a href="logout.php">logout</a>


</body>

</html>