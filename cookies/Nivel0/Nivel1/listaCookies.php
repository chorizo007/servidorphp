<?php
$cookies = $_COOKIE;

echo "<h2>Cookies en el nivel: 1</h2>";
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

echo "<br><a href='../../index.html'>Volver al formulario</a>";
echo "<br><a href='creaCookieNivel.php'>Crear cookie en este nivel</a>";
?>

