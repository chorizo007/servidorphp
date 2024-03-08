<?php
require('nav.php');
require('constantes.php');
require('funciones.php');

//SOLO ADMIN
if (!isset($_SESSION['admin'])) {
} else {
    header("Location: login.php");
}

//A POR TODAS


?>