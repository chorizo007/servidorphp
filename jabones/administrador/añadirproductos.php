<?php
session_start();

if (isset($_SESSION['email'])) {
    $es_user = $_SESSION['email'];
}
if (isset($_SESSION['admin'])) {
    $botonadmin = "<button><a href='admin.php'>ADMINISTRAR</a></button>";
} else {
    header("Location: ../jabonescarlatty.php");
}

$servername = "127.0.0.1";
$username = "jabon";
$password = "jabon";
$dbname = "jabonescarlatty";


require('cabecera.php');
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query = "SELECT * FROM productos";
$stmt = $conn->prepare($query);
$stmt->execute();
$num_rows = $stmt->rowCount();
echo "<h1>ADMIN PRODUCTOS</h1>";
echo '<form action="validarproductos.php" method="post">';
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

// Cerrar conexión
mysqli_close($conexion);
exit();
