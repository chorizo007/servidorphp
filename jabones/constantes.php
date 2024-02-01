<?php
$servername = "127.0.0.1";
$username = "jabon";
$password = "jabon";
$dbname = "jabonescarlatty";


function calcularjabones($correo)
{

    $servername = "127.0.0.1";
    $username = "jabon";
    $password = "jabon";
    $dbname = "jabonescarlatty";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT SUM(unidades) AS total_unidades FROM pedidos INNER JOIN itempedido ON itempedido.pedidoid = pedidos.pedidoid WHERE email = :correo AND DATEDIFF(CURDATE(), fechapedido) <= 30";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result['total_unidades'] !== null) {
        $puede= $result['total_unidades'];
    }else{
        $puede = 0;
    }
    if ($puede < 2) {
        //comprobar el numero de objetos que tiene en la cesta para poder comprar otro mas
        $query = "SELECT sum(cantidad) AS total_unidades FROM itemcesta inner join productos on itemcesta.productoid=productos.productoid WHERE cestaid = (select cestaid from cesta where email = :correo)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['total_unidades'] !== null) {
            $puede_cesta = $result['total_unidades'];
            
        } else {
            $puede_cesta = 0;
        }
        if ($puede_cesta == 0 && $puede == 0) {
            $puede = 2;
        } else if ($puede_cesta < 1 && $puede < 0) {
            $puede = 1;
        } else if ($puede_cesta < 1 && $puede > 0) {
            $puede = 1;
        } else {
            $puede = 0;
        }
    }else{
        $puede = 0;
    }
    $_SESSION['jabanes'] = $puede;
}
