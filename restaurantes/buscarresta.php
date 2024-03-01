<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php
    require('funciones.php');

    $restaurante = $_SESSION['restaurante'];
    $hora = $_SESSION['hora'];
    $capacidad = $_SESSION['capacidad'];
    $restaurante = $_SESSION['restaurante'];


    $servername = "127.0.0.1";
    $username = "mimesa";
    $password = "mimesa";
    $dbname = "MIMESA";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }
</style>
</head>

<body>
    <h1>restaurante <?php echo $restaurante ?></h1>

    <?php
    $mostrar  = generarmesas($conn, $restaurante, $fechareserva , $hora , 'mostrar');
    echo $mostrar;
    ?>
</body>

</html>