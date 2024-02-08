<?php
if (!empty($_SESSION['email'])) {
    $correo = $_SESSION['email'];
} else {
    header("Location: adoptamascota.php");
    exit();
}
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $mascota = $_POST['nombreperro'];
        $query = "INSERT INTO ADOPCIONES VALUES (:correo,:mascota,current_date())";
        $stmt->bindParam(':correo', $mascota, PDO::PARAM_STR);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt = $conn->prepare($query);
        $success = $stmt->execute();
    if ($success) {
        echo "ADOPTADOOOO";
    } else {
        setcookie('nombre_mascota', $mascota, 0);
    }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
