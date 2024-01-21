<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correo Express</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        hr {
            border: 1px solid #ccc;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        select,
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
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
        <input type="text" name="body" required><br>
        <br>
        <label for="cabecera">Cabecera del correo</label>
        <input type="text" name="cabecera" required><br>
        <br>
        <input type="submit" name="enviar" value="Enviar">
    </form>
</body>
</html>
