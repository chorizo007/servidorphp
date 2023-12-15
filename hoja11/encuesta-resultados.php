<?php
$conexion = mysqli_connect('localhost', 'web', 'web', 'inmobiliaria');
if (!$conexion) {
    die('Error de conexión: ' . mysqli_connect_error());
}
$queryResultados = "SELECT votos_si, votos_no FROM votos WHERE id = 1";
$resultResultados = mysqli_query($conexion, $queryResultados);
$resultados = mysqli_fetch_assoc($resultResultados);

// Cerrar conexión
mysqli_close($conexion);
?>

<h3>Resultados actuales:</h3>
<p>Votos Sí: <?php echo $resultados['votos_si']; ?></p>
<p>Votos No: <?php echo $resultados['votos_no']; ?></p>
<p>Total de votos <?php echo $resultados['votos_no'] + $resultados['votos_si']; ?></p>
