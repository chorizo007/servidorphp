<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php
$errores = "";
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
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $numeroplazas = $_POST['numeroplazas'];
    $plazoinscripcion = $_POST['plazoinscripcion'];
    $fecha_actual = date("Y-m-d");
    if($fecha_actual>$plazoinscripcion ){
        $errores = "la fecha tiene que ser posterior a hoy";
    }else{
        $query = "INSERT INTO cursos (nombre,abierto,numeroplazas,plazoinscripcion) VALUES (?,?,?,?)";
        $stmt = mysqli_prepare($conexion, $query);
        if($stmt){
            mysqli_stmt_bind_param($stmt, "ssss", $nombre,$estado,$numeroplazas,$plazoinscripcion);
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
    }
    
}
?>
<form action="abrirres.php" method="post">
    <label>nombre:</label>
    <input type="text" name="nombre" value='<?php echo $nombre?>' required><br>
    <br>
    <label>estado:</label>
    <select name="estado">
        <option value="1">abierto</option>
        <option value="0">cerrado</option>
    </select>
    <br>
    <br>
    <label>numeroplazas:</label>
    <input type="number" name="numeroplazas" min="1" max="100" required value='<?php echo $nombre?>'>
    <br>
    <br>
    <label>Fecha de inscripcion:</label>
    <input type="date" name="plazoinscripcion" required><br>
    <br>
    <input type="submit" name="añadircurso" value="añadircurso">
    <?php
        echo $errores ; 
    ?>
</form>