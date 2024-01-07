<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>

<?php
include("comprobar_user.php");
if (isset($_SESSION['admin'])) {
    $botonadmin = "<button><a href='admin.php'>ADMINISTRAR</a></button>";
}else{
    header('Location: cursosabi.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = mysqli_connect('localhost', 'cursos', 'cursos', 'cursoscp');
    
    if (!$conexion) {
        die('Error de conexión: ' . mysqli_connect_error());
    }


    $query_comprobar = "SELECT * FROM solicitantes WHERE dni = '$dni'";
    $result_comp = mysqli_query($conexion, $query_comprobar);
    if (mysqli_num_rows($result_comp) == 0) {
        $query = "INSERT INTO solicitantes (dni, apellidos, nombre, telefono, correo, codigocentro, coordinadortic, grupotic, nombregrupo, pbilin, cargo, nombrecargo, situacion, fechaalta, especialidad, puntos) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssssiisssssssi", $dni, $apellidos, $nombre, $telefono, $correo, $codigocentro, $coordinadortic, $grupotic, $nombregrupo, $pbilin, $cargo, $nombrecargo, $situacion, $fechaalta, $especialidad, $puntos);
            if (mysqli_stmt_execute($stmt)) {
                $query = "INSERT INTO usuarios (nombre_usuario,contrasena,es_admin) 
                VALUES (?,?,false)";
                $stmt = mysqli_prepare($conexion, $query);
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "ss", $dni,$password);
                    if (mysqli_stmt_execute($stmt)) {
                        $_SESSION['nombre_usuario'] = $dni;
                        header("Location: cursosabi.php");
                        exit();
                    } else {
                        echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    echo "Error al preparar la consulta: " . mysqli_error($conexion);
                }
                exit();
            } else {
                echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error al preparar la consulta: " . mysqli_error($conexion);
        }
    } else {
        echo "Ya existe esta cuenta con ese DNI";
    }

    mysqli_close($conexion);
}else{

}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Solicitantes</title>
</head>
<body>
    <h2>Formulario de Solicitantes</h2>
    <form action="registro.php" method="post">

        <label for="situacion">Situación:</label>
        <select id="situacion" name="situacion">
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
        </select>
        <br>
        <br>
        <label for="situacion">Situación:</label>
        <select id="situacion" name="situacion">
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
        </select>

        <input type="submit" value="Enviar">
    </form>
    <br>

</body>
</html>