<!DOCTYPE html>
<html>
<head>
    <title>Listado de Archivos</title>
</head>
<body>
<h1>Listado de Archivos</h1>
<ul>
    <?php
    $directorio = './'; // Directorio actual (puedes cambiarlo)
    $archivos = scandir($directorio);

    foreach ($archivos as $archivo) {
        $ruta = $directorio . $archivo;
        if (is_file($ruta)) {
            $fecha_modificacion = date("d/m/Y H:i:s", filemtime($ruta));
            $tamaño = filesize($ruta);

            echo "<li>";
            echo "<strong>$archivo</strong> - Última modificación: $fecha_modificacion - Tamaño: $tamaño bytes";
            echo "</li>";
        }
    }
    ?>
</ul>
</body>
</html>