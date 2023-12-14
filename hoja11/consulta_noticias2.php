<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'web', 'web', 'inmobiliaria');
if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}

// Número de noticias por página
$noticiasPorPagina = 3;

// Obtener el número total de noticias
$queryTotal = "SELECT COUNT(*) AS total FROM noticias";
$resultTotal = $conexion->query($queryTotal);
$totalNoticias = $resultTotal->fetch_assoc()['total'];

// Calcular el número total de páginas
$totalPaginas = ceil($totalNoticias / $noticiasPorPagina);

// Obtener el número de página actual
$paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Calcular el inicio y fin de las noticias a mostrar en la página actual
$inicio = ($paginaActual - 1) * $noticiasPorPagina;
$fin = $inicio + $noticiasPorPagina;

// Consulta de noticias paginadas
$queryPaginada = "SELECT * FROM noticias LIMIT $inicio, $noticiasPorPagina";
$resultPaginada = $conexion->query($queryPaginada);

// Mostrar resultados en una tabla
echo '<h2>Noticias Paginadas</h2>';
echo '<table border="1">';
echo '<tr><th>ID</th><th>Título</th><th>Texto</th><th>Categoría</th><th>Fecha</th><th>Imagen</th></tr>';
while ($row = $resultPaginada->fetch_assoc()) {
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

// Mostrar enlaces de paginación
echo '<div>';
for ($i = 1; $i <= $totalPaginas; $i++) {
    echo '<a href="consulta_noticias2.php?pagina=' . $i . '">' . $i . '</a> ';
}
echo '</div>';

// Cerrar conexión
$conexion->close();
?>
