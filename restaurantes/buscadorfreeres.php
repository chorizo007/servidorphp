<?php
/*
CREATE USER 'mimesa'@'%' IDENTIFIED BY 'mimesa';
GRANT ALL PRIVILEGES ON mimesa.* TO 'mimesa'@'%';

-- Actualizar privilegios
FLUSH PRIVILEGES;
*/
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php
session_start();
if (isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

require('funciones.php');

//admin
if (!isset($_SESSION['email'])) {
    $titulo = "<h1>Administrar un restaurante</h1>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //validar campos 
    if (!isset($_POST['restaurante']) && !isset($_POST['capacidad']) && !isset($_POST['fechareserva']) && !isset($_POST['horas'])) {
        $restaurante = $_POST['restaurante'];
        $capacidad = $_POST['capacidad'];
        $fechareserva = $_POST['fechareserva'];
        $hora = $_POST['horas'];
    } else {
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
    <?php echo $titulo ?>

    <h2>busqueda</h2>

    <form action="formres.php" method="post">

        <?php
        $array_num = generarmesas($conn, $restaurante, $fechareserva, $hora, 'generar');
        if (count($array_num) == 0) {
            echo 'no tenemos ningun restaurante en de esta franquicia que este libre en estas horas que pediste';
        } else {
            $where = "where restaurante in (" . implode(",", $array) . ")";
            echo $where;
            crearselect($conn, 'restaurante', $where);
        }
        ?>



        <input type="submit" value="buscar">
        <input type="reset" name="borrar" value="Limpiar datos">
    </form>


</body>

</html>