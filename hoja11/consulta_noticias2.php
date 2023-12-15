<?php
// Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'web', 'web', 'inmobiliaria');
if (!$conexion) {
    die('Error de conexión: ' . mysqli_connect_error());
}

// Número de noticias por página
$noticiasPorPagina = 3;

// Obtener el número total de noticias
$queryTotal = "SELECT COUNT(*) AS total FROM noticias";
$resultTotal = mysqli_query($conexion, $queryTotal);
$totalNoticias = mysqli_fetch_assoc($resultTotal)['total'];

// Calcular el número total de páginas
$totalPaginas = ceil($totalNoticias / $noticiasPorPagina);

// Obtener el número de página actual
$paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Calcular el inicio y fin de las noticias a mostrar en la página actual
$inicio = ($paginaActual - 1) * $noticiasPorPagina;
$fin = $inicio + $noticiasPorPagina;

// Consulta de noticias paginadas
$queryPaginada = "SELECT * FROM noticias LIMIT $inicio, $noticiasPorPagina";
$resultPaginada = mysqli_query($conexion, $queryPaginada);

// Mostrar resultados en una tabla
echo '<h2>Noticias Paginadas</h2>';
echo '<table border="1">';
echo '<tr><th>ID</th><th>Título</th><th>Texto</th><th>Categoría</th><th>Fecha</th><th>Imagen</th></tr>';
while ($row = mysqli_fetch_assoc($resultPaginada)) {
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
mysqli_close($conexion);
?>
