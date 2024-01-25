<?php
session_start();

require('constantes.php');

if (!empty($_SESSION['email'])) {
    $correo = $_SESSION['email'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idjabon = $_POST['idjabon'];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * cesta WHERE email = :correo";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        $num_rows = $stmt->rowCount();
        if ($num_rows > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $idcesta = $result['cestaid'];
            $query = "SELECT * itemcesta WHERE productoid = :productoid and cestaid = :idcesta";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':productoid', $idjabon, PDO::PARAM_STR);
            $stmt->bindParam(':idcesta', $idcesta, PDO::PARAM_STR);
            $stmt->execute();
            $num_rows = $stmt->rowCount();
            if ($num_rows > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $idcesta = $result['cestaid'];
                $query = "UPDATE itemcesta SET cantidad = 2 WHERE productoid = :productoid and cestaid = :idcesta";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':productoid', $idjabon, PDO::PARAM_STR);
                $stmt->bindParam(':idcesta', $idcesta, PDO::PARAM_STR);
                $stmt->execute();
            }else{
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $idcesta = $result['cestaid'];
                $query = "INSERT INTO itemcesta SET cantidad = 2 WHERE productoid = :productoid and cestaid = :idcesta";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':productoid', $idjabon, PDO::PARAM_STR);
                $stmt->bindParam(':idcesta', $idcesta, PDO::PARAM_STR);
                $stmt->execute();
            }
        } else {
            $query = "SELECT * FROM clientes WHERE email = :correo and contraseña = :contra";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->bindParam(':contra', $contrasena, PDO::PARAM_STR);
            $stmt->execute();
            $num_rows = $stmt->rowCount();
            if ($num_rows > 0) {
                $_SESSION['email'] = $correo;
                header("Location: jabonescarlatty.php");
                exit();
            } else {
                $error_message = "credenciales incorrectas";
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
