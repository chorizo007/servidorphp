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
    $_SESSION['jabanes']=$_SESSION['jabanes']-1;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM cesta WHERE email = :correo";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        $num_rows = $stmt->rowCount();
        if ($num_rows > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $idcesta = $result['cestaid'];
            $query = "SELECT * FROM itemcesta WHERE productoid = :productoid and cestaid = :idcesta";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':productoid', $idjabon, PDO::PARAM_STR);
            $stmt->bindParam(':idcesta', $idcesta, PDO::PARAM_STR);
            $stmt->execute();
            $num_rows = $stmt->rowCount();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($num_rows > 0) {
                $query = "UPDATE itemcesta SET cantidad = 2 WHERE productoid = :productoid and cestaid = :idcesta";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':productoid', $idjabon, PDO::PARAM_STR);
                $stmt->bindParam(':idcesta', $idcesta, PDO::PARAM_STR);
                $stmt->execute();
            }else{
                $query = "SELECT * FROM itemcesta WHERE cestaid = :idcesta";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':idcesta', $idcesta, PDO::PARAM_STR);
                $stmt->execute();
                $num_rows = $stmt->rowCount();
                if ($num_rows > 0) {
                    $iditemcesta = 2;
                }else{
                    $iditemcesta = 1;
                }
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $query = "INSERT INTO itemcesta (itemcestaid,cestaid,productoid, cantidad) VALUES (:itemcesta, :idcesta , :productoid , 1)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':itemcesta', $iditemcesta, PDO::PARAM_STR);
                $stmt->bindParam(':idcesta', $idcesta, PDO::PARAM_STR);
                $stmt->bindParam(':productoid', $idjabon, PDO::PARAM_STR);
                $stmt->execute();
            }
        } else {
            $query = "INSERT INTO cesta (email, fechaCreacion) VALUES (:correo, current_date())";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->execute();

            $query = "INSERT INTO itemcesta (itemcestaid,cestaid,productoid, cantidad) VALUES (1, (SELECT cestaid FROM cesta WHERE email = :correo) , :productoid , 1)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->bindParam(':productoid', $idjabon, PDO::PARAM_STR);
            $stmt->execute();

        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
    header("Location: cesta.php");
}
