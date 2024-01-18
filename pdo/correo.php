<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>

<?php
	require('/var/www/html/servidorphp/PHPMailer-master/src/PHPMailer.php');
    require('/var/www/html/servidorphp/PHPMailer-master/src/SMTP.php');


  //instanciamos un objeto de la clase phpmailer al que llamamos 
  //por ejemplo mail
  $mail = new PHPMailer();

  $mail -> isSMTP();
  //Definimos las propiedades y llamamos a los m�todos 
  //correspondientes del objeto mail

  //Con la propiedad Mailer le indicamos que vamos a usar un 
  //servidor smtp
  $mail->Mailer = "SMTP";
  $mail->SMTPAutoTLS = true;
  $mail->isHTML(true);
  $mail->Port = 25;
  $mail->CharSet = 'UTF-8';
  

  //Asignamos a Host el nombre de nuestro servidor smtp
  $mail->Host = "localhost";

  //Le indicamos que el servidor smtp requiere autenticaci�n
  $mail->SMTPAuth = true;

  //Le decimos cual es nuestro nombre de usuario y password
  $mail->Username = "nico@nicolas.com"; 
  $mail->Password = "nico";

  //Indicamos cual es nuestra direcci�n de correo y el nombre que 
  //queremos que vea el usuario que lee nuestro correo
  $mail->From = "nico@nicolas.com";
  $mail->FromName = "nico";

  //el valor por defecto 10 de Timeout es un poco escaso dado que voy a usar 
  //una cuenta gratuita, por tanto lo pongo a 30  
  $mail->Timeout=30;

  //Indicamos cual es la direcci�n de destino del correo
  $mail->AddAddress("anival@nicolas.com");

  //Asignamos asunto y cuerpo del mensaje
  //El cuerpo del mensaje lo ponemos en formato html, haciendo 
  //que se vea en negrita
  $mail->Subject = "Prueba de phpmailer";
  $mail->Body = "<b>Mensaje de prueba mandado con phpmailer en formato html</b>";

  //Definimos AltBody por si el destinatario del correo no admite email con formato html 
  $mail->AltBody = "Mensaje de prueba mandado con phpmailer en formato solo texto";

  //se envia el mensaje, si no ha habido problemas 
  //la variable $exito tendra el valor true
  $exito = $mail->Send();

  //Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas como mucho 
  //para intentar enviar el mensaje, cada intento se hara 5 segundos despues 
  //del anterior, para ello se usa la funcion sleep	
  $intentos=1; 
  while ((!$exito) && ($intentos < 5)) {
	sleep(5);
     	//echo $mail->ErrorInfo;
     	$exito = $mail->Send();
     	$intentos=$intentos+1;	
	
   }
 
		
   if(!$exito)
   {
	echo "Problemas enviando correo electr�nico a ".$valor;
	echo "<br/>".$mail->ErrorInfo;	
   }
   else
   {
	echo "Mensaje enviado correctamente";
   } 
?>

