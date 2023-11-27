<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    // Mostrar el nombre de usuario y un enlace para cerrar sesión
    $usuario = $_SESSION['usuario'];
    echo "Bienvenido de nuevo, $usuario! <br>";
    echo '<a href="cerrar_sesion.php">Cerrar Sesión</a>';
} else {
    // Si el usuario no ha iniciado sesión, mostrar el formulario de inicio de sesión
    if (isset($_POST['submit'])) {
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];

        // Verificar las credenciales (en este ejemplo, simplemente comparamos con valores fijos)
        if ($usuario == 'nico' && $password == '123') {
            // Inicio de sesión exitoso
            $_SESSION['usuario'] = $usuario;

            // Almacenar el nombre de usuario en una cookie con una duración de 1 hora
            setcookie('usuario', $usuario, time() + 3600);

            echo "Inicio de sesión exitoso, bienvenido $usuario! <br>";
            echo '<a href="cerrar_sesion.php">Cerrar Sesión</a>';
        } else {
            echo "Credenciales incorrectas. Intenta de nuevo.";
        }
    } else {
        // Mostrar el formulario de inicio de sesión
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
