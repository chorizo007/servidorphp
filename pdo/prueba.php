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
