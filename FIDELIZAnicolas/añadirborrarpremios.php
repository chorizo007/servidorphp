<?php
$fechaini = "";
$fechafin = "";
$descripcion = "";

session_start();

if (isset($_SESSION['admin'])) {

} else {
    header("Location: ../pricipal.php");
}

$servername = "127.0.0.1";
$username = "fideliza";
$password = "fideliza";
$dbname = "FIDELIZA";


$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!empty($_POST['borrar'])) {
    $codigo = $_POST['borrar'];
    $query = "DELETE FROM premios WHERE premioid = :codigo";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
    $stmt->execute();
    header("Location: adminpremios.php");
} else if (!empty($_POST['añadirpremio'])) {
    $fechaini = $_POST['fechaini'];
    $fechafin = $_POST['fechafin'];
    $descripcion = $_POST['descripcion'];

    if (empty($fechaini) || empty($fechafin) || empty($descripcion)) {
        //validar si la fecha esta bien
        $errores = "Rellene todo el formulario";
    } else {
        $query = "INSERT INTO premios (ddescrip,fechai_validez, fechaf_validez) VALUES (:descripcion, :inicio, :fin)";
        $stmt = $conn->prepare($query);

        // Vincular parámetros
        $stmt->bindParam(':inicio', $fechaini, PDO::PARAM_STR);
        $stmt->bindParam(':peso', $peso, PDO::PARAM_STR);
        $stmt->bindValue(':fin', $fin, PDO::PARAM_STR);
        $stmt->execute();
        header("Location: adminpremios.php");
    }
}
?>
<form action="añadirborrarpremios.php" method="post">

    <label>descripcion:</label>
    <input type="text" name="descripcion" value='<?php echo $descripcion ?>' required><br>
    <br>
    <br>
    <label>fecha valizez:</label>
    <input type="date" name="fechaini">
    <br>
    <label>fecha de fin:</label>
    <input type="date" name="fechafin">
    <br>
    <input type="submit" name="añadirpremio" value="añadirpremio">
    <?php
    echo $errores;
    ?>
</form>
