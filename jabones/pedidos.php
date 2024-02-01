<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php
session_start();

require('constantes.php');

if (!empty($_SESSION['email'])) {
    $correo = $_SESSION['email'];
}else{
    header("Location: login.php");
}


$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query = "SELECT * FROM pedidos WHERE email = :correo";
$stmt = $conn->prepare($query);
$stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
$stmt->execute();
$num_rows = $stmt->rowCount();
if($num_rows>0){
    echo '<form action="eliminarcompra.php" method="post">';
    echo '<table border="1">';
    echo '<tr><th>codigo del pedido</th><th>fecha del pedido </th><th>fecha estimada de la entrega</th> <th>total del pedido</th>' ;
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $result['pedidoid'] . '</td>';
        echo '<td>' . $result['fechapedido'] . '</td>';
        echo '<td>' . $result['fechaentrega'] . '</td>';
        echo '<td>' . $result['totalpedido'] . '</td>';
        echo '</tr>';
    }
    echo '</form>';
}else{
    echo "hay ningun pedido realizado todavia";
}


$conn = null;
