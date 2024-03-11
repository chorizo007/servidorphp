<?php
$errores = "";
$nombre = "";
$descripcion = "";
$precio = "";
$peso = "";

if (!isset($_SESSION['admin'])) {

} else {
    header("Location: login.php");
}

require('nav.php');
require('constantes.php');
require('funciones.php');


if (!empty($_POST['aceptar'])) {

    $codigo = $_POST['aceptar'];
    $query = "UPDATE reservas SET aceptada = 1 where reservaID = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $codigo, PDO::PARAM_STR);
    $stmt->execute();
    header("Location: adminpropietarios.php");

} else if (!empty($_POST['pais'])) {

    $pais = $_POST['pais'];
    $ciudad = $_POST['ciudad'];
    $cp = $_POST['cp'];
    $direccion = $_POST['direccion'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $tipo_alquiler = $_POST['tipo_alquiler'];
    $precio_min = $_POST['precio'];

    if (empty($nombre) || empty($descripcion) || empty($precio) || empty($peso)) {
        $errores = "Rellene todo el formulario";
    } else {
        $query = "INSERT INTO $nombretabla (pais, ciudad, cp, direccion , latitud ,longitud) VALUES (:pais, :ciudad, :cp, :direccion , :latitud , :longitud)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':pais', $pais, PDO::PARAM_STR);
        $stmt->bindParam(':ciudad', $ciudad, PDO::PARAM_STR);
        $stmt->bindParam(':cp', $cp, PDO::PARAM_STR);
        $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $stmt->bindParam(':latitud', $latitud, PDO::PARAM_STR);
        $stmt->bindValue(':longitud', $longitud, PDO::PARAM_STR);
        $stmt->execute();

    }
}

echo $errores;
?>

