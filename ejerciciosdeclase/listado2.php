<!DOCTYPE html>
<html>
<head>
    <title>Listado de Directorio</title>
</head>
<body>
<h1>Listado de Directorio</h1>
<ul>
    <?php
    $directorio = './'; // Directorio actual (puedes cambiarlo)
    $archivos = scandir($directorio);

    foreach ($archivos as $archivo) {
        if ($archivo != '.' && $archivo != '..') {
            $ruta = $directorio . $archivo;
            $es_directorio = is_dir($ruta);
            $fecha_modificacion = date("d/m/Y H:i:s", filemtime($ruta));

            echo "<li>";
            echo "<strong>$archivo</strong> - Última modificación: $fecha_modificacion";
            if (!$es_directorio) {
                $tamaño = filesize($ruta);
                echo " - Tamaño: $tamaño bytes";
            }
            echo "</li>";
        }
    }
    ?>
</ul>
</body>
</html>