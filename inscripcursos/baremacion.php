<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>


<?php
include("estilos.php");
include("comprobar_user.php");
if (isset($_SESSION['admin'])) {
    $botonadmin = "<button><a href='admin.php'>ADMINISTRAR</a></button>";
}else{
    header('Location: cursosabi.php');
}

$conexion = mysqli_connect('localhost', 'cursos', 'cursos', 'cursoscp');
    
if (!$conexion) {
    die('Error de conexión: ' . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $curso = $_POST['bar'];
    $query_comprobar = "SELECT dni, codigocurso, fechasolicitud, admitido
    FROM (
        SELECT s.dni, s.codigocurso, s.fechasolicitud, s.admitido,
               ROW_NUMBER() OVER (ORDER BY MAX(s.admitido) ASC, st.puntos DESC) as row_num
        FROM solicitudes s
        INNER JOIN cursos c ON s.codigocurso = c.codigo
        INNER JOIN solicitantes st ON s.dni = st.dni
        WHERE s.codigocurso = '$curso'
          AND st.situacion = 'activo'
        GROUP BY s.dni
    ) AS subquery
    WHERE row_num <= (SELECT numeroplazas FROM cursos WHERE codigo = '$curso');
    
    ";
    $result = mysqli_query($conexion, $query_comprobar);
    echo $query_comprobar;
    echo '<table border="1">';
    echo '<tr><th>dni</th><th>codigocurso</th><th>fechasolicitud</th><th>admitido</th>';
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
}else{
    $query = "SELECT * FROM cursos where abierto = false";
    $result = mysqli_query($conexion, $query);
    // Obtener el número de filas
    $num_rows = mysqli_num_rows($result);
    echo "<h1>listado de profesores admitidos</h1>";
    echo '<form action="baremacion.php" method="post">';
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
        echo '<td><button type="submid" name="bar" value="' . $row['codigo'] . '">listado</button></td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '</form>';
    exit();

}
mysqli_close($conexion);
?>