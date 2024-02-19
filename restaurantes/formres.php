<?php
/*
CREATE USER 'mimesa'@'%' IDENTIFIED BY 'mimesa';
GRANT ALL PRIVILEGES ON mimesa.* TO 'mimesa'@'%';

-- Actualizar privilegios
FLUSH PRIVILEGES;
*/
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php
function crearselect($conn, $nombre)
{
    $query = "SELECT DISTINCT $nombre FROM mesa";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    echo "<select name='$nombre'>";
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option>" . $result[$nombre] . "</option>";
    }
    echo "</select>";
}


$servername = "127.0.0.1";
$username = "mimesa";
$password = "mimesa";
$dbname = "MIMESA";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>restaurante</title>
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
    <h2>busqueda</h2>

    <form action="buscarresta" method="post">

        <label for="correo">restaurante</label>

        <?php
        crearselect($conn, 'restaurante');
        ?>

        <label for="correo">nuermo de comensales</label>

        <?php
        crearselect($conn, 'capacidad');
        ?>

        <label for="correo">fecha de reserva</label>

        <select name="mes">
            <?php
            setlocale(LC_TIME, 'es_ES.UTF-8');
            for ($i = 1; $i <= 12; $i++) {
                $nombre_mes = strftime('%B', mktime(0, 0, 0, $i, 1));
                echo "<option value='$i'>$nombre_mes</option>";
            }
            ?>
        </select>


        <select name="dias">
            <?php
            for ($i = 1; $i <= 31; $i++) {
                echo "<option value='$i'>$i</option>";
            }
            ?>
        </select>



        <input type="submit" value="Enviar">
        <input type="reset" name=“borrar" value="Limpiar datos">
    </form>


</body>

</html>