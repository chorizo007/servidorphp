<?php
session_start();
session_destroy();
//tambien puedo elimiar las cookies si quiero
header("Location: login.php");
exit();
?>
