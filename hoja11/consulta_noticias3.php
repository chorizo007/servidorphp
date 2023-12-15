<?php
session_start();
include('comprobar_user.php');
$conexion = mysqli_connect('localhost', 'web', 'web', 'inmobiliaria');
if (!$conexion) {
    die('Error de conexión: ' . mysqli_connect_error());
}

$queryCategorias = "SELECT nombre FROM categorias";
$resultCategorias = mysqli_query($conexion, $queryCategorias);

$categoriaSeleccionada = isset($_GET['categoria']) ? $_GET['categoria'] : 'Todas';
$queryNoticias = ($categoriaSeleccionada !== 'Todas') ? "SELECT * FROM noticias WHERE CATEGORIA = '$categoriaSeleccionada'" : "SELECT * FROM noticias";
$resultNoticias = mysqli_query($conexion, $queryNoticias);

echo '<h2>Consulta de Noticias por Categoría</h2>';

echo '<form action="consulta_noticias3.php" method="get">';
echo '<label for="categoria">Selecciona una categoría:</label>';
echo '<select name="categoria">';
echo '<option value="Todas">Todas</option>';
while ($rowCategoria = mysqli_fetch_assoc($resultCategorias)) {
    $categoria = $rowCategoria['nombre'];
    echo '<option value="' . $categoria . '" ' . ($categoria === $categoriaSeleccionada ? 'selected' : '') . '>' . $categoria . '</option>';
}
echo '</select>';
echo '<input type="submit" value="Filtrar">';
echo '</form>';

$num_rows = mysqli_num_rows($resultNoticias);
if ($num_rows > 0) {
    // Mostrar resultados en una tabla
    echo '<table border="1">';
    echo '<tr><th>ID</th><th>Título</th><th>Texto</th><th>Categoría</th><th>Fecha</th><th>Imagen</th></tr>';
    while ($row = mysqli_fetch_assoc($resultNoticias)) {
        echo '<tr>';
        echo '<td>' . $row['ID'] . '</td>';
        echo '<td>' . $row['TITULO'] . '</td>';
        echo '<td>' . $row['TEXTO'] . '</td>';
        echo '<td>' . $row['CATEGORIA'] . '</td>';
        echo '<td>' . $row['FECHA'] . '</td>';
        echo '<td> <img src='.'http://localhost/github/servidorphp/hoja11/noticiasfile/'.$row['IMAGEN'].'></td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo "no hay resultados para esta categoria";
}

// Cerrar conexión
mysqli_close($conexion);
?>
