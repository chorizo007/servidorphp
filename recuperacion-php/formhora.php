<?php
require('nav.php');
require('constantes.php');
require('funciones.php');

$errores = "";
$fecha = "";
$hora_inicio = "";
$hora_final = "";
if (isset($_SESSION['conductor'])) {
    
} else {
    header("Location: nav.php");
}

$id = $_SESSION['idplaza'];

if (!empty($_POST['contratar'])) {
    $_SESSION['idplaza'] =  $_POST['contratar'];

} else if (!empty($_POST['reservar'])) {

    $fecha = $_POST['fecha'];
    $hoy = new DateTime('now');
    $fecha_now = $hoy->format('Y-m-d');
    $hora_inicio = $_POST['hora_inicio'];
    $hora_final = $_POST['hora_final'];
    $_SESSION['fecha'] = $fecha;
    $_SESSION['hora_inicio'] = $hora_inicio;
    $_SESSION['hora_final'] = $hora_final;
    
    if($hora_final<$hora_inicio || $fecha < $fecha_now){
        $errores .= "introduce fechas correctas";
    }else{
        if (empty($fecha) || empty($hora_inicio) || empty($hora_final)) {
            $errores .= "Rellene todo el formulario";
        } else {
            $comprobar = comprobarfijo($id, $conn);
            if($comprobar){
                $libre = estadolibre ($conn , $id , $fecha , $hora_inicio , $hora_final);
                if($libre){
                    $usuario_plaza= $_SESSION['conductor'];
                    
                    insertarreserva ($conn , $id , $fecha , $hora_inicio , $hora_final , $usuario_plaza , 0);
                    echo "reserva realizada con exito";
                }else{
                    echo "esta plaza ya esta reservada para estas horas";
                }
            }else{
                    header("Location: formpuja.php");
            }
        }
    }
    
}
?>
<form action="formhora.php" method="post">
    <?php echo "reserva para el apacarcamiendo id :" . $id ?>
    <br>
    <br>
    <label>fecha reserva:</label>
    <input type="date" name="fecha" value='<?php echo $fecha ?>' required><br>
    <br>
    <label>hora inicio:</label>
    <input type="text" name="hora_inicio" value='<?php echo $hora_inicio ?>' required><br>
    <br>    
    <label>hora final:</label>
    <input type="text" name="hora_final" value='<?php echo $hora_final ?>'>
    <br>
    <br>
    <input type="submit" name="reservar" value="reservar">
    <?php
    echo $errores;  
    ?>
</form>
