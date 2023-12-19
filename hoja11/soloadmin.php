<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['nombre_usuario'])) {
    header('Location: login.php');
    exit(); 
}
if (!isset($_SESSION['admin'])) {
    header('Location: consulta_noticias.php');
    exit(); 
}
?>