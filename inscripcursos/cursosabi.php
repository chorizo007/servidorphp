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

$query = "SELECT * FROM cursos where abierto = true";
$result = mysqli_query($conexion, $query);

$num_rows = mysqli_num_rows($result);
echo "<h1>Cursos abiertos</h1>";
echo '<form action="solicitud.php" method="post">';
echo '<p>Número de cursos abiertos actualmente: ' . $num_rows . '</p>';
echo '<table border="1">';
echo '<tr><th>codigo</th><th>nombre</th><th>numero de plazas</th><th>plazo de inscripcion</th>';
echo '</tr>';
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row['codigo'] . '</td>';
    echo '<td>' . $row['nombre'] . '</td>';
    echo '<td>' . $row['numeroplazas'] . '</td>';
    echo '<td>' . $row['plazoinscripcion'] . '</td>';
    if ($es_user && !isset($_SESSION['admin']) ) {
        echo '<td><input type="checkbox" name="inscribir[]" value="' . $row['codigo'] . '"></td>';
    }
    echo '</tr>';
}
echo '</table>';
if ($es_user && !isset($_SESSION['admin']) ) {
    echo '<input type="submit" value="inscribirse">';
}
echo '</form>';
if ($es_user && !isset($_SESSION['admin']) ) {
    echo '<button><a href="vercursos.php">mis colicitudes</a></button></td>';
}

mysqli_close($conexion);
    exit();

?>