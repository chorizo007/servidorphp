<?php
function crearselect($conn, $nombre,$where)
{
    $query = "SELECT DISTINCT $nombre FROM mesa $where";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    echo "<select name='$nombre'>";
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option>" . $result[$nombre] . "</option>";
    }
    echo "</select>";
}
function selecthoras() {
    if ($file = fopen('horas.txt', 'r+')) {
        echo "<select name='horas'>";
        while (!feof($file)) {
            $linea = fgets($file);
            echo "<option>".$linea."</option>";
        }
        echo "</select>";
        fclose($file);
        return false;
    } else {
        die("No se pudo acceder al fichero de la base de datos");
    }
}

$servername = "127.0.0.1";
$username = "mimesa";
$password = "mimesa";
$dbname = "MIMESA";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

function generarmesas($conn, $restaurante, $fechareserva ,$hora, $funcion)
{
    $mostrar = "";
    $array_con = array(); 
    $query = "SELECT * FROM mesa WHERE restaurante = :restaurante order by nfila , ncolumna";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':restaurante', $restaurante, PDO::PARAM_STR);
    $stmt->execute();
    $num_rows = $stmt->rowCount();
    if ($num_rows <= 0) {
        $mostrar .= "este restaurante no tiene mesas";
    } else {
        $fila = 0;
        $mostrar .= '<form action="contratar.php" method="post">';
        $mostrar .= "<table>";
        $mostrar .= "<tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $numMesa = $row['numMesa'];
            $capacidad = $row['capacidad'];
            $id = $numMesa;
            $query = "SELECT * FROM reservas WHERE restaurante = :restaurante and numMesa = :numMesa";
            $stmt1 = $conn->prepare($query);
            $stmt1->bindParam(':restaurante', $restaurante, PDO::PARAM_STR);
            $stmt1->bindParam(':numMesa', $numMesa, PDO::PARAM_STR);
            $stmt1->execute();
            $num_rows1 = $stmt1->rowCount();
            if ($num_rows1 <= 0) {
                $contador ++; 
                $celda = "<td>libre P:" . $capacidad . " <button type='submid' name='id' value='".$id."'>contratar</button>" . "</td>";
                array_push($array_con,$id);
            } else {
                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                $fechahistorial = $row1['fecha'];
                $horass = $row1['hora'];
                $hoy = new DateTime($fechareserva . $hora);
                $hoy->sub(new DateInterval('PT1H'));
                
                $hoy3 = new DateTime($fechareserva . $hora);
                $hoy3->add(new DateInterval('PT1H'));

                $hoy2 = new DateTime($fechareserva . $hora);
                $hoy2->add(new DateInterval('P16M'));

                $fechadatetime = new DateTime($fechahistorial . $horass);
                if ($fechadatetime > $hoy && $fechadatetime < $hoy3) {
                    $celda = "<td>ocupado P:"  . $capacidad . " <button type='submid' name='esperar' value='".$id."'>esperar</button>" . "</td>";
                } else if ($hoy2 < $fechadatetime) {
                    $celda = "<td>libre en 15m P:" . $capacidad . " <button type='submid' name='esperar' value='".$id."'>esperar</button>" . "</td>";
                } else {
                    $celda = "<td>libre P:" . $capacidad . " <button type='submid' name='id' value='".$id."'>contratar</button>" . "</td>";
                    array_push($array_con,$id);
                }
            }
            $numfila = $row['nfila'];
            if ($numfila > $fila) {
                $mostrar .= "</tr>";
                $fila = $numfila;
                $mostrar .= "<tr>";
                $mostrar .= $celda;
            } else {
                $mostrar .= $celda;
            }
        }
        $mostrar .= "</table>";
        $mostrar .= "</form>";
        if($funcion == 'mostrar'){
            return $mostrar; 
        }else{
            return $array_con;
        }
        
    }
}



?>