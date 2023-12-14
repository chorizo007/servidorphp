<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'web', 'web', 'inmobiliaria');
if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}

// Obtener las categorías de las noticias
$queryCategorias = "SELECT DISTINCT CATEGORIA FROM noticias";
$resultCategorias = $conexion->query($queryCategorias);

// Consultar noticias según la categoría seleccionada
$categoriaSeleccionada = isset($_GET['categoria']) ? $_GET['categoria'] : 'Todas';
$queryNoticias = ($categoriaSeleccionada !== 'Todas') ? "SELECT * FROM noticias WHERE CATEGORIA = '$categoriaSeleccionada'" : "SELECT * FROM noticias";
$resultNoticias = $conexion->query($queryNoticias);

// Mostrar resultados en una tabla
echo '<h2>Consulta de Noticias por Categoría</h2>';

// Mostrar el desplegable de categorías
echo '<form action="consulta_noticias3.php" method="get">';
echo '<label for="categoria">Selecciona una categoría:</label>';
echo '<select name="categoria">';
echo '<option value="Todas">Todas</option>';
while ($rowCategoria = $resultCategorias->fetch_assoc()) {
    $categoria = $rowCategoria['CATEGORIA'];
    echo '<option value="' . $categoria . '" ' . ($categoria === $categoriaSeleccionada ? 'selected' : '') . '>' . $categoria . '</option>';
}
echo '</select>';
echo '<input type="submit" value="Filtrar">';
echo '</form>';

// Mostrar resultados en una tabla
echo '<table border="1">';
echo '<tr><th>ID</th><th>Título</th><th>Texto</th><th>Categoría</th><th>Fecha</th><th>Imagen</th></tr>';
while ($row = $resultNoticias->fetch_assoc()) {
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
