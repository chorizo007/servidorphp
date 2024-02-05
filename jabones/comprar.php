<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();  // Asegúrate de iniciar la sesión


if ($_SESSION['cestacantidad'] <= 0) {
    header("Location: jabonescarlatty.php");
}


if (!empty($_SESSION['email'])) {
    $correo = $_SESSION['email'];
}


require('constantes.php');
require('./cabecera.php');

$servername = "127.0.0.1";
$username = "jabon";
$password = "jabon";
$dbname = "jabonescarlatty";


$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Obtener el ID de la cesta
$query = "SELECT * FROM cesta WHERE email = :correo";
$stmt = $conn->prepare($query);
$stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$idcesta = $result['cestaid'];

// Obtener el último ID de pedido
$query = "SELECT pedidoid FROM pedidos ORDER BY pedidoid DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$codigo_pedido = $result ? $result['pedidoid'] + 1 : 1;

// Calcular el precio total
$query = "SELECT SUM(precio) as total FROM productos
              INNER JOIN itemcesta ON productos.productoid = itemcesta.productoid
              WHERE cestaid = :cestaid";
$stmt = $conn->prepare($query);
$stmt->bindParam(':cestaid', $idcesta, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$precio_total = $result['total'];

// Insertar en la tabla de pedidos
$query = "INSERT INTO pedidos VALUES (:codigopedido, :email, CURRENT_DATE, DATE_ADD(CURRENT_DATE, INTERVAL 30 DAY), :total, false)";
$stmt = $conn->prepare($query);
$stmt->bindParam(':email', $correo, PDO::PARAM_STR);
$stmt->bindParam(':codigopedido', $codigo_pedido, PDO::PARAM_STR);
$stmt->bindParam(':total', $precio_total, PDO::PARAM_STR);
$stmt->execute();

$query = "INSERT INTO itempedido 
          VALUES (
              (SELECT itemcestaid FROM itemcesta WHERE cestaid = :idcesta ORDER BY itemcestaid DESC LIMIT 1), 
              :codigopedido, 
              (SELECT productoid FROM itemcesta WHERE cestaid = :idcesta ORDER BY itemcestaid DESC LIMIT 1), 
              (SELECT cantidad FROM itemcesta WHERE cestaid = :idcesta ORDER BY itemcestaid DESC LIMIT 1)
          )";

$stmt = $conn->prepare($query);
$stmt->bindParam(':idcesta', $idcesta, PDO::PARAM_STR);
$stmt->bindParam(':codigopedido', $codigo_pedido, PDO::PARAM_STR);
$stmt->execute();


$numero_productos = $_SESSION['cestacantidad'];
if ($numero_productos == 2) {
    $query = "INSERT INTO itempedido 
          VALUES (
              (SELECT itemcestaid FROM itemcesta WHERE cestaid = :idcesta ORDER BY itemcestaid ASC LIMIT 1), 
              :codigopedido, 
              (SELECT productoid FROM itemcesta WHERE cestaid = :idcesta ORDER BY itemcestaid ASC LIMIT 1), 
              (SELECT cantidad FROM itemcesta WHERE cestaid = :idcesta ORDER BY itemcestaid ASC LIMIT 1)
          )";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':idcesta', $idcesta, PDO::PARAM_STR);
    $stmt->bindParam(':codigopedido', $codigo_pedido, PDO::PARAM_STR);
    $stmt->execute();
}
require('/var/www/html/github/servidorphp/PHPMailer-master/src/PHPMailer.php');
require('/var/www/html/github/servidorphp/PHPMailer-master/src/SMTP.php');
//require('/var/www/html/servidorphp/PHPMailer-master/src/PHPMailer.php');
//require('/var/www/html/servidorphp/PHPMailer-master/src/SMTP.php');

$mail = new PHPMailer();

$mail->isSMTP();
$mail->Mailer = "SMTP";
$mail->SMTPAutoTLS = true;
$mail->isHTML(true);
$mail->Port = 25;
$mail->Host = "localhost";
$mail->SMTPAuth = true;
$mail->Username = "anival@nicolas.com";
$mail->Password = "anival";
$mail->From = "anival@nicolas.com";
$mail->FromName = "anival";
$mail->Timeout = 30;
$mail->ClearAddresses();
$mail->AddAddress($correo);

$mail->Subject = 'Gracias por confiar con nosotros';

$mail->Body .= "Productos comprados : ";
$query = "SELECT * FROM pedidos 
          INNER JOIN itempedido ON pedidos.pedidoid = itempedido.pedidoid 
          INNER JOIN productos ON productos.productoid = itempedido.productoid 
          WHERE pedidos.pedidoid = :pedidoid";
$stmt = $conn->prepare($query);
$stmt->bindParam(':pedidoid', $codigo_pedido, PDO::PARAM_STR);
$stmt->execute();
while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $mail->Body .= "nombre producto :" . $result['nombre'] . "<br>";
    $mail->Body .= "precio del producto :" . $result['precio'] . "<br>";
    $mail->Body .= "precio del producto :" . $result['unidades'] . "<br>";
    $mail->Body .= "fecha de entrega estimada :" . $result['fechaentrega'] . "<br>";
    $mail->addEmbeddedImage("imagenes/" . $result['productoid'] . ".jpg", 'imagenID', 'productos.jpg');
    $mail->Body .= '<br><img src="cid:imagenID" alt="Imagen Embebida" style="max-width: 400px;">' . "<br>";
}

