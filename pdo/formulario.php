<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correo Express</title>
    <link rel="stylesheet" type="text/css" href="formulario.css">
</head>
<body>
    <h1>CORREOS EXPRES</h1>
    <hr>
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
        <label for="body">Body del correo</label>
        <input type="text" name="body"><br>
        <br>
        <label for="cabecera">Cabecera del correo</label>
        <input type="text" name="cabecera" ><br>
        <br>
        <?php
            echo $_GET['error'];
        ?>
        <input type="submit" name="enviar" value="Enviar">
    </form>
</body>
</html>
