
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php

$servername = "127.0.0.1";
$username = "jabon";
$password = "jabon";
$dbname = "jabonescarlatty";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(!empty($_POST['modificar'])){
        $idproducto = $_POST['modificar'];
        $nombre = $_POST['$idproducto."nombre"'];
        $descripcion = $_POST['$idproducto."descripcion"'];
        $peso = $_POST['$idproducto."peso"'];
        $precio = $_POST['$idproducto."precio"'];
    }else if(!empty($_POST['borrar'])){
        $idproducto = $_POST['borrar'];
    }else{
        $query = "SELECT * FROM productos";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        echo '<form action="modificartabla.php" method="post">';
        echo '<p>Número de productos: ' . $num_rows . '</p>';
        echo '<table>';
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo '<td><input type="text" name="' . $result['productoid'] . 'nombre" value="' . $result['nombre'] . '"></td>';
            echo '<td><input type="text" name="' . $result['productoid'] . 'descripcion" value="' . $result['descripcion'] . '"></td>';
            echo '<td><input type="text" name="' . $result['productoid'] . 'peso" value="' . $result['peso'] . '"></td>';
            echo '<td><input type="text" name="' . $result['productoid'] . 'precio" value="' . $result['precio'] . '"></td>';
            echo '<td><button type="submid" name="modificar" value="' . $result['productoid'] . '">modificar</button></td>';
            echo '<td><button type="submid" name="borrar" value="' . $result['productoid'] . '">borrar</button></td>';
            echo "</tr>";
        }
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;


?>
