<?php
// Iniciar sesión
session_start();

// Verificar si el usuario ha iniciado sesión y obtener su nombre de usuario
if(isset($_SESSION['nombre_usuario'])) {
    $usuario_actual = $_SESSION['nombre_usuario'];

    // Conexión a la base de datos
    $conexion = mysqli_connect('localhost', 'web', 'web', 'inmobiliaria');
    if (!$conexion) {
        die('Error de conexión: ' . mysqli_connect_error());
    }

    // Verificar si el usuario es administrador
    $query_admin = "SELECT es_admin FROM usuarios WHERE nombre_usuario = '$usuario_actual'";
    $result_admin = mysqli_query($conexion, $query_admin);

    $es_admin = false;

    if ($result_admin && mysqli_num_rows($result_admin) > 0) {
        $row_admin = mysqli_fetch_assoc($result_admin);
        $es_admin = $row_admin['es_admin'];
    }

    // Consulta de noticias
    $query = "SELECT * FROM noticias";
    $result = mysqli_query($conexion, $query);

    // Obtener el número de filas
    $num_rows = mysqli_num_rows($result);

    // Mostrar resultados en una tabla con checkbox para eliminar (solo para administradores)
    echo '<form action="eliminar.php" method="post">'; // Ajusta "eliminar.php" según tu necesidad
    echo '<p>Número de filas: ' . $num_rows . '</p>';
    echo '<table border="1">';
    echo '<tr><th>ID</th><th>Título</th><th>Texto</th><th>Categoría</th><th>Fecha</th><th>Imagen</th>';
    if ($es_admin) {
        echo '<th>Eliminar</th>';
    }
    echo '</tr>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['ID'] . '</td>';
        echo '<td>' . $row['TITULO'] . '</td>';
        echo '<td>' . $row['TEXTO'] . '</td>';
        echo '<td>' . $row['CATEGORIA'] . '</td>';
        echo '<td>' . $row['FECHA'] . '</td>';
        echo '<td> <img src='.$_SERVER['DOCUMENT_ROOT'].'/servidorphp/hoja11/noticiasfile/'.$row['IMAGEN'].'/></td>';

        if ($es_admin) {
            echo '<td><input type="checkbox" name="eliminar[]" value="' . $row['ID'] . '"></td>';
        }

        echo '</tr>';
    }

    echo '</table>';

    // Mostrar el botón de borrar solo si es administrador
    if ($es_admin) {
        echo '<input type="submit" value="Borrar Seleccionados">';
    }

    echo '</form>';

    // Cerrar conexión
    mysqli_close($conexion);
} else {
    // Redirigir al usuario si no ha iniciado sesión
    header("Location: login.php");
    exit();
}
?>

<a href="logout.php">Cerrar Sesión</a>
