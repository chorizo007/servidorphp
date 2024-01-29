<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php

session_start();

if (!empty($_SESSION['email'])) {
    $es_user = $_SESSION['email'];
}

//cormprobar si puede comprar 

$servername = "127.0.0.1";
$username = "jabon";
$password = "jabon";
$dbname = "jabonescarlatty";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT * FROM productos";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $num_rows = $stmt->rowCount();
    echo "<h1>PRODUCTOS</h1>";
    echo $_SESSION['jabanes'];
    echo "<button><a href='logout.php'>Cerrar Sesión</a></button>";
    echo '<form action="comprajabon.php" method="post">';
    echo '<p>Número de productos: ' . $num_rows . '</p>';
    echo '<table border="1">';
    echo '<tr><th>nombre</th><th>descripcion</th><th>peso</th><th>precio</th><th>imagen</th>';
    echo '</tr>';
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $result['nombre'] . '</td>';
        echo '<td>' . $result['descripcion'] . '</td>';
        echo '<td>' . $result['peso'] . '</td>';
        echo '<td>' . $result['precio'] . '</td>';
        echo '<td><img src="'.$result['productoid'].'.jpg"></td>';
        if ($_SESSION['jabanes']>0) {
            echo '<td><button type="submid" name="idjabon" value="' . $result['productoid'] . '">añadir a la cesta</button></td>';
        }
        echo '</tr>';
    }
    echo '</table>';
    echo '</form>';
    if ($es_user && !isset($_SESSION['admin'])) {
        echo '<button><a href="cesta.php">cesta</a></button></td>';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


$conn = null;

