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

$hoy = new DateTime ('now');
$hoy2= new DateTime ('now');
$fecha_inicio = $hoy->format('Y-m-d');
$hoy->add(new DateInterval('P7D'));
$fecha_fin = $hoy->format('Y-m-d');
$hoy2->sub(new DateInterval('P3M'));
$fecha_fin_tri = $hoy2->format('Y-m-d');
try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT * FROM clientes";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $query = "SELECT * from premios inner join cupones on premios.premioid=cupones.premioid where premios.fechai_validez < current_date and premios.fechaf_validez > CURRENT_DATE and clienteid != :clienteid";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':clienteid', $row1['clienteid'], PDO::PARAM_STR);
        $stmt->execute();
        echo "hace un insert";
        while ($row2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $query = "INSERT INTO CUPONES VALUES(:clienteid, :premioid , :fecha_validez , : fecha_fin)";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':clienteid', $row1['clienteid'], PDO::PARAM_STR);
            $stmt->bindValue(':premioid', $row2['premioid'], PDO::PARAM_STR);
            $stmt->bindValue(':fecha_validez', $fecha_inicio, PDO::PARAM_STR);
            $stmt->bindValue(':fecha_fin', $fecha_fin, PDO::PARAM_STR);
            $stmt->execute();
        }
    }
    
    $query = "SELECT * FROM clientes";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $query = "SELECT compras.clienteid, sum(unidades), articulos.anombre as nombrearticulo FROM clientes inner join compras on clientes.clienteid=compras.clienteid inner join itemcompras on itemcompras.compraid=compras.compraid inner join articulos on articulos.articuloid=itemcompras.articuloid where clientes.clienteid = :clienteid and fecha_compra > :fechatrimestre group by compras.clienteid, itemcompras.articuloid order by sum(unidades) DESC LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':clienteid', $row1['clienteid'], PDO::PARAM_STR);
        $stmt->bindValue(':fechatrimestre', $fecha_fin_tri, PDO::PARAM_STR);
        $stmt->execute();
        while ($row2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row2['nombrearticulo'];
            $query = "SELECT * FROM premios where ddescrip like '%:nombrearticulo1%' ";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':nombrearticulo1', $row2['nombrearticulo'], PDO::PARAM_STR);
            $stmt->execute();
            $num_rows33 = 0;
            $num_rows33 = $stmt->rowCount();
            if($num_rows33 > 0){
                $query = "INSERT INTO CUPONES VALUES(:clienteid, :premioid , :fecha_validez , : fecha_fin)";
                $stmt = $conn->prepare($query);
                $stmt->bindValue(':clienteid', $row1['clienteid'], PDO::PARAM_STR);
                $stmt->bindValue(':premioid', $row2['premioid'], PDO::PARAM_STR);
                $stmt->bindValue(':fecha_validez', $fecha_inicio, PDO::PARAM_STR);
                $stmt->bindValue(':fecha_fin', $fecha_fin, PDO::PARAM_STR);
                $stmt->execute();
            }else{
                $query = "INSERT INTO premios VALUES(:ddescrip, :fecha_validez , : fecha_fin)";
                $stmt = $conn->prepare($query);
                $stmt->bindValue(':ddescrip', "25% de descuento en " . $row2['nombrearticulo'], PDO::PARAM_STR);
                $stmt->bindValue(':fecha_validez', $fecha_inicio, PDO::PARAM_STR);
                $stmt->bindValue(':fecha_fin', $fecha_fin, PDO::PARAM_STR);
                $stmt->execute();
                
                $query = "INSERT INTO CUPONES VALUES(:clienteid, :premioid , :fecha_validez , : fecha_fin)";
                $stmt = $conn->prepare($query);
                $stmt->bindValue(':clienteid', $row1['clienteid'], PDO::PARAM_STR);
                $stmt->bindValue(':premioid', $row2['premioid'], PDO::PARAM_STR);
                $stmt->bindValue(':fecha_validez', $fecha_inicio, PDO::PARAM_STR);
                $stmt->bindValue(':fecha_fin', $fecha_fin, PDO::PARAM_STR);
                $stmt->execute();
            }
        }
    }
}catch (PDOException $e){
    echo "Error: " . $e->getMessage();
}

?>