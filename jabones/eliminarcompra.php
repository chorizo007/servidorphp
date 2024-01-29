<?php
session_start();

if (!empty($_SESSION['email'])) {
    $es_user = $_SESSION['email'];
}

$servername = "127.0.0.1";
$username = "jabon";
$password = "jabon";
$dbname = "jabonescarlatty";

$iditemcesta = $_POST['eliminar'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT cantidad FROM itemcesta WHERE itemcestaid = :idcesta";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':idcesta', $iditemcesta, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $puede += $result['cantidad'];
    $_SESSION['jabanes'] = $puede;
    
    $query = "DELETE FROM itemcesta WHERE itemcestaid = :idcesta";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':idcesta', $iditemcesta, PDO::PARAM_STR);
    $stmt->execute();
    echo "eliminado";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
