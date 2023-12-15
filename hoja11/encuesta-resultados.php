<?php

$conexion = new mysqli('localhost', 'web', 'web', 'inmobiliaria');
if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}
$queryResultados = "SELECT votos_si, votos_no FROM votos WHERE id = 1";
$resultResultados = $conexion->query($queryResultados);
$resultados = $resultResultados->fetch_assoc();

// Cerrar conexión
$conexion->close();
?>

<h3>Resultados actuales:</h3>
<p>Votos Sí: <?php echo $resultados['votos_si']; ?></p>
<p>Votos No: <?php echo $resultados['votos_no']; ?></p>
<p>total de votos <?php echo $resultados['votos_no'] + $resultados['votos_si']; ?></p>
