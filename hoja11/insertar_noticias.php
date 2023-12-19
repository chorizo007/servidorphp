<?php
    include('soloadmin.php');
    include('estilos.html');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Noticia</title>
</head>
<body>

<h1>Insertar una Noticia</h1>

<form action="resultado_insertar_noticias.php" method="post" enctype="multipart/form-data">
    <label for="titulo">Título:</label>
    <input type="text" name="titulo" required><br>

    <label for="texto">Texto:</label>
    <textarea name="texto" rows="4" required></textarea><br>

    <label for="fecha">Fecha:</label>
    <input type="date" name="fecha" required><br>
    <?php
        session_start();
        include('comprobar_user.php');
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
    <br>
    <input type="submit" value="Insertar Noticia">
</form>

</body>
</html>
