<?php
//configuracion del php.ini para tener un buen uso de sesiones: 
/*

session.save_handler = files
session.save_path = /tmp  ; Puedes ajustar esta ruta según tus preferencias
session.use_only_cookies = 1
session.use_trans_sid = 0  ; Cambiado a 0 para deshabilitar la propagación de sesiones a través de URL
*/

//sesiones: sirven para guardar la informacion de usuario en el servidor
//cookies: para guardar informacion dentro del cliente (tienes que pedir al cliente que de el consentimiento para guardar las cookies)

//PASOS PARA TENER UNA CONEXION:
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




if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    echo "Bienvenido de nuevo, $usuario! <br>";
    echo '<a href="cerrar_sesion.php">Cerrar Sesión</a>';
} else {
    if (isset($_POST['submit'])) {
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];

        if ($usuario == 'nico' && $password == '123') {
            $_SESSION['usuario'] = $usuario;

            setcookie('usuario', $usuario, time() + 3600);

            echo "Inicio de sesión exitoso, bienvenido $usuario! <br>";
            echo '<a href="cerrar_sesion.php">Cerrar Sesión</a>';
        } else {
            echo "Credenciales incorrectas. Intenta de nuevo.";
        }
    } else {
        echo '
            <form method="post" action="">
                Usuario: <input type="text" name="usuario" required><br>
                Contraseña: <input type="password" name="password" required><br>
                <input type="submit" name="submit" value="Iniciar Sesión">
            </form>
        ';
    }
}



?>
