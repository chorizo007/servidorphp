<?php
$mensaje = '';
$nombre = $_POST['nombre'];
$destino = $_POST['destino'];
$duracion = $_POST['duracion'];
$dias = $_POST['dias'];
    if(!empty($_POST['nombre']) || !empty($_POST['destino']) || !empty($_POST['duracion']) ||!empty($_POST['dias'])){
        if(empty($_POST['nombre'])){
            $mensaje.='introduce el nombre <br>';
        }
        if(empty($_POST['destino'])){
            $mensaje.='introduce el destino <br>';
        }
        if(empty($_POST['duracion'])){
            $mensaje.='introduce el duracion <br>';
        }
        if(empty($_POST['dias'])){
            $mensaje.='introduce el numero de dias <br>';
        }
        if(strlen($mensaje)===0){
            if (!$archivoescribir = fopen('viajes.txt', 'a')) {
                die("FATAL ERROR ");
            }
    
            $añadir = $nombre.':'.$destino.':'.$duracion.':'.$dias." \r\n";
            fwrite($archivoescribir,$añadir);
    
            fclose($archivoescribir);
        }
    }
    $tablades = "<table><tr class='primera'><td>nombre</td><td>destino</td><td>duracion</td><td>salida</td></tr>";
    $tablades .="";
    if (!$archivoviajes = fopen('viajes.txt', 'r')) {
        die("FATAL ERROR");
    }
    while(!feof($archivoviajes)){
        $tablades .= "<tr>";
        $linea = explode(":",fgets($archivoviajes));
        foreach($linea as $valor){
            $tablades .= "<td> ".$valor." </td>";
        }
        $tablades .= "</tr>";
    }
    $tablades .= "</table>";
    fclose($archivoviajes);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table{
            background-color: red;
        }
        td {
            padding: 10px;
        }
        .primera{
            background-color:violet;
        }
    </style>

</head>
<body>
    <?php
    echo $tablades;
    ?>
    <br>
    <br>
    <br>
    <br>
    <h1>FORMULARIO DE VIAJES :)</h1>
    <form action='travelmas.php' method='post' id='formulario'>
        <label>introduzca el nombre del viajero :</label>
        <INPUT TYPE='text' NAME='nombre' value='<?php echo $nombre?>'> 
        <br>
        <label>introduzca el destino :</label>
        <INPUT TYPE='text' NAME='destino'value='<?php echo $destino?>'>
        <br>
        <label>introduzca la duracion :</label>
        <INPUT TYPE='text' NAME='duracion'value='<?php echo $duracion?>'>
        <br>
        <label>introduzca los dias de salida :</label>
        <INPUT TYPE='text' NAME='dias' value='<?php echo $dias?>'>
        <button type="submid">enviar</button>
    </form>
    <?php
     echo $mensaje;
    ?>
</body>
</html>