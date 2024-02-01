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


    $numero_productos = $_SESSION['cestacantidad'];
    if ($numero_productos == 2) {
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
    //require('/var/www/html/github/servidorphp/PHPMailer-master/src/PHPMailer.php');
    //require('/var/www/html/github/servidorphp/PHPMailer-master/src/SMTP.php');
    require('/var/www/html/servidorphp/PHPMailer-master/src/PHPMailer.php');
    require('/var/www/html/servidorphp/PHPMailer-master/src/SMTP.php');

    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->Mailer = "SMTP";
    $mail->SMTPAutoTLS = true;
    $mail->isHTML(true);
    $mail->Port = 25;
    $mail->Host = "localhost";
    $mail->SMTPAuth = true;
    $mail->Username = "jefe@nicolas.com";
    $mail->Password = "jefe";
    $mail->From = "jefe@nicolas.com";
    $mail->FromName = "jefe";
    $mail->Timeout = 30;

    $mail->ClearAddresses();
    $mail->AddAddress($correo);

    $mail->Subject = 'Gracias por confiar con nosotros';

    $mail->addEmbeddedImage($foto, 'imagenID', 'nombre_imagen.jpg');
    $mail->Body .= '<br><img src="cid:imagenID" alt="Imagen Embebida" style="max-width: 400px;">';

    $mail->Body .= "Productos comprados : ";
    $query = "SELECT * FROM pedidos inner join itempedido ON pedidos.pedidoid = itempedido.pedidoid inner join productos on productos.productoid = itempedido.productoid where pedidoid = :pedidoid";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':pedidoid', $codigo_pedido , PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $mail->Body .= "precio total :". $result['pedidos.totalpedido'];
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $mail->Body .= "nombre producto :" . $result['productos.nombre'];
        $mail->Body .= "precio del producto :". $result['productos.precio'];
        $mail->Body .= "precio del producto :". $result['itempedido.cantidad'];
        $mail->Body .= "fecha de entrega estimada :". $result['pedidos.fechaentrega'];
        $mail->addEmbeddedImage("imagenes/".$result['productoid'].".jpg", 'imagenID', 'productos.jpg');
        $mail->Body .= '<br><img src="cid:imagenID" alt="Imagen Embebida" style="max-width: 400px;">';
    }

    $exito = $mail->Send();

    if (!$exito) {
        echo "Problemas enviando correo electrónico a $correo";
        echo "<br/>" . $mail->ErrorInfo;
    } else {
        echo "Mensaje enviado correctamente a $correo";
        echo "<br>";
    }
    $mail->clearAttachments();
    $mail->ClearAddresses();
    $mail->AddAddress('jabones@nicolas.com');

    $mail->Subject = 'nueva compra';

    $mail->addEmbeddedImage($foto, 'imagenID', 'nombre_imagen.jpg');
    $mail->Body .= '<br><img src="cid:imagenID" alt="Imagen Embebida" style="max-width: 400px;">';

    $mail->Body .= "Productos comprados : ";
    $query = "SELECT * FROM pedidos inner join itempedido ON pedidos.pedidoid = itempedido.pedidoid inner join productos on productos.productoid = itempedido.productoid where pedidoid = :pedidoid";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':pedidoid', $codigo_pedido , PDO::PARAM_STR);
    $stmt->execute();
    
    $mail->Body .= "correo del comprador :" . $correo;

    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $mail->Body .= "nombre producto :" . $result['productos.nombre'];
        $mail->Body .= "precio del producto :". $result['productos.precio'];
        $mail->Body .= "precio del producto :". $result['itempedido.cantidad'];
        $mail->Body .= "fecha de entrega estimada :". $result['pedidos.fechaentrega'];
        $mail->addEmbeddedImage("imagenes/".$result['productoid'].".jpg", 'imagenID', 'productos.jpg');
        $mail->Body .= '<br><img src="cid:imagenID" alt="Imagen Embebida" style="max-width: 400px;">';
    }

    $exito = $mail->Send();


    if (!$exito) {
        echo "Problemas enviando correo electrónico a $correo";
        echo "<br/>" . $mail->ErrorInfo;
    } else {
        echo "Mensaje enviado correctamente a $correo";
        echo "<br>";
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


echo '<button><a href="pedidos.php">ver mis pedidos</a></button></td>';
?>