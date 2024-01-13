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
    echo "<h1>Baremación del curso</h1>";
    echo '<table border="1">';
    echo '<tr><th>dni</th><th>codigocurso</th><th>fechasolicitud</th><th>admitido</th>';
    echo '</tr>';
    $curso = $_POST['bar'];

    $query_comprobarsitermino = "SELECT dni FROM solicitudes where codigocurso like '$curso' and admitido = true";
    $array_comprobar = mysqli_query($conexion, $query_comprobarsitermino);

    $comprobar_terminado = mysqli_num_rows($array_comprobar);

    if($comprobar_terminado==0){
        $query_comprobar = "SELECT s.dni, s.codigocurso, s.fechasolicitud, s.admitido
        FROM solicitudes s
        INNER JOIN solicitantes st ON s.dni = st.dni
        WHERE s.codigocurso like '$curso'
        and s.dni in (select dni from solicitudes where admitido = false)
        and s.dni not in (select dni from solicitudes where admitido = true)
        ORDER BY st.puntos DESC
        ";
        $resultado_adminitidos = mysqli_query($conexion, $query_comprobar);

        $query_plazas = "SELECT numeroplazas FROM cursos where codigo like '$curso'";
        $numero_de_plazas_consulta = mysqli_query($conexion, $query_plazas);

        $array_numero_de_plazas = mysqli_fetch_assoc($numero_de_plazas_consulta); 
        $numero_de_plazas = $array_numero_de_plazas['numeroplazas'];
        echo '</tr>';
        while ($row = mysqli_fetch_assoc($resultado_adminitidos) and $numero_de_plazas>0) {
            echo '<tr>';
            echo '<td>' . $row['dni'] . '</td>';
            echo '<td>' . $row['codigocurso'] . '</td>';
            echo '<td>' . $row['fechasolicitud'] . '</td>';
            echo '<td>1</td>';
            echo '</tr>';
            $numero_de_plazas--;
            $query = "UPDATE solicitudes set admitido = true where dni = ?";
            $stmt = mysqli_prepare($conexion, $query);
            if($stmt){
                mysqli_stmt_bind_param($stmt, "s", $row['dni']);
                if (mysqli_stmt_execute($stmt)) {
                }else{
                    echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
                }
                mysqli_stmt_close($stmt);
            }else{
                echo "Error al preparar la consulta: " . mysqli_error($conexion);
            }
        }
        if($numero_de_plazas>0){
            
            $query_adminitodos_una_vez= "SELECT s.dni, s.codigocurso, s.fechasolicitud, s.admitido, COUNT(*) AS total_admitido
            FROM solicitudes s
            INNER JOIN solicitantes st ON s.dni = st.dni
            WHERE s.codigocurso = 1
            GROUP BY st.dni
            ORDER BY total_admitido DESC, st.puntos DESC;
            ";
            $resultado_adminitidos_una_vez = mysqli_query($conexion, $query_adminitodos_una_vez);
            while ($row = mysqli_fetch_assoc($resultado_adminitidos_una_vez) and $numero_de_plazas>0) {
                echo '<tr>';
                echo '<td>' . $row['dni'] . '</td>';
                echo '<td>' . $row['codigocurso'] . '</td>';
                echo '<td>' . $row['fechasolicitud'] . '</td>';
                echo '<td>1</td>';
                echo '</tr>';
                $numero_de_plazas--;
                $query = "UPDATE solicitudes set admitido = true where dni = ?";
                $stmt = mysqli_prepare($conexion, $query);
                if($stmt){
                    mysqli_stmt_bind_param($stmt, "s", $row['dni']);
                    if (mysqli_stmt_execute($stmt)) {
                    }else{
                        echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
                    }
                    mysqli_stmt_close($stmt);
                }else{
                    echo "Error al preparar la consulta: " . mysqli_error($conexion);
                }
            }
        }
        echo '</table>';
    }else{
        $query = "SELECT * FROM solicitudes where codigocurso = '$curso' and admitido = true";
        $result = mysqli_query($conexion, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['dni'] . 'd</td>';
            echo '<td>' . $row['codigocurso'] . '</td>';
            echo '<td>' . $row['fechasolicitud'] . '</td>';
            echo '<td>' . $row['admitido'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }


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
        echo '<td>' . $row['codigo'] . ' </td>';
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