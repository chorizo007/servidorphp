

<?php


$servername = "127.0.0.1";
$username = "jabon";
$password = "jabon";
$dbname = "jabonescarlatty";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    general($conn);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

function general($conn)
{
    $query = "SELECT * FROM productos";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $cantidad = $row['cantidad'];
        $id = $row['id'];
        $precio = $row['precio_unidad'];
        if ($cantidad < 10) {
            $cantidad_comprar = $cantidad - 50; //pon la cantidad minima que quieras xdd
            $precio_total = $precio * $cantidad_comprar;
            comprar($conn, $id, $precio_total, $cantidad_comprar);
        }
    }
}

function comprar($conn, $id, $precio_total, $cantidad)
{
    $id_provedor = mejorprovedor($conn);
    $query = "INSERT INTO ordenes_compra (id_producto,id_proveedor,cantidad_comprada,precio_total) values (:idproducto, :idproveedor, :cantidad , :precio_total)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':idproducto', $id, PDO::PARAM_STR);
    $stmt->bindParam(':idproveedor', $id_provedor, PDO::PARAM_STR);
    $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_STR);
    $stmt->bindParam(':precio_total', $precio_total, PDO::PARAM_STR);
    $stmt->execute();
}

function mejorprovedor($conn)
{
    $query = "SELECT id FROM proveedores order by tiempo_entrega_dias asc limit 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['id'];
}
?>