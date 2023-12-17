<?php
session_start();
include('comprobar_user.php');
include('estilos.html');
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

<h1>Resultados actuales:</h1>

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
        <td><?php echo number_format(($si/$total*100), 2); ?></td>
        <td>
            <?php
            echo "<div style='width:" . ($si/$total*100) . "%; background-color: orange;'>";
            echo "Votos Sí: " . $si;
            echo "</div>";
            ?>
        </td>
    <tr>
    <tr>
        <td>no</td>
        <td><?php echo $resultados['votos_no']; ?></td>
        <td><?php echo number_format(($no/$total*100), 2); ?></td>
        <td>
            <?php
                echo "<div style='width:" . ($no/$total*100) . "%; background-color: orange;'>";
                echo "Votos no: " . $no;
                echo "</div>";
            ?>
        </td>
    <tr>
</table>


<?php
    echo"<br>";
    echo"<br>";
    echo "Numero total de votos emitidos: ". $total;
    echo"<br>";
    echo"<br>";
    echo "<a href='encuesta.php'>pagina de votacion</a>";
    echo"<br>";
?>
