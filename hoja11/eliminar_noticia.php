<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_noticia = $_POST["id_noticia"];

    $conexion = new mysqli('localhost', 'web', 'web', 'inmobiliaria');
    if ($conexion->connect_error) {
        die('Error de conexión: ' . $conexion->connect_error);
    }

    $query = "DELETE FROM noticias WHERE ID = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id_noticia);

    if ($stmt->execute()) {
        echo "Noticia eliminada correctamente.";
    } else {
        echo "Error al eliminar la noticia: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
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

<h2>Eliminar Noticia</h2>

<form action="eliminar_noticia.php" method="post">
    <label for="id_noticia">ID de la noticia a eliminar:</label>
    <input type="number" name="id_noticia" required><br>

    <input type="submit" value="Eliminar Noticia">
</form>

</body>
</html>
