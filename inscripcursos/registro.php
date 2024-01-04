<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>

<?php
session_start();

if (isset($_SESSION['nombre_usuario'])) {
    header("Location: inicio.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = mysqli_connect('localhost', 'cursos', 'cursos', 'cursoscp');
    
    if (!$conexion) {
        die('Error de conexión: ' . mysqli_connect_error());
    }

    $dni = $_POST['dni'];
    $apellidos = $_POST['apellidos'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $codigocentro = $_POST['codigocentro'];
    $coordinadortic = isset($_POST['coordinadortic']) ? 1 : 0;
    $grupotic = isset($_POST['grupotic']) ? 1 : 0;
    $nombregrupo = $_POST['nombregrupo'];
    $pbilin = isset($_POST['pbilin']) ? 1 : 0;
    $cargo = isset($_POST['cargo']) ? 1 : 0;
    $nombrecargo = $_POST['nombrecargo'];
    $situacion = $_POST['situacion'];
    $fechaalta = $_POST['fechaalta'];
    $especialidad = $_POST['especialidad'];
    $puntos = 2; //aqui tengo que calcular los puntos

    $query_comprobar = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario'";
    $result_comp = mysqli_query($conexion, $query_comprobar);
    if (mysqli_num_rows($result_comp) == 0) {
        $query = "INSERT INTO solicitantes (dni, apellidos, nombre, telefono, correo, codigocentro, coordinadortic, grupotic, nombregrupo, pbilin, cargo, nombrecargo, situacion, fechaalta, especialidad, puntos) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssssiiississsi", $dni, $apellidos, $nombre, $telefono, $correo, $codigocentro, $coordinadortic, $grupotic, $nombregrupo, $pbilin, $cargo, $nombrecargo, $situacion, $fechaalta, $especialidad, $puntos);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['nombre_usuario'] = $dni;
                header("Location: inicio.php");
                exit();
            } else {
                echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error al preparar la consulta: " . mysqli_error($conexion);
        }
    } else {
        echo "Ya existe un usuario con este nombre. Por favor, elige otro nombre de usuario.";
    }

    mysqli_close($conexion);
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
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" required maxlength="9"><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required maxlength="40"><br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required maxlength="20"><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" maxlength="12"><br>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required maxlength="50"><br>

        <label for="codigocentro">Código Centro:</label>
        <input type="text" id="codigocentro" name="codigocentro" maxlength="8"><br>

        <label for="coordinadortic">Coordinador TIC:</label>
        <input type="checkbox" id="coordinadortic" name="coordinadortic"><br>

        <label for="grupotic">Grupo TIC:</label>
        <input type="checkbox" id="grupotic" name="grupotic"><br>

        <label for="nombregrupo">Nombre Grupo:</label>
        <input type="text" id="nombregrupo" name="nombregrupo" maxlength="5"><br>

        <label for="pbilin">Programa bilingüe:</label>
        <input type="checkbox" id="pbilin" name="pbilin"><br>

        <label for="cargo">Cargo:</label>
        <input type="checkbox" id="cargo" name="cargo"><br>

        <label for="nombrecargo">Nombre Cargo:</label>
        <input type="text" id="nombrecargo" name="nombrecargo" maxlength="15"><br>

        <label for="situacion">Situación:</label>
        <select id="situacion" name="situacion">
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
        </select><br>

        <label for="fechaalta">Fecha Alta:</label>
        <input type="date" id="fechaalta" name="fechaalta"><br>

        <label for="especialidad">Especialidad:</label>
        <input type="text" id="especialidad" name="especialidad" maxlength="50"><br>

        <input type="submit" value="Enviar">
    </form>

<br>
<br>
<a href="login.php">¿Ya tienes cuenta? Inicia sesión aquí.</a>

</body>
</html>
