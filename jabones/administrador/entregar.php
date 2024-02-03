<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php
$errores = "";
$nombre = "";
$descripcion = "";
$precio = "";
$peso = "";

session_start();

if (isset($_SESSION['email'])) {
    $es_user = $_SESSION['email'];
}

if (isset($_SESSION['admin'])) {
    $botonadmin = "<button><a href='admin.php'>ADMINISTRAR</a></button>";
} else {
    header("Location: ../jabonescarlatty.php");
}

require('./cabecera.php');

$servername = "127.0.0.1";
$username = "jabon";
$password = "jabon";
$dbname = "jabonescarlatty";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!empty($_POST['entregar'])) {
    $codigo = $_POST['entregar'];
    $query = "update pedidos set entregado = true WHERE pedidoid = :pedidoid";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':pedidoid', $codigo, PDO::PARAM_STR);
    $stmt->execute();
    header("Location: pedidos.php");
} 


?>
