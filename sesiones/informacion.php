<?php
session_start();

if (isset($_POST['cerrar'])) {
    session_destroy();
    header("Location: acreditacion.php");
    exit();
}

if (!isset($_SESSION["usuario"]) || empty($_SESSION["usuario"])) {
    session_destroy();
    header("Location: acreditacion.php");
    exit();
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


    <a href="https://www.youtube.com/" target="_blank"><button>Otra página</button></a>
    
    <form method="post" action="">
        <button type="submit" name="cerrar" value="cerrar">Cerrar sesión</button>
    </form>

</body>
</html>
