<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>

<?php
session_start();

if (isset($_SESSION['nombre_usuario'])) {
    header("Location: consulta_noticias.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = mysqli_connect('localhost', 'web', 'web', 'inmobiliaria');
    
    if (!$conexion) {
        die('Error de conexión: ' . mysqli_connect_error());
    }

    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    $query_comprobar = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario'";
    $result_comp = mysqli_query($conexion, $query_comprobar);
    if (mysqli_num_rows($result_comp) == 0) {
        $query = "INSERT INTO usuarios (nombre_usuario, contrasena, es_admin) VALUES (?, ?, 0)";
        $stmt = mysqli_prepare($conexion, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $nombre_usuario, $contrasena);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['nombre_usuario'] = $nombre_usuario;
                header("Location: consulta_noticias.php");
                exit();
            } else {
                echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error al preparar la consulta: " . mysqli_error($conexion);
        }
    } else {
        echo "Ya existe un usuario con este nombre. Por favor, elige otro nombre de usuario.";
    }

    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>

<h2>REGISTRO</h2>

<form method="post" action="registro.php">
    <label for="nombre_usuario">Nombre de Usuario:</label>
    <input type="text" id="nombre_usuario" name="nombre_usuario" required><br>

    <label for="contrasena">Contraseña:</label>
    <input type="password" id="contrasena" name="contrasena" required><br>

    <input type="submit" value="Registrarse">
</form>

<br>
<br>
<a href="login.php">¿Ya tienes cuenta? Inicia sesión aquí.</a>

</body>
</html>
