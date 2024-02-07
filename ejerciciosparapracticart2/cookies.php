<?php
//hazme un carrito de la compra en las cookies del cliente
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php
foreach ($_COOKIE as $key => $value) {
    setcookie($key, '', time() - 600, '/');
}       
$servername = "127.0.0.1";
$username = "jabon";
$password = "jabon";
$dbname = "jabonescarlatty";
$correo = "nico@nicolas.com";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT * from itemcesta inner join cesta on cesta.cestaid = itemcesta.cestaid where email = :correo";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $stmt->execute();
    $num_rows = $stmt->rowCount();
    $aux = 0;
    if ($num_rows > 0) {
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            setcookie('productoid'.$aux, $result['productoid'], 0);
            setcookie('cantidad'.$aux, $result['cantidad'], 0);
            setcookie('cestaid'.$aux, $result['cestaid'], 0);
            $aux++;
        }

    } else {
        echo "no tienes nada en el carrito";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$cookies = $_COOKIE;

echo "<h2>Cookies en el nivel: todos</h2>";
echo "<table border='1'>
        <tr>
            <th>Nombre</th>
            <th>Contenido</th>
        </tr>";

foreach ($cookies as $nombre => $contenido) {
    echo "<tr>
            <td>$nombre</td>
            <td>$contenido</td>
        </tr>";
}

$conn = null;

?>

