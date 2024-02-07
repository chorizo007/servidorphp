
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php
//hazme un registro y que compruebe que la fecha que introduces es menor a la fecha actual
$mensaje = "";
$corregir = false;

$contra = "";
$nombre = "";
$telefono = "";
$correo = "";
$direccion = "";
$cp = "";
$fechanacimiento = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $direccion = $_POST['direccion'];
    $contra = $_POST['contra'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $cp = $_POST['cp'];
    $fechanacimiento = $_POST['fechanaci'];

    $mensaje = "errores: ";

    $fechaactual = new DateTime();
    $fechandatenaci = new DateTime($fechanacimiento);
    $diferencia = $fechandatenaci->diff($fechaactual);
    $años = $diferencia->y;

    if($años < 18){
        $corregir = true;
        $mensaje .= "no tienes los años correspondientes";
    }
    if (empty($direccion) || empty($contra) || empty($nombre) || empty($telefono) || empty($correo) || empty($cp) || $años < 18) {
        $corregir = true;
        $mensaje .= "rellena todos los campos ";
    } else {
        $servername = "127.0.0.1";
        $username = "jabon";
        $password = "jabon";
        $dbname = "jabonescarlatty";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM clientes WHERE email = :correo";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->execute();
            $num_rows = $stmt->rowCount();
            if ($num_rows > 0) {
                $mensaje .= "este correo ya esta en uso";
            } else {
                $query = "INSERT INTO clientes (email, nombre, direccion, cp, telefono, contraseña) VALUES (:correo, :nombre, :direccion, :cp, :telefono, :contra)";
                $stmt = $conn->prepare($query);

                // Vincular parámetros
                $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
                $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
                $stmt->bindValue(':cp', $cp, PDO::PARAM_STR);
                $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
                $stmt->bindParam(':contra', $contra, PDO::PARAM_STR);
                $stmt->execute();
                exit();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    $conn = null;

}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Solicitantes</title>
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
    <h2>Registros jabones Domenico Scarlatti</h2>
    <?php
    echo $mensaje;
    ?>
    <form action="comparafecha.php" method="post">

        <label for="correo">Correo:</label>
        <input type="email" value="<?php echo $correo ?>" name="correo">

        <br>

        <label>Contraseña:</label>
        <input type="text" value="<?php echo $contra ?>" name="contra"><br>

        <label for="nombre">Nombre:</label>
        <input type="text" value="<?php echo $nombre ?>" name="nombre">

        <br>

        <label for="telefono">Teléfono:</label>
        <input type="tel" value="<?php echo $telefono ?>" name="telefono">

        <br>


        <label>direccion:</label>
        <input type="text" value="<?php echo $direccion ?>" name="direccion">

        <br>

        <label>cp:</label>
        <input type="text" value="<?php echo $cp ?>" name="cp">

        <br>
        <label>fecha de nacimiento (mayores de edad):</label>
        <input type="date" name="fechanaci">

        <br>

        <input type="submit" value="Enviar">
    </form>

    <br>
    <br>
    <a href="login.php">¿Ya tienes cuenta? Inicia sesión aquí.</a>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

</body>

</html>