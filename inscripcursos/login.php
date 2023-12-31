<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php
session_start();

if (isset($_SESSION['nombre_usuario'])) {
    header("Location: cursosabi.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexión a la base de datos
    $conexion = mysqli_connect('localhost', 'cursos', 'cursos', 'cursoscp');
    if (!$conexion) {
        die('Error de conexión: ' . mysqli_connect_error());
    }

    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    $query = "SELECT * FROM administradores WHERE nombre_usuario = '$nombre_usuario' AND contrasena = '$contrasena'";
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $_SESSION['nombre_usuario'] = $nombre_usuario;
        $_SESSION['admin'] = "si";
        header("Location: cursosabi.php");
        exit();
    } else {
        $query = "SELECT * FROM solicitantes WHERE dni = '$nombre_usuario' AND contrasena = '$contrasena'";
        $result = mysqli_query($conexion, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $_SESSION['nombre_usuario'] = $nombre_usuario;
            header("Location: cursosabi.php");
        }else{
            $error_message = "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
        }
    }
    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
</head>
<body>

<h2>Iniciar Sesión</h2>

<?php
if (isset($error_message)) {
    echo '<p style="color: red;">' . $error_message . '</p>';
}
?>

<form method="post" action="login.php">
    <label for="nombre_usuario">Nombre de Usuario:</label>
    <input type="text" id="nombre_usuario" name="nombre_usuario" required><br>

    <label for="contrasena">Contraseña:</label>
    <input type="password" id="contrasena" name="contrasena" required><br>

    <input type="submit" value="Iniciar Sesión">
</form>


<br>
<br>
<a href="registro.php">No tienes cuenta ? </a>
</body>
</html>
