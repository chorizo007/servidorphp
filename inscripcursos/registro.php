<?php
session_start();
if (isset($_SESSION['nombre_usuario'])) {
    header("Location: cursosabi.php");
    exit();
}
$mensaje ="";
$corregir = false;

$dni = "";
$password = "";
$apellidos = "";
$nombre = "";
$telefono = "";
$correo = "";
$codigocentro = "";
$coordinadortic = "";
$grupotic = "";
$nombregrupo = "";
$pbilin = "";
$cargo = "";
$nombrecargo = "";
$situacion = "";
$fechaalta = "";
$especialidad = "";
$puntos = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = mysqli_connect('localhost', 'cursos', 'cursos', 'cursoscp');
    
    if (!$conexion) {
        die('Error de conexión: ' . mysqli_connect_error());
    }

    $dni = $_POST['dni'];
    $password = $_POST['password'];
    $apellidos = $_POST['apellidos'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $codigocentro = $_POST['codigocentro'];
    $coordinadortic = isset($_POST['coordinadortic']); //4
    $grupotic = isset($_POST['grupotic']); //3
    $nombregrupo = $_POST['nombregrupo']; 
    $pbilin = isset($_POST['pbilin']); //3
    $cargo = isset($_POST['cargo']); //2
    $nombrecargo = $_POST['nombrecargo']; //jefe de estudios 2 secretario 2 jefe de departamento
    $situacion = $_POST['situacion']; //activo 1
    $fechaalta = $_POST['fechaalta']; // 15 años 1 
    $especialidad = $_POST['especialidad'];
    $puntos = 0;

    $mensaje = "errores: ";

    $fecha_actual = date("Y-m-d");

    $años_transcurridos = $diferencia->y;
    $dias_transcurritos = $diferencia->days;
    if (preg_match('/^[0-9]{8}[A-Za-z]$/', $dni)) {
        if($fechaalta<$fecha_actual){
        }else{
            $corregir = true;
            $mensaje .= "fecha incorrecta";
        }
    } else {
        $corregir = true;
        $mensaje .= "esta mal el dni";
    }


    if(!$corregir){

        $comparacion = array(
            $coordinadortic,
            $grupotic,
            $pbilin,
            $nombrecargo,
            $nombrecargo,
            $nombrecargo,
            $nombrecargo,
            $situacion
        );
        $aux = 0;
        if ($file = fopen('puntos.txt', 'r+')) {
            $linea = fgets($file);
            $array_linea = explode(" ", $linea);
            if($array_linea[0]<$años_transcurridos){
                $puntos +=$array_linea[1];
            }
            while (!feof($file)) {
                $linea = fgets($file);
                $array_linea = explode(" ", $linea);
                $palabra = trim($array_linea[0]);
                if ($palabra == $comparacion[$aux]) {
                    $puntos += $array_linea[1];
                }
                $aux++;
            }
            fclose($file);
        } else {
            die("No se pudo acceder al archivo de puntos");
        }
    
    
        $query_comprobar = "SELECT * FROM solicitantes WHERE dni = '$dni'";
        $result_comp = mysqli_query($conexion, $query_comprobar);
        if (mysqli_num_rows($result_comp) == 0) {
            $query = "INSERT INTO solicitantes (dni, contrasena, apellidos, nombre, telefono, correo, codigocentro, coordinadortic, grupotic, nombregrupo, pbilin, cargo, nombrecargo, situacion, fechaalta, especialidad, puntos) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conexion, $query);
    
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssssssiisiissssi", $dni, $password, $apellidos, $nombre, $telefono, $correo, $codigocentro, $coordinadortic, $grupotic, $nombregrupo, $pbilin, $cargo, $nombrecargo, $situacion, $fechaalta, $especialidad, $puntos);
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['nombre_usuario'] = $dni;
                    header("Location: cursosabi.php");
                } else {
                    echo "Error al ejecutar la sentencia preparada: " . mysqli_error($conexion);
                }
                
    
                mysqli_stmt_close($stmt);
            } else {
                echo "Error al preparar la consulta: " . mysqli_error($conexion);
            }
        } else {
            $mensaje = "Ya existe esta cuenta con ese DNI";
        }    
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
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h2 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            margin-top: 10px;
            color: #3498db;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h2>Formulario de Solicitantes</h2>
    <?php
        echo $mensaje;
    ?>
    <form action="registro.php" method="post">
        <label for="dni">DNI:</label>
        <input type="text" value="<?php echo $dni?>" name="dni" required maxlength="9"><br>

        <label>Contraseña:</label>
        <input type="text" value="<?php echo $password?>" name="password" required><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" value="<?php echo $apellidos?>" name="apellidos">

        <br>

        <label for="nombre">Nombre:</label>
        <input type="text" value="<?php echo $nombre?>" name="nombre" required>

        <br>

        <label for="telefono">Teléfono:</label>
        <input type="tel" value="<?php echo $telefono?>" name="telefono">

        <br>

        <label for="correo">Correo:</label>
        <input type="email" value="<?php echo $correo?>" name="correo">

        <br>

        <label for="codigocentro">Código Centro:</label>
        <input type="text" value="<?php echo $codigocentro?>" name="codigocentro">

        <br>

        <label for="coordinadortic">Coordinador TIC:</label>
        <input type="checkbox" value="<?php echo $coordinadortic?>" name="coordinadortic">

        <br>

        <label for="grupotic">Grupo TIC:</label>
        <input type="checkbox" value="<?php echo $grupotic?>" name="grupotic">

        <br>

        <label for="nombregrupo">Nombre Grupo:</label>
        <input type="text" value="<?php echo $nombregrupo?>" name="nombregrupo" maxlength="5">

        <br>

        <label for="pbilin">Programa Bilingüe:</label>
        <input type="checkbox" value="<?php echo $pbilin?>" name="pbilin">

        <br>

        <label for="cargo">Cargo:</label>
        <input type="checkbox" value="<?php echo $cargo?>" name="cargo">

        <br>
        <label for="nombrecargo">Nombre Cargo:</label>
        <select name="nombrecargo">
            <option value="director">director</option>
            <option value="JefeEstudios">JefeEstudios</option>
            <option value="Secretario">Secretario</option>
            <option value="Jefede">JefedeDepartamento</option>

        </select>

        <br>

        <label for="situacion">Situación:</label>
        <select id="situacion" name="situacion">
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
        </select>

        <br>

        <label for="fechaalta">Fecha Alta:</label>
        <input type="date" name="fechaalta">

        <br>

        <label for="especialidad">Especialidad:</label>
        <input type="text" value="<?php echo $especialidad?>" name="especialidad">

        <br>

        <input type="submit" value="Enviar">
    </form>
    
    <br>
    <br>
    <a href="login.php">¿Ya tienes cuenta? Inicia sesión aquí.</a>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

</body>
</html>
