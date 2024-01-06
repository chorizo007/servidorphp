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
if(!empty($_POST['cerrar'])){
    $codigo = $_POST['cerrar'];
    $query = "UPDATE cursos set abierto = false where codigo = ?";
    $stmt = mysqli_prepare($conexion, $query);
    if($stmt){
        mysqli_stmt_bind_param($stmt, "s", $codigo);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: abrircuros.php");
            exit();
        }else{
            echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
        }
        mysqli_stmt_close($stmt);
    }else{
        echo "Error al preparar la consulta: " . mysqli_error($conexion);
    }
}else if(!empty($_POST['abrir'])){
    $codigo = $_POST['abrir'];
    $query = "UPDATE cursos set abierto = true where codigo = ?";
    $stmt = mysqli_prepare($conexion, $query);
    if($stmt){
        mysqli_stmt_bind_param($stmt, "s", $codigo);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: abrircuros.php");
            exit();
        }else{
            echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
        }
        mysqli_stmt_close($stmt);
    }else{
        echo "Error al preparar la consulta: " . mysqli_error($conexion);
    }
}else if(!empty($_POST['borrar'])){
    $codigo = $_POST['borrar'];
    $query = "DELETE FROM cursos where codigo = ?";
    $stmt = mysqli_prepare($conexion, $query);
    if($stmt){
        mysqli_stmt_bind_param($stmt, "s", $codigo);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: abrircuros.php");
            exit();
        }else{
            echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
        }
        mysqli_stmt_close($stmt);
    }else{
        echo "Error al preparar la consulta: " . mysqli_error($conexion);
    }
}else if(!empty($_POST['añadircurso'])){
    
}
?>
<form action="abrirres.php" method="post">
    <label>nombre:</label>
    <input type="text" name="titulo" required><br>
    <br>
    <label>estado:</label>
    <select name="estado">
        <option value="abierto">abierto</option>
        <option value="cerrado">cerrado</option>
    </select>
    <br>
    <br>
    <label>nombre:</label>
    <input type="text" name="titulo" required><br>
    <br>
    <label>numeroplazas:</label>
    <input type="number" name="numeroplazas" min="1" max="100" required>
    <br>
    <br>
    <label>Fecha de inscripcion:</label>
    <input type="date" name="plazoinscripcion" required><br>
    <br>
    <input type="submit" value="Insertar Noticia">
</form>