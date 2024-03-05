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
    $id = $_POST['id'];
    $esperar = $_POST['esperar'];

    if ($esperar == null) {
        $restaurante = $_SESSION['restaurante'];
        $fechareserva = $_SESSION['fechareserva'];
        $hora = $_SESSION['hora'];
        $email = $_SESSION['email'];
        $capacidad = $_SESSION['capacidad'];
        
        $servername = "127.0.0.1";
        $username = "mimesa";
        $password = "mimesa";
        $dbname = "MIMESA";

        try {
            
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "INSERT INTO reservas VALUES(:nummesa, :restaurante, :email, :fechaR, :horaR, 'R', :numpersonas)";
            $stmt1 = $conn->prepare($query);
            $stmt1->bindParam(':nummesa', $id, PDO::PARAM_STR);
            $stmt1->bindParam(':restaurante', $restaurante, PDO::PARAM_STR);
            $stmt1->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt1->bindParam(':fechaR', $fechareserva, PDO::PARAM_STR);
            $stmt1->bindParam(':horaR', $hora, PDO::PARAM_STR);
            $stmt1->bindParam(':numpersonas', $capacidad, PDO::PARAM_STR);
            $stmt1->execute();

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
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

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>restaurante <?php echo $restaurante ?></h1>


</body>

</html>