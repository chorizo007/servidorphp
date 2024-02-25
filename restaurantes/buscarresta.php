<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php
function generarmesas($conn, $restaurante, $fechareserva ,$hora)
{
    $query = "SELECT * FROM mesa WHERE restaurante = :restaurante order by nfila , ncolumna";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':restaurante', $restaurante, PDO::PARAM_STR);
    $stmt->execute();
    $num_rows = $stmt->rowCount();
    if ($num_rows <= 0) {
        echo "este restaurante no tiene mesas";
    } else {
        $fila = 0;
        echo '<form action="contratar.php" method="post">';
        echo "<table>";
        echo "<tr>";
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
                $celda = "<td>libre P:" . $capacidad . " <button type='submid' name='id' value='".$id."'>contratar</button>" . "</td>";
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
                }
            }
            $numfila = $row['nfila'];
            if ($numfila > $fila) {
                echo "</tr>";
                $fila = $numfila;
                echo "<tr>";
                echo $celda;
            } else {
                echo $celda;
            }
        }
        echo "</table>";
        echo "</form>";
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $restaurante = $_POST['restaurante'];
    $capacidad = $_POST['capacidad'];
    $fechareserva = $_POST['fechareserva'];
    $hora = $_POST['horas'];
    $_SESSION['restaurante'] = $restaurante;
    $_SESSION['fechareserva'] = $fechareserva;
    $_SESSION['hora'] = $hora;
    $_SESSION['capacidad'] = $capacidad;


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
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }
</style>
</head>

<body>
    <h1>restaurante <?php echo $restaurante ?></h1>

    <?php
    generarmesas($conn, $restaurante, $fechareserva , $hora);
    ?>
</body>

</html>