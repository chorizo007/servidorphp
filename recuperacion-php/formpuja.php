<?php
require('nav.php');
require('constantes.php');
require('funciones.php');

$errores = "";
$fecha = "";
$hora_inicio = "";
$precio = "";
if (isset($_SESSION['conductor'])) {
    $usuario_plaza = $_SESSION['conductor'];
    $id = $_SESSION['idplaza'];
} else {
    header("Location: nav.php");
}



$fecha = $_SESSION['fecha'];
$hora_inicio = $_SESSION['hora_inicio'];
$hora_final = $_SESSION['hora_final'];
$usuario_plaza = $_SESSION['conductor'];

$precio_min = preciominimopuja($conn, $id , $fecha, $hora_inicio, $hora_final);

if (!empty($_POST['pujar'])) {
    $precio = $_POST['precio'];
    if ($precio <= $precio_min) {
        echo "introduce un precio superior a al de la puja";
    } else {
        $id_puja = insertarreserva($conn, $id, $fecha, $hora_inicio, $hora_final, $usuario_plaza , $precio);
        insertarpuja($conn , $id_puja , $precio );
        echo "reserva realizada con exito";
    }

}
?>
<form action="formpuja.php" method="post">
    <?php echo "reserva para el apacarcamiendo id :" . $id ?>
    <br>
    <br>
    <!--quitar los campos que no necesites -->
    <label>introduce tu puja , tiene que ser mayor a :
        <?php echo $precio_min ?>
    </label>
    <input type="text" name="precio" value='<?php echo $precio ?>' required><br>
    <br>
    <br>
    <input type="submit" name="pujar" value="pujar">
    <?php
    echo $errores;
    ?>
</form>