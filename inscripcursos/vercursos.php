<?php
session_start();
include("estilos.php");
if(isset($_SESSION['nombre_usuario'])) {
    $es_user = $_SESSION['nombre_usuario'];
}
$conexion = mysqli_connect('localhost', 'cursos', 'cursos', 'cursoscp');
if (!$conexion) {
    die('Error de conexión: ' . mysqli_connect_error());
}
$query = "SELECT * FROM solicitudes where dni = '$es_user'";
$result = mysqli_query($conexion, $query);
// Obtener el número de filas
$num_rows = mysqli_num_rows($result);
echo "<h1>mis solicidudes</h1>";
echo '<form action="solicitud.php" method="post">';
echo '<p>Número de cursos solicitados: ' . $num_rows . '</p>';
echo '<table border="1">';
echo '<tr><th>dni</th><th>codigocurso</th><th>fechasolicitud</th><th>estado</th>';
echo '</tr>';
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row['dni'] . '</td>';
    echo '<td>' . $row['codigocurso'] . '</td>';
    echo '<td>' . $row['fechasolicitud'] . '</td>';
    echo '<td>' . $row['admitido'] . '</td>';
    echo '</tr>';
}
echo '</table>';
echo '</form>';
mysqli_close($conexion);
exit();
?>