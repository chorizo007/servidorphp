<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //aqui se tendria que hacer una consulta en una base de datos 
    $usuario_valido = "nico";  
    $contrasena_valida = "1234";

    $usuario_ingresado = $_POST["usuario"];
    $contrasena_ingresada = $_POST["contrasena"];

    if ($usuario_ingresado == $usuario_valido && $contrasena_ingresada == $contrasena_valida) {
        // Autenticación exitosa
        $_SESSION["usuario"] = $usuario_ingresado;

        // Redireccionar hacia la página información.php
        header("Location: informacion.php");
        exit();
    } else {
        // Autenticación fallida
        header("Location: acreditacion.php");  
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acreditación</title>
</head>
<body>

    <form method="post" action="acreditacion.php">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>

        <button type="submit">Iniciar sesión</button>
    </form>

</body>
</html>
