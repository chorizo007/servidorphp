<?php
session_start();

if (isset($_SESSION['admin'])) {

} else {
    header("Location: principal.php");
}

$servername = "127.0.0.1";
$username = "fideliza";
$password = "fideliza";
$dbname = "FIDELIZA";


$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query = "SELECT * FROM PREMIOS WHERE fechaf_validez > current_date";
$stmt = $conn->prepare($query);
$stmt->execute();
$num_rows = $stmt->rowCount();
echo "<h1>ADMIN PREMIOS</h1>";
echo '<form action="añadirborrarpremios.php" method="post">';
echo '<p>Número de filas: ' . $num_rows . '</p>';
echo '<table border="1">';
echo '<tr><th>premioid</th><th>ddescrip</th>';
echo '</tr>';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>' . $row['premioid'] . '</td>';
    echo '<td>' . $row['ddescrip'] . '</td>';
    echo '<td><button type="submid" name="borrar" value="' . $row['premioid'] . '">borrar</button></td>';
    echo '</tr>';
}
echo '</table>';
echo '<td><button name="añadir" value="añadir">añadir un premio</button></td>';
echo '</form>';

// Cerrar conexión
mysqli_close($conexion);
exit();
