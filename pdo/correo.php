<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php
$errores = "";
if (empty($_POST['mail'])) {
   $errores = "seleciona un email para poder mandarlo<br><br>";
   $url = "categoria.php?errorcorreo=" . $errores . "&categorias=" . $_POST['categorias'] . "&body=" . $_POST['body'] . "&cabecera=" . $_POST['cabecera'];
   header("Location: " . $url);
}
?>
<?php
//require('/var/www/html/github/servidorphp/PHPMailer-master/src/PHPMailer.php');
//require('/var/www/html/github/servidorphp/PHPMailer-master/src/SMTP.php');
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

$array_correos = $_POST['mail'];
$foto = $_POST['foto'];
$fotO = 'localhost/servidorphp/pdo/' . $foto;
$categorias = $_POST['categorias'];


foreach ($array_correos as $correo) {

   $mail->ClearAddresses();
   $mail->AddAddress($correo);


   $mail->Subject = $_POST['cabecera'];

   if ($categorias == "cumples") {
      $servername = "127.0.0.1";
      $username = "mail";
      $password = "mail";
      $dbname = "mail";

      try {
         $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $query = "SELECT * FROM clientes WHERE email = :correo";
         $stmt = $conn->prepare($query);
         $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
         $stmt->execute();

         while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $mail->Body = "Hola, " . $result['nombre_cliente'] . " ." . $_POST['body'];
            $fecha = $result['fecha_nacimiento'];
            $fechaActual = new DateTime();
            $fechaAlmacenada = new DateTime($fecha);
            $años_que_tiene = $fechaActual->diff($fechaAlmacenada)->y;
            $mail->Body .= "Felices " . $años_que_tiene;
         }
      } catch (PDOException $e) {
         echo "Error: " . $e->getMessage();
      }

      $conn = null;
   } else {
      $mail->Body = "Hola, $correo. " . $_POST['body'];
   }
   $mail->clearAttachments();
   if (!empty($foto)) {
      $mail->addEmbeddedImage($foto, 'imagenID', 'nombre_imagen.jpg');
      $mail->Body .= '<br><img src="cid:imagenID" alt="Imagen Embebida" style="max-width: 400px;">';
   }

   $exito = $mail->Send();

   if (!$exito) {
      echo "Problemas enviando correo electrónico a $correo";
      echo "<br/>" . $mail->ErrorInfo;
   } else {
      echo "Mensaje enviado correctamente a $correo";
      echo "<br>";
   }
}
?>


