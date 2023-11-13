<?php
/*
nos permite desde el servidor cambiar el comportamiento de las paginas al ejecutarse en el cliente



*/
header( 'X-Powered-By: adivina-adivinanza' ); //oculatar la version del interprete
header('Content-Type: text/html; charset=utf-8');
//header ('Refresh: 5; url=http://www.google.es');


/* 
header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="documento.pdf"');
readfile('documento.pdf');
 */

 header("Content-type: image/jpeg");
 header("Content-Disposition: inline; filename=fondo.jpeg");
 readfile('fondo.jpeg');

?>
