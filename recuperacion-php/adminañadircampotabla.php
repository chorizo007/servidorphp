<?php
$errores = "";
$nombre = "";
$descripcion = "";
$precio = "";
$peso = "";

if (!isset($_SESSION['admin'])) {

} else {
    header("Location: login.php");
}

require('nav.php');
require('constantes.php');
require('funciones.php');

$nombretabla = "productos";

if (!empty($_POST['borrar'])) {

    $codigo = $_POST['borrar'];
    $query = "DELETE FROM $nombretabla WHERE productoid = :productoid";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':productoid', $codigo, PDO::PARAM_STR);
    $stmt->execute();
    header("Location: añadirproductos.php");

} else if (!empty($_POST['añadirfila'])) {

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $peso = $_POST['peso'];

    if (empty($nombre) || empty($descripcion) || empty($precio) || empty($peso)) {
        $errores = "Rellene todo el formulario";
    } else {
        $query = "INSERT INTO $nombretabla (nombre, descripcion, peso, precio) VALUES (:nombre, :descripcion, :peso, :precio)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':peso', $peso, PDO::PARAM_STR);
        $stmt->bindValue(':precio', $precio, PDO::PARAM_STR);
        $stmt->execute();

        // Obtener el ID del producto recién insertado
        $idProducto = $conn->lastInsertId();

        if (isset($_FILES['jabonfoto']) && $_FILES['jabonfoto']['error'] === UPLOAD_ERR_OK) {
            $rutaAbsoluta = $_SERVER['DOCUMENT_ROOT'] . '/github/servidorphp/jabones/imagenes/';
            $nombreFichero = $idProducto . '.jpg'; 
            $nombreCompleto = $rutaAbsoluta . $nombreFichero;

            if (move_uploaded_file($_FILES['jabonfoto']['tmp_name'], $nombreCompleto)) {
                header("Location: añadirproductos.php");
            } else {
                $errores .= "Error al subir la foto. ";
            }
        } else {
            $errores .= "No se ha seleccionado ninguna imagen. ";
        }
    }
}
?>
<form action="adminañadircampotabla.php" method="post" enctype="multipart/form-data">
    <!--quitar los campos que no necesites -->
    <label>nombre:</label>
    <input type="text" name="nombre" value='<?php echo $nombre ?>' required><br>
    <br>
    <label>descripcion:</label>
    <input type="text" name="descripcion" value='<?php echo $descripcion ?>' required><br>
    <br>    
    <label>precio:</label>
    <input type="number" name="precio" min="1" value='<?php echo $precio ?>'>
    <br>
    <br>
    <label>peso:</label>
    <input type="number" name="peso" min="1" value='<?php echo $peso ?>'>
    <br>
    <br>
    <label for="imagen">Imagen (opcional):</label>
    <input type="file" name="jabonfoto">
    <br>
    <input type="submit" name="añadirfila" value="añadirfila">
    <?php
    echo $errores;  
    ?>
</form>
