<?php
session_start();

if (isset($_SESSION['email'])) {
    $es_user = $_SESSION['email'];
}
if (isset($_SESSION['admin'])) {
} else {
    header("Location: login.php");
}

require('nav.php');
require('constantes.php');
require('funciones.php');

try {
    $query = "SELECT * FROM productos";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $num_rows = $stmt->rowCount();
    echo "<h1>ADMIN PRODUCTOS</h1>";
    echo '<form action="adminañadircampotabla.php" method="post">';
    echo '<p>Número de filas: ' . $num_rows . '</p>';
    echo '<table border="1">';
    
    // Obtener los nombres de las columnas
    $column_names = [];
    for ($i = 0; $i < $stmt->columnCount(); $i++) {
        $column_names[] = $stmt->getColumnMeta($i)['name'];
    }
    
    // Mostrar los nombres de las columnas
    echo '<tr>';
    foreach ($column_names as $column_name) {
        echo '<th>' . $column_name . '</th>';
    }
    echo '<th>Acciones</th>'; // Añadir columna para acciones
    echo '</tr>';

    // Mostrar los datos de las filas
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        foreach ($column_names as $column_name) {
            echo '<td>' . $row[$column_name] . '</td>';
        }
        echo '<td><button type="submit" name="borrar" value="' . $row['productoid'] . '">borrar</button></td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '<button name="añadir" value="añadir">añadir curso</button>';
    echo '</form>';
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}



exit();


?>