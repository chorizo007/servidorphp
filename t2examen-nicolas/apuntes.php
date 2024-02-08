<?php

setcookie($nombre, $contenido, 0, '/cookies/');

$cookies = $_COOKIE;

echo "<h2>Cookies en el nivel: todos</h2>";
echo "<table border='1'>
        <tr>
            <th>Nombre</th>
            <th>Contenido</th>
        </tr>";

foreach ($cookies as $nombre => $contenido) {
    echo "<tr>
            <td>$nombre</td>
            <td>$contenido</td>
        </tr>";
}

echo "</table>";


//hacer barrido de carpetas y de archivos 

$contenidoDirectorio = scandir($directorio);
$carpetas = array_filter($contenidoDirectorio, function ($elemento) use ($directorio) {
    return $elemento != '.' && $elemento != '..';
});

foreach ($carpetas as $carpeta) {
    echo "<img src='" . $directorio . "/" . $carpeta . "' width='100'>";
    echo "<input type='radio' name ='foto' value=" . $directorio . "/" . $carpeta . ">";
}
