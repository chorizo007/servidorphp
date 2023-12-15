<?php
session_start();
include('comprobar_user.php');
$conexion = mysqli_connect('localhost', 'web', 'web', 'inmobiliaria');
if (!$conexion) {
    die('Error de conexión: ' . mysqli_connect_error());
}
$queryResultados = "SELECT votos_si, votos_no FROM votos WHERE id = 1";
$resultResultados = mysqli_query($conexion, $queryResultados);
$resultados = mysqli_fetch_assoc($resultResultados);

// Cerrar conexión
mysqli_close($conexion);
$si = $resultados['votos_si'];
$no = $resultados['votos_no'];
$total = $si + $no;
?>

<h3>Resultados actuales:</h3>

<table style='width:100%'>
    <tr>
        <td>respuesta</td>
        <td>votos</td>
        <td>pocentaje</td>
        <td>representacion grafica</td>
    <tr>
    <tr>
        <td>si</td>
        <td><?php echo $resultados['votos_si']; ?></td>
        <td><?php echo ($si/$total*100) ?></td>
        <td>
            <?php
            echo "<div style='width:" . ($si/$total*100) . "%; border: 1px solid black;'>";
            echo "Votos Sí: " . $si;
            echo "</div>";
            ?>
        </td>
    <tr>
    <tr>
        <td>no</td>
        <td><?php echo $resultados['votos_no']; ?></td>
        <td><?php echo ($no/$total*100) ?></td>
        <td>
            <?php
                echo "<div style='width:" . ($no/$total*100) . "%; border: 1px solid black;'>";
                echo "Votos no: " . $no;
                echo "</div>";
            ?>
        </td>
    <tr>
</table>
