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
$query = "SELECT * FROM CUPONES inner join premios on premios.premioid = cupones.premioid inner join clientes on clientes.clienteid=cupones.clienteid";
$stmt = $conn->prepare($query);
$stmt->execute();
$num_rows = $stmt->rowCount();
echo "<h1>ADMIN CUPONES</h1>";
echo '<form action="anularcuponesvalidar.php" method="post">';
echo '<p>Número de filas: ' . $num_rows . '</p>';
echo '<table border="1">';
echo '<tr><th>email del cliente</th><th>descripcion del premio</th>';
echo '</tr>';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>' . $row['cemail'] . '</td>';
    echo '<td>' . $row['ddescrip'] . '</td>';
    echo '<td>' . $row['fechai_validez'] . '</td>';
    echo '<td>' . $row['fechaf_validez'] . '</td>';
    echo '<td><button type="submid" name="borrar" value="' . $row['clienteid'] . ';' . $row['premioid'] . '">quitar cupon</button></td>';
    echo '</tr>';
}
echo '</table>';
echo '</form>';

// Cerrar conexión
mysqli_close($conexion);
exit();
