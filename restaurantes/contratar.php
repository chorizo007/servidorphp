<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: inicio.php");
    exit();
}

require('cabecera.php');

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
            echo "<h3>reserva realizada con exito en :".$restaurante."</h3>";
            echo "<p>numero de la mesa :".$id."</p>";
            echo "<p>email del cliente :".$email."</p>";
            echo "<p>fecha de la reser va :".$fechareserva."</p>";
            echo "<p>hora :".$hora."</p>";
            echo "<p>numero de personas :".$capacidad."</p>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
