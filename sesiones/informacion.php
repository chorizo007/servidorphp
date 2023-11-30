<?php
session_start();
$cerrar = $_POST['cerrar'];
if($cerrar!=null){
    session_destroy();
    header("Location: acredetacion.php");
}
if($_SESSION["usuario"] ==null){
    session_destroy();
    header("Location: acredetacion.php");
}
else{
    echo "<button href='https://www.youtube.com/'>otra pagina</button>";
    echo "<button value='cerrar' value='cerrar'>cerrar sesion</button>";
}
?>