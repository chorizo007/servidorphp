<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php
// function __autoload($clase) {
// include 'clases/' . ’class.’.$clase . '.php';
// }

spl_autoload_register(function ($clase) {
    include './' . 'class.' . $clase . '.php';
});


$caja = new caja();
$caja->introduce("texto");
echo $caja -> contenido;
?>