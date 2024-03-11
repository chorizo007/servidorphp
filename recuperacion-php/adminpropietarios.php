<?php
require('nav.php');
require('constantes.php');
require('funciones.php');
if (isset($_SESSION['propietario'])) {
    $dni = $_SESSION['propietario'];
} else {
    header("Location: nav.php");
}

try {
    $query = "SELECT * FROM reservas where plazaID IN (SELECT plazaID from plazaparking where dni_propietario = :dni) and aceptada = 0";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
    $stmt->execute();
    $num_rows = $stmt->rowCount();
    echo "<h1>ADMIN TABLA RESERVAS</h1>";
    echo '<form action="compobaradmin.php" method="post">';
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
        echo '<td><button type="submit" name="aceptar" value="' . $row['reservaID'] . '">aceptar</button></td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '</form>';
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


?>

<form action="compobaradmin.php" method="post">
    <br>
    <label>pais:</label>
    <input type="text" name="pais"required><br>
    <br>
    <label>ciudad:</label>
    <input type="text" name="ciudad" required><br>
    <br>    
    <label>cp:</label>
    <input type="number" name="cp" min="1">
    <br>
    <br>
    <label>direccion:</label>
    <input type="text" name="direccion" min="1" >
    <br>
    <br>
    <label>latitud:</label>
    <input type="text" name="latitud" >
    <br>
    <br>
    <label>longitud:</label>
    <input type="text" name="longitud" >
    <br>
    <br>
    <label>tipo alquiler:</label>
    <select name ='tipo_alquiler'>
        <option value="Fijo">Fijo</option>
        <option value="Subasta">Subasta</option>
    </select>
    <br>
    <br>
    <br>    
    <label>precio minimo:</label>
    <input type="number" name="precio" min="1">
    <br>

    <input type="submit" name="parking " value="parking">
</form>