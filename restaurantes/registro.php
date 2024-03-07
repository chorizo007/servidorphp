<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php
require('cabecera.php');
session_start();
if (isset($_SESSION['nombre_usuario'])) {
    header("Location: formres.php");
    exit();
}

$mensaje = "";
$corregir = false;

$contra = "";
$nombre = "";
$telefono = "";
$correo = "";
$direccion = "";
$cp = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $direccion = $_POST['direccion'];
    $contra = $_POST['contra'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $cp = $_POST['cp'];

    $mensaje = "errores: ";

    if (empty($direccion) || empty($contra) || empty($nombre) || empty($telefono) || empty($correo) || empty($cp)) {
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
                $_SESSION['email'] = $correo;
                $_SESSION['jabanes'] = 2;
                header("Location: formres.php");
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
    <h2>Registro</h2>
    <?php
    echo $mensaje;
    ?>
    <form action="registro.php" method="post" enctype="multipart/form-data">

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

        <input type="file" name="fichero">

        <br>

        <input type="submit" value="Enviar">
        <input type="reset" name=“borrar" value="Limpiar datos">
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