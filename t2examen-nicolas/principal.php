<?php

session_start();

require('cabecera.php');

if (!empty($_SESSION['email'])) {
    $es_user = $_SESSION['email'];
}

$servername = "127.0.0.1";
$username = "jabon";
$password = "jabon";
$dbname = "jabonescarlatty";

$numerodeproductos = 2;

$paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

$inicio = ($paginaActual - 1) * $numerodeproductos;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT * FROM productos";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $totalproductos = $stmt->rowCount() / $numerodeproductos;


    $query = "SELECT * FROM productos limit $inicio, $numerodeproductos";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $num_rows = $stmt->rowCount();
    echo "<h1>PRODUCTOS</h1>";
    echo '<form action="comprajabon.php" method="post">';
    echo '<p>Número de productos: ' . $num_rows . '</p>';
    echo '<div id="contenedorelementos">';
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<div id="elemento">';
        echo '<h4>' . $result['nombre'] . '</h4>';
        echo '<p>' . $result['descripcion'] . '</p>';
        echo '<p>peso:' . $result['peso'] . '</p>';
        echo '<p class="precioelemento">' . $result['precio'] . '</td>';
        echo '<td><img src="imagenes/'.$result['productoid'].'.jpg" style="width: 50px;"></td>';
        if ($_SESSION['jabanes']>0) {
            echo '<td><button type="submid" name="idjabon" value="' . $result['productoid'] . '">añadir a la cesta</button></td>';
        }
        echo '</div>';

    }
    echo '</div>';
    echo '</form>';
    echo '<div>';
    for ($i = 1; $i <= $totalproductos + 1; $i++) {
        echo '<a href="inicio.php?pagina=' . $i . '">' . $i . '</a> ';
    }
    echo '</div>';
    echo "<br>";
    if ($es_user && !isset($_SESSION['admin'])) {
        echo '<button><a href="cesta.php">cesta</a></button></td>';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


$conn = null;



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domenico Scarlatti</title>
    <style>
        #contenedorelementos {
            display: flex;
            flex-wrap: wrap;
        }

        #elemento {
            border: 0.15em solid black;
            border-radius: 10px;
            width: 260px;
            height: 220px;
            padding: 10px;
            background-color: #f0f0f0;
            margin: 5px;
        }

        #elemento h4,
        #elemento p {
            text-overflow: ellipsis;
        }

        .precioelemento {
            font-size: large;
            color: rgb(243, 156, 42);
        }
    </style>
</head>
<body>
    
</body>
</html>