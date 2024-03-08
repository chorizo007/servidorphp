<?php
session_start();

if (isset($_SESSION['email'])) {
    $es_user = $_SESSION['email'];
}
if (isset($_SESSION['admin'])) {
} else {
    header("Location: login.php");
}

require('nav.php');
require('constantes.php');
require('funciones.php');

try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT * FROM productos";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $num_rows = $stmt->rowCount();
    echo "<h1>ADMIN PRODUCTOS</h1>";
    echo '<form action="adminañadircampotabla.php" method="post">';
    echo '<p>Número de filas: ' . $num_rows . '</p>';
    echo '<table border="1">';
    echo '<tr><th>productoid</th><th>nombre</th><th>descripcion</th><th>peso</th><th>precio</th>';
    echo '</tr>';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $row['productoid'] . '</td>';
        echo '<td>' . $row['nombre'] . '</td>';
        echo '<td>' . $row['descripcion'] . '</td>';
        echo '<td>' . $row['peso'] . '</td>';
        echo '<td>' . $row['precio'] . '</td>';
        echo '<td><button type="submid" name="borrar" value="' . $row['productoid'] . '">borrar</button></td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '<td><button name="añadir" value="añadir">añadir curso</button></td>';
    echo '</form>';
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

exit();


?>