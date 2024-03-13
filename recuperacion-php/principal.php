<?php
require('nav.php');
require('constantes.php');
require('funciones.php');

//SOLO ADMIN
if (!isset($_SESSION['conductor'])) {
} else {
    header("Location: login.php");
}




?>