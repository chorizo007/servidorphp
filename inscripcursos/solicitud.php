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
$arraycursos = $_POST['inscribir'];
$busquedadecursos = implode("', '", $arraycursos);
$fechaActual = new DateTime();
$fechaHoy = $fechaActual->format('Y-m-d');
$query = "SELECT * FROM solicitudes WHERE dni = '$es_user' AND codigocurso IN ('$busquedadecursos')";
$result = mysqli_query($conexion, $query);
if ($result && mysqli_num_rows($result) == 0) {
    foreach($arraycursos as $curso){
        $query = "INSERT INTO solicitudes (dni,codigocurso,fechasolicitud,admitido) VALUES (?,?,?,0)";
        $stmt = mysqli_prepare($conexion, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $es_user,$curso,$fechaHoy);
            if (mysqli_stmt_execute($stmt)) {
            } else {
                echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
            }
        }
    }
    echo "realizado con exito";
} else {
    echo "ya has solicitado en estos cursos";
}
mysqli_close($conexion);
    exit();
?>