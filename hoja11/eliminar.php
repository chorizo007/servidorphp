<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>

<?php
session_start();
include('comprobar_user.php');
$conexion = mysqli_connect('localhost', 'web', 'web', 'inmobiliaria');
if (!$conexion) {
    die('Error de conexión: ' . mysqli_connect_error());
}
$noticias_a_eliminar = $_POST['eliminar'];
$noticias_a_eliminar = array_map('limpiarInput', $noticias_a_eliminar);
$ids = implode(',', $noticias_a_eliminar);
$query_eliminar = "DELETE FROM noticias WHERE ID IN ($ids)";
$resultado_eliminar = mysqli_query($conexion, $query_eliminar);
if ($resultado_eliminar) {
    echo 'Noticias eliminadas correctamente.';
} else {
    echo 'Error al eliminar noticias: ' . mysqli_error($conexion);
}
mysqli_close($conexion);
function limpiarInput($input) {
    global $conexion;
    return mysqli_real_escape_string($conexion, $input);
}
echo "<a href='consultar_noticia.php'>volver al inicio</a>";
?>
