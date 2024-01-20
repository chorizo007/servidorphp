<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>

<?php
	require('/var/www/html/github/servidorphp/PHPMailer-master/src/PHPMailer.php');
   require('/var/www/html/github/servidorphp/PHPMailer-master/src/SMTP.php');

  $mail = new PHPMailer();

  $mail -> isSMTP();

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

  $mail->Timeout=30;

  $mail->Subject = $_POST['cabecera'];
  $mail->Body = $_POST['body'];

  $mail->AltBody = "Mensaje de prueba mandado con phpmailer en formato solo texto";

   $array_correos = $_POST['mail[]'];
   foreach($array_correos as $correo){
      $mail->AddAddress("anival@nicolas.com");
      $exito = $mail->Send();
      if(!$exito)
      {
      echo "Problemas enviando correo electr�nico a ".$valor;
      echo "<br/>".$mail->ErrorInfo;	
      }
      else
      {
      echo "Mensaje enviado correctamente";
      } 
   }
?>

