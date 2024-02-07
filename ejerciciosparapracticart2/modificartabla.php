
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php

$servername = "127.0.0.1";
$username = "jabon";
$password = "jabon";
$dbname = "jabonescarlatty";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT * FROM clientes WHERE email = :correo";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $num_rows = $stmt->rowCount();
    if ($num_rows > 0) {
        $mensaje .= "este correo ya esta en uso";
    } else {

    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;


?>
