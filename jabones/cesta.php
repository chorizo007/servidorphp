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
}


$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query = "SELECT * FROM itemcesta inner join productos on itemcesta.productoid=productos.productoid WHERE cestaid = (select cestaid from cesta where email = :correo)";
$stmt = $conn->prepare($query);
$stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
$stmt->execute();
$num_rows = $stmt->rowCount();
$_SESSION['cestacantidad'] = $num_rows;
echo $_SESSION['cestacantidad'];
if($num_rows>0){
    echo '<form action="eliminarcompra.php" method="post">';
    echo '<table border="1">';
    echo '<tr><th>nombre</th><th>cantidad</th>';
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $result['nombre'] . '</td>';
        echo '<td>' . $result['cantidad'] . '</td>';
        echo '<td><button type="submid" name="eliminar" value="' . $result['itemcestaid'] . '">quitar de la cesta</button></td>';
        echo '</tr>';
    }
    echo '</form>';
    echo '<button><a href="comprar.php">comprar</a></button></td>';
}else{
    echo "no hay ninguno producto en la cesta";
}


$conn = null;
