<?php

//crearselect ($conexion , $nombre_tabla , $wheredelaconsulta)
//selectfichero () 
//selectenum($conexion) 

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

function preciominimopuja($conn, $id, $fecha, $hora_inicio, $hora_final)
{
    $query = "SELECT * FROM reservas WHERE plazaID = :id and fecha = :fecha and ((hora_inicio <= :hora_inicio AND hora_cancelacion >= :hora_inicio) 
    OR (hora_inicio <= :hora_final AND hora_cancelacion >= :hora_final)) order by precio_puja desc limit 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $stmt->bindParam(':hora_inicio', $hora_inicio, PDO::PARAM_STR);
    $stmt->bindValue(':hora_final', $hora_final, PDO::PARAM_STR);
    $stmt->execute();
    $num_rows = $stmt->rowCount();
    if ($num_rows <= 0) {
        $query1= "SELECT precio_min FROM plazaparking WHERE plazaID = :plazaID";
        $stmt1 = $conn->prepare($query1);
        $stmt1->bindParam(':plazaID', $id, PDO::PARAM_STR);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        return ($row1) ? $row1['precio_min'] : null;
    } else {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['precio_puja'];
    }
}


function comprobarfijo($id, $conn)
{
    $query = "SELECT * FROM plazaparking WHERE plazaID = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $tipo = $row['tipo_alquiler'];
    if ($tipo == 'Fijo') {
        return true;
    } else {
        return false;
    }

}

function insertarpuja($conn , $id_puja , $precio){
    $query = "INSERT INTO pujas (reservaID , precio) 
              VALUES (:reservaid, :precio)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':reservaid', $id_puja, PDO::PARAM_STR);
    $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);
    $stmt->execute();
}

function estadolibre($conn, $id, $fecha, $hora_inicio, $hora_final)
{
    $query = "SELECT * 
          FROM reservas 
          WHERE plazaID = :id 
          AND fecha = :fecha 
          AND ((hora_inicio <= :hora_inicio AND hora_cancelacion >= :hora_inicio) 
               OR (hora_inicio <= :hora_final AND hora_cancelacion >= :hora_final))";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $stmt->bindParam(':hora_inicio', $hora_inicio, PDO::PARAM_STR);
    $stmt->bindParam(':hora_final', $hora_final, PDO::PARAM_STR);
    $stmt->execute();
    $num_rows = $stmt->rowCount();
    if ($num_rows > 0) {
        return false; // Hay alguna reserva que se superpone
    } else {
        return true; // No hay ninguna reserva que se superpone
    }
}


function insertarreserva($conn, $id, $fecha, $hora_inicio, $hora_final, $user, $precio)
{
    if ($precio > 0) {
        $query = "INSERT INTO reservas (dni_usuario, plazaID, fecha, hora_inicio, hora_cancelacion, precio_puja) 
                  VALUES (:user, :id, :fecha, :hora_inicio, :hora_final, :precio)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);
    } else {
        $query = "INSERT INTO reservas (dni_usuario, plazaID, fecha, hora_inicio, hora_cancelacion, precio_puja) 
                  VALUES (:user, :id, :fecha, :hora_inicio, :hora_final, 
                  (SELECT precio_min FROM plazaparking WHERE plazaID = :plazaid))";
        $stmt = $conn->prepare($query);
    }
    $stmt->bindParam(':user', $user, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $stmt->bindParam(':hora_inicio', $hora_inicio, PDO::PARAM_STR);
    $stmt->bindParam(':hora_final', $hora_final, PDO::PARAM_STR);
    if ($precio <= 0) {
        $stmt->bindParam(':plazaid', $id, PDO::PARAM_STR);
    }
    $stmt->execute();

    $id_ultimo = $conn->lastInsertId();

    return $id_ultimo;
}


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
function selectfichero()
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
                    $celda = "<td>Ocupado P:" . $capacidad . "</td>";
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


