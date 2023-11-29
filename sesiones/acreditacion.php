<?php
    //1 .iniciamos la sesion
session_start();

//2 . acceso o guardado de datos en sesiones : 
    // Almacenar datos en la sesión
    $_SESSION['usuario'] = 'nombre_usuario';
    $_SESSION['rol'] = 'admin';

    // Acceder a los datos de la sesión
    echo $_SESSION['usuario'];
    echo $_SESSION['rol'];

// 3. nombre de la sesion
echo session_name(); //pphpsessid
echo session_id();  //1234asdfjkasldkjfa1034 


// elimiar la sesion
unset($_SESSION['usuario']); //eliminar las variables
unset($_SESSION['rol']);
$_SESSION=array();
session_destroy(); //eliminar el id que esta relacionado
?>