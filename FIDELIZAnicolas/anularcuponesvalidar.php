<?php
session_start();

if (isset($_SESSION['admin'])) {
} else {
    header("Location: ../pricipal.php");
}

$servername = "127.0.0.1";
$username = "fideliza";
$password = "fideliza";
$dbname = "FIDELIZA";


$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!empty($_POST['borrar'])) {
    $codigo = $_POST['borrar'];
    $array_vampos = explode(";", $codigo);
    $query = "UPDATE cupones set fechai_validez = null , fechaf_validez = null WHERE clienteid = :codigo1 and premioid = :codigo2";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':codigo1', $array_vampos[0], PDO::PARAM_STR);
    $stmt->bindParam(':codigo2', $array_vampos[1], PDO::PARAM_STR);
    $stmt->execute();
    header("Location: anularcupones.php");
} 
?>
