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
echo "<h1>ADMIN pedidos</h1>";
?>
<form action="pedidos.php" method="post">

    <label>email:</label>
    <input type="text" name="email" value='<?php echo $email ?>'>
    <input type="submit" name="filtrar" value="filtrar">
</form>
<?php

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if ($_POST['email'] != null) {
    $correo = $_POST['email'];
    $correo = '%' . $correo . '%';
    $query = "SELECT * FROM pedidos WHERE email LIKE :correo ORDER BY entregado ASC";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
} else {
    $query = "SELECT * FROM pedidos order by entregado asc";
    $stmt = $conn->prepare($query);
}
$stmt->execute();
$num_rows = $stmt->rowCount();


if ($num_rows == 0) {
    echo "este usuario no tiene ningun pedido";
} else {
    echo '<form action="entregar.php" method="post">';
    echo '<p>Número de pedidos: ' . $num_rows . '</p>';
    echo '<table border="1">';
    echo '<tr><th>pedidoid</th><th>email</th><th>fechapedido</th><th>totalpedido</th><th>entregado</th>';
    echo '</tr>';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $row['pedidoid'] . '</td>';
        echo '<td>' . $row['email'] . '</td>';
        echo '<td>' . $row['fechapedido'] . '</td>';
        echo '<td>' . $row['fechaentrega'] . '</td>';
        echo '<td>' . $row['totalpedido'] . '</td>';
        echo '<td>' . $row['entregado'] . '</td>';
        echo '<td><button type="submid" name="entregar" value="' . $row['pedidoid'] . '">entregado</button></td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '</form>';
}

exit();
?>