$exito = $mail->Send();

if (!$exito) {
    echo "Problemas enviando correo electrónico a $correo";
    echo "<br/>" . $mail->ErrorInfo;
} else {
    echo "Mensaje enviado correctamente a $correo";
    echo "<br>";
}
$mail->clearAttachments();
$mail->ClearAddresses();
$mail->AddAddress('jabon@nicolas.com');
$mail->Body = "";
$mail->Subject = 'nueva compra';





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

$pdf->AddPage();

$pdf->SetFont('Arial', '', 12); 
$pdf->SetMargins(20, 20);
$pdf->SetFillColor(244, 244, 244); 

$pdf->SetFont('Arial', 'B', 16);  
$pdf->SetTextColor(51, 51, 51);  
$pdf->SetFillColor(224, 224, 224);  
$pdf->Cell(0, 10, 'albaran de pedido', 0, 1, 'C', true); 

// Establecer el estilo de h3
$pdf->SetFont('Arial', 'B', 14);  // Negrita $precio_total
$pdf->SetTextColor(85, 85, 85);   // Color de texto
$pdf->SetDrawColor(204, 204, 204);  // Color de borde
$pdf->Cell(0, 7, 'datos del pedido', 'B', 1, 'L');

$pdf->SetFont('Arial', '', 12); 
$pdf->SetFillColor(255, 255, 255);
$pdf->SetDrawColor(221, 221, 221);
$pdf->SetTextColor(51, 51, 51);
$pdf->Cell(40, 10, 'pedido id', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'email cliente', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'total pedido', 1, 1, 'C', true);

$pdf->Cell(40, 10, $codigo_pedido, 1, 0, 'C', true);
$pdf->Cell(40, 10, $correo, 1, 0, 'C', true);
$pdf->Cell(40, 10, $precio_total, 1, 1, 'C', true);


// Establecer el estilo de h3
$pdf->SetFont('Arial', 'B', 14);  // Negrita $precio_total
$pdf->SetTextColor(85, 85, 85);   // Color de texto
$pdf->SetDrawColor(204, 204, 204);  // Color de borde
$pdf->Cell(0, 7, 'productos', 'B', 1, 'L');

$pdf->SetFont('Arial', '', 12); 
$pdf->SetFillColor(255, 255, 255);
$pdf->SetDrawColor(221, 221, 221);
$pdf->SetTextColor(51, 51, 51);


$query = "SELECT * FROM pedidos 
          INNER JOIN itempedido ON pedidos.pedidoid = itempedido.pedidoid 
          INNER JOIN productos ON productos.productoid = itempedido.productoid 
          WHERE pedidos.pedidoid = :pedidoid";
$stmt = $conn->prepare($query);
$stmt->bindParam(':pedidoid', $codigo_pedido, PDO::PARAM_STR);
$stmt->execute();
$mail->Body .= "Productos comprados : " . "<br>";
$mail->Body .= "correo del comprador :" . $correo . "<br>";

$pdf->Cell(30, 10, 'nombre del producto', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'precio', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'unidades ', 1, 1, 'C', true);
$pdf->Cell(30, 10, 'fecha de la compra', 1, 1, 'C', true);


while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(30, 10, $result['nombre'], 1, 0, 'C', true);
    $pdf->Cell(30, 10, $result['precio'], 1, 0, 'C', true);
    $pdf->Cell(30, 10, $result['unidades'], 1, 0, 'C', true);
    $pdf->Cell(30, 10, $result['fechapedido'], 1, 0, 'C', true);

    $mail->Body .= "nombre producto :" . $result['nombre'] . "<br>";
    $mail->Body .= "precio del producto :" . $result['precio'] . "<br>";
    $mail->Body .= "unidades:" . $result['unidades'] . "<br>";
    $mail->Body .= "fecha de entrega estimada :" . $result['fechaentrega'] . "<br>";
    $mail->addEmbeddedImage("imagenes/" . $result['productoid'] . ".jpg", 'imagenID', 'productos.jpg');
    $mail->Body .= '<br><img src="cid:imagenID" alt="Imagen Embebida" style="max-width: 400px;">' . "<br>";
}



$archivo_pdf = '/var/www/html/github/servidorphp/jabones/temporal/' . uniqid('pdf_') . '.pdf';

$pdf->Output('F', $archivo_pdf);

$mail->addAttachment($archivo_pdf);

$exito = $mail->Send();


if (!$exito) {
    echo "Problemas enviando correo electrónico al provedor";
    echo "<br/>" . $mail->ErrorInfo;
} else {
    echo "correo enviando al email del provedor";
    echo "<br>";
}


// Eliminar de la tabla itemcesta
$query = "DELETE FROM itemcesta WHERE cestaid = :cestaid";
$stmt = $conn->prepare($query);
$stmt->bindParam(':cestaid', $idcesta, PDO::PARAM_STR);
$stmt->execute();

$query = "DELETE FROM cesta WHERE cestaid = :cestaid";
$stmt = $conn->prepare($query);
$stmt->bindParam(':cestaid', $idcesta, PDO::PARAM_STR);
$stmt->execute();


// Cerrar la conexión
echo "realizado con exito";
calcularjabones($correo);
$conn = null;



echo '<button><a href="pedidos.php">ver mis pedidos</a></button></td>';
