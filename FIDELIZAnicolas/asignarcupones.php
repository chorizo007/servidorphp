<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (isset($_SESSION['admin'])) {

} else {
    header("Location: principal.php");
}

$servername = "127.0.0.1";
$username = "fideliza";
$password = "fideliza";
$dbname = "FIDELIZA";

$hoy = new DateTime('now');
$hoy2 = new DateTime('now');
$fecha_inicio = $hoy->format('Y-m-d');
$hoy->add(new DateInterval('P7D'));
$fecha_fin = $hoy->format('Y-m-d');
$hoy2->sub(new DateInterval('P3M'));
$fecha_fin_tri = $hoy2->format('Y-m-d');
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT * FROM clientes";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $query = "SELECT * from premios inner join cupones on premios.premioid=cupones.premioid where premios.fechai_validez < CURRENT_DATE and premios.fechaf_validez > CURRENT_DATE and cupones.clienteid != :clienteid";
        $stmt1 = $conn->prepare($query);
        $stmt1->bindValue(':clienteid', $row1['clienteid'], PDO::PARAM_STR);
        $stmt1->execute();
        while ($row2 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $query = "INSERT INTO cupones VALUES(:clienteid, :premioid , :fecha_validez , :fecha_fin)";
            $stmt2 = $conn->prepare($query);
            $stmt2->bindValue(':clienteid', $row1['clienteid'], PDO::PARAM_STR);
            $stmt2->bindValue(':premioid', $row2['premioid'], PDO::PARAM_STR);
            $stmt2->bindValue(':fecha_validez', $fecha_inicio, PDO::PARAM_STR);
            $stmt2->bindValue(':fecha_fin', $fecha_fin, PDO::PARAM_STR);
            $stmt2->execute();
        }
    }
    
    $query = "SELECT * FROM clientes";
    $stmt = $conn->prepare($query);
    $stmt11->execute();
    
    while ($row1 = $stmt11->fetch(PDO::FETCH_ASSOC)) {
        $query = "SELECT compras.clienteid, sum(unidades), articulos.anombre as nombrearticulo, articulos.amarca as nombremarca FROM clientes inner join compras on clientes.clienteid=compras.clienteid inner join itemcompras on itemcompras.compraid=compras.compraid inner join articulos on articulos.articuloid=itemcompras.articuloid where clientes.clienteid = :clienteid and fecha_compra > :fechatrimestre group by itemcompras.articuloid order by sum(unidades) DESC LIMIT 1";
        $stmt22 = $conn->prepare($query);
        $stmt22->bindValue(':clienteid', $row1['clienteid'], PDO::PARAM_STR);
        $stmt22->bindValue(':fechatrimestre', $fecha_fin_tri, PDO::PARAM_STR);
        $stmt22->execute();
        while ($row2 = $stmt22->fetch(PDO::FETCH_ASSOC)) {
            echo $row2['nombrearticulo'];
            $query = "SELECT * FROM premios WHERE ddescrip LIKE :nombrearticulo1";
            $stmt33 = $conn->prepare($query);
            $nombrearticulo1 = '%' . $row2['nombrearticulo'] . '%';
            $stmt33->bindParam(':nombrearticulo1', $nombrearticulo1, PDO::PARAM_STR);
            $stmt33->execute();
            $num_rows33 = 0;
            $num_rows33 = $stmt33->rowCount();
            if ($num_rows33 > 0) {
                $fila_premio = $stmt33->fetch(PDO::FETCH_ASSOC);
                $query = "INSERT INTO cupones VALUES(:clienteid, :premioid , :fecha_validez , :fecha_fin)";
                $stmt44 = $conn->prepare($query);
                $stmt44->bindValue(':clienteid', $row1['clienteid'], PDO::PARAM_STR);
                $stmt44->bindValue(':premioid', $fila_premio['premioid'], PDO::PARAM_STR);
                $stmt44->bindValue(':fecha_validez', $fecha_inicio, PDO::PARAM_STR);
                $stmt44->bindValue(':fecha_fin', $fecha_fin, PDO::PARAM_STR);
                $stmt44->execute();
            } else {
                $query = "INSERT INTO premios(ddescrip, fechai_validez, fechaf_validez) VALUES(:ddescrip, :fecha_validez , :fecha_fin)";
                $stmt44 = $conn->prepare($query);
                $stmt44->bindValue(':ddescrip', "25% de descuento en " . $row2['nombrearticulo'] .  "de la marca "  . $row2['nombremarca'], PDO::PARAM_STR);
                $stmt44->bindValue(':fecha_validez', $fecha_inicio, PDO::PARAM_STR);
                $stmt44->bindValue(':fecha_fin', $fecha_fin, PDO::PARAM_STR);
                $stmt44->execute();
    
                // Obtener el ID del último insert en la tabla premios
                $idpremio = $conn->lastInsertId();
    
                $query = "INSERT INTO cupones VALUES(:clienteid, :premioid , :fecha_validez , :fecha_fin)";
                $stmt45 = $conn->prepare($query);
                $stmt45->bindValue(':clienteid', $row1['clienteid'], PDO::PARAM_STR);
                $stmt45->bindValue(':premioid', $idpremio, PDO::PARAM_INT); // Suponiendo que el ID es un entero
                $stmt45->bindValue(':fecha_validez', $fecha_inicio, PDO::PARAM_STR);
                $stmt45->bindValue(':fecha_fin', $fecha_fin, PDO::PARAM_STR);
                $stmt45->execute();
    
            }
        }
    }
}catch(Exception){
    echo "error";
}



?>