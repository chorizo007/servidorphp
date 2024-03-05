<?php
function crearselect($conn, $nombre, $where)
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
function selecthoras()
{
    if ($file = fopen('horas.txt', 'r+')) {
        echo "<select name='horas'>";
        while (!feof($file)) {
            $linea = fgets($file);
            echo "<option>" . $linea . "</option>";
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
function selectrestaurantes($conn, $fechareserva, $hora)
{
    $query = "SELECT DISTINCT restaurante FROM mesa";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    echo "<select name='nombreres'>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nombre = generarmesas($conn, $row['restaurante'], $fechareserva, $hora, 'generar', 'user');
        echo "<option>" . $nombre . "</option>";
    }
    echo "</select>";
}

function generarmesas($conn, $restaurante, $fechareserva, $hora, $funcion, $usuario)
{
    $mostrar = "";
    $nombre_res = null;
    $query = "SELECT * FROM mesa WHERE restaurante = :restaurante ORDER BY nfila, ncolumna";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':restaurante', $restaurante, PDO::PARAM_STR);
    $stmt->execute();
    $num_rows = $stmt->rowCount();
    if ($num_rows <= 0) {
        $mostrar .= "Este restaurante no tiene mesas";
    } else {
        $nombre_res = $restaurante;
        $fila = 0;
        $mostrar .= "<table>";
        $mostrar .= "<tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $numMesa = $row['numMesa'];
            $capacidad = $row['capacidad'];
            $id = $numMesa;
            $hora1_datetime = new DateTime($hora);
            $hora1_datetime->sub(new DateInterval('PT1H'));

            $hora2_datetime = new DateTime($hora);
            $hora2_datetime->add(new DateInterval('PT1H'));

            $hora1 = $hora1_datetime->format('H:i');
            $hora2 = $hora2_datetime->format('H:i');

            $query = "SELECT * FROM reservas WHERE restaurante = :restaurante AND numMesa = :numMesa AND fecha = :fecha AND hora BETWEEN '$hora1' AND '$hora2'";
            $stmt1 = $conn->prepare($query);
            $stmt1->bindParam(':restaurante', $restaurante, PDO::PARAM_STR);
            $stmt1->bindParam(':numMesa', $numMesa, PDO::PARAM_STR);
            $stmt1->bindParam(':fecha', $fechareserva, PDO::PARAM_STR);
            $stmt1->execute();
            $num_rows1 = $stmt1->rowCount();
            if ($num_rows1 <= 0) {
                if ($usuario == 'admin') {
                    $celda = "<td>LIBRE</td>";
                } else {
                    $celda = "<td>Libre P:" . $capacidad . " <button type='submit' name='id' value='" . $id . "'>Contratar</button>" . "</td>";
                }
            } else {
                if ($usuario == 'admin') {
                    $celda = "<td>Ocupado P:" . $capacidad . " <button type='submit' name='admin' value='" . $id . "'>Administrar</button>" . "</td>";
                } else {
                    $celda = "<td>Ocupado P:"  . $capacidad . "</td>";
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
        if ($funcion == 'mostrar') {
            return $mostrar;
        } else {
            return $nombre_res;
        }
    }
}


function selectestdomesa($conn)
{
    $sql = "SHOW COLUMNS FROM reservas WHERE Field = 'estado'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $enum_values_str = $row["Type"];
        preg_match_all("/'([^']+)'/", $enum_values_str, $matches);
        $enum_values = $matches[1];

        echo "<select name='estado'>";
        foreach ($enum_values as $value) {
            echo "<option value='$value'>$value</option>";
        }
        echo "</select>";
    } else {
        echo "No se encontró el campo enum 'estado' en la tabla.";
    }
}
