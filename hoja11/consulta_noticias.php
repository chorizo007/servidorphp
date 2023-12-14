<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'web', 'web', 'inmobiliaria');
if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}

// Consulta de noticias
$query = "SELECT * FROM noticias";
$result = $conexion->query($query);

// Obtener el número de filas
$num_rows = $result->num_rows;

// Mostrar resultados en una tabla
echo '<p>Número de filas: ' . $num_rows . '</p>';
// Mostrar resultados en una tabla
echo '<table border="1">';
echo '<tr><th>ID</th><th>Título</th><th>Texto</th><th>Categoría</th><th>Fecha</th><th>Imagen</th></tr>';
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['ID'] . '</td>';
    echo '<td>' . $row['TITULO'] . '</td>';
    echo '<td>' . $row['TEXTO'] . '</td>';
    echo '<td>' . $row['CATEGORIA'] . '</td>';
    echo '<td>' . $row['FECHA'] . '</td>';
    echo '<td>' . $row['IMAGEN'] . '</td>';
    echo '</tr>';
}
echo '</table>';

// Cerrar conexión
$conexion->close();
?>
