<?php
session_start();
include('comprobar_user.php');
$conexion = mysqli_connect('localhost', 'web', 'web', 'inmobiliaria');
if (!$conexion) {
    die('Error de conexión: ' . mysqli_connect_error());
}
$query_admin = "SELECT es_admin FROM usuarios WHERE nombre_usuario = '$usuario_actual'";
$result_admin = mysqli_query($conexion, $query_admin);
if ($result_admin && mysqli_num_rows($result_admin) > 0) {
    $row_admin = mysqli_fetch_assoc($result_admin);
    $es_admin = $row_admin['es_admin'];
    if ($es_admin) {
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
    } else {
        echo 'No tienes permisos para realizar esta acción.';
    }
}
mysqli_close($conexion);
function limpiarInput($input) {
    global $conexion;
    return mysqli_real_escape_string($conexion, $input);
}
?>
