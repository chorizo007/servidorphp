<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();  // Asegúrate de iniciar la sesión

if (!empty($_SESSION['email'])) {
    $correo = $_SESSION['email'];
}

$servername = "127.0.0.1";
$username = "jabon";
$password = "jabon";
$dbname = "jabonescarlatty";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener el ID de la cesta
    $query = "SELECT * FROM cesta WHERE email = :correo";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $idcesta = $result['cestaid'];

    // Obtener el último ID de pedido
    $query = "SELECT pedidoid FROM pedidos ORDER BY pedidoid DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $codigo_pedido = $result ? $result['pedidoid'] + 1 : 1;

    // Calcular el precio total
    $query = "SELECT SUM(precio) as total FROM productos
              INNER JOIN itemcesta ON productos.productoid = itemcesta.productoid
              WHERE cestaid = :cestaid";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':cestaid', $idcesta, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $precio_total = $result['total'];

    // Insertar en la tabla de pedidos
    $query = "INSERT INTO pedidos VALUES (:codigopedido, :email, CURRENT_DATE, DATE_ADD(CURRENT_DATE, INTERVAL 30 DAY), :total, false)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $correo, PDO::PARAM_STR);
    $stmt->bindParam(':codigopedido', $codigo_pedido, PDO::PARAM_STR);
    $stmt->bindParam(':total', $precio_total, PDO::PARAM_STR);
    $stmt->execute();

    $query = "INSERT INTO itempedido 
          VALUES (
              (SELECT itemcestaid FROM itemcesta WHERE cestaid = :idcesta ORDER BY itemcestaid DESC LIMIT 1), 
              :codigopedido, 
              (SELECT productoid FROM itemcesta WHERE cestaid = :idcesta ORDER BY itemcestaid DESC LIMIT 1), 
              (SELECT cantidad FROM itemcesta WHERE cestaid = :idcesta ORDER BY itemcestaid DESC LIMIT 1)
          )";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':idcesta', $idcesta, PDO::PARAM_STR);
    $stmt->bindParam(':codigopedido', $codigo_pedido, PDO::PARAM_STR);
    $stmt->execute();


    $numero_productos = $_SESSION['cestacantidad'] ;
    if($numero_productos == 2){
        $query = "INSERT INTO itempedido 
          VALUES (
              (SELECT itemcestaid FROM itemcesta WHERE cestaid = :idcesta ORDER BY itemcestaid ASC LIMIT 1), 
              :codigopedido, 
              (SELECT productoid FROM itemcesta WHERE cestaid = :idcesta ORDER BY itemcestaid ASC LIMIT 1), 
              (SELECT cantidad FROM itemcesta WHERE cestaid = :idcesta ORDER BY itemcestaid ASC LIMIT 1)
          )";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idcesta', $idcesta, PDO::PARAM_STR);
        $stmt->bindParam(':codigopedido', $codigo_pedido, PDO::PARAM_STR);
        $stmt->execute();

    }

    
    $numero_productos = $_SESSION['cestacantidad'] ;
    if($numero_productos == 2){
        $query = "INSERT INTO itempedido VALUES ((select itemcestaid itemcesta where cestaid = :idcesta order by itemcestaid asc limit 1), :codigopedido, (select productoid itemcesta where cestaid = :idcesta order by itemcestaid asc limit 1) , (select unidades itemcesta where cestaid = :idcesta order by itemcestaid asc limit 1) )";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':last_itemcestaid', $last_itemcestaid, PDO::PARAM_STR);
        $stmt->bindParam(':codigopedido', $codigo_pedido, PDO::PARAM_STR);
        $stmt->bindParam(':last_productoid', $last_productoid, PDO::PARAM_STR);
        $stmt->bindParam(':last_unidades', $last_unidades, PDO::PARAM_STR);
        $stmt->execute();
    }

    // Eliminar de la tabla itemcesta
    $query = "DELETE FROM itemcesta WHERE cestaid = :cestaid";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':cestaid', $idcesta, PDO::PARAM_STR);
    $stmt->execute();


    // Cerrar la conexión
    echo "realizado con exito";
    $conn = null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
