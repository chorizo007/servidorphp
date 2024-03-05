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
require('funciones.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $restaurante = $_SESSION['restaurante'];
    $fechareserva = $_SESSION['fechareserva'];
    $idmesa = $_SESSION['mesa'];
    $estado = $_POST['estado'];

    $idmesa;

    $servername = "127.0.0.1";
    $username = "mimesa";
    $password = "mimesa";
    $dbname = "MIMESA";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "UPDATE FROM RESERVAS SET ESTADO = :estado where numMesa = :numMesa and restaurante = :restaurantes and fecha = :fechareserva and hora = HOUR(current_date())";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':numMesa', $idmesa, PDO::PARAM_STR);
        $stmt->bindParam(':fechareserva', $fechareserva, PDO::PARAM_STR);
        $stmt->execute();
        
        header("Location: buscarresta.php");
        exit();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}else{
    $idmesa = $_GET['admin'];
    $_SESSION['mesa'] = $idmesa;
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
    <?php
        echo "<h1>admin de la mesa " . $idmesa . " del restaurante " . $_SESSION['restaurante']; 
    ?>

    <form action="adminmesa.php" method="post">
        <?php
            selectestdomesa($conn);
        ?>
        <button type="submit">actualizar</button>
    </form>
</body>

</html>