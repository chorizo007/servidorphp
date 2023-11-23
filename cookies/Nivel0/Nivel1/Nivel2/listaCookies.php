<?php
$cookies = $_COOKIE;
$directorio = dirname($_SERVER['SCRIPT_NAME']); // Obtiene el directorio actual del script

echo "<h2>Cookies en el directorio: $directorio</h2>";
echo "<table border='1'>
        <tr>
            <th>Nombre</th>
            <th>Contenido</th>
        </tr>";

foreach ($cookies as $nombre => $contenido) {
    // Filtra las cookies que pertenecen al mismo directorio
    if (strpos($_SERVER['REQUEST_URI'], $directorio) !== false) {
        echo "<tr>
                <td>$nombre</td>
                <td>$contenido</td>
            </tr>";
    }
}

echo "</table>";

echo "<br><a href='../index.html'>Volver al formulario</a>";
echo "<br><a href='creaCookieNivel.php'>Crear cookie en este nivel</a>";
?>
