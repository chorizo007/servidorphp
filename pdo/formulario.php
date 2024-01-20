<?php
$servername = "127.0.0.1";
$username = "cursos";
$password = "cursos";
$dbname = "cursoscp";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ejemplo de consulta SELECT
    $query = "SELECT * FROM cursos";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Obtener resultados
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar resultados
    echo "<pre>";
    print_r($result);
    echo "</pre>";

    


} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cerrar conexión
$conn = null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="abrirres.php" method="post">
        <label>nombre:</label>
        <input type="text" name="nombre" value='<?php echo $nombre?>' required><br>
        <br>
        <label>estado:</label>
        <select name="estado">
            <option value="1">abierto</option>
            <option value="0">cerrado</option>
        </select>
        <br>
        <br>
        <label>numeroplazas:</label>
        <input type="number" name="numeroplazas" min="1" max="100" required value='<?php echo $nombre?>'>
        <br>
        <br>
        <label>Fecha de inscripcion:</label>
        <input type="date" name="plazoinscripcion" required><br>
        <br>
        <input type="submit" name="añadircurso" value="añadircurso">
        <?php
            echo $errores ; 
        ?>
    </form>
</body>
</html>