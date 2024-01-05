<?php
session_start();
include("estilos.php");
if(isset($_SESSION['nombre_usuario'])) {
    $es_user = $_SESSION['nombre_usuario'];
}
// Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'cursos', 'cursos', 'cursoscp');
if (!$conexion) {
    die('Error de conexión: ' . mysqli_connect_error());
}
// Consulta de noticias
$query = "SELECT * FROM cursos where abierto = true";
$result = mysqli_query($conexion, $query);
// Obtener el número de filas
$num_rows = mysqli_num_rows($result);
echo "<h1>Consulta de noticias</h1>";
echo '<form action="solicitud.php" method="post">';
echo '<p>Número de filas: ' . $num_rows . '</p>';
echo '<table border="1">';
echo '<tr><th>codigo</th><th>nombre</th><th>numero de plazas</th><th>plazo de inscripcion</th>';
echo '</tr>';
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row['codigo'] . '</td>';
    echo '<td>' . $row['nombre'] . '</td>';
    echo '<td>' . $row['numeroplazas'] . '</td>';
    echo '<td>' . $row['plazoinscripcion'] . '</td>';
    if ($es_user) {
        echo '<td><input type="checkbox" name="inscribir[]" value="' . $row['codigo'] . '"></td>';
    }
    echo '</tr>';
}
echo '</table>';
if ($es_user) {
    echo '<input type="submit" value="inscribirse">';
}
echo '</form>';
// Cerrar conexión
mysqli_close($conexion);
    exit();
?>