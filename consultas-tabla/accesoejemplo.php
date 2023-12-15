<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servidor = "192.168.3.181";
$usuario = "nicolas";
$contrasena = "1234";
$base_datos = "test";

$conn = new mysqli($servidor, $usuario, $contrasena, $base_datos);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS desdephp (
    anival varchar(20),
    nico varchar(20),
    paco varchar(20)
)");

echo "creada la base de datos \n";

mysqli_query($conn, "insert into desdephp values('nico','paco','anival')");

echo "insertado en la tabla";

?>

