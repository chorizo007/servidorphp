<?php
session_start();
include("estilos.php");
include("comprobar_user.php");
if(isset($_SESSION['nombre_usuario'])) {
    $es_user = $_SESSION['nombre_usuario'];
}
if (isset($_SESSION['admin'])) {
    $botonadmin = "<button><a href='admin.php'>ADMINISTRAR</a></button>";
}else{
    header('Location: cursosabi.php');
}
// Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'cursos', 'cursos', 'cursoscp');
if (!$conexion) {
    die('Error de conexión: ' . mysqli_connect_error());
}
// Consulta de noticias
$query = "SELECT * FROM cursos";
$result = mysqli_query($conexion, $query);
// Obtener el número de filas
$num_rows = mysqli_num_rows($result);
echo "<h1>Abrir y cerrar cursos</h1>";
echo '<form action="abrirres.php" method="post">';
echo '<p>Número de filas: ' . $num_rows . '</p>';
echo '<table border="1">';
echo '<tr><th>codigo</th><th>nombre</th><th>estado</th><th>numero de plazas</th><th>plazo de inscripcion</th>';
echo '</tr>';
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row['codigo'] . '</td>';
    echo '<td>' . $row['nombre'] . '</td>';
    echo '<td>' . $row['abierto'] . '</td>';
    echo '<td>' . $row['numeroplazas'] . '</td>';
    echo '<td>' . $row['plazoinscripcion'] . '</td>';
    if ($row['abierto']!=0) {
        echo '<td><button type="submid" name="cerrar" value="' . $row['codigo'] . '">cerrar</button></td>';
    }else{
        echo '<td><button type="submid" name="abrir" value="' . $row['codigo'] . '">abrir</button></td>';
    }
    echo '<td><button type="submid" name="borrar" value="' . $row['codigo'] . '">borrar</button></td>';
    echo '</tr>';
}
echo '</table>';
echo '<td><button name="añadir" value="añadir">añadir curso</button></td>';
echo '</form>';

// Cerrar conexión
mysqli_close($conexion);
    exit();
?>