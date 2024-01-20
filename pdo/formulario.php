
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="categoria.php" method="post">
        <?php
            $directorio = './categorias';
            $contenidoDirectorio = scandir($directorio);
            $carpetas = array_filter($contenidoDirectorio, function ($elemento) use ($directorio) {
                return is_dir($directorio . '/' . $elemento) && $elemento != '.' && $elemento != '..';
            });

            // Generar el elemento select
            echo '<select name="categorias">';
            foreach ($carpetas as $carpeta) {
                echo '<option value="' . $carpeta . '">' . $carpeta . '</option>';
            }
            echo '</select>';
        ?>
        <br>
        <br>
        <label>body del correo</label>
        <input type="text" name="body"required><br>
        <br>
        <label>cabecera del correo</label>
        <input type="text" name="cabecera"required><br>
        <br>
        <input type="submit" name="enviar" value="enviar">
    </form>
</body>
</html>