function selectenum($conn)
{
    //cambia el nombre de la tabla y el campo
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


function enviarcorreo($conn, $usuarios, $body, $cabecera)
{
    require('/var/www/html/servidorphp/PHPMailer-master/src/PHPMailer.php');
    require('/var/www/html/servidorphp/PHPMailer-master/src/SMTP.php');

    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->Mailer = "SMTP";
    $mail->SMTPAutoTLS = true;
    $mail->isHTML(true);
    $mail->Port = 25;
    $mail->Host = "localhost";
    $mail->SMTPAuth = true;
    $mail->Username = "jefe@nicolas.com";
    $mail->Password = "jefe";
    $mail->From = "jefe@nicolas.com";
    $mail->FromName = "jefe";
    $mail->Timeout = 30;

    foreach ($usuarios as $user) {
        $mail->ClearAddresses();
        $mail->AddAddress($user);
        $mail->Subject = $cabecera;
        $mail->Body = $body;

        $mail->clearAttachments();
        //quitar si no tenemos foto
        $mail->addEmbeddedImage($foto, 'imagenID', 'nombre_imagen.jpg');
        $mail->Body .= '<br><img src="cid:imagenID" alt="Imagen Embebida" style="max-width: 400px;">';
        $exito = $mail->Send();

        if (!$exito) {
            echo "Problemas enviando correo electrónico a $user";
            echo "<br/>" . $mail->ErrorInfo;
        } else {
            echo "Mensaje enviado correctamente a $user";
            echo "<br>";
        }
    }
}


function generarpdf()
{

    require('/var/www/html/github/servidorphp/fpdf/fpdf.php');

    class PDF extends FPDF
    {
        protected $B = 0;
        protected $I = 0;
        protected $U = 0;
        protected $HREF = '';

        function WriteHTML($html)
        {
            // Intérprete de HTML
            $html = str_replace("\n", ' ', $html);
            $a = preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
            foreach ($a as $i => $e) {
                if ($i % 2 == 0) {
                    // Text
                    if ($this->HREF)
                        $this->PutLink($this->HREF, $e);
                    else
                        $this->Write(5, $e);
                } else {
                    // Etiqueta
                    if ($e[0] == '/')
                        $this->CloseTag(strtoupper(substr($e, 1)));
                    else {
                        // Extraer atributos
                        $a2 = explode(' ', $e);
                        $tag = strtoupper(array_shift($a2));
                        $attr = array();
                        foreach ($a2 as $v) {
                            if (preg_match('/([^=]*)=["\']?([^"\']*)/', $v, $a3))
                                $attr[strtoupper($a3[1])] = $a3[2];
                        }
                        $this->OpenTag($tag, $attr);
                    }
                }
            }
        }

        function OpenTag($tag, $attr)
        {
            // Etiqueta de apertura
            if ($tag == 'B' || $tag == 'I' || $tag == 'U')
                $this->SetStyle($tag, true);
            if ($tag == 'A')
                $this->HREF = $attr['HREF'];
            if ($tag == 'BR')
                $this->Ln(5);
        }

        function CloseTag($tag)
        {
            // Etiqueta de cierre
            if ($tag == 'B' || $tag == 'I' || $tag == 'U')
                $this->SetStyle($tag, false);
            if ($tag == 'A')
                $this->HREF = '';
        }

        function SetStyle($tag, $enable)
        {
            // Modificar estilo y escoger la fuente correspondiente
            $this->$tag += ($enable ? 1 : -1);
            $style = '';
            foreach (array('B', 'I', 'U') as $s) {
                if ($this->$s > 0)
                    $style .= $s;
            }
            $this->SetFont('', $style);
        }

        function PutLink($URL, $txt)
        {
            // Escribir un hiper-enlace
            $this->SetTextColor(0, 0, 255);
            $this->SetStyle('U', true);
            $this->Write(5, $txt, $URL);
            $this->SetStyle('U', false);
            $this->SetTextColor(0);
        }
    }


    $pdf = new PDF();

    // Agregar una página al documento
    $pdf->AddPage();

    // Establecer la fuente y el tamaño del texto
    $pdf->SetFont('Arial', 'B', 16);

    // Agregar un título
    $pdf->Cell(0, 10, 'Ejemplo de Documento PDF', 0, 1, 'C');

    // Agregar un párrafo de texto
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Este es un ejemplo de cómo crear un documento PDF utilizando FPDF en PHP.', 0, 1);

    // Agregar una imagen
    $pdf->Image('logo.png', 10, 50, 100);

    // Establecer los márgenes
    $pdf->SetMargins(20, 20, 20);

    // Establecer el color del texto
    $pdf->SetTextColor(255, 0, 0);

    // Agregar más texto
    $pdf->Ln(10); // Salto de línea
    $pdf->Write(5, 'Este es otro párrafo de texto en rojo.');

    //crear una tabla
    $pdf->Cell(30, 10, "texto", 1, 0, 'C', true);
    $pdf->Cell(30, 10, "texto", 1, 0, 'C', true);
    $pdf->Cell(30, 10, "texto", 1, 0, 'C', true);
    $pdf->Cell(30, 10, "texto", 1, 0, 'C', true);


    // Guardar el documento PDF
    //ruta
    $archivo_pdf = '/var/www/html/github/servidorphp/jabones/temporal/' . uniqid('pdf_') . '.pdf';
    //guardar
    $pdf->Output('F', $archivo_pdf);

    echo 'Documento PDF generado exitosamente.';
}


?>