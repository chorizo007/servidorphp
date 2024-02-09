<?php
session_start();
if (isset($_SESSION['email'])) {
    $correo = $_SESSION['email'];
}else {
    header("Location: ../principal.php");
}
if (isset($_SESSION['admin'])) {
    $admin = $_SESSION['admin'];
} 

$servername = "127.0.0.1";
$username = "fideliza";
$password = "fideliza";
$dbname = "FIDELIZA";


$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if($admin == null){
    $query = "SELECT * FROM CUPONES inner join premios on premios.premioid = cupones.premioid WHERE clienteid = (select clienteid from cliente where cemail = :correo) and current_date between cupones.fechai_validez and cupones.fechaf_validez";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':cemail', $correo, PDO::PARAM_STR);
}else{
    $query = "SELECT * FROM CUPONES inner join premios on premios.premioid = cupones.premioid WHERE current_date between cupones.fechai_validez and cupones.fechaf_validez";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$num_rows = $stmt->rowCount();
echo "<h1>numero de cupones</h1>";
echo '<form action="añadirborrarpremios.php" method="post">';
echo '<p>numero de cupones que hay: ' . $num_rows . '</p>';
echo '<table border="1">';
echo '<tr><th>cuponid</th><th>descripcion</th>';
echo '</tr>';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>' . $row['premioid'] . '</td>';
    echo '<td>' . $row['ddescrip'] . '</td>';
    echo '</tr>';
}
echo '</table>';
echo '</form>';

// Cerrar conexión
mysqli_close($conexion);
exit();
