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
    <form action="adoptamascota" method="post">
        <label>raza a buscar:</label>
        <input type="text" value="<?php echo $raza ?>" name="raza"><br>
    </form>


    <?php
    session_start();


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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $raza = $_POST['raza'];
            if($correo!=null){
                $query = "SELECT * FROM animales inner join personalidad_mascota on personalidad_mascota.nombre=animales.nombre inner join rasgos on rasgos.id=personalidad_mascota.rasgo inner join preferencias on preferencias.rasgo=rasgos.id where email = :correo and animales.raza like '%:raza%'order by preferencias.orden";
                $stmt->bindParam(':raza', $raza, PDO::PARAM_STR);
                $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
                $stmt = $conn->prepare($query);

            }else{
                $query = "SELECT * FROM animales";
                $stmt = $conn->prepare($query);
            }
        } else {
            $query = "SELECT * FROM animales inner join personalidad_mascota on personalidad_mascota.nombre=animales.nombre inner join rasgos on rasgos.id=personalidad_mascota.rasgo inner join preferencias on preferencias.rasgo=rasgos.id where email = :correo order by preferencias.orden";
                $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
                $stmt = $conn->prepare($query);
        }
        $stmt->execute();

        $num_rows = $stmt->rowCount();
        echo "<h1>animales adopcion</h1>";
        echo '<form action="procesaradopcion.php" method="post">';
        echo '<p>Número de perros que estan en nuestra perrera: ' . $num_rows . '</p>';
        echo '<div id="contenedorelementos">';
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<div id="elemento">';
            echo '<h4>' . $result['nombre'] . '</h4>';
            echo '<p>' . $result['edad'] . '</p>';
            echo '<p>espacie:' . $result['espacie'] . '</p>';
            echo '<p>estado:' . $result['estado'] . '</p>';
            echo '<p>bacunado:' . $result['bacunado'] . '</p>';
            echo '<p class="precioelemento">peso ' . $result['peso'] . '</td>';
            echo '<td><img src="imagenes/' . $result['foto'] . '.jpg" style="width: 50px;"></td>';
            if ($correo != null) {
                echo '<td><button type="submid" name="nombreperro" value="' . $result['nombre'] . '">adoptar</button></td>';
            }
            echo '</div>';
        }
        echo '</div>';
        echo '</form>';
        echo '<div>';
        for ($i = 1; $i <= $totalproductos + 1; $i++) {
            echo '<a href="adoptamascota.php?pagina=' . $i . '">' . $i . '</a> ';
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

</body>

</html>