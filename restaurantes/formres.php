<?php
session_start();
require ('funciones.php');

//admin
if (isset($_SESSION['admin'])) {
    $titulo = "<h1>Administrar un restaurante</h1>";
}else if (isset($_SESSION['email'])) {
}else{
    header("Location: inicio.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //validar campos 
    if(isset($_POST['restaurante']) && isset($_POST['capacidad']) && isset($_POST['fechareserva']) && isset($_POST['horas'])){
        $restaurante = $_POST['restaurante'];
        $capacidad = $_POST['capacidad'];
        $fechareserva = $_POST['fechareserva'];
        $hora = $_POST['horas'];
    }else{
        $restaurante = $_POST['restaurante'];
        $capacidad = 8;
        $fechaactual = new DateTime('now');
        $fechareserva = $fechaactual->format('Y-m-d');
        $hora = $fechaactual->format('h:i');
    }
    
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
    <?php echo $titulo?>

    <h2>busqueda</h2>

    <form action="formres.php" method="post">

        <label for="correo">restaurante</label>

        <?php
        crearselect($conn, 'restaurante', '');
        ?>

        

        <?php
        if($titulo==null){
            echo "<label>nuermo de comensales</label>";

            crearselect($conn, 'capacidad', '');

            echo '<label for="correo">fecha de reserva</label>';
            echo '<input name="fechareserva" type="date">';

            selecthoras();
        }
        ?>



        <input type="submit" value="buscar">
        <input type="reset" name="borrar" value="Limpiar datos">
    </form>


    <a href="logout.php">logout</a>


</body>

</html>