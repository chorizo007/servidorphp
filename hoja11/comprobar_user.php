<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['nombre_usuario'])) {
    // Redirige a login.php
    header('Location: login.php');
    exit(); 
}
?>
