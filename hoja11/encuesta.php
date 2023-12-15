<?php
// Conexión a la base de datos

$conexion = new mysqli('localhost', 'root', 'root', 'inmobiliaria');
if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener la opción seleccionada
    $opcion = $_POST["opcion"];

    // Actualizar los votos en la base de datos
    if ($opcion === "si") {
        $query = "UPDATE votos SET votos_si = votos_si + 1 WHERE id = 1";
    } elseif ($opcion === "no") {
        $query = "UPDATE votos SET votos_no = votos_no + 1 WHERE id = 1";
    }

    $result = $conexion->query($query);

    if ($result) {
        echo "¡Gracias por tu voto!";
    } else {
        echo "Error al procesar el voto: " . $conexion->error;
    }
}

// Obtener los resultados actuales de la encuesta
$queryResultados = "SELECT votos_si, votos_no FROM votos WHERE id = 1";
$resultResultados = $conexion->query($queryResultados);
$resultados = $resultResultados->fetch_assoc();

// Cerrar conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta</title>
</head>
<body>

<h2>Encuesta</h2>
<form action="encuesta.php" method="post">
    <p>¿Estás satisfecho con nuestros servicios?</p>
    <input type="radio" name="opcion" value="si" required> Sí
    <input type="radio" name="opcion" value="no" required> No
    <br>
    <input type="submit" value="Votar">
</form>

<h3>Resultados actuales:</h3>
<p>Votos Sí: <?php echo $resultados['votos_si']; ?></p>
<p>Votos No: <?php echo $resultados['votos_no']; ?></p>

</body>
</html>
