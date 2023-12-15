<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $texto = $_POST["texto"];
    $categoria = $_POST["categoria"];
    $fecha = $_POST["fecha"];
    $imagen = null;

    if (isset($_FILES['ficheronoticia']) && $_FILES['ficheronoticia']['error'] === UPLOAD_ERR_OK) {
        $rutaAbsoluta = $_SERVER['DOCUMENT_ROOT'] . '/servidorphp/hoja11/noticiasfile/';
        $nombreFichero = $_FILES['ficheronoticia']['name'];
        $nombreCompleto = $rutaAbsoluta . $nombreFichero;

        if (move_uploaded_file($_FILES['ficheronoticia']['tmp_name'], $nombreCompleto)) {
            echo "Fichero subido con éxito a la ruta absoluta: $nombreCompleto";
            $imagen = $nombreFichero;
        } else {
            echo "No se pudo mover el fichero a la ruta absoluta.";
        }
    } else {
        echo "Error al subir el archivo.";
    }

    // Conexión a la base de datos utilizando funciones
    $conexion = mysqli_connect('localhost', 'web', 'web', 'inmobiliaria');
    if (!$conexion) {
        die('Error de conexión: ' . mysqli_connect_error());
    }

    $query = "INSERT INTO noticias (TITULO, TEXTO, CATEGORIA, FECHA, IMAGEN) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $titulo, $texto, $categoria, $fecha, $imagen);

    if (mysqli_stmt_execute($stmt)) {
        echo "Noticia insertada correctamente.";
    } else {
        echo "Error al insertar la noticia: " . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Noticia</title>
</head>
<body>

<h2>Insertar Noticia</h2>

<form action="insertar_noticias.php" method="post" enctype="multipart/form-data">
    <label for="titulo">Título:</label>
    <input type="text" name="titulo" required><br>

    <label for="texto">Texto:</label>
    <textarea name="texto" rows="4" required></textarea><br>

    <label for="fecha">Fecha:</label>
    <input type="date" name="fecha" required><br>
    <?php
        $conexion = mysqli_connect('localhost', 'web', 'web', 'inmobiliaria');
        if (!$conexion) {
            die('Error de conexión: ' . mysqli_connect_error());
        }
        $queryCategorias = "SELECT nombre FROM categorias";
        $resultCategorias = mysqli_query($conexion, $queryCategorias);
        echo '<select name="categoria">';
        while ($rowCategoria = mysqli_fetch_assoc($resultCategorias)) {
            $categoria = $rowCategoria['nombre'];
            echo '<option value="' . $categoria . '" ' . ($categoria === $categoriaSeleccionada ? 'selected' : '') . '>' . $categoria . '</option>';
        }
        echo '</select>';
    ?>
    <br>
    <label for="imagen">Imagen (opcional):</label>
    <input type="file" name="ficheronoticia">

    <input type="submit" value="Insertar Noticia">
</form>

</body>
</html>
