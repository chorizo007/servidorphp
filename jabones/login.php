<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php
session_start();

if (isset($_SESSION['email'])) {
    header("Location: jabonescarlatty.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "127.0.0.1";
    $username = "jabon";
    $password = "jabon";
    $dbname = "jabonescarlatty";

    $contrasena = $_POST['contrasena'];
    $correo = $_POST['email'];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT * FROM administradores WHERE email = :correo and contraseña = :contra";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':contra', $contrasena, PDO::PARAM_STR);
        $stmt->execute();
        $num_rows = $stmt->rowCount();
        if ($num_rows > 0) {
            $_SESSION['email'] = $correo;
            $_SESSION['admin'] = $correo;
            header("Location: jabonescarlatty.php");
            exit();
        } else {
            $query = "SELECT * FROM clientes WHERE email = :correo and contraseña = :contra";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->bindParam(':contra', $contrasena, PDO::PARAM_STR);
            $stmt->execute();
            $num_rows = $stmt->rowCount();
            $puede = 0;
            if ($num_rows > 0) {
                $_SESSION['email'] = $correo;
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = "SELECT SUM(unidades) AS total_unidades FROM pedidos INNER JOIN itempedido ON itempedido.pedidoid = pedidos.pedidoid WHERE email = :correo AND DATEDIFF(CURDATE(), fechapedido) <= 30";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $puede = ($result['total_unidades'] !== null) ? intval($result['total_unidades']) : 0;
                if($puede<2){  
                     //comprobar el numero de objetos que tiene en la cesta para poder comprar otro mas
                    $query = "SELECT sum(cantidad) AS total_unidades FROM itemcesta inner join productos on itemcesta.productoid=productos.productoid WHERE cestaid = (select cestaid from cesta where email = :correo)";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($result['total_unidades'] !== null){
                        $puede_cesta = $result['total_unidades'];
                    }else{  
                        $puede_cesta = 0;
                    }
                    if($puede_cesta == 0 && $puede == 0){
                        $puede = 2;
                    }else if($puede_cesta < 1 && $puede < 0){
                        $puede = 1;
                    }else{
                        $puede = 0;
                    }
                }
                $_SESSION['jabanes'] = $puede;
                $_SESSION['email'] = $correo;
                header("Location: jabonescarlatty.php");
                exit();
            }else{
                $error_message = "credenciales incorrectas";
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h2 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            margin-top: 10px;
            color: #3498db;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <h2>Iniciar Sesión</h2>

    <?php
    if (isset($error_message)) {
        echo '<p style="color: red;">' . $error_message . '</p>';
    }
    ?>

    <form method="post" action="login.php">
        <label>email: </label>
        <input type="text" id="nombre_usuario" name="email" required><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required><br>

        <input type="submit" value="Iniciar Sesión">
    </form>


    <br>
    <br>
    <a href="registro.php">No tienes cuenta ? </a>
</body>

</html>