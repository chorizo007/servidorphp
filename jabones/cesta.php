<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php
session_start();

require('constantes.php');

if (!empty($_SESSION['email'])) {
    $correo = $_SESSION['email'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idjabon = $_POST['idjabon'];
    try {
        echo "aqui";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM cesta WHERE email = :correo";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        $num_rows = $stmt->rowCount();
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
