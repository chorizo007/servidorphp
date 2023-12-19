<?php
session_start();
include('soloadmin.php');
include('estilos.html');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_noticia = $_POST["id_noticia"];

    $conexion = mysqli_connect('localhost', 'web', 'web', 'inmobiliaria');
    if (!$conexion) {
        die('Error de conexión: ' . mysqli_connect_error());
    }

    $query = "DELETE FROM noticias WHERE ID = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_noticia);

    if (mysqli_stmt_execute($stmt)) {
        echo "Noticia eliminada correctamente.";
    } else {
        echo "Error al eliminar la noticia: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Noticia</title>
</head>
<body>

<h1>Eliminar Noticia</h1>

<form action="eliminar_noticia.php" method="post">
    <label for="id_noticia">ID de la noticia a eliminar:</label>
    <input type="number" name="id_noticia" required><br>

    <input type="submit" value="Eliminar Noticia">
</form>

</body>
</html>
